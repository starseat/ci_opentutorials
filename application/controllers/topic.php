<?php
defined('BASEPATH') or exit('No direct script access allowed');

// controllers/topic 에서 topic 은 검색 주소란의 링크주소가됨.
// Topic 은 해당 파일명에서 앞에만 대문자로 작성해야함.
class Topic extends CI_Controller
{
    // public function index() 은 ~/topic 입력했을떄의 index 페이지임.
    public function index()
    {
        echo '토픽 페이지';
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
        echo '토픽 - get ' . $id;
    }

    
}

?>
