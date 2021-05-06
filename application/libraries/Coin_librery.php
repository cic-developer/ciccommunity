<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Point class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 포인트 추가 및 삭제를 관리하는 class 입니다.
 */

class Coin_librery extends CI_Controller
{
    private $CI;

    function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->helper( array('array'));
    }

    public function insert_stocks($stk_id = 0, $market = '', $name_ko = '', $name_en = ''){
        //check if market already exist if already exist don't insert
        /* $sql = "SELECT * FROM stocks WHERE symbol=?";
        $result = $db->prepare($sql);
        $res = $result->execute(array($_POST['stock'])) or die(print_r($result->errorInfo(), true));
        $count = $result->rowCount();
        if($count == 1){
        $errors[] = "Stock Symbol already exists in database";
        }
    }*/
    $this->CI->load->model('Coin_model');

    if ($market OR $name_ko ){   
        $where = array(
                'stk_id' => $stk_id,
                'market' => $market,
                'name_ko' => $name_ko,
                'name_en' => $name_ko         
        );

    $stock = $this->CI->Coin_model -> count_by($where);

    if($stocks > 0){
        return false;
    }
}
    $insertdata = array(
        'stk_id' => $stk_id,
        'market' => $market,
        'name_ko' => $name_ko,
        'name_en' => $name_ko,
        'timestamp'=> $timestamp
    );
    $this -> CI -> Coin_model ->insert($insertdata);

}
}
?>