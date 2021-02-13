<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function _head() {
        $this->load->config('topic_config');
        $this->load->view('topic/header');
    }

    function _footer() {
        $this->load->view('topic/footer');
    }
}
