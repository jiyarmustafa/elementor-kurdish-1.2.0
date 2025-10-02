/**
 * پیکربندی مرکزی تقویم کردی برای ئێلێمنتۆری کوردی
 * Kurdish Calendar Configuration for Elementor Kurdish
 * 
 * @version 2.0.0
 * @author Jiyar Mustafa
 */

(function() {
    'use strict';

    // پیکربندی اصلی
    window.KurdishCalendarConfig = {
        // فعال/غیرفعال کردن تقویم کردی
        enabled: true,
        
        // تبدیل به تاریخ کردی (روز/ماه شمسی + سال میلادی + 700)
        convertToKurdish: true,
        
        // فرمت پیشفرض
        format: 'DD/MM/YYYY', // مثال: 10/07/2725
        
        // محدوده سال‌های کردی
        minYear: 2700, // حداقل سال کردی
        maxYear: 3700, // حداکثر سال کردی
        
        // تنظیمات نمایش
        display: {
            persianDigits: true,      // نمایش اعداد به صورت کردی (٠١٢٣...)
            showTodayButton: true,    // نمایش دکمه امروز
            showEmptyButton: true,    // نمایش دکمه خالی کردن
            showCloseButton: true,    // نمایش دکمه بستن
            autoClose: true,          // بستن خودکار پس از انتخاب
            position: 'auto'          // موقعیت نمایش پاپ‌آپ
        },
        
        // ماه‌های کردی
        months: [
            'نەورۆز',    // فروردین (1)
            'گوڵان',     // اردیبهشت (2)
            'جۆزەردان',  // خرداد (3)
            'پووشپەڕ',   // تیر (4)
            'گەلاوێژ',    // مرداد (5)
            'خەرمانان',   // شهریور (6)
            'ڕەزبەر',     // مهر (7)
            'خەزەن',      // آبان (8)
            'سەرماوە',    // آذر (9)
            'بەفرانبار',  // دی (10)
            'ڕێبەندان',   // بهمن (11)
            'ڕەشەمە'      // اسفند (12)
        ],
        
        // روزهای هفته (کوتاه)
        daysShort: ['ی', 'د', 'س', 'چ', 'پ', 'ه', 'ش'],
        
        // روزهای هفته (کامل)
        days: [
            'یەکشەممە',   // شنبه
            'دووشەممە',   // یکشنبه
            'سێشەممە',    // دوشنبه
            'چوارشەممە',  // سه شنبه
            'پێنجشەممە',  // چهارشنبه
            'هەینی',      // پنجشنبه
            'شەممە'       // جمعه
        ],
        
        // سلکتورهای المنتور برای فیلدهای تاریخ
        selectors: {
            // فیلدهای تاریخ در فرم‌های المنتور
            formDateFields: '.elementor-field-type-date input[type="text"], .elementor-field-type-date input[type="date"]',
            
            // فیلدهای تاریخ کردی اختصاصی
            customDateFields: '.kurdish-date-input',
            
            // فیلدهای تاریخ عمومی المنتور
            elementorDateFields: '.elementor-date-field',
            
            // فیلدهای تاریخ عمومی
            generalDateFields: 'input[type="date"], input[data-type="date"]',
            
            // تمام فیلدهای تاریخ
            allDateFields: 'input[data-jdp]',
            
            // سلکتورهای خاص برای ویجت‌های مختلف
            widgets: {
                form: '.elementor-widget-form',
                datePicker: '.elementor-date-picker',
                calendar: '.elementor-widget-calendar'
            }
        },
        
        // تنظیمات کتابخانه تقویم
        datepickerSettings: {
            hasSecond: false,
            time: false,
            changeMonthRotateYear: true,
            useDropDownYears: true,
            autoShow: true,
            autoHide: true,
            hideAfterChange: true,
            zIndex: 999999
        },
        
        // رویدادها (Callbacks)
        events: {
            /**
             * هنگام راه‌اندازی تقویم
             */
            onInit: function() {
                if (this.debug) {
                    console.log('Elementor Kurdish: تقویم کردی راه‌اندازی شد');
                }
            },
            
            /**
             * هنگام انتخاب تاریخ
             * @param {Object} date - تاریخ انتخاب شده
             * @param {HTMLElement} input - فیلد ورودی
             */
            onDateSelect: function(date, input) {
                if (this.debug) {
                    console.log('Elementor Kurdish: تاریخ انتخاب شد:', date);
                    console.log('Elementor Kurdish: فیلد:', input);
                }
                
                // ایجاد رویداد سفارشی
                const event = new CustomEvent('elementor-kurdish-date-selected', {
                    detail: {
                        date: date,
                        input: input,
                        timestamp: new Date().getTime()
                    }
                });
                document.dispatchEvent(event);
            },
            
            /**
             * هنگام نمایش تقویم
             * @param {HTMLElement} input - فیلد ورودی
             */
            onShow: function(input) {
                if (this.debug) {
                    console.log('Elementor Kurdish: تقویم نمایش داده شد برای:', input);
                }
            },
            
            /**
             * هنگام بستن تقویم
             */
            onHide: function() {
                if (this.debug) {
                    console.log('Elementor Kurdish: تقویم بسته شد');
                }
            },
            
            /**
             * هنگام خطا
             * @param {Error} error - شیء خطا
             */
            onError: function(error) {
                console.error('Elementor Kurdish: خطا در تقویم کردی:', error);
                
                // گزارش خطا به سرور (در صورت نیاز)
                if (this.reportErrors) {
                    this.reportErrorToServer(error);
                }
            }
        },
        
        // ابزارهای توسعه
        development: {
            // فعال کردن لاگ‌های دیباگ
            debug: window.location.search.indexOf('debug=kurdish-calendar') !== -1,
            
            // گزارش خطا به سرور
            reportErrors: false,
            errorEndpoint: '/wp-json/elementor-kurdish/v1/error',
            
            // تست و نمونه‌ها
            testMode: window.location.search.indexOf('test=kurdish-calendar') !== -1
        },
        
        // توابع کاربردی
        utils: {
            /**
             * تبدیل اعداد انگلیسی به کردی
             * @param {number|string} number - عدد انگلیسی
             * @returns {string} - عدد کردی
             */
            toKurdishDigits: function(number) {
                const kurdishDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
                return number.toString().replace(/\d/g, function(digit) {
                    return kurdishDigits[digit];
                });
            },
            
            /**
             * تبدیل اعداد کردی به انگلیسی
             * @param {string} str - رشته شامل اعداد کردی
             * @returns {string} - رشته با اعداد انگلیسی
             */
            toEnglishDigits: function(str) {
                const kurdishDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
                const englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                
                return str.toString().replace(new RegExp(kurdishDigits.join('|'), 'g'), function(match) {
                    return englishDigits[kurdishDigits.indexOf(match)];
                });
            },
            
            /**
             * تبدیل تاریخ شمسی به کردی
             * @param {Object} jalaliDate - تاریخ شمسی {jy, jm, jd}
             * @returns {Object} - تاریخ کردی
             */
            convertToKurdishDate: function(jalaliDate) {
                const gregorianYear = jalaliDate.jy + 621;
                const kurdishYear = gregorianYear + 700;
                
                const day = jalaliDate.jd.toString().padStart(2, '0');
                const month = jalaliDate.jm.toString().padStart(2, '0');
                
                return {
                    day: day,
                    month: month,
                    year: kurdishYear,
                    formatted: this.toKurdishDigits(day) + '/' + this.toKurdishDigits(month) + '/' + this.toKurdishDigits(kurdishYear),
                    formattedEnglish: day + '/' + month + '/' + kurdishYear,
                    calculation: `${jalaliDate.jy} + 621 = ${jalaliDate.jy + 621} + 700 = ${kurdishYear}`
                };
            },
            
            /**
             * تبدیل تاریخ کردی به شمسی
             * @param {string} kurdishDate - تاریخ کردی (فرمت: DD/MM/YYYY)
             * @returns {Object|null} - تاریخ شمسی یا null
             */
            convertToJalali: function(kurdishDate) {
                const parts = kurdishDate.split('/');
                if (parts.length !== 3) return null;
                
                const day = parseInt(this.toEnglishDigits(parts[0]));
                const month = parseInt(this.toEnglishDigits(parts[1]));
                const kurdishYear = parseInt(this.toEnglishDigits(parts[2]));
                
                const gregorianYear = kurdishYear - 700;
                const jalaliYear = gregorianYear - 621;
                
                return {
                    jy: jalaliYear,
                    jm: month,
                    jd: day,
                    formatted: jalaliYear + '/' + month + '/' + day,
                    calculation: `${kurdishYear} - 700 = ${kurdishYear - 700} - 621 = ${jalaliYear}`
                };
            },
            
            /**
             * اعتبارسنجی تاریخ کردی
             * @param {string} date - تاریخ کردی
             * @returns {boolean} - معتبر بودن
             */
            validateKurdishDate: function(date) {
                if (!date || typeof date !== 'string') return false;
                
                // بررسی فرمت
                if (!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(date)) return false;
                
                const parts = date.split('/');
                const day = parseInt(parts[0]);
                const month = parseInt(parts[1]);
                const year = parseInt(parts[2]);
                
                // بررسی محدوده‌ها
                if (month < 1 || month > 12) return false;
                if (day < 1 || day > 31) return false;
                if (year < this.minYear || year > this.maxYear) return false;
                
                return true;
            }
        },
        
        // نمونه‌های تست برای توسعه و دیباگ
        examples: [
            {
                input: { jy: 1404, jm: 7, jd: 10 },
                expected: '10/07/2725',
                description: 'مثال اصلی کاربر - 10/7/1404 شمسی'
            },
            {
                input: { jy: 1403, jm: 1, jd: 1 },
                expected: '01/01/2724',
                description: 'اول فروردین 1403'
            },
            {
                input: { jy: 1400, jm: 12, jd: 30 },
                expected: '30/12/2721',
                description: 'آخر اسفند 1400'
            },
            {
                input: { jy: 1399, jm: 6, jd: 31 },
                expected: '31/06/2720',
                description: 'سی ام شهریور 1399'
            }
        ],
        
        /**
         * اجرای تست‌های نمونه
         */
        runTests: function() {
            if (!this.development.debug) return;
            
            console.group('Elementor Kurdish: تست تبدیل تاریخ‌های کردی');
            
            this.examples.forEach((example, index) => {
                const result = this.utils.convertToKurdishDate(example.input);
                const passed = result.formattedEnglish === example.expected;
                
                console.log(`تست ${index + 1}: ${passed ? '✅' : '❌'}`);
                console.log(`   ورودی: ${example.input.jd}/${example.input.jm}/${example.input.jy} (شمسی)`);
                console.log(`   انتظار: ${example.expected} (کردی)`);
                console.log(`   نتیجه: ${result.formattedEnglish} (کردی)`);
                console.log(`   محاسبه: ${result.calculation}`);
                console.log(`   توضیح: ${example.description}`);
                
                if (!passed) {
                    console.error(`   خطا: نتیجه با انتظار مطابقت ندارد!`);
                }
            });
            
            console.groupEnd();
        },
        
        /**
         * گزارش خطا به سرور
         * @param {Error} error - شیء خطا
         */
        reportErrorToServer: function(error) {
            if (!this.development.reportErrors) return;
            
            const errorData = {
                message: error.message,
                stack: error.stack,
                timestamp: new Date().toISOString(),
                url: window.location.href,
                userAgent: navigator.userAgent
            };
            
            // ارسال درخواست به سرور
            fetch(this.development.errorEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(errorData)
            }).catch(console.error);
        },
        
        /**
         * مقداردهی اولیه پیکربندی
         */
        init: function() {
            // اجرای تست‌ها در حالت دیباگ
            if (this.development.debug) {
                this.runTests();
            }
            
            // فراخوانی رویداد init
            if (typeof this.events.onInit === 'function') {
                this.events.onInit.call(this);
            }
            
            console.log('Elementor Kurdish: پیکربندی تقویم کردی بارگذاری شد');
        }
    };

    // مقداردهی اولیه خودکار
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            window.KurdishCalendarConfig.init();
        });
    } else {
        window.KurdishCalendarConfig.init();
    }

})();

