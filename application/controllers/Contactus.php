<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Contactus class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

/** 
 * 문의 담당하는 controller 입니다.
 */
class Contactus extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	// protected $models = array('Contactus');

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'dhtml_editor');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring', 'email'));
	}


	/**
	 * 출석체크 페이지입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_contactus_index';
		$this->load->event($eventname);
		

		//달력데이터
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
				'field' => 'contactus_title',
				'label' => '제목',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'contactus_content',
				'label' => '내용',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'captcha_key',
				'label' => '자동등록방지문자',
				'rules' => 'trim|required|callback__check_captcha',
			),
		);

		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();

		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if($form_validation === false){

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
	
			/**
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_attendance');
			$meta_description = $this->cbconfig->item('site_meta_description_attendance');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_attendance');
			$meta_author = $this->cbconfig->item('site_meta_author_attendance');
			$page_name = $this->cbconfig->item('site_page_name_attendance');
	
			$layoutconfig = array(
				'path' => 'contactus',
				'layout' => 'layout',
				'skin' => 'index',
				'layout_dir' => 'cic_sub',
				'mobile_layout_dir' => 'cic_sub',
				'use_sidebar' => $this->cbconfig->item('sidebar_main'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_main'),
				'skin_dir' => 'cic',
				'mobile_skin_dir' => 'cic',
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

			$to_email 	= "support@ciccommunity.com";
			// $to_email 	= "developer@rs-team.com";
			$from_email = "support@ciccommunity.com";
			$title 		= "[cic 문의 접수] ". $this->input->post('contactus_title');
			$message 	= $this->input->post('contactus_content');
			$this->email->from($from_email);
			$this->email->to($to_email);
			$this->email->subject($title);
			$this->email->message($message);
	
			if ($this->email->send() === false) {
				$this->session->set_flashdata('message', '등록중 오류가 발생했습니다.');
				redirect('contactus');
			} else {
				$this->session->set_flashdata('message', '정상적으로 문의등록이 완료되었습니다.');
				redirect('contactus');
			}
		}
	}



	/**
	 * 게시물 작성시 비회원이 작성한 경우 또는 게시판에서 캡챠를 사용시 captcha체크합니다
	 */
	public function _check_captcha($str)
	{
		$captcha = $this->session->userdata('captcha');
		if ( ! is_array($captcha)
			OR ! element('word', $captcha)
			OR strtolower(element('word', $captcha)) !== strtolower($str)) {
			$this->session->unset_userdata('captcha');
			$this->form_validation->set_message(
				'_check_captcha',
				'자동등록방지코드가 잘못되었습니다'
			);
			return false;
		}
		return true;
	}
}
