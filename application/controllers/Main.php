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
	protected $helpers = array('form', 'array');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('querystring'));
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
}
