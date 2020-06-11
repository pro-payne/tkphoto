<!DOCTYPE html>
<html>

<head>
    <title><?=$title?></title>
    <?php require 'assets/include/admin/head_meta.php';?>
    <link rel="stylesheet" href="<?=base_url('assets/css/admin/modal.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/lib/datepicker/datepicker.css')?>">
</head>

<body>
    <div class="container-fluid">
        <?php require 'assets/include/admin/nav.php';?>
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="breadcrumb-container">
                        <ol class="breadcrumb box-shadow">
                            <li><a href="<?=base_url('admin')?>">Home</a></li>
                            <li><a href="<?=base_url('admin/gallery')?>">Gallery</a></li>
                            <li class="active">Upload</li>
                        </ol>
                    </div>
                    <div class="box">
                        <div class="box-header">
                            <div>Gallery Upload</div>
                        </div>
                        <div class="box-body">
                            <div class="event-input box-shadow">
                                <form action="" id="uploadForm">
                                    <div class="input-form">
                                        <label for="caption">Caption</label>
                                        <input type="text" required="" class="form-control" name="caption" id="caption" placeholder="Image caption">
                                    </div>
                                    <div class="input-form">
                                        <label for="category">Category</label>
                                        <select required="" name="category" id="category">
                                            <option value="">Select category</option>
                                            <?php 
                                                foreach($categories as $category){
                                                    $category_name = $category->name;
                                                    echo "<option class='__event' value='".$category->id."'>".ucfirst($category_name)."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="input-form gallery-select">
                                        <label>Select Image(s) <span id="_sizeCount"></span> <label id="add-more" for="image"
                                                class="btn btn-success btn-sm">Add Image</label></label>
                                        <div class="custom-file-container">
                                            <label class="custom-file" for="image" title="Select image(s)">
                                                <div class="file-ready"></div>
                                                <div class="custom-file-title">
                                                    <span>Select files</span>
                                                </div>
                                                <input multiple="" maxlength="5"
                                                    accept="image/png, image/jpg, image/jpeg" name="images[]"
                                                    class="_select_file" id="image" type="file">
                                            </label>
                                            <div class="file-error"></div>
                                        </div>
                                        <div class="input-info">
                                            All file size combined shouldn't exceed 8MB, keep checking size count above
                                        </div>
                                    </div>
                                    <div class="input-form custom-label">
                                        <label class="accordion">Advanced Image Options <i class="fa fa-angle-down"></i></label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="date_taken">Date Taken</label>
                                                <input name="date_taken" id="date_taken" type="text"
                                                    placeholder="Date image was taken" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-form input-btns">
                                        <a href="<?=base_url('admin/gallery')?>" class="btn btn-default">Cancel</a>
                                        <button id="submit-form" type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <?php require 'assets/include/admin/scripts.php'?>
    <script src="<?=base_url('assets/lib/datepicker/bootstrap-datepicker.js')?>"></script>
    <script>
        $(function(){
            $('#date_taken').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
    <script src="<?=base_url('assets/js/admin/admin_gallery.js')?>"></script>
</body>

</html>