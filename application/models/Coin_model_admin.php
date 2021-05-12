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
	public $_table = 'cic_coin_admins';
    public $primary_key = 'idx';

    function __construct()
    {
        parent::__construct();

        check_cache_dir('coin');
    }
	/**
	 * Get RealTime Coin Price
	 */
    function insert_keyword($data){

        if(isset($data) && !empty($data)){
            $result = $this->db->insert('cic_coin_admins', $data);
            return $result;
        }
    }
    
    function get_keyword(){
        $this->db->select('cic_coin_stock.*');
        $this->db->select('cic_coin_admins.*');
         //$this->db->('market');
        $this->db->from('cic_coin_admins');
        $this->db->join('cic_coin_stock', 'cic_coin_stock.market = cic_coin_admins.coin_market');

        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    function getById($id){
        return $this->db->get_where('cic_coin_admins', array('id'=>$id))->row();
    }

    function delete_keyword($id){

        $this->db->where('idx', $id);
        $this->db->delete('cic_coin_admins');
        return true;
    }


    function update_keyword($id, $data){
        $this->db->where('coin_market', $id);
        $this->db->update('cic_coin_admins', $data);

    }

    function save_defaut_keyword(){
        $query = $this->db->get('cic_coin_admins');
        return $query->row();
    }
    
    function search_coin($search, $keyword ){
        $this->db->select('*');
        $this->db->from('cic_coin_admins');
        $this->db->where('keyword', $search);

        if($search == market)


        $query = $this->db->get();

        return $query -> result_array();

    }


}
?>