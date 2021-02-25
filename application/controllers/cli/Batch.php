<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ci 의 메인 directory 에서 
// $ php index.php cli/batch process
//   {controller directory}/{Controller php file}  {method}
class Batch extends MY_Controller {
    function __construct(){
        parent::__construct();
    }

    // function process(){
    //     $this->load->model('user_model');
    //     $users = $this->user_model->gets();       
    //     $this->load->library('email');
    //     $this->email->initialize(array('mailtype'=>'html'));
    //     foreach($users as $user){
    //         $this->email->from('tester@send.co.kr', 'tester');
    //         $this->email->to($user->email);
    //         $this->email->subject('ci 메일전송 테스트');
    //         $this->email->message('테스트 입니다.'); 
    //         $this->email->send();
    //         echo "{$user->email}로 메일 전송을 성공 했습니다.\n";
    //     } 
    // }

    // crontab 용으로 변경
    // - 테스트 : $ php index.php /cli/batch process;
    // - crontab 등록
    //  + $ sudo crontab -e
    //  + $ */1 * * * * php {Web Server path}/index.php cli/batch process > {Web Server path}/application/logs/batch.access.log 2> {Web Server path}/application/logs/batch.error.log
    //   ㅁ 1분에 한번 실행
    //   ㅁ > {Web Server path}/application/logs/batch.access.log :: batch.access.logs 파일에 스크립트의 실행결과를 저장하는 명령   
    //   ㅁ 2> {Web Server path}/application/logs/batch.error.log :: batch.error.logs 파일에 실행도중 발생한 에러를 저장하는 명령
    function process(){
        $this->load->model('batch_model');
        $queue = $this->batch_model->gets();
        foreach($queue as $job){
            switch($job->job_name){
                case 'notify_email_add_topic':
                    $context = json_decode($job->context);
                    $this->load->model('topic_model');
                    $topic = $this->topic_model->get($context->topic_id);
                    $this->load->model('user_model');
                    $users = $this->user_model->gets();     
                    $this->load->library('email');
                    $this->email->initialize(array('mailtype'=>'html'));
                    foreach($users as $user){
                        $this->email->from('tester@send.co.kr', 'tester');
                        $this->email->to($user->email);
                        $this->email->subject($topic->title);
                        $this->email->message($topic->description);
                        $this->email->send();
                        echo "{$user->email}로 메일 전송을 성공 했습니다.\n";
                    }
                    $this->batch_model->delete(array('id'=>$job->id));
                    break;
            }
        }
    }
}

?>
