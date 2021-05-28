<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CIC Maincoin Coin model class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

class CIC_maincoin_coin_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cic_maincoin_coin';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cmc_idx'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

	function get_default_list(){
		$where = array(
			'cmc_default' => '1'
		);
		$result = $this->get('', '', $where, '', '', 'cmc_orderby', 'ASC');
		foreach($result as $val){
			$this->db->where(array(
				'cmcd_cmc_idx' => element('cmc_idx', $val),
			));
			$detail_data = $this->db->get('cic_maincoin_coin_detail')->result_array();
			$val['coin_detail'] = array();
			foreach($detail_data as $thisData){
				$val['coin_detail'][element('cmcd_cme_idx', $thisData)] = $thisData;
			}
		}
		return $result;
	}

	function get_user_list($where_in){
		$this->db->where_in('cmc_idx', $where_in);
		return $this->get();
	}

	function get_this_orderby(){
		$result = $this->_get('', 'cmc_orderby', '', 1, '', 'cmc_orderby', 'DESC');
		return element('cmc_orderby', $result->row_array()) ? (int)element('cmc_orderby', $result->row_array()) + 1 : 1;
	}

	function get_beside_coin($cmc_orderby, $type){
		if($type == 'up'){
			$where = array(
				'cmc_orderby >' => $cmc_orderby
			);
			$orderby = 'ASC';
		} else {
			$where = array(
				'cmc_orderby <' => $cmc_orderby
			);
			$orderby = 'DESC';
		}
		$result = $this->_get('', 'cmc_idx, cmc_orderby', $where, 1, 0, 'cmc_orderby', $orderby);
		return $result->row_array();
	}
}

?>