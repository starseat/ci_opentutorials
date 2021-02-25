<?php
defined('BASEPATH') or exit('No direct script access allowed');

// controllers/topic 에서 topic 은 검색 주소란의 링크주소가됨.
// Topic 은 해당 파일명에서 앞에만 대문자로 작성해야함.
class Topic extends MY_Controller
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
        //var_dump($this->session->userdata('session_test'));  // 값이 없으면 false (or null) 출력
        //$this->session->set_userdata('session_test', 'starseat');

        //var_dump($this->session->all_userdata());

        // $this->load->config('topic_config');  // 파일명 써줘야함.
        // $this->load->view('topic/header');

        parent::_head();
        $this->_sidebar();
    }

    function _sidebar() {
        $topics = $this->topic_model->gets();
        $this->load->view('topic/list', array('topics' => $topics));
    }

    // 부모 class 인 MY_Controller 로 옮김.
    // function _footer() {
    //     $this->load->view('topic/footer');
    // }

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

        // 로그인 필요
        
        // 로그인이 되어 있지 않다면 로그인 페이지로 redirection
        if( ! $this->session->userdata('is_login') ) {
            $this->load->helper('url');
            //redirect('/auth/login');  // redirect 는 url library 필요

            // 페이지 이동시키기
            //redirect('/auth/login?returnURL=' . rawurlencode('http://localhost/ci_opentutorials/index.php/topic/add?page=2'));
            // rawurldecode() : url encoding

            redirect('/auth/login?returnURL=' . rawurlencode(site_url('/topic/add')));
        }

        // 로그인이 되어있다면 밑에 코드 실행

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

            // ---------- 메일 전송 start
            // $this->load->model('user_mode');
            // $users = $this->user_model->gets();

            // $this->load->library('email');
            // $this->email->initialize(array('mailtype' => 'html'));
            // foreach($users as $user) {
            //     //var_dump($user);

            //     $this->email->from('sender@test.com', 'ci_tester'); // 보내는 사람 
            //     //xdebug_break();
            //     $this->email->to($user->email);  // 받을 사람
            //     //$this->email->cc();
            //     //$this->email->bcc();

            //     $this->email->subject('새로운 글이 등록되었습니다.');
            //     $this->email->message('<a href="' . site_url('/topic/get/' . $topic_id) . '">' . $this->input->post('title') . '</a>');

            //     $this->email->send();

            // }
            
            // 메일 전송 batch 로 대체 
            $this->load->model('batch_model');
            $this->batch_model->add(
                array(
                    'job_name'=>'notify_email_add_topic', 
                    'context'=>json_encode(array('topic_id'=>$topic_id))
                )
            );
 
        $this->load->helper('url');
        redirect('/topic/get/'.$topic_id);
    }
     
    $this->_footer();
}


            // ---------- 메일 전송 end

            $this->load->helper('url');  // redirect 사용 가능
            redirect('/topic/get/' . $topic_id);  // /ci_opentutorials/index.php/ 은 입력 안해도 됨.
        }        

        $this->_footer();
    }

    // 사용자가 전송한 데이터 받는 부분
    public function upload_receive() {
        // 아래 내용은 CI 에서 제공하는 정보임. 그냥 하면 됨.

        // 사용자가 업로드 한 파일을 /static/upload/ 디렉토리에 저장한다.
        $config['upload_path'] = '/ci_opentutorials/static/upload';
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
            //var_dump($data);
        }
    }

    // ckeditor 용
    public function upload_receive_from_ck() {
        // 아래 내용은 CI 에서 제공하는 정보임. 그냥 하면 됨.

        // 사용자가 업로드 한 파일을 /static/upload/ 디렉토리에 저장한다.
        $config['upload_path'] = '/ci_opentutorials/static/upload';
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
        if(!$this->upload->do_upload('upload')) {  // ckeditor 에서는 <input type="file" name="upload"> 로 만들어짐
            //$error = array('error' => $this->upload->display_errors());
            //$this->load->view('upload_form', $error);

            // 임시로 에러 메시지 출력
            $error_msg = $this->upload->display_errors('', '');  // 파라미터 2개를 공백으로 주면 html 태그 삭제함
            echo $error_msg;
            echo "<script>alert('업로드에 실패하였습니다. (" . $error_msg . ")');</script>";
            
        }
        else {
            $data = array('upload_data' => $this->upload->data());
            //$this->load->view('upload_success', $data);

            // 화면을 만들어서 전송해야되지만 임시로 이렇게 함.
            //echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('콜백의 식별 ID 값', '파일의 URL', '전송완료 메시지')</script>";

            // get 방식으로 데이터를 가져옴
            $CKEditorFuncName = $this->input->get('CKEditorFuncNum');
            $filename = $data['filen_name'];
            $url = '/static/upload' . $filename; // 상대경로로 변환

            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('" . $CKEditorFuncName . "', '" . $url . "', '업로드 성공')</script>";
            //var_dump($data);
        }

    }
    
    public function upload() {
        $this->_head();

        $this->load->view('topic/upload_form');

        $this->_footer();
    }
}

?>
