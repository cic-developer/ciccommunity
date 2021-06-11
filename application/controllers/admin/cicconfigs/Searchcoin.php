<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Coin class
 *
 * Copyright (c) CIBoard <www.rs-team.com>
 *
 * @author CIBoard (develop@rs-team.com)
 */

/**
 * 관리자>페이지설정>검색 코인관리 controller 입니다.
 */
class Searchcoin extends CB_Controller
{
	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cicconfigs/searchcoin';

	
	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('CIC_coin_list', 'CIC_coin_keyword');

	protected $modelname = 'CIC_coin_list_model';
	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'dhtml_editor','url');

	function __construct()
	{
		parent::__construct();
		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring', 'form_validation', 'session'));
		$this->load->model(array('CIC_coin_list_model', 'CIC_coin_keyword_model'));
	}

    /**
	 * 목록을 가져오는 메소드입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_stock';
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
		$this->{$this->modelname}->allow_search_field = array('clist_market', 'clist_name_ko', 'clist_name_en'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('clist_market'); // 정렬이 가능한 필드

		$where = array();
		$result = $this->{$this->modelname}
		->get_coin_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['display_name'] = display_username(
					element('clist_market', $val),
					element('clist_name_ko', $val),
					element('clist_name_en', $val)
				);
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;
		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;
		
		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '/' . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;
		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('clist_market' => '마켓', 'clist_name_ko' => '한국어명', 'clist_name_en' => '영어명');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/listdelete/?' . $param->output());
		$view['view']['list_trash_url'] = admin_url($this->pagedir . '/listtrash/?' . $param->output());
		
		//이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
		// keyword 테이블을 통째로 불러온다.
		$coin_list = $this->CIC_coin_list_model->getstockData();
		// 통째로 가져온 테이블에서 keyword 만 담은 array() 만든다.
		$keyword_arr = array();
		$keyword_list = $this->CIC_coin_keyword_model->get_keyword();
		foreach($keyword_list as $value){
			$keyword_arr[] = element('coin_keyword', $value);
		}
		// 통째로 가져온 테이블에서 keyword 만 담은 array() 만든다.
		$coin_arr = array();
		foreach($coin_list as $value){
			$coin_arr[] = element('clist_market', $value);
		}
    
		$get_apiList = $this -> CIC_coin_list_model->get_apiList();
		for($i=0; $i<count($get_apiList); $i++){
			// Getting only coin starting with K
			$market =$get_apiList[$i]['market'];
			if(strcmp(substr($market, 0, 1), "K")==0){	
				$market = substr($market, 4);	
				$data = array(
					'clist_market' => $market,
					'clist_name_ko' => $get_apiList[$i]['korean_name'],
					'clist_name_en' => $get_apiList[$i]['english_name'],
				);
				if(isset($data) && !empty($data)){
					foreach($data as $coinData){
						if(in_array($coinData, $coin_arr)){
							continue;
						}
						else{
							$stock = $this->CIC_coin_list_model->insertStockData($data);
							$view['view']['alert_message'] = '정상적으로 저장되었습니다';
						}
					}
				}
				$data = array(
					array(
						'coin_market'=> $market,
						'coin_keyword'=>$get_apiList[$i]['korean_name'],
					),
					array(
						'coin_market'=> $market,
						'coin_keyword'=>$get_apiList[$i]['english_name']
					),
					array(
						'coin_market'=> $market,
						'coin_keyword'=> $market
					),
				);
				if(isset($data) && !empty($data)){
					foreach($data as $thisData){
						if(in_array($thisData['coin_keyword'], $keyword_arr)){	
							continue;
						}
						else{
							$this->CIC_coin_keyword_model->insert_keyword_list($thisData);
						}	
					} 
				}else{
					continue;
				}	
			}
		}
		$layoutconfig = array('layout' => 'layout', 'skin' => 'Searchcoin');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	public function CStock_keyword()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_amdmin_coin_keyword';
		$this->load->event($eventname);
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
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
		//$getList = $this -> CIC_coin_list_model->retrieve_api();
		$this->form_validation->set_rules($config);
		if($this->form_validation -> run () == FALSE){
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);
		}else{
			$is_data = $this->CIC_coin_keyword_model->get_one('','',array('coin_keyword' => $this -> input -> post('keyword')));
			if(!$is_data){
				$data = array(
					'coin_market' => $this -> input -> post('coin_market'),
					'coin_keyword' => $this -> input -> post('keyword'),
	
				);
				$this->CIC_coin_keyword_model->insert($data);
				$view['view']['alert_message'] = '수정 완료되었습니다.';
			} else {
				$view['view']['alert_warning_message'] = '이미 등록되어있는 키워드입니다.';
			}
		}
		$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

		//INSERT KEYWORDS IN DB
		$keyword_list = $this->CIC_coin_keyword_model->get_keyword();
		$keyword_arr = array();
		foreach($keyword_list as $value){
			$keyword_arr[] = element('coin_keyword', $value);
		}
		$stockKey = $this->CIC_coin_list_model->getstockData();
		foreach($stockKey as $getList){
			$data = array(
				array(
					'coin_market'=> $getList['clist_market'],
					'coin_keyword'=>$getList['clist_name_ko']
				),
				array(
					'coin_market'=> $getList['clist_market'],
					'coin_keyword'=>$getList['clist_name_en']
				),
				array(
					'coin_market'=> $getList['clist_market'],
					'coin_keyword'=> $getList['clist_market'],
				),
			);
			if(isset($data) && !empty($data)){
				foreach($data as $thisData){
					if(in_array($thisData['coin_keyword'], $keyword_arr)){	
						continue;
					}
					else{
						$this->CIC_coin_keyword_model->refresh_keyword_list($thisData);
					}	
				} 
			}	
		}	
		//SHOWING LIST TO VIEW KEYWORD TO LIST
		$keylist = $this -> CIC_coin_keyword_model->get_keyword();
		$view['keylist'] = $keylist;
		$coin_list = $this->CIC_coin_list_model->getstockData();
		$view['coin_list'] = $coin_list;

		//이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		* 어드민 레이아웃을 정의합니다
		*/
		$layoutconfig = array('layout' => 'layout', 'skin' => 'Searchcoin_keyword');
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
		$view = array();
		$view['view'] = array();			
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		//DELETE KEYWORD
		$key_id = (int)$this->input->get('id');
		$deleted = $this->CIC_coin_keyword_model->delete_keyword($key_id);
		if($deleted == 1){
			redirect( admin_url("/cicconfigs/searchcoin/CStock_keyword?id=".$this->input->get('pageId')));
		}
		else{
			redirect( admin_url("/cicconfigs/searchcoin/CStock_keyword?id=".$this->input->get('pageId')));
		}

	}
	function get_keyword(){
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_amdmin_coin_get';
		$this->load->event($eventname);
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		$view = array();
		$view['view'] = array();			
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		if(!empty($this->input->get('id'))){
			$id = $this->input->get('id');
			$getKey = $this->CIC_coin_keyword_model -> getKeywordRow($id);
			echo json_encode($getKey);
    	}

	}
	function update_keyword(){
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_amdmin_coin_update';
		$this->load->event($eventname);
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		$view = array();
		$view['view'] = array();			
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		$this->load->library('form_validation');
		$config = array(
			array(
				'field' => 'cp_content1',
				'rules'=>'required'
			),
		);
		$data = array(
			'_table' => 'cic_coin_keyword', // pass the real table name
			'id' => $this->input->get('wid_idx1'),
			'coin_keyword' => $this->input->get('cp_content1')
		);
			
		$update = $this->CIC_coin_keyword_model->update_keyword($data);
		if($update){
			redirect(admin_url("/cicconfigs/searchcoin/CStock_keyword?id=".$this->input->get('pageId')));
		}
		else{
			return false;
		}
	}

}
?>