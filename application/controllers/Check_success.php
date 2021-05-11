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
class Check_success extends CB_Controller
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
		$this->load->library(array('querystring', 'form_validation', 'email', 'notelib', 'point', 'checkplus'));

		if ( ! function_exists('password_hash')) {
			$this->load->helper('password');
		}
	}


	/**
	 * 회원 약관 동의시 작동하는 함수입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_register_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		if ($this->member->is_member()
			&& ! ($this->member->is_admin() === 'super' && $this->uri->segment(1) === config_item('uri_segment_admin'))) {
			redirect();
		}

		if($this->input->get("EncodeData")){
			$this->checkplus->success($this->input->get("EncodeData"));
			// echo("<script>self.close()</script>");
			redirect("register/checkplus_success");
		}//window.opener.parent.location.reload();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
	}

	public function checkplus_success()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_register_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		prinit_r("@@@@@@@@@@@@@@@@");

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		if ($this->member->is_member()
			&& ! ($this->member->is_admin() === 'super' && $this->uri->segment(1) === config_item('uri_segment_admin'))) {
			redirect();
		}

		if($this->input->get("EncodeData")){
			$this->checkplus->success($this->input->get("EncodeData"));
			// echo("<script>self.close()</script>");
			redirect("checkplus_success");
		}//window.opener.parent.location.reload();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
	}
}
