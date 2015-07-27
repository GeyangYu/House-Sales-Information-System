<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Record_model extends CI_Model {
	public $record_id;
	public $project_id;
	public $building_id;
	public $record_floor;
	public $record_price;
	public $record_area;
	public $record_time;
		
	public function __construct() {
		parent::__construct();
		$this->load->database(); 
	}
	
	public function get_all_records() {
        $sql = 'SELECT * FROM house_record NATURAL JOIN house_project';
        $result_set = $this->db->query($sql);
        return $result_set->result_array();
    }
    
	
}
