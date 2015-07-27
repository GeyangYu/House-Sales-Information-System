<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {
	public $project_id;
	public $project_name;
	public $project_type;
	public $project_address;
	public $project_city;
	public $project_district;
	public $project_block;
	public $project_function;
	public $project_reserve;
	
	public function __construct() {
		parent::__construct();
		 $this->load->database();
	}
	
	public function get_project_using_name($project_name) {
        $sql = 'SELECT * FROM house_project WHERE project_name = ?';
        $result_set = $this->db->query($sql, array($project_name));
        return $result_set->row_array();
    }
    
    public function get_records($city, $year, $month_low, $month_high, $district, $block, $name,
        $function, $building, $project_type, $height_low, $height_high, 
        $area_low, $area_high,$number, $offset, $limit) {
	    $parameters = array($city, $year, $month_low, $month_high);
        $sql = 'SELECT * FROM house_record '. 
               'NATURAL JOIN house_project '.
               'NATURAL JOIN house_building '.
               'WHERE project_city = ? AND YEAR(record_time) = ? AND MONTH(record_time) >= ? AND MONTH(record_time) <= ?';
               
        if ( $district != NULL ) {
	        $sql .= ' AND project_district = ?';
	        array_push($parameters, $district);
        }
        if ( $block != NULL ) {
	        $sql .= ' AND project_block = ?';
	        array_push($parameters, $block);
        }
        if ( $name != NULL ) {
	        $sql .= ' AND project_name = ?';
	        array_push($parameters, $name);
        }
        if ( $function != NULL ) {
	        $sql .= ' AND project_function = ?';
	        array_push($parameters, $function);
        }
        if ( $building != NULL ) {
	        $sql .= ' AND building_id = ?';
	        array_push($parameters, $building);
        }
        if ( $project_type != NULL ) {
	        $sql .= ' AND project_type = ?';
	        array_push($parameters, $project_type);
        }
        if ( $height_low != NULL ) {
	        $sql .= ' AND building_height >= ?';
	        array_push($parameters, $height_low);
        }
        if ( $height_high != NULL ) {
	        $sql .= ' AND building_height <= ?';
	        array_push($parameters, $height_high);
        }
        if ( $area_low != NULL ) {
	        $sql .= ' AND record_area >= ?';
	        array_push($parameters, $area_low);
        }
        if ( $area_high != NULL ) {
	        $sql .= ' AND record_area <= ?';
	        array_push($parameters, $area_high);
        }
        if ( $number != NULL ) {
	        $sql .= ' AND project_number = ?';
	        array_push($parameters, $number);
        }
        $sql .= ' LIMIT ?, ?';
        array_push($parameters, $offset, $limit);
        
        $result_set = $this->db->query($sql, $parameters);
        // echo $this -> db -> last_query();
        return $result_set->result_array();
    }
    
    public function get_sold_suit ($city, $year, $month_low, $month_high) {
	    $sql = 'SELECT project_id, building_id, COUNT(*) AS sold_suit '.
	           'FROM house_record' . 
	           'GROUP BY project_id, building_id'.
               'WHERE project_city = ? AND YEAR(record_time) = ? AND MONTH(record_time) >= ? AND MONTH(record_time) <= ?'; 
        $result_set = $this->db->query($sql, array($city, $year, $month_low, $month_high));
        return $result_set->row_array();  

    }
    
    public function get_sold_price ($city, $year, $month_low, $month_high) {
	    $sql = 'SELECT project_id, building_id, SUM(record_price) AS sold_price '.
	           'FROM house_record' . 
	           'GROUP BY project_id, building_id'.
	           'WHERE project_city = ? AND YEAR(record_time) = ? AND MONTH(record_time) >= ? AND MONTH(record_time) <= ?'; 
	    $result_set = $this->db->query($sql, array($city, $year, $month_low, $month_high));
        return $result_set->row_array();  
 
    }
    
    public function get_sold_area ($city, $year, $month_low, $month_high) {
	    $sql = 'SELECT project_id, building_id, SUM(record_area) AS sold_area '.
	           'FROM house_record' . 
	           'GROUP BY project_id, building_id'.
	           'WHERE project_city = ? AND YEAR(record_time) = ? AND MONTH(record_time) >= ? AND MONTH(record_time) <= ?'; 
	    $result_set = $this->db->query($sql, array($city, $year, $month_low, $month_high));
        return $result_set->row_array();  
   
	}
    
    public function get_average_price ($city, $year, $month_low, $month_high) {
	    $sql = 'SELECT project_id, building_id, AVG(record_price) AS average_price '.
	           'FROM house_record' . 
	           'GROUP BY project_id, building_id'.
	           'WHERE project_city = ? AND YEAR(record_time) = ? AND MONTH(record_time) >= ? AND MONTH(record_time) <= ?';  
	    $result_set = $this->db->query($sql, array($city, $year, $month_low, $month_high));
        return $result_set->row_array();  
  
	}
	
	public function get_rest_suit ($city, $year, $month_low, $month_high) {
	    $sql = 'SELECT project_id, building_id, project_total_suit, (project_total_suit - ( '.
	           '    SELECT COUNT(*) '. 
	           '    FROM house_record r '. 
	           '    WHERE r.project_id = b.project_id '. 
	           '    AND r.building_id = b.building_id '.
	           '    AND p.project_city = ? '
	           '    AND YEAR(r.record_time) < ? ) - ( '.
	           '    SELECT COUNT(*) '.
	           '    FROM house_record r '.
	           '    WHERE r.project_id = b.project_id '.
	           '    AND r.building_id = b.building_id '.
	           '    AND p.project_city = ? '
	           '    AND YEAR(r.record_time) = ? '.
	           '    AND MONTH(r.record_time)<=? )) AS rest_suit '.
	           'FROM house_building b '
	           'NATURAL JOIN house_project p';
	    $result_set = $this->db->query($sql, array($project_name));
        return $result_set->row_array();  
	}




  	
}
