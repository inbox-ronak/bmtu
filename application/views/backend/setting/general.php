<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Settings</h1>
            </div>          
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <?php
    if (!empty($this->session->flashdata('message'))) {
        echo $this->session->flashdata('message');
    }
    ?>
    <!-- Default box -->
    <!-- <script src="<?php echo base_url() ?>public/plugins/ckeditor_new/ckeditor.js"></script>
    <script src="<?php echo base_url() ?>public/dist/js/jquery.validate.min.js"></script> -->
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <nav class="w-100">
                    <div class="nav nav-tabs" id="product-tab" role="tablist">
                        <a class="nav-item nav-link general_settings <?= ($post_hidden_tab == "general_settings") ? 'active' : ''; ?> " id="general_settings-tab" data-toggle="tab" href="#general_settings" role="tab" aria-controls="general_settings" aria-selected="true">General</a>  

                        <a class="nav-item nav-link company_setting <?= ($post_hidden_tab == "company_setting") ? 'active' : ''; ?> " id="company_setting-tab" data-toggle="tab" href="#company_setting" role="tab" aria-controls="grade_setting" aria-selected="false">Company Setting</a>
                         <a class="nav-item nav-link captcha_setting <?= ($post_hidden_tab == "captcha_setting") ? 'active' : ''; ?>" id="captcha_setting-tab" data-toggle="tab" href="#captcha_setting" role="tab" aria-controls="captcha_setting" aria-selected="false">Captcha Setting</a>

                        <a class="nav-item nav-link social_media_links <?= ($post_hidden_tab == "social_media_links") ? 'active' : ''; ?> " id="social_media_links-tab" data-toggle="tab" href="#social_media_links" role="tab" aria-controls="social_media_links" aria-selected="false">Social Media Links</a>
                    </div>
                </nav>
                <?php echo form_open(base_url('admin/setting/update_settings'), 'class="form-horizontal" enctype="multipart/form-data" method="post" '); ?>
                <input type="hidden" name="hidden_tab" value="<?= $post_hidden_tab ?>" id="hidden_tab">
                <div class="tab-content p-3" id="nav-tabContent">				
                    <div class="tab-pane fade show active" id="general_settings" role="tabpanel" aria-labelledby="general_settings-tab">
                        <div class="form-group">
                            <label for="subscription_amount" class="col-sm-12 control-label">Frontend Header Logo <span class="text-danger">*</span> </label>
                            <div class="col-sm-12">
                                <input type="file" name="site_logo" class="form-control" />
                                <span style="color:blue;" ><i><b>Note:</b> Recommended Image size: <b>284 X 82</b></i></span>
                            </div>
                        </div>
                        <?php if (!empty($posts) && isset($posts['site_logo'])) { ?>
                            <div class="form-group">
                                <label for="subscription_amount" class="col-sm-12 control-label"> </label>
                                <div class="col-sm-12">
                                    <img src="<?php echo base_url() . $posts['site_logo']; ?>" style="max-height: 100px; max-width: 100px; background-color: #ecf0f5" >
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="footer_logo" class="col-sm-12 control-label">Frontend Footer Logo <span class="text-danger">*</span> </label>
                            <div class="col-sm-12">
                                <input type="file" name="footer_logo" id="footer_logo" class="form-control" />
                                <span style="color:blue;" ><i><b>Note:</b> Recommended Image size: <b>268 X 96</b></i></span>
                            </div>
                        </div>
                        <?php if (!empty($posts) && isset($posts['footer_logo'])) { ?>
                            <div class="form-group">
                                <label for="footer_logo" class="col-sm-12 control-label"> </label>
                                <div class="col-sm-12">
                                    <img src="<?php echo base_url() . $posts['footer_logo']; ?>" style="max-height: 100px; max-width: 100px; background-color: #ecf0f5" >
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="subscription_amount" class="col-sm-12 control-label">Backend Main Logo <span class="text-danger">*</span> </label>
                            <div class="col-sm-12">
                                <input type="file" name="backend_main_logo" class="form-control" />
                                <span style="color:blue;" ><i><b>Note:</b> Recommended Image size: <b>284 X 82</b></i></span>
                            </div>
                        </div>
                        <?php if (!empty($posts) && isset($posts['backend_main_logo']) && $posts['backend_main_logo'] != '') { ?>
                            <div class="form-group">
                                <label for="subscription_amount" class="col-sm-12 control-label"> </label>
                                <div class="col-sm-12">
                                    <img src="<?php echo base_url() . $posts['backend_main_logo']; ?>" style="max-height: 100px; max-width: 100px; background-color: #ecf0f5" >
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="footer_logo" class="col-sm-12 control-label">Backend Side Favicon icon <span class="text-danger">*</span> </label>
                            <div class="col-sm-12">
                                <input type="file" name="backend_side_logo" id="backend_side_logo" class="form-control" />
                                <span style="color:blue;" ><i><b>Note:</b> Recommended Image size: <b>268 X 96</b></i></span>
                            </div>
                        </div>
                        <?php if (!empty($posts) && isset($posts['backend_side_logo'])) { ?>
                            <div class="form-group">
                                <label for="backend_side_logo" class="col-sm-12 control-label"> </label>
                                <div class="col-sm-12">
                                    <img src="<?php echo base_url() . $posts['backend_side_logo']; ?>" style="max-height: 100px; max-width: 100px; background-color: #ecf0f5" >
                                </div>
                            </div>
                        <?php } ?>
                        <!-- End Home Page Block Enable -->
                        <div style="clear:both"></div>
                        <div class="form-group">
                            <div class="col-md-11">                             
                                <button type="submit" class="btn btn-info pull-right"> Save Changes </button>
                            </div>
                        </div>
                    </div>  
                    <div class="tab-pane fade" id="company_setting" role="tabpanel" aria-labelledby="company_setting-tab">    
                        <div class="form-group">
                            <label for="subscription_amount" class="col-sm-12 control-label"> Company Name <span class="text-danger">*</span> </label>
                            <div class="col-sm-12">
                                <input id="autocomplete_search" name="company_name" type="text" class="form-control" placeholder="Company Name" value="<?php echo ($this->input->post()) ? $this->input->post('company_name') : (!empty($posts) && isset($posts['company_name'])) ? $posts['company_name'] : ''; ?>" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="subscription_amount" class="col-sm-12 control-label"> Company Address <span class="text-danger">*</span> </label>
                            <div class="col-sm-12">
                                <input id="autocomplete_search" name="contact_address" type="text" class="form-control" placeholder="Search Location (eg: Toronto)" value="<?php echo ($this->input->post()) ? $this->input->post('contact_address') : (!empty($posts) && isset($posts['contact_address'])) ? $posts['contact_address'] : ''; ?>" />
                                <input type="hidden" name="lat">
                                <input type="hidden" name="long">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="contact_no" class="col-sm-12 control-label">Company Contact No Header</label>
                                <div class="col-sm-12">
                                    <input type="text" name="contact_no" id="contact_no" class="form-control" placeholder="" value="<?php echo ($this->input->post()) ? $this->input->post('contact_no') : (!empty($posts) && isset($posts['contact_no'])) ? $posts['contact_no'] : ''; ?>" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="contact_no" class="col-sm-12 control-label">Company Contact No Footer </label>
                                <div class="col-sm-12">
                                    <input type="text" name="contact_no_footer" id="contact_no_footer" class="form-control" placeholder="" value="<?php echo ($this->input->post()) ? $this->input->post('contact_no_footer') : (!empty($posts) && isset($posts['contact_no_footer'])) ? $posts['contact_no_footer'] : ''; ?>" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="contact_email" class="col-sm-12 control-label"> Company Contact Email</label>
                                <div class="col-sm-12">
                                    <input type="text" name="contact_email" id="contact_email" class="form-control" placeholder="" value="<?php echo ($this->input->post()) ? $this->input->post('contact_email') : (!empty($posts) && isset($posts['contact_email'])) ? $posts['contact_email'] : ''; ?>" />
                                </div>
                            </div>                           
                        </div>
                        
                        <div class="form-group">
                            <label for="footer_copy_right" class="col-sm-12 control-label">Footer Copyright message:<small style="color: blue; font-weight: bold;"><i>[English]</i></small></label>
                            <div class="col-sm-12">
                                <input id="footer_copy_right" name="footer_copy_right" type="text" class="form-control"  value="<?php echo ($this->input->post()) ? $this->input->post('footer_copy_right') : (!empty($posts) && isset($posts['footer_copy_right'])) ? $posts['footer_copy_right'] : ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="footer_copy_right" class="col-sm-12 control-label">Footer Copyright message:<small style="color: blue; font-weight: bold;"><i>[Arabic]</i></small></label>
                            <div class="col-sm-12">
                                <input id="footer_copy_right_arabic" name="footer_copy_right_arabic" type="text" class="form-control"  value="<?php echo ($this->input->post()) ? $this->input->post('footer_copy_right_arabic') : (!empty($posts) && isset($posts['footer_copy_right_arabic'])) ? $posts['footer_copy_right_arabic'] : ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="footer_copy_right" class="col-sm-12 control-label">Footer Copyright message:<small style="color: blue; font-weight: bold;"><i>[Kurdish]</i></small></label>
                            <div class="col-sm-12">
                                <input id="footer_copy_right_kurdish" name="footer_copy_right_kurdish" type="text" class="form-control"  value="<?php echo ($this->input->post()) ? $this->input->post('footer_copy_right_kurdish') : (!empty($posts) && isset($posts['footer_copy_right_kurdish'])) ? $posts['footer_copy_right_kurdish'] : ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="footer_copy_right" class="col-sm-12 control-label">Footer Copyright message:<small style="color: blue; font-weight: bold;"><i>[Kurdish]</i></small></label>
                            <div class="col-sm-12">
                                <input id="footer_copy_right_kurdish" name="footer_copy_right_kurdish" type="text" class="form-control"  value="<?php echo ($this->input->post()) ? $this->input->post('footer_copy_right_kurdish') : (!empty($posts) && isset($posts['footer_copy_right_kurdish'])) ? $posts['footer_copy_right_kurdish'] : ''; ?>" />
                            </div>
                        </div>
                        <div style="clear:both"></div>
                        <div class="form-group">
                            <div class="col-md-11">
                                <button type="submit" class="btn btn-info pull-right"> Save Changes </button>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="captcha_setting" role="tabpanel" aria-labelledby="captcha_setting-tab"> 

                        <div class="google_captcha_div">
                            
                        <div class="form-group">
                            <label for="k" class="col-sm-12 control-label">CAPTCHA Type <span class="text-danger">*</span> </label>
                            <div class="col-sm-12">
                                <div class="contentradio" id="captcha_type">
                                          <div class="icheck-primary d-inline">
                                            <input type="radio" name="captcha_type" value="1" <?php echo set_radio('captcha_type', 1); ?> id="customCheck3"  <?php if (isset($posts['captcha_type']) && $posts['captcha_type'] == 1) {
                                                echo 'checked="checked"';
                                            } else {
                                                echo 'checked="checked"';
                                            }
                                            ?>  >
                                            <label for="customCheck3">Google</label>
                                        </div> 
                                        <div class="icheck-primary d-inline p-3">
                                            <input type="radio" name="captcha_type" value="0" <?php echo set_radio('captcha_type', 0); ?> id="customCheck4" <?php if (isset($posts['captcha_type']) && $posts['captcha_type'] == 0) {
                                                echo 'checked="checked"';
                                            }
                                            ?>  >
                                            <label for="customCheck4">Manual</label>
                                        </div>
                                 </div>
                             </div>
                        </div>
                        <div id="captcha_div">
                            <div class="form-group" id="">
                                <label for="CAPTCHA_key" class="col-sm-12 control-label">CAPTCHA Key</label>
                                <div class="col-sm-12">
                                    <input type="text" name="CAPTCHA_key" class="form-control" placeholder="6Ld205gUAAAAABrAt1GwkJTzkMtdPEEcuLc" value="<?php echo ($this->input->post()) ? ($this->input->post('CAPTCHA_key')) : (!empty($posts) && isset($posts['CAPTCHA_key'])) ? $posts['CAPTCHA_key'] : ''; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="CAPTCHA_secret" class="col-sm-12 control-label">CAPTCHA Secret</label>
                                <div class="col-sm-12">
                                    <input type="text" name="CAPTCHA_secret" class="form-control" placeholder="6Ld205gUAAAAAGngK2ybDJpHd9omqsJ-vK" value="<?php echo ($this->input->post()) ? ($this->input->post('CAPTCHA_secret')) : (!empty($posts) && isset($posts['CAPTCHA_secret'])) ? $posts['CAPTCHA_secret'] : ''; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                            <div style="clear:both"></div>
                            <div class="form-group">
                                <div class="col-md-11">
                                    <button type="submit" class="btn btn-info pull-right"> Save Changes </button>
                                </div>
                            </div>
                        </div>
                    <div class="tab-pane fade" id="email_setting" role="tabpanel" aria-labelledby="email_setting-tab"> 
                        <div class="form-group">
                            <label for="mail_sending_method" class="col-sm-12 control-label">Mail Sending Method <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select name="mail_sending_method" id="mail_sending_method" class="form-control" required="">
                                    <option value="smtp" 
                                    <?php
                                    if (!empty($posts) && isset($posts['mail_sending_method']) && $posts['mail_sending_method'] == 'smtp') {
                                        echo 'selected';
                                    }
                                    ?> > SMTP </option>
                                    <option value="php_mail" 
                                    <?php
                                    if (!empty($posts) && isset($posts['mail_sending_method']) && $posts['mail_sending_method'] == 'php_mail') {
                                        echo 'selected';
                                    }
                                    ?>> PHP Mail </option>
                                </select>
                            </div>
                        </div>
                        <div class="smtp box-mail">
                            <div class="form-group">
                                <label for="smtp_host" class="col-sm-12 control-label"> SMTP Host <span class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="smtp_host" value="<?php echo ($this->input->post()) ? ($this->input->post('smtp_host')) : (!empty($posts) && isset($posts['smtp_host'])) ? $posts['smtp_host'] : ''; ?>" placeholder="SMTP Host" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="smtp_port" class="col-sm-12 control-label"> SMTP Port <span class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control" name="smtp_port" value="<?php echo ($this->input->post()) ? ($this->input->post('smtp_port')) : (!empty($posts) && isset($posts['smtp_port'])) ? $posts['smtp_port'] : ''; ?>" placeholder="SMTP Port" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="smtp_tls_ssl_opt" class="col-sm-12 control-label">Select SMTP TLS/SSL <span class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <select name="smtp_tls_ssl_opt" id="smtp_tls_ssl_opt" class="form-control js-example-basic-single" required="">
                                        <option value="tls" <?php
                                        if (!empty($posts) && isset($posts['smtp_tls_ssl_opt']) && $posts['smtp_tls_ssl_opt'] == 'tls') {
                                            echo 'selected';
                                        }
                                        ?>> TLS </option>
                                        <option value="ssl" <?php
                                        if (!empty($posts) && isset($posts['smtp_tls_ssl_opt']) && $posts['smtp_tls_ssl_opt'] == 'ssl') {
                                            echo 'selected';
                                        }
                                        ?>> SSL </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="smtp_user" class="col-sm-12 control-label"> SMTP Username <span class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="smtp_user" value="<?php echo ($this->input->post()) ? ($this->input->post('smtp_user')) : (!empty($posts) && isset($posts['smtp_user'])) ? $posts['smtp_user'] : ''; ?>" placeholder="SMTP User" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="smtp_pass" class="col-sm-12 control-label"> SMTP Password <span class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="smtp_pass" value="<?php echo ($this->input->post()) ? ($this->input->post('smtp_pass')) : (!empty($posts) && isset($posts['smtp_pass'])) ? $posts['smtp_pass'] : ''; ?>" placeholder="SMTP Password" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="smtp_mail_from" class="col-sm-12 control-label"> Mail From <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="smtp_mail_from" value="<?php echo ($this->input->post()) ? ($this->input->post('smtp_mail_from')) : (!empty($posts) && isset($posts['smtp_mail_from'])) ? $posts['smtp_mail_from'] : ''; ?>" placeholder="" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="smtp_mail_from" class="col-sm-12 control-label"> Mail From Name<span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="smtp_mail_from_name" value="<?php echo ($this->input->post()) ? ($this->input->post('smtp_mail_from_name')) : (!empty($posts) && isset($posts['smtp_mail_from_name'])) ? $posts['smtp_mail_from_name'] : ''; ?>" placeholder="Mail From Name" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="smtp_mail_cc" class="col-sm-12 control-label">CC Mail </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="smtp_mail_cc" value="<?php echo ($this->input->post()) ? ($this->input->post('smtp_mail_cc')) : (!empty($posts) && isset($posts['smtp_mail_cc'])) ? $posts['smtp_mail_cc'] : ''; ?>" placeholder="" >
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="smtp_mail_bcc" class="col-sm-12 control-label"> BCC Mail </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="smtp_mail_bcc" value="<?php echo ($this->input->post()) ? ($this->input->post('smtp_mail_bcc')) : (!empty($posts) && isset($posts['smtp_mail_bcc'])) ? $posts['smtp_mail_bcc'] : ''; ?>" placeholder="no-reply@fundraisingnet.com" >
                            </div>
                        </div>                           
                        <div style="clear:both"></div>
                        <div class="form-group">
                            <div class="col-md-11">
                                <button type="submit" class="btn btn-info pull-right"> Save Changes </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="social_media_links" role="tabpanel" aria-labelledby="social_media_links-tab">  
                            <div class="form-group">
                                <label for="facebook_link" class="col-sm-6 control-label">Facebook</label>
                                <div class="col-sm-6">
                                    <input type="text" name="facebook_link" class="form-control" placeholder="Facebook Page Link" value="<?php echo ($this->input->post()) ? $this->input->post('facebook_link') : (!empty($posts) && isset($posts['facebook_link'])) ? $posts['facebook_link'] : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="twitter_link" class="col-sm-6 control-label">Twitter</label>
                                <div class="col-sm-6">
                                    <input type="text" name="twitter_link" class="form-control" placeholder="Twitter Page Link" value="<?php echo ($this->input->post()) ? $this->input->post('twitter_link') : (!empty($posts)) && isset($posts['twitter_link']) ? $posts['twitter_link'] : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="instagram_link" class="col-sm-6 control-label">Linkdin</label>
                                <div class="col-sm-6">
                                    <input type="text" name="linkedin_link" class="form-control" placeholder="Linkdin Page Link" value="<?php echo ($this->input->post()) ? ($this->input->post('linkedin_link')) : (!empty($posts) && isset($posts['linkedin_link'])) ? $posts['linkedin_link'] : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group socialField " id="att_title_desc" >
                                <div class="row form-group attributeLable">
                                    <div class="col-sm-3 pull-left">
                                        <label for="status" class="">Label </label>
                                    </div>
                                    <div class="col-sm-3 pull-left">
                                        <label for="status" class="">Icon</label>
                                    </div>
                                    <div class="col-sm-4 pull-left">
                                        <label for="status" class="">Link</label>
                                    </div>
                                </div>
                                <div class="row form-group socialClass after-add-more" >
                                    <?php if((isset($posts['social_label']) && !empty($posts['social_label']))){
                                        $label = unserialize($posts['social_label']);
                                        $link = unserialize($posts['social_link']);
                                        $icon = unserialize($posts['social_icon']);
                                        for($i = 0;$i<count($label);$i++){
                                            $singleIcon = isset($icon[$i]) ? $icon[$i] : '';
                                            $singleLink = isset($link[$i]) ? $link[$i] : '';
                                            $singleLbl = isset($label[$i]) ? $label[$i] : ''; ?>
                                            <div class="form-group row">
                                                <div class="col-sm-3">                              
                                                    <input type="text" name="social_label[]" value="<?php echo $singleLbl;?>" class="form-control text" placeholder="Label"/>
                                                </div>   

                                                <div class="col-sm-3">                              
                                                    <input type="text" name="social_icon[]" value='<?php echo $singleIcon;?>' class="form-control text" placeholder="Icon"/>
                                                </div>
                                                <div class="col-sm-4">                              
                                                    <input type="text" name="social_link[]" value="<?php echo $singleLink;?>" class="form-control text" placeholder="Link"/>
                                                </div>
                                                <div class="form-group">
                                                    <?php if($i==0){?>
                                                        <button type="button"  class="btn btn-sm btn-info pull-left addMoreSocialButton"><i class="fa fa-plus"></i> Add More</button>
                                                    <?php } else {?>
                                                        <button class="btn btn-danger btn_remove" type="button"><i class="fa fa-minus"></i></button>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        <?php }
                                    } else {?>
                                        <div class="form-group row">
                                            <div class="col-sm-3">                              
                                                <input type="text" name="social_label[]" value="" class="form-control text" placeholder="Label"/>
                                            </div>   

                                            <div class="col-sm-3">                              
                                                <input type="text" name="social_icon[]" value="" class="form-control text" placeholder="Icon"/>
                                            </div>
                                            <div class="col-sm-4">                              
                                                <input type="text" name="social_link[]" value="" class="form-control text" placeholder="Link"/>
                                            </div>

                                            <div class="form-group">
                                                <button type="button"  class="btn btn-sm btn-info pull-left addMoreSocialButton"><i class="fa fa-plus"></i> Add More</button>
                                            </div>
                                        </div>
                                    <?php }?>
                                </div>
                            </div>
     
                        
                        <div style="clear:both"></div>
                        <div class="form-group">
                            <div class="col-md-11">
                                <button type="submit" class="btn btn-info pull-right"> Save Changes </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</section>

    <div class="copyblock hide" style="display:none;">
        <div class="row">
            <div class="col-sm-3">                              
                <input type="text" name="social_label[]" value="" class="form-control text" placeholder="Label"/>
            </div>   
            <div class="col-sm-3">                              
                <input type="text" name="social_icon[]" value="" class="form-control text" placeholder="Icon"/>
            </div>
            <div class="col-sm-4">                              
                <input type="text" name="social_link[]" value="" class="form-control text" placeholder="Link"/>
            </div>
            <div class="form-group">
                 <button class="btn btn-danger btn_remove" type="button"><i class="fa fa-minus"></i></button>
            </div>
        </div>
    </div>
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function () {
        
        $(document).on('change', '#mail_sending_method', function () {

            if ($(this).val() == "smtp") {
                $(".box-mail").hide();
                $(".smtp").show();
            }
            if ($(this).val() == "php_mail") {
                $(".box-mail").hide();
                $(".php_mail").show();
            }
        });
        $('#mail_sending_method').trigger('change');

        $(".addMoreSocialButton").click(function () {
            var htmlfind = $(".copyblock").html();
            $(".after-add-more").append(htmlfind);
        }); 
    });

</script>

<?php $this->session->unset_userdata('hidden_tab_session'); ?>
<script>
    $("#product-tab a").click(function () {
        var active_tab_id = $(this).attr('id');
        
        document.getElementById("hidden_tab").value = active_tab_id;
        sessionStorage.setItem('activetab', active_tab_id);
    });

    $(document).ready(function () {
       
        if (sessionStorage.getItem('activetab') == 'grade_setting-tab') {
            $("#grade_setting-tab").click();
        } else if (sessionStorage.getItem('activetab') == 'email_setting-tab') {
            $("#email_setting-tab").click();
        } else if (sessionStorage.getItem('activetab') == 'general_settings-tab') {
            $("#general_settings-tab").click();
        } else if (sessionStorage.getItem('activetab') == 'social_media_links-tab') {
            $("#social_media_links-tab").click();
        }
        else if (sessionStorage.getItem('activetab') == 'captcha_setting-tab') {
            $("#captcha_setting-tab").click();
        }
        else if (sessionStorage.getItem('activetab') == 'home_page_content-tab') {
            $("#home_page_content-tab").click();
        }


       
    });


         $(document).on('click', '.btn_remove', function(event) {            
            $(this).parent('div').parent('div').remove();
        });
    
</script>

<script language="javascript">
 
     $(document).ready(function () {
      <?php foreach ($langArr as $key => $val) { ?>
        $('.chart_block_<?php echo $key; ?>').summernote({
            height: 200,
            callbacks: {
                onImageUpload: function (files, editor, welEditable) {
                    sendFile(files[0], editor, welEditable);
                }
            },
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Avante Garde', 'Times New Roman', 'Helvetica'],
            fontNamesIgnoreCheck: ['Avante Garde']
        });

        get_editor('chart_block_<?php echo $key; ?>');

        $('.overview_block_<?php echo $key; ?>').summernote({
            height: 200,
            callbacks: {
                onImageUpload: function (files, editor, welEditable) {
                    sendFile(files[0], editor, welEditable);
                }
            },
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Avante Garde', 'Times New Roman', 'Helvetica'],
            fontNamesIgnoreCheck: ['Avante Garde']
        });

        get_editor('overview_block_<?php echo $key; ?>');

<?php } ?>
        function sendFile(file, editor, welEditable) {
            data = new FormData();
            data.append("file", file);
            $.ajax({
                data: {data: data, 'csrf_test_name': $("input[name=csrf_test_name]").val()},
                type: "POST",
                url: "<?php echo base_url(); ?>admin/ckeditor/image_upload",
                cache: false,
                contentType: false,
                processData: false,
                success: function (url) {
                    $('.chart_block_<?php echo $key; ?>').summernote('editor.insertImage', url);
                },
                error: function (jqXHR, ajaxOptions, thrownError) {
                    if (jqXHR.responseText) {
                        toastr.error(jqXHR.responseText, 'Inconceivable!')
                    } else {
                        console.error("<div>Http status: " + jqXHR.status + " " + jqXHR.statusText + "</div>" + "<div>ajaxOptions: " + ajaxOptions + "</div>"
                                + "<div>thrownError: " + thrownError + "</div>");
                    }
                }
            });
        }
        
       
        function sendFile1(file, editor, welEditable) {
            data = new FormData();
            data.append("file", file);
            $.ajax({
                 data: {data: data, 'csrf_test_name': $("input[name=csrf_test_name]").val()},
                type: "POST",
                url: "<?php echo base_url(); ?>admin/ckeditor/image_upload",
                cache: false,
                contentType: false,
                processData: false,
                success: function (url) {
                    $('.textarea_fr').summernote('editor.insertImage', url);
                },
                error: function (jqXHR, ajaxOptions, thrownError) {
                    if (jqXHR.responseText) {
                        toastr.error(jqXHR.responseText, 'Inconceivable!')
                    } else {
                        console.error("<div>Http status: " + jqXHR.status + " " + jqXHR.statusText + "</div>" + "<div>ajaxOptions: " + ajaxOptions + "</div>"
                                + "<div>thrownError: " + thrownError + "</div>");
                    }
                }
            });
        }
    });
</script>
 <script>
    $(document).ready(function(){
        $("input[type='radio']").click(function(){
            var registered_on_etender_value = $("input[name='captcha_type']:checked").val();

            if(registered_on_etender_value ==0){
                $('#captcha_div').css('display','none');                
            }
            else{
                $('#captcha_div').css('display','block');
            }
        
        });
    });
     $(document).ready(function(){
     
            var registered_on_etender_value = $("input[name='captcha_type']:checked").val();

            if(registered_on_etender_value ==0){
                $('#captcha_div').css('display','none');                
            }
            else{
                $('#captcha_div').css('display','block');
            }
        
    });
</script>
