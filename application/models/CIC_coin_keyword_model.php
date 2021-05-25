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
class CIC_Coin_keyword_model extends CB_Model
{

    /**
	 * 테이블명
	 */
	public $_table = 'cic_coin_keyword';
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
            $result = $this->db->insert('cic_coin_keyword', $data);
            return $result;
        }
    }
    
    function get_keyword(){
        $this->db->select('cic_coin_list.*');
        $this->db->select('cic_coin_keyword.*');
         //$this->db->('market');
        $this->db->from('cic_coin_keyword');
        $this->db->join('cic_coin_list', 'cic_coin_list.clist_market = cic_coin_keyword.coin_market');

        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    function delete_keyword($id){
        $this->db->where('idx', $id);
        $this->db->delete('cic_coin_keyword');
        return true;
    }


    public function update_keyword($data) {
        extract($data);
        $this->db->where('idx', $id);
        $this->db->update($_table, array('coin_keyword' => $coin_keyword));
        return true;
    }
    function getKeywordRow($id){
        $this->db->where('idx', $id);
        $query = $this->db->get('cic_coin_keyword');
        return $query->row();
    }

    function search_coin ($search){
        if (empty($search)) {
			return false;
		}
		$this->db->select('*');
		$this->db->join('cic_coin_keyword', 'cic_coin_keyword.coin_market = cic_coin_list.clist_market', 'inner');
		$this->db->where('cic_coin_keyword.coin_keyword', $search);
		$result = $this->db->get('cic_coin_list')->row_array();
        return $result;

    }
    function insert_keyword_list($data){
        $this-> db -> where('coin_keyword', $coin_keyword);
        $query = $this->db->get('cic_coin_keyword');
        $refresh_ = $this -> input -> post('refresh_');
        print_r($refresh_);
        if($refresh_){
            $result = $this->db->insert('cic_coin_keyword', $data);
            return $result;  
        }
    }

    

}
?>