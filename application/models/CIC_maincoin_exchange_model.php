<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CIC Maincoin Exchange model class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

class CIC_maincoin_exchange_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cic_maincoin_exchange';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cme_idx'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

	function get_default_list(){
		$where = array(
			'cme_default' => '1'
		);
		return $this->get('', '', $where, '', '', 'cme_orderby', 'ASC');
	}

	function get_user_list($where_in){
		$this->db->where_in('cme_idx', $where_in);
		$result = $this->get();
		$return_data = array();
		foreach($where_in as $l){
			foreach($result as $r){
				if($l == element('cme_idx' ,$r)){
					$return_data[] = $r;
					break;
				}
			}
		}
		return $return_data;
	}

	function get_this_orderby(){
		$result = $this->_get('', 'cme_orderby', '', 1, '', 'cme_orderby', 'DESC');
		return element('cme_orderby', $result->row_array()) ? (int)element('cme_orderby', $result->row_array()) + 1 : 1;
	}

	function get_beside_exchange($cme_orderby, $type){
		if($type == 'up'){
			$where = array(
				'cme_orderby <' => $cme_orderby
			);
			$orderby = 'DESC';
		} else {
			$where = array(
				'cme_orderby >' => $cme_orderby
			);
			$orderby = 'ASC';
		}
		$result = $this->_get('', 'cme_idx, cme_orderby', $where, 1, 0, 'cme_orderby', $orderby);
		return $result->row_array();
	}
}

?>