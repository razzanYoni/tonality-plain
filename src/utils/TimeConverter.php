<?php

namespace utils;

use InvalidArgumentException;

class TimeConverter
{
    public static TimeConverter $instance;

    public static function getInstance(): TimeConverter
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function secondsToMinutes($seconds): float|int
    {
        if (!is_numeric($seconds)) {
            throw new InvalidArgumentException("Input must be a numeric value.");
        }

        return $seconds / 60;
    }

    public function minutesToSeconds($minutes): float|int
    {
        if (!is_numeric($minutes)) {
            throw new InvalidArgumentException("Input must be a numeric value.");
        }

        return $minutes * 60;
    }


    public function secondsToMinutesTuple($seconds): array
    {
        if (!is_numeric($seconds)) {
            throw new InvalidArgumentException("Input must be a numeric value.");
        }

        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        return [$minutes, $remainingSeconds];
    }
}