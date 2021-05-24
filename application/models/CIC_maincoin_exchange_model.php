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

	function get_this_orderby(){
		$result = $this->_get('', 'cme_orderby', $where, 1, '', 'cme_orderby', 'DESC');
		return element('cme_orderby', $result->row_array()) ? (int)element('cme_orderby', $result->row_array()) + 1 : 1;
	}
}

?>