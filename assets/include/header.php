<div class="header">
    <div class="wrap">
        <div class="navbar navbar_ clearfix">
            <div class="container">
                <div class="row">
                    <div class="span4 width-auto">
                        <div class="logo"><a href="<?=base_url()?>"><img src="<?=base_url('assets/img/logo.png')?>"
                                    alt="" /></a></div>
                    </div>
                    <nav id="main_menu">
                        <div class="menu_wrap">                            
                            <div class="desktop-nav">
                                <ul class="nav sf-menu">
                                    <li class="<?=(isset($navBar) && $navBar == 'home')? 'current':''?>"><a href="<?=base_url()?>">Home</a></li>
                                    <li class="<?=(isset($navBar) && $navBar == 'about')? 'current':''?>"><a href="<?=base_url('about')?>">About</a></li>
                                    <li class="<?=(isset($navBar) && $navBar == 'portfolio')? 'current':''?>">
                                        <a href="<?=base_url('portfolio')?>">Portfolio</a>
                                        <ul>
                                            <?php
                                                $header_categories = $this->User_model->find_all('categories', 'name');
                                                foreach($header_categories as $header_category){
                                                    echo '<li><a href="'.base_url('portfolio?category='.$header_category->codename).'"><span>-</span>'.$header_category->name.'</a></li>';
                                                }
                                            ?>
                                        </ul>
                                    </li>
                                    <li class="<?=(isset($navBar) && $navBar == 'contacts')? 'current':''?>"><a href="<?=base_url('contacts')?>">Contacts</a></li>
                                </ul>
                            </div>
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".mini-nav" aria-expanded="false">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="mobi-nav">
        <div class="collapse navbar-collapse mini-nav">
            <ul class="nav">
                <li class="<?=(isset($navBar) && $navBar == 'home')? 'current':''?>"><a href="<?=base_url()?>">Home</a></li>
                <li class="<?=(isset($navBar) && $navBar == 'about')? 'current':''?>"><a href="<?=base_url('about')?>">About</a></li>
                <li class="<?=(isset($navBar) && $navBar == 'portfolio')? 'current':''?>">
                    <a href="<?=base_url('portfolio')?>">Portfolio</a>
                </li>
                <li class="<?=(isset($navBar) && $navBar == 'contacts')? 'current':''?>"><a href="<?=base_url('contacts')?>">Contacts</a></li>
            </ul>
        </div>
    </div>
</div>