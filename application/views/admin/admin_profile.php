<!DOCTYPE html>
<html>

<head>
    <title><?=$title?></title>
    <?php require 'assets/include/admin/head_meta.php'?>
</head>

<body>
    <div class="container-fluid">
        <?php require 'assets/include/admin/nav.php'?>
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="breadcrumb-container">
                        <ol class="breadcrumb box-shadow">
                            <li><a href="<?=base_url('admin')?>">Home</a></li>
                            <li class="active">Profile</li>
                        </ol>
                    </div>
                    <div class="box">
                        <div class="box-header">
                            <div>Profile</div>
                        </div>
                        <div class="box-body">
                            <div class="event-input box-shadow">
                                <form action="" id="account-form">
                                    <div class="row input-form">
                                        <div class="col-md-6">
                                            <label for="">First Name</label>
                                            <input type="text" name="firstname"
                                                value="<?=(isset($profile['fname'])?$profile['fname']:'')?>"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Last Name</label>
                                            <input type="text" name="lastname"
                                                value="<?=(isset($profile['lname'])?$profile['lname']:'')?>"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="input-form">
                                        <label for="">Email</label>
                                        <input type="email" name="email" value="<?=(isset($profile['email'])?$profile['email']:'')?>"
                                            class="form-control">
                                    </div>
                                    <div class="input-form input-btns">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <?php require 'assets/include/admin/scripts.php'?>
    <script src="<?=base_url('assets/lib/validate/validate.min.js')?>"></script>
    <script src="<?=base_url('assets/js/admin/auth.js')?>"></script>
</body>

</html>