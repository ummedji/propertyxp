<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */

define( 'AUTOMATIC_UPDATER_DISABLED', true );

if($_SERVER["HTTP_HOST"] == "www.propertyxp.com"){

define('DB_NAME', 'open_propertyxp');

/** MySQL database username */
define('DB_USER', 'sqlyog');

/** MySQL database password */
define('DB_PASSWORD', 'sqlyog');

/** MySQL hostname */
define('DB_HOST', '192.168.1.245');
}
else{
    
    define('DB_NAME', 'ab95976_pxp');
    define('DB_USER', 'ab95976_pxp');
    define('DB_PASSWORD', 'as*yX=7wwv9$');
    define('DB_HOST', 'ftp.webcluesglobal.com');
}
//define('DB_NAME', 'property_proxp_new');

/** MySQL database username */
//define('DB_USER', 'sqlyog');

/** MySQL database password */
//define('DB_PASSWORD', 'sqlyog');

/** MySQL hostname */
//define('DB_HOST', '192.168.1.245');


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
define('AUTH_KEY',         '|DTTT{S1CkvSP2CWfm1sO4.;lV2yG9ny@c)U:lISUHf8 -+!xLL(Tm/pb>>y}]jK');
define('SECURE_AUTH_KEY',  'SNv+0Lv@iN-k;Y5imOR`+*K|+~#_pYSN_r<F;xD>{qTDM9!]Wfr,v8,5f[HU+7lY');
define('LOGGED_IN_KEY',    'CUKg8}VRPeso)XX$<hEDN9/<D|b9P/D^wRox+H#|@Tlk>_]140|Jc[xS|pC=J+PW');
define('NONCE_KEY',        'V`[a@(9^<u+*hxden>qt?9TH`=d.d^[[*6X#Aa#`.IepNwOHqwuQCA|mg=@+BXE#');
define('AUTH_SALT',        'ur|tC=%I9W,17%S3esG#-$&CtexN0,u&)U*C&7q/;k|vY!Zn}|S~*VJ|zSiz>R[9');
define('SECURE_AUTH_SALT', '6B<mxU9Y.E EdpW!kb$fr7O*bX=U<?[ o0|j6mxi8|-x*HrYyVE6Y96F90XYx0YK');
define('LOGGED_IN_SALT',   '8ma9hu$>W`m,7T!XN#l+LA=;41F+N]VdBS5+<?F)#=_:>m2m`>*d*y~J!GV>9f-J');
define('NONCE_SALT',       '<OY5=TdKN,{s^cBrS][25nk9^Jyb-c@H}o#3|O@OI.fZ+|rY6mw]K;zQ.^dx}f]8');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');