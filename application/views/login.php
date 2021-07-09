<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
<!--     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url('/assets/js/jquery.validate.js'); ?>"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">            
            </div>
            <div class="col-lg-6" style="margin-top:100px">   
                <div class="row">  
                    <div class="col-lg-12" style="text-align:center">  
                        <h4>Sign In</h4>          
                    </div>  
                </div>   
                <?php
                    if($this->session->flashdata('registration_success_msg')){
                        echo '<div class="alert alert-success" role="alert">
                            '.$this->session->flashdata('registration_success_msg').'
                        </div>';                       
                    }
                    if($this->session->flashdata('login_failure_msg')){
                        echo '<div class="alert alert-danger" role="alert">
                         '.$this->session->flashdata('login_failure_msg').'
                        </div>';
                    }
                ?>
                <form class="row" id="signin_form" method="post" action="<?php echo base_url('login/login'); ?>">
                    <div class="form-group col-lg-12">
                        <label for="user_email">Email</label>
                        <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Enter Email" >
                        <?php echo form_error('user_email', '<div class="error">', '</div>'); ?>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="user_password">Password</label>
                        <input type="password" class="form-control" id="user_password" name="user_password"  placeholder="Password">
                        <?php echo form_error('user_password', '<div class="error">', '</div>'); ?>                 
                    </div>
                    <div class="form-group col-lg-12">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="captcha">Captcha</label>
                                <input type="captcha" class="form-control" id="captcha" name="captcha" maxlength="5" placeholder="Captcha">
                                <?php echo form_error('captcha', '<div class="error">', '</div>'); ?>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="refresh_captcha">&nbsp;</label>
                                <div class="row">
                                    <div class="col-lg-8">
                                    <p id="image_captcha"><?php echo $captchaImg??''; ?></p>
                                    </div>
                                    <div class="col-lg-4">
                                        <a href="javascript:void(0);" id="refresh_captcha">Refresh</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" style="text-align:left">
                        <a href="<?php echo base_url('registration'); ?>" class="btn btn-danger">Registration</a>
                    </div>
                    <div class="col-lg-6" style="text-align:right">
                        <input class="btn btn-primary submit" id="login_submit" name="login_submit" type="submit" value="Sign In">
                    </div>                    
                </form>
            </div>
            
        </div>
    </div>
    
</body>
<script>
/* $.validator.setDefaults({
    submitHandler: function(form) {             
        $(form).submit(function(event){
            $('#login_submit').prop('value', 'Please wait..'); 
            $('#login_submit').prop('disabled', true);    
            event.preventDefault();
        });
    }
}); */
$(document).ready(function(){    
    $("#signin_form").validate({
        rules: {
            user_email: {    
                required: true,
                email: true
            },
            user_password: {
                required: true,
                minlength:8
            },
            captcha: "required",
        },
        messages: {
            user_email: "Please enter a valid email address",           
            user_password: {
                required: "Please enter your password",
                minlength:"Password must be atleast 8 charecters in length",
            },
            captcha: "Please enter captcha",
        }
    });
    $('#refresh_captcha').click(function() {
        $.get('<?php echo base_url('registration/captchaRefresh'); ?>', function(data){           
            $('#image_captcha').html(data);
        });
    });
});
</script>
<style>
.error {
    color: red;
}
</style>
</html>