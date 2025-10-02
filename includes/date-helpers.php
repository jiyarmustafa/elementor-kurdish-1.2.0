<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * توابع کمک کننده برای محاسبات تاریخ کردی
 */

class Elementor_Kurdish_Date_Helpers {
    
    /**
     * تبدیل تاریخ شمسی به کردی
     */
    public static function jalali_to_kurdish($jalali_year, $jalali_month, $jalali_day) {
        // تبدیل سال شمسی به میلادی (تقریبی)
        $gregorian_year = $jalali_year + 621;
        
        // سال کردی = سال میلادی + 700
        $kurdish_year = $gregorian_year + 700;
        
        return [
            'day' => str_pad($jalali_day, 2, '0', STR_PAD_LEFT),
            'month' => str_pad($jalali_month, 2, '0', STR_PAD_LEFT),
            'year' => $kurdish_year,
            'formatted' => $jalali_day . '/' . $jalali_month . '/' . $kurdish_year,
            'calculation' => $jalali_year . ' + 621 = ' . ($jalali_year + 621) . ' + 700 = ' . $kurdish_year
        ];
    }
    
    /**
     * تبدیل تاریخ کردی به شمسی
     */
    public static function kurdish_to_jalali($kurdish_date) {
        if (!preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $kurdish_date, $matches)) {
            return false;
        }
        
        $day = (int) $matches[1];
        $month = (int) $matches[2];
        $kurdish_year = (int) $matches[3];
        
        // سال میلادی = سال کردی - 700
        $gregorian_year = $kurdish_year - 700;
        
        // سال شمسی = سال میلادی - 621
        $jalali_year = $gregorian_year - 621;
        
        return [
            'jalali_year' => $jalali_year,
            'jalali_month' => $month,
            'jalali_day' => $day,
            'formatted' => $jalali_year . '/' . $month . '/' . $day,
            'calculation' => $kurdish_year . ' - 700 = ' . ($kurdish_year - 700) . ' - 621 = ' . $jalali_year
        ];
    }
    
    /**
     * اعتبارسنجی تاریخ کردی
     */
    public static function validate_kurdish_date($date) {
        if (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $date)) {
            return false;
        }
        
        $parts = explode('/', $date);
        $day = (int) $parts[0];
        $month = (int) $parts[1];
        $year = (int) $parts[2];
        
        // بررسی محدوده سال کردی (2700 تا 3700)
        if ($year < 2700 || $year > 3700) {
            return false;
        }
        
        // بررسی محدوده ماه و روز
        if ($month < 1 || $month > 12 || $day < 1 || $day > 31) {
            return false;
        }
        
        return true;
    }
    
    /**
     * مثال‌های تست برای بررسی درستی محاسبات
     */
    public static function test_examples() {
        $examples = [
            ['1404', '7', '10'],  // مثال کاربر
            ['1403', '1', '1'],   // اول فروردین
            ['1400', '12', '30'], // آخر اسفند
            ['1399', '6', '31'],  // سی ام شهریور
        ];
        
        $results = [];
        foreach ($examples as $example) {
            list($year, $month, $day) = $example;
            $kurdish = self::jalali_to_kurdish($year, $month, $day);
            $results[] = [
                'input' => $year . '/' . $month . '/' . $day . ' (شمسی)',
                'output' => $kurdish['formatted'] . ' (کردی)',
                'calculation' => $kurdish['calculation']
            ];
        }
        
        return $results;
    }
    
    /**
     * تبدیل اعداد انگلیسی به کردی
     */
    public static function to_kurdish_digits($number) {
        $english_digits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $kurdish_digits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        
        return str_replace($english_digits, $kurdish_digits, $number);
    }
    
    /**
     * تبدیل اعداد کردی به انگلیسی
     */
    public static function to_english_digits($string) {
        $kurdish_digits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $english_digits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        
        return str_replace($kurdish_digits, $english_digits, $string);
    }
}