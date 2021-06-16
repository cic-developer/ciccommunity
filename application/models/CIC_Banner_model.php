<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CIC_Banner_model class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

class CIC_Banner_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cic_banner';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'ban_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();

        check_cache_dir('banner');
	}

    public function get_today_list()
	{
		$cachename = 'banner/banner-info-' . cdate('Y-m-d');
		$data = array();
		if ( ! $data = $this->cache->get($cachename)) {
			$this->db->from($this->_table);
			$this->db->where('ban_activated', 1);
			$this->db->group_start();
			$this->db->where(array('ban_start_date <=' => cdate('Y-m-d')));
			$this->db->or_where(array('ban_start_date' => null));
			$this->db->group_end();
			$this->db->group_start();
			$this->db->where('ban_end_date >=', cdate('Y-m-d'));
			$this->db->or_where('ban_end_date', '0000-00-00');
			$this->db->or_where(array('ban_end_date' => ''));
			$this->db->or_where(array('ban_end_date' => null));
			$this->db->group_end();
			$this->db->order_by('ban_order', 'DESC');
			$res = $this->db->get();
			$result['list'] = $res->result_array();

			$data['result'] = $result;
			$data['cached'] = '1';

			$this->cache->save($cachename, $data, $this->cache_time);
		}
		return isset($data['result']) ? $data['result'] : false;
	}


	public function delete($primary_value = '', $where = '')
	{
		$result = parent::delete($primary_value, $where);
		$this->cache->delete('banner/banner-info-' . cdate('Y-m-d'));

		return $result;
	}


	public function update($primary_value = '', $updatedata = '', $where = '')
	{
		$result = parent::update($primary_value, $updatedata);
		$this->cache->delete('banner/banner-info-' . cdate('Y-m-d'));

		return $result;
	}
}

?>