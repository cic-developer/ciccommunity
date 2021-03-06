<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Member model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Member_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'member';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'mem_id'; // 사용되는 테이블의 프라이머리키

	public $search_sfield = '';

	function __construct()
	{
		parent::__construct();
	}


	public function get_by_memid($memid = 0, $select = '')
	{
		$memid = (int) $memid;
		if (empty($memid) OR $memid < 1) {
			return false;
		}
		$where = array('mem_id' => $memid);
		
		return $this->get_one('', $select, $where);
	}


	public function get_by_userid($userid = '', $select = '')
	{
		if (empty($userid)) {
			return false;
		}
		$where = array('mem_userid' => $userid);
		return $this->get_one('', $select, $where);
	}


	public function get_by_email($email = '', $select = '')
	{
		if (empty($email)) {
			return false;
		}
		$where = array('mem_email' => $email);
		return $this->get_one('', $select, $where);
	}


	public function get_by_both($str = '', $select = '')
	{
		if (empty($str)) {
			return false;
		}
		if ($select) {
			$this->db->select($select);
		}
		$this->db->from($this->_table);
		$this->db->where('mem_userid', $str);
		$this->db->or_where('mem_email', $str);
		$result = $this->db->get();
		return $result->row_array();
	}


	public function get_superadmin_list($select='')
	{
		$where = array(
			'mem_is_admin' => 1,
			'mem_denied' => 0,
		);
		$result = $this->get('', $select, $where);

		return $result;
	}


	public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$join = array();
		if (isset($where['mgr_id'])) {
			$select = 'member.*';
			$join[] = array('table' => 'member_group_member', 'on' => 'member.mem_id = member_group_member.mem_id', 'type' => 'left');
		}
		$result = $this->_get_list_common($select = '', $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);

		return $result;
	}


	public function get_register_count($type = 'd', $start_date = '', $end_date = '', $orderby = 'asc')
	{
		if (empty($start_date) OR empty($end_date)) {
			return false;
		}
		$left = ($type === 'y') ? 4 : ($type === 'm' ? 7 : 10);
		if (strtolower($orderby) !== 'desc') $orderby = 'asc';

		$this->db->select('count(*) as cnt, left(mem_register_datetime, ' . $left . ') as day ', false);
		$this->db->where('left(mem_register_datetime, 10) >=', $start_date);
		$this->db->where('left(mem_register_datetime, 10) <=', $end_date);
		$this->db->where('mem_denied', 0);
		$this->db->group_by('day');
		$this->db->order_by('mem_register_datetime', $orderby);
		$qry = $this->db->get($this->_table);
		$result = $qry->result_array();

		return $result;
	}

	public function set_user_point($primary_value = '', $money, $mem_cp)
	{

		$arr = array(
			'mem_cp' => (double)$mem_cp-(double)$money,
		);

		$result = $this->update($primary_value, $arr);

		return $result;
	}

	public function set_user_modify($primary_value = '', $arr)
	{
		if($primary_value){
			$result = $this->update($primary_value, $arr);
		}else{
			$result = false;
		}

		return $result;
	}

	public function get_by_memDI($DI, $select = '')
	{
		if (empty($DI)) {
			return false;
		}
		$where = array('mem_dup_info' => $DI);
		return $this->get_one('', $select, $where);
	}
	
	public function get_by_memPhone($mem_phone, $select = '')
	{
		if (empty($mem_phone)) {
			return false;
		}
		$where = array('mem_phone' => $mem_phone);
		return $this->get_one('', $select, $where);
	}

	public function get_by_memWallet($mem_wallet, $select = '')
	{
		if (empty($mem_wallet)) {
			return false;
		}
		$where = array('mem_wallet_address' => $mem_wallet);
		return $this->get_one('', $select, $where);
	}

	//
	public function getMembersIsDeposit()
	{
        
		$join = array();
		// $select = 'member.* post.*';
		$this->db->select('member.mem_id, member.mem_deposit, member.mem_cp'); //, post.post_id, cic_forum_info.frm_repart_state');
		// $join[] = array('table' => 'post', 'on' => 'member.mem_id = post.mem_id', 'type' => 'left');
		// $join[] = array('table' => 'cic_forum_info', 'on' => 'cic_forum_info.pst_id = post.post_id', 'type' => 'left');
		$where = array(
			'member.mem_deposit <>' => null,
			// 'post.brd_id' => 3,
			// 'cic_forum_info.frm_repart_state' => null,
		);
        
		$result = $this->_get_list_common($select = '', $join, '', '', $where, '', '', '', '', '', '');
        
		return $result;
	}

	public function getMemIdsForReturnToCp_userforum()
	{
        
		$join = array();
		// $select = 'member.* post.*';
		$this->db->select('member.mem_id, member.mem_deposit, member.mem_cp'); //, post.post_id, post.post_category');
		$join[] = array('table' => 'post', 'on' => 'member.mem_id = post.mem_id', 'type' => 'left');
		$where = array(
			'member.mem_deposit <>' => null,
			'post.brd_id' => 6,
			// 'post.post_category <>' => 2,
		);
        
		$result = $this->_get_list_common($select = '', $join, '', '', $where, '', '', '', '', '', '');
        
		return $result;
	}
}
