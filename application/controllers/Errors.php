<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The controller to handle errors.
 */
class Errors extends CI_Controller {
    /**
     * The constructor of the class.
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
     * Display the page that notice user to upgrade browser.
     */
    public function not_supported() {
        $this->load->view('errors/not-supported');
    }
}
