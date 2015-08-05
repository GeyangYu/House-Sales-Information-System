<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The default controller of the application.
 */
class Dashboard extends CI_Controller {
    /**
     * The contructor of the class.
     */
    public function __construct() {
        parent::__construct();
        
        $this->load->helper('url');

        $this->load->model('Building_model');
        $this->load->model('Project_model');
        $this->load->model('Record_model');
    }

    /**
     * Render to the dashboard page.
     */
    public function index() {
        $data = array(
        );
        $this->load->view('index', $data);
    }

    /**
     * Render to the import page.
     */
    public function import() {
        $this->load->view('import');
    }

    /**
     * 处理上传和预览数据的请求.
     * @return 包含上传数据结果的JSON数据
     */
    public function preview_data() {
        $upload_result = $this->upload_files();
        $import_result = array(
            'isSuccessful'  => true,
            'data'          => array()
        );

        if ( $upload_result['isSuccessful'] ) {
            $file_path              = $upload_result['message'];
            $import_result['data']  = $this->get_data_from_excel($file_path);
        }
        $result        = array(
            'isSuccessful'  => $upload_result['isSuccessful'] && $import_result['isSuccessful'],
            'message'       => $upload_result['message'],
            'data'          => $import_result['data'],
        );

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($result));
    }

    /**
     * 上传需要导入的数据文件.
     * @return 数据上传结果
     */
    private function upload_files() {
        $config['upload_path']      = './application/uploads/';
        $config['allowed_types']    = 'xls|xlsx';
        $config['max_size']         = '1024';
        $this->load->library('lib_upload', $config);

        return $this->lib_upload->do_upload();
    }

    /**
     * 从Excel读取文件内容.
     * @param  String $file_path - Excel文件路径
     * @return Excel的文件内容, 以数组的形式返回
     */
    private function get_data_from_excel($file_path) {
        $this->load->library('lib_excel');
        return $this->lib_excel->get_data_from_excel($file_path);
    }

    /**
     * 处理导入数据的请求.
     * @return 包含数据导入结果的JSON数据
     */
    public function import_data() {
        $city               = $this->input->post('city');
        $records            = json_decode($this->input->post('records'));

        $total_projects     = $this->import_projects($city, $records);
        $total_buildings    = $this->import_buildings($city, $records);
        $total_records      = $this->import_records($city, $records);

        $result             = array(
            'isSuccessful'      => true,
            'totalProjects'     => $total_projects,
            'totalBuildings'    => $total_buildings,
            'totalRecords'      => $total_records,
        );
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($result));
    }

    /**
     * 导入项目.
     * @param  String $city    - 项目所在城市
     * @param  Array  $records - 成交记录列表
     * @return 导入的项目数量
     */
    public function import_projects($city, $records) {
        $total_projects     = 0;
        $projects           = $this->get_project_list($city);

        foreach ( $records as $record ) {
            $project_name       = $record->projectName;
            $project_type       = $record->projectType;
            $project_address    = $record->projectAddress;
            $project_city       = $city;

            if ( !in_array( $project_name, $projects ) ) {
                $this->Project_model->create_project($project_name, $project_type, $project_address, $project_city);

                array_push($projects, $project_name);
                ++ $total_projects;
            }
        }
        return $total_projects;
    }

    /**
     * 获取某个城市的项目列表.
     * @param  String $city - 项目所在的城市
     * @return 该城市项目列表
     */
    private function get_project_list($city) {
        $result_set  = $this->Project_model->get_projects_using_city($city);
        $projects    = array();
        
        foreach ( $result_set as $row_set ) {
            array_push($projects, $row_set['project_name']);
        }
        return $projects;
    }

    /**
     * 导入建筑记录.
     * @param  String $city    - 项目所在城市
     * @param  Array  $records - 成交记录列表
     * @return 导入的建筑的数量
     */
    private function import_buildings($city, $records) {
        $total_buildings    = 0;
        $projects           = $this->get_project_map($city);
        $buildings          = $this->get_buildings_list($city);

        foreach ( $records as $record ) {
            $project_name       = $record->projectName;
            $project_id         = $projects[$project_name];
            $building_id        = $record->buildingId;
            $building_structure = $record->buildingStructure;
            $building_height    = $record->buildingHeight;

            if ( !in_array( $project_id.'-'.$building_id, $buildings ) ) {
                $this->Building_model->create_buildings($project_id, $building_id, $building_structure, $building_height);

                array_push($buildings, $project_id.'-'.$building_id);
                ++ $total_buildings;
            }
        }
        return $total_buildings;
    }

    /**
     * 获取建筑的列表.
     * @param  String $city - 建筑所在的城市
     * @return 建筑的列表
     */
    private function get_buildings_list($city) {
        $result_set  = $this->Building_model->get_buildings_using_city($city);
        $buildings   = array();
        
        foreach ( $result_set as $row_set ) {
            $project_id     = $row_set['project_id'];
            $building_id    = $row_set['building_id'];

            array_push($buildings, $project_id.'-'.$building_id);
        }
        return $buildings;
    }

    /**
     * 导入成交记录.
     * @param  String $city    - 项目所在城市
     * @param  Array  $records - 成交记录列表
     * @return 导入成交记录的数量
     */
    private function import_records($city, $records) {
        $total_records  = 0;
        $projects       = $this->get_project_map($city);

        foreach ( $records as $record ) {
            $project_name   = $record->projectName;
            $project_id     = $projects[$project_name];
            $building_id    = $record->buildingId;
            $record_floor   = $record->recordFloor;
            $record_price   = $record->recordPrice;
            $record_area    = $record->recordArea;
            $record_time    = $record->recordTime;

            $this->Record_model->create_record($project_id, $building_id, $record_floor, $record_price, $record_area, $record_time);
            ++ $total_records;
        }
        return $total_records;
    }

    /**
     * 获取某个城市项目的键值对列表.
     * 其中Key为项目名称, Value为项目的ID.
     * @param  String $city - 城市名称
     * @return 项目的键值对列表
     */
    private function get_project_map($city) {
        $result_set = $this->Project_model->get_projects_using_city($city);
        $projects   = array();

        foreach ( $result_set as $row_set ) {
            $project_id     = $row_set['project_id'];
            $project_name   = $row_set['project_name'];

            $projects[$project_name] = $project_id;
        }
        return $projects;
    }

    /**
     * Render to the edit page.
     */
    public function edit() {
        $cities         = $this->Project_model->get_cities();

        $data = array(
            'cities'    => $cities,
        );
        $this->load->view('edit', $data);
    }

    /**
     * 获取项目信息.
     * @return 一个包含项目信息的数组
     */
    public function get_projects() {
        $project_city       = $this->input->get('city');
        $display_null_only  = $this->input->get('displayNullOnly');
        $page_number        = $this->input->get('page');
        $limit              = 25;
        $offset             = $page_number <= 1 ? 0 : ($page_number - 1) * $limit;

        $number_of_projects = $this->Project_model->get_number_of_projects($project_city, $display_null_only);
        $projects           = $this->Project_model->get_projects_using_city_and_offset($project_city, $display_null_only, $offset, $limit);
        $result             = array(
            'isSuccessful'  => count($projects) > 0,
            'projects'      => $projects,
            'totalPages'    => ceil($number_of_projects / $limit),
        );

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($result));
    }

    /**
     * 获取建筑信息.
     * @return 一个包含建筑信息的数组
     */
    public function get_buildings() {
        $project_city       = $this->input->get('city');
        $display_null_only  = $this->input->get('displayNullOnly');
        $page_number        = $this->input->get('page');
        $limit              = 25;
        $offset             = $page_number <= 1 ? 0 : ($page_number - 1) * $limit;

        $number_of_buildings= $this->Building_model->get_number_of_buildings($project_city, $display_null_only);
        $buildings          = $this->Building_model->get_buildings_using_city_and_offset($project_city, $display_null_only, $offset, $limit);
        $result             = array(
            'isSuccessful'  => count($buildings) > 0,
            'buildings'     => $buildings,
            'totalPages'    => ceil($number_of_buildings / $limit),
        );

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($result));
    }

    /**
     * 处理用户更新项目信息的请求.
     * @return 项目信息的更新结果
     */
    public function update_projects() {
        $isSuccessful   = false;
        $projects       = json_decode($this->input->post('projects'));

        if ( is_array($projects) ) {
            foreach ( $projects as $project ) {
	            $project_id        = $project->projectId;
	            $project_name      = $project->projectName;
                $project_type      = $project->projectType;
                $project_address   = $project->projectAddress;
                $project_city      = $project->projectCity;
                $project_district  = $project->projectDistrict;
                $project_block     = $project->projectBlock;
                $project_function  = $project->projectFunction;	           
	           
                $this->Project_model->update_project($project_id, $project_name, $project_type, $project_address, $project_city,
                    $project_district, $project_block, $project_function, NULL);
            }
            $isSuccessful   = true;
        }

        $result = array(
            'isSuccessful'  => $isSuccessful,
        );
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($result));
    }

    /**
     * 处理用户更新建筑信息的请求.
     * @return 项目信息的更新结果
     */
    public function update_buildings() {
        $isSuccessful   = false;
        $buildings      = json_decode($this->input->post('buildings'));

        if ( is_array($buildings) ) {
            foreach ( $buildings as $building ) {
	            $project_id         = $building->projectId;                    
	            $building_id        = $building->buildingId;                             
	            $building_structure = $building->buildingStructure;
	            $building_height    = $building->buildingHeight;     
                $project_number     = $building->projectNumber;      
                $project_area       = $building->projectArea;
                $project_total_suit = $building->projectTotalSuit;
                
                $this->Building_model->update_building($project_id, $building_id, $building_structure, $building_height,
                    $project_number, $project_area, $project_total_suit); 
            }
            $isSuccessful   = true;
        }

        $result = array(
            'isSuccessful'  => $isSuccessful,
        );
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($result));
    }

    /**
     * 加载数据搜索页面.
     */
    public function search() {
        $cities         = $this->Project_model->get_cities();
        $time_period    = $this->get_time_period();

        $data = array(
            'cities'        => $cities,
            'time_period'   => $time_period,
        );
        $this->load->view('search', $data);
    }

    /**
     * 获取数据库中记录的日期的最大值和最小值.
     * @return DatePeriod对象, 包含数据的起始日期和结束日期
     */
    private function get_time_period() {
        $date_range = $this->Record_model->get_date_range();
        $min_date   = $date_range['min_time'];
        $max_date   = $date_range['max_time'];

        $start      = (new DateTime($min_date))->modify('first day of this month');
        $end        = (new DateTime($max_date))->modify('first day of next month');
        $interval   = DateInterval::createFromDateString('1 month');
        $period     = new DatePeriod($start, $interval, $end);

        return $period;
    }

    /**
     * 根据筛选条件获取指定的数据记录集, 以JSON的形式返回.
     */
    public function get_records() {
        $project_city       = $this->input->get('city');
        $start_time         = $this->input->get('startTime');
        $end_time           = $this->input->get('endTime');
        $project_district   = $this->input->get('district');
        $project_block      = $this->input->get('block');
        $project_name       = $this->input->get('projectName');
        $project_function   = $this->input->get('function');
        $building           = $this->input->get('building');
        $project_type       = $this->input->get('projectType');
        $height_type        = $this->input->get('heightType');
        $area_type          = $this->input->get('areaType');
        $number             = $this->input->get('number');
        $page_number        = $this->input->get('page');
        $group_by           = $this->get_group_by_field($this->input->get('groupBy'));

        $time_lower_bound   = (new DateTime($start_time))->modify('first day of this month')->format('Y-m-d');
        $time_upper_bound   = (new DateTime($end_time))->modify('last day of this month')->format('Y-m-d');
        $height_lower_bound = NULL;
        $height_upper_bound = NULL;
        $area_lower_bound   = NULL;
        $area_upper_bound   = NULL;
        $limit              = 50;
        $offset             = $page_number <= 1 ? 0 : ($page_number - 1) * $limit;

        if ( $height_type != NULL ) {
            if ( $height_type == '多层住宅' ) {
                $height_lower_bound = 2;
                $height_upper_bound = 6;
            } else if ( $height_type == '小高层' ) {
                $height_lower_bound = 7;
                $height_upper_bound = 11;
            } else if ( $height_type == '高层' ) {
                $height_lower_bound = 12;
            } else if ( $height_type == '别墅' ) {
                // 1.3
                $height_lower_bound = 1.20;
                $height_upper_bound = 1.40;
            } else if ( $height_type == '跃层' ) {
                // 1.5
                $height_lower_bound = 1.40;
                $height_upper_bound = 1.60;
            }
        }
        if ( $area_type != NULL ) {
            if ( $area_type == '90平方米以下' ) {
                $area_upper_bound = 89.99;
            } else if ( $area_type == '90-144平方米' ) {
                $area_lower_bound = 90;
                $area_upper_bound = 144;
            } else if ( $area_type == '144平方米以上' ) {
                $area_lower_bound = 144.01;
            }
        }

        $records            = $this->get_report_records($project_city, $time_lower_bound, $time_upper_bound, 
                                $project_district, $project_block, $project_name, $project_function, $building, $project_type, 
                                $height_lower_bound, $height_upper_bound, $area_lower_bound, 
                                $area_upper_bound, $number, $offset, $limit, $group_by);
        $number_of_records  = $this->Record_model->get_number_of_records($project_city, $time_lower_bound, 
                                $time_upper_bound, $project_district, $project_block, $project_name, $project_function, $building, 
                                $project_type, $height_lower_bound, $height_upper_bound, $area_lower_bound, 
                                $area_upper_bound, $number);
        $result             = array(
            'isSuccessful'  => count($records) != 0,
            'records'       => $records,
            'totalPages'    => ceil($number_of_records / $limit),
        );

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($result));
    }

    /**
     * 根据Web传递的参数获取数据库中的数据字段名称.
     * @param  String $group_by - 需要汇总的数据字段名称
     * @return 数据库中的数据字段名称
     */
    private function get_group_by_field($group_by) {
        if ( $group_by == 'district' ) {
            return 'project_district';
        } else if ( $group_by == 'block' ) {
            return 'project_block';
        }  else if ( $group_by == 'function' ) {
            return 'project_function';
        } else {
            return 'project_id';
        }
    }

    /**
     * 根据筛选条件获取指定的数据记录集.
     * @param  [type] $project_city       [description]
     * @param  [type] $time_lower_bound   [description]
     * @param  [type] $time_upper_bound   [description]
     * @param  [type] $project_district   [description]
     * @param  [type] $project_block      [description]
     * @param  [type] $project_name       [description]
     * @param  [type] $project_function   [description]
     * @param  [type] $building           [description]
     * @param  [type] $project_type       [description]
     * @param  [type] $height_lower_bound [description]
     * @param  [type] $height_upper_bound [description]
     * @param  [type] $area_lower_bound   [description]
     * @param  [type] $area_upper_bound   [description]
     * @param  [type] $number             [description]
     * @param  [type] $offset             [description]
     * @param  [type] $limit              [description]
     * @return [type]                     [description]
     */
    private function get_report_records($project_city, $time_lower_bound, $time_upper_bound, 
        $project_district, $project_block, $project_name, $project_function, $building, $project_type, 
        $height_lower_bound, $height_upper_bound, $area_lower_bound, 
        $area_upper_bound, $number, $offset, $limit, $group_by) {
        $records        = $this->Record_model->get_records($project_city, $time_lower_bound, $time_upper_bound, 
                            $project_district, $project_block, $project_name, $project_function, $building, $project_type, 
                            $height_lower_bound, $height_upper_bound, $area_lower_bound, 
                            $area_upper_bound, $number, $offset, $limit);
        $sold_suit      = $this->get_map_result($this->Record_model->get_sold_suit($project_city, $time_lower_bound,
        $time_upper_bound, $project_district, $project_block, $project_name, $project_function, 
        $building, $project_type, $height_lower_bound, $height_upper_bound, $area_lower_bound, 
        $area_upper_bound, $number, $group_by), 'sold_suit', $group_by);
        $sold_price     = $this->get_map_result($this->Record_model->get_sold_price($project_city, $time_lower_bound,
        $time_upper_bound, $project_district, $project_block, $project_name, $project_function, 
        $building, $project_type, $height_lower_bound, $height_upper_bound, $area_lower_bound, 
        $area_upper_bound, $number, $group_by), 'sold_price', $group_by);
        $sold_area      = $this->get_map_result($this->Record_model->get_sold_area($project_city, $time_lower_bound,
        $time_upper_bound, $project_district, $project_block, $project_name, $project_function, 
        $building, $project_type, $height_lower_bound, $height_upper_bound, $area_lower_bound, 
        $area_upper_bound, $number, $group_by), 'sold_area', $group_by);
        $average_price  = $this->get_map_result($this->Record_model->get_average_price($project_city, $time_lower_bound,
        $time_upper_bound, $project_district, $project_block, $project_name, $project_function, 
        $building, $project_type, $height_lower_bound, $height_upper_bound, $area_lower_bound, 
        $area_upper_bound, $number, $group_by), 'average_price', $group_by);
        $rest_suit      = $this->get_map_result_using_project_id_and_building_id($this->Record_model->get_rest_suit($project_city, $time_upper_bound), 'rest_suit');

        foreach ( $records as &$record ) {
            $project_id                 = $record['project_id'];
            $building_id                = $record['building_id'];
            $project_district           = $record['project_district'];
            $project_block              = $record['project_block'];
            $project_function           = $record['project_function'];

            $record['sold_suit']        = $sold_suit[$$group_by];
            $record['sold_price']       = $sold_price[$$group_by];
            $record['sold_area']        = $sold_area[$$group_by];
            $record['average_price']    = $average_price[$$group_by];
            $record['rest_suit']        = $rest_suit[$project_id][$building_id];
        }
        return $records;
    }

    /**
     * 将ResultSet返回的数组转换为Map, 以方便索引.
     * @param  Array  $result_set - 数据库查询结果
     * @param  String $key        - 结果集中的字段名(例如: sold_suit, sold_price, etc.)
     * @param  String $group_by   - 生成Map时的key, 根据什么字段GROUP BY, 那么就以该作为Map的key
     * @return [type]             [description]
     */
    private function get_map_result($result_set, $key, $group_by) {
        $map_result = array();

        foreach ( $result_set as $row_set ) {
            $group_by_key   = $row_set[$group_by];
            $value          = $row_set[$key];
            $map_result[$group_by_key] = $value;
        }
        return $map_result;
    }

    /**
     * [get_map_result description]
     * @param  [type] $result_set [description]
     * @param  [type] $key        [description]
     * @return [type]             [description]
     */
    private function get_map_result_using_project_id_and_building_id($result_set, $key) {
        $map_result = array();

        foreach ( $result_set as $row_set ) {
            $project_id     = $row_set['project_id'];
            $building_id    = $row_set['building_id'];
            $value          = $row_set[$key];
            $map_result[$project_id][$building_id] = $value;
        }
        return $map_result;
    }
}
