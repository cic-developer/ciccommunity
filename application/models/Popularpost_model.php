<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Post History model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Popularpost_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'post';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'post_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

	public function upadte_post_exept_state($post_id)
	{
		$where = array(
			'post_id' => $post_id,
		);
		$updatedata = array(
			'post_exept_state' => 1,
		);
		$this->db->where($where);
		$this->db->set($updatedata);

		return $this->db->update($this->_table);
	}
	

	public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = 'post.*, post.mem_id as member.mem_id, 
			member.mem_id, member.mem_userid,
			member.mem_username, member.mem_nickname, member.mem_is_admin, member.mem_icon';
		$join[] = array('table' => 'member', 'on' => 'post.mem_id = member.mem_id', 'type' => 'left');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);

		return $result;
	}


	public function get_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = 'post.*, post.mem_id as mem.mem_id, 
			member.mem_id, member.mem_userid,
			member.mem_username, member.mem_nickname, member.mem_is_admin, member.mem_icon';
		$join[] = array('table' => 'member', 'on' => 'post.mem_id = member.mem_id', 'type' => 'left');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);

		return $result;
	}
}
