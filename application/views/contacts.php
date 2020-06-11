<!DOCTYPE html>
<html lang="en">
<head>
    <?php

        require('assets/include/head.php');
    ?>     
</head>
<body>
	<!--header-->
      <?php require('assets/include/header.php')?>
    <!--//header-->
        
    <!--page_container-->
    <div class="page_container pages contact-page">
    	<div class="wrap">
        	<div class="container">
                <section>
                	<div class="row">
                    	<div>
                             <div class="span4">
                                <h2 class="title"><span>Contact Info</span></h2>
                                <div id="map">
                                    <iframe width="100%" height="310" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3351.6678938424134!2d27.432954014931184!3d-32.85404387453594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e66b12178f1a733%3A0x61b450f2ee64fece!2sIndependence+Ave%2C+Bisho%2C+5605!5e0!3m2!1sen!2sza!4v1550334815776"></iframe>
                                </div>
                                <p>Mtata, Eastern Cape<br/></p>
                                <p>Phone: 072 806 8455<br/>Email: <a href="mailto:#">info@thandikhaya.co.za</a></p>                           
                            </div>   
                        </div>
                    	<div>
                            <div class="span7">
                                <h2 class="title"><span>Get In Touch</span></h2>
                                <div class="contact_form">
                                    <div id="fields">
                                        <?php require_once('assets/include/contact_process.php')?>
                                    </div>
                                </div>                   
                            </div>    
                        </div>               	
                	</div>
                </section>
            </div>
        </div>
    </div>
    <!--//page_container-->
    
    <!--//footer-->    
    <?php $removeFooter = true;
        $border_top = 'border-top: none'; 
    require('assets/include/footer.php')?>
    <?php require('assets/include/scripts.php')?>
</body>
</html>
