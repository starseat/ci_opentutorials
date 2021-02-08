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
        log_message('debug', 'topic 초기화');
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
        // $this->load->view('topic/header');
        // $this->load->view('topic/list', array('topics' => $topics));
        // $this->load->view('topic', array('topics' => $topics));
        // $this->load->view('topic/footer');

        // _header(), _footer() 호출로 변경
        $this->_head();
        $this->load->view('topic', array('topics' => $topics));
        $this->_footer();
    }

    public function list() {
        $this->index();
    }

    // public function 으로 만드는 함수들은
    // topic(파일명) 의 뒤에 나오는 패스가 됨.
    // http://localhost/ci_opentutorials/index.php/topic/test
    public function test()
    {
        echo '토픽 - test';
    }

    // function name 앞에 _ 를 붙이면 uri routing 에 대한 private method 가 됨.
    function _head() {
        $this->load->config('topic_config');  // 파일명 써줘야함.

        $this->load->view('topic/header');
        $topics = $this->topic_model->gets();
        $this->load->view('topic/list', array('topics' => $topics));
    }

    function _footer() {
        $this->load->view('topic/footer');
    }

    // ~/topic/get/1  이런식으로 get 뒤에 param 을 받고 싶으면 다음과 같이 사용
    // public function get($id) {

    //     //$this->load->database();
    //     //$this->load->model('topic_model');

    //     $topics = $this->topic_model->gets();
    //     $topic = $this->topic_model->get($id);

    //     //echo '토픽 - get ' . $id;
    //     // array 에서 첫번째 'id' 에 값 담아서 화면으로 넘김
    //     $this->load->view('topic/header');
    //     $this->load->view('topic/list', array('topics' => $topics));
    //     //$this->load->view('topic_get', array('id' => $id) );

    //     // 헬퍼 사용
    //     $this->load->helper(array('url', 'HTML', 'korean')); // korean 이라고 써주면 korean* 파일을 찾아서 view 에 적용함
    //     $this->load->view('topic/get', array('topic' => $topic));
    //     $this->load->view('topic/footer');
    // }

    public function get($id) {
        $this->_head();

        log_message('debug', 'topic get 호출 id: ' . $id);
        $topic = $this->topic_model->get($id);
        if(empty($topic)) {
            log_message('error', 'topic data is empty.');
            show_error('topic data is empty.');
        }
        else {
            log_message('info', var_export($topic, true));  // $topic 같은 객체를 보기 쉽게 변환해줌
        }       
        
        $this->load->helper(array('url', 'HTML', 'korean'));
        $this->load->view('topic/get', array('topic' => $topic));

        $this->_footer();
    }

    public function add() {
        $this->_head();

        // 테스트용
        // echo $this->input->post('title');
        // echo ', ';
        // echo $this->input->post('description');

        $this->load->library('form_validation');        

        // form validation rule
        // paraameter
        //  1: form 의 'name' attribute
        //  2: 에러가 났을 시 사용자가 알기쉽게 표현할 문자열
        //  3: form validation 규칙
        $this->form_validation->set_rules('title', '제목', 'required');
        $this->form_validation->set_rules('description', '본문', 'required');

        // 사용자의 입력한 정보 유효성 검사 실행 시 
        if($this->form_validation->run() == FALSE) {
            // 실패하면 여기 실행

            //$this->load->view('myForm');

            $this->load->view('topic/add');
        }
        else {
            // $this->load->view('formsuccess');
            //echo '성공';

            $topic_id = $this->topic_model->add($this->input->post('title'), $this->input->post('description'));

            $this->load->helper('url');  // redirect 사용 가능
            redirect('/topic/get/' . $topic_id);  // /ci_opentutorials/index.php/ 은 입력 안해도 됨.
        }        

        $this->_footer();
    }

    // 사용자가 전송한 데이터 받는 부분
    public function upload_receive() {
        // 아래 내용은 CI 에서 제공하는 정보임. 그냥 하면 됨.

        // 사용자가 업로드 한 파일을 /static/upload/ 디렉토리에 저장한다.
        $config['upload_path'] = './static/upload';
        // git,jpg,png 파일만 업로드를 허용한다.
        $config['allowed_types'] = 'gif|jpg|png';
        // 허용되는 파일의 최대 사이즈 (kb) 
        $config['max_size'] = '0';  // 0 이면 php.ini 참조. php.ini 는 defaualt 로 2mb
        // 이미지인 경우 허용되는 최대 폭
        $config['max_width']  = '0';  // 픽셀단위. 0이면 제한 X
        // 이미지인 경우 허용되는 최대 높이
        $config['max_height']  = '0'; // 픽셀단위. 0이면 제한 X 

        $this->load->library('upload', $config);

        // 위 까지는 설정임.
        // 여기부터가 실제로 파일 업로드 처리
        if(!$this->upload->do_upload('user_upload_file')) {
            //$error = array('error' => $this->upload->display_errors());
            //$this->load->view('upload_form', $error);

            // 임시로 에러 메시지 출력
            echo $this->upload->display_errors();
        }
        else {
            $data = array('upload_data' => $this->upload->data());
            //$this->load->view('upload_success', $data);

            // 임시
            echo 'success';
            var_dump($data);
        }

    }
    
    public function upload() {
        $this->_head();

        $this->load->view('topic/upload_form');

        $this->_footer();
    }
}

?>
