<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Point model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class CIC_cp_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cic_cp';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cp_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}


	public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = 'cic_cp.*, member.mem_userid, member.mem_nickname, member.mem_is_admin, member.mem_icon, member.mem_cp';
		$join[] = array('table' => 'member', 'on' => 'cic_cp.mem_id = member.mem_id', 'type' => 'left');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);

		return $result;
	}


	public function get_point_sum($mem_id = 0)
	{
		$mem_id = (int) $mem_id;
		if (empty($mem_id) OR $mem_id < 1) {
			return 0;
		}

		$this->db->select_sum('cp_point');
		$this->db->where(array('mem_id' => $mem_id));
		$result = $this->db->get('cic_cp');
		$result = $result->row_array();

		return $result['cp_point'] ? $result['cp_point'] : 0;
	}


	public function point_ranking_all($limit = '')
	{
		if (empty($limit)) {
			$limit = 100;
		}
		$this->db->select_sum('cp_point');
		$this->db->select('member.mem_id, member.mem_userid, member.mem_nickname, member.mem_is_admin, member.mem_icon');
		$this->db->join('member', 'cic_cp.mem_id = member.mem_id', 'inner');
		$this->db->where('member.mem_denied', 0);
		$this->db->where('member.mem_is_admin', 0);
		$this->db->where('cp_point >', 0);
		$this->db->group_by('member.mem_id');
		$this->db->order_by('cp_point', 'DESC');
		$this->db->limit($limit);
		$qry = $this->db->get('cic_cp');
		$result = $qry->result_array();

		return $result;
	}


	public function point_ranking_month($year = 0, $month = 0, $limit = 0)
	{
		$year = (int) $year;
		if ($year<1000 OR $year > 2999) {
			$year = cdate('Y');
		}

		$month = (int) $month;
		if ($month < 1 OR $month > 12) {
			$month = (int) cdate('m');
		}
		$month = sprintf("%02d", $month);

		$start_datetime = $year . '-' . $month . '-01 00:00:00';
		$end_datetime = $year . '-' . $month . '-31 23:59:59';

		if (empty($limit)) {
			$limit = 100;
		}

		$this->db->select_sum('cp_point');
		$this->db->select('member.mem_id, member.mem_userid, member.mem_nickname, member.mem_is_admin, member.mem_icon');
		$this->db->join('member', 'cic_cp.mem_id = member.mem_id', 'inner');
		$this->db->where('member.mem_denied', 0);
		$this->db->where('member.mem_is_admin', 0);
		$this->db->where('cic_cp.cp_datetime >=', $start_datetime);
		$this->db->where('cic_cp.cp_datetime <=', $end_datetime);
		$this->db->where('cp_point >', 0);
		$this->db->group_by('member.mem_id');
		$this->db->order_by('cp_point', 'DESC');
		$this->db->limit($limit);
		$qry = $this->db->get('cic_cp');
		$result = $qry->result_array();

		return $result;
	}


	public function member_count_by_point_count($point_count = 10, $datetime = '')
	{
		if (empty($datetime)) {
			$datetime = ctimestamp() - 30 * 24 * 60 * 60;
		}
		$this->db->select('count(*) as cnt');
		$this->db->where('cp_datetime <=', $datetime);
		$this->db->group_by('mem_id');
		$this->db->having('cnt >', $point_count);
		$qry = $this->db->get('cic_cp');
		$result = $qry->result_array();

		return $result;
	}


	public function member_list_by_point_count($point_count = 10, $datetime = '')
	{
		if (empty($datetime)) {
			$datetime = ctimestamp() - 30 * 24 * 60 * 60;
		}
		$this->db->select('mem_id, count(*) as cnt, sum(cp_point) as sum_point');
		$this->db->where('cp_datetime <=', $datetime);
		$this->db->group_by('mem_id');
		$this->db->having('cnt >', $point_count);
		$this->db->order_by('cnt', 'DESC');
		$this->db->limit(100);
		$qry = $this->db->get('cic_cp');
		$result = $qry->result_array();

		return $result;
	}

	public function set_cp_retire($content = '출금반려', $memIdx = 0, $money = 0)
	{

		$arr = array(
			'mem_id'=> $memIdx,
			'cp_datetime' => date("Y-m-d H:i:s"),
			'cp_content' => $content,
			'cp_point' => $money,
			'cp_type' => '@byadmin',
			'cp_related_id' => $memIdx,
			'cp_action' => '출금반려'
		);

		$result = $this->insert($arr);
		return $result;
	}

	public function set_cic_cp($memIdx = 0, $content = '' , $money = 0 , $type = '', $action = '')
	{

		$login_mem_id = $this->member->item('mem_id');
		
		$arr = array(
			'mem_id'=> $memIdx,
			'cp_datetime' => date("Y-m-d H:i:s"),
			'cp_content' => $content,
			'cp_point' => $money,
			'cp_type' => $type,
			'cp_related_id' => $login_mem_id,
			'cp_action' => $action
		);

		$result = $this->insert($arr);
		return $result;
	}
}
