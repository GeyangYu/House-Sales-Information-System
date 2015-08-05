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
     * 根据筛选条件生成SQL查询语句.
     * @param  String $base_sql   - SQL 查询语句的模板
     * @param  Array  $parameters - SQL 查询的参数列表
     * @param  Array  $conditions - 筛选条件
     * @return SQL查询语句
     */
    private function get_query_sql($base_sql, &$parameters, $conditions) {
        if ( $conditions['project_district'] != NULL ) {
            $base_sql .= ' AND project_district = ?';
            array_push($parameters, $conditions['project_district']);
        }
        if ( $conditions['project_block'] != NULL ) {
            $base_sql .= ' AND project_block = ?';
            array_push($parameters, $conditions['project_block']);
        }
        if ( $conditions['project_name'] != NULL ) {
            $base_sql .= ' AND project_name = ?';
            array_push($parameters, $conditions['project_name']);
        }
        if ( $conditions['project_function'] != NULL ) {
            $base_sql .= ' AND project_function = ?';
            array_push($parameters, $conditions['project_function']);
        }
        if ( $conditions['building_id'] != NULL ) {
            $base_sql .= ' AND building_id = ?';
            array_push($parameters, $conditions['building_id']);
        }
        if ( $conditions['project_type'] != NULL ) {
            $base_sql .= ' AND project_type = ?';
            array_push($parameters, $conditions['project_type']);
        }
        if ( $conditions['height_lower_bound'] != NULL ) {
            $base_sql .= ' AND building_height >= ?';
            array_push($parameters, $conditions['height_lower_bound']);
        }
        if ( $conditions['height_upper_bound'] != NULL ) {
            $base_sql .= ' AND building_height <= ?';
            array_push($parameters, $conditions['height_upper_bound']);
        }
        if ( $conditions['area_lower_bound'] != NULL ) {
            $base_sql .= ' AND record_area >= ?';
            array_push($parameters, $conditions['area_lower_bound']);
        }
        if ( $conditions['area_upper_bound'] != NULL ) {
            $base_sql .= ' AND record_area <= ?';
            array_push($parameters, $conditions['area_upper_bound']);
        }
        if ( $conditions['project_number'] != NULL ) {
            $base_sql .= ' AND project_number = ?';
            array_push($parameters, $conditions['project_number']);
        }
        return $base_sql;
    }

    /**
     * 获取在某些筛选条件下成交记录的数量.
     * @param  $conditions - 筛选条件
     * @return 在某些筛选条件下成交记录的数量
     */
    public function get_number_of_records($conditions) {
        $parameters = array($conditions['project_city'], $conditions['time_lower_bound'], $conditions['time_upper_bound']);
        $sql        = 'SELECT * FROM house_record '. 
                      'NATURAL JOIN house_project '.
                      'NATURAL JOIN house_building '.
                      'WHERE project_city = ? '.
                      'AND record_time >= ? AND record_time <= ?';

        $sql        = $this->get_query_sql($sql, $parameters, $conditions);

        $result_set = $this->db->query($sql, $parameters);
        return $result_set->num_rows();
    }
    
    /**
     * Get records using several conditions.
     * @param  $conditions - 筛选条件
     * @return 符合筛选结果的记录
     */
    public function get_records($conditions) {
        $parameters = array($conditions['project_city'], $conditions['time_lower_bound'], $conditions['time_upper_bound']);
        $sql        = 'SELECT * FROM house_record '. 
                      'NATURAL JOIN house_project '.
                      'NATURAL JOIN house_building '.
                      'WHERE project_city = ? '.
                      'AND record_time >= ? AND record_time <= ?';

        $sql        = $this->get_query_sql($sql, $parameters, $conditions);
        $sql       .= ' ORDER BY record_time LIMIT ?, ?';
        array_push($parameters, $conditions['offset'], $conditions['limit']);
        
        $result_set = $this->db->query($sql, $parameters);
        return $result_set->result_array();
    }

    /**
     * 获取项目的总可售面积.
     * @param  [type] $conditions [description]
     * @return [type]             [description]
     */
    public function get_project_area($conditions) {
        $parameters = array();
        $group_by   = $conditions['group_by'];

        $sql        = "SELECT c.project_area AS project_area, c.project_id AS project_id, house_building.building_id ". ($group_by == 'project_id' ? '' : ", $group_by ") .
                      "FROM ( ".
                      "    SELECT SUM(project_area) AS project_area, project_id ".
                      "    FROM ( ".
                      "        SELECT DISTINCT(project_number), project_area, project_id ".
                      "        FROM house_project ".
                      "        NATURAL JOIN house_building ".
                      "    ) p ".
                      "GROUP BY project_id ".
                      ") c ".
                      "NATURAL JOIN house_project ".
                      "NATURAL JOIN house_record ".
                      "INNER JOIN house_building ON house_building.project_id = house_project.project_id ".
                      "WHERE 1";
        $sql        = $this->get_query_sql($sql, $parameters, $conditions);

        $result_set = $this->db->query($sql, $parameters);
        return $result_set->result_array();
    }
    
    /**
     * [get_sold_suit description]
     * @param  $conditions - 筛选条件
     * @return [type]             [description]
     */
    public function get_sold_suit($conditions) {
        $parameters = array($conditions['project_city'], $conditions['time_lower_bound'], $conditions['time_upper_bound']);
        $sql        = 'SELECT *, COUNT(*) AS sold_suit '.
                      'FROM house_record ' . 
                      'NATURAL JOIN house_project '.
                      'NATURAL JOIN house_building '.
                      'WHERE project_city = ? AND record_time >= ? AND record_time <= ?';
                      
        $sql        = $this->get_query_sql($sql, $parameters, $conditions);
        $sql       .= ' GROUP BY '. $conditions['group_by'];

        $result_set = $this->db->query($sql, $parameters);
        return $result_set->result_array();
    }
    
    /**
     * [get_sold_price description]
     * @param  $conditions - 筛选条件
     * @return [type]             [description]
     */
    public function get_sold_price($conditions) {
        $parameters = array($conditions['project_city'], $conditions['time_lower_bound'], $conditions['time_upper_bound']);
        $sql        = 'SELECT *, SUM(record_price) AS sold_price '.
                      'FROM house_record ' . 
                      'NATURAL JOIN house_project '.
                      'NATURAL JOIN house_building '.
                      'WHERE project_city = ? AND record_time >= ? AND record_time <= ? ';
                      
        $sql        = $this->get_query_sql($sql, $parameters, $conditions);
        $sql       .= ' GROUP BY '. $conditions['group_by'];

        $result_set = $this->db->query($sql, $parameters);
        return $result_set->result_array();
    }
    
    /**
     * [get_sold_area description]
     * @param  $conditions - 筛选条件
     * @return [type]             [description]
     */
    public function get_sold_area($conditions) {
        $parameters = array($conditions['project_city'], $conditions['time_lower_bound'], $conditions['time_upper_bound']);
        $sql        = 'SELECT *, SUM(record_area) AS sold_area '.
                      'FROM house_record ' . 
                      'NATURAL JOIN house_project '.
                      'NATURAL JOIN house_building '.
                      'WHERE project_city = ? AND record_time >= ? AND record_time <= ? ';
                      
        $sql        = $this->get_query_sql($sql, $parameters, $conditions);
        $sql       .= ' GROUP BY '. $conditions['group_by'];

        $result_set = $this->db->query($sql, $parameters);
        return $result_set->result_array();
    }
    
    /**
     * 获取某个时间段内房屋的平均价格.
     * @param  $conditions - 筛选条件
     * @return [type]             [description]
     */
    public function get_average_price($conditions) {
        $parameters = array($conditions['project_city'], $conditions['time_lower_bound'], $conditions['time_upper_bound']);
        $sql        = 'SELECT *, AVG(record_price) AS average_price '.
                      'FROM house_record ' . 
                      'NATURAL JOIN house_project '.
                      'NATURAL JOIN house_building '.
                      'WHERE project_city = ? AND record_time >= ? AND record_time <= ? '; 
        
        $sql        = $this->get_query_sql($sql, $parameters, $conditions);
        $sql       .= ' GROUP BY '. $conditions['group_by'];

        $result_set = $this->db->query($sql, $parameters);
        return $result_set->result_array();
    }
    
    public function get_rest_area($conditions) {
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

        $result_set = $this->db->query($sql, 
            array($conditions['project_city'], $conditions['time_upper_bound']));
        return $result_set->result_array();  
    }
    
    /**
     * 获取截止到某个时间的库存房源.
     * @param  $conditions - 筛选条件
     * @return 该城市中截止到指定时间所有剩余房源的列表
     */
    public function get_rest_suit($conditions) {
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

        $result_set = $this->db->query($sql, 
            array($conditions['project_city'], $conditions['time_upper_bound']));
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
