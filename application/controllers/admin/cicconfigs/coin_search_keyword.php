<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Banner class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>페이지설정>배너관리 controller 입니다.
 */
class Coin_keyword extends CB_Controller
{
	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cicconfigs/coin';

	
	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Coin');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Coin_model';

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
        parent::__construct();
        $this->load->helper('url');
		$this->load->library(array('pagination', 'querystring', 'form_validation', 'session'));
		$this->load->model(array('coin_model', 'Coin_model_admin'));
	}

    public function CStock_keyword(){

        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_keyword';
        $this->load->event($eventname);

        // 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

        $config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
        $this->load->view('CStock_keyword');



        $view['realtime_coin_info'] = $realtime_coin_info;
        $layoutconfig = array('layout' => 'layout', 'skin' => 'CStock_keyword');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

}