<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Forum model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class CIC_forum_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cic_forum_config';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $meta_key = 'frm_key';

	public $meta_value = 'frm_value';

	public $cache_name= 'forum-model-get'; // 캐시 사용시 프리픽스

	public $cache_time = 86400; // 캐시 저장시간

	function __construct()
	{
		parent::__construct();
	}
	
	public function get_forum_list(){

		return ;
	}

	public function get_post_list($limit = '', $offset = '', $where = '', $category_id = '', $orderby = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{

		$sop = (strtoupper($sop) === 'AND') ? 'AND' : 'OR';
		if (empty($sfield)) {
			$sfield = array('post_title', 'post_content');
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

		$this->db->select('post.*, member.mem_id, member.mem_userid, member.mem_nickname, member.mem_icon, member.mem_photo, member.mem_point, cic_member_level_config.*');
		$this->db->from($this->_table);
		$this->db->join('member', 'post.mem_id = member.mem_id', 'left');
		$this->db->join('cic_member_level_config', 'member.mem_level = cic_member_level_config.mlc_level AND cic_member_level_config.mlc_enable = 1', 'left');

		if ($where) {
			$this->db->where($where);
		}
		if ($search_where) {
			$this->db->where($search_where);
		}
		if ($category_id) {
			if (strpos($category_id, '.')) {
				$this->db->like('post_category', $category_id . '', 'after');
			} else {
				$this->db->group_start();
				$this->db->where('post_category', $category_id);
				$this->db->or_like('post_category', $category_id . '.', 'after');
				$this->db->group_end();
			}
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
		$this->db->join('member', 'post.mem_id = member.mem_id', 'left');
		$this->db->join('cic_member_level_config', 'member.mem_level = cic_member_level_config.mlc_level AND cic_member_level_config.mlc_enable = 1', 'left');
		if ($where) {
			$this->db->where($where);
		}
		if ($search_where) {
			$this->db->where($search_where);
		}
		if ($category_id) {
			if (strpos($category_id, '.')) {
				$this->db->like('post_category', $category_id . '', 'after');
			} else {
				$this->db->group_start();
				$this->db->where('post_category', $category_id);
				$this->db->or_like('post_category', $category_id . '.', 'after');
				$this->db->group_end();
			}
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
}
