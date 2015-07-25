<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The default controller of the application.
 */
class Dashboard extends CI_Controller {
    /**
     * The contructor of the class.
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
     * Render to the dashboard page.
     */
    public function index() {
        $data = array(

        );
        $this->load->view('index', $data);
    }

    /**
     * Render to the import page.
     */
    public function import() {
        $data = array(

        );
        $this->load->view('import', $data);
    }

    /**
     * Render to the edit page.
     */
    public function edit() {
        $data = array(

        );
        $this->load->view('edit', $data);
    }

    /**
     * Render to the search page.
     */
    public function search() {
        $data = array(

        );
        $this->load->view('search', $data);
    }
}
