<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['useragent'] = 'Secret';
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$config['smtp_host'] = '';
$config['smtp_user'] = '';
$config['smtp_pass'] = '';
$config['smtp_port'] = 25;
$config['smtp_timeout'] = 5;
$config['wordwrap'] = FALSE;
$config['wrapchars'] = 76;
$config['mailtype'] = 'text';
$config['charset'] = 'utf-8';
$config['validate'] = FALSE;
$config['priority'] = 3;
$config['crlf'] = "\n";
$config['bcc_batch_mode'] = FALSE;
$config['bcc_batch_size'] = 200;
