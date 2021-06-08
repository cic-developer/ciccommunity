<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Referrer class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/** 
 * 출석체크 담당하는 controller 입니다.
 */
class Referrer extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	// protected $models = array();

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring'));
	}


	/**
	 * 추천인 리다이렉트 컨트롤러입니다
	 */
	public function redirect($userid = '')
	{
		//해당 아이디가 존재하는지 확인
		$countwhere = array(
			'mem_userid' => $userid,
			'mem_denied' => 0,
		);
		$row = $this->Member_model->count_by($countwhere);

		//만약 존재하지 않는 아이디 일 경우 세션에 저장하지 않음
		if ($row === 0) {
			$userid = '';
		}

		//추천인코드 세션에 저장
		if($userid){
			$this->session->set_userdata('ref_code', $userid);
		}
		
		redirect(base_url('register'));
	}
}
