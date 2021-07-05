<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Search class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 게시물 전체 검색시 필요한 controller 입니다.
 */
class Sign_up extends CB_Controller
{
    function __construct()
	{
		parent::__construct();
		$_end_date = '2021-06-30 17:00:00';
		$_end_timestamp = strtotime($_end_date);
		$_now = strtotime("now");
		if($_end_timestamp < $_now){
			redirect('/');
			exit;
		}
	}

    public function index(){
        
		$page_title = '사전가입 종료';
		$meta_description = '사전가입 이벤트가 종료되었습니다.';
		$meta_keywords = '사전가입';
		
		$layoutconfig = array(
			'path' => 'signup',
			'layout' => 'layout',
			'skin' => 'index',
			'layout_dir' => 'test',
			'mobile_layout_dir' => 'test',
			'use_sidebar' => $this->cbconfig->item('sidebar_news'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_news'),
			'skin_dir' => 'cic',
			'mobile_skin_dir' => 'cic',
			'page_title' => $page_title,
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
		);
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
    }
}