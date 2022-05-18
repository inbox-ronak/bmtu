


$(document).on('click', '#login-button', function (event) {
    event.preventDefault();
    var login_heading=$('#login_heading').val();
    var login_please_wait=$('#login_please_wait').val();
    
    $('#login-button').html('');  
    $('#login-button').html(login_please_wait+' <i class="fas fa-spinner fa-spin ml-1"></i>');
    
    $.ajax({
        data: $('#login-form').serialize(),
        type: 'POST',
         url: `${baseURL}login`,
        async: true,
        success: function (res) {
            var data = JSON.parse(res);
            // console.log(data);
            if (data.status == 0){
                //$(".modal-content").css("margin-top", "-50px");
                window.scrollTo(500, 0);
                var temp = `<div class="alert alert-danger alert-dismissible fade show" role="alert">${data.msg}
                            <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">x</span>
                            </a>
                          </div>`;

                $('.login-alert-message').html(temp);
                $('#login-button').html('');
                $('#login-button').html(login_heading+' <i class="fas fa-sign-in ml-1"></i>');
            } else {
                //window.location.href = `${sharpSRCURL}/${data.language_preference}/login_check/${data.data}`;
                window.location.href = `${baseURL}user/dashboard`;
            }
        }
    });

});



$(document).on('click', '#sign-up-button', function (event) {
    event.preventDefault();
    $('#sign-up-button').html('');
    $('#sign-up-button').html('Please wait <i class="fas fa-spinner fa-spin ml-1"></i>');
    $.ajax({
        data: $('#sign-up-form').serialize(),
        type: 'POST',
        url: `${baseURL}user_auth/register`,
        async: true,
        success: function (res) {
            var data = JSON.parse(res);
            if (data.status == 0)
            {
                grecaptcha.reset();
                var temp = `<div class="alert alert-danger alert-dismissible fade show" id="scroll_div" role="alert">${data.msg}
                            <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">x</span>
                            </a>
                          </div>`;

                $('.sign-up-alert-message').html(temp);
                $('#sign-up-button').html('');
                $('#sign-up-button').html('Sign up <i class="fas fa-sign-in ml-1"></i>');
                var container = $('#login-register-modal'),
                        scrollTo = $('#scroll_div');
                container.animate({
                    scrollTop: scrollTo.offset().top - container.offset().top + container.scrollTop()
                });


            } else {

                $(document).find('.user-roles-wrapper').html('');
                $(document).find('.form-feilds-wrapper').css('display', 'none');

                var temp = `<div class="alert alert-success alert-dismissible fade show" id="scroll_div" role="alert">${data.msg}
                            <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">x</span>
                            </a>
                          </div>`;
                $('.sign-up-alert-message').html(temp);
                $('#sign-up-button').html('');
                $('#sign-up-button').html('Sign up <i class="fas fa-sign-in ml-1"></i>');
                $(document).find('#sign-up-form').trigger("reset");
                var container = $('#login-register-modal'),
                        scrollTo = $('#scroll_div');
                container.animate({
                    scrollTop: scrollTo.offset().top - container.offset().top + container.scrollTop()
                })
                 $('.site-form-group-row').hide();
                setTimeout(function () {
                    window.location.href = `${baseURL}`;
                }, 7000);

            }
        }
    });
});

$(document).on('click', '#forgot-button', function (event) {
    event.preventDefault();
    var forgot_password=$('#forgot_password').val();
    var login_please_wait=$('#login_please_wait').val();
    $('#forgot-button').html('');
    $('#forgot-button').html(login_please_wait+'<i class="fas fa-spinner fa-spin ml-1"></i>');
    $.ajax({
        data: $('#forgot-form').serialize(),
        type: 'POST',
        url: `${baseURL}forgot_password`,
        async: true,
        success: function (res) {
            var data = JSON.parse(res);
            if (data.status == 0)
            {
                var temp = `<div class="alert alert-danger alert-dismissible fade show" id="scroll_div" role="alert">${data.msg}
                            <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="Close">
                              x
                            </a>
                          </div>`;
                $('.forgot-alert-message').html(temp);
                $('#forgot-button').html('');
                $('#forgot-button').html(forgot_password+'<i class="fas fa-sign-in ml-1"></i>');
            } else
            {
                $(document).find('.user-roles-wrapper').html('');
                var temp = `<div class="alert alert-success alert-dismissible fade show" id="scroll_div" role="alert">${data.msg}
                            <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">x</span>
                            </a>
                          </div>`;
                $('.forgot-alert-message').html(temp);
                $('#forgot-button').html('');
                $('#forgot-button').html('Forgot password <i class="fas fa-sign-in ml-1"></i>');
                $(document).find('#sign-up-form').trigger("reset");
            }
        }
    });
});

$(document).on('click', '.not-a-member', function () {
    $(document).find('.register-tab').trigger("click");

    $(document).find('.sign-up-alert-message').html('');
    $(document).find('.form-feilds-wrapper').css('display', 'block');
});

$(document).on('click', '.already-have-an-accoun', function () {
    $(document).find('.login-tab').trigger("click");
});

$(document).on('click', '.forgot-password', function () {
    $(document).find('#login-form').trigger("reset");
    $(document).find('.loginRegistrationForm').hide();
    $(document).find('.forgotPasswordForm').show();
});

$(document).on('click', '.do-you-remember-password', function () {
    $(document).find('#forgot-form').trigger("reset");
    $(document).find('.forgotPasswordForm').hide();
    $(document).find('.loginRegistrationForm').show();
});

$(document).on('click', '.login-modal-close-wrapper', function () {
    $(document).find('#login-form').trigger("reset");
    $(document).find('#sign-up-form').trigger("reset");
    $(document).find('#forgot-form').trigger("reset");
    $(document).find('.user-roles-wrapper').remove();
    $(document).find('.forgotPasswordForm').hide();
    $(document).find('.loginRegistrationForm').show();
});

$(document).on('click', '.login-tab', function () {
    $(document).find('#sign-up-form').trigger("reset");
    $(document).find('.user-roles-wrapper').remove();
    $(".modal-dialog").removeClass('modal-lg');
    $(".modal-dialog").addClass('modal-sm');
});
$(document).on('click', '.login-register-model-close-button-wrapper', function () {
    $(document).find('.form-feilds-wrapper').css('display', 'block');
    $(document).find('.login-tab').trigger("click");
});

$(document).on('click', '.register-tab', function () {
    $(document).find('#login-form').trigger("reset");
    $(".modal-dialog").removeClass('modal-sm');
    $(".modal-dialog").addClass('modal-lg');

    $(document).find('.sign-up-alert-message').html('');
    $(document).find('.form-feilds-wrapper').css('display', 'block');

});

$(document).ready(function () {
    $(document).find('.forgotPasswordForm').hide();
});
