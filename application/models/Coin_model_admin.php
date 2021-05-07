<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Coin class
 *
 * Copyright (c) RsTeam <www.rs-team.com>
 *
 * @author RsTeam (developer@rs-team.com)
 */

/**
 * 권한이 있는지 없는지 판단하는 class 입니다.
 */
class Coin_model_admin extends CB_Model
{

    /**
	 * 테이블명
	 */
	public $_table = 'cic_coin_admin';
    public $primary_key = 'market';

    function __construct()
    {
        parent::__construct();

        check_cache_dir('coin');
    }
	/**
	 * Get RealTime Coin Price
	 */

    function get_admin_coinList(){
        $query = $this->db->get('cic_coin_admin');
        return $query->result(); 
    }

    // function getonerow(){
    //     $this->db->where('stk_id', $id);
    //     $query = $this->db->get('cic_stocks');
    //     return $query->row();
    // }


    // function search_coin($search){
    // //     if(!empty($key)) {
    // //         $this->db->where($_table, $key);
    // //     }
    // //     $search_ = "";
    // //     if(preg_match('/\s/', $search_) > 0){
    // //         $search_ = array_map('trim',array_filter(explode('', $search_)));
    // //         foreach ($search_ as $key_=> $value){
    // //             $this->db->or_like('foo_column', $value);
    // //         }
    // //     }else if($search_ !=''){
    // //         $this->db->like('foo_column', $search_);
    // //     }
    // //     $query = $this->db->get('name_en');
    // //     return $query->result();
    //     $search = $this->input->GET('search', TRUE);
    //     $data = $this->db->query("SELECT * from $_table where key_word like '%$search%' ");
    //     return $data->result();

    // }


}
?>