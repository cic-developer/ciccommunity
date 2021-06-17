<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CIC_forum_model class
 *
 * Copyright (c) RsTeam <www.rs-team.com>
 *
 * @author RsTeam (developer@rs-team.com)
 */

class CIC_forum_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'post';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'post_id'; // 사용되는 테이블의 프라이머리키

	public $allow_order = array('post_num, post_reply', 'post_datetime desc', 'post_datetime asc', 'post_hit desc', 'post_hit asc', 'post_comment_count desc', 'post_comment_count asc', 'post_comment_updated_datetime desc', 'post_comment_updated_datetime asc', 'post_like_point desc',  'post_dislike_point desc','post_dislike_point asc','post_id desc',);

	function __construct()
	{
		parent::__construct();
	}

	// CIC 포럼 게시물 리스트 가져오기
	public function get_post_list($limit = '', $offset = '', $where = '', $category_id = '', $orderby = '', $forder = 'asc', $sfield = '', $skeyword = '', $sop = 'OR')
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

		$this->db->select('post.*, member.mem_id, member.mem_userid, member.mem_nickname, member.mem_icon, member.mem_photo, member.mem_point, cic_member_level_config.*, cic_forum_info.*');
		$this->db->select_sum('cic_forum_cp.cfc_cp', 'cic_forum_total_cp');
		$this->db->from($this->_table);
		$this->db->join('cic_forum_cp', 'post.post_id = cic_forum_cp.pst_id', 'left');
		$this->db->join('cic_forum_info', 'post.post_id = cic_forum_info.pst_id', 'left');
		$this->db->join('member', 'post.mem_id = member.mem_id', 'left');
		$this->db->join('cic_member_level_config', 'member.mem_level = cic_member_level_config.mlc_level AND cic_member_level_config.mlc_enable = 1', 'left');

		if ($where) {
			$this->db->where($where);
			$this->db->group_by('post.post_id');
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

		$this->db->order_by($orderby, $forder);
		if ($limit) {
			$this->db->limit($limit, $offset);
		}
		$qry = $this->db->get();
		$result['list'] = $qry->result_array();

		$this->db->select('count(*) as rownum');
		$this->db->from($this->_table);
		// $this->db->join('cic_forum_cp', 'post.post_id = cic_forum_cp.pst_id', 'left');
		$this->db->join('cic_forum_info', 'post.post_id = cic_forum_info.pst_id', 'left');
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

	// CIC 포럼 게시물 가져오기
	public function get_one($primary_value = '', $select = '', $where = '')
	{
		$result = $this->_get($primary_value, $select, $where, 1);

		return $result->row_array();
	}

	public function _get($primary_value = '', $select = '', $where = '', $limit = '', $offset = 0, $findex = '', $forder = '')
	{
		if ($select) {
			$this->db->select($select);
		}

		$this->db->select('cic_forum_info.*, SUM(CASE WHEN  `cic_forum_cp`.`cfc_option` = 1 THEN `cic_forum_cp`.`cfc_cp` ELSE 0 END) AS `cic_A_cp`, SUM(CASE WHEN  `cic_forum_cp`.`cfc_option` = 2 THEN `cic_forum_cp`.`cfc_cp` ELSE 0 END) AS `cic_B_cp`');
		$this->db->select_sum('cic_forum_cp.cfc_cp', 'cic_forum_total_cp');

		// $this->db->from('$this->_table');
		$this->db->from('cic_forum_info');
		$this->db->join('cic_forum_cp', 'cic_forum_info.pst_id = cic_forum_cp.pst_id', 'left');

		if ($primary_value) {
			// $this->db->where($this->primary_key, $primary_value);
			$this->db->where('cic_forum_info.pst_id', $primary_value);
		}


		if ($where) {
			$this->db->where($where);
		}
		if ($findex) {
			if (strtoupper($forder) === 'RANDOM') {
				$forder = 'RANDOM';
			} elseif (strtoupper($forder) === 'DESC') {
				$forder = 'DESC';
			} else {
				$forder = 'ASC';
			}
			$this->db->order_by($findex, $forder);
		}
		if (is_numeric($limit) && is_numeric($offset)) {
			$this->db->limit($limit, $offset);
		}
		$result = $this->db->get();
		
		// => 주석을 해제하면 해당 query를 볼수 있습니다.
		// print_r($this->db->last_query());
		// exit;
		return $result;
	}

	// 포럼 배팅 확인
	public function get_forum_bat($where, $select = '')
	{
		if (empty($where)) {
			return false;
		}

		$this->db->select('cic_forum_cp.*');
		$this->db->from('cic_forum_cp');
		$this->db->where($where);
		$qry = $this->db->get();
		return $qry->result_array();
	}

	// 포럼 cp 배팅
	public function insert($data)
	{
		if ( ! empty($data)) {
			$this->db->insert('cic_forum_cp', $data);
			$insert_id = $this->db->insert_id();

			return $insert_id;
		} else {
			return false;
		}
	}

	// 포럼 cp 추가 배팅
	public function more_bat($primary_value = '', $updatedata = '', $where = '')
	{

		$this->db->where($where);
		$this->db->set($updatedata);
		$result = $this->db->update('cic_forum_cp');
		
		return $result;
	}
	// 포럼 배팅 진영 변경
	public function change_bat($primary_value = '', $updatedata = '', $where = '')
	{

		$this->db->where($where);
		$this->db->set($updatedata);
		$result = $this->db->update('cic_forum_cp');
		
		return $result;
	}
	// 포럼 배분 완료
	public function change_repart_state($primary_value = '', $updatedata = '', $where = '')
	{

		$this->db->where($where);
		$this->db->set($updatedata);
		$result = $this->db->update('cic_forum_info');
		
		return $result;
	}

	public function delete_forum_where($where = '', $table = '')
	{
		if (empty($where)) {
			return;
		}

		$this->db->where($where);
		if ($table == ''){
			$table = $this->_table;
		}else{
			$result = $this->db->delete($table);
		}

		return $result;
	}
}
