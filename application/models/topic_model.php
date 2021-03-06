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

    public function get($topic_id) {
        // 아래는 select * from topic where id=1  과 같은 sql 인데
        // * 이 아닌 원하는 항목만 가져오고싶을떄 다음과 같이 절처리 사용
        // 그럼 * 이 명시된 항목으로 하나씩 추가됨.
        $this->db->select('id');
        $this->db->select('title');
        $this->db->select('description');
        $this->db->select('UNIX_TIMESTAMP(created) AS created');

        // get_where 이런걸 active record 라고함
        return $this->db->get_where('topic', array('id=' => $topic_id))->row();  // row() 로 한 항목만 조회
        // 이것과 동일
        // return $this->db->query("SELECT * FROM topic WHERE id=" . $topic_id)->row();
    }

    public function add($title, $description) {
        // sql 이 생성되기 전에 created 가 now() 를 대입하는데 3번째 파라미터를 false 로 하여 문자열이 아닌 그대로 들어가게함.
        $this->db->set('created', 'NOW()', false); 

        $this->db->insert('topic', array(
            'title' => $title, 
            'description' => $description
        ));

        //echo $this->db->last_query(); // 마지막에 생성된 sql 확인

        return $this->db->insert_id();  // 마지막에 생성된 id 값 return
    }
}