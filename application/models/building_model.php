<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Building_model extends CI_Model {
	public $project_id;
	public $building_id;
	public $building_structure;
	public $building_height;
		
	public function __construct() {
		parent::__construct();
		
	}
	
}
