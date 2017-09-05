<?php

final class ITSEC_Version_Management {
	private static $instance;

	private $scan_for_outdated_software_hook = 'itsec_vm_outdated_wp_check';
	private $old_scan_for_outdated_software_hook = 'itsec_vm_outdated_check';
	private $scan_for_old_sites_hook = 'itsec_vm_scan_for_old_sites';

	private $settings;

	private function __construct() {
		$this->settings = ITSEC_Modules::get_settings( 'version-management' );

		add_action( $this->scan_for_outdated_software_hook, array( $this, 'check_for_outdated_software' ) );
		add_action( 'upgrader_process_complete', array( $this, 'check_for_outdated_software' ), 100 );
		add_action( $this->scan_for_old_sites_hook, array( $this, 'scan_for_old_sites' ) );

		if ( $this->settings['strengthen_when_outdated'] && $this->settings['is_software_outdated'] ) {
			if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
				define( 'DISALLOW_FILE_EDIT', true );
			}

			add_filter( 'bloginfo_url', array( $this, 'remove_pingback_url' ), 10, 2 );

			if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
				add_filter( 'authenticate', array( $this, 'block_multiauth_attempts' ), 0, 3 );
			}
		}

		if ( $this->settings['wordpress_automatic_updates'] ) {
			add_filter( 'auto_update_core', '__return_true', 20 );
			add_filter( 'allow_dev_auto_core_updates', '__return_true', 20 );
			add_filter( 'allow_minor_auto_core_updates', '__return_true', 20 );
			add_filter( 'allow_major_auto_core_updates', '__return_true', 20 );
		}

		if ( $this->settings['plugin_automatic_updates'] ) {
			add_filter( 'auto_update_plugin', '__return_true', 20 );
		}

		if ( $this->settings['theme_automatic_updates'] ) {
			add_filter( 'auto_update_theme', '__return_true', 20 );
		}
	}

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public static function activate() {
		$self = self::get_instance();

		// If the old hook remains, store the next scheduled time and clear the hook.
		if ( false !== ( $time = wp_next_scheduled( $self->old_scan_for_outdated_software_hook ) ) ) {
			wp_clear_scheduled_hook( $self->old_scan_for_outdated_software_hook );
		}

		if ( ! wp_next_scheduled( $self->scan_for_outdated_software_hook ) ) {
			// Use the time from the old hook, if it is valid, otherwise, use the current time.
			if ( ! isset( $time ) || false === $time ) {
				$time = time();
			}

			wp_schedule_event( $time, 'daily', $self->scan_for_outdated_software_hook );
		}

		if ( $self->settings['scan_for_old_wordpress_sites'] && ! wp_next_scheduled( $self->scan_for_old_sites_hook ) ) {
			wp_schedule_event( time() + ( 5 * MINUTE_IN_SECONDS ), 'daily', $self->scan_for_old_sites_hook );
		}

		$self->check_for_outdated_software();
	}

	public static function deactivate() {
		$self = self::get_instance();

		wp_clear_scheduled_hook( $self->old_scan_for_outdated_software_hook );
		wp_clear_scheduled_hook( $self->scan_for_outdated_software_hook );
		wp_clear_scheduled_hook( $self->scan_for_old_sites_hook );
	}

	public function remove_pingback_url( $output, $show ) {
		if ( $show === 'pingback_url' ) {
			return '';
		}

		return $output;
	}

	public function block_multiauth_attempts( $filter_val, $username, $password ) {
		if ( empty( $this->first_xmlrpc_credentials ) ) {
			$this->first_xmlrpc_credentials = array(
				$username,
				$password
			);

			return $filter_var;
		}

		if ( $username === $this->first_xmlrpc_credentials[0] && $password === $this->first_xmlrpc_credentials[1] ) {
			return $filter_var;
		}

		status_header( 405 );
		header( 'Content-Type: text/plain' );
		die( __( 'XML-RPC services are disabled on this site.' ) );
	}

	public function check_for_outdated_software() {
		if ( ! $this->settings['strengthen_when_outdated'] ) {
			wp_clear_scheduled_hook( $this->scan_for_outdated_software_hook );
			return;
		}

		require_once( dirname( __FILE__ ) . '/outdated-software-scanner.php' );

		ITSEC_VM_Outdated_Software_Scanner::run_scan();

		$this->update_outdated_software_flag();
	}

	public function update_outdated_software_flag() {
		require_once( dirname( __FILE__ ) . '/strengthen-site.php' );

		$is_software_outdated = ITSEC_Version_Management_Strengthen_Site::is_software_outdated();

		if ( $is_software_outdated !== $this->settings['is_software_outdated'] ) {
			$this->settings['is_software_outdated'] = $is_software_outdated;
			ITSEC_Modules::set_setting( 'version-management', 'is_software_outdated', $is_software_outdated );
		}
	}

	public function scan_for_old_sites() {
		if ( ! $this->settings['scan_for_old_wordpress_sites'] ) {
			wp_clear_scheduled_hook( 'itsec_vm_scan_for_old_sites' );
			return;
		}

		require_once( dirname( __FILE__ ) . '/old-site-scanner.php' );

		ITSEC_VM_Old_Site_Scanner::run_scan();
	}
}
ITSEC_Version_Management::get_instance();
