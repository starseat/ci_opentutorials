<?php

// models 에 있는 파일은 사용하고자 할 database 의 table 과 맞춰서 생성
// class 의 첫 글자는 대문자로!
class Topic_model extends CI_Model 
{
    // 생성자
    function __construct()
    {
        parent::__construct();
    }

    public function gets() {
        //echo 'gets test';
        $sql = "SELECT * FROM topic";
        return $this->db->query($sql)->result();  // object 형으로 return
        //return $this->db->query($sql)->result_array();
    }
}