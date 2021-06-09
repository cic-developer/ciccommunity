<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Mypage class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 마이페이지와 관련된 controller 입니다.
 */
class Mypage extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('CIC_withdraw', 'CIC_withdraw_log', 'Member', 'Post', 'Comment', 'Point', 'CIC_cp', 'CIC_vp', 'CIC_wconfig');

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
		$this->load->library(array('pagination', 'querystring','member'));

	}


	/**
	 * 마이페이지입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_index';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$registerform = $this->cbconfig->item('registerform');
		$view['view']['memberform'] = json_decode($registerform, true);

		$view['view']['member_group_name'] = '';
		$member_group = $this->member->group();
		if ($member_group && is_array($member_group)) {

			$this->load->model('Member_group_model');

			foreach ($member_group as $gkey => $gval) {
				$item = $this->Member_group_model->item(element('mgr_id', $gval));
				if ($view['view']['member_group_name']) {
					$view['view']['member_group_name'] .= ', ';
				}
				$view['view']['member_group_name'] .= element('mgr_title', $item);
			}
		}
		$member_info = $this->member->get_member();
		$view['member'] = $member_info;
	

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage');
		$page_name = $this->cbconfig->item('site_page_name_mypage');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'main',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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
	 * 마이페이지>나의작성글 입니다
	 */
	public function post()
	{
        
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_post';
		$this->load->event($eventname);
        
		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();
        
		$mem_id = (int) $this->member->item('mem_id');
        
		$view = array();
		$view['view'] = array();
        
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
        
		$this->load->model(array('Post_model', 'Post_file_model'));
        
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$order_by_field = element('order_by_field', $board)
			? element('order_by_field', $board)
			: 'post_num, post_reply';
		$findex = $this->input->get('findex', null, $order_by_field);
		// $forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');
        
		$per_page = 10;
		// $per_page = $this->cbconfig->item('list_count') ? $this->cbconfig->item('list_count') : 10;
		$offset = ($page - 1) * $per_page;
        
		$this->Post_model->allow_search_field = array('post_id', 'post_title', 'post_content', 'post_category', 'post_userid', 'post_nickname'); // 검색이 가능한 필드
		$this->Post_model->search_field_equal = array('post_id', 'post_userid', 'post_nickname'); // 검색중 like 가 아닌 = 검색을 하는 필드
        
		
		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'post.mem_id' => $mem_id,
			'post_del' => 0,
		);
        
		$result = $this->Post_model
			->get_post_list($per_page, $offset, $where, '', $findex, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
        
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$brd_key = $this->board->item_id('brd_key', element('brd_id', $val));
				$result['list'][$key]['post_url'] = post_url($brd_key, element('post_id', $val));
				$result['list'][$key]['num'] = $list_num--;
				if (element('post_image', $val)) {
					$filewhere = array(
						'post_id' => element('post_id', $val),
						'pfi_is_image' => 1,
					);
					$file = $this->Post_file_model
						->get_one('', '', $filewhere, '', '', 'pfi_id', 'ASC');
					$result['list'][$key]['thumb_url'] = thumb_url('post', element('pfi_filename', $file), 50, 40);
				} else {
					$result['list'][$key]['thumb_url'] = get_post_image_url(element('post_content', $val), 50, 40);
				}
			}
		}
        
		$view['view']['data'] = $result;
        
		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/post') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$config['first_link'] = '처음';
		$config['last_link'] = '마지막';
		$config['next_link'] = '다음';
		$config['prev_link'] = '이전';
		if ($this->cbconfig->get_device_view_type() === 'mobile') {
			$config['num_links'] = element('mobile_page_count', $board)
				? element('mobile_page_count', $board) : 2;
		} else {
			$config['num_links'] = element('page_count', $board)
				? element('page_count', $board) : 4;
		}
		$this->pagination->initialize($config);
		
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;
        
        
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
        
		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		// 'post_id' => '번호', 'post_nickname' => '닉네임', 'post_category' => '카테고리', 'post_userid' => '아이디', 제외
		$search_option = array('post_title' => '제목', 'post_content' => '내용');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['list_delete_url'] = site_url('mypage/postListdelete');
        
		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_post');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_post');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_post');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_post');
		$page_name = $this->cbconfig->item('site_page_name_mypage_post');
        
		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'post',
			'layout_dir' => 'cic_sub',//$this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => 'cic_sub',//$this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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
	 * 마이페이지>나의작성글(댓글) 입니다
	 */
	public function comment()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_comment';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
        
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$this->load->model(array('Post_model', 'Comment_model'));
        
		
		$findex = $this->input->get('findex', null, $order_by_field);
		// $findex = $this->Comment_model->primary_key;
		
		// $forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = 10;
		// $per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;
        
		$this->Comment_model->allow_search_field = array('cmt_content'); // 검색이 가능한 필드
		$this->Comment_model->search_field_equal = array(''); // 검색중 like 가 아닌 = 검색을 하는 필드
        
		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'comment.mem_id' => $mem_id,
			// 'comment.cmt_del' => 0, => (현재는 row에서 삭제)
		);
		$result = $this->Comment_model
			->get_comment_list($per_page, $offset, $where, '', $findex, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$post = $this->Post_model
					->get_one(element('post_id', $val), 'brd_id');
				$brd_key = $this->board->item_id('brd_key', element('brd_id', $post));
				$result['list'][$key]['comment_url'] = post_url($brd_key, element('post_id', $val)) . '#comment_' . element('cmt_id', $val);
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;
        
		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/comment') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$config['first_link'] = '처음';
		$config['last_link'] = '마지막';
		$config['next_link'] = '다음';
		$config['prev_link'] = '이전';
		if ($this->cbconfig->get_device_view_type() === 'mobile') {
			$config['num_links'] = element('mobile_page_count', $board)
				? element('mobile_page_count', $board) : 2;
		} else {
			$config['num_links'] = element('page_count', $board)
				? element('page_count', $board) : 4;
		}
		$this->pagination->initialize($config);
        
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;
        
        
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
        
        
		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		// 'post_id' => '번호', 'post_nickname' => '닉네임', 'post_category' => '카테고리', 'post_userid' => '아이디', 제외
		$search_option = array('cmt_content' => '내용');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['list_delete_url'] = site_url('mypage/commentListdelete');
        
		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_comment');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_comment');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_comment');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_comment');
		$page_name = $this->cbconfig->item('site_page_name_mypage_comment');
        
		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'comment',
			'layout_dir' => 'cic_sub',//$this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => 'cic_sub',//$this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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
	 * 마이페이지>나의작성글(vp) 입니다
	 */
	public function vp()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_vp';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
        
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
        
		$order_by_field = element('order_by_field', $board)
			? element('order_by_field', $board)
			: 'vp_id';
		$findex = $this->input->get('findex', null, $order_by_field);
		// $findex = $this->Comment_model->primary_key;
		
		$forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = 10;
		// $per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;
        
		$this->CIC_vp_model->allow_search_field = array('vp_content', 'vp_point', 'vp_action'); // 검색이 가능한 필드
		$this->CIC_vp_model->search_field_equal = array(''); // 검색중 like 가 아닌 = 검색을 하는 필드
        
		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'cic_vp.mem_id' => $mem_id,
		);
		$result = $this->CIC_vp_model->get_admin_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);

		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$post = $this->Post_model
					->get_one(element('post_id', $val), 'brd_id');
				$brd_key = $this->board->item_id('brd_key', element('brd_id', $post));
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;
        
		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/vp') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$config['first_link'] = '처음';
		$config['last_link'] = '마지막';
		$config['next_link'] = '다음';
		$config['prev_link'] = '이전';
		if ($this->cbconfig->get_device_view_type() === 'mobile') {
			$config['num_links'] = element('mobile_page_count', $board)
				? element('mobile_page_count', $board) : 2;
		} else {
			$config['num_links'] = element('page_count', $board)
				? element('page_count', $board) : 4;
		}
		$this->pagination->initialize($config);
        
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;
        
        
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
        
        
		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		// 'post_id' => '번호', 'post_nickname' => '닉네임', 'post_category' => '카테고리', 'post_userid' => '아이디', 제외
		$search_option = array('vp_content' => '내용');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
        
		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_vp');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_vp');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_vp');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_vp');
		$page_name = $this->cbconfig->item('site_page_name_mypage_vp');
        
		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'vp',
			'layout_dir' => 'cic_sub',//$this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => 'cic_sub',//$this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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

	public function cp()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_cp';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
        
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
        
		$order_by_field = element('order_by_field', $board)
			? element('order_by_field', $board)
			: 'cp_id';
		$findex = $this->input->get('findex', null, $order_by_field);
		// $findex = $this->Comment_model->primary_key;
		
		$forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = 10;
		// $per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;
        
		$this->CIC_cp_model->allow_search_field = array('cp_content', 'cp_point', 'cp_action'); // 검색이 가능한 필드
		$this->CIC_cp_model->search_field_equal = array(''); // 검색중 like 가 아닌 = 검색을 하는 필드
        
		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'cic_cp.mem_id' => $mem_id,
		);
		$result = $this->CIC_cp_model->get_admin_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);

		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$post = $this->Post_model
					->get_one(element('post_id', $val), 'brd_id');
				$brd_key = $this->board->item_id('brd_key', element('brd_id', $post));
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;
        
		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/cp') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$config['first_link'] = '처음';
		$config['last_link'] = '마지막';
		$config['next_link'] = '다음';
		$config['prev_link'] = '이전';
		if ($this->cbconfig->get_device_view_type() === 'mobile') {
			$config['num_links'] = element('mobile_page_count', $board)
				? element('mobile_page_count', $board) : 2;
		} else {
			$config['num_links'] = element('page_count', $board)
				? element('page_count', $board) : 4;
		}
		$this->pagination->initialize($config);
        
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;
        
        
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
        
        
		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('cp_content' => '내용');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
        
		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_cp');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_cp');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_cp');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_cp');
		$page_name = $this->cbconfig->item('site_page_name_mypage_cp');
        
		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'cp',
			'layout_dir' => 'cic_sub',//$this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => 'cic_sub',//$this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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
	 * 마이페이지>포인트 입니다
	 */
	public function point()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_point';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		if ( ! $this->cbconfig->item('use_point')) {
			alert('이 웹사이트는 포인트 기능을 제공하지 않습니다');
		}

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->model('Point_model');
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->Point_model->primary_key;
		$forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;
        
		$this->Point_model->allow_search_field = array('poi_content', 'poi_point', 'poi_action'); // 검색이 가능한 필드
		$this->Point_model->search_field_equal = array(''); // 검색중 like 가 아닌 = 검색을 하는 필드

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'point.mem_id' => $mem_id,
		);
		$result = $this->Point_model
			->get_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		$result['plus'] = 0;
		$result['minus'] = 0;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['num'] = $list_num--;
				if (element('poi_point', $val) > 0) {
					$result['plus'] += element('poi_point', $val);
				} else {
					$result['minus'] += element('poi_point', $val);
				}
			}
		}
		$view['view']['data'] = $result;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/point') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
        
        
		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('poi_content' => '내용');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_point');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_point');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_point');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_point');
		$page_name = $this->cbconfig->item('site_page_name_mypage_point');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'point',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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
	 * 마이페이지>팔로우 입니다
	 */
	public function followinglist()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_followinglist';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->model('Follow_model');

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->Follow_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'follow.mem_id' => $mem_id,
		);
		$result = $this->Follow_model
			->get_following_list($per_page, $offset, $where, '', $findex, $forder);
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

		$view['view']['following_total_rows'] = $result['total_rows'];
		$countwhere = array(
			'target_mem_id' => $mem_id,
		);
		$view['view']['followed_total_rows'] = $this->Follow_model->count_by($countwhere);

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/followinglist') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_followinglist');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_followinglist');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_followinglist');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_followinglist');
		$page_name = $this->cbconfig->item('site_page_name_mypage_followinglist');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'followinglist',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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
	 * 마이페이지>팔로우(Followed) 입니다
	 */
	public function followedlist()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_followedlist';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->model('Follow_model');
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->Follow_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'follow.target_mem_id' => $mem_id,
		);
		$result = $this->Follow_model
			->get_followed_list($per_page, $offset, $where, '', $findex, $forder);
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

		$view['view']['followed_total_rows'] = $result['total_rows'];
		$countwhere = array(
			'mem_id' => $mem_id,
		);
		$view['view']['following_total_rows'] = $this->Follow_model->count_by($countwhere);

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/followedlist') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_followedlist');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_followedlist');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_followedlist');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_followedlist');
		$page_name = $this->cbconfig->item('site_page_name_mypage_followedlist');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'followedlist',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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
	 * 마이페이지>추천 입니다
	 */
	public function like_post()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_like_post';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->model(array('Like_model', 'Post_file_model'));
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->Like_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'like.mem_id' => $mem_id,
			'lik_type' => 1,
			'target_type' => 1,
			'post.post_del' => 0,
		);
		$result = $this->Like_model
			->get_post_like_list($per_page, $offset, $where, '', $findex, $forder);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$brd_key = $this->board->item_id('brd_key', element('brd_id', $val));
				$result['list'][$key]['post_url'] = post_url($brd_key, element('post_id', $val));
				$result['list'][$key]['num'] = $list_num--;
				$images = '';
				if (element('post_image', $val)) {
					$filewhere = array(
						'post_id' => element('post_id', $val),
						'pfi_is_image' => 1,
					);
					$images = $this->Post_file_model
						->get_one('', '', $filewhere, '', '', 'pfi_id', 'ASC');
				}
				$result['list'][$key]['images'] = $images;
			}
		}
		$view['view']['data'] = $result;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/like_post') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_like_post');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_like_post');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_like_post');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_like_post');
		$page_name = $this->cbconfig->item('site_page_name_mypage_like_post');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'like_post',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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
	 * 마이페이지>추천(댓글) 입니다
	 */
	public function like_comment()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_like_comment';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->model(array('Like_model', 'Post_model'));
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->Like_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'like.mem_id' => $mem_id,
			'lik_type' => 1,
			'target_type' => 2,
		);
		$result = $this->Like_model
			->get_comment_like_list($per_page, $offset, $where, '', $findex, $forder);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$post = $this->Post_model->get_one(element('post_id', $val), 'brd_id');
				$brd_key = $this->board->item_id('brd_key', element('brd_id', $post));
				$result['list'][$key]['comment_url'] = post_url($brd_key, element('post_id', $val)) . '#comment_' . element('cmt_id', $val);
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/like_comment') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_like_comment');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_like_comment');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_like_comment');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_like_comment');
		$page_name = $this->cbconfig->item('site_page_name_mypage_like_comment');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'like_comment',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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
	 * 마이페이지>스크랩 입니다
	 */
	public function scrap()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_scrap';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->model('Scrap_model');
		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');
		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'scr_id',
				'label' => 'SCRAP ID',
				'rules' => 'trim|required|numeric',
			),
			array(
				'field' => 'scr_title',
				'label' => '제목',
				'rules' => 'trim',
			),
		);
		$this->form_validation->set_rules($config);


		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		$alert_message = '';
		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			$scr_title = $this->input->post('scr_title', null, '');
			$updatedata = array(
				'scr_title' => $scr_title,
			);
			$this->Scrap_model->update($this->input->post('scr_id'), $updatedata);
			$alert_message = '제목이 저장되었습니다';
		}

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->Scrap_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'scrap.mem_id' => $mem_id,
			'post.post_del' => 0,
		);
		$result = $this->Scrap_model
			->get_list($per_page, $offset, $where, '', $findex, $forder);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['board'] = $board = $this->board->item_all(element('brd_id', $val));

				$result['list'][$key]['post_url'] = post_url(element('brd_key', $board), element('post_id', $val));
				$result['list'][$key]['board_url'] = board_url(element('brd_key', $board));
				$result['list'][$key]['delete_url'] = site_url('mypage/scrap_delete/' . element('scr_id', $val) . '?' . $param->output());
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;
		$view['view']['alert_message'] = $alert_message;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/scrap') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_scrap');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_scrap');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_scrap');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_scrap');
		$page_name = $this->cbconfig->item('site_page_name_mypage_scrap');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'scrap',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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
	 * 마이페이지>스크랩삭제 입니다
	 */
	public function scrap_delete($scr_id = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_scrap_delete';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		$scr_id = (int) $scr_id;
		if (empty($scr_id) OR $scr_id < 1) {
			show_404();
		}

		$this->load->model('Scrap_model');
		$scrap = $this->Scrap_model->get_one($scr_id);

		if ( ! element('scr_id', $scrap)) {
			show_404();
		}
		if ((int) element('mem_id', $scrap) !== $mem_id) {
			show_404();
		}

		$this->Scrap_model->delete($scr_id);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('after', $eventname);

		/**
		 * 삭제가 끝난 후 목록페이지로 이동합니다
		 */
		$this->session->set_flashdata(
			'message',
			'정상적으로 삭제되었습니다'
		);
		$param =& $this->querystring;

		redirect('mypage/scrap?' . $param->output());
	}


	/**
	 * 마이페이지>로그인기록 입니다
	 */
	public function loginlog()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_loginlog';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;

		$this->load->model('Member_login_log_model');

		$findex = $this->Member_login_log_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'mem_id' => $mem_id,
		);
		$result = $this->Member_login_log_model
			->get_list($per_page, $offset, $where, '', $findex, $forder);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				if (element('mll_useragent', $val)) {
					$userAgent = get_useragent_info(element('mll_useragent', $val));
					$result['list'][$key]['browsername'] = $userAgent['browsername'];
					$result['list'][$key]['browserversion'] = $userAgent['browserversion'];
					$result['list'][$key]['os'] = $userAgent['os'];
					$result['list'][$key]['engine'] = $userAgent['engine'];
				}
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/loginlog') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_loginlog');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
		$page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'loginlog',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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

	// 출금 페이지
	function withdraw(){
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_withdraw';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$view = array();
		$view['view'] = array();
		
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$withdraw_deposit = $this->CIC_wconfig_model->item('withdraw_deposit'); // 신청 수수료
		$withdraw_minimum = $this->CIC_wconfig_model->item('withdraw_minimum'); // 최소 신청금액
		$view['view']['withdraw_deposit'] = $withdraw_deposit;
		$view['view']['withdraw_minimum'] = $withdraw_minimum;

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex', null, 'wid_idx');
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = 10;
		$offset = ($page - 1) * $per_page;

		// 회원 정보를 가져옵니다
		$member_info = $this->member->get_member();
		if(!$member_info){
			show_404();
		}
		$view['view']['mem_cp'] = $member_info['mem_cp'];
		$where['wid_mem_idx'] = $member_info['mem_id'];
		// $view['view']['mem_id'] = $member_info['mem_id'];

		// 출금 요청 url
		$view['view']['req_url'] = site_url('mypage/withdraw_request');

		$result = $this->CIC_withdraw_model->get_withdraw_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);

		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {

				$where = array(
					'wid_idx' => element('wid_idx', $val),
				);
				
				$result['list'][$key]['num'] = $list_num--;
			}
		}

		$view['view']['data'] = $result;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/withdraw') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$config['next_link'] = '다음';
		$config['prev_link'] = '이전';
		if ($this->cbconfig->get_device_view_type() === 'mobile') {
			$config['num_links'] = element('mobile_page_count', $board)
				? element('mobile_page_count', $board) : 3;
		} else {
			$config['num_links'] = element('page_count', $board)
				? element('page_count', $board) : 5;
		}
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'withdraw',
			'layout_dir' => 'cic_sub',
			'mobile_layout_dir' => 'cic_sub',
			'skin_dir' => 'cic',
			'mobile_skin_dir' => 'cic',
			'page_title' => '출금신청',
			
		);	

		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	// 출금요청
	function withdraw_request(){
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_withdraw_request';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		// 데이터 빡스~
		$view = array();
		$view['view'] = array();

		// 회원 데이터 가져오기
		$member_info = $this->member->get_member();
		$view['member'] = $member_info;
		
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
        
		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');
		
		$config = array(
			array(
				'field' => 'money',
				'label' => '금액',
				'rules' => 'trim|required|greater_than_equal_to[0]|less_than_equal_to['.$member_info['mem_cp'].']|callback__withdraw_minimum_check',
			),
		);
		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();

		// 출금신청
		if ($form_validation) {

			// 회원정보 가져오기
			$_money = $this->input->post('money');
			$mem_id = $member_info['mem_id'];
			$mem_userid = $member_info['mem_userid'];
			$mem_userip = $this->input->ip_address();
			$mem_nickname = $member_info['mem_nickname'];
			$mem_cp = $member_info['mem_cp'];
			$mem_wallet_address = $member_info['mem_wallet_address'];

			if(!$mem_wallet_address){
				$this->session->set_flashdata(
					'message',
					'지갑주소를 설정해주세요'
				);
				// 이벤트가 존재하면 실행합니다
				Events::trigger('after', $eventname);
				redirect('mypage/withdraw');
			}

			/**
			 * 포인트 차감
			 * member
			 */
			
			$result = $this->Member_model->set_user_point($mem_id, $_money, $mem_cp);
			
			if($result != 1){
				$this->session->set_flashdata(
					'message',
					'출금 신청에 실패하였습니다 (관리자 문의)'
				);
			} else{
				/**
				 * 출금 신청
				 * cic_withdraw
				 */
                $withdraw_deposit = $this->CIC_wconfig_model->item('withdraw_deposit');  // 신청 수수료

				$money = $_money - ($_money * ($withdraw_deposit/100));

				$result = $this->CIC_withdraw_model->set_withdraw($mem_id, $mem_userid, $mem_userip, $mem_nickname, $mem_wallet_address, $_money, $money, $withdraw_deposit);
                
				if($result == 0 ){
					/**
					 * 출금 신청 실패로 인한, 차감포인트 리셋
					 * member
					 */
					// 차감 후의 포인트 가져오기
					$new_mem_cp = $this->Member_model->get_by_memid($mem_id, 'mem_cp');
					$result = $this->Member_model->set_user_point($mem_id, -$_money, $new_mem_cp['mem_cp']);
                    
					if($result != 1){
						$this->session->set_flashdata(
							'message',
							'포인트 차감후 신청 및 포인트 리셋에 실패하였습니다 (관리자문의)'
						);
					} 
                    
					$this->session->set_flashdata(
						'message',
						'출금 신청에 실패하였습니다 (관리자 문의)'
					);
				} else{
					$logResult = $this->CIC_cp_model->set_cic_cp($mem_id, '-', -$_money, '@byself', $mem_id, '출금신청');

					$this->session->set_flashdata(
						'message',
						'정상적으로 신청되었습니다'
					);
				}
				
				// else{
					/**
					 * 신청 로그를 남깁니다.
					 * cic_withdraw_log
					 */
					// $result = $this->CIC_withdraw_log_model->set_withdraw_log('유저 출금신청', $mem_wallet_address, '', '', $mem_userid, $mem_userip, $money, '');

					// if($result == 0){
					// 	$this->session->set_flashdata(
					// 		'message',
					// 		'정상 처리후 로그오류입니다 (관리자 문의)'
					// 	);
					// } else{
					// 	$this->session->set_flashdata(
					// 		'message',
					// 		'정상적으로 신청되었습니다'
					// 	);
					// }
				// }
			}

		} else {
			$withdraw_minimum = $this->CIC_wconfig_model->item('withdraw_minimum'); 

			$this->session->set_flashdata(
				'message',
				'금액을 옳바르게 입력해주세요 (최소금액: '.$withdraw_minimum.')'
			);
		}

		// 이벤트가 존재하면 실행합니다
		Events::trigger('after', $eventname);

		/**
		 * 삭제가 끝난 후 목록페이지로 이동합니다
		 */
		// $param =& $this->querystring;

		redirect('mypage/withdraw');
	}

	function _withdraw_minimum_check($_str){

		$str = explode( '.', $_str );
		if( strlen($str[1]) > 2){
			$this->form_validation->set_message(
				'_withdraw_minimum_check',
				'출금요청 금액은 소수점 2자리 까지 설정이 가능합니다'
			);
			return false;
		}

		// 최소 신청 금액
		$withdraw_minimum = $this->CIC_wconfig_model->item('withdraw_minimum'); 
        
		if($_str < $withdraw_minimum){
			$this->form_validation->set_message(
				'_withdraw_minimum_check',
				'최소 신청금액을 맞춰주세요 ('.$withdraw_minimum.')'
			);
			return false;
		}

		return true;
	}

	public function charge(){
		
		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();
        
		$this->load->library('coinapi');
		$per_gdac_price = element('price', $this->coinapi->get_coin_data('gdac', 'PER', 'KRW'));
		$per2cp = (floor($per_gdac_price / 10) * 10) / 100;
		$view['per2cp'] = $per2cp;
		$this->session->set_userdata('per2cp', $per2cp);

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'charge',
			'layout_dir' => 'cic_sub',
			'mobile_layout_dir' => 'cic_sub',
			'skin_dir' => 'cic',
			'mobile_skin_dir' => 'cic',
			'page_title' => '충전하기',
		);

		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	public function charge_ajax(){
		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library(array('form_validation', 'point'));
		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'transaction_hash',
				'label' => '트랜젝션 해시',
				'rules' => 'trim|required|callback__check_valid_transaction_hash',
			),
			array(
				'field' => 'charge_input',
				'label' => '충전액',
				'rules' => 'trim|required|is_natural_no_zero',
			),
		);
		$this->form_validation->set_rules($config);


		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false) {
			$return = array(
				'result' => false,
				'code' 	 => '0000',
				'data'	 => "Invalid Request"
			);
			echo json_encode($return);
			exit;
		}

		/*
		 * 정상적으로 시도 한 경우
		 */
		$transaction_hash = $this->input->post('transaction_hash');
		$charge_input = $this->input->post('charge_input');
		$memid = $this->member->is_member();
		$this->load->model('Charge_point_model');
		// 트랜젝션 해시를 통해 해당 row 가져오기
		$thisData = $this->Charge_point_model->get_one('','',array('cp_transaction' => $transaction_hash));
		if(!$thisData){
			$return = array(
				'result' => false,
				'code' 	 => '0001',
				'data'	 => "No Transaction Found"
			);
			echo json_encode($return);
			exit;
		}
		// 해당 PER 과 같은지 확인
		$recorded_value = element('cp_value', $thisData);
		if($recorded_value != $charge_input){
			$update_data = array(
				'cp_mem_id' => $memid,
				'cp_mdate'  => date('Y-m-d H:i:s'),
				'cp_state'  => 0,
				'cp_reason' => '입력한 PER토큰양과 실제 전송된 토큰양이 일치하지 않음',
				'cp_ip'		=> $this->input->ip_address(),
			);
			$this->Charge_point_model->update(element('cp_id', $thisData), $update_data);
			$return = array(
				'result' => false,
				'code' 	 => '0002',
				'data'	 => "Invalid Request"
			);
			echo json_encode($return);
			exit;
		}
		// 세션에 있는 CP 가져오고 세션 지우기
		$per2cp = $this->session->userdata('per2cp');
		if($per2cp){
			$update_data = array(
				'cp_mem_id' => $memid,
				'cp_mdate'  => date('Y-m-d H:i:s'),
				'cp_state'  => 0,
				'cp_reason' => '세션이 입력되지 않고 입금요청을 진행할 수 없음. 확인요함',
				'cp_ip'		=> $this->input->ip_address(),
			);
			$this->Charge_point_model->update(element('cp_id', $thisData), $update_data);
			$return = array(
				'result' => false,
				'code' 	 => '0003',
				'data'	 => "Invalid Request"
			);
			echo json_encode($return);
			exit;
		}

		// PER * PER2CP 계산해서 기록남기기
		$total_charge_cp = $charge_input * $per2cp;
		$update_data = array(
			'cp_mem_id' => $memid,
			'cp_mdate'  => date('Y-m-d H:i:s'),
			'cp_charge_point'  => $total_charge_cp,
			'cp_state'  => 2,
			'cp_ip'		=> $this->input->ip_address(),
		);
		$this->Charge_point_model->update(element('cp_id', $thisData), $update_data);
		
		//  CP 추가해주기
		$this->point->insert_cp(
			$memid,
			$total_charge_cp,
			'PER 토큰을 통한 충전',
			'charge_point',
			element('cp_id', $thisData),
			'충전'
		);

		// CP 충전까지 완료
		$update_data = array(
			'cp_state'  => 3,
		);
		$this->Charge_point_model->update(element('cp_id', $thisData), $update_data);

		$return = array(
			'result' => true,
			'code' 	 => '1000',
			'data'	 => "Success"
		);
		echo json_encode($return);
		exit;
	}

	/**
	 * 게시물 목록 페이지에서 선택삭제를 하는 경우 실행되는 메소드입니다
	 */
	public function postListdelete()
	{
        
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_post_listdelete';
		$this->load->event($eventname);
        
		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);
        
		required_user_login();
        
		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		$deletePostArr = array();
		if ($this->input->post('vsel') && is_array($this->input->post('vsel'))) {
			foreach ($this->input->post('vsel') as $val) {
				$post_info = $this->Post_model->get_one($val);
				$post_mem_id = $post_info['mem_id'];
				$mem_id = (int) $this->member->item('mem_id');
				// $member_info = $this->member->get_member();
				// $mem_id = $member_info['mem_id'];
				
				if ($val && $post_mem_id == $mem_id) {
					$this->board->delete_post($val);
				} else {
					array_push($deletePostArr, $val);
				}
			}
		}else {
			// 이벤트가 존재하면 실행합니다
			Events::trigger('after', $eventname);
			
			$this->session->set_flashdata(
				'message',
				'게시물 삭제에 실패하였습니다'
			);
			redirect('mypage/post');
		}
		
		// 삭제에 실패한 게시물 배열
		if($deletePostArr){
			// 이벤트가 존재하면 실행합니다
			Events::trigger('after', $eventname);
            
			// print_r($deletePostArr); => 확인용
			$this->session->set_flashdata(
				'message',
				'일부 게시물 삭제에 실패하였습니다'
			);
			redirect('mypage/post');
		}else {
			// 이벤트가 존재하면 실행합니다
			Events::trigger('after', $eventname);
            
			/**
			 * 삭제가 끝난 후 목록페이지로 이동합니다
			 */
			$this->session->set_flashdata(
				'message',
				'정상적으로 삭제되었습니다'
			);
			redirect('mypage/post');
		}
	}

	/**
	 * 댓글 목록 페이지에서 선택삭제를 하는 경우 실행되는 메소드입니다
	 */
	public function commentListdelete()
	{
        
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_comment_listdelete';
		$this->load->event($eventname);
        
		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);
        
		required_user_login();
        
		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		$deleteCommentArr = array();
		if ($this->input->post('vsel') && is_array($this->input->post('vsel'))) {
			foreach ($this->input->post('vsel') as $val) {
				$comment_info = $this->Comment_model->get_one($val);
				$comment_mem_id = $comment_info['mem_id'];
				$mem_id = (int) $this->member->item('mem_id');
				// $member_info = $this->member->get_member();
				// $mem_id = $member_info['mem_id'];
				
				if ($val && $comment_mem_id == $mem_id) {
					$this->board->delete_comment($val);
				} else {
					array_push($deleteCommentArr, $val);
				}
				
			}
		}else {
			// 이벤트가 존재하면 실행합니다
			Events::trigger('after', $eventname);
			
			$this->session->set_flashdata(
				'message',
				'댓글 삭제에 실패하였습니다'
			);
			redirect('mypage/comment');
		}
		
		// 삭제에 실패한 게시물 배열
		if($deleteCommentArr){
			// 이벤트가 존재하면 실행합니다
			Events::trigger('after', $eventname);
            
			// print_r($deletePostArr); => 확인용
			$this->session->set_flashdata(
				'message',
				'일부 댓글 삭제에 실패하였습니다'
			);
			redirect('mypage/comment');
		}else {
			// 이벤트가 존재하면 실행합니다
			Events::trigger('after', $eventname);
            
			/**
			 * 삭제가 끝난 후 목록페이지로 이동합니다
			 */
			$this->session->set_flashdata(
				'message',
				'정상적으로 삭제되었습니다'
			);
			redirect('mypage/comment');
		}
	}

	public function _check_valid_transaction_hash($transaction_hash){
		$url = 'https://caver.ciccommunity.com/proof/ciccommunity_charge_cp';    

		$post_field_string = http_build_query(array('hash' => $transaction_hash));
		$ch = curl_init();                                                            // curl 초기화
		curl_setopt($ch, CURLOPT_URL, $url);                                 // url 지정하기
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);              // 요청결과를 문자열로 반환
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);               // connection timeout : 10초
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                 // 원격 서버의 인증서가 유효한지 검사 여부
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field_string);      // POST DATA
		curl_setopt($ch, CURLOPT_POST, true);                               // POST 전송 여부
		$response = curl_exec($ch);
		curl_close ($ch);

		$json = json_decode($response, true);
		if(element('result', $json)){
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
