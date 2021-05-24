<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CIC Maincoin List model class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

class CIC_maincoin_list_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cic_maincoin_list';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cml_idx'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

	function get_this_orderby(){
		$result = $this->_get('', 'cml_orderby', $where, 1, '', 'cml_orderby', 'DESC');
		return element('cml_orderby', $result->row_array()) ? (int)element('cml_orderby', $result->row_array()) + 1 : 1;
	}
}

?>