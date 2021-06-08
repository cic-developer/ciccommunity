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
class Wconfig extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'withdraw/wconfig';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('CIC_withdraw', 'CIC_cp', 'Member', 'CIC_wconfig');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'CIC_wconfig_model';

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
	 * 관리자 출급요청설정 메인 페이지입니다.
	 */
	public function index()
	{

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_withdraw_config_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		$config = array(
			array(
				'field' => 'withdraw_deposit',
				'label' => '출금요청 수수료 설정',
				'rules' => 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]|callback__deposit_decimal_check',
			),
			array(
				'field' => 'withdraw_minimum',
				'label' => '출금요청 최소금액 설정',
				'rules' => 'trim|required|greater_than_equal_to[0]|callback__minimum_decimal_check',
			),
		);
		$this->form_validation->set_rules($config);

		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			$array = array(
				'withdraw_deposit',
				'withdraw_minimum',
			);
			foreach ($array as $value) {
				$savedata[$value] = $this->input->post($value, null, '');
			}

			$this->CIC_wconfig_model->save($savedata);
			$view['view']['alert_message'] = '기본정보 설정이 저장되었습니다';
		}

		$getdata = $this->CIC_wconfig_model->get_all_meta();
		$view['view']['data'] = $getdata;
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'index');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 소수점을 체크하는 콜백함수입니다.
	 */
	public function _deposit_decimal_check($_str)
	{
        
		$str = explode( '.', $_str );
		if( strlen($str[1]) < 3){
			return true;
		}
        
		$this->form_validation->set_message(
			'_deposit_decimal_check',
			'출금요청 수수료는 소수점 2자리 까지 설정이 가능합니다'
		);
		return false;
	}
	
	/**
	 * 소수점을 체크하는 콜백함수입니다.
	 */
	public function _minimum_decimal_check($_str)
	{
        
		$str = explode( '.', $_str );
		if( strlen($str[1]) < 3){
			return true;
		}
        
		$this->form_validation->set_message(
			'_minimum_decimal_check',
			'출금요청 최소금액은 소수점 2자리 까지 설정이 가능합니다'
		);
		return false;
	}
	
}
