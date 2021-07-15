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
		// 2021.06.29 member.mem_id -> post.mem_id 로 수정(한호인)
		$this->db->select('post.*, post.mem_id, member.mem_userid, member.mem_nickname, member.mem_icon, member.mem_photo, member.mem_point, cic_member_level_config.*, cic_forum_info.*,member.mem_forum_win,member.mem_forum_lose');
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

		$this->db->select('cic_forum_info.*, SUM(CASE WHEN  `cic_forum_cp`.`cfc_option` = 1 THEN `cic_forum_cp`.`cfc_cp` ELSE 0 END) AS `cic_A_cp`, SUM(CASE WHEN  `cic_forum_cp`.`cfc_option` = 2 THEN `cic_forum_cp`.`cfc_cp` ELSE 0 END) AS `cic_B_cp`, member.mem_forum_win, member.mem_forum_lose');
		$this->db->select_sum('cic_forum_cp.cfc_cp', 'cic_forum_total_cp');

		// $this->db->from('$this->_table');
		$this->db->from('cic_forum_info');
		$this->db->join('cic_forum_cp', 'cic_forum_info.pst_id = cic_forum_cp.pst_id',  'left');
		$this->db->join('post', 'post.post_id = cic_forum_info.pst_id', 'left outer');
		$this->db->join('member', 'post.mem_id = member.mem_id', 'left outer');

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

	public function get_one_apply_deadline($pst_id, $dead_line){
		$this->db->select('cic_forum_info.*, SUM(CASE WHEN  `cic_forum_cp`.`cfc_option` = 1 THEN `cic_forum_cp`.`cfc_cp` ELSE 0 END) AS `cic_A_cp`, SUM(CASE WHEN  `cic_forum_cp`.`cfc_option` = 2 THEN `cic_forum_cp`.`cfc_cp` ELSE 0 END) AS `cic_B_cp`, member.mem_forum_win, member.mem_forum_lose');
		$this->db->select_sum('cic_forum_cp.cfc_cp', 'cic_forum_total_cp');

		// $this->db->from('$this->_table');
		$this->db->from('cic_forum_info');
		$this->db->join('cic_forum_cp', 'cic_forum_info.pst_id = cic_forum_cp.pst_id',  'left');
		$this->db->join('post', 'post.post_id = cic_forum_info.pst_id', 'left outer');
		$this->db->join('member', 'post.mem_id = member.mem_id', 'left outer');
		$this->db->where('cic_forum_info.pst_id', $pst_id);
		$this->db->group_start()->where('cfc_vote_date',NULL)->or_where('cfc_vote_date <=', $dead_line)->group_end();

		$this->db->limit(1, 0);
		$result = $this->db->get()->row_array();
		return $result;
	}

	// 포럼 배팅 확인
	public function get_forum_bat($where, $select = '', $dead_line = '', $_morethan = '<=')
	{
		if (empty($where)) {
			return false;
		}

		$this->db->select('cic_forum_cp.*');
		$this->db->from('cic_forum_cp');
		$this->db->where($where);
		if($dead_line){
			$this->db->group_start()->where('cfc_vote_date',NULL)->or_where('cfc_vote_date '.$_morethan, $dead_line)->group_end();
		}
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

	public function mem_batting_cp($mem_id = ''){
		$this->db->select('sum(cfc_cp) as cfc_cp_sum, member.mem_forum_win as win, member.mem_forum_lose as lose, post.brd_id');
		$this->db->from('cic_forum_cp');
		$this->db->join('member', 'cic_forum_cp.mem_id = member.mem_id', 'right');
		$this->db->join('post', 'cic_forum_cp.pst_id = post.post_id', 'left');
		$this->db->join('cic_forum_info', 'cic_forum_info.pst_id = cic_forum_cp.pst_id', 'left');
		$this->db->where('cic_forum_cp.mem_id', $mem_id);
		$this->db->where('post.brd_id in(3,6)');

		$qry = $this->db->get();
		$result['mem_bat'] = $qry->row_array();

		return $result;
	}

	public function mem_join_forum($mem_id = ''){
		$this->db->select('(case post.post_category when 1 then post.brd_id when 2 then 0 when 0 then post.brd_id end) as ing');
		$this->db->from('post');
		$this->db->where('post.mem_id', $mem_id);
		$this->db->where('post.brd_id in (3,6)');
		$this->db->where('frm_repart_state', NULL);
		$this->db->join('cic_forum_info', 'post.post_id = cic_forum_info.pst_id', 'LEFT OUTER');
		$this->db->order_by('post.post_id', 'desc');
		$this->db->limit(1);

		$qry = $this->db->get();
		$result['mem_join_forum'] = $qry->row_array();
		// echo $this->db->last_query();
		// exit;

		return $result;
	}

	public function get_participated_forums($mem_id, $orderby = 'total_cp', $ordertype = 'DESC'){
		if(!$mem_id) return false;
		$result = array();
		$this->db->from('cic_forum_cp');
		$this->db->join('post', 'cic_forum_cp.pst_id = post.post_id', 'left');
		$this->db->join('cic_forum_info', 'cic_forum_cp.pst_id = cic_forum_info.pst_id', 'left');
		$this->db->join(
			'(SELECT pst_id, SUM(CASE WHEN  `cic_forum_cp`.`cfc_option` = 1 THEN `cic_forum_cp`.`cfc_cp` ELSE 0 END) AS `cic_A_cp`, SUM(CASE WHEN  `cic_forum_cp`.`cfc_option` = 2 THEN `cic_forum_cp`.`cfc_cp` ELSE 0 END) AS `cic_B_cp` FROM cic_forum_cp GROUP BY pst_id) AS sum_table',
			'sum_table.pst_id = cic_forum_cp.pst_id',
			'left'
		);
		$this->db->join('post_extra_vars', "post.post_id = post_extra_vars.post_id AND cfc_option = (CASE pev_key WHEN 'A_opinion' THEN 1 WHEN 'B_opinion' THEN 2 END)", 'left');
		$this->db->select('
			cic_forum_cp.*,
			post.*, 
			cic_forum_info.*, 
			(CASE WHEN cfc_option = 1 THEN (((cic_B_cp - (((cic_B_cp / 100) * frm_repart_reward) + ((cic_B_cp / 100) * frm_repart_commission))) / cic_A_cp) * cfc_cp) + cfc_cp
	 		WHEN cfc_option = 2 THEN (((cic_A_cp - (((cic_A_cp / 100) * frm_repart_reward) + ((cic_A_cp / 100) * frm_repart_commission))) / cic_B_cp) * cfc_cp) + cfc_cp END) AS expect_cp,
			(cic_A_cp + cic_B_cp) AS total_cp,
			pev_value
		');
		$_where = array(
			'post.brd_id' => 3,
			'frm_repart_state'	=> NULL,
			'cic_forum_cp.mem_id' => $mem_id
		);
		$this->db->where($_where);
		switch($orderby){
			case 'total_cp' :
				$this->db->order_by('total_cp', $ordertype);
			break;
			case 'cfc_cp' :
				$this->db->order_by('cfc_cp', $ordertype);
			break;
			case 'frm_close_datetime' :
				$this->db->order_by('frm_close_datetime', $ordertype);
			break;
			case 'frm_bat_close_datetime' :
				$this->db->order_by('frm_bat_close_datetime', $ordertype);
			break;
			case 'expect_cp' :
				$this->db->order_by('expect_cp', $ordertype);
			break;
		}
		$result['list'] = $this->db->get()->result_array();

		$this->db->from('cic_forum_cp');
		$this->db->join('post', 'cic_forum_cp.pst_id = post.post_id', 'left');
		$this->db->join('cic_forum_info', 'cic_forum_cp.pst_id = cic_forum_info.pst_id', 'left');
		$this->db->select('count(*) AS total_row');
		$_where = array(
			'post.brd_id' => 3,
			'frm_repart_state'	=> NULL,
			'cic_forum_cp.mem_id' => $mem_id
		);
		$this->db->where($_where);
		$result['total_row'] = element('total_row' ,$this->db->get()->row_array());
		// echo $this->db->last_query();exit;
		return $result;
	}

	public function get_mem_battingCP($mem_id){
		$this->db->select('sum(cp_point) AS total_cp');
		$this->db->from('cic_forum_using_for_winforum_view');
		$this->db->where('mem_id', $mem_id);

		$qry = $this->db->get();
		$_result = $qry->row_array();
		return element('total_cp', $_result);
	}

	//도전 포럼의 내 도전포럼용 포럼 리스트 가져오기
	function get_userforum($mem_id, $where){
		$this->db->from('post');
		$this->db->where($where);
		$this->db->where('post.mem_id', $mem_id);
		$this->db->join('post_extra_vars AS a', "post.post_id = a.post_id AND a.pev_key = 'A_opinion'");
		$this->db->join('post_extra_vars AS b', "post.post_id = b.post_id AND b.pev_key = 'B_opinion'");
		$this->db->select('post.*, a.pev_value AS a_opinion, b.pev_value AS b_opinion');
		return $this->db->get()->result_array();
	}
}
