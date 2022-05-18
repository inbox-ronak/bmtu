<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
function headers()
{
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
    header('Access-Control-Allow-Credentials: true');
}

function get_setting_value_by_name($name) {
    $CI = & get_instance();

    $CI->db->select('setting_value')->where(array('setting_key' => $name));
    $query = $CI->db->get('ci_setting');
    $result = $query->row_array();
    if (!empty($result)) {
        return $result['setting_value'];
    }
    return false;
}

function get_page_length_dropdown() {
    $result = '[[10, 50, 100, 200, 300, 400, 500, 1000], [10, 50, 100, 200, 300, 400, 500, 1000]]';

    return $result;
}

function get_setting_data() {
    $CI = & get_instance();
    $query = $CI->db->select('*')->from('ci_setting')->where(array())->get();
    $result = $query->result_array();
    foreach ($result as $key => $value) {
        $my[] = array($value['setting_key'] => $value['setting_value']);
    }
    foreach ($my as $value) {
        foreach ($value as $key => $value) {
            $settings[$key] = $value;
        }
    }
    return $settings;
}

function setImagePath() {
    $CI = & get_instance();
    $str = '';
    return $str;
}
function getImagePath() {
    $CI = & get_instance();
    $str = base_url();
    return $str;
}

function number_to_alpha($str)
{
    $alpha = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $newName = '';
    do {
        $str--;
        $limit = floor($str / 26);
        $reminder = $str % 26;
        $newName = $alpha[$reminder].$newName;
        $str=$limit;
    } while ($str >0);
    return $newName;
}

function convertToIndianCurrency($number) 
{
    $no = round($number);
    $decimal = round($number - ($no = floor($number)), 2) * 100;    
    $digits_length = strlen($no);    
    $i = 0;
    $str = array();
    $words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
        } else {
            $str [] = null;
        }  
    }
    
    $Rupees = implode(' ', array_reverse($str));
    $paise = ($decimal) ? "And " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])." Paisa"  : '';
    return ($Rupees ? $Rupees.' Rupees ' : '') . " Only";
}

