        <div id="sidebar">
            <div id="logo">
                <a href="<?php echo base_url('/'); ?>">
                    <img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Logo" />
                    浙江省房屋统计系统
                </a>
            </div> <!-- #logo -->
            <div id="sidebar-user">
                <div class="row-fluid">
                    <div class="span3">
                        <img src="<?php echo base_url('assets/img/avatar.jpg'); ?>" alt="avatar">
                    </div> <!-- .span3 -->
                    <div class="offset1 span8">
                        欢迎回来, <br>User <br>
                        <span class="label label-success">Online</span>
                    </div> <!-- .span8 -->
                </div> <!-- .row-fluid -->
            </div> <!-- #sidebar-user -->
            <div id="sidebar-nav">
                <ul class="nav">
                    <li class="nav-item primary-nav-item">
                        <a href="<?php echo base_url('/dashboard'); ?>"><i class="fa fa-dashboard"></i> 控制板</a>
                    </li>
                    <li class="nav-item primary-nav-item">
                        <a href="<?php echo base_url('/dashboard/import'); ?>"><i class="fa fa-upload"></i> 导入数据</a>
                    </li>
                    <li class="nav-item primary-nav-item">
                        <a href="<?php echo base_url('/dashboard/edit'); ?>"><i class="fa fa-edit"></i> 编辑数据</a>
                    </li>
                    <li class="nav-item primary-nav-item">
                        <a href="<?php echo base_url('/dashboard/search'); ?>"><i class="fa fa-search"></i> 查询数据</a>
                    </li>
                </ul>
            </div> <!-- #sidebar-nav -->
        </div> <!-- #sidebar -->