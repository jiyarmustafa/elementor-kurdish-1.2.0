<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Elementor_Kurdish_Settings {
    
    private static $instance = null;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'admin_init', [ $this, 'register_settings' ] );
        add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_styles' ] );
        add_action( 'admin_head', [ $this, 'add_menu_icon_styles' ] );
    }

    public function register_settings() {
        register_setting( 
            'elementor_kurdish_settings', 
            'elementor_kurdish', 
            [ 'sanitize_callback' => [ $this, 'sanitize_settings' ] ]
        );
    }

    public function add_admin_menu() {
        // منوی اصلی با آیکن dashicons
        add_menu_page(
            'ئێلێمنتۆری کوردی',
            'ئێلێمنتۆری کوردی',
            'manage_options',
            'elementor-kurdish',
            [ $this, 'render_settings_page' ],
            'dashicons-translation',
            58
        );

        // زیرمنوها
        add_submenu_page(
            'elementor-kurdish',
            'ڕێکخستنەکان',
            'ڕێکخستنەکان',
            'manage_options',
            'elementor-kurdish',
            [ $this, 'render_settings_page' ]
        );

        add_submenu_page(
            'elementor-kurdish',
            'دەربارەی ئێمە',
            'دەربارەی ئێمە',
            'manage_options',
            'elementor-kurdish-about',
            [ $this, 'render_about_page' ]
        );
    }

    public function add_menu_icon_styles() {
        ?>
        <style>
        /* استایل‌های اجباری برای آیکن منو */
        #adminmenu .toplevel_page_elementor-kurdish .wp-menu-image img {
            width: 35px !important;
            height: 35px !important;
            padding: 0px 0 !important;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }
        
        #adminmenu .toplevel_page_elementor-kurdish .wp-menu-image .dashicons-translation:before {
            font-size: 18px;
            line-height: 1.2;
        }
        
        #adminmenu .toplevel_page_elementor-kurdish:hover .wp-menu-image img {
            opacity: 1;
            transform: scale(1.05);
        }
        </style>
        <?php
    }

    public function enqueue_admin_styles( $hook ) {
        if ( strpos( $hook, 'elementor-kurdish' ) !== false ) {
            wp_enqueue_style(
                'elementor-kurdish-admin',
                ELEMENTOR_KURDISH_ASSETS_URL . 'css/admin-options.css',
                [],
                ELEMENTOR_KURDISH_VERSION
            );
        }
    }

    public function sanitize_settings( $input ) {
        $sanitized = [];
        $fields = [ 'kurdish_fonts', 'kurdish_rtl_styles', 'kurdish_translation', 'kurdish_calendar' ];
        
        foreach ( $fields as $field ) {
            $sanitized[ $field ] = isset( $input[ $field ] ) ? '1' : '0';
        }
        
        return $sanitized;
    }

    public function render_settings_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // ذخیره تنظیمات
        if ( isset( $_POST['elementor_kurdish'] ) && check_admin_referer( 'elementor_kurdish_save' ) ) {
            update_option( 'elementor_kurdish', $this->sanitize_settings( $_POST['elementor_kurdish'] ) );
            echo '<div class="notice notice-success is-dismissible"><p>ڕێکخستنەکان بەسەرکەوتووی هەڵگیرا!</p></div>';
        }

        $options = get_option( 'elementor_kurdish', [] );
        $logo_exists = file_exists( ELEMENTOR_KURDISH_PLUGIN_DIR . 'assets/images/logo.png' );
        ?>
        <div class="wrap elementor-kurdish-settings">
            <div class="elementor-kurdish-header">
                <div class="elementor-kurdish-header-main">
                    <div class="elementor-kurdish-logo">
                        <?php if ( $logo_exists ): ?>
                            <img src="<?php echo esc_url( ELEMENTOR_KURDISH_IMAGES_URL . 'logo.png' ); ?>" alt="ئێلێمنتۆری کوردی">
                        <?php else: ?>
                            <div class="elementor-kurdish-logo-fallback">
                                <span>کوردی</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="elementor-kurdish-header-title">
                        <h4>ڕێکخستنەکانی ئێلێمنتۆری کوردی</h4>
                        <p>بستەی تەواوی وەرگێڕانی ئێلێمنتۆر بۆ زاراوەی کوردی سورانی</p>
                    </div>
                </div>
            </div>

            <div class="elementor-kurdish-main">
                <div class="elementor-kurdish-content">
                    <form method="post" action="">
                        <?php wp_nonce_field( 'elementor_kurdish_save' ); ?>
                        
                        <div class="elementor-kurdish-card">
                            <div class="elementor-kurdish-card-header">
                                <h4>تایبەتمەندییەکان</h4>
                            </div>
                            <div class="elementor-kurdish-card-body">
                                <!-- ترجمه کردی -->
                                <div class="elementor-kurdish-settings-row">
                                    <div class="elementor-kurdish-settings-icon">
                                        <span class="dashicons dashicons-translation"></span>
                                    </div>
                                    <div class="elementor-kurdish-settings-content">
                                        <div class="elementor-kurdish-settings-title">وەرگێڕانی کوردی</div>
                                        <p class="elementor-kurdish-settings-description">چالاککردنی وەرگێڕانی کوردی بۆ ئێلێمنتۆر و ئێلێمنتۆر پرۆ</p>
                                    </div>
                                    <div class="elementor-kurdish-settings-control">
                                        <label class="elementor-kurdish-toggle">
                                            <input type="hidden" name="elementor_kurdish[kurdish_translation]" value="0">
                                            <input type="checkbox" name="elementor_kurdish[kurdish_translation]" value="1" <?php checked( $options['kurdish_translation'] ?? '1', '1' ); ?>>
                                            <span class="elementor-kurdish-slider"></span>
                                        </label>
                                    </div>
                                </div>

                                <!-- فونت‌های کردی -->
                                <div class="elementor-kurdish-settings-row">
                                    <div class="elementor-kurdish-settings-icon">
                                        <span class="dashicons dashicons-admin-appearance"></span>
                                    </div>
                                    <div class="elementor-kurdish-settings-content">
                                        <div class="elementor-kurdish-settings-title">فۆنتی کوردی</div>
                                        <p class="elementor-kurdish-settings-description">زیادکردنی فۆنتە کوردییەکان بۆ ئێلێمنتۆر</p>
                                    </div>
                                    <div class="elementor-kurdish-settings-control">
                                        <label class="elementor-kurdish-toggle">
                                            <input type="hidden" name="elementor_kurdish[kurdish_fonts]" value="0">
                                            <input type="checkbox" name="elementor_kurdish[kurdish_fonts]" value="1" <?php checked( $options['kurdish_fonts'] ?? '1', '1' ); ?>>
                                            <span class="elementor-kurdish-slider"></span>
                                        </label>
                                    </div>
                                </div>

                                <!-- پشتیبانی RTL -->
                                <div class="elementor-kurdish-settings-row">
                                    <div class="elementor-kurdish-settings-icon">
                                        <span class="dashicons dashicons-editor-textcolor"></span>
                                    </div>
                                    <div class="elementor-kurdish-settings-content">
                                        <div class="elementor-kurdish-settings-title">پشتیوانی RTL</div>
                                        <p class="elementor-kurdish-settings-description">چالاککردنی پشتیوانی ڕاست بۆ چەپ بۆ ڕووکاری ئێلێمنتۆر</p>
                                    </div>
                                    <div class="elementor-kurdish-settings-control">
                                        <label class="elementor-kurdish-toggle">
                                            <input type="hidden" name="elementor_kurdish[kurdish_rtl_styles]" value="0">
                                            <input type="checkbox" name="elementor_kurdish[kurdish_rtl_styles]" value="1" <?php checked( $options['kurdish_rtl_styles'] ?? '1', '1' ); ?>>
                                            <span class="elementor-kurdish-slider"></span>
                                        </label>
                                    </div>
                                </div>

                                <!-- تقویم کردی -->
                                <?php if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) : ?>
                                <div class="elementor-kurdish-settings-row">
                                    <div class="elementor-kurdish-settings-icon">
                                        <span class="dashicons dashicons-calendar-alt"></span>
                                    </div>
                                    <div class="elementor-kurdish-settings-content">
                                        <div class="elementor-kurdish-settings-title">تقویم کوردی</div>
                                        <p class="elementor-kurdish-settings-description">چالاککردنی ویجتی تقویم کوردی بۆ فۆرمەکانی ئێلێمنتۆر پرۆ</p>
                                    </div>
                                    <div class="elementor-kurdish-settings-control">
                                        <label class="elementor-kurdish-toggle">
                                            <input type="hidden" name="elementor_kurdish[kurdish_calendar]" value="0">
                                            <input type="checkbox" name="elementor_kurdish[kurdish_calendar]" value="1" <?php checked( $options['kurdish_calendar'] ?? '1', '1' ); ?>>
                                            <span class="elementor-kurdish-slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <button type="submit" class="elementor-kurdish-submit">هەڵگرتنی ڕێکخستنەکان</button>
                    </form>
                </div>

                <div class="elementor-kurdish-sidebar">
                    <div class="elementor-kurdish-premium-ad">
                        <div class="premium-ad-content">
                            <h5>پشتیوانی و گەشەپێدان</h5>
                            <p>ئەم ئەفزونە بەخۆڕایی دروست کراوە بۆ کۆمەڵگەی کوردی. سوپاس بۆ بەکارهێنان!</p>
                            <a href="https://jiyarwp.ir" target="_blank" class="premium-ad-button">وێبسایتی فەرمی</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function render_about_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $logo_exists = file_exists( ELEMENTOR_KURDISH_PLUGIN_DIR . 'assets/images/logo.png' );
        $developer_exists = file_exists( ELEMENTOR_KURDISH_PLUGIN_DIR . 'assets/images/developer.jpg' );
        ?>
        <div class="wrap elementor-kurdish-about">
            <!-- هدر صفحه -->
            <div class="elementor-kurdish-about-header">
                <div class="elementor-kurdish-about-hero">
                    <div class="elementor-kurdish-about-logo">
                        <?php if ( $logo_exists ): ?>
                            <img src="<?php echo esc_url( ELEMENTOR_KURDISH_IMAGES_URL . 'logo.png' ); ?>" alt="ئێلێمنتۆری کوردی">
                        <?php else: ?>
                            <div class="elementor-kurdish-logo-fallback">
                                <span>ئێلێمنتۆری کوردی</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="elementor-kurdish-about-title">
                        <h1>ئێلێمنتۆری کوردی</h1>
                        <p class="version">ڤێرژن <?php echo esc_html( ELEMENTOR_KURDISH_VERSION ); ?></p>
                        <p class="description">بستەی تەواوی وەرگێڕانی ئێلێمنتۆر بۆ زاراوەی کوردی سورانی</p>
                    </div>
                </div>
            </div>

            <!-- کارت‌های ویژگی‌ها -->
            <div class="elementor-kurdish-about-features">
                <h2>تایبەتمەندییە سەرەکییەکان</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">🎯</div>
                        <h3>وەرگێڕانی کوردی</h3>
                        <p>ترجمه کامل المنتور و المنتور پرو به کردی سورانی</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">🔤</div>
                        <h3>فۆنتی کوردی</h3>
                        <p>فونت‌های کردی (Kurdistan24, Unikurd, Rudaw, Shasenem)</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">📅</div>
                        <h3>تقویم کوردی</h3>
                        <p>تقویم کردی با ماه‌های اصیل کردی برای فرم‌ها</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">🔄</div>
                        <h3>پشتیبانی RTL</h3>
                        <p>پشتیبانی پیشرفته از راست به چپ برای رابط کاربری</p>
                    </div>
                </div>
            </div>

            <!-- اطلاعات توسعه‌دهنده -->
            <div class="elementor-kurdish-about-developer">
                <div class="developer-card">
                    <div class="developer-avatar">
                        <?php if ( $developer_exists ): ?>
                            <img src="<?php echo esc_url( ELEMENTOR_KURDISH_IMAGES_URL . 'developer.jpg' ); ?>" alt="جیار مصطفی">
                        <?php else: ?>
                            <div class="avatar-fallback">JM</div>
                        <?php endif; ?>
                    </div>
                    <div class="developer-info">
                        <h3>جیار مصطفی</h3>
                        <p class="developer-title">پەرەپێدەر و دیزاینەر</p>
                        <p class="developer-bio">پەرەپێدەری وێب و دیزاینەری ڕووکاری بەکارهێنەر بە تایبەتمەندییەکانی کوردی</p>
                        <div class="developer-links">
                            <a href="https://jiyarwp.ir" target="_blank" class="dev-link">🌐 وێبسایتی فەرمی</a>
                            <a href="https://github.com/jiyarmustafa" target="_blank" class="dev-link">💻 GitHub</a>
                            <a href="mailto:contact@jiyarwp.ir" class="dev-link">📧 پەیوەندی</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- آمار و اطلاعات -->
            <div class="elementor-kurdish-about-stats">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">١.٢.۰</div>
                        <div class="stat-label">ڤێرژنی ئێستا</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">۴+</div>
                        <div class="stat-label">فۆنتی کوردی</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">۱۰۰٪</div>
                        <div class="stat-label">وەرگێڕان</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">✅</div>
                        <div class="stat-label">ئامادەیە</div>
                    </div>
                </div>
            </div>

            <!-- تغییرات -->
            <div class="elementor-kurdish-about-changelog">
                <h3>گۆڕانکارییەکان</h3>
                <div class="changelog">
                    <div class="changelog-version">
                        <h4>ڤێرژن ١.٢.۰</h4>
                        <ul>
                            <li>✅ سیستم تقویم کردی جامع</li>
                            <li>✅ فونت‌های کردی اضافه شد</li>
                            <li>✅ صفحه درباره ما اضافه شد</li>
                            <li>✅ بهینه‌سازی عملکرد</li>
                        </ul>
                    </div>
                    <div class="changelog-version">
                        <h4>ڤێرژن ۱.٢.۰</h4>
                        <ul>
                            <li>🎉 انتشار نسخه اولیه</li>
                            <li>✅ ترجمه کردی سورانی</li>
                            <li>✅ پشتیبانی RTL</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}