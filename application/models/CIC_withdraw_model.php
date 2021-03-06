<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CIC_withdraw_model class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

class CIC_withdraw_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cic_withdraw';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'wid_idx'; // 사용되는 테이블의 프라이머리키

	public $search_sfield = '';

	function __construct()
	{
		parent::__construct();
	}

	// public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	// {
	// 	$join = array();
	// 	// if (isset($where['mgr_id'])) {
			
	// 			echo "<script>alert(\"이렇게 띄우면 되자나\");</script>";
			

	// 		// $select = 'member.*';
	// 		// $join[] = array('table' => 'member_group_member', 'on' => 'member.mem_id = member_group_member.mem_id', 'type' => 'left');
	// 	// }
	// 	// $result = $this->_get_list_common($select = '', $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);

	// 	// return $result;
	// 	return null;
	// }


	public function get_withdraw_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		// $result['list'] = $this->db->get('cic_withdraw')->result_array();

		$select = 'cic_withdraw.*';
		// $join[] = array('table' => 'member_group_member', 'on' => 'member.mem_id = member_group_member.mem_id', 'type' => 'left');
		// $join[] = null;
		$join[] = array();
		
		$result = $this->_get_list_common($select = '', $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);

		return $result;
	}

	public function set_withdraw_approve($primary_value = '', $adminid, $adminip, $transaction, $percoin, $content, $memo='')
	{
		$arr = array(
			'wid_memo' => $memo,
			'wid_content' => $content,
			'wid_percoin' => $percoin,
			'wid_transaction' => $transaction,
			'wid_admin_ip' => $adminip,
			'wid_admin_id' => $adminid,
			'wid_res_datetime'=> date("Y-m-d H:i:s"),
			'wid_state' => 1
		);

		$result = $this->update($primary_value, $arr);
		return $result;
	}

	public function set_withdraw_retire($primary_value = '', $content = '', $adminid, $adminip, $memo = '')
	{
		$arr = array(
			'wid_memo' => $memo,
			'wid_content' => $content,
			'wid_admin_id' => $adminid,
			'wid_admin_ip' => $adminip,
			'wid_res_datetime'=> date("Y-m-d H:i:s"),
			'wid_state' => 0
		);

		$result = $this->update($primary_value, $arr);
		return $result;
	}

	public function set_withdraw($mem_id = 0, $mem_userid = '', $mem_userip = '', $mem_nickname = '', $mem_wallet_address = '', $_money = 0, $money = 0 , $withdraw_deposit = 0)
	{

		$arr = array(
			'wid_mem_idx' => $mem_id,
			'wid_userid' => $mem_userid,
			'wid_userip' => $mem_userip,
			'wid_nickname' => $mem_nickname,
			'wid_wallet_address' => $mem_wallet_address,
			'wid_commission' => $withdraw_deposit,
			'wid_req_money' => $_money,
			'wid_cal_money' => $money,
			'wid_req_datetime' => date("Y-m-d H:i:s"),
		);

		$result = $this->insert($arr);

		return $result;
	}
}
