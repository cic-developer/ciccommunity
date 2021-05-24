<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CIC Maincoin Coin Detail model class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

class CIC_maincoin_coin_detail_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cic_maincoin_coin_detail';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cmcd_idx'; // 사용되는 테이블의 프라이머리키

	public $cache_name = 'coin/maincoin_coin_detail'; // 캐시 사용시 프리픽스

	public $cache_time = 86400; // 캐시 저장시간

	function __construct()
	{
		parent::__construct();

		check_cache_dir('coin');
	}


	public function update_exchange($data = array())
	{
		$order = 1;
		if (element('cmcd_cme_idx', $data) && is_array(element('cmcd_cme_idx', $data))) {
			foreach (element('cmcd_cme_idx', $data) as $key => $value) {
				if ( ! element($key, element('cmcd_use', $data))) {
					continue;
				}
				if ($value) {
					$is_default = isset($data['mgr_is_default'][$key]) && $data['mgr_is_default'][$key] ? 1 : 0;
					$updatedata = array(
						'mgr_title' => $data['mgr_title'][$key],
						'mgr_is_default' => $is_default,
						'mgr_datetime' => cdate('Y-m-d H:i:s'),
						'mgr_order' => $order,
						'mgr_description' => $data['mgr_description'][$key],
					);
					$this->update($value, $updatedata);
				} else {
					$is_default = isset($data['mgr_is_default'][$key]) && $data['mgr_is_default'][$key] ? 1 : 0;
					$insertdata = array(
						'mgr_title' => $data['mgr_title'][$key],
						'mgr_is_default' => $is_default,
						'mgr_datetime' => cdate('Y-m-d H:i:s'),
						'mgr_order' => $order,
						'mgr_description' => $data['mgr_description'][$key],
					);
					$this->insert($insertdata);
				}
			$order++;
			}
		}
		$deletewhere = array(
			'mgr_datetime !=' => cdate('Y-m-d H:i:s'),
		);
		$this->delete_where($deletewhere);
		$this->cache->delete($this->cache_name);
	}
}

?>