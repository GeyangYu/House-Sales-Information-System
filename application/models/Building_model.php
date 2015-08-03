<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Building_model extends CI_Model {
    /**
     * 构造函数.
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * 通过城市获取建筑列表.
     * 用于在导入数据时检查建筑是否已经存在.
     */
    public function get_buildings_using_city($city) {
        $sql        = 'SELECT * FROM house_building NATURAL JOIN house_project WHERE project_city = ?';
        $result_set = $this->db->query($sql, array($city));

        return $result_set->result_array();
    }

    /**
     * 创建建筑的记录.
     * @param  int    $project_id         - 项目的ID
     * @param  int    $building_id        - 幢号
     * @param  String $building_structure - 房屋结构
     * @param  int    $building_height    - 总层数
     */
    public function create_buildings($project_id, $building_id, $building_structure, $building_height) {
        $building   = array(
            'project_id'            => $project_id,
            'building_id'           => $building_id,
            'building_structure'    => $building_structure,
            'building_height'       => $building_height
        );
        return $this->db->insert('house_building', $building);
    }
}
