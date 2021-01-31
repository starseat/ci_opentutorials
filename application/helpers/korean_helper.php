<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// 이미 helper 가 정의되어 있는지 확인
if ( ! function_exists('kdate')) {
    function kdate($stamp) {
        return date('o년 n월 j일, G시 i분 s초', $stamp);
    }
}

?>
