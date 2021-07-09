<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
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
    <div class="container-fluid">
        <div class="row" style="background: #007bc5;padding: 20px 0px;color:#ffffff">
            <div class="col-lg-8"> 
                <h4>Welcome <?php echo $userDetails['user_first_name']??''; ?></h4>
            </div>
            <div class="col-lg-4" style="text-align:right">  
                <a href="<?php echo base_url('login/logout'); ?>" class="btn btn-danger">Logout</a>
            </div>
        </div>
        <div class="row" style="margin:50px 0px">
            <div class="col-lg-12" style="text-align:center">                
                <h4>Admin Home</h4> 
                <h5>Users List</h5>                
            </div>
            <div class="col-lg-12" style="text-align:center"> 
            <?php
                if($this->session->flashdata('updation_success_msg')){
                    echo '<div class="alert alert-success" role="alert">
                        '.$this->session->flashdata('updation_success_msg').'
                    </div>';                       
                }
                if($this->session->flashdata('updation_failure_msg')){
                    echo '<div class="alert alert-danger" role="alert">
                        '.$this->session->flashdata('updation_failure_msg').'
                    </div>';
                }
            ?>
            </div>
        </div>
        <div class="row" style="padding:0px 100px;min-height:500px">            
            <div class="col-lg-12"> 
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">DOB</th>                        
                        <th scope="col">Email</th>
                        <th scope="col">Country</th>
                        <th scope="col">Subscription</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($allUserDetails) && sizeof($allUserDetails)>0){
                                $slNo=0;
                                foreach($allUserDetails as $user){
                                    $slNo++;
                                    echo '<tr>
                                    <th scope="row">'.$slNo.'</th>
                                    <td>'.$user['user_first_name'].'</td>
                                    <td>'.$user['user_last_name'].'</td>
                                    <td>'.$user['user_phone_number'].'</td>
                                    <td>'.$user['user_dob'].'</td>                                    
                                    <td>'.$user['user_email'].'</td>
                                    <td>'.$user['country_name'].'</td>
                                    <td>'.$user['tag_name'].'</td>
                                    <td><a class="btn btn-info btn-sm" href="'.base_url('adminhome/edituser/').$user['user_id'].'">Edit</a></td>
                                    <td><a class="btn btn-danger btn-sm" href="'.base_url('adminhome/deleteuser/').$user['user_id'].'">Delete</a></td>
                                    </tr>  ';
                                }
                            }
                        ?>
                                             
                    </tbody>
                </table>
            </div>    
        </div>
        <div class="row" style="margin-top:50px;background: #252525;padding: 20px 0px;color:#ffffff">
            <div class="col-lg-12" style="text-align:center"> 
                <h4>Footer</h4>
            </div>
           
        </div>
    </div>    
</body>
<script>
    $(document).ready(function(){
    });
       
</script>

</html>