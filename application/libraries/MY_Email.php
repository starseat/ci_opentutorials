<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Email extends CI_Email {
    public function to($to) {
        // 이메일 주소 변경
        $this->ci = &get_instance();  // controller 의 맥락 가져오기  // controller 의 $this 를 가져오기 위함임.
        $_to = $this->ci->config->item('dev_receive_email'); 
        $to = $_to ? $to : $_to;
        return parent::to($to);
    }
}

?>
