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
define('DB_NAME', 'wp497');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '12345-');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'P|~{}h1TWwpjtd[O+1~v27VG?J[I4S`6Dkp5mG1)_WZtlxN.}~?&+qN,)1a@%/|q');
define('SECURE_AUTH_KEY',  'D^|e;X(*,s4Be<r=piu2k6P|)er+Ixe:3;Fv!u-{%Z1*Qm!XG(IK:9J^+yO{Jh~u');
define('LOGGED_IN_KEY',    'L,I+r!!JQj(Cj+I6JVz{r~?{_k$?`{Iqa)Y`4r<,Oj:aa6XsanB1v~MH{DN6AT6u');
define('NONCE_KEY',        ':4<qVs5F$` J6RFccwc[IF7?Yo,%U2u./R,dTFpDy~/!NhomZ_`mZdH &.S6|vj=');
define('AUTH_SALT',        '`6q-KkgbC%1kquKXoFZg).w:+So1X`=!{ Kq_mtY/yw~4~y07ScaB,uo!> qWAdX');
define('SECURE_AUTH_SALT', '{OGdIvAQ8t8}[!36;lmG_QwR#>jYLHXuxJUa60vqa2UQw|X[$MLWSykWJgs~ijE.');
define('LOGGED_IN_SALT',   '>FcvFh2d9bI[U/~5^0~l$]k{[m6Xgnq9y[adqcST>r6hKj7`3GNyS4A?F8-tXbiM');
define('NONCE_SALT',       'A& k3rqd:2`9:u1lG@]`kI/&emzsuU(r}c_oaFeB9MW+(G|&3#S6sxvsCmP+D9A}');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
