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
        $data = array(

        );
        $this->load->view('import', $data);
    }

    /**
     * Render to the edit page.
     */
    public function edit() {
        $data = array(

        );
        $this->load->view('edit', $data);
    }

    /**
     * Render to the search page.
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
     * [get_time_period description]
     * @return [type] [description]
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
     * [get_records description]
     */
    public function get_records() {
        $city               = $this->input->get('city');
        $start_time         = $this->input->get('startTime');
        $end_time           = $this->input->get('endTime');
        $district           = $this->input->get('district');
        $block              = $this->input->get('block');
        $project_name       = $this->input->get('projectName');
        $function           = $this->input->get('function');
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

        $records            = $this->get_report_records($city, $time_lower_bound, $time_upper_bound, 
                                $district, $block, $project_name, $function, $building, $project_type, 
                                $height_lower_bound, $height_upper_bound, $area_lower_bound, 
                                $area_upper_bound, $number, $offset, $limit, $group_by);
        $number_of_records  = $this->Record_model->get_number_of_records($city, $time_lower_bound, 
                                $time_upper_bound, $district, $block, $project_name, $function, $building, 
                                $project_type, $height_lower_bound, $height_upper_bound, $area_lower_bound, 
                                $area_upper_bound, $number);
        $result             = array(
            'isSuccessful'  => count($records) != 0,
            'records'       => $records,
            'totalPages'    => ceil($number_of_records / $limit),
        );

        echo json_encode($result);
    }

    private function get_group_by_field($group_by) {
        if ( $group_by == 'district' ) {
            return 'district';
        } else if ( $group_by == 'block' ) {
            return 'block';
        }  else if ( $group_by == 'function' ) {
            return 'function';
        } else {
            return 'project_id';
        }
    }

    /**
     * [get_report_records description]
     * @param  [type] $city               [description]
     * @param  [type] $time_lower_bound   [description]
     * @param  [type] $time_upper_bound   [description]
     * @param  [type] $district           [description]
     * @param  [type] $block              [description]
     * @param  [type] $project_name       [description]
     * @param  [type] $function           [description]
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
    private function get_report_records($city, $time_lower_bound, $time_upper_bound, 
        $district, $block, $project_name, $function, $building, $project_type, 
        $height_lower_bound, $height_upper_bound, $area_lower_bound, 
        $area_upper_bound, $number, $offset, $limit, $group_by) {
        $records        = $this->Record_model->get_records($city, $time_lower_bound, $time_upper_bound, 
                            $district, $block, $project_name, $function, $building, $project_type, 
                            $height_lower_bound, $height_upper_bound, $area_lower_bound, 
                            $area_upper_bound, $number, $offset, $limit);
        $sold_suit      = $this->get_map_result($this->Record_model->get_sold_suit($city, $time_lower_bound, $time_upper_bound, $group_by), 'sold_suit', $group_by);
        $sold_price     = $this->get_map_result($this->Record_model->get_sold_price($city, $time_lower_bound, $time_upper_bound, $group_by), 'sold_price', $group_by);
        $sold_area      = $this->get_map_result($this->Record_model->get_sold_area($city, $time_lower_bound, $time_upper_bound, $group_by), 'sold_area', $group_by);
        $average_price  = $this->get_map_result($this->Record_model->get_average_price($city, $time_lower_bound, $time_upper_bound, $group_by), 'average_price', $group_by);
        $rest_suit      = $this->get_map_result_using_project_id_and_building_id($this->Record_model->get_rest_suit($city, $time_upper_bound), 'rest_suit');

        foreach ( $records as &$record ) {
            $project_city               = $record['project_city'];
            $project_id                 = $record['project_id'];
            $building_id                = $record['building_id'];

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
