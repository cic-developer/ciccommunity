<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Points class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

/**
 * 관리자>회원설정>포인트관리 controller 입니다.
 */
class Recommend extends CB_Controller
{
	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Point','CIC_vp', 'CIC_cp', 'Mem_recommeder');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Mem_recommeder_model';

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
		$this->load->library(array('pagination', 'querystring', 'point'));
	}

	/**
	 * 목록을 가져오는 메소드입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_member_recommend_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		$_type = $this->input->get('type') ?  $this->input->get('type') : 'rec';

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		$result = $this->Mem_recommeder_model->get_recommend_list($_type);
		$list_num = $result['total_rows'];
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['num'] = $list_num--;
			}
		}

		$view['view']['data'] = $result;

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);


		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'required_value',
				'label' => '필수 입력값',
				'rules' => 'trim|numeric|required',
			),
			array(
				'field' => 'reward_vp',
				'label' => '회원아이디',
				'rules' => 'trim|numeric',
			),
			array(
				'field' => 'reward_cp',
				'label' => '포인트',
				'rules' => 'trim|integer',
			)
		);
		
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() === false) {
		}else{
			$this->session->set_flashdata(
				'message',
				'정상적으로 입력되었습니다'
			);
		}

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'index');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
}