<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Document class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 일반 문서 페이지를 보여주는 controller 입니다.
 */
class Paper extends CB_Controller
{
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
		$this->load->library(array('querystring'));
	}

    function privacy(){
		$layout_dir = element('doc_layout', $data) ? element('doc_layout', $data) : $this->cbconfig->item('layout_document');
		$mobile_layout_dir = element('doc_mobile_layout', $data) ? element('doc_mobile_layout', $data) : $this->cbconfig->item('mobile_layout_document');
		$skin_dir = element('doc_skin', $data) ? element('doc_skin', $data) : $this->cbconfig->item('skin_document');
		$mobile_skin_dir = element('doc_mobile_skin', $data) ? element('doc_mobile_skin', $data) : $this->cbconfig->item('mobile_skin_document');
		$layoutconfig = array(
			'path' => 'paper',
			'layout' => 'layout',
			'skin' => 'privacy',
			'layout_dir' => 'cic',
			'mobile_layout_dir' => 'cic',
			'skin_dir' => 'cic',
			'mobile_skin_dir' => 'cic',
			'page_title' => '개인정보 처리방침',
			'page_name' => '개인정보 처리방침',
		);
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
    }
}