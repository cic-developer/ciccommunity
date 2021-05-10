<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Search Keyword model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Search_keyword_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'search_keyword';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'sek_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}


	public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = 'search_keyword.*, member.mem_id, member.mem_userid, member.mem_nickname, member.mem_is_admin, member.mem_icon';
		$join[] = array('table' => 'member', 'on' => 'search_keyword.mem_id = member.mem_id', 'type' => 'left');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
	}


	public function get_rank($start_date = '', $end_date = '')
	{
		if (empty($start_date) OR empty($end_date)) {
			return false;
		}

		$this->db->where('left(sek_datetime, 10) >=', $start_date);
		$this->db->where('left(sek_datetime, 10) <=', $end_date);
		$this->db->select('sek_keyword');
		$qry = $this->db->get($this->_table);
		$result = $qry->result_array();

		return $result;
	}

	function get_main_rank(){
		$start_date = cadte('Y-m-d', strtotime('-3 days'));
		$end_date = cadte('Y-m-d');
		$result = $this->get_rank($start_date, $end_date);

		$sum_count = 0;
		$arr = array();
		$max = 0;

		if ($result && is_array($result)) {
			foreach ($result as $key => $value) {
				$s = element('sek_keyword', $value);
				if ( ! isset($arr[$s])) {
					$arr[$s] = 0;
				}
				$arr[$s]++;

				if ($arr[$s] > $max) {
					$max = $arr[$s];
				}
				$sum_count++;

			}
		}

		$view['view']['list'] = array();
		$i = 0;
		$k = 0;
		$save_count = -1;
		$tot_count = 0;

		if (count($arr)) {
			arsort($arr);
			foreach ($arr as $key => $value) {
				$count = (int) $arr[$key];
				$view['view']['list'][$k]['count'] = $count;
				$i++;
				if ($save_count !== $count) {
					$no = $i;
					$save_count = $count;
				}
				$view['view']['list'][$k]['no'] = $no;

				$view['view']['list'][$k]['key'] = $key;
				$rate = ($count / $sum_count * 100);
				$view['view']['list'][$k]['rate'] = $rate;
				$s_rate = number_format($rate, 1);
				$view['view']['list'][$k]['s_rate'] = $s_rate;

				$bar = (int)($count / $max * 100);
				$view['view']['list'][$k]['bar'] = $bar;
				$k++;
			}

			$view['view']['max_value'] = $max;
			$view['view']['sum_count'] = $sum_count;
		}

		$view['view']['start_date'] = $start_date;
		$view['view']['end_date'] = $end_date;
		return $view['view']['list'];
	}
}
