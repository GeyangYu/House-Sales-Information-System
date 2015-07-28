<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Building_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        
    }
    
    public function get_all_buildings() {
        $sql        = 'SELECT * FROM house_building NATURAL JOIN house_project';
        $result_set = $this->db->query($sql);

        return $result_set->result_array();
    }

    public $project_id;
    public $building_id;
    public $building_structure;
    public $building_height;
    public $project_number;
    public $project_area;
    public $project_total_suite;
}
