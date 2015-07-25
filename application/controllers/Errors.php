<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The default controller of the application.
 */
class Errors extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function not_supported() {
        $this->load->view('errors/not-supported');
    }
}
