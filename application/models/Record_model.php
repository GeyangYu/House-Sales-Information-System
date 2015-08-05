<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Record_model extends CI_Model {
    /**
     * The constructor of the class.
     */
    public function __construct() {
        parent::__construct();
        $this->load->database(); 
    }

    public function get_date_range() {
        $sql        = 'SELECT MIN(record_time) AS min_time, MAX(record_time) AS max_time '.
                      'FROM house_record';
        $result_set = $this->db->query($sql);
        return $result_set->row_array();
    }

    /**
     * 获取在某些筛选条件下成交记录的数量.
     * @param  [type] $city               - 城市
     * @param  [type] $time_lower_bound   - 起始时间(YYYY-mm-dd)
     * @param  [type] $time_upper_bound   - 结束时间(YYYY-mm-dd)
     * @param  [type] $district           - 行政区划
     * @param  [type] $block              - 板块名称
     * @param  [type] $project_name       - 项目名称
     * @param  [type] $function           - 功能区块
     * @param  [type] $building           - 幢号
     * @param  [type] $project_type       - 项目类型
     * @param  [type] $height_lower_bound - 房屋高度的下界
     * @param  [type] $height_upper_bound - 房屋高度的上界
     * @param  [type] $area_lower_bound   - 房屋面积的下界
     * @param  [type] $area_upper_bound   - 房屋面积的上界
     * @param  [type] $number             - 预售证号
     * @return 在某些筛选条件下成交记录的数量
     */
    public function get_number_of_records($city, $time_lower_bound, $time_upper_bound, 
        $district, $block, $project_name, $function, $building, $project_type, 
        $height_lower_bound, $height_upper_bound, $area_lower_bound, 
        $area_upper_bound, $number) {
        $parameters = array($city, $time_lower_bound, $time_upper_bound);
        $sql        = 'SELECT * FROM house_record '. 
                      'NATURAL JOIN house_project '.
                      'NATURAL JOIN house_building '.
                      'WHERE project_city = ? '.
                      'AND record_time >= ? AND record_time <= ?';

        $sql        = $this->get_records_sql($sql, $parameters, $district, $block, 
                        $project_name, $function, $building, $project_type, $height_lower_bound, 
                        $height_upper_bound, $area_lower_bound, $area_upper_bound, $number);

        $result_set = $this->db->query($sql, $parameters);
        return $result_set->num_rows();
    }
    
    /**
     * Get records using several conditions.
     * @param  [type] $city               - 城市
     * @param  [type] $time_lower_bound   - 起始时间(YYYY-mm-dd)
     * @param  [type] $time_upper_bound   - 结束时间(YYYY-mm-dd)
     * @param  [type] $district           - 行政区划
     * @param  [type] $block              - 板块名称
     * @param  [type] $project_name       - 项目名称
     * @param  [type] $function           - 功能区块
     * @param  [type] $building           - 幢号
     * @param  [type] $project_type       - 项目类型
     * @param  [type] $height_lower_bound - 房屋高度的下界
     * @param  [type] $height_upper_bound - 房屋高度的上界
     * @param  [type] $area_lower_bound   - 房屋面积的下界
     * @param  [type] $area_upper_bound   - 房屋面积的上界
     * @param  [type] $number             - 预售证号
     * @param  [type] $offset             [description]
     * @param  [type] $limit              [description]
     * @return [type]                     [description]
     */
    public function get_records($city, $time_lower_bound, $time_upper_bound, 
        $district, $block, $project_name, $function, $building, $project_type, 
        $height_lower_bound, $height_upper_bound, $area_lower_bound, 
        $area_upper_bound, $number, $offset, $limit) {
        $parameters = array($city, $time_lower_bound, $time_upper_bound);
        $sql        = 'SELECT * FROM house_record '. 
                      'NATURAL JOIN house_project '.
                      'NATURAL JOIN house_building '.
                      'WHERE project_city = ? '.
                      'AND record_time >= ? AND record_time <= ?';

        $sql        = $this->get_records_sql($sql, $parameters, $district, $block, 
                        $project_name, $function, $building, $project_type, $height_lower_bound, 
                        $height_upper_bound, $area_lower_bound, $area_upper_bound, $number);
        $sql       .= ' ORDER BY record_time LIMIT ?, ?';
        array_push($parameters, $offset, $limit);
        
        $result_set = $this->db->query($sql, $parameters);
        return $result_set->result_array();
    }

    /**
     * [get_records_sql description]
     * @param  [type] $base_sql           [description]
     * @param  [type] $parameters         [description]
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
     * @return [type]                     [description]
     */
    private function get_records_sql($base_sql, &$parameters, $district, $block, 
        $project_name, $function, $building, $project_type, $height_lower_bound, 
        $height_upper_bound, $area_lower_bound, $area_upper_bound, $number) {
        if ( $district != NULL ) {
            $base_sql .= ' AND project_district = ?';
            array_push($parameters, $district);
        }
        if ( $block != NULL ) {
            $base_sql .= ' AND project_block = ?';
            array_push($parameters, $block);
        }
        if ( $project_name != NULL ) {
            $base_sql .= ' AND project_name = ?';
            array_push($parameters, $project_name);
        }
        if ( $function != NULL ) {
            $base_sql .= ' AND project_function = ?';
            array_push($parameters, $function);
        }
        if ( $building != NULL ) {
            $base_sql .= ' AND building_id = ?';
            array_push($parameters, $building);
        }
        if ( $project_type != NULL ) {
            $base_sql .= ' AND project_type = ?';
            array_push($parameters, $project_type);
        }
        if ( $height_lower_bound != NULL ) {
            $base_sql .= ' AND building_height >= ?';
            array_push($parameters, $height_lower_bound);
        }
        if ( $height_upper_bound != NULL ) {
            $base_sql .= ' AND building_height <= ?';
            array_push($parameters, $height_upper_bound);
        }
        if ( $area_lower_bound != NULL ) {
            $base_sql .= ' AND record_area >= ?';
            array_push($parameters, $area_lower_bound);
        }
        if ( $area_upper_bound != NULL ) {
            $base_sql .= ' AND record_area <= ?';
            array_push($parameters, $area_upper_bound);
        }
        if ( $number != NULL ) {
            $base_sql .= ' AND project_number = ?';
            array_push($parameters, $number);
        }

        return $base_sql;
    }

    public function get_project_area($city, $time_lower_bound, $time_upper_bound, 
        $district, $block, $project_name, $function, $building, $project_type, 
        $height_lower_bound, $height_upper_bound, $area_lower_bound, 
        $area_upper_bound, $number, $group_by) {
        $parameters = array($city, $time_lower_bound, $time_upper_bound);
        $sql        = "SELECT SUM(project_area) AS project_area, $group_by ".
                      "FROM (".
                      "    SELECT DISTINCT(project_number), project_area, $group_by ".
                      "    FROM house_project ".
                      "    NATURAL JOIN house_building ".
                      ") p ".
                      "NATURAL JOIN house_project ";

        $sql        = $this->get_records_sql($sql, $parameters, $district, $block, 
                        $project_name, $function, $building, $project_type, $height_lower_bound, 
                        $height_upper_bound, $area_lower_bound, $area_upper_bound, $number);
        $sql       .= 'GROUP BY '. $group_by;

        $result_set = $this->db->query($sql, $parameters);
        // echo $this->db->last_query();
        return $result_set->result_array();
    }
    
    /**
     * [get_sold_suit description]
     * @param  [type] $city              [description]
     * @param  [type] $time_lower_bound  [description]
     * @param  [type] $time_upper_bound  [description]
     * @return [type]             [description]
     */
    public function get_sold_suit($city, $time_lower_bound, $time_upper_bound, 
        $district, $block, $project_name, $function, $building, $project_type, 
        $height_lower_bound, $height_upper_bound, $area_lower_bound, 
        $area_upper_bound, $number, $group_by) {
	    $parameters = array($city, $time_lower_bound, $time_upper_bound);
        $sql        = 'SELECT *, COUNT(*) AS sold_suit '.
                      'FROM house_record ' . 
                      'NATURAL JOIN house_project '.
                      'WHERE project_city = ? AND record_time >= ? AND record_time <= ?';
                      
        $sql        = $this->get_records_sql($sql, $parameters, $district, $block, 
                        $project_name, $function, $building, $project_type, $height_lower_bound, 
                        $height_upper_bound, $area_lower_bound, $area_upper_bound, $number);
        $sql       .= 'GROUP BY '. $group_by;

        $result_set = $this->db->query($sql, $parameters);
        return $result_set->result_array();
    }
    
    /**
     * [get_sold_price description]
     * @param  [type] $city              [description]
     * @param  [type] $time_lower_bound  [description]
     * @param  [type] $time_upper_bound  [description]
     * @return [type]             [description]
     */
    public function get_sold_price($city, $time_lower_bound, $time_upper_bound, 
        $district, $block, $project_name, $function, $building, $project_type, 
        $height_lower_bound, $height_upper_bound, $area_lower_bound, 
        $area_upper_bound, $number, $group_by) {
	    $parameters = array($city, $time_lower_bound, $time_upper_bound);
        $sql        = 'SELECT *, SUM(record_price) AS sold_price '.
                      'FROM house_record ' . 
                      'NATURAL JOIN house_project '.
                      'WHERE project_city = ? AND record_time >= ? AND record_time <= ? ';
                      
        $sql        = $this->get_records_sql($sql, $parameters, $district, $block, 
                        $project_name, $function, $building, $project_type, $height_lower_bound, 
                        $height_upper_bound, $area_lower_bound, $area_upper_bound, $number);
        $sql       .= 'GROUP BY '. $group_by;

        $result_set = $this->db->query($sql, $parameters);
        return $result_set->result_array();
    }
    
    /**
     * [get_sold_area description]
     * @param  [type] $city              [description]
     * @param  [type] $time_lower_bound  [description]
     * @param  [type] $time_upper_bound  [description]
     * @return [type]             [description]
     */
    public function get_sold_area($city, $time_lower_bound, $time_upper_bound, 
        $district, $block, $project_name, $function, $building, $project_type, 
        $height_lower_bound, $height_upper_bound, $area_lower_bound, 
        $area_upper_bound, $number, $group_by) {
	    $parameters = array($city, $time_lower_bound, $time_upper_bound);
        $sql        = 'SELECT *, SUM(record_area) AS sold_area '.
                      'FROM house_record ' . 
                      'NATURAL JOIN house_project '.
                      'WHERE project_city = ? AND record_time >= ? AND record_time <= ? ';
                      
        $sql        = $this->get_records_sql($sql, $parameters, $district, $block, 
                        $project_name, $function, $building, $project_type, $height_lower_bound, 
                        $height_upper_bound, $area_lower_bound, $area_upper_bound, $number);
        $sql       .= 'GROUP BY '. $group_by;

        $result_set = $this->db->query($sql, $parameters);
        return $result_set->result_array();
    }
    
    /**
     * 获取某个时间段内房屋的平均价格.
     * @param  String $city             - 项目所在城市
     * @param  Date   $time_lower_bound - 分析起始时间
     * @param  Date   $time_upper_bound - 分析截止时间
     * @return [type]             [description]
     */
    public function get_average_price($city, $time_lower_bound, $time_upper_bound, 
        $district, $block, $project_name, $function, $building, $project_type, 
        $height_lower_bound, $height_upper_bound, $area_lower_bound, 
        $area_upper_bound, $number, $group_by) {
	    $parameters = array($city, $time_lower_bound, $time_upper_bound);
        $sql        = 'SELECT *, AVG(record_price) AS average_price '.
                      'FROM house_record ' . 
                      'NATURAL JOIN house_project '.
                      'WHERE project_city = ? AND record_time >= ? AND record_time <= ? '; 
        
        $sql        = $this->get_records_sql($sql, $parameters, $district, $block, 
                        $project_name, $function, $building, $project_type, $height_lower_bound, 
                        $height_upper_bound, $area_lower_bound, $area_upper_bound, $number);
        $sql       .= 'GROUP BY '. $group_by;

        $result_set = $this->db->query($sql, $parameters);
        return $result_set->result_array();
    }
    
    public function get_rest_area($city, $time_upper_bound) {
        $sql        = 'SELECT b2.project_id, b2.building_id, b2.project_area - ('.
                      '    SELECT SUM(record_area) '.
                      '    FROM house_record '.
                      '    NATURAL JOIN house_building b1 '.
                      '    NATURAL JOIN house_project '.
                      '    WHERE b1.project_number = b2.project_number '.
                      '    AND project_city = ? '.
                      '    AND record_time <= ?'.
                      ') AS rest_area '.
                      'FROM house_building b2';
        $result_set = $this->db->query($sql, array($city, $time_upper_bound));
        return $result_set->result_array();  
    }
    
    /**
     * 获取截止到某个时间的库存房源.
     * @param  String $city             - 项目所在城市
     * @param  Date   $time_upper_bound - 截止时间
     * @return 该城市中截止到指定时间所有剩余房源的列表
     */
    public function get_rest_suit($city, $time_upper_bound) {
        $sql        = 'SELECT b2.project_id, b2.building_id, b2.project_total_suit - ('.
                      '    SELECT COUNT(*) '.
                      '    FROM house_record '.
                      '    NATURAL JOIN house_building b1 '.
                      '    NATURAL JOIN house_project '.
                      '    WHERE b1.project_number = b2.project_number '.
                      '    AND project_city = ? '.
                      '    AND record_time <= ?'.
                      ') AS rest_suit '.
                      'FROM house_building b2';
        $result_set = $this->db->query($sql, array($city, $time_upper_bound));
        return $result_set->result_array();  
    }

    /**
     * 创建成交记录.
     * @param  int   $project_id   - 项目ID
     * @param  int   $building_id  - 幢号
     * @param  int   $record_floor - 所在层数
     * @param  float $record_price - 成交总价
     * @param  float $record_area  - 建筑面积
     * @param  Date  $record_time  - 成交时间
     */
    public function create_record($project_id, $building_id, $record_floor, $record_price, $record_area, $record_time) {
        $record     = array(
            'project_id'    => $project_id,
            'building_id'   => $building_id,
            'record_floor'  => $record_floor,
            'record_price'  => $record_price,
            'record_area'   => $record_price,
            'record_time'   => $record_time,
        );
        return $this->db->insert('house_record', $record);
    }
}
