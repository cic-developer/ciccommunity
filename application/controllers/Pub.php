<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Faq class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * FAQ 페이지를 보여주는 controller 입니다.
 */
class Pub extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Faq', 'Faq_group');

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
		$this->load->library(array('pagination', 'querystring'));
	}

    public function index(){
		$view = array();
		$view['view'] = array();

		/**
		 * 레이아웃을 정의합니다
		 */
		$layout_dir = '/test';
		$mobile_layout_dir = '/test';
		$skin_dir = 'test';
		$mobile_skin_dir = 'test';
		$layoutconfig = array(
			'path' => 'pub',
			'layout' => 'layout',
			'skin' => 'example',
			'layout_dir' => $layout_dir,
			'mobile_layout_dir' => $mobile_layout_dir,
			'skin_dir' => $skin_dir,
			'mobile_skin_dir' => $mobile_skin_dir,
		);
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
    }

    function test($index = 0){
        $view = array();
		$view['view'] = array();
		/**
		 * 레이아웃을 정의합니다
		 */

		$layout_dir = '/test';
		$mobile_layout_dir = '/test';
		$skin_dir = 'test';
		$mobile_skin_dir = 'test';
		$layoutconfig = array(
			'path' => 'pub',
			'layout' => 'layout',
			'skin' => $index ? $index : 'example',
			'layout_dir' => $layout_dir,
			'mobile_layout_dir' => $mobile_layout_dir,
			'skin_dir' => $skin_dir,
			'mobile_skin_dir' => $mobile_skin_dir,
		);
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
    }

}
?>