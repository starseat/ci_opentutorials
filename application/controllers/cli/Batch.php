<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ci 의 메인 directory 에서 
// $ php index.php cli/batch process
//   {controller directory}/{Controller php file}  {method}
class Batch extends MY_Controller {
    function __construct(){
        parent::__construct();
    }

    function process(){
        $this->load->model('user_model');
        $users = $this->user_model->gets();       
        $this->load->library('email');
        $this->email->initialize(array('mailtype'=>'html'));
        foreach($users as $user){
            $this->email->from('tester@send.co.kr', 'tester');
            $this->email->to($user->email);
            $this->email->subject('ci 메일전송 테스트');
            $this->email->message('테스트 입니다.'); 
            $this->email->send();
            echo "{$user->email}로 메일 전송을 성공 했습니다.\n";
        } 
    }
}

?>
