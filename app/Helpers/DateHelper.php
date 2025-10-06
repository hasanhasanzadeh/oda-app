<?php

namespace App\Helpers;

use Carbon\Carbon;
use Morilog\Jalali\Jalalian;
use DateTime;

class DateHelper
{
    /**
     * تبدیل تاریخ میلادی به شمسی
     *
     * @param string|Carbon|DateTime|null $date
     * @param string $format
     * @return string|null
     */
    public static function toJalali($date, string $format = 'Y/m/d'): ?string
    {
        if (!$date) {
            return null;
        }

        try {
            // تبدیل به Carbon
            if (is_string($date)) {
                $carbonDate = Carbon::parse($date);
            } elseif ($date instanceof DateTime) {
                $carbonDate = Carbon::instance($date);
            } elseif ($date instanceof Carbon) {
                $carbonDate = $date;
            } else {
                return null;
            }

            // استفاده از Jalalian برای تبدیل دقیق
            return Jalalian::fromCarbon($carbonDate)->format($format);
        } catch (\Exception $e) {
            \Log::error('DateHelper::toJalali Error: ' . $e->getMessage(), [
                'date' => $date,
                'format' => $format
            ]);
            return null;
        }
    }

    /**
     * تبدیل تاریخ شمسی به میلادی
     *
     * @param string $jalaliDate (فرمت: Y/m/d یا Y-m-d)
     * @return Carbon|null
     */
    public static function toGregorian(string $jalaliDate): ?Carbon
    {
        try {
            // پاک کردن فضاهای خالی
            $jalaliDate = trim($jalaliDate);

            // جدا کردن اجزای تاریخ
            $parts = preg_split('/[\/\-]/', $jalaliDate);

            if (count($parts) !== 3) {
                return null;
            }

            [$year, $month, $day] = array_map('intval', $parts);

            // استفاده از Jalalian برای تبدیل
            $jDate = Jalalian::fromFormat('Y/m/d', "$year/$month/$day");
            return $jDate->toCarbon();
        } catch (\Exception $e) {
            \Log::error('DateHelper::toGregorian Error: ' . $e->getMessage(), [
                'jalaliDate' => $jalaliDate
            ]);
            return null;
        }
    }

