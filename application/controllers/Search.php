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
class Search extends CB_Controller
{
    /**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Board', 'Board_group', 'Post', 'News', 'Post_file', 'Search_keyword', 'CIC_coin_list', 'CIC_coin_keyword', 'News', 'Company');
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
		$this->load->library(array('pagination', 'querystring', 'cic_company'));
	}
	/**
	 * 검색 페이지 함수입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_search_index';
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
		$findex_get = $this->input->get('findex', null, 'latest');
		$sfield = $sfield2 = $this->input->get('sfield', null, '');
		$sop = $this->input->get('sop', null, '');

		$mem_id = (int) $this->member->item('mem_id');
		$type = $this->input->get('type', null, '');
		if($type == 'free'){
			$type_word = '자유게시판';
		} else if($type == 'writer'){
			$type_word = 'WRITER';
		} else if($type == 'news'){
			$type_word = '뉴스';
		} else if($type == 'forum'){
			$type_word = '포럼';
		} else {
			$type_word = '통합검색';
		}
		$view['view']['is_all'] = $is_all = !in_array($type, array('free','writer','news', 'forum'));
		$view['view']['is_free'] = $is_free = ($type == 'free');
		$view['view']['is_writer'] = $is_writer = ($type == 'writer');
		$view['view']['is_news'] = $is_news = ($type == 'news');
		$view['view']['is_forum'] = $is_forum = ($type == 'forum');
		$view['view']['type'] = $type;
		$view['view']['type_word'] = $type_word;

		
		if($sfield == 'post_title'){
			$sfield_word = '제목';
		} else if($sfield == 'post_content'){
			$sfield_word = '내용';
		} else if($sfield == 'post_nickname'){
			$sfield_word = '작성자';
		} else {
			$sfield_word = '전체';
			$sfield === 'post_both';
		}
		$view['view']['sfield'] = $sfield;
		$view['view']['sfield_word'] = $sfield_word;

		if ($sfield === 'post_both') {
			// $sfield = array('post_title', 'post_content', 'post_nickname');
			$sfield = array('post_title', 'post_content', );
		}
		
		if($findex_get == 'view'){
			$this->Post_model->allow_order[] = 'post_hit desc, post_num asc';
			$findex = 'post_hit desc, post_num asc';
			$findex_word = "조회 순";
		} else {
			$findex_word = "최신 순";
			$findex = 'post_num, post_reply';
		}
		$view['view']['findex'] = $findex_get;
		$view['view']['findex_word'] = $findex_word;

		$skeyword = $this->input->get('skeyword', null, '');
		if (empty($skeyword)) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_nokeyword_layout'] = Events::trigger('before_nokeyword_layout', $eventname);

			/**
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_search');
			$meta_description = $this->cbconfig->item('site_meta_description_search');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_search');
			$meta_author = $this->cbconfig->item('site_meta_author_search');
			$page_name = $this->cbconfig->item('site_page_name_search');

			$layoutconfig = array(
				'path' => 'search',
				'layout' => 'layout',
				'skin' => 'search',
				'layout_dir' => $this->cbconfig->item('layout_search'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_search'),
				'use_sidebar' => $this->cbconfig->item('sidebar_search'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_search'),
				'skin_dir' => $this->cbconfig->item('skin_search'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_search'),
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
			return false;
		}


		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->Post_model->allow_search_field = array('post_title', 'post_content', 'post_userid', 'post_nickname'); // 검색이 가능한 필드
		$this->Post_model->search_field_equal = array('post_userid'); // 검색중 like 가 아닌 = 검색을 하는 필드

		$per_page = 10;
		$offset = ($page - 1) * $per_page;

		$group_id = (int) $this->input->get('group_id') ? (int) $this->input->get('group_id') : '';

		$where = array();
		$boardwhere = array(
			'brd_search' => 1,
		);
		if ($group_id) {
			$where['board.bgr_id'] = $group_id;
			$boardwhere['board.bgr_id'] = $group_id;
		}

		$boardlisttmp = $this->Board_model->get_board_list($boardwhere);
		$boardlist = array();
		if (is_array($boardlisttmp)) {
			foreach ($boardlisttmp as $key => $value) {
				$boardlist[$value['brd_id']] = $value;
			}
		}
		$grouplisttmp = $this->Board_group_model
			->get('', '', '', '', 0, 'bgr_order', 'ASC');
		if (is_array($grouplisttmp)) {
			foreach ($grouplisttmp as $key => $value) {
				$grouplist[$value['bgr_id']] = $value;
			}
		}
		$where['post.post_secret'] = 0;
		$where['post.post_del'] = 0;
		$like = '';

		//통합검색 or 자유게시판검색일 경우 자유게시판 정보 불러오기
		$free_result = array();
		if($is_all || $is_free){
			$board_id = 1;
			$free_result = $this->Post_model
				->get_search_list($per_page, $offset, $where, $like, $board_id, $findex, $sfield, $skeyword, $sop);
				
			$list_num = $free_result['total_rows'] - ($page - 1) * $per_page;
			if (element('list', $free_result)) {
				foreach (element('list', $free_result) as $key => $val) {
					$images = '';
					if (element('post_image', $val)) {
						$imagewhere = array(
							'post_id' => element('post_id', $val),
							'pfi_is_image' => 1,
						);
						$images = $this->Post_file_model
							->get_one('', '', $imagewhere, '', '', 'pfi_id', 'ASC');
					}
					$free_result['list'][$key]['images'] = $images;
					$free_result['list'][$key]['thumb_url'] = thumb_url('post', element('pfi_filename', $images), 50, 40);
					$free_result['list'][$key]['post_url'] = post_url(element('brd_key', $val), element('post_id', $val));
					$free_result['list'][$key]['display_name'] = display_username(
						element('post_userid', $val),
						element('post_nickname', $val),
						element('mem_icon', $val),
						'Y'
					);
					
					$free_result['list'][$key]['display_datetime'] = display_datetime(element('post_datetime', $val), 'user', 'Y-m-d H:i');
					$free_result['list'][$key]['content'] = cut_str(strip_tags(element('post_content', $val)),200);
					$free_result['list'][$key]['is_mobile'] = (element('post_device', $val) === 'mobile') ? true : false;
				}
			}
		}

		//통합검색 or WRITER검색일 경우 WRITER 정보 불러오기
		$writer_result = array();
		if($is_all || $is_writer){
			$board_id = 2;
			$writer_result = $this->Post_model
				->get_search_list($per_page, $offset, $where, $like, $board_id, $findex, $sfield, $skeyword, $sop);
				
			$list_num = $writer_result['total_rows'] - ($page - 1) * $per_page;
			if (element('list', $writer_result)) {
				foreach (element('list', $writer_result) as $key => $val) {
					$images = '';
					if (element('post_image', $val)) {
						$imagewhere = array(
							'post_id' => element('post_id', $val),
							'pfi_is_image' => 1,
						);
						$images = $this->Post_file_model
							->get_one('', '', $imagewhere, '', '', 'pfi_id', 'ASC');
					}
					$writer_result['list'][$key]['images'] = $images;
					$writer_result['list'][$key]['thumb_url'] = thumb_url('post', element('pfi_filename', $images), 50, 40);
					$writer_result['list'][$key]['post_url'] = post_url(element('brd_key', $val), element('post_id', $val));
					$writer_result['list'][$key]['display_name'] = display_username(
						element('post_userid', $val),
						element('post_nickname', $val),
						element('mem_icon', $val),
						'Y'
					);
					
					$writer_result['list'][$key]['display_datetime'] = display_datetime(element('post_datetime', $val), 'user', 'Y-m-d H:i');
					$writer_result['list'][$key]['content'] = cut_str(strip_tags(element('post_content', $val)),200);
					$writer_result['list'][$key]['is_mobile'] = (element('post_device', $val) === 'mobile') ? true : false;
				}
			}
		}
	//통합검색 or Forum 검색일 경우 Forum 정보 불러오기
		if($is_all || $is_forum){
			$this->load->model('CIC_forum_info_model');
			$board_id = 3;
			
			//문제시 및
			$checktime = cdate('Y-m-d H:i:s', ctimestamp());
			$where = Array();
			$where['cic_forum_info.frm_close_datetime >='] = $checktime;
			
			
			$forum_result = $this->Post_model
				->get_search_list($per_page, $offset, $where, $like, $board_id, $findex, $sfield, $skeyword, $sop);
			
			$list_num = $forum_result['total_rows'] - ($page - 1) * $per_page;
			if (element('list', $forum_result)) {
				foreach (element('list', $forum_result) as $key => $val) {
					$imagewhere = array(
						'pst_id' => element('post_id', $val),
					);
					
					$images =  $this->CIC_forum_info_model->get_one('', '', $imagewhere, '', '', 'pfi_id', 'ASC');
					$forum_result['list'][$key]['images'] = $images;
					$forum_result['list'][$key]['thumb_url'] = thumb_url('post', element('pfi_filename', $images), 50, 40);
					$forum_result['list'][$key]['post_url'] = post_url(element('brd_key', $val), element('post_id', $val));
					$forum_result['list'][$key]['display_name'] = display_username(
						element('post_userid', $val),
						element('post_nickname', $val),
						element('mem_icon', $val),
						'Y'
					);
					
					$forum_result['list'][$key]['display_datetime'] = display_datetime(element('post_datetime', $val), 'user', 'Y-m-d H:i');
					$forum_result['list'][$key]['content'] = cut_str(strip_tags(element('post_content', $val)),200);
					$forum_result['list'][$key]['is_mobile'] = (element('post_device', $val) === 'mobile') ? true : false;
				}
			}
		}

		//통합검색 or 뉴스검색일 경우 뉴스 정보 불러오기
		$news_result = array();
		if($is_all || $is_news){
			$this->News_model->allow_search_field = array('news_title', 'news_contents', 'company.comp_name'); // 검색이 가능한 필드
			$this->News_model->allow_order = array('news_id', 'news_reviews', 'news_reviews desc, news_id asc'); // 검색중 like 가 아닌 = 검색을 하는 필드
			
		
			if($findex_get == 'view'){
				$findex = 'news_reviews desc, news_id asc';
			} else {
				$findex = 'news_id';
			}
			$sop = $this->input->get('sop', null, '');
			
			$sfield = $sfield2 = $this->input->get('sfield', null, '');
			if($sfield === 'post_title') {
				$sfield = 'news_title';
			} else if($sfield === 'post_content'){
				$sfield = 'news_contents';
			} else if($sfield === 'post_nickname'){
				$sfield = 'company.comp_name';
			} else {
				$sfield = array('news_title', 'news_contents');
			}
			$where = array();
			$news_result = $this->News_model
				->get_search_list($per_page, $offset, $where, $like, $findex, $sfield, $skeyword, $sop);
		}

		$free_row = $is_all || $is_free ? (int) $free_result['board_rows']['1'] : 0; // 자유게시판 검색 ROW 
		$writer_row = $is_all || $is_writer ? (int) $writer_result['board_rows']['2'] : 0; // WRITER 개시판 검색 Row
		$news_row = $is_all || $is_news ? (int) $news_result['total_rows'] : 0; // WRITER 개시판 검색 Row
		$forum_row = $is_all || $is_forum ? (int) $forum_result['board_rows']['3'] : 0; // WRITER 개시판 검색 Row

		$view['view']['data'] = $result;
		$view['view']['free_data'] = $free_result;
		$view['view']['writer_data'] = $writer_result;
		$view['view']['forum_data'] = $forum_result;
		$view['view']['news_data'] = $news_result;
		$view['view']['boardlist'] = $boardlist;
		$view['view']['grouplist'] = $grouplist;
		$total_rows = $free_row + $writer_row + $news_row;
		$view['total_rows'] = $total_rows;
		$view['free_row'] = $free_row;  
		$view['writer_row'] = $writer_row; 
		
		if ( ! $this->session->userdata('skeyword_' . urlencode($skeyword))) {
			$sfieldarray = array('post_title', 'post_content', 'post_both');
			if (in_array($sfield2, $sfieldarray)) {
				$searchinsert = array(
					'sek_keyword' => $skeyword,
					'sek_datetime' => cdate('Y-m-d H:i:s'),
					'sek_ip' => $this->input->ip_address(),
					'mem_id' => $mem_id,
				);
				$this->Search_keyword_model->insert($searchinsert);
				$this->session->set_userdata(
					'skeyword_' . urlencode($skeyword),
					1
				);
			}
		}

		$highlight_keyword = '';
		if ($skeyword) {
			$key_explode = explode(' ', $skeyword);
			if ($key_explode) {
				foreach ($key_explode as $seval) {
					if ($highlight_keyword) {
						$highlight_keyword .= ',';
					}
					$highlight_keyword .= '\'' . html_escape($seval) . '\'';
				}
			}
		}
		$view['view']['highlight_keyword'] = $highlight_keyword;

		if($is_all){
			//코인 값 검색 AND CALL OF MODELS
			$key_search = $this-> CIC_coin_keyword_model -> search_coin($skeyword);
			if($key_search){
				$market = element('clist_market', $key_search);
				$api_result = $this->CIC_coin_list_model -> get_price($market);
				$getHist = $this -> CIC_coin_list_model->get_histData($market);
				$korean = element('clist_name_ko', $key_search);
				$symbole = element('clist_market', $key_search);
				if($market === "PER"){
					$result_price = element('result', $api_result);

					$high = $result_price['high'];
					$low = $result_price['low'];
					$prev = $result_price['open'];;
					$trade =$result_price['last'];
					if($trade != NULL){
						$difference = $trade - $prev;
						$rate =  ($difference / $prev) * 100;
						$view['trade'] = $trade;
						$view['difference'] = $difference;
						$view['rate'] = $rate;
					}
					$view['low'] = $low;
					$view['high'] = $high;
					$view['prev'] = $prev;
						
					//HISTORICAL DATA FOR CHART
					$his_price = array();
					$his_time = array();
					for($i=0; $i<25; $i++){
						if($getHist['result'][$i][0]){
							$his_time[] = $getHist['result'][$i][0];
							$his_price[] = $getHist['result'][$i][1];
						}
					}		
					$view['his_price'] = $his_price;
					$view['his_time'] = $his_time;
				}else {
					$result_price = element(0, $api_result);
					$high = $result_price['high_price'];
					$low =$result_price['low_price'];
					$prev = $result_price['prev_closing_price'];
					$change = $result_price['change'];
					$rate =  $result_price['change_rate'];
					$difference = $result_price['change_price'];
					$trade = $result_price['trade_price'];
	
					$view['trade'] = $trade;
					$view['low'] = $low;
					$view['high'] = $high;
					$view['prev'] = $prev;
					$view['difference'] = $difference;
					$view['rate'] = $rate;
					$view['change'] = $change;
						
					//HISTORICAL DATA FOR CHART
					$his_price = array();
					$his_time = array();
					foreach($getHist as $histDota){
						if($histDota['candle_date_time_kst']){
							$his_time[] = $histDota['candle_date_time_kst'];
							$his_price[] = $histDota['trade_price'];
						}	
					}	
					$view['his_price'] = $his_price;
					$view['his_time'] = $his_time;
					
				}	
				$view['symbole'] = strtoupper($symbole);
				$view['korean'] = $korean;
			}
		}

		
	

		// END HISTORICAL DATA FOR CHART
		// 코인 검색 여기까지 
		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->Post_model->primary_key;
		/**
		 * 페이지네이션을 생성합니다
		 */
		if(!$is_all){
			$config['base_url'] = site_url('search/') . '?' . $param->replace('page');
			$view['view']['tab_url'] = site_url('search/') . '?' . $param->replace('page, board_id');
			$config['total_rows'] = $total_rows;
			$config['per_page'] = $per_page;
			$config['first_link'] = FALSE;
			$config['last_link'] = FALSE;
			$config['next_link'] = '다음';
			$config['prev_link'] = '이전';
			if ($this->cbconfig->get_device_view_type() === 'mobile') {
				$config['num_links'] = 3;
			} else {
				$config['num_links'] = 5;
			}
			$this->pagination->initialize($config);
			$view['view']['paging'] = $this->pagination->create_links();
		}
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_search');
		$meta_description = $this->cbconfig->item('site_meta_description_search');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_search');
		$meta_author = $this->cbconfig->item('site_meta_author_search');
		$page_name = $this->cbconfig->item('site_page_name_search');
		$searchconfig = array(
			'{검색어}',
		);
		$replaceconfig = array(
			$skeyword,
		);
		$page_title = str_replace($searchconfig, $replaceconfig, $page_title);
		$meta_description = str_replace($searchconfig, $replaceconfig, $meta_description);
		$meta_keywords = str_replace($searchconfig, $replaceconfig, $meta_keywords);
		$meta_author = str_replace($searchconfig, $replaceconfig, $meta_author);
		$page_name = str_replace($searchconfig, $replaceconfig, $page_name);

		$layoutconfig = array(
			'path' => 'search',
			'layout' => 'layout',
			'skin' => 'search',
			'layout_dir' => $this->cbconfig->item('layout_search'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_search'),
			'use_sidebar' => $this->cbconfig->item('sidebar_search'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_search'),
			'skin_dir' => $this->cbconfig->item('skin_search'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_search'),
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
