<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CIC_vp_model class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

class CIC_vp_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cic_vp';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'vp_id'; // 사용되는 테이블의 프라이머리키

	// public $allow_order = array('vp_id');

	function __construct()
	{
		parent::__construct();
	}


	public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = 'cic_vp.*, member.mem_userid, member.mem_nickname, member.mem_is_admin, member.mem_icon, member.mem_vp';
		$join[] = array('table' => 'member', 'on' => 'cic_vp.mem_id = member.mem_id', 'type' => 'left');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		echo $select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop;
		return $result;
	}

	public function get_point_sum($mem_id = 0)
	{
		$mem_id = (int) $mem_id;
		if (empty($mem_id) OR $mem_id < 1) {
			return 0;
		}

		$this->db->select_sum('vp_point');
		$this->db->where(array('mem_id' => $mem_id));
		$result = $this->db->get('cic_vp');
		$result = $result->row_array();
		
		return $result['vp_point'] ? $result['vp_point'] : 0;
	}


	public function point_ranking_all($limit = '')
	{
		if (empty($limit)) {
			$limit = 100;
		}
		$this->db->select_sum('vp_point');
		$this->db->select('member.mem_id, member.mem_userid, member.mem_nickname, member.mem_is_admin, member.mem_icon');
		$this->db->join('member', 'cic_vp.mem_id = member.mem_id', 'inner');
		$this->db->where('member.mem_denied', 0);
		$this->db->where('member.mem_is_admin', 0);
		$this->db->where('vp_point >', 0);
		$this->db->group_by('member.mem_id');
		$this->db->order_by('vp_point', 'DESC');
		$this->db->limit($limit);
		$qry = $this->db->get('cic_vp');
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

		$this->db->select_sum('vp_point');
		$this->db->select('member.mem_id, member.mem_userid, member.mem_nickname, member.mem_is_admin, member.mem_icon');
		$this->db->join('member', 'cic_vp.mem_id = member.mem_id', 'inner');
		$this->db->where('member.mem_denied', 0);
		$this->db->where('member.mem_is_admin', 0);
		$this->db->where('cic_vp.vp_datetime >=', $start_datetime);
		$this->db->where('cic_vp.vp_datetime <=', $end_datetime);
		$this->db->where('vp_point >', 0);
		$this->db->group_by('member.mem_id');
		$this->db->order_by('vp_point', 'DESC');
		$this->db->limit($limit);
		$qry = $this->db->get('cic_vp');
		$result = $qry->result_array();

		return $result;
	}


	public function member_count_by_point_count($point_count = 10, $datetime = '')
	{
		if (empty($datetime)) {
			$datetime = ctimestamp() - 30 * 24 * 60 * 60;
		}
		$this->db->select('count(*) as cnt');
		$this->db->where('vp_datetime <=', $datetime);
		$this->db->group_by('mem_id');
		$this->db->having('cnt >', $point_count);
		$qry = $this->db->get('cic_vp');
		$result = $qry->result_array();

		return $result;
	}


	public function member_list_by_point_count($point_count = 10, $datetime = '')
	{
		if (empty($datetime)) {
			$datetime = ctimestamp() - 30 * 24 * 60 * 60;
		}
		$this->db->select('mem_id, count(*) as cnt, sum(vp_point) as sum_point');
		$this->db->where('vp_datetime <=', $datetime);
		$this->db->group_by('mem_id');
		$this->db->having('cnt >', $point_count);
		$this->db->order_by('cnt', 'DESC');
		$this->db->limit(100);
		$qry = $this->db->get('cic_vp');
		$result = $qry->result_array();

		return $result;
	}
}