// نمونه‌های سریع برای تست در کنسول
window.KurdishCalendarExamples = {
    /**
     * تست سریع تبدیل تاریخ
     */
    quickTest: function() {
        const testDates = [
            { jy: 1404, jm: 7, jd: 10 },
            { jy: 1403, jm: 1, jd: 1 },
            { jy: 1400, jm: 12, jd: 30 }
        ];
        
        console.group('Elementor Kurdish: تست سریع تبدیل تاریخ');
        testDates.forEach(date => {
            const result = window.KurdishCalendarConfig.utils.convertToKurdishDate(date);
            console.log(`شمسی: ${date.jd}/${date.jm}/${date.jy} → کردی: ${result.formatted}`);
        });
        console.groupEnd();
    },
    
    /**
     * بررسی وضعیت پیکربندی
     */
    status: function() {
        console.group('Elementor Kurdish: وضعیت پیکربندی');
        console.log('فعال:', window.KurdishCalendarConfig.enabled);
        console.log('تبدیل به کردی:', window.KurdishCalendarConfig.convertToKurdish);
        console.log('حالت دیباگ:', window.KurdishCalendarConfig.development.debug);
        console.log('فرمت:', window.KurdishCalendarConfig.format);
        console.log('محدوده سال:', window.KurdishCalendarConfig.minYear + ' - ' + window.KurdishCalendarConfig.maxYear);
        console.groupEnd();
    }
};