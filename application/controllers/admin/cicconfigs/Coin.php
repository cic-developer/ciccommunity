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
        $eventname = 'event_stok';
        $this->load->event($eventname);
		
		
		
		$view = array();
		$view['view'] = array();
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		// $view['view']['sort'] = array(
		// 	'wid_idx' => $param->sort('wid_idx', 'asc'),
		// );
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->Coin_model->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		// 'wid_admin_id', 'wid_admin_ip', 'wid_res_datetime', 'wid_content'
		$this->Coin_model->allow_search_field = array(''); // 검색이 가능한 필드

		$this->Coin_model->search_field_equal = array(''); // 검색중 like 가 아닌 = 검색을 하는 필드
		
		$this->Coin_model->allow_order_field = array(''); // 정렬이 가능한 필드

		$where = array();

		$result = $this->Coin_model->getstockData($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {

				$where = array(
					'' => element('', $val),
				);
				
				$result['list'][$key]['num'] = $list_num--;
			}
		}

		$view['view']['data'] = $result;
				// Pagination Configuration
		/**
		 * 페이지네이션을 생성합니다
		 */

		//$getStock = $this -> Coin_model->getstockData();
		$config['base_url'] = admin_url($this->pagedir).'?'. $param->replace('page');
		//$config['total_rows'] = $this->Coin_model->getrecord();
		$config['per_page'] = $per_page;
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;
		
		$view['getStock'] = $getStock;
		
		// Initialize
		$this->pagination->initialize($config);
		$view['pagination'] = $this->pagination->create_links();


		
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


		//GET COIN MARKET INFORMATION FOR DROPDOWN LIST

		$getStock = $this -> Coin_model->getstockData();
		$view['getStock'] = $getStock;//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
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


	public function loadRecord(){
		
		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		
		
		//admin search 
		print_r(1);

		$search_text = "";
		if($this->input->post('submit') != NULL ){
			$search_text = $this->input->post('search');
			$this->session->set_userdata(array("search"=>$search_text));
		}else{
			if($this->session->userdata('search') != NULL)
			{
				$search_text = $this->session->userdata('search');
			}
		}
		$rowperpage = 5;

    	// Row position
		if($rowno != 0){
		$rowno = ($rowno-1) * $rowperpage;
		}
	
		// All records count
		$allcount = $this->Main_model->getrecordCount($search_text);

		// Get records
		$users_record = $this->Main_model->getData($rowno,$rowperpage,$search_text);
	
		// Pagination Configuration
		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir).'?'. $param->replace('page');
		$config['total_rows'] = $this->Coin_model->getrecord();
		$config['per_page'] = $per_page;
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;
		$getStock = $this -> Coin_model->getstockData();
		$view['getStock'] = $getStock;
		
		// Initialize
		$this->pagination->initialize($config);
		$view['pagination'] = $this->pagination->create_links();
		// $data['result'] = $users_record;
		// $data['row'] = $rowno;
		// $data['search'] = $search_text;

		// Load view
		$this->load->view('Coin/loadRecord', $view);


		
		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'CStock');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	

		}

	
}
?>