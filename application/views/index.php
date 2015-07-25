<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>控制板 | 浙江省房屋统计系统</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icon -->
    <link href="<?php echo base_url('/favicon.ico'); ?>" rel="shortcut icon" type="image/x-icon">
    <!-- StyleSheets -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-responsive.min.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/flat-ui.min.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>" />
    <!-- JavaScript -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.11.1.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/pace.min.js'); ?>"></script>
    <!--[if lte IE 9]>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.placeholder.min.js'); ?>"></script>
    <![endif]-->
    <!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome-ie7.min.css'); ?>" />
    <![endif]-->
    <!--[if lte IE 6]>
        <script type="text/javascript"> 
            window.location.href='<?php echo site_url(array('errors', 'not-supported')); ?>';
        </script>
    <![endif]-->
</head>
<body>
	<div id="wrapper">
        <!-- Sidebar -->
        <?php include_once('include/sidebar.php') ?>
        <div id="container">
            <!-- Header -->
            <?php include_once('include/header.php') ?>
            <!-- Content -->
            <div id="content">
                <h2 class="page-header">
                    <i class="fa fa-dashboard"></i> 控制板
                </h2>
            </div> <!-- #content -->
        </div> <!-- #container -->
    </div> <!-- #wrapper -->
    <!-- Java Script -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/site.js'); ?>"></script>
</body>
</html>