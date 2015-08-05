<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {
    /**
     * 构造函数.
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 获取项目所在城市的列表.
     * 用于加载搜索页面的城市选项.
     */
    public function get_cities() {
        $sql        = 'SELECT DISTINCT(project_city) AS city FROM house_project';
        $result_set = $this->db->query($sql);
        return $result_set->result_array();
    }
    
    /**
     * 通过城市获取项目列表.
     * 用于在导入数据时检查项目是否已经存在.
     */
    public function get_projects_using_city($project_city) {
        $sql        = 'SELECT * FROM house_project WHERE project_city = ?';
        $result_set = $this->db->query($sql, array($project_city));

        return $result_set->result_array();
    }

    public function get_project_area($group_by) {
        $sql        = "SELECT SUM(project_area) AS project_area, $group_by ".
                      "FROM (".
                      "    SELECT  DISTINCT(project_number), project_area, $group_by ".
                      "    FROM house_project ".
                      "    NATURAL JOIN house_building ".
                      ") p ".
                      "GROUP BY $group_by";

        $result_set = $this->db->query($sql);
        return $result_set->result_array();
    }

    /**
     * 获取在某些筛选条件下项目记录的数量.
     * @param  String  $project_city      - 项目所在的城市(可为空)
     * @param  boolean $display_null_only - 是否只显示存在空字段的记录
     * @return 某些筛选条件下项目记录的数量
     */
    public function get_number_of_projects($project_city, $display_null_only) {
        $parameters = array();
        $sql        = 'SELECT * FROM house_project WHERE 1';
        
        if ( !empty($project_city) ) {
            $sql   .= ' AND project_city = ?';
            array_push($parameters, $project_city);
        }
        if ( $display_null_only ) {
            $sql   .= ' AND ( project_district = "" OR project_block = "" OR project_function = "" )';
        }

        $result_set = $this->db->query($sql, $parameters);
        return $result_set->num_rows();
    }

    /**
     * 通过城市获取项目列表, 并分页.
     * @param  String  $project_city      - 项目所在城市(可为空)
     * @param  boolean $display_null_only - 是否只显示存在空字段的记录
     * @param  int     $offset            - 记录起始游标
     * @param  int     $limit             - 最大记录数量
     * @return 一个包含项目列表的数组
     */
    public function get_projects_using_city_and_offset($project_city, $display_null_only, $offset, $limit) {
        $parameters = array();
        $sql        = 'SELECT * FROM house_project WHERE 1';
        
        if ( !empty($project_city) ) {
            $sql   .= ' AND project_city = ?';
            array_push($parameters, $project_city);
        }
        if ( $display_null_only ) {
            $sql   .= ' AND ( project_district = "" OR project_block = "" OR project_function = "" )';
        }
        $sql       .= ' ORDER BY project_id DESC LIMIT ?, ?';
        array_push($parameters, $offset, $limit);

        $result_set = $this->db->query($sql, $parameters);
        return $result_set->result_array();
    }

    /**
     * 创建项目.
     * @param  String $project_name    - 项目名称
     * @param  int    $project_type    - 项目类型(0或1)
     * @param  String $project_address - 项目地址
     * @param  String $project_city    - 项目所在城市
     */
    public function create_project($project_name, $project_type, $project_address, $project_city) {
        $project    = array(
            'project_name'      => $project_name,
            'project_type'      => $project_type,
            'project_address'   => $project_address,
            'project_city'      => $project_city,
        );
        return $this->db->insert('house_project', $project);
    }
}
