<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Elementor_Kurdish_About {
    
    private static $instance = null;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'admin_menu', [ $this, 'add_about_page' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_about_styles' ] );
    }

    public function add_about_page() {
        add_submenu_page(
            'elementor-kurdish',
            'سەبارەت بە ئێمە',
            'سەبارەت بە ئێمە',
            'manage_options',
            'elementor-kurdish-about',
            [ $this, 'render_about_page' ]
        );
    }

    public function enqueue_about_styles( $hook ) {
        if ( 'toplevel_page_elementor-kurdish-about' !== $hook ) {
            return;
        }

        wp_enqueue_style(
            'elementor-kurdish-about',
            ELEMENTOR_KURDISH_ASSETS_URL . 'css/about-page.css',
            [],
            ELEMENTOR_KURDISH_VERSION
        );
    }

    public function render_about_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        ?>
        <div class="wrap elementor-kurdish-about">
            <!-- هدر صفحه -->
            <div class="elementor-kurdish-about-header">
                <div class="elementor-kurdish-about-hero">
                    <div class="elementor-kurdish-about-logo">
                        <?php if ( file_exists( ELEMENTOR_KURDISH_PLUGIN_DIR . 'assets/images/logo.png' ) ): ?>
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
                        <?php if ( file_exists( ELEMENTOR_KURDISH_PLUGIN_DIR . 'assets/images/developer.jpg' ) ): ?>
                            <img src="<?php echo esc_url( ELEMENTOR_KURDISH_IMAGES_URL . 'developer.jpg' ); ?>" alt="ژیار مصطفی">
                        <?php else: ?>
                            <div class="avatar-fallback">JM</div>
                        <?php endif; ?>
                    </div>
                    <div class="developer-info">
                        <h3>ژیار مصطفی</h3>
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
                        <div class="stat-number">۲.۰.۰</div>
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

            <!-- حمایت -->
            <div class="elementor-kurdish-about-support">
                <div class="support-card">
                    <h3>پشتیوانی و گەشەپێدان</h3>
                    <p>ئەم ئەفزونە بەخۆڕایی دروست کراوە بۆ کۆمەڵگەی کوردی. ئەگەر پێتان خۆشە، دەتوانیت لە ڕێگای ئەم هەلەوانە پشتیوانیمان بکەیت:</p>
                    <div class="support-actions">
                        <a href="https://jiyarwp.ir/donate" target="_blank" class="support-button primary">💰 پشتیوانی دارایی</a>
                        <a href="https://github.com/jiyarmustafa/elementor-kurdish" target="_blank" class="support-button secondary">⭐ دانەبەزی لە GitHub</a>
                        <a href="https://wordpress.org/plugins/elementor-kurdish/reviews/" target="_blank" class="support-button secondary">📝 ڕەخنە و پێشنیار</a>
                    </div>
                </div>
            </div>

            <!-- تغییرات -->
            <div class="elementor-kurdish-about-changelog">
                <h3>گۆڕانکارییەکان</h3>
                <div class="changelog">
                    <div class="changelog-version">
                        <h4>ڤێرژەنی ١.١.۰</h4>
                        <ul>
                            <li>✅ سیستم تقویم کردی جامع</li>
                            <li>✅ فونت‌های کردی اضافه شد</li>
                            <li>✅ صفحه درباره ما اضافه شد</li>
                            <li>✅ بهینه‌سازی عملکرد</li>
                        </ul>
                    </div>
                    <div class="changelog-version">
                        <h4>ڤێرژەنی ۱.١.۰</h4>
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