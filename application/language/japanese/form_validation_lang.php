<?php
/**
 * System messages translation for CodeIgniter(tm)
 *
 * @author	CodeIgniter community
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['form_validation_required']              = '{field}を入力して下さい';
$lang['form_validation_isset']                 = '{field}は値を入力してください';
$lang['form_validation_valid_email']           = '{field}はメールアドレスとして正しい形式で入力してください';
$lang['form_validation_valid_emails']          = '{field}は複数メールアドレスとして正しい形式で入力してください';
$lang['form_validation_valid_url']             = '{field}はURLとして正しい形式で入力してください';
$lang['form_validation_valid_ip']              = '{field}はIPアドレスとして正しい形式で入力してください';
$lang['form_validation_min_length']            = '{field}は{param}文字以上入力してください';
$lang['form_validation_max_length']            = '{field}は{param}文字より短く入力してください';
$lang['form_validation_exact_length']          = '{field}は{param}文字で入力してください';
$lang['form_validation_alpha']                 = '{field}は半角英字のみで入力してください';
$lang['form_validation_alpha_numeric']         = '{field}は半角英数字のみで入力してください';
$lang['form_validation_alpha_numeric_spaces']  = '{field}は半角英数字かスペースのみで入力してください';
$lang['form_validation_alpha_dash']            = '{field}は半角英数字、_(アンダースコア)、もしくは-(ハイフン)のみで入力してください';
$lang['form_validation_numeric']               = '{field}は半角数字のみで入力してください';
$lang['form_validation_is_numeric']            = '{field}は半角数字のみで入力してください';
$lang['form_validation_integer']               = '{field}は半角整数のみで入力してください';
$lang['form_validation_regex_match']           = '{field}は正しい形式で入力してください';
$lang['form_validation_matches']               = '{field}は{param}欄と同じ内容を入力してください';
$lang['form_validation_differs']               = '{field}は{param}欄と同じ内容を入力してください';
$lang['form_validation_is_unique']             = '{field}は他と重複しない値を入力してください';
$lang['form_validation_is_natural']            = '{field}は半角数値のみを入力してください';
$lang['form_validation_is_natural_no_zero']    = '{field}はゼロより大きい半角数値のみを入力してください';
$lang['form_validation_decimal']               = '{field}は10進数のみを入力してください';
$lang['form_validation_less_than']             = '{field}は{param}より小さい値を入力してください';
$lang['form_validation_less_than_equal_to']    = '{field}は{param}以下の値を入力してください';
$lang['form_validation_greater_than']          = '{field}は{param}より大きい値を入力してください';
$lang['form_validation_greater_than_equal_to'] = '{field}は{param}以上の値を入力してください';
$lang['form_validation_error_message_not_set'] = '{field}に適切なエラーメッセージがありません';
$lang['form_validation_in_list']               = '{field}は{param}のいずれかを入力してください';

// 拡張
$lang['form_validation_date']     = "{field}は YYYY-MM-DD 形式で入力してください";
$lang['form_validation_time']     = "{field}は HH:MM 形式で入力してください";
$lang['form_validation_datetime'] = "{field}は YYYY-MM-DD HH:MM 形式で入力してください";
$lang['form_validation_katakana'] = "{field}は全角カタカナで入力してください";
$lang['form_validation_hiragana'] = '{field}は全角ひらがなで入力してください';
$lang['form_validation_password'] = "{field}は半角英数字を含む8文字以上32文字以下で入力してください";
$lang['form_validation_zip']      = "{field}は 999-9999 形式で入力してください";
$lang['form_validation_tel']      = "{field}は 099-9999-9999 形式で入力してください";
$lang['form_validation_jisx0208'] = "{field}は機種依存文字や半角カナを含めず入力してください";
$lang['form_validation_ascii']    = "{field}は半角英数記号で入力してください";
