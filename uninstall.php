<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// حذف options
delete_option( 'elementor_kurdish' );
delete_option( 'elementor_kurdish_version' );

// حذف transient ها
delete_transient( 'elementor_kurdish_fonts_cache' );

// پاکسازی داده‌های دیگر در صورت وجود
// global $wpdb;
// $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'elementor_kurdish_%'" );