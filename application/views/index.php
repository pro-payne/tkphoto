<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        $other_styles =  '<link rel="stylesheet" id="camera-css" href="'.base_url('assets/').'css/camera.css" type="text/css" media="all">'; 

        require('assets/include/head.php');
    ?>
</head>
<body>
    <!--header-->
    <?php require('assets/include/header.php')?>
    <!--//header-->

  
      <!--page_container-->
    <div class="page_container slideshow">
        <!--slider-->
        <div id="main_slider">
            <div class="camera_wrap" id="camera_wrap_1">
                <?php
                    foreach($slides as $slide){
                        echo '<div data-src="'.$slide.'"></div> ';
                    }
                ?>
            </div><!-- #camera_wrap_1 -->
            <div class="clear"></div>
        </div>
        <!--//slider-->

        <!--Welcome-->
        <div class="wrap block">
            <div class="container welcome_block">
                <div class="welcome_line welcome_t"></div>
                <h2>RECENT WORK</h2>
                <div class="row">
                    <div class="span12">
                        <ul class="featured">
                            <?php 
                            foreach($recent as $work){
                                ?>
                                <li>
                                    <div class="hover_img">
                                        <a class="thumbnail-src" data-src="<?=base_url('assets/img/portfolio/'. $work['url'])?>" href="<?=$work['link']?>" rel="portfolio">
                                            
                                        </a>
                                    </div>
                                </li>
                                <?php                             
                            }
                            ?>
                            <li>
                                <div class="hover_img">
                                    <a href="<?=base_url('portfolio')?>" rel="">
                                        <div class="more-portfolio">
                                            <span>Go to Portfolio</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>    
                </div>
            </div>   
        </div>    
    </div>           

    <!--//footer-->
    <?php require('assets/include/footer.php')?>
    <?php require('assets/include/scripts.php')?>
    <script type="text/javascript" src="<?=base_url('assets/js/jquery.thumbnail.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/jquery.easing.1.3.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/camera.js')?>"></script>
    <script type="text/javascript">
    $(function() {
        //Slider
        $('#camera_wrap_1').camera();
        $.thumbnail({ screen: 'landing', element: '.thumbnail-src', thumbW: 500, thumbH: 500});

    });
    </script>
</body>

</html>