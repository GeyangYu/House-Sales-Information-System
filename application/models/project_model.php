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
    
    public function get_records_using_city($city, $year, $month, $district, $block, $name,
        $function, $building, $project_type, $height_type, $area_type, $number) {
	    $parameters = array($city, $year, $month);
        $sql = 'SELECT * FROM house_record '. 
               'NATURAL JOIN house_project '.
               'NATURAL JOIN house_building '.
               'WHERE project_city = ? AND YEAR(record_time) = ? AND MONTH(record_time) = ?';
               
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
        if ( $height_type != NULL ) {
	        $sql .= ' AND building_height = ?';
	        array_push($parameters, $height_type);
        }
        if ( $area_type != NULL ) {
	        $sql .= ' AND record_area = ?';
	        array_push($parameters, $area_type);
        }
        if ( $number != NULL ) {
	        $sql .= ' AND project_number = ?';
	        array_push($parameters, $number);
        }
        
        $result_set = $this->db->query($sql, $parameters);
        echo $this -> db -> last_query();
        return $result_set->result_array();
    }
    
    
    
	
}
