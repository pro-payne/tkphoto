<?php

$gallery_categories = $this->User_model->find_all('categories', 'name');
$available_years = gallery_dates();

$get_category = $this->input->get('category');
$get_category = ($get_category != null) ? strtolower(trim($get_category)) : '';

$get_year = $this->input->get('year');
$get_year = ($get_year != null) ? (int) strtolower(trim($get_year)) : '';

$_selected_title = '';
$_selected_year = '';

$gallery_type = (isset($gallery_type)) ? $gallery_type : '';

$user = (isset($user)) ? $user : '';
 ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if($user == 'admin' && $gallery_type == ''): ?>
            <div class="breadcrumb-container">
                <ol class="breadcrumb box-shadow">
                    <li><a href="<?=base_url('admin')?>">Home</a></li>
                    <li class="active">Gallery</li>
                </ol>
            </div>
            <?php endif;?>
            <div id='<?=($gallery_type == '')? '_gallery_stick':''?>' class="gallery-box">
                <div class="gallery-header">
                    <?php if($user == 'admin'): ?>
                    <div class="_cancel_select">
                        <span>&times;</span>
                    </div>
                    <?php endif;?>
                    <div>
                        <span class="<?=($gallery_type != '')? 'slideshow-header':''?>"><?= ($gallery_type == '') ? 'Category:' : 'SlideShow'?> </span>
                        <select name="category" class="__gallery_filter <?=($gallery_type != '')? 'hide':''?>" id="_gallery-category">
                            <option value="all">All pictures</option>
                            <?php
                                foreach ($gallery_categories as $gallery_category) {
                                    if ($gallery_category->codename == $get_category) {
                                        $_selected_title = $gallery_category->name;
                                        echo '<option selected="" value="' . $gallery_category->codename . '">' . $gallery_category->name . '</option>';
                                    } else {
                                        echo '<option value="' . $gallery_category->codename . '">' . $gallery_category->name . '</option>';
                                    }
                                }
                            ?>
                        </select>
                        <select class="__gallery_filter <?=($gallery_type != '')? 'hide':''?>" name="year" id="_gallery-year">
                            <option value="all">Every year</option>
                            <?php
                                foreach ($available_years as $year) {
                                    if ($year == $get_year) {
                                        $_selected_year = $year;
                                        echo '<option selected="" value="' . $year . '">' . $year . '</option>';
                                    } else {
                                        echo '<option value="' . $year . '">' . $year . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <?php if($user == 'admin'): ?>
                    <div class="gallery-upload">
                        <?php
                            if($gallery_type == ''){
                                echo '<a href="'.base_url('admin/gallery/upload').'" class="btn btn-success" role="button"><i
                                class="fa fa-upload"></i> Upload</a>';
                            }else{
                                echo '<a href="'.base_url('admin/slideshow/new').'" class="btn btn-success" role="button">New Slide</a>';
                            }
                        ?>
                    </div>
                    <div class="_gallery_delete">
                        <i class="fa fa-trash"></i>
                    </div>
                    <?php endif;?>
                </div>
                <div class="gallery-body">
                    <h3 class="<?=($gallery_type != '')? 'hide':''?>">
                        <?php
                        $__gallery_title = '';
                        if($_selected_title == ''){
                            if($_selected_year == ''){
                                $__gallery_title = "Showing all photos";
                            }else{
                                $__gallery_title = "All ". $_selected_year ." photos";
                            }                            
                        }else{
                            if($_selected_year == ''){
                                $__gallery_title = "All photos of ". $_selected_title;
                            }else{
                                $__gallery_title = "Photos of ". $_selected_title ." for " . $_selected_year;
                            }
                        }
                        echo $__gallery_title;
                        ?>
                    </h3>
                    <div class="photo-container">
                        <!-- Ghost -->
                        <div class="photo-section gallery-ghost" style="display:none">
                            <div class="photos">
                                <ul class="photo-list"></ul>
                            </div>
                            <div class="h3">
                                <div></div>
                            </div>
                        </div>
                        <!-- end: Ghost -->

                        <div id="empty_gallery" class="empty-gallery" style="display:none">
                            <div class="empty-image">
                                <img id="_empty_gall" src="<?=base_url('assets/include/gallery/assets/img/gallery.png')?>" alt="empty gallery">
                                <img id="_empty_error" src="<?=base_url('assets/include/gallery/assets/img/unavailable.png')?>"
                                    alt="gallery error">
                            </div>
                            <div class="empty-text"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="visibility: hidden;height: 0; width: 0;position: absolute;">
    <img class="hide" src="<?=base_url('assets/img/placeholder.png')?>" alt="">
</div>
<!-- Preview -->
   <?php require 'preview.php';?>
<!-- end: Preview -->
<?php 
    if($user == 'admin'){
        require 'assets/include/admin/modals/confirm_modal.php';
    }
?>

<script id="section_temp" type="text/html">
<div class="photo-section _target">
    <div class="photos">
        <ul class="photo-list {{randId}}"></ul>
    </div>
    <div class="h3">
        <div>
            <div class="section-check"><i class="fa fa-check-circle"></i></div>
            <div>{{year}}</div>
        </div>
    </div>
</div>
</script>
<script id="item_temp" type="text/html">
<li id="{{token}}_{{id}}">
    <div class="photo-selector" role="checkbox">
        <i class="fa fa-check-circle"></i>
    </div>
    <div class="image-view"></div>
    <div>
        <input type="hidden" class="_image-date" value="{{date}}">
        <input type="hidden" class="_image-id" value="{{id}}">
        <input type="hidden" class="_image-title" value="{{title}}">
        <div class="_image-descrip hide">{{descrip}}</div>
    </div>
    <div class="image">
        <img class="lazy-image lazy" data-src="{{url}}" src="<?=base_url('assets/img/placeholder.png')?>" alt="{{title}}">
    </div>
</li>
</script>