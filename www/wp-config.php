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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'xdb' );

/** MySQL database username */
define( 'DB_USER', 'xdb' );

/** MySQL database password */
define( 'DB_PASSWORD', '7!wsyHKzSjcV195Y' );

/** MySQL hostname */
define( 'DB_HOST', 'mysql' );

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
define( 'AUTH_KEY',         'c-&akLRzQygnT6HmlB$d#U-}U%1u`,EbTf#rEn=8%J2,OY}-br0BS!vU902Tu@V_' );
define( 'SECURE_AUTH_KEY',  'l:NSUPBB[lLC%rnO#-RK/K5RTVt&0YIcN*QJE}:GmeX86AdzdS i6ptX-S.AlAJt' );
define( 'LOGGED_IN_KEY',    '|]0JF.3#z32~]nYd2]$}2!O0x}0ZcV,g{-eaW&ZvE;57ou_iVA&>kjLiPpPs)b%p' );
define( 'NONCE_KEY',        '0z*a^$7pafrSP*-;Ekl+qkyO7#n` 2^1.lCd&!C`1g9;QjkNt`y :hNk,uhQ80r%' );
define( 'AUTH_SALT',        'Y]=il0N,pD}Eon(Ur|$JHYk>LvR7[,sF8ifVyu:.8,xrt]+I E6OJ22mITq)MlWs' );
define( 'SECURE_AUTH_SALT', 'a#D2{1p6o=9Z4EdBqqG4`]o),UY0MXJ5dt9Q2ME(c>>,~/T#V2c9XGqgpm^DPg;c' );
define( 'LOGGED_IN_SALT',   '8p}:jVbi$t=#I_67HYVB0Sjbl+CeQ&sX]OnW. sf][$!Te(WX2N|^!Jw*Vt=|Hk.' );
define( 'NONCE_SALT',       'Xd>Upe(K+w?M,4KlLm<yW:9x~RULBdra/zZadhk[R-Yp^39Gz6]Q3<K54:?^5}!R' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'localhost');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

/* Multisite */
//define('WP_ALLOW_MULTISITE', true);

define('FS_METHOD', 'direct');
