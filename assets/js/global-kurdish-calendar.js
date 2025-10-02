(function($) {
    'use strict';

    // تبدیل اعداد انگلیسی به کردی
    function toKurdishDigits(number) {
        const kurdishDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        return number.toString().replace(/\d/g, function(digit) {
            return kurdishDigits[digit];
        });
    }

    // تبدیل اعداد کردی به انگلیسی
    function toEnglishDigits(str) {
        const kurdishDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        const englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        
        return str.toString().replace(new RegExp(kurdishDigits.join('|'), 'g'), function(match) {
            return englishDigits[kurdishDigits.indexOf(match)];
        });
    }

    // تبدیل تاریخ شمسی به کردی
    function convertToKurdishDate(jalaliDate) {
        const gregorianYear = jalaliDate.jy + 621;
        const kurdishYear = gregorianYear + 700;
        
        const day = jalaliDate.jd.toString().padStart(2, '0');
        const month = jalaliDate.jm.toString().padStart(2, '0');
        
        return {
            day: day,
            month: month,
            year: kurdishYear,
            formatted: toKurdishDigits(day) + '/' + toKurdishDigits(month) + '/' + toKurdishDigits(kurdishYear),
            formattedEnglish: day + '/' + month + '/' + kurdishYear
        };
    }

    // تبدیل تاریخ کردی به شمسی
    function convertKurdishToJalali(kurdishDate) {
        const parts = kurdishDate.split('/');
        if (parts.length !== 3) return null;
        
        const day = parseInt(toEnglishDigits(parts[0]));
        const month = parseInt(toEnglishDigits(parts[1]));
        const kurdishYear = parseInt(toEnglishDigits(parts[2]));
        
        const gregorianYear = kurdishYear - 700;
        const jalaliYear = gregorianYear - 621;
        
        return {
            jy: jalaliYear,
            jm: month,
            jd: day
        };
    }

    // تنظیمات پیشرفته تقویم کردی
    const kurdishCalendarSettings = {
        months: kurdishCalendarConfig.months,
        days: kurdishCalendarConfig.daysShort,
        persianDigits: true,
        time: false,
        
        format: function(date) {
            if (!kurdishCalendarConfig.convertToKurdish) {
                return date.jd + '/' + date.jm + '/' + date.jy;
            }
            
            const kurdishDate = convertToKurdishDate(date);
            return kurdishDate.formatted;
        },
        
        onSelect: function(date, input) {
            if (kurdishCalendarConfig.convertToKurdish) {
                const kurdishDate = convertToKurdishDate(date);
                input.value = kurdishDate.formatted;
                
                // ایجاد رویداد تغییر برای المنتور
                $(input).trigger('input');
                $(input).trigger('change');
                
                console.log('Elementor Kurdish: تاریخ کردی انتخاب شد:', kurdishDate.formatted);
            }
        }
    };

    // راه‌اندازی تقویم برای تمام المنتور
    function initGlobalKurdishCalendar() {
        if (typeof jalaliDatepicker === 'undefined') {
            console.error('Elementor Kurdish: کتابخانه تقویم بارگذاری نشده است');
            return;
        }

        // 1. فیلدهای تاریخ در فرم‌های المنتور
        $('.elementor-field-type-date input[type="text"], .elementor-field-type-date input[type="date"]').each(function() {
            if (!$(this).hasClass('jdp-initialized')) {
                $(this).attr('data-jdp', '');
                $(this).addClass('jdp-initialized');
                jalaliDatepicker.attachDatepicker(this, kurdishCalendarSettings);
            }
        });

        // 2. فیلدهای تاریخ کردی اختصاصی
        $('.kurdish-date-input').each(function() {
            if (!$(this).hasClass('jdp-initialized')) {
                $(this).attr('data-jdp', '');
                $(this).addClass('jdp-initialized');
                jalaliDatepicker.attachDatepicker(this, kurdishCalendarSettings);
            }
        });

        // 3. فیلدهای تاریخ عمومی
        $('input[type="date"], input[data-type="date"]').each(function() {
            if (!$(this).hasClass('jdp-initialized') && 
                $(this).closest('.elementor-widget').length > 0) {
                $(this).attr('data-jdp', '');
                $(this).addClass('jdp-initialized');
                jalaliDatepicker.attachDatepicker(this, kurdishCalendarSettings);
            }
        });

        // 4. ویجت تاریخ المنتور
        $('.elementor-date-field').each(function() {
            if (!$(this).hasClass('jdp-initialized')) {
                $(this).attr('data-jdp', '');
                $(this).addClass('jdp-initialized');
                jalaliDatepicker.attachDatepicker(this, kurdishCalendarSettings);
            }
        });

        console.log('Elementor Kurdish: تقویم کردی برای تمام فیلدهای تاریخ راه‌اندازی شد');
    }

    // راه‌اندازی وقتی DOM آماده است
    $(document).ready(function() {
        setTimeout(initGlobalKurdishCalendar, 500);
    });

    // راه‌اندازی در ویرایشگر المنتور
    if (typeof elementor !== 'undefined') {
        $(window).on('elementor/frontend/init', function() {
            elementor.hooks.addAction('frontend/element_ready/global', function($scope) {
                setTimeout(initGlobalKurdishCalendar, 300);
            });
            
            elementor.hooks.addAction('frontend/element_ready/form.default', function($scope) {
                setTimeout(initGlobalKurdishCalendar, 300);
            });
        });
    }

    // راه‌اندازی مجدد وقتی محتوای داینامیک لود می‌شود
    $(document).on('DOMNodeInserted', function(e) {
        if ($(e.target).hasClass('elementor-widget') || 
            $(e.target).find('.elementor-widget').length > 0) {
            setTimeout(initGlobalKurdishCalendar, 200);
        }
    });

    // برای پاپ‌آپ‌های المنتور
    $(document).on('elementor/popup/show', function() {
        setTimeout(initGlobalKurdishCalendar, 500);
    });

    // توابع عمومی برای استفاده در سایر اسکریپت‌ها
    window.ElementorKurdishCalendar = {
        init: initGlobalKurdishCalendar,
        convertToKurdish: convertToKurdishDate,
        convertToJalali: convertKurdishToJalali,
        toKurdishDigits: toKurdishDigits,
        toEnglishDigits: toEnglishDigits,
        
        // تست تاریخ‌های مختلف
        testDates: function() {
            const testDates = [
                { jy: 1404, jm: 7, jd: 10 },  // 10/7/1404 → 10/07/2725
                { jy: 1403, jm: 1, jd: 1 },   // 01/01/1403 → 01/01/2724
                { jy: 1400, jm: 12, jd: 30 }, // 30/12/1400 → 30/12/2721
                { jy: 1399, jm: 6, jd: 31 }   // 31/06/1399 → 31/06/2720
            ];
            
            testDates.forEach(date => {
                const result = convertToKurdishDate(date);
                console.log(`Elementor Kurdish Test: ${date.jd}/${date.jm}/${date.jy} → ${result.formatted}`);
            });
        }
    };

    // اجرای تست هنگام لود
    if (window.location.search.indexOf('debug=kurdish-calendar') !== -1) {
        setTimeout(() => {
            window.ElementorKurdishCalendar.testDates();
        }, 1000);
    }

})(jQuery);