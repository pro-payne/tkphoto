<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        $other_styles =  '<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
                        <link href="'.base_url('assets/include/gallery/assets/gallery.css').'" rel="stylesheet" type="text/css" />'; 

        require('assets/include/head.php');
    ?>   
    <style type="text/css">
        .logo {
            width: 91px;
            height: 91px;
        }
        .menu_wrap {
            padding-top: 21px;
        }
    </style>
</head>
<body>
	 <!--header-->
   <?php require('assets/include/header.php')?>
    <!--//header-->
        
    <!--page_container-->
    <div class="page_container portfolio">
    	<?php include 'assets/include/gallery/gallery.php'?>
    </div>
    <!--//page_container-->

    <!--//footer-->  
    <script src="<?=base_url('assets/lib/jquery/jquery.min.js')?>"></script>
    <script src="<?=base_url('assets/lib/bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?=base_url('assets/lib/mustache/mustache.js');?>"></script>
    <script src="<?=base_url('assets/include/gallery/assets/gallery.js');?>"></script>
    <script src="<?=base_url('assets/include/gallery/assets/view_box.js')?>"></script>
    
</body>
</html>