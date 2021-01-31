<?php

class Errors extends CI_Controller {
    public function notfound() {
        $this->load->view('topic/header');
        $this->load->view('error/404');
        $this->load->view('topic/footer');
    }
}

?>
