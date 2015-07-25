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
	public $project_number;
	public $project_area;
	public $project_total_suite;
	public $project_reserve;
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get_project_using_name($project_name) {
        $sql = 'SELECT * FROM house_project WHERE project_name = ?';
        $result_set = $this->db->query($sql, array($project_name));
        return $result_set->row_array();
    }
	
}
