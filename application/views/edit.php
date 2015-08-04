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
                            <div class="span4 text-right">
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
                            <div class="span4 text-right">
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
    <script type="text/javascript">
        $(function() {
            getProjectConditions(1);
            getBuildingConditions(1);
        });
    </script>
    <script type="text/javascript">
        function displayPagination(paginationContainer, totalPages, currentPage) {
            var lowerBound = ( currentPage - 5 > 0 ? currentPage - 5 : 1 ),
                upperBound = ( currentPage + 5 < totalPages ? currentPage + 5 : totalPages );

            var paginationString  = '<li class="previous ' + ( currentPage > 1 ? '' : 'disabled') + '"><a href="#fakelink">&lt;</a></li>';

            for ( var i = lowerBound; i <= upperBound; ++ i ) {
                paginationString += '<li' + ( currentPage == i ? ' class="active"' : '' ) + '><a href="#">' + i + '</a></li>';
            }
            paginationString     += '<li class="next ' + ( currentPage < totalPages ? '>' : 'disabled') + '"><a href="#">&gt;</a></li>';

            $('ul', $(paginationContainer)).append(paginationString);
        }
    </script>
    <script type="text/javascript">
        $('.btn-primary', '#projects').click(function() {
            return getProjectConditions(1);
        });
    </script>
    <script type="text/javascript">
        $('#project-pagination > ul').delegate('li', 'click', function(e) {
            e.preventDefault();
            if ( $(this).hasClass('disabled') ) {
                return;
            }
            var currentPage = parseInt($('li.active > a', '#project-pagination').html());
            
            $('#project-pagination > li.active').removeClass('active');
            $(this).addClass('active');
            var pageNumber  = $('a', this).html();

            if ( pageNumber === '&lt;' ) {
                pageNumber  = currentPage - 1;
            } else if ( pageNumber === '&gt;' ) {
                pageNumber  = currentPage + 1;
            }

            return getProjectConditions(pageNumber);
        });
    </script>
    <script type="text/javascript">
        function getProjectConditions(pageNumber) {
            var city            = $('#project-city').val(),
                displayNullOnly = $('label[for=project-display-null-only]').hasClass('checked') ? 1 : 0;

            $('.btn-primary', '#projects').attr('disabled', 'disabled');
            $('.btn-primary', '#projects').html('请稍后...');
            return getProjects(city, displayNullOnly, pageNumber);
        }
    </script>
    <script type="text/javascript">
        function getProjects(city, displayNullOnly, pageNumber) {
            var request = {
                'city': city,
                'displayNullOnly': displayNullOnly,
                'page': pageNumber
            };

            $.ajax({
                type: 'GET',
                url: '<?php echo base_url('/dashboard/get-projects'); ?>',
                data: request,
                dataType: 'JSON',
                success: function(result){
                    processProjectResult(result, pageNumber);

                    $('.btn-primary', '#projects').removeAttr('disabled');
                    $('.btn-primary', '#projects').html('加载数据');
                }
            });
        }
    </script>
    <script type="text/javascript">
        function processProjectResult(result, pageNumber) {
            if ( result['isSuccessful'] ) {
                $('.table tbody', '#projects').empty();
                $('div#project-pagination > ul').empty();
                displayProjectRecords(result['projects']);
                displayPagination($('div#project-pagination'), result['totalPages'], pageNumber);

                $('.alert-error', '#projects').addClass('hide');
                $('.table', '#projects').removeClass('hide');
                $('div#project-pagination').removeClass('hide');
            } else {
                $('.table', '#projects').addClass('hide');
                $('div#project-pagination').addClass('hide');
                $('.alert-error', '#projects').removeClass('hide');
            }
        }
    </script>
    <script type="text/javascript">
        function displayProjectRecords(records) {
            $('table > tbody', '#projects').empty();

            for ( var i = 0; i < records.length; ++ i ) {
                $('table > tbody', '#projects').append(getProjectContent(records[i]));
            }
        }
    </script>
    <script type="text/javascript">
        function getProjectContent(record) {
            var projectTemplate = '<tr>' +
                                  '    <td class="project-id hide">%s</td>' +
                                  '    <td class="project-name">' +
                                  '        <div class="control-group">' +
                                  '            <input class="span12" type="text" value="%s" />' +
                                  '        </div>' +
                                  '    </td>' +
                                  '    <td class="project-type">' + 
                                  '        <select>' + 
                                  '            <option value="0"' + (record['project_type'] == '0' ? ' selected' : '') + '>保障性住宅</option>' +
                                  '            <option value="1"' + (record['project_type'] == '1' ? ' selected' : '') + '>新建商品住宅</option>' +
                                  '        </select>' +
                                  '    </td>' +
                                  '    <td class="project-address">' +
                                  '        <div class="control-group">' +
                                  '            <input class="span12" type="text" value="%s" />' +
                                  '        </div>' +
                                  '    </td>' +
                                  '    <td class="project-city">' +
                                  '        <div class="control-group">' +
                                  '            <input class="span12" type="text" value="%s" />' +
                                  '        </div>' +
                                  '    </td>' +
                                  '    <td class="project-district">' +
                                  '        <div class="control-group">' +
                                  '            <input class="span12" type="text" value="%s" />' +
                                  '        </div>' +
                                  '    </td>' +
                                  '    <td class="project-block">' +
                                  '        <div class="control-group">' +
                                  '            <input class="span12" type="text" value="%s" />' +
                                  '        </div>' +
                                  '    </td>' +
                                  '    <td class="project-function">' +
                                  '        <div class="control-group">' +
                                  '            <input class="span12" type="text" value="%s" />' +
                                  '        </div>' +
                                  '    </td>' +
                                  '</tr>';
            
            return projectTemplate.format(record['project_id'], record['project_name'], 
                    record['project_address'], record['project_city'], record['project_district'], record['project_block'], record['project_function']);
        }
    </script>
    <script type="text/javascript">
        $('.btn-primary', '#buildings').click(function() {
            return getBuildingConditions(1);
        });
    </script>
    <script type="text/javascript">
        $('#building-pagination > ul').delegate('li', 'click', function(e) {
            e.preventDefault();
            if ( $(this).hasClass('disabled') ) {
                return;
            }
            var currentPage = parseInt($('li.active > a', '#building-pagination').html());
            
            $('#building-pagination > li.active').removeClass('active');
            $(this).addClass('active');
            var pageNumber  = $('a', this).html();

            if ( pageNumber === '&lt;' ) {
                pageNumber  = currentPage - 1;
            } else if ( pageNumber === '&gt;' ) {
                pageNumber  = currentPage + 1;
            }

            return getBuildingConditions(pageNumber);
        });
    </script>
    <script type="text/javascript">
        function getBuildingConditions(pageNumber) {
            var city            = $('#building-city').val(),
                displayNullOnly = $('label[for=building-display-null-only]').hasClass('checked') ? 1 : 0;

            $('.btn-primary', '#buildings').attr('disabled', 'disabled');
            $('.btn-primary', '#buildings').html('请稍后...');
            return getBuildings(city, displayNullOnly, pageNumber);
        }
    </script>
    <script type="text/javascript">
        function getBuildings(city, displayNullOnly, pageNumber) {
            var request = {
                'city': city,
                'displayNullOnly': displayNullOnly,
                'page': pageNumber
            };

            $.ajax({
                type: 'GET',
                url: '<?php echo base_url('/dashboard/get-buildings'); ?>',
                data: request,
                dataType: 'JSON',
                success: function(result){
                    processBuildingResult(result, pageNumber);

                    $('.btn-primary', '#buildings').removeAttr('disabled');
                    $('.btn-primary', '#buildings').html('加载数据');
                }
            });
        }
    </script>
    <script type="text/javascript">
        function processBuildingResult(result, pageNumber) {
            if ( result['isSuccessful'] ) {
                $('.table tbody', '#buildings').empty();
                $('div#building-pagination > ul').empty();
                displayBuildingRecords(result['buildings']);
                displayPagination($('div#building-pagination'), result['totalPages'], pageNumber);

                $('.alert-error', '#buildings').addClass('hide');
                $('.table', '#buildings').removeClass('hide');
                $('div#building-pagination').removeClass('hide');
            } else {
                $('.table', '#buildings').addClass('hide');
                $('div#building-pagination').addClass('hide');
                $('.alert-error', '#buildings').removeClass('hide');
            }
        }
    </script>
    <script type="text/javascript">
        function displayBuildingRecords(records) {
            $('table > tbody', '#buildings').empty();

            for ( var i = 0; i < records.length; ++ i ) {
                $('table > tbody', '#buildings').append(getBuildingContent(records[i]));
            }
        }
    </script>
    <script type="text/javascript">
        function getBuildingContent(record) {
            var buildingTemplate = '<tr>' +
                                   '    <td class="project-id hide">%s</td>' +
                                   '    <td class="project-name">%s</td>' +
                                   '    <td class="building-id">%s</td>' +
                                   '    <td class="building-structure">' +
                                   '        <div class="control-group">' +
                                   '            <input class="span12" type="text" value="%s" />' +
                                   '        </div>' +
                                   '    </td>' +
                                   '    <td class="building-height">' +
                                   '        <div class="control-group">' +
                                   '            <input class="span12" type="text" value="%s" />' +
                                   '        </div>' +
                                   '    </td>' +
                                   '    <td class="project-number">' +
                                   '        <div class="control-group">' +
                                   '            <input class="span12" type="text" value="%s" />' +
                                   '        </div>' +
                                   '    </td>' +
                                   '    <td class="project-area">' +
                                   '        <div class="control-group">' +
                                   '            <input class="span12" type="text" value="%s" />' +
                                   '        </div>' +
                                   '    </td>' +
                                   '    <td class="project-total-suit">' +
                                   '        <div class="control-group">' +
                                   '            <input class="span12" type="text" value="%s" />' +
                                   '        </div>' +
                                   '    </td>' +
                                   '</tr>';

            return buildingTemplate.format(record['project_id'], record['project_name'], record['building_id'], record['building_structure'], 
                    record['building_height'], record['project_number'], record['project_area'], record['project_total_suit']);
        }
    </script>
</body>
</html>