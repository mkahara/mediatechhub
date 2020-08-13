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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mediatechhub' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '`3l*nM$z8C$78FdMdui3s4~b`q*q$89IL*VmyS{r{~C!us7c_F+-[p4c&]E$OrLy' );
define( 'SECURE_AUTH_KEY',  'i__pBj?XC#k)b@2?-jHq&Z-5iowy?=dVZ6l8d=9iGuk~G(xcI0slJ*uvG/|f65Fm' );
define( 'LOGGED_IN_KEY',    'fG~`NJ+@%0<.zT5}</uz9eUENs] zih*W*%5D+1$HWTEAR>wDbOKvIrO/+_$O]]-' );
define( 'NONCE_KEY',        'qjNN/c9!pJtqz1e5buNd9+DNQWm0Qi H*_?qJEARSvd8[i-kA?7f70c`T<{yHB43' );
define( 'AUTH_SALT',        'u4cnBOSnJPpXR:]x7V^7zAIC0g3V:n5**f}h)K#slG9E <?Wfs:_BeiH4hOq^4Oe' );
define( 'SECURE_AUTH_SALT', '9.QwEoM!UZ!jCe}.xBNB^iTiP*INrF^9d;(AzBX&B%$Q<S5#bM}o6XW_5OefbK2:' );
define( 'LOGGED_IN_SALT',   'b(GZUqXBm(mXh&YKSKI):?_vdcCy8Hu~,K[2|C/qek-F=K^],nw0HkezIT#+z(Fc' );
define( 'NONCE_SALT',       'I]?vxw&[P_jUI#a7w.ObDqZ<!Y/!,Vrs*)SSfC#xH/XG5Bk$VXl`F/}r#yNvy+V_' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
set_time_limit(300);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
