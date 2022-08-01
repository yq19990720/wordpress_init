<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
    define( 'DB_NAME', 'wp_init' );

/** Database username */
    define( 'DB_USER', 'wp_init' );

/** Database password */
    define( 'DB_PASSWORD', 'wp_init' );

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
define( 'AUTH_KEY',         'DODvwcJ6MnuB%h 8N.co] Gb}a-(ie2k(MW9nz!g&j_1(r t><^4AVVS!3t/Al_]' );
define( 'SECURE_AUTH_KEY',  '!&Pu 1pHTJ?3?R^.XjvUfP8b4j(V3M-OA_+Hi>^Mc/2Xu(S#SiV>&p0On9[P-V9y' );
define( 'LOGGED_IN_KEY',    'VK5::pqN7ftM}}sZ:6&thT 8@`:q[g,H)~&C!kju0@leb%}dnfX=]_Zp>_Y+HI <' );
define( 'NONCE_KEY',        '?}DWe|u_`:@a1osq.^Q^gx-w[C:y5/nl@.mDl$X hRV2cx#c7mOVzV?PrIPFXTPm' );
define( 'AUTH_SALT',        '39$kjpZV5U_O;Q[(/ Z7q^E_r|FNsW61nQ6PfLUJ}}0V>vS =/Vq;7axQbovCws+' );
define( 'SECURE_AUTH_SALT', 'IG`e}rH@:9V4CbNMFJ{j=h`SsA6(f^J~8~kzjkrvm57;wsAe+@o 5lKMJX@@LhjY' );
define( 'LOGGED_IN_SALT',   '?,i</SWmb;iCp9%~/}@|(ozVO#MySUPvZM)80Y4sJhy&q2bM5a*7OIxC_muSmlf<' );
define( 'NONCE_SALT',       '! C4o.<D Fst&w $r>l]K:0S01~COdBS-mcTHVapFiTo`[f,yzWWkS+KM$`F2#Vu' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_init';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
