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


    function delete_keyword($id){
        $this->db->where('idx', $id);
        $this->db->delete('cic_coin_admins');
        return true;
    }


    function update_keyword($id, $data){
        $this->db->where('coin_market', $id);
        $this->db->update('cic_coin_admins', $data);

    }

    function search_Coin ($search){
        if (empty($search)) {
			return false;
		}
		$this->db->select('*');
		$this->db->join('cic_coin_admins', 'cic_coin_admins.coin_market = cic_coin_stock.market', 'inner');
		$this->db->where('cic_coin_admins.keyword', $search);
		$result = $this->db->get('cic_coin_stock')->row_array();
        return $result;

    }



    function search_Coin_($limit = '', $offset = '', $where = '', $like = '', $board_id = 0, $orderby = '', $sfield = '', $skeyword = '', $sop = 'OR') {
        $search_where = array();
        if ($sfield && is_array($sfield)) {
			foreach ($sfield as $skey => $sval) {
				$ssf = $sval;
				if ($skeyword && $ssf && in_array($ssf, $this->allow_search_field)) {
					if (in_array($ssf, $this->search_field_equal)) {
						$search_where[$ssf] = $skeyword;
					} else {
						$swordarray = explode(' ', $skeyword);
						foreach ($swordarray as $str) {
							if (empty($ssf)) {
								continue;
							}
							if ($sop === 'AND') {
								$search_like[] = array($ssf => $str);
							} else {
								$search_or_like[] = array($ssf => $str);
							}
						}
					}
				}
			}
		} else {
			$ssf = $sfield;
			if ($skeyword && $ssf && in_array($ssf, $this->allow_search_field)) {
				if (in_array($ssf, $this->search_field_equal)) {
					$search_where[$ssf] = $skeyword;
				} else {
					$swordarray = explode(' ', $skeyword);
					foreach ($swordarray as $str) {
						if (empty($ssf)) {
							continue;
						}
						if ($sop === 'AND') {
							$search_like[] = array($ssf => $str);
						} else {
							$search_or_like[] = array($ssf => $str);
						}
					}
				}
			}
		}


        $this->db->select('*');
		$this->db->join('cic_coin_admins', 'cic_coin_admins.coin_market = cic_coin_stock.market', 'inner');
		$this->db->where('cic_coin_admins.keyword', $skeyword);

        $this->db->where($where);
        if ($search_where) {
            $this->db->where($search_where);
        } 

        $result = $this->db->get('cic_coin_stock')->row_array();
        return $result;
    }
    

}
?>