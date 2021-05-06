<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Member Nickname model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class CIC_withdraw_log_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cic_withdraw_log';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cwl_idx'; // 사용되는 테이블의 프라이머리키

	public $search_sfield = '';

	function __construct()
	{
		parent::__construct();
	}

	public function get_withdraw_log_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = 'cic_withdraw_log.*';
		// $join[] = array('table' => 'member_group_member', 'on' => 'member.mem_id = member_group_member.mem_id', 'type' => 'left');
		$join[] = null;
		
		$result = $this->get_admin_list($limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);

		return $result;
	}

	public function set_withdraw_log($content = '', $address='', $adminid= '' , $adminip= '', $userid='', $userip='', $money = 0, $result = '')
	{
		$arr = array(
			'cwl_wallet_address' => $address,
			'cwl_res_admin_id' => $adminid,
			'cwl_req_user_id' => $userid,
			'cwl_res_admin_ip' => $adminip,
			'cwl_req_user_ip' => $userip,
			'cwl_cp_point' => $money,
			'cwl_content' => $content,
			'cwl_datetime' => date("Y-m-d H:i:s"),
			'cwl_result' => $result
		);

		$result = $this->insert($arr);

		return $result;
	}

}