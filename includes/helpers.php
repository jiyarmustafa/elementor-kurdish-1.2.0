<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * توابع کمکی ئێلێمنتۆری کوردی
 */

/**
 * بررسی فعال بودن ماژول
 */
function elementor_kurdish_is_module_active( $module ) {
    $core = Elementor_Kurdish_Core::instance();
    return $core->get_option( $module, false );
}

/**
 * گرفتن آدرس فایل asset
 */
function elementor_kurdish_asset_url( $file ) {
    return ELEMENTOR_KURDISH_ASSETS_URL . $file;
}

/**
 * لاگ خطا برای دیباگ
 */
function elementor_kurdish_log( $message ) {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        error_log( 'Elementor Kurdish: ' . $message );
    }
}

/**
 * بررسی وجود المنتور پرو
 */
function elementor_kurdish_has_pro() {
    return defined( 'ELEMENTOR_PRO_VERSION' );
}

/**
 * نمایش اعلان خطا
 */
function elementor_kurdish_admin_notice( $message, $type = 'error' ) {
    add_action( 'admin_notices', function() use ( $message, $type ) {
        printf(
            '<div class="notice notice-%s is-dismissible"><p>%s</p></div>',
            esc_attr( $type ),
            esc_html( $message )
        );
    } );
}

/**
 * تبدیل اعداد انگلیسی به کردی
 */
function elementor_kurdish_convert_numbers( $number ) {
    $persian_digits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    $english_digits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    
    return str_replace( $english_digits, $persian_digits, $number );
}