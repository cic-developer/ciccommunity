<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자 메인 controller 입니다.
 */
class Deposit extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('CIC_cp', 'Member');

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'chkstring',  'dhtml_editor');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring', 'member'));
	}

	/**
	 * 
	 */
	public function index()
	{
		exit;
	}

	/**
	 * insert
	 */
	public function insert()
	{
        
	}

	/**
	 * subtract
	 */
	public function subtract()
	{
        // cp 반환 기록 + member 예치금 제거

        // 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_deposit_ajax_subtract';
		$this->load->event($eventname);
        
		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();
        
		$view = array();
		$view['view'] = array();
        
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);






        $mem_deposit = $this->member->item('mem_deposit');

        print_r($mem_deposit);
        exit;





        exit;
        
		$this->session->set_userdata('password_confirm', '');
        
		if($this->session->userdata('password_modify_ath_mail_result') != '1'){
			$result = array(
				'state' => '0',
				'message' => '이메일 인증이 필요합니다',
			);
			exit(json_encode($result));
		}
		if($this->session->userdata('password_modify_ath_nice_phone_result') != '1'){
			$result = array(
				'state' => '0',
				'message' => '핸드폰 인증이 필요합니다',
			);
			exit(json_encode($result));
		}
        
		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');
		$password_length = $this->cbconfig->item('password_length');
        
		$config = array(
			array(
				'field' => 'new_password',
				'label' => '새 비밀번호',
				'rules' => 'trim|required|min_length[' . $password_length . ']|callback__mem_password_check',
			),
			array(
				'field' => 'new_password_re',
				'label' => '새 비밀번호 확인',
				'rules' => 'trim|required|min_length[' . $password_length . ']|matches[new_password]',
			),
		);
		// password_description
		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();
        
		if(!$form_validation){
			$result = array(
				'state' => '0',
				'message' => $this->form_validation->error_string(),
			);
			exit(json_encode($result));
		}else{
			$this->session->set_userdata('password_confirm', '1');
            
			$result = array(
				'state' => '1',
				'message' => '사용 가능한 비밀번호입니다',
			);
			exit(json_encode($result));
		}
	}
}
