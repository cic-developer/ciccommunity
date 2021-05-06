<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Member Nickname model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Test_withdraw_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'test_withdraw';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'wid_idx'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}


	public function get_test_withdraw_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$result = $this->db->get('cic_withdraw');

		return $result;
	}
}
