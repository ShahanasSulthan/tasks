<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
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
                <h4>User Home</h4>
                <h6>Subscribed for : <?php echo $userDetails['tag_name']??''; ?></h4>
            </div>
        </div>
        <div class="row" style="padding:0px 100px;min-height:500px">
            
            <div class="col-lg-12">  
                <div class="row" style="font-weight:bold;border-bottom:1px solid black;">
                    <div class="col-lg-4">
                    Title
                    </div>
                    <div class="col-lg-4">
                    Author
                    </div>
                    <div class="col-lg-4">
                    Created at
                    </div>
				</div>
                <div id='items_list' class="">

                </div>
                <!-- Paginate -->
                <div id='pagination'></div>     
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
        loadPagination(0);
        function loadPagination(page){
            var url='<?php echo base_url('userhome/loaddetails/'); ?>';
            $.ajax({
				url: url+page,
                //url:'https://hn.algolia.com/api/v1/search_by_date?&tags=story&page=2&hitsPerPage=10',
				type: 'get',
				dataType: 'json',
				success: function(response) {
                    console.log(response);
					$('#pagination').html(response.pagination);
					createTable(response.result.hits);
					
				}
			});
        }
        $('#pagination').on('click', 'a', function(e) {           
            e.preventDefault();
            var pageno = $(this).attr('data-ci-pagination-page');
            loadPagination(pageno, 'all');
            
        });
        function createTable(result) {			
			$('#items_list').empty();
            //console.log(result);
             				
			for (index in result) {
				var tr = '<div class="catalogue-item row" style="border-bottom:1px solid #dddbdb;min-height:50px">';
				tr += '<div class="col-lg-4">';
				tr += result[index].title;
				tr += '</div>';
                tr += '<div class="col-lg-4">';
				tr += result[index].author;
				tr += '</div>';
                tr += '<div class="col-lg-4">';
				tr += result[index].created_at;
				tr += '</div>';
				tr += '</div>'; 
				$('#items_list').append(tr);
			}
		}
    });
</script>
<style>
.catalogue-pagination {
	padding-top: 20px;
}
.catalogue-pagination ul {
	list-style: none;
	text-align: center;
	margin: 0px !important;
	padding: 0px !important;
}
.catalogue-pagination li {
	font-size: 13px;
	display: inline-block;
	margin: 0 5px;
}
.catalogue-pagination a {
	font-size: 13px;
	display: inline-block;
	padding: 0.2em 1em;
	line-height: 1em;
	padding: 10px;
	min-width: 13px;
	color: #222222;
	border-radius: 2em;
}
.catalogue-pagination a.current,
.catalogue-pagination a:hover {
	background-color: #f3ab01;
	color: #ffffff;
}
</style>
</html>