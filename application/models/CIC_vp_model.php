<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Point model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
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
		$like = '';
		$sfield = '';
		$skeyword = '';
		print_r("test....ing....");
		print_r("<br>");
		print_r("<hr>");
		print_r("<br>");
		print_r($limit);
		print_r("<br>");
		print_r($offset);
		print_r("<br>");
		print_r($where);
		print_r("<br>");
		print_r($like);
		print_r("<br>");
		print_r($findex);
		print_r("<br>");
		print_r($forder);
		print_r("<br>");
		print_r($sfield);
		print_r("<br>");
		print_r($skeyword);
		print_r("<br>");
		print_r($sop);
		$select = 'cic_vp.*, member.mem_userid, member.mem_nickname, member.mem_is_admin, member.mem_icon, member.mem_vp';
		$join[] = array('table' => 'member', 'on' => 'cic_vp.mem_id = member.mem_id', 'type' => 'left');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		print_r("<hr>");

		print_r("<hr>");
		print_r($result);
		exit;
		return $result;
	}

	public function get_vp_list($limit = '', $offset = '', $where = '', $category_id = '', $orderby = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$sfield = array('vp_id');
		// $sop = (strtoupper($sop) === 'AND') ? 'AND' : 'OR';
		// if (empty($sfield)) {
		// 	$sfield = array('vp_id', 'post_content');
		// }

		$search_where = array();
		$search_like = array();
		$search_or_like = array();
		if ($sfield && is_array($sfield)) {
			foreach ($sfield as $skey => $sval) {
				$ssf = $sval;
				if ($skeyword && $ssf && in_array($ssf, $this->allow_search_field)) {
					if (in_array($ssf, $this->search_field_equal)) {
						$search_where[$ssf] = $skeyword;
					} else {
						$swordarray = explode(' ', $skeyword);
						foreach ($swordarray as $str) {
							if (empty($ssf)) {
								continue;
							}
							if ($sop === 'AND') {
								$search_like[] = array($ssf => $str);
							} else {
								$search_or_like[] = array($ssf => $str);
							}
						}
					}
				}
			}
		} else {
			$ssf = $sfield;
			if ($skeyword && $ssf && in_array($ssf, $this->allow_search_field)) {
				if (in_array($ssf, $this->search_field_equal)) {
					$search_where[$ssf] = $skeyword;
				} else {
					$swordarray = explode(' ', $skeyword);
					foreach ($swordarray as $str) {
						if (empty($ssf)) {
							continue;
						}
						if ($sop === 'AND') {
							$search_like[] = array($ssf => $str);
						} else {
							$search_or_like[] = array($ssf => $str);
						}
					}
				}
			}
		}

		$this->db->select('cic_vp.*, member.mem_userid, member.mem_nickname, member.mem_is_admin, member.mem_icon, member.mem_vp');
		$this->db->from($this->_table);
		$this->db->join('member', 'cic_vp.mem_id = member.mem_id', 'left');

		if ($where) {
			$this->db->where($where);
		}
		if ($search_where) {
			$this->db->where($search_where);
		}
		if ($like) {
			$this->db->like($like);
		}
		if ($search_like) {
			foreach ($search_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->like($skey, $sval);
				}
			}
		}
		if ($search_or_like) {
			$this->db->group_start();
			foreach ($search_or_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->or_like($skey, $sval);
				}
			}
			$this->db->group_end();
		}
		$this->db->order_by($orderby);
		if ($limit) {
			$this->db->limit($limit, $offset);
		}
		$qry = $this->db->get();
		$result['list'] = $qry->result_array();
		
		$this->db->select('count(*) as rownum');
		$this->db->from($this->_table);
		$this->db->join('member', 'cic_vp.mem_id = member.mem_id', 'left');
		if ($where) {
			$this->db->where($where);
		}
		if ($search_where) {
			$this->db->where($search_where);
		}
		if ($like) {
			$this->db->like($like);
		}
		if ($search_like) {
			foreach ($search_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->like($skey, $sval);
				}
			}
		}
		if ($search_or_like) {
			$this->db->group_start();
			foreach ($search_or_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->or_like($skey, $sval);
				}
			}
			$this->db->group_end();
		}
		$qry = $this->db->get();
		$rows = $qry->row_array();
		$result['total_rows'] = $rows['rownum'];

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
