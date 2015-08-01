<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>导入数据 | 浙江省房屋统计系统</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icon -->
    <link href="<?php echo base_url('/favicon.ico'); ?>" rel="shortcut icon" type="image/x-icon">
    <!-- StyleSheets -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-responsive.min.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/flat-ui.min.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/fineuploader.min.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/import.css'); ?>" />
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
                    <i class="fa fa-upload"></i> 导入数据
                </h2>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#upload" data-toggle="tab">上传数据</a></li>
                    <li><a href="#preview" data-toggle="tab">预览数据</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="upload">
                        <div id="jquery-wrapped-fine-uploader">
                        </div> <!-- #jquery-wrapped-fine-uploader -->
                    </div> <!-- #upload -->
                    <div class="tab-pane fade" id="preview">
                    </div> <!-- #preview -->
                </div> <!-- .tab-content -->
            </div> <!-- #content -->
        </div> <!-- #container -->
    </div> <!-- #wrapper -->
    <!-- Java Script -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/site.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/fineuploader.min.js'); ?>"></script>
    <script type="text/javascript">
        $(function() {
            $('#jquery-wrapped-fine-uploader').fineUploader({
                request: {
                    endpoint: '<?php echo base_url('/dashboard/import-data'); ?>'
                },
                text: {
                    uploadButton: '上传文件'
                }
            }).on('complete', function(event, id, file_name, result) {
                if ( result['isSuccessful'] ) {
                    $('.fileUploader-upload-fail').last().addClass('fileUploader-upload-success');
                    $('.fileUploader-upload-fail').last().removeClass('fileUploader-upload-fail');
                    $('.fileUploader-upload-status-text').last().html('文件已成功上传.');
                    $('.nav-tabs a[href="#preview"]').tab('show');
                } else {
                    $('.fileUploader-upload-status-text').last().html(result['message']);
                }
            });
        });
    </script>
</body>
</html>