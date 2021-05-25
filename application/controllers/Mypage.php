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
	protected $models = array('CIC_withdraw', 'CIC_withdraw_log', 'Member');

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
		$findex = $this->Post_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'post.mem_id' => $mem_id,
			'post_del' => 0,
		);
		$result = $this->Post_model
			->get_post_list($per_page, $offset, $where, '', $findex, $forder);
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
		$this->pagination->initialize($config);
		$view['view']['list_delete_url'] = site_url('mypage/listdelete');
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

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

		$findex = $this->Comment_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'comment.mem_id' => $mem_id,
		);
		$result = $this->Comment_model
			->get_comment_list($per_page, $offset, $where, '', $findex, $forder);
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
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

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

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'point.mem_id' => $mem_id,
		);
		$result = $this->Point_model
			->get_list($per_page, $offset, $where, '', $findex, $forder);
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
				'rules' => 'trim|required|greater_than_equal_to[0]|less_than_equal_to['.$member_info['mem_cp'].']',
			),
		);
		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();

		// 출금신청
		if ($form_validation) {

			// 회원정보 가져오기
			$money = $this->input->post('money');
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

			$result = $this->Member_model->set_user_point($mem_id, $money, $mem_cp);

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

				$result = $this->CIC_withdraw_model->set_withdraw($mem_id, $mem_userid, $mem_userip, $mem_nickname, $mem_wallet_address, $money);

				if($result == 0 ){
					/**
					 * 출금 신청 실패로 인한, 차감포인트 리셋
					 * member
					 */
					// 차감 후의 포인트 가져오기
					$new_mem_cp = $this->Member_model->get_by_memid($mem_id, 'mem_cp');
					$result = $this->Member_model->set_user_point($mem_id, -$money, $new_mem_cp['mem_cp']);

					if($result != 1){
						$this->session->set_flashdata(
							'message',
							'포인트 차감후 신청 및 포인트 리셋에 실패하였습니다 (관리자문의)'
						);
					} 

					$this->session->set_flashdata(
						'message',
						'포인트 차감후 신청에 실패하였습니다 (관리자 문의)'
					);
				} else{
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
			$this->session->set_flashdata(
				'message',
				'금액을 옳바르게 입력해주세요'
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

	function charge(){
		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();
        
        // if(!$mem_id || is_numeric($mem_id)){
        //     alert('유저 정보가 없습니다.\n로그인후 다시 시도해주세요' , '/');
        // }
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

	/**
	 * 목록 페이지에서 선택삭제를 하는 경우 실행되는 메소드입니다
	 */
	public function listdelete()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_post_listdelete';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					$this->board->delete_post($val);
				}
			}
		}

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
		$redirecturl = admin_url($this->pagedir . '?' . $param->output());
		redirect($redirecturl);
	}
}
