<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CIC_forum_config_model class
 *
 * Copyright (c) RsTeam <www.rs-team.com>
 *
 * @author RsTeam (developer@rs-team.com)
 */
class CIC_forum_config_model extends CB_Model
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
	
	public function get_all_meta()
	{
		$cachename = $this->cache_name;
		if ( ! $result = $this->cache->get($cachename)) {
			$result = array();
			$res = $this->get();
			if ($res && is_array($res)) {
				foreach ($res as $val) {
					$result[$val[$this->meta_key]] = $val[$this->meta_value];
				}
			}
			$this->cache->save($cachename, $result, $this->cache_time);
		}
		return $result;
	}

	public function save($savedata = '')
	{
		if ($savedata && is_array($savedata)) {
			foreach ($savedata as $column => $value) {
				$this->meta_update($column, $value);
			}
		}
		$this->cache->delete($this->cache_name);
	}

	public function meta_update($column = '', $value = false)
	{
		$column = trim($column);
		if (empty($column)) {
			return false;
		}

		$old_value = $this->item($column);
		if (is_null($value)) {
			$value = '';
		}
		if ($value === $old_value) {
			return false;
		}

		if (false === $old_value) {
			return $this->add_meta($column, $value);
		}

		return $this->update_meta($column, $value);
	}

	public function item($column = '')
	{
		if (empty($column)) {
			return false;
		}

		$result = $this->get_all_meta();

		return isset($result[ $column ]) ? $result[ $column ] : false;
	}

	public function add_meta($column = '', $value = '')
	{
		$column = trim($column);
		if (empty($column)) {
			return false;
		}
		$updatedata = array(
			'frm_key' => $column,
			'frm_value' => $value,
		);
		$this->db->replace($this->_table, $updatedata);

		return true;
	}

	public function update_meta($column = '', $value = '')
	{
		$column = trim($column);
		if (empty($column)) {
			return false;
		}

		$this->db->where($this->meta_key, $column);
		$data = array($this->meta_value => $value);
		$this->db->update($this->_table, $data);

		return true;
	}
}
