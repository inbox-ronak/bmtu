<?php
defined('BASEPATH') OR exit('No direct script access allowed');

        /*$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        $config['next_tag_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';
        $config['first_url'] = '1';*/


        $config['link_config'] = array (
        'full_tag_open'      => '<div class="pagging text-center"><nav><ul class="pagination">',
        'full_tag_close' => '</ul></nav></div>',
        'num_tag_open'      => '<li class="page-item"><span class="page-link">',
        'num_tag_close' => '</span></li>',

        'cur_tag_open'      => '<li class="page-item active"><span class="page-link">',
        'cur_tag_close' => '<span class="sr-only">(current)</span></span></li>',
        
        'next_tag_open'      =>'<li class="page-item"><span class="page-link">',
        'next_tag_close' => '<span aria-hidden="true"></span></span></li>',
        
        'next_tag_close'      => '<span aria-hidden="true">&raquo;</span></span></li>',
        'prev_tag_open' => '<li class="page-item"><span class="page-link">',
        
        'prev_tag_close'      => '<li class="page-item"><span class="page-link">',
        'first_tag_open' => '<li class="page-item"><span class="page-link">',        
        'first_tag_close'      => '</span></li>',
        'last_tag_open' => '<li class="page-item"><span class="page-link">',
        'last_tag_close'=>'</span></li>',
        'first_url'=>0
        );
?>