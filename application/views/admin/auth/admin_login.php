<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <title>Login - Admin - TK Photography</title>
     <!-- Favicons -->
  <link href="<?=base_url('assets/img/favicon.png')?>" rel="icon">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
  <!-- Resources -->
  <link href="<?=base_url('assets/lib/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
  <link href="<?=base_url('assets/lib/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
  <link href="<?=base_url('assets/css/admin/admin_style.css');?>" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 auth-logo">
                <img height="65" src="<?=base_url('assets/img/logo.png')?>" alt="logo">
            </div>
        </div>
        <div class="row auth-push">
            <div class="col-md-2 col-xs-12"></div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="form-container">
                            <form action="" id="auth-form">
                                <div class="alert alert-danger error" style="display: none"></div>
                                <div class="form-input">
                                    <label for="email">Email</label>
                                    <input requered type="email" name="email" placeholder="Email address" class="form-control">
                                </div>
                                <div class="form-input">
                                    <label for="password">Password</label>
                                    <input requered type="password" name="password" placeholder="Password" class="form-control">
                                </div>
                                <div class="form-input auth-btn">
                                    <button type="submit" class="btn btn-success">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
            <div class="col-md-2 col-xs-12"></div>
        </div>
    </div>

    <script src="<?=base_url('assets/lib/jquery/jquery.min.js')?>"></script>
    <script src="<?=base_url('assets/lib/validate/validate.min.js')?>"></script>
    <script src="<?=base_url('assets/js/admin/auth.js')?>"></script>
</body>
</html>