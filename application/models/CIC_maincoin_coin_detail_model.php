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

	function __construct()
	{
		parent::__construct();
	}


	public function get_this_exchange($cmcd_cmc_idx = 0)
	{
		$where = array(
			'cmcd_cmc_idx' => $cmcd_cmc_idx,
		);
		$result = array();
		$res = $this->get('', '', $where);
		if ($res && is_array($res)) {
			foreach ($res as $val) {
				$result[$val['cmcd_cme_idx']] = $val;
			}
		}
		return $result;
	}


	public function update_exchange($data = array())
	{
		$now_date = cdate('Y-m-d H:i:s');
		if (element('cmcd_cme_idx', $data) && is_array(element('cmcd_cme_idx', $data))) {
			foreach (element('cmcd_cme_idx', $data) as $key => $value) {
				if ( ! element($key, element('cmcd_use', $data))) {
					continue;
				}
				if ($value) {
					$updatedata = array(
						'cmcd_coin_id' => $data['cmcd_coin_id'][$key],
						'cmcd_coin_market' => $data['cmcd_coin_market'][$key],
						'cmcd_datetime' => $now_date,
					);
					$this->update($value, $updatedata);
				} else {
					$insertdata = array(
						'cmcd_cmc_idx' => $data['cmcd_cmc_idx'],
						'cmcd_cme_idx' => $key,
						'cmcd_coin_id' => $data['cmcd_coin_id'][$key],
						'cmcd_coin_market' => $data['cmcd_coin_market'][$key],
						'cmcd_datetime' => $now_date,
					);
					$this->insert($insertdata);
				}
			}
		}
		$deletewhere = array(
			'cmcd_datetime !=' => $now_date,
		);
		$this->delete_where($deletewhere);
	}
}

?>