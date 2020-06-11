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

    <div class="page_container pages about-page">
     	<div class="wrap block">
        	<div class="container">
                <section>
                    <div class="row">
                        <div class="span4">

                            <div class="hover_img">
                                <img src="<?=base_url('assets/img/featured_works/philosophy.jpg')?>" alt="" />
                            </div>
                            <h2 class="title"><span>Our Philosophy</span></h2>
                            <h5><b>"Everyone is photogenic"</b>
                            <br>
                            <div>Please don’t hesitate to contact us we wil endeavor to meet all your requirements and we assure that we capture the best moments of your life for your next generation.
                            #EveryoneIsPhotogenic</div>
                            </h5>                        
                        </div>
                        <div class="span4">

                            <div class="hover_img">
                                <img src="<?=base_url('assets/img/featured_works/mission.jpg')?>" alt="" />
                            </div>
                            <h2 class="title"><span>Our Mission</span></h2>
                        	<h5>Our mission is to document all memories and stories of magical personal events last with warmth and artistry to preserve those in your life legacy.</h5>
                        </div>
                        <div class="span4">

                            <div class="hover_img">
                                <img src="<?=base_url('assets/img/featured_works/work.jpg')?>" alt="" />
                            </div>
                            <h2 class="title"><span>What We Do</span></h2>
                        	<h5><b>TKPhotography</b> focuses on delivering high quality photographs for weddings, baby showers, graduation photography, company portfolios, modeling portfolios, family portraits, sport photography and many more.</h5> 
                        </div>                        
                    </div>
                </section>
             </div>
        </div>
    </div>
    <!--//page_container-->

    <!--//footer-->  
    <?php $removeFooter = 'hide'; require('assets/include/footer.php')?>
    <?php require('assets/include/scripts.php')?>
    
</body>
</html>

