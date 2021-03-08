<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cbconfigs class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>환경설정>기본환경설정 controller 입니다.
 */
class Point extends CB_Controller
{
    /**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cicconfigs/Point';

	/**
     * 모델을 로딩합니다
     */
	protected $models = array('CIC_cp', 'CIC_vp', 'CIC_cp_config', 'CIC_vp_config', 'Config', 'CIC_point_config');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'CIC_point_config_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'dhtml_editor');

	function __construct()
	{
		parent::__construct();
	}

    // public function index()
    // {
	// 	// 이벤트 라이브러리를 로딩합니다
	// 	$eventname = 'event_admin_cicconfigs_point';
	// 	$this->load->event($eventname);

	// 	$view = array();
	// 	$view['view'] = array();

	// 	// 이벤트가 존재하면 실행합니다
	// 	$view['view']['event']['before'] = Events::trigger('before', $eventname);

	// 	/**
	// 	 * Validation 라이브러리를 가져옵니다
	// 	 */
	// 	$this->load->library('form_validation');

	// 	/**
	// 	 * 전송된 데이터의 유효성을 체크합니다
	// 	 */
	// 	$config = array(
	// 		array(
	// 			'field' => 'is_submit',
	// 			'label' => '전송',
	// 			'rules' => 'trim|required',
	// 		),
	// 		array(
	// 			'field' => 'cpc_enable[]',
	// 			'label' => '활성화',
	// 			'rules' => 'required|in_list[0,1]'
	// 		),
	// 		array(
	// 			'field' => 'cpc_class[]',
	// 			'label' => '비율/절대값',
	// 			'rules' => 'required|in_list[1,2]'
	// 		),
	// 		array(
	// 			'field' => 'cpc_value[]',
	// 			'label' => '지급 비율/절대값',
	// 			'rules' => 'required|numeric'
	// 		),
	// 		array(
	// 			'field' => 'like_min_vp',
	// 			'label' => '최소 입력 VP',
	// 			'rules' => 'required|numeric'
	// 		),
	// 		array(
	// 			'field' => 'like_max_vp',
	// 			'label' => '최대 입력 VP',
	// 			'rules' => 'required|numeric'
	// 		),
	// 	);
	// 	$this->form_validation->set_rules($config);

	// 	/**
	// 	 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
	// 	 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
	// 	 */
	// 	if ($this->form_validation->run() === false) {

	// 		// 이벤트가 존재하면 실행합니다
	// 		$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

	// 	} else {
	// 		/**
	// 		 * 유효성 검사를 통과한 경우입니다.
	// 		 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
	// 		 */

	// 		// 이벤트가 존재하면 실행합니다
	// 		$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);
	// 		$_postData = $this->input->post();

	// 		$_cpc_idArr = $_postData['cpc_id'];
	// 		$_cpc_enableArr = $_postData['cpc_enable'];
	// 		$_cpc_classArr = $_postData['cpc_class'];
	// 		$_cpc_valueArr = $_postData['cpc_value'];

			
	// 		for($_index = 0; $_index < count($_cpc_idArr); $_index++ ){
	// 			$_cpc_valueArr[$_index] = $_cpc_classArr[$_index] == 1? $_cpc_valueArr[$_index] : round($_cpc_valueArr[$_index]);
	// 			$arr = array(
	// 				'cpc_enable'=> $_cpc_enableArr[$_index],
	// 				'cpc_class'	=> $_cpc_classArr[$_index],
	// 				'cpc_value' => $_cpc_valueArr[$_index]
	// 			);
	// 			$this->CIC_point_config_model->update($_cpc_idArr[$_index], $arr);
	// 		}
	// 		$this->Config_model->meta_update('like_min_vp', $_postData['like_min_vp']);
	// 		$this->Config_model->meta_update('like_max_vp', $_postData['like_max_vp']);

	// 		$view['view']['alert_message'] = 'VP/CP 지급 설정이 저장되었습니다';
	// 	}

	// 	// Point 지급 config 파일 가져옴
	// 	$getdata = $this->CIC_point_config_model->get_list();

	// 	// $getdata = $this->Config_model->get_all_meta();
	// 	$view['view']['data'] = $getdata;
	// 	$view['view']['like_min_vp'] = $this->Config_model->get_one('','',"cfg_key = 'like_min_vp'");
	// 	$view['view']['like_max_vp'] = $this->Config_model->get_one('','',"cfg_key = 'like_max_vp'"); 

	// 	// 이벤트가 존재하면 실행합니다
	// 	$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
	// 	/**
	// 	 * 어드민 레이아웃을 정의합니다
	// 	 */
	// 	$layoutconfig = array('layout' => 'layout', 'skin' => 'point');
	// 	$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
	// 	$this->data = $view;
	// 	$this->layout = element('layout_skin_file', element('layout', $view));
	// 	$this->view = element('view_skin_file', element('layout', $view));
	// }

	function VPconfig()
    {
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cicconfigs_vpconfig';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'is_submit',
				'label' => '전송',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'vpc_enable[]',
				'label' => '활성화',
				'rules' => 'required|in_list[0,1]'
			),
			array(
				'field' => 'vpc_value[]',
				'label' => '지급 비율/절대값',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'like_min_vp',
				'label' => '최소 입력 VP',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'like_max_vp',
				'label' => '최대 입력 VP',
				'rules' => 'required|numeric'
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

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);
			$_postData = $this->input->post();

