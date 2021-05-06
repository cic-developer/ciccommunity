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
class Coin extends CB_Controller
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
		$this->load->library(array('pagination', 'querystring', 'form_validation'));
		//$this->load->model(array('coin_model'));
	}

    /**
	 * 목록을 가져오는 메소드입니다
	 */
	public function CStock()
	{
        $eventname = 'event_stok';
        $this->load->event($eventname);

		
		$view = array();
		$view['view'] = array();
        $view['view']['event']['before'] = Events::trigger('before', $eventname);
		

		$this->load->library('form_validation');

		$config = array(
			array(
				'field' => 'market',
				'rules'=>'required'
			),

			array(
				'field' => 'name_ko',
				'rules'=>'required'
			),

			
			array(
				'field' => 'name_en',
				'rules'=>'required'
			),
		);

		
		$this->form_validation->set_rules($config);

		if($this->form_validation -> run () == FALSE)
		{
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);
		}else{
		
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			//$arr = $this->input->post();


			// $data = array(
			// 	'market' => $this -> input -> post('market'),
			// 	'name_ko' => $this -> input -> post('name_ko'),
			// 	'name_en' => $this -> input -> post('name_en')
			// 	);
			
			for($i=0; $i<$key_word; $i++){
				array_push($key_word, array(
					'market' => $this -> input -> post('market')[$i],
					'name_ko' => $this -> input -> post('name_ko')[$i],
					'name_en' => $this -> input -> post('name_en')[$i]
					));
				}	
			
			// if(isset($data) && !empty($data)){
			$stock = $this->Coin_model->insertStockData($key_word);
			// }
		    $view['view']['alert_message'] = '정상적으로 저장되었습니다';
			
		}

		//Get price from API
		//$realtime_coin_info = $this->Coin_model->get_price();


		$getStock = $this -> Coin_model->getstockData();

		for($i = 0; $i < count($getStock); $i++){
			$market[] = $getStock[$i]->market;
            if($market){
				$realtime_coin_info = $this->Coin_model->get_price($marketdata[$i]);
			}else{
				$realtime_coin_info = 0;
			}

			// echo "<br><pre>";
			// print_r($realtime_coin_info);
			// echo "</pre>"; 
		

		// $view['view']['maket'] = $market;

			foreach ($getStock as $getstoks){
				if($getstoks-> market){
					$marketdata[] = $getstoks->market;
				}else{
					$marketdata[] = 0;
				}
			}
			// echo "<br><pre>";
			// print_r($realtime_coin_info);
			// echo "</pre>";
			
			$view['realtime_coin_info'] = $realtime_coin_info;
			$layoutconfig = array('layout' => 'layout', 'skin' => 'CStock');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}
			// echo "<br><pre>";
			// print_r($realtime_coin_info);
			// echo "</pre>";
		}
	

	public function coin_search(){
		$this->load->view('search');
			//skeyword
		$data2['skeyword'] = $this->Coin_model->search_coin();
       	$this->load->view('result', $data2);


		}
}
?>