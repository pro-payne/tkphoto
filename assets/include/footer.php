<div id="footer" style="<?=isset($border_top)?$border_top:''?>">
    <?php if(!isset($removeFooter)):?>
    <div class="wrap">
        <div class="container welcome_block">
            <div class="welcome_line welcome_t"></div>
            <h2>MEET THANDIKHAYA</h2>

            <div class="container">
                <div class="row">
                    <div class="span5">
                        <div class="contact-img">
                            <img src="<?=base_url('assets/')?>img/tk-photo.jpg" alt="Photo of TK" />
                        </div>
                    </div>

                    <div class="col">
                        <div class="span6">
                            <div class="post_carousel">
                                <p>
                                    Tkphotography is a Thandikaya Matokazi owned photography business based in Mthatha town in the Eastern Cape. Tkphotography is passionate about capturing your good and beautiful moments. The business focuses on the themes of photography such as weddings, baby showers, graduation photography, company portfolios, modeling portfolios, family portraits, sport photography and many more.
                                </p>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="span6 contact">
                            <div>
                                <?php require_once('assets/include/contact_process.php');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="footer_bottom">
        <div class="wrap">
            <div class="container">
                <div class="row2">
                    <div class="span4">
                        <div class="footer-social">
                            <a class="facebook" href="https://mobile.facebook.com/doozieMagazine/">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a class="instagram" href="https://www.instagram.com/tkphotography_doozie/?hl=en">
                                <i class="fa fa-instagram"></i>
                            </a>
                            <a class="twitter" href="https://twitter.com/TkphotographyV">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </div>
                        <div class="copyright">&copy; 2019 TK PHOTOGRAPHY. All Rights Reserved.
                        </div>
                    </div>
 
                </div>
            </div>
        </div>
    </div>
</div>