<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 메인 페이지를 담당하는 controller 입니다.
 */
class Main extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Board', 'Post', 'Search_keyword', 'CIC_Banner');

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'coin_price');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('querystring', 'coinapi'));
	}


	/**
	 * 전체 메인 페이지입니다
	 */
	public function index()
	{
		$view = array();
		$view['view'] = array();
		$view['view']['banner'] = array();

		$eventname = 'event_main_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();
		$view['view']['banner'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
        
		// 배너 가져오기 시작
		$_banner = $this->CIC_Banner_model->get_today_list();
		$banner = array();
		
		if(element('list', $_banner)){
			foreach (element('list', $_banner) as $key => $val) {
				if ($val && $val['ban_image']) {
					$banner['list'][$key] = $val;
				}
			}
		}
		
		$view['view']['banner_count'] = count(element('list', $banner));
		$view['view']['banner_noimage_count'] = 4 - $view['view']['banner_count'];
		// 배너 가져오기 끝

		$where = array(
			'brd_search' => 1,
		);
		$board_id = $this->Board_model->get_board_list($where);
		$board_list = array();
		if ($board_id && is_array($board_id)) {
			foreach ($board_id as $key => $val) {
				$board_list[] = $this->board->item_all(element('brd_id', $val));
			}
		}

		$checktime = cdate('Y-m-d H:i:s', ctimestamp() - 24 * 60 * 60);
		$where = array(
			'post_exept_state' => 0,
			'post_datetime >=' => $checktime,
			'post_del <>' => 2,
		);
		$limit = 10;

		$popularpost = $this->Post_model
			->get_like_point_ranking_list($limit, $offset, $where, '', $findex, $forder, $sfield, $skeyword);

		$list_num = 1;
		
		if (element('list', $popularpost)) {
			foreach (element('list', $popularpost) as $key => $val) {
				$popularpost['list'][$key]['post_display_name'] = display_username(
					element('post_userid', $val),
					element('post_nickname', $val)
				);
				$popularpost['list'][$key]['board'] = $board = $this->board->item_all(element('brd_id', $val));
				$popularpost['list'][$key]['num'] = $list_num++;
				if ($board) {
					$popularpost['list'][$key]['boardurl'] = board_url(element('brd_key', $board));
					$popularpost['list'][$key]['posturl'] = post_url(element('brd_key', $board), element('post_id', $val));
				}
				$popularpost['list'][$key]['category'] = '';
				if (element('post_category', $val)) {
					$popularpost['list'][$key]['category'] = $this->Board_category_model->get_category_info(element('brd_id', $val), element('post_category', $val));
				}
				if (element('post_image', $val)) {
					$imagewhere = array(
						'post_id' => element('post_id', $val),
						'pfi_is_image' => 1,
					);
					$popularpost['list'][$key][''] = thumb_url('post', element('pfi_filename', $file), 80);
				} else {
					$popularpost['list'][$key]['thumb_url'] = get_post_image_url(element('post_content', $val), 80);
				}
			}
		}
		$view['view']['data'] = $popularpost;

		$select = 'brd_id, brd_name';
		$view['view']['boardlist'] = $this->Board_model->get_board_list();
			
		$view['view']['board_list'] = $board_list;
		$view['view']['canonical'] = site_url();		
		$view['view']['searchrank'] = $this->Search_keyword_model->get_main_rank();
		$view['view']['popularpost'] = $popularpost;
		$view['view']['banner'] = $banner;
		$view['view']['maincoin'] = $this->coinapi->get_main_data();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_main');
		$meta_description = $this->cbconfig->item('site_meta_description_main');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
		$meta_author = $this->cbconfig->item('site_meta_author_main');
		$page_name = $this->cbconfig->item('site_page_name_main');

		$layoutconfig = array(
			'path' => 'main',
			'layout' => 'layout',
			'skin' => 'main',
			'layout_dir' => $this->cbconfig->item('layout_main'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_main'),
			'use_sidebar' => $this->cbconfig->item('sidebar_main'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_main'),
			'skin_dir' => $this->cbconfig->item('skin_main'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_main'),
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

	/**
	 * 배너 조회수
	 */
	public function bannerHit()
	{
        
		$eventname = 'event_main_bannerHit';
		$this->load->event($eventname);
        
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
        
		if($this->input->post("ban_id")){
			$ban_id = $this->input->post("ban_id");
            
			// 세션 생성
			if ( ! $this->session->userdata('ban_id_' . $ban_id)) {
				$this->CIC_Banner_model->update_plus($ban_id, 'ban_hit', 1);
				$this->session->set_userdata(
					'ban_id_' . $ban_id,
					'1'
				);
                
				$result = array(
					'state' => '1',
					'message' => 'hit success',
				);
				exit(json_encode($result));
			}
		}
        
		$result = array(
			'state' => '0',
			'message' => 'hit fail',
		);
		exit(json_encode($result));
	}


	/**
	 * 메인페이지 코인설정 페이지입니다
	 */
	public function coin()
	{
		
		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$view = array();
		$view['view'] = array();
		$view['view']['banner'] = array();

		$eventname = 'event_main_index';
		$this->load->event($eventname);
		$this->load->model(array('CIC_maincoin_exchange_model','CIC_maincoin_coin_model','Member_extra_vars_model'));

		$view = array();
		$view['view'] = array();
		$view['view']['banner'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
        

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'my_exchange',
				'label' => '내 거래소',
				'rules' => 'trim|required|callback__check_comma_input',
			),
			array(
				'field' => 'my_coin',
				'label' => '내 코인',
				'rules' => 'trim|required|callback__check_comma_input',
			),
			array(
				'field' => 'money',
				'label' => '화폐단위',
				'rules' => 'trim|required|in_list[krw,usd]',
			),
		);
		$this->form_validation->set_rules($config);

		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === true) {

			$exchange = explode(',',$this->input->post('my_exchange'));
			for($i=0; $i<count($exchange); $i++){
				$exchange[$i] = (int)trim($exchange[$i]);
			}
			$exchange = array_unique($exchange);

			$coin = explode(',',$this->input->post('my_coin'));
			for($i=0; $i<count($coin); $i++){
				$coin[$i] = (int)trim($coin[$i]);
			}
			$coin = array_unique($coin);

			$money = $this->input->post('money');
			$set_data = array(
				'exchange' => $exchange,
				'coin' => $coin,
				'money' => $money,
			);
			$this->Member_extra_vars_model->save($this->member->is_member(), array('mem_maincoin' => json_encode($set_data,JSON_UNESCAPED_UNICODE)));
			
			$this->session->set_flashdata(
				'message',
				'정상적으로 수정되었습니다.'
			);
			redirect(base_url('/main/coin'));
		} else {
			// 데이터 가져오기 시작
			$exchange_list = $this->CIC_maincoin_exchange_model->get('','','','','','cme_orderby','ASC');
			$coin_list = $this->CIC_maincoin_coin_model->get('','',array('cmc_default !=' => 2),'','','cmc_orderby','ASC');
			$member_coin_data_raw = $this->Member_extra_vars_model->item($this->member->is_member(), 'mem_maincoin');
			$member_coin_data = json_decode($member_coin_data_raw, true);
			$member_exchange_list = element('exchange',$member_coin_data) ? element('exchange',$member_coin_data) : array();
			$member_coin_list = element('coin',$member_coin_data) ? element('coin',$member_coin_data) : array();
			// 데이터 가져오기 끝
			$view['view']['exchange_list'] = $exchange_list;
			$view['view']['coin_list'] = $coin_list;
	
			$my_exchange_list = array();
			$except_exchange_list = array();
			foreach($exchange_list as $l){
				if(in_array(element('cme_idx' ,$l), $member_exchange_list)){
					$my_exchange_list[] = $l;
				} else {
					$except_exchange_list[] = $l;
				}
			}
			$my_coin_list = array();
			$except_coin_list = array();
			foreach($coin_list as $l){
				if(in_array(element('cmc_idx' ,$l), $member_coin_list)){
					$my_coin_list[] = $l;
				} else {
					$except_coin_list[] = $l;
				}
			}
			$view['view']['my_exchange_list'] = $my_exchange_list;
			$view['view']['except_exchange_list'] = $except_exchange_list;
			$view['view']['my_coin_list'] = $my_coin_list;
			$view['view']['except_coin_list'] = $except_coin_list;
			$view['view']['money'] = element('money',$member_coin_data) ? element('money',$member_coin_data) : 'krw';

	
			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
	
			/**
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_main');
			$meta_description = $this->cbconfig->item('site_meta_description_main');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
			$meta_author = $this->cbconfig->item('site_meta_author_main');
			$page_name = $this->cbconfig->item('site_page_name_main');
	
			$layoutconfig = array(
				'path' => 'main',
				'layout' => 'layout',
				'skin' => 'coin',
				'layout_dir' => 'cic_sub',//$this->cbconfig->item('layout_main'),
				'mobile_layout_dir' => 'cic_sub',//$this->cbconfig->item('mobile_layout_main'),
				'use_sidebar' => $this->cbconfig->item('sidebar_main'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_main'),
				'skin_dir' => 'cic',//$this->cbconfig->item('skin_main'),
				'mobile_skin_dir' => 'cic',//$this->cbconfig->item('mobile_skin_main'),
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


	/**
	 * 메인페이지 코인설정 페이지입니다
	 */
	public function ajax_get_maincoin()
	{

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'cmc_symbol',
				'label' => '선택 코인',
				'rules' => 'trim|required|alpha_numeric|min_length[2]|max_length[6]',
			),
		);
		$this->form_validation->set_rules($config);

		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false) {
			$result = array('error' => '비정상적인 접근입니다.(1)');
			exit(json_encode($result));
		}
		$symbol = $this->input->post('cmc_symbol');
		$mem_idx = $this->member->is_member();
		$data = $this->coinapi->get_select_data($symbol);
		if($data === FALSE){
			$result = array('error' => '비정상적인 접근입니다.(2)');
			exit(json_encode($result));
		}

		$result = array('success' => $this->load->view('main/cic/ajax_maincoin', $data, TRUE));
		exit(json_encode($result));
	}

	public function _check_comma_input($string){
		if(count(explode(',', $string)) > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
