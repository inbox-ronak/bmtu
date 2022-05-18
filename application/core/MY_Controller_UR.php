<?php

class MY_Controller_UR extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->has_userdata('web_language_frontend')) {
            //$this->session->set_userdata('web_language_frontend', $this->session->userdata('site_lang'));
            // if ($this->uri->segment(1)) {
            //     $this->session->set_userdata('web_language_frontend', $this->uri->segment(1));
            // } else {
            //     $this->session->set_userdata('web_language_frontend', $this->session->userdata('web_language_frontend'));
            // }
        } else {
            $this->session->set_userdata('web_language_frontend', 'en');
        }

        $this->user_type = $this->session->userdata('website_type_frontend');
        //echo '<pre>';print_r($_SESSION);exit;
        $this->lang->load("message_lang", $this->session->userdata('web_language_frontend'));
    }

}
?>

