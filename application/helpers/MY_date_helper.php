<?php
/**
 * DATEヘルパ拡張
 *
 * @package    CodeIgniter
 * @subpackage Helper
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
/**
 * 日本語の日付文字列を得る
 *
 * @param date $date
 * @return string
 */
function jp_date($date)
{
    return date("Y年n月j日", strtotime($date));
}

/**
 * 日本語の日付曜日文字列を得る
 *
 * @param date $date
 * @return string
 */
function jp_date_week($date)
{
    $weeks = array('日', '月', '火', '水', '木', '金', '土');
    $week  = $weeks[date("w", strtotime($date))];
    return date("Y年n月j日({$week})", strtotime($date));
}

/**
 * 日本語の日付時間文字列を得る
 *
 * @param datetime $datetime
 * @return string
 */
function jp_datetime($datetime)
{
    return date("Y年n月j日 H:i", strtotime($datetime));
}

/**
 * 日本語の日付時間曜日文字列を得る
 *
 * @param datetime $datetime
 * @return string
 */
function jp_datetime_week($datetime)
{
    $weeks = array('日', '月', '火', '水', '木', '金', '土');
    $week  = $weeks[date("w", strtotime($datetime))];
    return date("Y年n月j日({$week}) H:i", strtotime($datetime));
}

/**
 * 日本語の年月文字列を得る
 *
 * @param date $date
 * @return string
 */
function jp_month($date)
{
    return date("Y年n月", strtotime($date));
}

/**
 * 日本語の月日曜日文字列を得る
 *
 * @param date $date
 * @return string
 */
function jp_mdw($date)
{
    $weeks = array('日', '月', '火', '水', '木', '金', '土');
    $week  = $weeks[date("w", strtotime($date))];
    return $date ? date("n月j日({$week})", strtotime($date)) : $date;
}

/**
 * 日本語の時間文字列を得る
 *
 * @param date $time
 * @return string
 */
function jp_time($time)
{
    return date("G時i分", strtotime($time));
}

/**
 * 年月日時分を得る
 *
 * @param datetime $datetime
 * @return string
 */
function hm_datetime($datetime)
{
    return date("Y-m-d H:i", strtotime($datetime));
}

/**
 * 時分を得る
 *
 * @param time $time
 * @return string
 */
function hm_time($time)
{
    return $time ? date("H:i", strtotime($time)) : $time;
}

/**
 * スラッシュ繋ぎの月日を得る
 *
 * @param datetime $datetime
 * @return string
 */
function slash_md($datetime)
{
    return date("n/j", strtotime($datetime));
}
