<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Point class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 포인트 추가 및 삭제를 관리하는 class 입니다.
 */
class Point extends CI_Controller
{

	private $CI;

	function __construct()
	{
		$this->CI = & get_instance();
		$this->CI->load->helper( array('array'));
	}


	/**
	 * 포인트를 추가합니다
	 */
	public function insert_point($mem_id = 0, $point = 0, $content = '', $poi_type = '', $poi_related_id = '', $poi_action = '')
	{
		// echo $mem_id. " / ".$point. " / ". $content. " / ". $poi_type. " / ".$poi_related_id. " / ".$poi_action;
		// 포인트 사용을 하지 않는다면 return
		if ( ! $this->CI->cbconfig->item('use_point')) {
			return false;
		}

		// 포인트가 없다면 업데이트 할 필요 없음
		$point = (int) $point;
		if (empty($point)) {
			return false;
		}

		// 회원아이디가 없다면 업데이트 할 필요 없음
		$mem_id = (int) $mem_id;
		if (empty($mem_id) OR $mem_id < 1) {
			return false;
		}

		if (empty($content)) {
			return false;
		}

		if (empty($poi_type) && empty($poi_related_id) && empty($poi_action)) {
			return false;
		}

		$member = $this->CI->Member_model->get_by_memid($mem_id, 'mem_id');

		if ( ! element('mem_id', $member)) {
			return false;
		}

		$this->CI->load->model('Point_model');

		// 이미 등록된 내역이라면 건너뜀
		if ($poi_type OR $poi_related_id OR $poi_action) {
			$where = array(
				'mem_id' => $mem_id,
				'poi_type' => $poi_type,
				'poi_related_id' => $poi_related_id,
				'poi_action' => $poi_action,
			);
			$cnt = $this->CI->Point_model->count_by($where);

			if ($cnt > 0) {
				return false;
			}
		}

		$insertdata = array(
			'mem_id' => $mem_id,
			'poi_datetime' => cdate('Y-m-d H:i:s'),
			'poi_content' => $content,
			'poi_point' => $point,
			'poi_type' => $poi_type,
			'poi_related_id' => $poi_related_id,
			'poi_action' => $poi_action,
		);
		$this->CI->Point_model->insert($insertdata);

		$sum = $this->CI->Point_model->get_point_sum($mem_id);

		$updatedata = array(
			'mem_point' => $sum,
		);
		$this->CI->Member_model->update($mem_id, $updatedata);

		//포인트에 따른 레벨 변경
		$this->setUserLevel($mem_id);
		
		return $sum;
	}

	/**
	 * vp를 추가합니다
	 */
	public function insert_vp($mem_id = 0, $point = 0, $content = '', $poi_type = '', $poi_related_id = '', $poi_action = '')
	{
		// 포인트 사용을 하지 않는다면 return
		// if ( ! $this->CI->cbconfig->item('use_point')) {
		// 	return false;
		// }

		// 포인트가 없다면 업데이트 할 필요 없음
		$point = (int) $point;
		if (empty($point)) {
			return false;
		}

		// 회원아이디가 없다면 업데이트 할 필요 없음
		$mem_id = (int) $mem_id;
		if (empty($mem_id) OR $mem_id < 1) {
			return false;
		}

		if (empty($content)) {
			return false;
		}

		if (empty($poi_type) && empty($poi_related_id) && empty($poi_action)) {
			return false;
		}

		$member = $this->CI->Member_model->get_by_memid($mem_id, 'mem_id');

		if ( ! element('mem_id', $member)) {
			return false;
		}

		$this->CI->load->model('CIC_vp_model');

		// 이미 등록된 내역이라면 건너뜀
		if ($poi_type OR $poi_related_id OR $poi_action) {
			$where = array(
				'mem_id' => $mem_id,
				'vp_type' => $poi_type,
				'vp_related_id' => $poi_related_id,
				'vp_action' => $poi_action,
			);
			$cnt = $this->CI->CIC_vp_model->count_by($where);

			if ($cnt > 0) {
				return false;
			}
		}

		$insertdata = array(
			'mem_id' => $mem_id,
			'vp_datetime' => cdate('Y-m-d H:i:s'),
			'vp_content' => $content,
			'vp_point' => $point,
			'vp_type' => $poi_type,
			'vp_related_id' => $poi_related_id,
			'vp_action' => $poi_action,
		);
		$this->CI->CIC_vp_model->insert($insertdata);

		$sum = $this->CI->CIC_vp_model->get_point_sum($mem_id);

		$updatedata = array(
			'mem_vp' => $sum,
		);
		$this->CI->Member_model->update($mem_id, $updatedata);

		return $sum;
	}