function amount($number)
{
  $value = '';
  if(trim($number)!= '')
  {
    $value = number_format($number,2,'.','');
  }
  return $value;
}
// This function will return a random
// string of specified length
function unique_code($length_of_string=10)
{
    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  
    // Shuffle the $str_result and returns substring
    // of specified length
    return substr(str_shuffle($str_result), 0, $length_of_string);
} 
function create_token()
{
    // ***** Generate Token *****
    $char = "bcdfghjkmnpqrstvzBCDFGHJKLMNPQRSTVWXZaeiouyAEIOUY!@#%";
    $token = '';
    for ($i = 0; $i < 47; $i++)
    {
        $token .= $char[(rand() % strlen($char))];
    }
    return $token;
}
function langArr()
{
    $languageArr = array(
        'en' => 'English',
        'hi' => 'Hindi',
        //'ar' => 'Arabic',
        //'ku' => 'Kurdish',
    );

    return $languageArr;
}
function check_bid_status($tender_id,$user_id){
    $bid_status = 0;
    $CI = & get_instance();    
    $CI->load->model('common_model');
    $bid_exits_data =  $CI->common_model->getRow('ci_tender_bids','id',array('created_by'=>$user_id,'tender_id' => $tender_id),'','id','ASC');
    if(!empty($bid_exits_data)){
           $bid_status = 1;
    }else{
        $bid_status=0;
    }
    return  $bid_status;

}
function check_tender_status($tender_id){
    $tenders_bid_status = 0;
    $CI = & get_instance();    
    $CI->load->model('common_model');
    $tenders_bid_exits_data =  $CI->common_model->getRow('ci_tender_bids','id',array('tender_id' => $tender_id),'','id','ASC');
    if(!empty($tenders_bid_exits_data)){
           $tenders_bid_status = 1;
    }else{
        $tenders_bid_status=0;
    }
    return  $tenders_bid_status;

}
function get_sub_category($category_id){
    $sub_category_data = array();
    $CI = & get_instance();    
    $CI->load->model('common_model');
   $sub_category_data =  $CI->common_model->getRows('ci_categories','*',array('parent_category'=>$category_id),'','id','ASC');
    return  $sub_category_data;
}
//Email Template
function sendEmail_PRM($to = '', $subject = '', $body = '', $attachment = '', $cc = '', $bcc = '', $from = '', $from_email = '') {
    $controller = & get_instance();
    $controller->load->helper('path');
    $config = array();
    $config['useragent'] = "CodeIgniter";
    $config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
    $config['protocol'] = "smtp";
    $config['smtp_host'] = get_setting_data()['smtp_host']; //"ssl://smtp.googlemail.com";
    $config['smtp_port'] = get_setting_data()['smtp_port']; //"465";
    $config['smtp_timeout'] = '30';
    $config['smtp_user'] = get_setting_data()['smtp_user']; //"naumanahmedcs@gmail.com";
    $config['smtp_pass'] = get_setting_data()['smtp_pass']; //"WWWdua3582154#";
    $config['smtp_crypto'] = get_setting_data()['smtp_tls_ssl_opt'];
    $config['mailtype'] = 'html';
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['wordwrap'] = TRUE;
    $controller->load->library('email');
    $controller->email->initialize($config);
    if ($from_email != '') {
        $controller->email->from($from_email, $from);
    } else {
        $controller->email->from(get_setting_data()['smtp_mail_from'], $from);
    }

    $controller->email->to($to);
    $controller->email->subject($subject);
    $controller->email->message($body); 
    if ($cc != '') {
        $controller->email->cc($cc);
    }
    if ($bcc != '') {
        $controller->email->bcc($bcc);
    }
    if ($attachment != '') {
        $controller->email->attach($attachment);
    }
    if ($controller->email->send()) {
        return TRUE;
    } else {
        return FALSE;
    }
}
function convertImageToWebP($source, $destination, $quality=80) {
    $extension = pathinfo($source, PATHINFO_EXTENSION);
    if ($extension == 'jpeg' || $extension == 'jpg') 
        $image = imagecreatefromjpeg($source);
    elseif ($extension == 'gif') 
        $image = imagecreatefromgif($source);
    elseif ($extension == 'png') 
        $image = imagecreatefrompng($source);
    return imagewebp($image, $destination, $quality);
    
}
function expo_status()
{
    $expo_status = array(
        '0' => 'Approved',
        '1' => 'Rejected',
    );
    return $expo_status;
}
function get_razorpay_details($payment_id)
{
    $curl = curl_init();
    $key_id = RAZORPAY_KEY_ID;
    $key_secret = RAZORPAY_KEY_SECRET;
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.razorpay.com/v1/payments/'.$payment_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_USERPWD => $key_id . ':' . $key_secret,
        //CURLOPT_HTTPHEADER => array(
        //'Authorization: Basic cnpwX3Rlc3RfSGFaR1A0MWtaS2s2eko6NHVIYm9zUUZPZzd0Sm40TGlnZEE4eDJ2'
        //),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}
function otp_generator($n=4) {
      
    $generator = "1234567890";
    $result = "";
  
    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand()%(strlen($generator))), 1);
    }
  
    // Return result
    return $result;
}
function check_user_approved_or_not($user_id){

    $user_is_approve = 0;
    $user_is_approved_data = array();
    $CI = & get_instance();    
    $CI->load->model('common_model');
    $user_is_approved_data  =  $CI->common_model->getRow('ci_users','is_approve',array('id' => $user_id),'','id','ASC');
    if(!empty($user_is_approved_data)){
        $user_is_approve = $user_is_approved_data['is_approve']; 
    }
    return  $user_is_approve;
}
if (!function_exists('GET_MAIL_TEMPLATE')) {
    function GET_MAIL_TEMPLATE($email_template_slug,$lang) {
        $DB = & get_instance();
        $DB->db->select('*');
        $DB->db->from('ci_email_template');
        $DB->db->where('email_template_slug', $email_template_slug);
        $result = $DB->db->get();
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $value) {
                 $email_subject_content = unserialize($value->email_template_subject);
                 $email_template_body_content = unserialize($value->email_template_body);
                 $email_temp_subject = '';
                 $email_temp_body = '';
                if (isset($email_subject_content['email_template_subject'][$lang])) {
                           $email_temp_subject = ($email_subject_content['email_template_subject'][$lang]);                           
                }  
                if (isset($email_template_body_content['email_template_body'][$lang])) {
                    $email_temp_body = base64_decode($email_template_body_content['email_template_body'][$lang]);
                           
                } 

             
                $template_arr = array(
                    'email_template_for' => $value->email_template_for,
                    'email_template_subject' => $email_temp_subject,
                    'email_template_body' => $email_temp_body,
                    'email_template_slug' => $value->email_template_slug,
                );
                return $template_arr;
            }
        } else {
            echo "<b>Error :</b> Something went wrong with Email Slug, '" . $email_template_slug . "' slug may not exist database!";
        }
    }
}
function view_foramated_date($lang,$date)
{
    if($lang=='ar')
        setlocale(LC_TIME, 'en_US.utf8');
    if($lang=='ku')
        setlocale(LC_TIME, 'fr_TR.utf8');
    return $date= strftime("%B %d, %Y", strtotime($date));
}
function get_master_menu($id) {
    $CI = & get_instance();
    //$lng = setLanguage_frontend();
    $CI->db->select("menu_id,page_name_en,page_name_ar,page_name_ku,page_name_hi,page_id,page_slug,url_type,page_url");
    $CI->db->from('ci_pages');
    $CI->db->join('ci_menus', 'ci_menus.pageid=ci_pages.page_id');
    $CI->db->where('parent_id', NULL);
    $CI->db->where('ci_pages.is_active', 1);
    $CI->db->where('ci_menus.menu_type', 1);
    $CI->db->where('ci_menus.mst_menu_id', $id);
    $CI->db->order_by('order_no', 'asc');
    $child = $CI->db->get();
    $categories = $child->result();
    //echo $CI->db->last_query();exit;
    return $categories;
}
?>