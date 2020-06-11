<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['about'] = 'main/about';
$route['contacts'] = 'main/contacts';

// Authentication

$route['admin'] = 'Admin/admin_auth/index';
$route['admin/login'] = 'Admin/admin_auth/login_page';
// $route['admin/register'] = 'Admin/admin_auth/register_page';
$route['admin/session'] = 'Admin/admin_auth/login';
// $route['admin/signup'] = 'Admin/admin_auth/register';
$route['admin/signout'] = 'Admin/admin_auth/logout';

// Admin Profile

$route['admin/profile'] = 'Admin/admin_profile/profile';
$route['admin/update'] = 'Admin/admin_profile/update';

// Gallery/Portfolio

$route['portfolio'] = 'gallery/index';
$route['admin/gallery'] = 'Admin/admin_gallery/gallery';
$route['admin/gallery/upload'] = 'Admin/admin_gallery/gallery_upload';

// Admin Pages

$route['admin/dashboard'] = 'Admin/admin_dashboard/dashboard';
$route['admin/slideshow'] = 'Admin/admin_slideshow/index';
$route['admin/slideshow/new'] = 'Admin/admin_slideshow/manage_slideshow';

// API

$route['api/slideshow/new'] = "Api/slideshow_api/store";
$route['api/slideshow/delete'] = "Api/slideshow_api/delete";
$route['api/contact'] = 'contact/send';

// Gallery API

$route['api/slideshow'] = "Admin/admin_slideshow/show";
$route['api/gallery'] = "gallery/show";
$route['api/gallery/upload'] = "Api/gallery_api/store";
$route['api/gallery/delete'] = "Api/gallery_api/delete";