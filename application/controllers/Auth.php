<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller {
    function __construct() {
        parent::__construct();
    }

    public function login() {
        $this->_footer();

        // 로그인 페이지에 이전 url 받을 returnURL 추가
        $this->load->helper('url'); // login.php 에서 site_url 을 사용하기 떄문에 여기서 추가해줌
        $this->load->view('login', array('returnURL' => $this->input->get('returnURL')));

        $this->_footer();  // MY_Controller 에 있음.
    }

    public function authentication() {
        //var_dump($this->config->item('authentication'));
        //echo '인증';

        $_auth = $this->config->item('authentication');
        if($this->input->post('id') == $_auth['id']
            && $this->input->post('password') == $_auth['password']) {
            //echo '일치';

            $this->session->set_userdata('is_login', true);

            $this->load->helper('url');
            //redirect('/topic/add');  // 이전에 있던 페이지로 돌려보내는건 다음에...

            $returnURL = $this->input->get('returnURL');
            if($returnURL === false) {
                $returnURL = '/';
            }
            redirect($returnURL);
        }
        else {
            //echo '불일치';

            // ci 에서 제공하는 flash data 사용. 페이지에 1회성으로 메시지 보내줌. session library 에 포함됨
            $this->session->set_flashdata('message', '로그인에 실패 하였습니다.');  // views/topic/header.php  에 가져와서 뿌려주는 처리 해줌.

            $this->load->helper('url');
            redirect('/auth/login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();

        $this->load->helper('url');
        redirect('/');
    }
}

?>
