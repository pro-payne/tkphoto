<!DOCTYPE html>
<html>

<head>
    <title><?=$title?></title>
    <?php require 'assets/include/admin/head_meta.php'?>
    <link rel="stylesheet" href="<?=base_url('assets/css/admin/modal.css')?>">
</head>

<body>
    <div class="container-fluid">
        <?php require 'assets/include/admin/nav.php'?>
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="breadcrumb-container">
                        <ol class="breadcrumb box-shadow">
                            <li><a href="<?=base_url('admin')?>">Home</a></li>
                            <li><a href="<?=base_url('admin/slideshow')?>">SlideShow</a></li>
                            <li class="active">New Slide</li>
                        </ol>
                    </div>
                    <div class="box">
                        <div class="box-header">
                            <div><?=$action_type?></div>
                        </div>
                        <div class="box-body">
                            <div class="event-input box-shadow">
                                <form action="" id="newResource-form">
                                    <div class="input-form">
                                        <label for="title">Title</label>
                                        <input required=""
                                            name="title" id="title" type="text" class="form-control">
                                    </div>
                                    <div class="input-form __announcement">
                                        <label for="">Image</label>
                                        <div class="custom-file-container">
                                            <label class="custom-file" for="image" title="Select an image">
                                                <div class="file-ready">
                                                    <div class="custom-file-img bg">
                                                        <img height="40" width="40" src="" alt="">
                                                    </div>
                                                    <div class="custom-file-text"></div>
                                                </div>
                                                <span>Select an image</span>
                                                <input accept="image/png, image/jpg, image/jpeg" name="image" class="_select_file" id="image" type="file">
                                            </label>
                                            <div class="file-error"></div>
                                        </div>
                                    </div>
                                    <div class="input-form input-btns">
                                        <?php
                                        if(isset($edit_data['id'])){
                                            echo '<input type="hidden" id="resource" value="'.$edit_data['id'].'" name="resource">';
                                        }
                                        ?>
                                        <a href="<?=base_url('admin/slideshow')?>"
                                            class="btn btn-default">Cancel</a>
                                        <button
                                            class="btn btn-success">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <?php require 'assets/include/admin/modals/confirm_modal.php'?>

                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <?php require 'assets/include/admin/scripts.php'?>
    <script src="<?=base_url('assets/js/admin/admin.js')?>"></script>
</body>

</html>