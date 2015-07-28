<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>查询数据 | 浙江省房屋统计系统</title>
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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/search.css'); ?>" />
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
                    <i class="fa fa-search"></i> 查询数据
                </h2>
                <div id="conditions">
                    <div class="header">
                        <h5>筛选条件</h5>
                        <a href="javascript:void(0);">
                        </a>
                    </div> <!-- .header-->
                    <div class="body">
                        <div class="row-fluid">
                            <div class="span3">
                                <label for="city">城市</label>
                                <select id="city">
                                <?php foreach ( $cities as $city ): ?>
                                    <option value="<?php echo $city['city']; ?>"><?php echo $city['city']; ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label for="start-time">起始时间</label>
                                <select id="start-time">
                                <?php foreach ( $time_period as $date ): ?>
                                    <option value="<?php echo $date->format("Y-m"); ?>"><?php echo $date->format('Y年m月'); ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label for="end-time">结束时间</label>
                                <select id="end-time">
                                <?php foreach ( $time_period as $date ): ?>
                                    <option value="<?php echo $date->format("Y-m"); ?>"><?php echo $date->format('Y年m月'); ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div> <!-- .span3 -->
                        </div> <!-- .row-fluid -->

                    </div> <!-- .body -->
                </div> <!-- #conditions -->
                <div id="columns">
                    <div class="header">
                        <h5></h5>
                    </div> <!-- .header -->
                    <div class="body">
                        
                    </div> <!-- .body -->
                </div> <!-- #columns -->
                <div id="main-content">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="city">城市</th>
                                <th class="year">年份</th>
                                <th class="month">月份</th>
                                <th class="district">行政区划</th>
                                <th class="block">板块名称</th>
                                <th class="project-name">项目名称</th>
                                <th class="function">功能区块</th>
                                <th class="building">幢号</th>
                                <th class="project-type">项目类型</th>
                                <th class="height-type">房屋类型</th>
                                <th class="area-type">房屋面积类型</th>
                                <th class="number">预售证号</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div> <!-- #main-content -->
            </div> <!-- #content -->
        </div> <!-- #container -->
    </div> <!-- #wrapper -->
    <!-- Java Script -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/site.js'); ?>"></script>
    <script type="text/javascript">
        function getRecords(city, year, month, district, block, projectName, funktion, building, projectType, heightType, areaType, number) {
            var request = {
                'city': city,
                'year': year,
                'month': month,
                'district': district,
                'block': block,
                'projectName': projectName,
                'function': funktion,
                'building': building,
                'projectType': projectType,
                'heightType': heightType,
                'areaType': areaType,
                'number': number
            };

            $.ajax({

            });
        }
    </script>
</body>
</html>