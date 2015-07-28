<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {public function __construct() {
        parent::__construct();
         $this->load->database();
    }

    /**
     * Get cities of all projects.
     */
    public function get_cities() {
        $sql        = 'SELECT DISTINCT(project_city) AS city FROM house_project';
        $result_set = $this->db->query($sql);
        return $result_set->result_array();
    }
    
    /**
     * Get a project using its name and city.
     * Used for check if the project already exists when import.
     */
    public function get_project_using_city_and_name($project_city, $project_name) {
        $sql        = 'SELECT * FROM house_project WHERE project_name = ? AND project_city = ?';
        $result_set = $this->db->query($sql, array($project_city, $project_name));

        return $result_set->row_array();
    }
    
    public $project_id;
    public $project_name;
    public $project_type;
    public $project_address;
    public $project_city;
    public $project_district;
    public $project_block;
    public $project_function;
    public $project_reserve;
}
