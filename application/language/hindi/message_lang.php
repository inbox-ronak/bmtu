<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang = array();
require_once(BASEPATH . 'database/DB.php');
$db = & DB();
$langdata = $db->get('ci_lang')->result_array();
//echo '<pre>';print_r($langdata);exit;
$lang['lang_name_home'] = 'Home';
if (!empty($langdata)) {
    foreach ($langdata as $langdatai) {
        $lang[($langdatai['lang_name'])] = $langdatai['lang_hi'];
    }    
}