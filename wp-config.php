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
define('DB_NAME', 'wpweb101_site');

/** MySQL database username */
define('DB_USER', 'wpweb101');

/** MySQL database password */
define('DB_PASSWORD', 'wpweb101@2015');

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
define('AUTH_KEY',         'GK@n566V}u-1^G3fk&7FkD{z~ c`l(;Jf_]+,,}7%uw=?]:fw$MoV.=:WY}VTVm8');
define('SECURE_AUTH_KEY',  'X{8q)SXKe_)}yjO#.S`DyT<+8^#g+L+6ei=[mR2AFIr+&U[qy<+-rUxcP8x(B4kc');
define('LOGGED_IN_KEY',    'wY|oavM1ZE~{cjxK_:E$w]e.C-gg63&pB&pg.P+BAgk&/%!BCSLAR>1#_%Av@QT2');
define('NONCE_KEY',        'r2=I#B5BiNSD^qV9k1hAn]N:@(31+/nYFOx*w*vu6v>f7Kj;#sxS,-fQY-V5P+]_');
define('AUTH_SALT',        '};u5o$[{c>qk~}IAq:,{//GK;x8<!GJ~@/b;q);d95|&qfM+Lt#%<Q5xrS)m0Ia(');
define('SECURE_AUTH_SALT', '}yj^&Ao.6;:BegYX`t*|Uf+tQbx`Acfv(s8Pv*r}K4i_b(eE`eyEeAKaE>htXoTH');
define('LOGGED_IN_SALT',   '623BEX+(ch^$dwkk6y Jb2K(Q45Woc0@tF(r?|-DlIqF7V|MJnto.h)o-$WD]P^Q');
define('NONCE_SALT',       'IO!<3N^[!p|7)&PD#{NCn}f9g0Ia?-~[1O=_7l;|_Oi+,$J]$D#w.a>;qDPhWAKz');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpweb_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */
define( 'DISALLOW_FILE_EDIT', true );
define( 'FS_METHOD', 'direct' );
define('WP_POST_REVISIONS', 3);

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