		/**
	 * 포인트를 추가합니다
	 */
	public function insert_cp($mem_id = 0, $point = 0, $content = '', $poi_type = '', $poi_related_id = '', $poi_action = '')
	{
		// 포인트 사용을 하지 않는다면 return
		// if ( ! $this->CI->cbconfig->item('use_point')) {
		// 	return false;
		// }

		// 포인트가 없다면 업데이트 할 필요 없음
		$point = (int) $point;
		if (empty($point)) {
			return false;
		}

		// 회원아이디가 없다면 업데이트 할 필요 없음
		$mem_id = (int) $mem_id;
		if (empty($mem_id) OR $mem_id < 1) {
			return false;
		}

		if (empty($content)) {
			return false;
		}

		if (empty($poi_type) && empty($poi_related_id) && empty($poi_action)) {
			return false;
		}

		$member = $this->CI->Member_model->get_by_memid($mem_id, 'mem_id');

		if ( ! element('mem_id', $member)) {
			return false;
		}

		$this->CI->load->model('CIC_cp_model');

		// 이미 등록된 내역이라면 건너뜀
		if ($poi_type OR $poi_related_id OR $poi_action) {
			$where = array(
				'mem_id' => $mem_id,
				'cp_type' => $poi_type,
				'cp_related_id' => $poi_related_id,
				'cp_action' => $poi_action,
			);
			$cnt = $this->CI->CIC_cp_model->count_by($where);

			if ($cnt > 0) {
				return false;
			}
		}

		$insertdata = array(
			'mem_id' => $mem_id,
			'cp_datetime' => cdate('Y-m-d H:i:s'),
			'cp_content' => $content,
			'cp_point' => $point,
			'cp_type' => $poi_type,
			'cp_related_id' => $poi_related_id,
			'cp_action' => $poi_action,
		);
		
		print_r(json_encode($insertdata));
		exit;
		$this->CI->CIC_cp_model->insert($insertdata);

		$sum = $this->CI->CIC_cp_model->get_point_sum($mem_id);

		$updatedata = array(
			'mem_cp' => $sum,
		);
		$this->CI->Member_model->update($mem_id, $updatedata);

		return $sum;
	}


	/**
	 * 포인트를 삭제합니다
	 */
	public function delete_point($mem_id = 0, $poi_type = '', $poi_related_id = '', $poi_action = '')
	{
		$mem_id = (int) $mem_id;
		if (empty($mem_id) OR $mem_id < 1) {
			return false;
		}

		if ($poi_type OR $poi_related_id OR $poi_action) {
			$this->CI->load->model('Point_model');

			$where = array(
				'mem_id' => $mem_id,
				'poi_type' => $poi_type,
				'poi_related_id' => $poi_related_id,
				'poi_action' => $poi_action,
			);
			$this->CI->Point_model->delete_where($where);

			// 포인트 내역의 합을 구하고
			$sum = $this->CI->Point_model->get_point_sum($mem_id);
			$updatedata = array(
				'mem_point' => $sum,
			);
			$this->CI->Member_model->update($mem_id, $updatedata);

			//포인트에 따른 레벨 변경
			$this->setUserLevel($mem_id);

			return $sum;
		}

		return false;
	}

	/**
	 * vp를 삭제합니다
	 */
	public function delete_vp($mem_id = 0, $poi_type = '', $poi_related_id = '', $poi_action = '')
	{
		$mem_id = (int) $mem_id;
		if (empty($mem_id) OR $mem_id < 1) {
			return false;
		}

		if ($poi_type OR $poi_related_id OR $poi_action) {
			$this->CI->load->model('CIC_vp_model');

			$where = array(
				'mem_id' => $mem_id,
				'vp_type' => $poi_type,
				'vp_related_id' => $poi_related_id,
				'vp_action' => $poi_action,
			);
			$this->CI->CIC_vp_model->delete_where($where);

			// 포인트 내역의 합을 구하고
			$sum = $this->CI->CIC_vp_model->get_point_sum($mem_id);
			$updatedata = array(
				'mem_vp' => $sum,
			);
			$this->CI->Member_model->update($mem_id, $updatedata);

			return $sum;
		}

		return false;
	}

	/**
	 * cp를 삭제합니다
	 */
	public function delete_cp($mem_id = 0, $poi_type = '', $poi_related_id = '', $poi_action = '')
	{
		$mem_id = (int) $mem_id;
		if (empty($mem_id) OR $mem_id < 1) {
			return false;
		}

		if ($poi_type OR $poi_related_id OR $poi_action) {
			$this->CI->load->model('CIC_cp_model');

			$where = array(
				'mem_id' => $mem_id,
				'cp_type' => $poi_type,
				'cp_related_id' => $poi_related_id,
				'cp_action' => $poi_action,
			);
			$this->CI->CIC_cp_model->delete_where($where);

			// 포인트 내역의 합을 구하고
			$sum = $this->CI->CIC_cp_model->get_point_sum($mem_id);
			$updatedata = array(
				'mem_cp' => $sum,
			);
			$this->CI->Member_model->update($mem_id, $updatedata);

			return $sum;
		}

		return false;
	}


