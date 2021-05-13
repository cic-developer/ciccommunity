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


    function getCoin_join( $limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR'){
       $select = 'name_ko';
       $join[] = array('table' => 'cic_coin_admins', 'on' => 'cic_coin_admins.coin_market = cic_coin_stock.market');
       $result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
       return $result;
    }

    

    function reseach_coinAdmin($search){
        if (empty($search)) {
			return result_array();
		}
		$this->db->select('name_ko');
		$this->db->join('cic_coin_admins', 'cic_coin_admins.coin_market = cic_coin_stock.market', 'inner');
		$this->db->where('cic_coin_admins.keyword', $search);
		$this->db->or_like('cic_coin_admins.keyword', $search);
		$this->db->order_by('cp_point', 'ASC');
		$this->db->limit(1);
		$qry = $this->db->get('cic_admins');
		$result = $qry->result_array();

		return $result;
    }


}
?>