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
class CIC_Coin_Keyword_model extends CB_Model
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


    function getKeyword($limit ='', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR'){
        $search_where = array();
		$search_like = array();
		$search_or_like = array();
        $select = 'cic_coin_keyword.*';
        $result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
        return $result;
    }


    function delete_keyword($id){
        $this->db->where('idx', $id);
        $this->db->delete('cic_coin_keyword');
        return true;
    }


    function update_keyword($id, $data){
        $this->db->where('idx', $id);
        $this->db->update('cic_coin_keyword', $data);
        return true;

    }

    function getKeywordRow($id){
        $this->db->where('idx', $id);
        $query = $this->db->get('cic_coin_keyword');
        return $query->row_array();
    }

    function search_Coin ($search){
        if (empty($search)) {
			return false;
		}
		$this->db->select('*');
		$this->db->join('cic_coin_keyword', 'cic_coin_keyword.coin_market = cic_coin_list.market', 'inner');
		$this->db->where('cic_coin_keyword.coin_keyword', $search);
		$result = $this->db->get('cic_coin_list')->row_array();
        return $result;

    }
    

}
?>