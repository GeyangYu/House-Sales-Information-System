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
                    <div class="tab-pane fade in" id="preview">
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="alert alert-success hide"></div> <!-- .alert-error -->
                            </div> <!-- .span12 -->
                        </div> <!-- .row-fluid -->
                        <div class="row-fluid">
                            <div class="span6">
                                <select id="cities">
                                    <option value="">请选择地区</option>
                                    <option value="杭州">杭州</option>
                                    <option value="宁波">宁波</option>
                                    <option value="温州">温州</option>
                                    <option value="绍兴">绍兴</option>
                                    <option value="湖州">湖州</option>
                                    <option value="嘉兴">嘉兴</option>
                                    <option value="金华">金华</option>
                                    <option value="衢州">衢州</option>
                                    <option value="舟山">舟山</option>
                                    <option value="台州">台州</option>
                                    <option value="丽水">丽水</option>
                                </select>
                            </div> <!-- .span6 -->
                            <div class="span6">
                                <button id="import-button" class="btn btn-primary">导入数据</button>
                            </div> <!-- .span6 -->
                        </div> <!-- .row-fluid -->
                        <div class="row-fluid">
                            <div class="span12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                <label class="checkbox" for="all-records">
                                                    <input id="all-records" type="checkbox" data-toggle="checkbox">
                                                </label>
                                            </th>
                                            <th>项目类型</th>
                                            <th>项目名称</th>
                                            <th>项目地址</th>
                                            <th>幢号</th>
                                            <th>总层数</th>
                                            <th>所在层数</th>
                                            <th>房屋结构</th>
                                            <th>成交总价</th>
                                            <th>建筑面积</th>
                                            <th>签约日期</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div> <!-- .span12 -->
                        </div> <!-- .row-fluid -->
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
                    endpoint: '<?php echo base_url('/dashboard/preview-data'); ?>'
                },
                text: {
                    uploadButton: '上传文件'
                }
            }).on('complete', function(event, id, file_name, result) {
                if ( result['isSuccessful'] ) {
                    $('.fileUploader-upload-fail').last().addClass('fileUploader-upload-success');
                    $('.fileUploader-upload-fail').last().removeClass('fileUploader-upload-fail');
                    $('.fileUploader-upload-status-text').last().html('文件已成功上传.');
                    
                    displayRecords(result['data']);
                    $('.nav-tabs a[href="#preview"]').tab('show');
                } else {
                    $('.fileUploader-upload-status-text').last().html(result['message']);
                }
            });
        });
    </script>
    <script type="text/javascript">
        function displayRecords(records) {
            $('table tbody').empty();
            for ( var i = 1; i < records.length; ++ i ) {
                $('table tbody').append(getRecord(records[i]));
            }
        }
    </script>
    <script type="text/javascript">
        function getRecord(record) {
            var recordTemplate = '<tr>' +
                                 '    <td class="check-box">' +
                                 '        <label class="checkbox">' +
                                 '            <span class="icons">'+ 
                                 '                <span class="first-icon fui-checkbox-unchecked"></span>' +
                                 '                <span class="second-icon fui-checkbox-checked"></span>' +
                                 '            </span>' +
                                 '            <input type="checkbox" data-toggle="checkbox">' +
                                 '        </label>' +
                                 '    </td>' +
                                 '    <td class="project-type">%s</td>' +
                                 '    <td class="project-name">%s</td>' +
                                 '    <td class="project-address">%s</td>' +
                                 '    <td class="building-id">%s</td>' +
                                 '    <td class="building-height">%s</td>' +
                                 '    <td class="record-floor">%s</td>' +
                                 '    <td class="building-structure">%s</td>' +
                                 '    <td class="record-price">%s</td>' +
                                 '    <td class="record-area">%s</td>' +
                                 '    <td class="record-time">%s</td>' +
                                 '</tr>';
            return recordTemplate.format(record[0] == 1 ? '新建商品住宅' : '保障性住宅', record[1], record[2], record[3], 
                        record[4], record[5], record[6], record[7], record[8], record[9]);
        }
    </script>
    <script type="text/javascript">
        $('label[for=all-records]').click(function() {
            // Fix the bug for Checkbox in FlatUI 
            var isChecked = false;
            setTimeout(function() {
                isChecked = $('label[for=all-records]').hasClass('checked');
                
                if ( isChecked ) {
                    $('label.checkbox').addClass('checked');
                } else {
                    $('label.checkbox').removeClass('checked');
                }
            }, 100);
        });
    </script>
    <script type="text/javascript">
        $('#import-button').click(function() {
            var projectCity             = $('#cities').val(),
                records                 = [];
            
            if ( projectCity == '' || typeof(projectCity) == 'undefined' ) {
                alert('请选择导入数据所在的城市.');
                return;
            }

            $('#import-button').attr('disabled', 'disabled');
            $('#import-button').html('请稍后...');

            $('tr', 'table tbody').each(function() {
                var isChecked           = $('label.checkbox', $(this)).hasClass('checked'),
                    projectType         = $('.project-type', $(this)).html() == '新建商品住宅' ? '1' : '0',
                    projectName         = $('.project-name', $(this)).html(),
                    projectAddress      = $('.project-address', $(this)).html(),
                    buildingId          = $('.building-id', $(this)).html(),
                    buildingHeight      = $('.building-height', $(this)).html(),
                    buildingStructure   = $('.building-structure', $(this)).html(),
                    recordFloor         = $('.record-floor', $(this)).html(),
                    recordPrice         = $('.record-price', $(this)).html(),
                    recordArea          = $('.record-area', $(this)).html(),
                    recordTime          = $('.record-time', $(this)).html();

                if ( isChecked ) {
                    records.push({
                        'projectType': projectType,
                        'projectName': projectName,
                        'projectAddress': projectAddress,
                        'buildingId': buildingId,
                        'buildingHeight': buildingHeight,
                        'buildingStructure': buildingStructure,
                        'recordFloor': recordFloor,
                        'recordPrice': recordPrice,
                        'recordArea': recordArea,
                        'recordTime': recordTime
                    });
                }
            });

            return doImportAction(projectCity, records);
        });
    </script>
    <script type="text/javascript">
        function doImportAction(city, records) {
            var postData = {
                'city': city,
                'records': JSON.stringify(records)
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/dashboard/import-data'); ?>',
                data: postData,
                dataType: 'JSON',
                success: function(result){
                    if ( result['isSuccessful'] ) {
                        $('.alert-success').html("成功导入记录%s条.<br> 其中创建了%s条项目记录, %s条建筑记录"
                            .format(result['totalRecords'], result['totalProjects'], result['totalBuildings']));
                        $('.alert-success').removeClass('hide');
                    }

                    $('tr', 'table tbody').each(function() {
                        var isChecked           = $('label.checkbox', $(this)).hasClass('checked');
                        if ( isChecked ) {
                            $(this).remove();
                        }
                    });

                    $('#import-button').removeAttr('disabled');
                    $('#import-button').html('导入数据');
                }
            });
        }
    </script>
</body>
</html>