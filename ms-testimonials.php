<?php 
/**
* Plugin Name: Simple Testimonials
* Description: WordPress Simple Testimonials PostType, easy to use with help of shortcodes.
* Version: 1.0.0
* Author: Manpreet Singh
**/

if ( ! defined( 'ABSPATH' ) ) {
     die;
}
define( 'MS_TESTI_VERSION', '1.0.0' );
define( 'MS_TESTI_TEXT_DOMAIN', 'ms-testimonial' );
define( 'MS_TESTI_DIR__NAME', dirname( __FILE__ ) );
define( 'MS_TESTI_EDITING__URL', plugin_dir_url( __FILE__ ) );
define( 'MS_TESTI_EDITING__DIR', plugin_dir_path( __FILE__ ) );
define( 'MS_TESTI_PLUGIN', __FILE__ );
define( 'MS_TESTI_PLUGIN_BASENAME', plugin_basename( MS_TESTI_PLUGIN ) );

include_once( 'inc/main_class.php' );
include_once( 'inc/setting-class.php' );
include_once( 'inc/form-handle.php' );

$obj = new MS_TESTI_PLUGIN_SETTINGS();
$obj->MS_HOOKS();
$obj->MS_SETTING_HOOKS();