    /**
     * فرمت کامل فارسی با نام روز و ماه
     *
     * @param string|Carbon|DateTime|null $date
     * @return string|null
     */
    public static function toJalaliFull($date): ?string
    {
        if (!$date) {
            return null;
        }

        try {
            if (is_string($date)) {
                $date = Carbon::parse($date);
            } elseif ($date instanceof DateTime) {
                $date = Carbon::instance($date);
            }

            return Jalalian::fromCarbon($date)->format('%A، %d %B %Y');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * فرمت با ساعت
     *
     * @param string|Carbon|DateTime|null $date
     * @return string|null
     */
    public static function toJalaliWithTime($date): ?string
    {
        if (!$date) {
            return null;
        }

        try {
            if (is_string($date)) {
                $date = Carbon::parse($date);
            } elseif ($date instanceof DateTime) {
                $date = Carbon::instance($date);
            }

            $jalaliDate = Jalalian::fromCarbon($date)->format('Y/m/d');
            $time = $date->format('H:i');

            return "$jalaliDate - $time";
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * تاریخ امروز شمسی
     *
     * @param string $format
     * @return string
     */
    public static function today(string $format = 'Y/m/d'): string
    {
        return Jalalian::now()->format($format);
    }

    /**
     * دیروز شمسی
     *
     * @param string $format
     * @return string
     */
    public static function yesterday(string $format = 'Y/m/d'): string
    {
        return Jalalian::fromCarbon(Carbon::yesterday())->format($format);
    }

    /**
     * فردا شمسی
     *
     * @param string $format
     * @return string
     */
    public static function tomorrow(string $format = 'Y/m/d'): string
    {
        return Jalalian::fromCarbon(Carbon::tomorrow())->format($format);
    }

    /**
     * نام ماه شمسی
     *
     * @param int $month
     * @return string
     */
    public static function getMonthName(int $month): string
    {
        $months = [
            1 => 'فروردین', 2 => 'اردیبهشت', 3 => 'خرداد',
            4 => 'تیر', 5 => 'مرداد', 6 => 'شهریور',
            7 => 'مهر', 8 => 'آبان', 9 => 'آذر',
            10 => 'دی', 11 => 'بهمن', 12 => 'اسفند'
        ];

        return $months[$month] ?? '';
    }

    /**
     * نام روز هفته فارسی
     *
     * @param string|Carbon|DateTime $date
     * @return string|null
     */
    public static function getDayName($date): ?string
    {
        if (!$date) {
            return null;
        }

        try {
            if (is_string($date)) {
                $date = Carbon::parse($date);
            } elseif ($date instanceof DateTime) {
                $date = Carbon::instance($date);
            }

            return Jalalian::fromCarbon($date)->format('%A');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * محاسبه فاصله زمانی به فارسی
     *
     * @param string|Carbon|DateTime $date
     * @return string
     */
    public static function diffForHumans($date): string
    {
        if (!$date) {
            return '';
        }

        try {
            if (is_string($date)) {
                $date = Carbon::parse($date);
            } elseif ($date instanceof DateTime) {
                $date = Carbon::instance($date);
            }

            $diff = Carbon::now()->diffInSeconds($date);
            $isPast = $date->isPast();

            if ($diff < 60) {
                return 'لحظاتی پیش';
            } elseif ($diff < 3600) {
                $minutes = floor($diff / 60);
                return $minutes . ' دقیقه ' . ($isPast ? 'پیش' : 'دیگر');
            } elseif ($diff < 86400) {
                $hours = floor($diff / 3600);
                return $hours . ' ساعت ' . ($isPast ? 'پیش' : 'دیگر');
            } elseif ($diff < 604800) {
                $days = floor($diff / 86400);
                return $days . ' روز ' . ($isPast ? 'پیش' : 'دیگر');
            } elseif ($diff < 2592000) {
                $weeks = floor($diff / 604800);
                return $weeks . ' هفته ' . ($isPast ? 'پیش' : 'دیگر');
            } else {
                return self::toJalali($date);
            }
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * بررسی اینکه آیا تاریخ امروز است
     *
     * @param string|Carbon|DateTime $date
     * @return bool
     */
    public static function isToday($date): bool
    {
        try {
            if (is_string($date)) {
                $date = Carbon::parse($date);
            } elseif ($date instanceof DateTime) {
                $date = Carbon::instance($date);
            }

            return $date->isToday();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * بررسی اینکه آیا تاریخ دیروز است
     *
     * @param string|Carbon|DateTime $date
     * @return bool
     */
    public static function isYesterday($date): bool
    {
        try {
            if (is_string($date)) {
                $date = Carbon::parse($date);
            } elseif ($date instanceof DateTime) {
                $date = Carbon::instance($date);
            }

            return $date->isYesterday();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * دریافت لیست ماه‌های شمسی
     *
     * @return array
     */
    public static function getMonths(): array
    {
        return [
            1 => 'فروردین', 2 => 'اردیبهشت', 3 => 'خرداد',
            4 => 'تیر', 5 => 'مرداد', 6 => 'شهریور',
            7 => 'مهر', 8 => 'آبان', 9 => 'آذر',
            10 => 'دی', 11 => 'بهمن', 12 => 'اسفند'
        ];
    }

    /**
     * دریافت لیست روزهای هفته
     *
     * @return array
     */
    public static function getWeekDays(): array
    {
        return [
            'شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه',
            'چهارشنبه', 'پنج‌شنبه', 'جمعه'
        ];
    }

    /**
     * تبدیل تاریخ میلادی به فرمت مناسب برای دیتابیس
     *
     * @param string|Carbon|DateTime|null $date
     * @return string|null
     */
    public static function toDatabase($date): ?string
    {
        if (!$date) {
            return null;
        }

        try {
            if (is_string($date)) {
                $date = Carbon::parse($date);
            } elseif ($date instanceof DateTime) {
                $date = Carbon::instance($date);
            }

            return $date->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * تبدیل تاریخ شمسی به فرمت مناسب برای دیتابیس (میلادی)
     *
     * @param string $jalaliDate
     * @return string|null
     */
    public static function jalaliToDatabase(string $jalaliDate): ?string
    {
        $carbon = self::toGregorian($jalaliDate);
        return $carbon ? $carbon->format('Y-m-d') : null;
    }

    /**
     * تبدیل مستقیم با استفاده از کتابخانه Morilog
     * این متد برای دیباگ و تست استفاده می‌شود
     *
     * @param mixed $date
     * @return array
     */
    public static function debug($date): array
    {
        try {
            $info = [
                'original' => $date,
                'type' => gettype($date),
            ];

            if ($date instanceof Carbon) {
                $info['is_carbon'] = true;
                $info['gregorian'] = $date->format('Y-m-d H:i:s');
                $info['jalali'] = Jalalian::fromCarbon($date)->format('Y/m/d H:i:s');
            } elseif ($date instanceof DateTime) {
                $carbonDate = Carbon::instance($date);
                $info['is_datetime'] = true;
                $info['gregorian'] = $carbonDate->format('Y-m-d H:i:s');
                $info['jalali'] = Jalalian::fromCarbon($carbonDate)->format('Y/m/d H:i:s');
            } elseif (is_string($date)) {
                $carbonDate = Carbon::parse($date);
                $info['is_string'] = true;
                $info['gregorian'] = $carbonDate->format('Y-m-d H:i:s');
                $info['jalali'] = Jalalian::fromCarbon($carbonDate)->format('Y/m/d H:i:s');
            }

            return $info;
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
                'original' => $date,
            ];
        }
    }
}