			$_vpc_idArr = $_postData['vpc_id'];
			$_vpc_enableArr = $_postData['vpc_enable'];
			$_vpc_valueArr = $_postData['vpc_value'];

			
			for($_index = 0; $_index < count($_vpc_idArr); $_index++ ){
				$arr = array(
					'vpc_enable'=> $_vpc_enableArr[$_index],
					'vpc_value' => $_vpc_valueArr[$_index]
				);
				$this->CIC_vp_config_model->update($_vpc_idArr[$_index], $arr);
			}
			$this->Config_model->meta_update('like_min_vp', $_postData['like_min_vp']);
			$this->Config_model->meta_update('like_max_vp', $_postData['like_max_vp']);
			if(element('defualt_using_point',$_postData)){
				$this->Config_model->meta_update('defualt_using_point', $_postData['defualt_using_point']);
			}

			$view['view']['alert_message'] = 'VP 지급 설정이 저장되었습니다';
		}

		// Point 지급 config 파일 가져옴
		$getdata = $this->CIC_vp_config_model->get_list('', '', '', '', 'vpc_id', 'ASC');

		// $getdata = $this->Config_model->get_all_meta();
		$view['view']['data'] = $getdata;
		$view['view']['like_min_vp'] = $this->Config_model->get_one('','',"cfg_key = 'like_min_vp'");
		$view['view']['like_max_vp'] = $this->Config_model->get_one('','',"cfg_key = 'like_max_vp'");
		$view['view']['like_comment_min_vp'] = $this->Config_model->get_one('','',"cfg_key = 'like_comment_max_vp'");
		$view['view']['like_comment_max_vp'] = $this->Config_model->get_one('','',"cfg_key = 'like_comment_max_vp'");
		$view['view']['defualt_using_point'] = $this->Config_model->get_one('','',"cfg_key = 'defualt_using_point'"); 

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'VPconfig');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}


	function CPconfig()
    {
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cicconfigs_cpconfig';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'is_submit',
				'label' => '전송',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'cpc_enable[]',
				'label' => '활성화',
				'rules' => 'required|in_list[0,1]'
			),
			array(
				'field' => 'cpc_value[]',
				'label' => '지급 비율/절대값',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'like_min_cp',
				'label' => '최소 입력 CP',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'like_max_cp',
				'label' => '최대 입력 CP',
				'rules' => 'required|numeric'
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

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);
			$_postData = $this->input->post();

			$_cpc_idArr = $_postData['cpc_id'];
			$_cpc_enableArr = $_postData['cpc_enable'];
			$_cpc_valueArr = $_postData['cpc_value'];

			
			for($_index = 0; $_index < count($_cpc_idArr); $_index++ ){
				$arr = array(
					'cpc_enable'=> $_cpc_enableArr[$_index],
					'cpc_value' => $_cpc_valueArr[$_index]
				);
				$this->CIC_cp_config_model->update($_cpc_idArr[$_index], $arr);
			}
			$this->Config_model->meta_update('like_min_cp', $_postData['like_min_cp']);
			$this->Config_model->meta_update('like_max_cp', $_postData['like_max_cp']);
			if(element('defualt_using_point',$_postData)){
				$this->Config_model->meta_update('defualt_using_point', $_postData['defualt_using_point']);
			}

			$view['view']['alert_message'] = 'CP 지급 설정이 저장되었습니다';
		}

		// Point 지급 config 파일 가져옴
		$getdata = $this->CIC_cp_config_model->get_list('', '', '', '', 'cpc_id', 'ASC');

		// $getdata = $this->Config_model->get_all_meta();
		$view['view']['data'] = $getdata;
		$view['view']['like_min_cp'] = $this->Config_model->get_one('','',"cfg_key = 'like_min_cp'");
		$view['view']['like_max_cp'] = $this->Config_model->get_one('','',"cfg_key = 'like_max_cp'"); 
		$view['view']['like_comment_min_cp'] = $this->Config_model->get_one('','',"cfg_key = 'like_comment_max_cp'");
		$view['view']['like_comment_max_cp'] = $this->Config_model->get_one('','',"cfg_key = 'like_comment_max_cp'");
		$view['view']['defualt_using_point'] = $this->Config_model->get_one('','',"cfg_key = 'defualt_using_point'");

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'CPconfig');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	
	function config()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cicconfigs_config';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'is_submit',
				'label' => '전송',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'pc_enable[]',
				'label' => '활성화',
				'rules' => 'required|in_list[0,1]'
			),
			array(
				'field' => 'pc_value[]',
				'label' => '지급 비율/절대값',
				'rules' => 'required|numeric'
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

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);
			$_postData = $this->input->post();

			$_pc_idArr = $_postData['pc_id'];
			$_pc_enableArr = $_postData['pc_enable'];
			$_pc_valueArr = $_postData['pc_value'];

			
			for($_index = 0; $_index < count($_pc_idArr); $_index++ ){
				$arr = array(
					'pc_enable'=> $_pc_enableArr[$_index],
					'pc_value' => $_pc_valueArr[$_index]
				);
				$this->CIC_point_config_model->update($_pc_idArr[$_index], $arr);
			}

			$view['view']['alert_message'] = '명예 포인트 지급 설정이 저장되었습니다';
		}

		// Point 지급 config 파일 가져옴
		$getdata = $this->CIC_point_config_model->get_list('', '', '', '', 'pc_id', 'ASC');

		$view['view']['data'] = $getdata;

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'Config');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

}
