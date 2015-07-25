<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The default controller of the application.
 */
class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index() {
        $data = array(

        );
        $this->load->view('index', $data);
    }

    public function import() {
        $data = array(

        );
        $this->load->view('import', $data);
    }

    public function edit() {
        $data = array(

        );
        $this->load->view('edit', $data);
    }

    public function search() {
        $data = array(

        );
        $this->load->view('search', $data);
    }
}
