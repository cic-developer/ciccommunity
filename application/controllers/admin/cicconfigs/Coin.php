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
	public $pagedir = 'cicconfigs/coin/CStock';

	
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
		$this->{$this->modelname}->allow_search_field = array('market', 'name_ko', 'name_en'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('market'); // 정렬이 가능한 필드

		$where = array();
 	
		$result = $this->{$this->modelname}
		->get_coin_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['display_name'] = display_username(
					element('market', $val),
					element('name_ko', $val),
					element('name_en', $val)
				);
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;
		//$view['result'] = $result;
		

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;
		
		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '/CStock' . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;
		
		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('market' => '마켓', 'name_ko' => '한국어명', 'name_en' => '영어명');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/listdelete/?' . $param->output());
		$view['view']['list_trash_url'] = admin_url($this->pagedir . '/listtrash/?' . $param->output());

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
		

    	//Load data to second db

		$refresh = $this -> input -> post('refresh');
		
		if($refresh){
			$getList = $this -> Coin_model->retrieve_api();
			for($i=0; $i<count($getList); $i++){
				$market = $getList[$i]['market'];
				if(strcmp(substr($market, 0, 1), "K")==0){
					$coin_market = substr($market, 4);
					$data = array(
						'market' => $coin_market,
						'name_ko' => $getList[$i]['english_name'],
						'name_en' => $getList[$i]['korean_name'],
					);
					//For rafreshing admin page
					if(isset($data) && !empty($data)){
						$stock = $this->Coin_model->insertStockData($data);
						$view['view']['alert_message'] = '정상적으로 저장되었습니다';
					}

					$data = array(
						array(
							'coin_market'=> $coin_market,
							'keyword'=>$getList[$i]['korean_name']
						),
						array(
							'coin_market'=> $coin_market,
							'keyword'=>$getList[$i]['english_name']
						),
						array(
							'coin_market'=> $coin_market,
							'keyword'=> $coin_market
						),
					);
					if(isset($data) && !empty($data)){	
						for($j = 0; $j < count($data); $j++) {
							$this->Coin_model -> insert_admin_list($data[$j]);
						}
					}	
				}
			}
		}

       	//GET MARKET PRICE
	    // $getStock = $this -> Coin_model_admin->get_keyword();
    
		// if($refresh){
		// 	for($i = 0; $i < count($getStock); $i++){
				
		// 		$marketdata[] = $getStock[$i]['market'];

		// 		if($marketdata){
		// 			$realtime_coin_info = $this->Coin_model->get_price($marketdata[$i]);
		// 		}else{
		// 			$realtime_coin_info = 0;
		// 		}

			
		// 		echo "<br><pre>";
		// 		print_r($realtime_coin_info);
		// 		echo "</pre>";
		// 		$refresh = $this -> input -> post('refresh');
				
		// 			$view['realtime_coin_info'] = $realtime_coin_info;
		// 	}


		// }

			$layoutconfig = array('layout' => 'layout', 'skin' => 'CStock');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));

	
		}
		
	
		public function CStock_keyword(){

			// 이벤트 라이브러리를 로딩합니다
			$eventname = 'event_amdmin_coin_keyword';
			$this->load->event($eventname);
	        $this->load->helper('url');
	
			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before'] = Events::trigger('before', $eventname);
	
			//$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
			
			$view = array();
			$view['view'] = array();
	
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

			//CREATE COIN KEYWORD LIST FOR ADMIN

			$this->load->library('form_validation');

			$config = array(
				array(
					'field' => 'coin_market',
					'rules'=>'required'
				),
				array(
					'field' => 'keyword',
					'rules'=>'required'
				),

			);
			$getList = $this -> Coin_model->retrieve_api();
		
			$this->form_validation->set_rules($config);

			if($this->form_validation -> run () == FALSE)
			{
				$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);
			}else{
				$data = array(
					'coin_market' => $this -> input -> post('coin_market'),
					'keyword' => $this -> input -> post('keyword'),

				);
				if(isset($data) && !empty($data)){
					$this->Coin_model_admin->insert_keyword($data);
					$view['view']['alert_message'] = '정상적으로 저장되었습니다';
				}
			}
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);
			//SHOWING LIST TO VIEW
			$keylist = $this -> Coin_model_admin->get_keyword();
			$view['keylist'] = $keylist;


			// $key_id = $_GET['id'];
			// $deleted = $this->Coin_model_admin->delete_keyword($key_id);
			// if($deleted == 1){
			// 	$this->session->set_flashdata('success', '삭제되었습니다');
			// 	redirect(current_url());
			// }
			/**
			* 어드민 레이아웃을 정의합니다
			*/
			$layoutconfig = array('layout' => 'layout', 'skin' => 'CStock_keyword');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));

		}


		function delete_keyword(){

			// 이벤트 라이브러리를 로딩합니다
			$eventname = 'event_amdmin_coin_delete';
			$this->load->event($eventname);
			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before'] = Events::trigger('before', $eventname);
			//$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
			$view = array();
			$view['view'] = array();			
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
						
			$key_id = $_GET['id'];

			$deleted = $this->Coin_model_admin->delete_keyword($key_id);
			if($deleted == 1){
				$view['view']['alert_message'] = '정상적으로 저장되었습니다';
				redirect('https://dev.ciccommunity.com/admin/cicconfigs/coin/CStock', 'rafresh');
			}

			
			$layoutconfig2 = array('layout' => 'layout', 'skin' => 'delete_keyword');
			//$layoutconfig = array('layout' => 'layout', 'skin' => 'CStock_keyword');
			$view['layout'] = $this->managelayout->admin($layoutconfig2, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));

		}
	
}
?>