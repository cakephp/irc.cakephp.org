<?php
namespace App\View\Helper;

use Cake\View\Helper\TimeHelper;

class AppTimeHelper extends TimeHelper
{
    /**
     * Returns a formatted descriptive date string for given datetime string.
     *
     * If the given date is today, the returned string could be "Today, 16:54".
     * If the given date was yesterday, the returned string could be "Yesterday, 16:54".
     * If $dateString's year is the current year, the returned string does not
     * include mention of the year.
     *
     * @param int|string|\DateTime|null $dateString UNIX timestamp, strtotime() valid string or DateTime object
     * @param string|\DateTimeZone|null $timezone User's timezone string or DateTimeZone object
     * @param string|null $locale Locale string.
     * @return string Formatted date string
     */
    public function niceShort($dateString = null, $timezone = null, $locale = null)
    {
        $date = $dateString ? $this->fromString($dateString, $timezone)->toUnixString() : time();
        $y = $this->isThisYear($date) ? '' : ' Y';
        if ($this->isToday($dateString, $timezone)) {
            $ret = sprintf(__('Today, %s',true), date("H:i", $date));
        } elseif ($this->wasYesterday($dateString, $timezone)) {
            $ret = sprintf(__('Yesterday, %s',true), date("H:i", $date));
        } else {
            $ret = date("M jS{$y}, H:i", $date);
        }
        return $ret;
    }
}
