<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Attendance model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Attendance_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'attendance';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'att_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}


	public function get_attend_list($limit = '', $offset = '', $where = '', $findex = '', $forder = '', $sfile = '', $skeyword = '')
	{
		$this->db->select('attendance.*, member.mem_id, member.mem_userid, member.mem_nickname, member.mem_is_admin, member.mem_icon');
		if ($where) {
			$this->db->where($where);
		}
		if($sfile && $skeyword){
			$this->db->like($sfile, $skeyword);
		}
		$this->db->order_by($findex, $forder);
		if ($limit) {
			$this->db->limit($limit, $offset);
		}
		$this->db->join('member', 'attendance.mem_id = member.mem_id', 'inner');
		$qry = $this->db->get($this->_table);
		$result['list'] = $qry->result_array();

		$this->db->select('count(*) as rownum');
		if ($where) {
			$this->db->where($where);
		}
		if($sfile && $skeyword){
			$this->db->like($sfile, $skeyword);
		}
		$this->db->join('member', 'attendance.mem_id = member.mem_id', 'inner');
		$qry = $this->db->get($this->_table);
		$rows = $qry->row_array();
		$result['total_rows'] = $rows['rownum'];

		return $result;
	}


	public function yesterday_data()
	{
		$yesterday = cdate('Y-m-d', ctimestamp() - 86400);
		$mem_id = (int) $this->member->item('mem_id');

		$where = array(
			'att_date' => $yesterday,
			'mem_id' => $mem_id,
		);
		$this->db->where($where);
		$qry = $this->db->get($this->_table);
		$result = $qry->row_array();
		return $result;
	}


	public function today_attended()
	{
		$today = cdate('Y-m-d');
		$mem_id = (int) $this->member->item('mem_id');
		$where = array(
			'att_date' => $today,
			'mem_id' => $mem_id,
		);
		$this->db->where($where);
		return $this->db->count_all_results($this->_table);
	}


	public function get_today_max_ranking()
	{
		$today = cdate('Y-m-d');
		$where = array(
			'att_date' => $today,
		);
		$this->db->select_max('att_ranking');
		$this->db->where($where);
		$qry = $this->db->get($this->_table);
		$result = $qry->row_array();
		return $result;
	}

	public function get_this_month_attend($_date){
		$this->load->library('member');
		$mem_id = $this->member->is_member();
		if($mem_id){
			$where = array(
				'mem_id' => $mem_id,
				'att_date >=' => $_date,
				'att_date <' => cdate('Y-m-01', strtotime('+1 month', strtotime($_date))),
			);
			$result = $this->get('', '', $where);
			$return = array();
			foreach($result as $val){
				$return[] = (int)cdate('d', strtotime($val['att_date']));
			}
			return $return;
		} else {
			return array();
		}
	}
}
