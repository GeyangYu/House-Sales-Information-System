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
                    <i class="fa fa-search"></i> 查询数据
                </h2>
                <div id="conditions" class="section">
                    <div class="header">
                        <h5>筛选条件</h5>
                        <button class="btn btn-primary">筛选</button>
                        <button class="btn btn-info">收起</button>
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
                            <div class="span3">
                                <label for="district">行政区划</label>
                                <div class="control-group">
                                    <input id="district" class="span12" type="text" />
                                </div> <!-- .control-group -->
                            </div> <!-- .span3 -->
                        </div> <!-- .row-fluid -->
                        <div class="row-fluid">
                            <div class="span3">
                                <label for="block">行政区划</label>
                                <div class="control-group">
                                    <input id="block" class="span12" type="text" />
                                </div> <!-- .control-group -->
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label for="project-name">项目名称</label>
                                <div class="control-group">
                                    <input id="project-name" class="span12" type="text" />
                                </div> <!-- .control-group -->
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label for="function">功能区块</label>
                                <div class="control-group">
                                    <input id="function" class="span12" type="text" />
                                </div> <!-- .control-group -->
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label for="building">幢号</label>
                                <div class="control-group">
                                    <input id="building" class="span12" type="text" />
                                </div> <!-- .control-group -->
                            </div> <!-- .span3 -->
                        </div> <!-- .row-fluid -->
                        <div class="row-fluid">
                            <div class="span3">
                                <label for="project-type">项目类型</label>
                                <select id="project-type">
                                    <option value=""></option>
                                    <option value="0">保障性住宅</option>
                                    <option value="1">新建商品住宅</option>
                                </select>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label for="height-type">房屋类型</label>
                                <select id="height-type">
                                    <option value=""></option>
                                    <option value="多层住宅">多层住宅</option>
                                    <option value="小高层">小高层</option>
                                    <option value="高层">高层</option>
                                    <option value="别墅">别墅</option>
                                    <option value="跃层">跃层</option>
                                </select>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label for="area-type">房屋面积类型</label>
                                <select id="area-type">
                                    <option value=""></option>
                                    <option value="90平方米以下">90平方米以下</option>
                                    <option value="90-144平方米">90-144平方米</option>
                                    <option value="144平方米以上">144平方米以上</option>
                                </select>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label for="number">预售证编号</label>
                                <div class="control-group">
                                    <input id="number" class="span12" type="text" />
                                </div> <!-- .control-group -->
                            </div> <!-- .span3 -->
                        </div> <!-- .row-fluid -->
                    </div> <!-- .body -->
                </div> <!-- #conditions -->
                <div id="columns" class="section">
                    <div class="header">
                        <h5>显示列</h5>
                        <button class="btn btn-info">展开</button>
                    </div> <!-- .header -->
                    <div class="body hide">
                        <div class="row-fluid">
                            <div class="span3">
                                <label class="checkbox" for="time">
                                    <input id="column-time" type="checkbox" data-toggle="checkbox" checked> 交易时间
                                </label>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label class="checkbox" for="district">
                                    <input id="column-district" type="checkbox" data-toggle="checkbox" checked> 行政区划
                                </label>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label class="checkbox" for="block">
                                    <input id="column-block" type="checkbox" data-toggle="checkbox" checked> 板块名称
                                </label>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label class="checkbox" for="project-name">
                                    <input id="column-project-name" type="checkbox" data-toggle="checkbox" checked> 项目名称
                                </label>
                            </div> <!-- .span3 -->
                        </div> <!-- .row-fluid -->
                        <div class="row-fluid">
                            <div class="span3">
                                <label class="checkbox" for="function">
                                    <input id="column-function" type="checkbox" data-toggle="checkbox" checked> 功能区块
                                </label>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label class="checkbox" for="building">
                                    <input id="column-building" type="checkbox" data-toggle="checkbox" checked> 幢号
                                </label>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label class="checkbox" for="project-type">
                                    <input id="column-project-type" type="checkbox" data-toggle="checkbox" checked> 项目类型
                                </label>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label class="checkbox" for="height-type">
                                    <input id="column-height-type" type="checkbox" data-toggle="checkbox" checked> 房屋类型
                                </label>
                            </div> <!-- .span3 -->
                        </div> <!-- .row-fluid -->
                        <div class="row-fluid">
                            <div class="span3">
                                <label class="checkbox" for="area-type">
                                    <input id="column-area-type" type="checkbox" data-toggle="checkbox" checked> 房屋面积类型
                                </label>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label class="checkbox" for="sold-suit">
                                    <input id="column-sold-suit" type="checkbox" data-toggle="checkbox" checked> 销售套数
                                </label>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label class="checkbox" for="sold-price">
                                    <input id="column-sold-price" type="checkbox" data-toggle="checkbox" checked> 成交总价汇总
                                </label>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label class="checkbox" for="project-area">
                                    <input id="column-project-area" type="checkbox" data-toggle="checkbox" checked> 建筑面积总和
                                </label>
                            </div> <!-- .span3 -->
                        </div> <!-- .row-fluid -->
                        <div class="row-fluid">
                            <div class="span3">
                                <label class="checkbox" for="average-price">
                                    <input id="column-average-price" type="checkbox" data-toggle="checkbox" checked> 均价
                                </label>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label class="checkbox" for="number">
                                    <input id="column-number" type="checkbox" data-toggle="checkbox" checked> 预售证号
                                </label>
                            </div> <!-- .span3 -->
                            <div class="span3">
                                <label class="checkbox" for="rest-suit">
                                    <input id="column-rest-suit" type="checkbox" data-toggle="checkbox" checked> 截止该月库存房源
                                </label>
                            </div> <!-- .span3 -->
                            <div class="span3"></div> <!-- .span3 -->
                        </div> <!-- .row-fluid -->
                    </div> <!-- .body -->
                </div> <!-- #columns -->
                <div id="main-content">
                    <div class="alert alert-error hide">暂无可用的数据.</div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="time">交易时间</th>
                                <th class="district">行政区划</th>
                                <th class="block">板块名称</th>
                                <th class="project-name">项目名称</th>
                                <th class="function">功能区块</th>
                                <th class="building">幢号</th>
                                <th class="project-type">项目类型</th>
                                <th class="height-type">房屋类型</th>
                                <th class="area-type">房屋面积类型</th>
                                <th class="sold-suit">销售套数</th>
                                <th class="sold-price">成交总价汇总</th>
                                <th class="project-area">建筑面积总和</th>
                                <th class="average-price">均价</th>
                                <th class="number">预售证号</th>
                                <th class="rest-suit">截止该月库存房源</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div id="pagination" class="pagination pagination-centered">
                        <ul></ul>
                    </div> <!-- #pagination-->
                </div> <!-- #main-content -->
            </div> <!-- #content -->
        </div> <!-- #container -->
    </div> <!-- #wrapper -->
    <!-- Java Script -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/site.js'); ?>"></script>
    <script type="text/javascript">
        $('.btn-info', '.section').click(function() {
            var container   = $(this).parent().parent(),
                isBodyShown = $('.body', $(container)).is(':visible');

            if ( isBodyShown ) {
                $(this).html('展开');
                $('.body', $(container)).slideUp();
            } else {
                $(this).html('收起');
                $('.body', $(container)).slideDown();
            }
        });
    </script>
    <script type="text/javascript">
        $('input[type=checkbox]', '#columns').change(function() {
            var columnName = $(this).attr('id').substr(7);
                isChecked  = $(this).parent().hasClass('checked');

            if ( isChecked ) {
                $('.' + columnName).removeClass('hide');
            } else {
                $('.' + columnName).addClass('hide');
            }
        });
    </script>
    <script type="text/javascript">
        $(function() {
            getCondictions(1);
        });

        $('.btn-primary', '#conditions').click(function() {
            getCondictions(1);
        });

        $('#pagination > ul').delegate('li', 'click', function(e) {
            e.preventDefault();
            if ( $(this).hasClass('disabled') ) {
                return;
            }
            var currentPage = parseInt($('li.active > a', '#pagination').html());
            
            $('#pagination > li.active').removeClass('active');
            $(this).addClass('active');
            var pageNumber  = $('a', this).html();

            if ( pageNumber === '&lt;' ) {
                pageNumber  = currentPage - 1;
            } else if ( pageNumber === '&gt;' ) {
                pageNumber  = currentPage + 1;
            }
            getCondictions(pageNumber);
        });
    </script>
    <script type="text/javascript">
        function getCondictions(pageNumber) {
            var city        = $('#city').val().trim() || null,
                startTime   = $('#start-time').val().trim() || null,
                endTime     = $('#end-time').val().trim() || null,
                district    = $('#district').val().trim() || null,
                block       = $('#block').val().trim() || null,
                projectName = $('#project-name').val().trim() || null,
                funktion    = $('#function').val().trim() || null,
                building    = $('#building').val().trim() || null,
                projectType = $('#project-type').val().trim() || null,
                heightType  = $('#height-type').val().trim() || null,
                areaType    = $('#area-type').val().trim() || null,
                number      = $('#number').val().trim() || null;

            return getRecords(city, startTime, endTime, district, block, projectName, funktion, building, projectType, heightType, areaType, number, pageNumber);
        }
    </script>
    <script type="text/javascript">
        function getRecords(city, startTime, endTime, district, block, projectName, funktion, building, projectType, heightType, areaType, number, pageNumber) {
            var request = {
                'city': city,
                'startTime': startTime,
                'endTime': endTime,
                'district': district,
                'block': block,
                'projectName': projectName,
                'function': funktion,
                'building': building,
                'projectType': projectType,
                'heightType': heightType,
                'areaType': areaType,
                'number': number,
                'page': pageNumber
            };

            $.ajax({
                type: 'GET',
                url: '<?php echo base_url('/dashboard/get-records'); ?>',
                data: request,
                dataType: 'JSON',
                success: function(result){
                    return processResult(result, pageNumber);
                }
            });
        }
    </script>
    <script type="text/javascript">
        function processResult(result, pageNumber) {
            if ( result['isSuccessful'] ) {
                $('.table tbody').empty();
                $('div#pagination > ul').empty();
                displayRecords(result['records']);
                displayPagination(result['totalPages'], pageNumber);

                $('.alert-error').addClass('hide');
                $('.table').removeClass('hide');
                $('div#pagination').removeClass('hide');
            } else {
                $('.table').addClass('hide');
                $('div#pagination').addClass('hide');
                $('.alert-error').removeClass('hide');
            }
        }
    </script>
    <script type="text/javascript">
        function displayRecords(records) {
            var numberOfRecords = records.length;

            for ( var i = 0; i < numberOfRecords; ++ i ) {
                $('.table tbody').append(getRecordContent(records[i]));
            }
        }
    </script>
    <script type="text/javascript">
        function getRecordContent(record) {
            var recordTemplate = '<tr>' +
                                 '    <td class="time %s">%s</td>' +
                                 '    <td class="district %s">%s</td>' +
                                 '    <td class="block %s">%s</td>' +
                                 '    <td class="project-name %s">%s</td>' +
                                 '    <td class="function %s">%s</td>' +
                                 '    <td class="building %s">%s</td>' +
                                 '    <td class="project-type %s">%s</td>' +
                                 '    <td class="height-type %s">%s</td>' +
                                 '    <td class="area-type %s">%s</td>' +
                                 '    <td class="sold-suit %s">%s</td>' +
                                 '    <td class="sold-price %s">%s</td>' +
                                 '    <td class="project-area %s">%s</td>' +
                                 '    <td class="average-price %s">%s</td>' +
                                 '    <td class="number %s">%s</td>' +
                                 '    <td class="rest-suit %s">%s</td>' +
                                 '</tr>';

            return recordTemplate.format(
                isColumnDisplayed('time'), record['record_time'], 
                isColumnDisplayed('district'), record['project_district'], 
                isColumnDisplayed('block'), record['project_block'], 
                isColumnDisplayed('project-name'), record['project_name'], 
                isColumnDisplayed('function'), record['project_function'], 
                isColumnDisplayed('building'), record['building_id'],
                isColumnDisplayed('project-type'), getProjectType(record['project_type']), 
                isColumnDisplayed('height-type'), getHeightType(record['building_height']), 
                isColumnDisplayed('area-type'), getAreaType(record['record_area']), 
                isColumnDisplayed('sold-suit'), record['sold_suit'], 
                isColumnDisplayed('sold-price'), parseInt(record['sold_price']).toFixed(2), 
                isColumnDisplayed('project-area'), parseInt(record['project_area']).toFixed(2), 
                isColumnDisplayed('average-price'), parseInt(record['average_price']).toFixed(2), 
                isColumnDisplayed('number'), record['project_number'], 
                isColumnDisplayed('rest-suit'), record['rest_suit']);
        }
    </script>
    <script type="text/javascript">
        function isColumnDisplayed(columnName) {
            var checkboxControl = $('#column-' + columnName);
                isChecked       = $(checkboxControl).parent().hasClass('checked');;

            return isChecked ? '' : 'hide';
        }
    </script>
    <script type="text/javascript">
        function getProjectType(projectType) {
            return projectType == 0 ? '保障性住宅' : '新建商品住宅';
        }
    </script>
    <script type="text/javascript">
        function getHeightType(height) {
            if ( height >= 2 && height <= 6 ) {
                return '多层住宅';
            } else if ( height >= 7 && height <= 11 ) {
                return '小高层';
            } else if ( height >= 12 ) {
                return '高层';
            } else if ( height >= 1.20 && height <= 1.40 ) {
                return '别墅';
            } else if ( height >= 1.40 && height <= 1.60 ) {
                return '跃层';
            }
            return '';
        }
    </script>
    <script type="text/javascript">
        function getAreaType(area) {
            if ( area < 90 ) {
                return '90平方米以下';
            } else if ( area > 144 ) {
                return '144平方米以上';
            } else {
                return '90-144平方米';
            }
        }
    </script>
    <script type="text/javascript">
        function displayPagination(totalPages, currentPage) {
            var lowerBound = ( currentPage - 5 > 0 ? currentPage - 5 : 1 ),
                upperBound = ( currentPage + 5 < totalPages ? currentPage + 5 : totalPages );

            var paginationString  = '<li class="previous ' + ( currentPage > 1 ? '' : 'disabled') + '"><a href="#fakelink">&lt;</a></li>';

            for ( var i = lowerBound; i <= upperBound; ++ i ) {
                paginationString += '<li' + ( currentPage == i ? ' class="active"' : '' ) + '><a href="#">' + i + '</a></li>';
            }
            paginationString     += '<li class="next ' + ( currentPage < totalPages ? '>' : 'disabled') + '"><a href="#">&gt;</a></li>';

            $('#pagination > ul').append(paginationString);
        }
    </script>
</body>
</html>