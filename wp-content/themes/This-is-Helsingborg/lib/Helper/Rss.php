<?php

namespace Helsingborg\Helper;

class Rss
{
    /**
     * Formats timestamp to RSS format
     * @param  String $timestamp Unformatted timestamp
     * @return String            Formatted timestamp
     */
    public static function helsingborgRssDate($timestamp = null)
    {
        $timestamp = ($timestamp == null) ? time() : strtotime($timestamp);
        return date(DATE_RSS, $timestamp);
    }

    /**
     * Limits a text to given parameters
     * @param  string $string    The original string
     * @param  integer $length   Target length
     * @param  string $replacer  Suffix
     * @return string            The limited string
     */
    public static function helsingborgRssTextLimit($string, $length, $replacer = '...')
    {
        $string = strip_tags($string);
        if (strlen($string) > $length) {
            if (preg_match('/^(.*)\W.*$/', substr($string, 0, $length+1), $matches)) {
                return  $matches[1];
            } else {
                return substr($string, 0, $length) . $replacer;
            }
        } else {
            return $string;
        }
    }
}
