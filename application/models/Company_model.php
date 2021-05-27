<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Board model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Company_model extends CB_Model
{
    /**
	 * 테이블명
	 */
	public $_table = 'company';

    /**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'comp_id'; // 사용되는 테이블의 프라이머리키

	public $cache_prefix = 'company/company-model-get-'; // 캐시 사용시 프리픽스

	public $cache_time = 86400; // 캐시 저장시간

    function __construct()
	{
		parent::__construct();

		check_cache_dir('company');
	}

    public function get_company_list($limit = '', $offset = '', $where = '', $category_id = '', $orderby = '', $sfield = '', $skeyword = '', $sop = 'OR')
    {

        if ( ! in_array(strtolower($orderby), $this->allow_order)) {
			$orderby = 'comp_id asc';
		}
		
		$sop = (strtoupper($sop) === 'AND') ? 'AND' : 'OR';
		if (empty($sfield)) {
			$sfield = array('comp_name');
		}
		
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

		$this->db->select('company.*, ');
		$this->db->from($this->_table);
		// $this->db->join('news', 'company.comp_id = news.comp_id', 'left');
		if ($where) {
			$this->db->where($where);
		}
		if ($search_where) {
			$this->db->where($search_where);
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
		// $this->db->join('news', 'company.comp_id = news.comp_id', 'left');
		

		if ($where) {
			$this->db->where($where);
		}
		if ($search_where) {
			$this->db->where($search_where);
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

		// print_r($result);
		// exit;

		return $result;
    }

	public function get_one($primary_value = '', $select = '', $where = '')
	{
		$use_cache = false;
		if ($primary_value && empty($select) && empty($where)) {
			$use_cache = true;
		}

		if ($use_cache) {
			$cachename = $this->cache_prefix . $primary_value;
			if ( ! $result = $this->cache->get($cachename)) {
				$result = parent::get_one($primary_value);
				$this->cache->save($cachename, $result, $this->cache_time);
			}
		} else {
			$result = parent::get_one($primary_value, $select, $where);
		}
		return $result;
	}

    public function delete($primary_value = '', $where = '')
	{
		if (empty($primary_value)) {
			return false;
		}
		$result = parent::delete($primary_value);
		$this->cache->delete($this->cache_prefix . $primary_value);
		return $result;
	}

    public function update($primary_value = '', $updatedata = '', $where = '')
	{
		if (empty($primary_value)) {
			return false;
		}

		$result = parent::update($primary_value, $updatedata);
		if ($result) {
			$this->cache->delete($this->cache_prefix . $primary_value);
		}
		return $result;
	}

	// public function updatecompany($data = array())
	// {
	// 	$now_date = cdate('Y-m-d H:i:s');
	// 	if(elemet('comp_id', $data && is_array(element('comp_id', $data)))) {
	// 		foreach ( element('comp_id', $data) as $key => $value) {
	// 			if (! element($key, element()))
	// 		}
	// 	}
	// }
}