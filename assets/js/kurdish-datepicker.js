(function($) {
    'use strict';

    // تنظیمات تقویم کردی
    const kurdishCalendarSettings = {
        months: [
            'نەورۆز', 'گوڵان', 'جۆزەردان', 'پووشپەڕ',
            'گەلاوێژ', 'خەرمانان', 'ڕەزبەر', 'خەزەن',
            'سەرماوە', 'بەفرانبار', 'ڕێبەندان', 'ڕەشەمە'
        ],
        days: ['ش', 'ی', 'د', 'س', 'چ', 'پ', 'ج'],
        persianDigits: true
    };

    // راه‌اندازی تقویم
    function initKurdishCalendar() {
        if (typeof jalaliDatepicker !== 'undefined') {
            jalaliDatepicker.startWatch(kurdishCalendarSettings);
        } else {
            console.error('Elementor Kurdish: Jalali Datepicker library not loaded');
        }
    }

    // راه‌اندازی وقتی DOM آماده است
    $(document).ready(function() {
        initKurdishCalendar();
    });

    // راه‌اندازی در ویرایشگر المنتور
    if (typeof elementor !== 'undefined') {
        $(window).on('elementor/frontend/init', function() {
            initKurdishCalendar();
        });
    }

})(jQuery);