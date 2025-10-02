<?php
/**
 * Plugin Name: ئێلێمنتۆری کوردی
 * Plugin URI: https://jiyarwp.ir/elementor-kurdish/
 * Description: بستەی تەواوی وەرگێڕانی ئێلێمنتۆر بۆ زاراوەی کوردی سورانی، لەگەڵ فۆنتی کوردی و تقویم کوردی.
 * Version: 1.2.0
 * Author: Jiyar Mustafa
 * Author URI: https://jiyarwp.ir
 * Text Domain: elementor-kurdish
 * License: GPLv2 or later
 * Elementor tested up to: 3.32
 * Elementor Pro tested up to: 3.32
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// تعریف ثابت‌ها
define( 'ELEMENTOR_KURDISH_VERSION', '1.2.0' );
define( 'ELEMENTOR_KURDISH_PLUGIN_FILE', __FILE__ );
define( 'ELEMENTOR_KURDISH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ELEMENTOR_KURDISH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'ELEMENTOR_KURDISH_ASSETS_URL', ELEMENTOR_KURDISH_PLUGIN_URL . 'assets/' );
define( 'ELEMENTOR_KURDISH_IMAGES_URL', ELEMENTOR_KURDISH_ASSETS_URL . 'images/' );

// بارگذاری کلاس اصلی
require_once ELEMENTOR_KURDISH_PLUGIN_DIR . 'includes/class-core.php';

// راه‌اندازی افزونه
Elementor_Kurdish_Core::instance();

// تابع کمکی برای دسترسی سریع
function elementor_kurdish() {
    return Elementor_Kurdish_Core::instance();
}