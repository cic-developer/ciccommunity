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

		if ($this->cbconfig->item('use_register_block')) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_block_layout'] = Events::trigger('before_block_layout', $eventname);

			/**
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_register');
			$meta_description = $this->cbconfig->item('site_meta_description_register');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_register');
			$meta_author = $this->cbconfig->item('site_meta_author_register');
			$page_name = $this->cbconfig->item('site_page_name_register');

			$layoutconfig = array(
				'path' => 'register',
				'layout' => 'layout',
				'skin' => 'register_block',
				'layout_dir' => $this->cbconfig->item('layout_register'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
				'use_sidebar' => $this->cbconfig->item('sidebar_register'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
				'skin_dir' => $this->cbconfig->item('skin_register'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
				'page_title' => $page_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'meta_author' => $meta_author,
				'page_name' => $page_name,
			);
			$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));

			return false;
		}

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'agree',
				'label' => '회원가입약관',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'agree2',
				'label' => '개인정보취급방침',
				'rules' => 'trim|required',
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

			$this->session->set_userdata('registeragree', '');

			$view['view']['member_register_policy1'] = $this->cbconfig->item('member_register_policy1');
			$view['view']['member_register_policy2'] = $this->cbconfig->item('member_register_policy2');
			$view['view']['canonical'] = site_url('register');

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
			$view['view']['recommend_id'] = $this->input->get('rcid');

			/**
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_register');
			$meta_description = $this->cbconfig->item('site_meta_description_register');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_register');
			$meta_author = $this->cbconfig->item('site_meta_author_register');
			$page_name = $this->cbconfig->item('site_page_name_register');

			$layoutconfig = array(
				'path' => 'register',
				'layout' => 'layout',
				'skin' => 'register',
				'layout_dir' => $this->cbconfig->item('layout_register'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
				'use_sidebar' => $this->cbconfig->item('sidebar_register'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
				'skin_dir' => $this->cbconfig->item('skin_register'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
				'page_title' => $page_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'meta_author' => $meta_author,
				'page_name' => $page_name,
			);
			$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));

		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);
			$rcid = $this->input->post('recommend_id');
			$this->session->set_userdata('registeragree', '1');
			// redirect('register/form/'.$rcid);
		}
	}
}

