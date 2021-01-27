<?php
defined('BASEPATH') or exit('No direct script access allowed');

// controllers/topic 에서 topic 은 검색 주소란의 링크주소가됨.
// Topic 은 해당 파일명에서 앞에만 대문자로 작성해야함.
class Topic extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        // 중복되는 부분 여기다가 옮기기
        $this->load->database();
        $this->load->model('topic_model');

    }
    // public function index() 은 ~/topic 입력했을떄의 index 페이지임.
    public function index()
    {
        //echo '토픽 페이지';

        // database 로드
        //$this->load->database();
        //$this->load->model('topic_model');  // models 에 있는 파일명 로드
                                           // 파일명에서 첫글자가 대문자인 클래스 찾음
        $topics = $this->topic_model->gets(); // topic_model 은 Topic_model class 로 생성된 object 임
        // foreach($topics as $entry) {
        //     //var_dump($entry);
        //     var_dump($entry->title);
        // }

        // application/views/topic.php 호출
        $this->load->view('topic/header');
        $this->load->view('topic/list', array('topics' => $topics));
        $this->load->view('topic', array('topics' => $topics));
        $this->load->view('topic/footer');
    }

    // public function 으로 만드는 함수들은
    // topic(파일명) 의 뒤에 나오는 패스가 됨.
    // http://localhost/ci_opentutorials/index.php/topic/test
    public function test()
    {
        echo '토픽 - test';
    }

    // ~/topic/get/1  이런식으로 get 뒤에 param 을 받고 싶으면 다음과 같이 사용
    public function get($id) {

        //$this->load->database();
        //$this->load->model('topic_model');

        $topics = $this->topic_model->gets();
        $topic = $this->topic_model->get($id);

        //echo '토픽 - get ' . $id;
        // array 에서 첫번째 'id' 에 값 담아서 화면으로 넘김
        $this->load->view('topic/header');
        $this->load->view('topic/list', array('topics' => $topics));
        //$this->load->view('topic_get', array('id' => $id) );
        $this->load->view('topic/get', array('topic' => $topic));
        $this->load->view('topic/footer');
    }

    
}

?>
