<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>编辑数据 | 浙江省房屋统计系统</title>
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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/edit.css'); ?>" />
    <!-- JavaScript -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.11.1.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/flat-ui.min.js'); ?>"></script>
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
                    <i class="fa fa-edit"></i> 编辑数据
                </h2>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#projects" data-toggle="tab">项目</a></li>
                    <li><a href="#buildings" data-toggle="tab">建筑</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="projects">
                        <div class="row-fluid">
                            <div class="span4">
                                <select id="project-city">
                                    <option value="">全部城市</option>
                                <?php foreach ( $cities as $city ): ?>
                                    <option value="<?php echo $city['city']; ?>"><?php echo $city['city']; ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div> <!-- .span4 -->
                            <div class="span4">
                                <label class="checkbox" for="project-display-null-only">
                                    <input id="project-display-null-only" type="checkbox" data-toggle="checkbox"> 只显示包含空字段的记录
                                </label>
                            </div> <!-- .span4 -->
                            <div class="span4">
                                <button class="btn btn-primary">加载数据</button>
                                <button class="btn btn-info">更新数据</button>
                            </div> <!-- .span4 -->
                        </div> <!-- row-fluid -->
                        <div class="row-fluid">
                            <div class="alert alert-error">暂无符合条件的记录.</div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="project-id hide">项目ID</th>
                                        <th class="project-name">项目名称</th>
                                        <th class="project-type">项目类型</th>
                                        <th class="project-address">项目地址</th>
                                        <th class="project-city">所在城市</th>
                                        <th class="project-district">行政区划</th>
                                        <th class="project-block">板块名称</th>
                                        <th class="project-function">功能区块</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div id="project-pagination" class="pagination pagination-centered">
                                <ul></ul>
                            </div> <!-- #pagination-->
                        </div> <!-- row-fluid -->
                    </div> <!-- #projects -->
                    <div class="tab-pane fade in" id="buildings">
                        <div class="row-fluid">
                            <div class="span4">
                                <select id="building-city">
                                    <option value="">全部城市</option>
                                <?php foreach ( $cities as $city ): ?>
                                    <option value="<?php echo $city['city']; ?>"><?php echo $city['city']; ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div> <!-- .span4 -->
                            <div class="span4">
                                <label class="checkbox" for="building-display-null-only">
                                    <input id="building-display-null-only" type="checkbox" data-toggle="checkbox"> 只显示包含空字段的记录
                                </label>
                            </div> <!-- .span4 -->
                            <div class="span4">
                                <button class="btn btn-primary">加载数据</button>
                                <button class="btn btn-info">更新数据</button>
                            </div> <!-- .span4 -->
                        </div> <!-- row-fluid -->
                        <div class="row-fluid">
                            <div class="alert alert-error">暂无符合条件的记录.</div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="project-id hide">项目ID</th>
                                        <th class="project-name">项目名称</th>
                                        <th class="building-id">幢号</th>
                                        <th class="building-structure">房屋结构</th>
                                        <th class="building-height">总层数</th>
                                        <th class="project-number">预售证号</th>
                                        <th class="project-area">总可售面积</th>
                                        <th class="project-total-suit">总可售套数</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div id="building-pagination" class="pagination pagination-centered">
                                <ul></ul>
                            </div> <!-- #pagination-->
                        </div> <!-- row-fluid -->
                    </div> <!-- #buildings -->
            </div> <!-- #content -->
        </div> <!-- #container -->
    </div> <!-- #wrapper -->
    <!-- Java Script -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/site.js'); ?>"></script>
</body>
</html>