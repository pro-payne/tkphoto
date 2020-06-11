<meta charset="utf-8">
<title><?=(isset($title)) ? $title . " - TK Photography" : "TK Photography"?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

<link href="<?=base_url('assets/css/bootstrap.css');?>" rel="stylesheet">
<link href="<?=base_url('assets/lib/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">
<link href="<?=base_url('assets/lib/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
<link href="<?=base_url('assets/css/theme.css');?>" rel="stylesheet">
<link href="<?=base_url('assets/css/bootstrap-responsive.css');?>" rel="stylesheet">

<?= (isset($other_styles)) ? $other_styles : '' ?>

<!-- Favicon -->
<link rel="shortcut icon" href="<?=base_url('assets/img/favicon.png')?>">


<!-- Global site tag (gtag.js) - Simba Snow Sebina Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-138313564-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-138313564-1');
</script>
<!-- Global site tag (gtag.js) - Simba Snow Sebina Analytics -->

<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->