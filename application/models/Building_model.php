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
     * 获取在某些筛选条件下建筑记录的数量.
     * @param  String  $project_city      - 建筑所在的城市(可为空)
     * @param  boolean $display_null_only - 是否只显示存在空字段的记录
     * @return 某些筛选条件下建筑记录的数量
     */
    public function get_number_of_buildings($project_city, $display_null_only) {
        $parameters = array();
        $sql        = 'SELECT * FROM house_building NATURAL JOIN house_project WHERE 1';
        
        if ( !empty($project_city) ) {
            $sql   .= ' AND project_city = ?';
            array_push($parameters, $project_city);
        }
        if ( $display_null_only ) {
            $sql   .= ' AND ( project_number = "" OR project_area = 0 OR project_total_suit = 0 )';
        }

        $result_set = $this->db->query($sql, $parameters);
        return $result_set->num_rows();
    }

    /**
     * 通过城市获取建筑列表, 并分页.
     * @param  String  $project_city      - 建筑所在的城市(可为空)
     * @param  boolean $display_null_only - 是否只显示存在空字段的记录
     * @param  int     $offset            - 记录起始游标
     * @param  int     $limit             - 最大记录数量
     * @return 一个包含建筑列表的数组
     */
    public function get_buildings_using_city_and_offset($project_city, $display_null_only, $offset, $limit) {
        $parameters = array();
        $sql        = 'SELECT * FROM house_building NATURAL JOIN house_project WHERE 1';
        
        if ( !empty($project_city) ) {
            $sql   .= ' AND project_city = ?';
            array_push($parameters, $project_city);
        }
        if ( $display_null_only ) {
            $sql   .= ' AND ( project_number = "" OR project_area = 0 OR project_total_suit = 0 )';
        }
        $sql       .= ' ORDER BY project_id DESC, building_id LIMIT ?, ?';
        array_push($parameters, $offset, $limit);

        $result_set = $this->db->query($sql, $parameters);
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
            'building_height'       => $building_height,
        );
        return $this->db->insert('house_building', $building);
    }
    
    public function update_building($project_id, $building_id, $building_structure, $building_height,
        $project_number, $project_area, $project_total_suit) {
        $building   = array(
            'project_id'            => $project_id,
            'building_id'           => $building_id,
            'building_structure'    => $building_structure,
            'building_height'       => $building_height,
            'project_number'        => $project_number, 
            'project_area'          => $project_area, 
            'project_total_suit'    => $project_total_suit,
            
        );
        $this->db->where('project_id', $project_id);
        $this->db->where('building_id', $building_id);
        return $this->db->update('house_building', $building);
       
    }

}
