<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'wpuser' );

/** Database password */
define( 'DB_PASSWORD', '123' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '#y!<{;z9|T1OGF$NMHuE0G^PCUZ#2*Y_=oeD5Yj[|Xl-g3Vk@G6~zM3FEg:I>J[:' );
define( 'SECURE_AUTH_KEY',  '!cy2$/m{wrOX5n&pAvbc,#M3K Z%=pQ>nJ7eU3-d;cV_fu!PDS{C$F{EA2raMgdD' );
define( 'LOGGED_IN_KEY',    'k1Dwwu7OG?oVl0OR-*B8w1ZjF-cuHkuc?a9&eC{mwi3x!ukjOL5F?ND+]dT#Dz8{' );
define( 'NONCE_KEY',        's0T^:d{|pw%:*:0|Lu/_z;]qvw[lBn}J89#R10$0nQ{%90,F-NrdcIH*gP~Bx]zk' );
define( 'AUTH_SALT',        ')dF#$Kh~k(2egaMooHD^w^Dh8I>Gv#/z>_hN*DMCjvZ# Mn-^5enQ;jcas+`;)s5' );
define( 'SECURE_AUTH_SALT', '(igDmk+cni}_vN``Al}Puk1{I]Fwer+V|eLqbV0lHedQyF [u:iEkNQ/]2K(@Vt4' );
define( 'LOGGED_IN_SALT',   'sCMVqkCOi:fKyC?m&?Rwvg^d{a37]q-`%7i9d;Z*v26!)Kr?cl;R*~#hj 2WC=Ep' );
define( 'NONCE_SALT',       'y=$6I}Y~cT|$cc[r4=vrv_1nQQ2!o6nsN?QOs/*qdYmS^Ddn0kxA}y]G>K^+4I*L' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