	/**
	 * 포인트 PK 를 이용한 포인트 삭제입니다.
	 */
	public function delete_point_by_pk($poi_id = 0)
	{
		$poi_id = (int) $poi_id;
		if (empty($poi_id) OR $poi_id < 1) {
			return false;
		}

		$this->CI->load->model('Point_model');

		$result = $this->CI->Point_model->get_one($poi_id, 'mem_id');
		$this->CI->Point_model->delete($poi_id);

		if (element('mem_id', $result)) {
			$mem_id = element('mem_id', $result);
			// 포인트 내역의 합을 구하고
			$sum = $this->CI->Point_model->get_point_sum($mem_id);
			$updatedata = array(
				'mem_point' => $sum,
			);
			$this->CI->Member_model->update($mem_id, $updatedata);

			//포인트에 따른 레벨 변경
			$this->setUserLevel($mem_id);

			return $sum;
		}

		return true;
	}

	/**
	 * 포인트 PK 를 이용한 포인트 삭제입니다.
	 */
	public function delete_vp_by_pk($poi_id = 0)
	{
		$poi_id = (int) $poi_id;
		if (empty($poi_id) OR $poi_id < 1) {
			return false;
		}

		$this->CI->load->model('CIC_vp_model');

		$result = $this->CI->CIC_vp_model->get_one($poi_id, 'mem_id');
		$this->CI->CIC_vp_model->delete($poi_id);

		if (element('mem_id', $result)) {
			$mem_id = element('mem_id', $result);
			// 포인트 내역의 합을 구하고
			$sum = $this->CI->CIC_vp_model->get_point_sum($mem_id);
			$updatedata = array(
				'mem_vp' => $sum,
			);
			$this->CI->Member_model->update($mem_id, $updatedata);

			return $sum;
		}

		return true;
	}

	/**
	 * 포인트 PK 를 이용한 포인트 삭제입니다.
	 */
	public function delete_cp_by_pk($poi_id = 0)
	{
		$poi_id = (int) $poi_id;
		if (empty($poi_id) OR $poi_id < 1) {
			return false;
		}

		$this->CI->load->model('CIC_cp_model');

		$result = $this->CI->CIC_cp_model->get_one($poi_id, 'mem_id');
		$this->CI->CIC_cp_model->delete($poi_id);

		if (element('mem_id', $result)) {
			$mem_id = element('mem_id', $result);
			// 포인트 내역의 합을 구하고
			$sum = $this->CI->CIC_cp_model->get_point_sum($mem_id);
			$updatedata = array(
				'mem_cp' => $sum,
			);
			$this->CI->Member_model->update($mem_id, $updatedata);

			return $sum;
		}

		return true;
	}

	/**
	 * 소유 포인트를 확인하여 현재 레벨과 일치하는지 확인후
	 * 알맞은 레벨로 옮김
	 */

	public function setUserLevel($mem_id)
	{
		$this->CI->load->model(array('Member_level_history_model', 'CIC_member_level_config_model', 'Member_model', 'Point_model'));
		$memberInfo = $this->CI->Member_model->get_by_memid($mem_id);
		if( $memberInfo && !element('mem_is_admin', $memberInfo) ){
			$pointSum = element('mem_point', $memberInfo);
			$_levelConfig = $this->CI->CIC_member_level_config_model->get_by_pointSum($pointSum);
			if($_levelConfig)
			{
				$_mlclevel = element('mlc_level' , $_levelConfig); // 적용될 레벨
				$_memLevel = element('mem_level', $memberInfo); //기존 레벨
				if($_mlclevel != $_memLevel)
				{
					$this->CI->Member_model->update($mem_id, array('mem_level' => $_mlclevel));
					$_checkHis = $this->CI->Member_level_history_model->get_one('','', array('mlh_to' => $_mlclevel, 'mem_id' => $mem_id));
					$levelhistoryinsert = array(
						'mem_id' => $mem_id,
						'mlh_from' => $_memLevel,
						'mlh_to' => $_mlclevel,
						'mlh_datetime' => cdate('Y-m-d H:i:s'),
						'mlh_reason' => '명예포인트 변경으로 인한 레벨 변화',
						'mlh_ip' => $this->CI->input->ip_address(),
					);
					$this->CI->Member_level_history_model->insert($levelhistoryinsert);

					if($_mlclevel > $_memLevel && !$_checkHis){
						$this->CI->load->model('CIC_vp_config_model');
						$_vp_levelConf = $this->CI->CIC_vp_config_model->get_one('','',"vpc_id = 2 AND vpc_enable = 1");
						$_cp_levelConf = $this->CI->CIC_cp_config_model->get_one('','',"cpc_id = 2 AND cpc_enable = 1");
						$this->insert_vp(
							$mem_id,
							element('vpc_value' ,$_vp_levelConf),
							'Level UP 보상 VP 지급',
							'Level Up',
							$post_id,
							'레벨 업'
						);
			
						$this->insert_cp(
							$mem_id,
							element('cpc_value' ,$_cp_levelConf),
							'Level UP 보상 CP 지급',
							'Level Up',
							$post_id,
							'레벨 업'
						);
						
						return $_mlclevel;
					}else{
						return false;
					}
				}
			}
		}
		return false;
	}
}
