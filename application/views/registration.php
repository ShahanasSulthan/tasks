<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
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
            <div class="col-lg-2">            
            </div>
            <div class="col-lg-8" style="margin-top:20px">                
                <h4>Registration Form</h4>
                <?php
                    if($this->session->flashdata('registration_failure_msg')){
                        echo '<div class="row"><div class="col-lg-12"><div class="alert alert-danger" role="alert">
                        '.$this->session->flashdata('registration_failure_msg').'
                        </div></div></div>'; 
                    }
                ?>
                <form class="row" id="registration_form" method="post" action="<?php echo base_url('registration/store'); ?>">
                    <div class="form-group col-lg-6">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" >
                        <?php echo form_error('first_name', '<div class="error">', '</div>'); ?>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"  placeholder="Enter Last Name">    
                        <?php echo form_error('last_name', '<div class="error">', '</div>'); ?>                    
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number"> 
                        <?php echo form_error('phone_number', '<div class="error">', '</div>'); ?>                              
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="dob">Date of Birth</label>
                        <div class="input-group date">
                            <input type="text" id="dob" name="dob" placeholder="Choose Date of Birth" class="form-control datepicker" style="width:100%">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>                    
                         </div>
                         <?php echo form_error('dob', '<div class="error">', '</div>'); ?>
                    </div>                    
                    <div class="form-group col-lg-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                        <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password"  placeholder="Password">
                        <?php echo form_error('password', '<div class="error">', '</div>'); ?>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="country">Country</label>                        
                        <select class="form-control" name="country" id="country"  name="country">
                            <?php                           
                                if(isset($countries) && sizeof($countries)>0){                                   
                                    foreach($countries as $country){
                                        $selected=$country['country_code']=='GB'?'selected':'';
                                        echo '<option '. $selected.' value="'.trim($country['country_code']).'">'.trim($country['country_name']).'</option>';
                                    }
                                }else{
                                    echo '<option>Select Country</option>';
                                }
                            ?>
                        </select>
                        <?php echo form_error('country', '<div class="error">', '</div>'); ?>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="subscription_for">Subscription For</label>
                        <select class="form-control" name="subscription_for" id="subscription_for">
                            <option value="1">Story</option>
                            <option value="2">Comment</option>
                            <option value="3">Poll</option>
                        </select>
                        <?php echo form_error('subscription_for', '<div class="error">', '</div>'); ?>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="captcha">Captcha</label>
                        <input type="captcha" class="form-control" id="captcha" name="captcha" maxlength="5" placeholder="Captcha">
                        <?php echo form_error('captcha', '<div class="error">', '</div>'); ?>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="refresh_captcha">&nbsp;</label>
                        <div class="row">
                            <div class="col-lg-6">
                            <p id="image_captcha"><?php echo $captchaImg??''; ?></p>
                            </div>
                            <div class="col-lg-6">
                                <a href="javascript:void(0);" id="refresh_captcha">Refresh</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" style="text-align:center">
                        <div class="row">
                            <div class="col-lg-6" style="text-align:left">
                                <a href="<?php echo base_url(); ?>" class="btn btn-info">Cancel</a>
                            </div>
                            <div class="col-lg-6" style="text-align:right">
                                <input class="btn btn-primary submit" type="submit" value="Submit">
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
            
        </div>
    </div>
    
</body>
<script>
/* $.validator.setDefaults({
    submitHandler: function(form) {       
        $(form).submit();
    }
}); */
$(document).ready(function(){
    $('.datepicker').datepicker({
        autoclose: true,
    });
    $("#registration_form").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            phone_number: {
                required: true,
                phoneUK:true
            },
            dob: "required",
            email: {    
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength:8
            },
            country: "required",
            subscription_for: "required",
            captcha: "required",
        },
        messages: {
            first_name: "Please enter your first name",
            last_name: "Please enter your last name",
            phone_number: {
                required: "Please enter your phone number",
                minlength: "Please enter a valid phone number",
            },
            email: "Please enter a valid email address",
            dob: "Please enter your date of birth",
            password: {
                required: "Please enter your password",
                minlength:"Password must be atleast 8 charecters in length",
            },
            country: "Please select your country",
            subscription_for: "Please select subscription",
            captcha: "Please enter captcha",
        }
    });
    jQuery.validator.addMethod('phoneUK', function(phone_number, element) {
        return this.optional(element) || phone_number.length > 9 &&
            phone_number.match(/^(\(?(0|\+44)[1-9]{1}\d{1,4}?\)?\s?\d{3,4}\s?\d{3,4})$/);
        }, 'Please enter a valid phone number'
    );
    $('#refresh_captcha').click(function() {
        $.get('<?php echo base_url('registration/captchaRefresh'); ?>', function(data){           
            $('#image_captcha').html(data);
        });
    });
});
</script>
<style>
.datepicker
.table-condensed {
    width: 300px;
    height:300px;
}
.error {
    color: red;
}
</style>
</html>