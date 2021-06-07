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
		$this->load->library(array('pagination', 'querystring'));
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
	}

}
