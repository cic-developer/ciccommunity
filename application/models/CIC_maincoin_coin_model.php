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

	function get_this_orderby(){
		$result = $this->_get('', 'cmc_orderby', '', 1, '', 'cmc_orderby', 'DESC');
		return element('cmc_orderby', $result->row_array()) ? (int)element('cmc_orderby', $result->row_array()) + 1 : 1;
	}
}

?>