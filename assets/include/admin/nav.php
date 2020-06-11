<?php
    $user_nav_details = $this->User_model->select('admin_profile', ['id'=> $_SESSION['ID']]);
    $USER_NAV_NAME = 'Admin';
    if(!empty($user_nav_details)){
        $USER_NAV_NAME = ucfirst($user_nav_details[0]->first_name);
    }
?>
<nav class="main-nav">
    <a href="<?=base_url('admin/dashboard')?>">
        <img height="45" src="<?=base_url('assets/img/logo.png')?>">
    </a>
    <ul class="nav-links">
        <li>
            <a href="<?=base_url('admin/gallery')?>">Gallery</a>
        </li>
        <li>
            <a href="<?=base_url('admin/slideshow')?>">SlideShow</a>
        </li>
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true" href="javascript:{}">
                <?=$USER_NAV_NAME?> <span class="fa fa-angle-down"></span>
            </a>
            <div class="dropdown-menu dropdown_menu account-dropdown">
                <div class="dropdown-caret">
                    <span class="caret-outer"></span>
                    <span class="caret-inner"></span>
                </div>
                <ul class="drop-menu no-space">
                    <li><a href="<?=base_url('admin/profile');?>">Profile</a></li>
                    <li><a href="<?=base_url('admin/signout');?>">Sign Out</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>