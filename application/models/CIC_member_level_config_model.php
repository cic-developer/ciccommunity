<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CIC_member_level_config_model class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

class CIC_member_level_config_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cic_member_level_config';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'mlc_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

	function get_by_pointSum($pointSum = 0)
	{
		if($pointSum >= 0){
			$this->db->where('mlc_target_point <=', $pointSum);
			$this->db->where('mlc_enable', 1);
			$this->db->order_by('mlc_target_point','DESC');
		}else{
			$this->db->where('mlc_target_point >=', $pointSum);
			$this->db->where('mlc_enable', 1);
			$this->db->order_by('mlc_target_point','ASC');
		}
		$this->db->limit(1);
		$result = $this->db->get('cic_member_level_config')->row_array();
		return $result;
	}

	function get_by_level($level = 0){
		if($level >= 0){
			$this->db->where('mlc_level <=', $level);
			$this->db->where('mlc_enable', 1);
			$this->db->order_by('mlc_target_point','DESC');
		}else{
			$this->db->where('mlc_level >=', $level);
			$this->db->where('mlc_enable', 1);
			$this->db->order_by('mlc_target_point','ASC');
		}
		$this->db->limit(1);
		$result = $this->db->get('cic_member_level_config')->row_array();
		return $result;
	}
}

?>