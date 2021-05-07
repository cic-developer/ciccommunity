<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Register class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 회원 가입과 관련된 controller 입니다.
 */
class Checkplus_main extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Member_nickname', 'Member_meta', 'Member_auth_email', 'Member_userid');

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'string');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('querystring', 'form_validation', 'email', 'notelib', 'point'));

		if ( ! function_exists('password_hash')) {
			$this->load->helper('password');
		}
	}


	/**
	 * 회원 약관 동의시 작동하는 함수입니다
	 */
	public function index()
	{
		$this->load->view('register/cic/Checkplus_fail');
	}
}

