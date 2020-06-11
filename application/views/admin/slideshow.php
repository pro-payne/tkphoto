<!DOCTYPE html>
<html class="__slideshow">

<head>
    <title><?=$title?></title>
    <?php require 'assets/include/admin/head_meta.php'?>
    <link rel="stylesheet" href="<?=base_url('assets/css/admin/modal.css')?>">
    <link href="<?=base_url('assets/include/gallery/assets/gallery.css')?>" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container-fluid admin">
        <?php require 'assets/include/admin/nav.php'?>
        <div>
            <div class="container">
                <div class="breadcrumb-container">
                    <ol class="breadcrumb box-shadow">
                        <li><a href="<?=base_url('admin')?>">Home</a></li>
                        <li class="active">SlideShow</li>
                    </ol>
                </div>
            </div>
            <?php
            $gallery_type = 'slideshow';
             include 'assets/include/gallery/gallery.php'?>
        </div>
    </div>


    <!-- Scripts -->
    <?php require 'assets/include/admin/scripts.php'?>
    <script src="<?=base_url('assets/lib/mustache/mustache.js');?>"></script>
    <script src="<?=base_url('assets/include/gallery/assets/gallery.js');?>"></script>
    <script src="<?=base_url('assets/include/gallery/assets/view_box.js')?>"></script>
</body>

</html>