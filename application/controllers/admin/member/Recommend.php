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
	protected $helpers = array('form', 'array', 'url');

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
				'rules' => 'trim|in_list[rec,reg]|required',
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
			$insert_cp = $this->input->post('reward_cp');
			$insert_vp = $this->input->post('reward_vp');
			if($_type == 'rec'){
				$_update_data = array(
					'rmd_rec_cp' => $insert_cp,
					'rmd_rec_vp' => $insert_vp,
				);
				$_insert_id = 'rec_mem_id';
<<<<<<< HEAD
				$_insert_content = 'cic 커뮤니티 추천인 회원가입 에어드랍';
=======
<<<<<<< HEAD
				$_insert_content = 'cic 커뮤니티 추천인 회원가입 에어드랍';
=======
				$_insert_content = 'cic 커뮤니티 추천인 에어드랍';
>>>>>>> e7f3b2e96c05c0ebeba432d85243f3c29601869e
>>>>>>> 1d898080cc9e3e580ab3b9cf15b880861c1e083d
				$_insert_relate_id = 'usr_mem_id';
			}else{
				$_update_data = array(
					'rmd_cp' => $insert_cp,
					'rmd_vp' => $insert_vp,
				);
				$_insert_id = 'usr_mem_id';
<<<<<<< HEAD
				$_insert_content = 'cic 커뮤니티 레퍼럴 추천인 에어드랍';
=======
<<<<<<< HEAD
				$_insert_content = 'cic 커뮤니티 레퍼럴 추천인 에어드랍';
=======
				$_insert_content = 'cic 커뮤니티 추천인 회원가입 에어드랍';
>>>>>>> e7f3b2e96c05c0ebeba432d85243f3c29601869e
>>>>>>> 1d898080cc9e3e580ab3b9cf15b880861c1e083d
				$_insert_relate_id = 'rec_mem_id';
			}
			$this->Mem_recommeder_model->update(NULL, $_update_data);
			// echo "<pre>";
			foreach($result['list'] AS $row){
				if($_type == 'rec'){
					// print_r(
					// 	array(
					// 		'vp' => (int)$row['is_count']*(int)$insert_vp,
					// 		 'cp' => (int)$row['is_count']*(int)$insert_cp,
					// 		  'count' => $row['is_count']
					// ));
					$this->point->insert_vp($row[$_insert_id], (int)$row['is_count']*(int)$insert_vp, $_insert_content,'@byadmin', $row[$_insert_relate_id], '사전예약 보상');
					$this->point->insert_cp($row[$_insert_id], (int)$row['is_count']*(int)$insert_cp, $_insert_content,'@byadmin', $row[$_insert_relate_id], '사전예약 보상');
				}else{
					$this->point->insert_vp($row[$_insert_id], $insert_vp, $_insert_content,'@byadmin', $row[$_insert_relate_id], '사전예약 보상');
					$this->point->insert_cp($row[$_insert_id], $insert_cp, $_insert_content,'@byadmin', $row[$_insert_relate_id], '사전예약 보상');
				}
			}
			// echo "</pre>";
			// exit;

			$this->session->set_flashdata(
				'message',
				'정상적으로 입력되었습니다'
			);
			redirect('admin/member/recommend?type='.$_type);
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