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
