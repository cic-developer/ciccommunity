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
    //public $primary_key = 'market';

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
        $this->db->join('cic_coin_stock', 'cic_coin_stock.coin_idx = cic_coin_admins.coin_idx');

        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    function delete_keyword($id){
        $this->db->select('cic_coin_stock.*');
        $this->db->select('cic_coin_admins.*');
         //$this->db->('market');
        $this->db->from('cic_coin_admins');
        $this->db->join('cic_coin_stock', 'cic_coin_stock.coin_idx = cic_coin_admins.coin_idx');
        
        if(is_array($id)){
            $this->db->where_in('id', '$ids');
        }
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else
            return false;
    }

    function research_coin($keyword){
        $this->db->select('cic_coin_admins.*');
        $this->db->from('cic_coin_admins');
        $this->db->join('cic_coin_stock', 'cic_coin_stock.coin_idx = cic_coin_admins.coin_idx');
        $this->db->get_where('cic_coin_admins', array('keyword' => $keyword ));
    }

    function save_defaut_keyword(){
        $this->db->where('stk_id', $id);
        $query = $this->db->get('cic_coin_stock');
        return $query->row();
    }


}
?>