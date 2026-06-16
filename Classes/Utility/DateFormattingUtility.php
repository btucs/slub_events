<?php
namespace Slub\SlubEvents\Utility;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use IntlDateFormatter;
use Throwable;

final class DateFormattingUtility
{
    private function __construct()
    {
    }

    public static function resolveDateTime(mixed $value): ?DateTimeImmutable
    {
        if ($value instanceof DateTimeImmutable) {
            return $value;
        }

        if ($value instanceof DateTimeInterface) {
            return DateTimeImmutable::createFromInterface($value);
        }

        if (is_int($value) || (is_string($value) && ctype_digit($value))) {
            return self::createFromTimestamp((int)$value);
        }

        if (is_string($value) && $value !== '') {
            try {
                return new DateTimeImmutable($value);
            } catch (Throwable) {
                return null;
            }
        }

        return null;
    }

    public static function createFromTimestamp(int $timestamp): DateTimeImmutable
    {
        $dateTime = new DateTimeImmutable('@' . $timestamp);
        $dateTime = $dateTime->setTimezone(new DateTimeZone(date_default_timezone_get()));
        return $dateTime;
    }

    public static function formatPattern(
        ?DateTimeInterface $dateTime,
        string $pattern,
        ?string $locale = null,
        string $phpFallbackPattern = 'Y-m-d H:i:s'
    ): string
    {
        if (!$dateTime instanceof DateTimeInterface) {
            return '';
        }

        $formatter = new IntlDateFormatter(
            $locale ?? self::getDefaultLocale(),
            IntlDateFormatter::NONE,
            IntlDateFormatter::NONE
        );
        $formatter->setPattern($pattern);

        $result = $formatter->format($dateTime);

        return is_string($result) ? $result : $dateTime->format($phpFallbackPattern);
    }

    public static function formatLocalized(
        ?DateTimeInterface $dateTime,
        int $dateType = IntlDateFormatter::SHORT,
        int $timeType = IntlDateFormatter::NONE,
        ?string $locale = null
    ): string {
        if (!$dateTime instanceof DateTimeInterface) {
            return '';
        }

        $formatter = new IntlDateFormatter(
            $locale ?? self::getDefaultLocale(),
            $dateType,
            $timeType
        );

        $result = $formatter->format($dateTime);

        return is_string($result) ? $result : $dateTime->format('Y-m-d H:i');
    }

    public static function getDefaultLocale(): string
    {
        if (!empty($GLOBALS['LANG']) && isset($GLOBALS['LANG']->lang)) {
            return match ($GLOBALS['LANG']->lang) {
                'de' => 'de_DE',
                'en' => 'en_GB',
                default => $GLOBALS['LANG']->lang,
            };
        }

        $locale = setlocale(LC_TIME, '0');
        if (is_string($locale) && $locale !== '' && $locale !== 'C') {
            return $locale;
        }

        return 'en_GB';
    }
}
