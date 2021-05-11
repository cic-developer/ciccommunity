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
	protected $models = array('Coin_model');

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
		$this->load->library(array('pagination', 'querystring', 'form_validation', 'session'));
		$this->load->model(array('coin_model', 'Coin_model_admin'));
	}

    /**
	 * 목록을 가져오는 메소드입니다
	 */
	public function CStock()
	{
		// 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_stok';
        $this->load->event($eventname);
		
		$view = array();
		$view['view'] = array();
		
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('mlh_id', 'member_level_history.mem_id', 'member.mem_userid', 'member.mem_nickname', 'mlh_from', 'mlh_to', 'mll_datetime', 'mlh_reason', 'mlh_ip'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('mlh_id', 'member_level_history.mem_id', 'mlh_from', 'mlh_to'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('mlh_id'); // 정렬이 가능한 필드

		
		$where = array();
		if (is_numeric($this->input->get('mlh_from'))) {
			$where['mlh_from'] = $this->input->get('mlh_from');
		}
		if (is_numeric($this->input->get('mlh_to'))) {
			$where['mlh_to'] = $this->input->get('mlh_to');

		}

		$result = $this->{$this->modelname}
		->getstockData($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $val),
					element('mem_nickname', $val),
					element('mem_icon', $val)
				);
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;
		
		
		
		
		
		
		
		$view['getStock'] = $getStock;
		
		$getList = $this -> Coin_model->get_coinlist();
		for($i=0; $i<count($getList); $i++){
			
			$market = $getList[$i]['market'];
			if(strcmp(substr($market, 0, 1), "K")==0){
				$coin_market = substr($market, 4);
				$data = array(
					'market' => $coin_market,
					'name_ko' => $getList[$i]['english_name'],
					'name_en' => $getList[$i]['korean_name'],
				);
			}   


				if(isset($data) && !empty($data)){
					$stock = $this->Coin_model->insertStockData($data);
					$view['view']['alert_message'] = '정상적으로 저장되었습니다';
				}
		}	

		//CREATE COIN LIST FOR ADMIN

		$this->load->library('form_validation');

		$config = array(
			array(
				'field' => 'selected_market',
				'rules'=>'required'
			),

		);
	
		$this->form_validation->set_rules($config);

		if($this->form_validation -> run () == FALSE)
		{
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);
		}else{
			$list = array(
				'selected_market' => $this -> input -> post('selected_market')
			);
			foreach($list as $l){
				if(isset($l) && !empty($l)){
					$stock_ = $this->Coin_model->dropdown_list($l);
					$view['view']['alert_message'] = '정상적으로 저장되었습니다';
					//print_r($stock_);
				}
			}
			
			
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);
		}


       	//GET MARKET 
	    // $admincoin = $this -> Coin_model_admin -> get_admin_coinList();
		for($i = 0; $i < count($getStock); $i++){
			$marketdata[] = $getStock[$i]->market;
            if($marketdata){
				$realtime_coin_info = $this->Coin_model->get_price($marketdata[$i]);
			}else{
				$realtime_coin_info = 0;
			}

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
	
}
?>