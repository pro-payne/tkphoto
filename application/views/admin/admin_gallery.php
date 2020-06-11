<!DOCTYPE html>
<html>
<head>
    <title><?=$title?></title>
    <?php require 'assets/include/admin/head_meta.php'?>
    <link rel="stylesheet" href="<?=base_url('assets/include/gallery/assets/gallery.css')?>">
</head>
<body>
    <div class="container-fluid admin">
        <?php require 'assets/include/admin/nav.php'?>
        <?php include 'assets/include/gallery/gallery.php'?>
    </div>
    <!-- Scripts -->
    <?php require 'assets/include/admin/scripts.php'?>
    <script src="<?=base_url('assets/lib/mustache/mustache.js');?>"></script>
    <script src="<?=base_url('assets/include/gallery/assets/gallery.js');?>"></script>
    <script src="<?=base_url('assets/include/gallery/assets/view_box.js')?>"></script>
</body>
</html>