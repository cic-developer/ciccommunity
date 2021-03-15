<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Point model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
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

	function get_by_pointSum($pointSum)
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

		$result = $this->db->get('cic_member_level_config');
		return element(0 ,$result);
	}
}

?>