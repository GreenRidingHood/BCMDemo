<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
date_default_timezone_set ( 'America/Chicago' );

define('SITECOOKIEPATH', '/');
define('COOKIEPATH', '/');
define('ADMIN_COOKIE_PATH', '/');
define('WP_SITEURL', '//' . $_SERVER['SERVER_NAME'] . '/wordpress');
define('WP_HOME',    '//' . $_SERVER['HTTP_HOST'] . '');

define ('FS_METHOD', 'direct');

switch (WP_HOME) {
	case '//localhost.bigcitymountaineers.org':
		define('AUTOSAVE_INTERVAL', 300); 
		define('WP_POST_REVISIONS', false);
		break;
	case '//bigcitymountaineers.hiebingdev.com':
		define('WP_AUTO_UPDATE_CORE', true);
		define('DISALLOW_FILE_EDIT', true);
		break;
	default:
		define('DISALLOW_FILE_EDIT', true);
		break;
}

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'bcm_wordpress');

/** MySQL database username */
define('DB_USER', 'bcm_wordpress_usr');

/** MySQL database password */
define('DB_PASSWORD', 'alluminum-+X4r9Z-surfboard');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'I3pk_-?EZBkc574n9%8p4QLzr<JkRJiH8GIR3t<O$N(A2)Y+d*ZY},@9K]o(4; P');
define('SECURE_AUTH_KEY',  ':3`]RXZB54lp:+^1(Bz5!%{!Hp8p6E-=6isgK1,(f](X-:Pc+<FOe6!X(wj Kcn+');
define('LOGGED_IN_KEY',    'R6$R]ahr=2_->^ao-Sxkxu+=3Q;<y;v_%.nO_[Y8;?fj;AkR7JlB`&c?c_2YHVZy');
define('NONCE_KEY',        'C|BIctz^4s|s2OOkC*Vsv6V2@Jb-T0q=8#+Z/Eq$?DZH491{PK*#(J{i<5Fa$W,2');
define('AUTH_SALT',        ';oP2O%aHQfXp&bM|Qp;-HHR`rv?6Lc$HCUG-H2|+-iz|!o@jzj-z;tV1BGZVH,-O');
define('SECURE_AUTH_SALT', 'e-/M1/7^jG<]GR>/}65i0xCC0JDo&4R6AarT<90.VSTw5>%6n|,w.gAaqYqeDZZ6');
define('LOGGED_IN_SALT',   '(L;_K@>*,HubQy3^W3XE$,gL#??LQV{{-ReZCudPDClYP)L>M,v;&#su8+9{Mqvg');
define('NONCE_SALT',       ' RzE]ut67Ti!LYjJ+]I{h#y31*NelLlbZ$pCQV*|~*FPosp@l*S_J>Rq@qw[o|y*');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'bcm_wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');