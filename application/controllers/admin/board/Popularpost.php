
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Post class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>게시판설정>게시물관리 controller 입니다.
 */
class Popularpost extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'board/popularpost';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Post', 'Board', 'Post_file', 'Post_meta', 'Board_category', 'Popularpost');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Post_model';

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
		$this->load->library(array('pagination', 'querystring'));
	}

	/**
	 * 목록을 가져오는 메소드입니다
	 */
public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_board_popularpost_index';
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
		$findex = 'post_like_point';
		$forder = 'asc';$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('post_id', 'post_title', 'post_content', 'mem_id', 'post_username', 'post_nickname', 'post_email', 'post_homepage', 'post_datetime', 'post_ip', 'post_device'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('post_id', 'mem_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('post_like_point'); // 정렬이 가능한 필드
		$where = array(
			'post.post_del' => 2,
		);
		if ($brdid = (int) $this->input->get('brd_id')) {
			$where['brd_id'] = $brdid;
		}
		$result = $this->{$this->modelname}
		->get_popularpost_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['post_display_name'] = display_username(
					element('post_userid', $val),
					element('post_nickname', $val)
				);
				$result['list'][$key]['board'] = $board = $this->board->item_all(element('brd_id', $val));
				$result['list'][$key]['num'] = $list_num--;
				if ($board) {
					$result['list'][$key]['boardurl'] = board_url(element('brd_key', $board));
					$result['list'][$key]['posturl'] = post_url(element('brd_key', $board), element('post_id', $val));
				}
				$result['list'][$key]['category'] = '';
				if (element('post_category', $val)) {
					$result['list'][$key]['category'] = $this->Board_category_model->get_category_info(element('brd_id', $val), element('post_category', $val));
				}
				if (element('post_image', $val)) {
					$imagewhere = array(
						'post_id' => element('post_id', $val),
						'pfi_is_image' => 1,
					);
					$file = $this->Post_file_model->get_one('', '', $imagewhere, '', '', 'pfi_id', 'ASC');
					$result['list'][$key]['thumb_url'] = thumb_url('post', element('pfi_filename', $file), 80);
				} else {
					$result['list'][$key]['thumb_url'] = get_post_image_url(element('post_content', $val), 80);
				}
			}
		}
		$view['view']['data'] = $result;

		$select = 'brd_id, brd_name';		
		$view['view']['boardlist'] = $this->Board_model->get_board_list();

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('post_title' => '제목', 'post_content' => '내용', 'post_username' => '실명', 'post_nickname' => '닉네임', 'post_email' => '이메일', 'post_homepage' => '홈페이지', 'post_datetime' => '작성일', 'post_ip' => 'IP');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['list_update_url'] = admin_url($this->pagedir . '/listupdate/?' . $param->output());

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'index');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 목록 페이지에서 선택삭제를 하는 경우 실행되는 메소드입니다
	 */
	public function listupdate()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_board_post_listupdate';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);
		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					$this->Post_model->upadte_post_exept_state($val);
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
			'정상적으로 제외되었습니다'
		);
		$param =& $this->querystring;
		$redirecturl = admin_url($this->pagedir . '?' . $param->output());
		redirect($redirecturl);
	}

	/**
	 * 목록 페이지에서 휴지통을 클릭한 경우 실행되는 메소드입니다
	 */
	public function listtr∫ash()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_board_post_listtrash';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					$updatedata = array(
						'post_del' => 2,
					);
					$this->Post_model->update($val, $updatedata);
					$metadata = array(
						'trash_mem_id' => $this->member->item('mem_id'),
						'trash_datetime' => cdate('Y-m-d H:i:s'),
						'trash_ip' => $this->input->ip_address(),
					);
					$board = $this->Post_model->get_one($val, 'brd_id');
					$this->Post_meta_model->save($val, element('brd_id', $board), $metadata);
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
			'정상적으로 휴지통으로 이동되었습니다'
		);
		$param =& $this->querystring;
		$redirecturl = admin_url($this->pagedir . '?' . $param->output());
		redirect($redirecturl);
	}

	// public function post($post_id = 0, $print = false)
	// {
	// 	// 이벤트 라이브러리를 로딩합니다
	// 	$eventname = 'event_board_post_post';
	// 	$this->load->event($eventname);

	// 	$view = array();
	// 	$view['view'] = array();

	// 	// 이벤트가 존재하면 실행합니다
	// 	$view['view']['event']['before'] = Events::trigger('before', $eventname);

	// 	/**
	// 	 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
	// 	 */
	// 	$post_id = (int) $post_id;
	// 	if (empty($post_id) OR $post_id < 1) {
	// 		show_404();
	// 	}

	// 	$post = $this->Post_model->get_one($post_id);
	// 	$post['meta'] = $this->Post_meta_model->get_all_meta($post_id);
	// 	$post['extravars'] = $this->Post_extra_vars_model->get_all_meta($post_id);
	// 	$view['view']['post'] = $post;

	// 	$mem_id = (int) $this->member->item('mem_id');

	// 	if ( ! element('post_id', $post)) {
	// 		show_404();
	// 	}
	// 	if (element('post_del', $post) > 1) {
	// 		show_404();
	// 	}

	// 	$board = $this->board->item_all(element('brd_id', $post));

	// 	if ( ! element('brd_id', $board)) {
	// 		show_404();
	// 	}

	// 	$skeyword = $this->input->get('skeyword', null, '');

	// 	if ($print === false && $this->uri->segment('1') !== config_item('uri_segment_admin')) {
	// 		if (strtoupper(config_item('uri_segment_post_type')) === 'B') {
	// 			if ($this->uri->segment('1') !== element('brd_key', $board)) {
	// 				show_404();
	// 			}
	// 		} elseif (strtoupper(config_item('uri_segment_post_type')) === 'C') {
	// 			if ($this->uri->segment('2') !== element('brd_key', $board)) {
	// 				show_404();
	// 			}
	// 		}
	// 	}

	// 	$alertmessage = $this->member->is_member()
	// 		? '회원님은 내용을 볼 수 있는 권한이 없습니다'
	// 		: '비회원은 내용을 볼 수 있는 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오';

	// 	$check = array(
	// 		'group_id' => element('bgr_id', $board),
	// 		'board_id' => element('brd_id', $board),
	// 	);
	// 	$this->accesslevel->check(
	// 		element('access_view', $board),
	// 		element('access_view_level', $board),
	// 		element('access_view_group', $board),
	// 		$alertmessage,
	// 		$check
	// 	);

	// 	$view['view']['is_admin'] = $is_admin = $this->member->is_admin(
	// 		array(
	// 			'board_id' => element('brd_id', $board),
	// 			'group_id' => element('bgr_id', $board)
	// 		)
	// 	);
	// 	$view['view']['board_key'] = element('brd_key', $board);

	// 	if (element('use_personal', $board) && $this->member->is_member() === false) {
	// 		alert('이 게시판은 1:1 게시판입니다. 비회원은 접근할 수 없습니다');
	// 		return false;
	// 	}


	// 	if ($print && ! element('use_print', $board)) {
	// 		alert('이 게시판은 프린트 기능을 지원하지 않습니다');
	// 		return false;
	// 	}

	// 	if (element('post_secret', $post)) {
	// 		if (element('mem_id', $post)) {
	// 			if ($is_admin === false && $mem_id !== abs(element('mem_id', $post))) {
	// 				alert('비밀글은 본인과 관리자만 확인 가능합니다');
	// 				return false;
	// 			}
	// 		} else {
	// 			if ($is_admin !== false) {
	// 				$this->session->set_userdata(
	// 					'view_secret_' . element('post_id', $post),
	// 					'1'
	// 				);
	// 			}
	// 			if ( ! $this->session->userdata('view_secret_' . element('post_id', $post))
	// 				&& $this->input->post('modify_password')) {
	// 				if ( ! function_exists('password_hash')) {
	// 					$this->load->helper('password');
	// 				}

	// 				if ( password_verify($this->input->post('modify_password'), element('post_password', $post))) {
	// 					$this->session->set_userdata(
	// 						'view_secret_' . element('post_id', $post),
	// 						'1'
	// 					);
	// 					redirect(current_url());
	// 				} else {
	// 					$view['view']['message'] = '패스워드가 잘못 입력되었습니다';
	// 				}
	// 			}
	// 			if ( ! $this->session->userdata('view_secret_' . element('post_id', $post))) {

	// 				// 이벤트가 존재하면 실행합니다
	// 				$view['view']['event']['before_secret_layout']
	// 					= Events::trigger('before_secret_layout', $eventname);

	// 				/**
	// 				 * 레이아웃을 정의합니다
	// 				 */
	// 				$view['view']['info'] = '비밀글 열람을 위한 패스워드 입력페이지입니다.<br />패스워드를 입력하시면 비밀글 열람이 가능합니다';
	// 				$page_title = element('board_name', $board) . ' 글열람';
	// 				$layout_dir = element('board_layout', $board) ? element('board_layout', $board) : $this->cbconfig->item('layout_board');
	// 				$mobile_layout_dir = element('board_mobile_layout', $board) ? element('board_mobile_layout', $board) : $this->cbconfig->item('mobile_layout_board');
	// 				$use_sidebar = element('board_sidebar', $board) ? element('board_sidebar', $board) : $this->cbconfig->item('sidebar_board');
	// 				$use_mobile_sidebar = element('board_mobile_sidebar', $board) ? element('board_mobile_sidebar', $board) : $this->cbconfig->item('mobile_sidebar_board');
	// 				$skin_dir = element('board_skin', $board) ? element('board_skin', $board) : $this->cbconfig->item('skin_board');
	// 				$mobile_skin_dir = element('board_mobile_skin', $board) ? element('board_mobile_skin', $board) : $this->cbconfig->item('mobile_skin_board');
	// 				$layoutconfig = array(
	// 					'path' => 'board',
	// 					'layout' => 'layout',
	// 					'skin' => 'password',
	// 					'layout_dir' => $layout_dir,
	// 					'mobile_layout_dir' => $mobile_layout_dir,
	// 					'use_sidebar' => $use_sidebar,
	// 					'use_mobile_sidebar' => $use_mobile_sidebar,
	// 					'skin_dir' => $skin_dir,
	// 					'mobile_skin_dir' => $mobile_skin_dir,
	// 					'page_title' => $page_title,
	// 				);
	// 				$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
	// 				$this->data = $view;
	// 				$this->layout = element('layout_skin_file', element('layout', $view));
	// 				$this->view = element('view_skin_file', element('layout', $view));
	// 				return true;
	// 			}
	// 		}
	// 	}

	// 	if ($mem_id > 0 && $mem_id !== abs(element('mem_id', $post))
	// 		&& element('use_point', $board)) {
	// 		$point = $this->point->insert_point(
	// 			$mem_id,
	// 			element('point_read', $board),
	// 			element('board_name', $board) . ' ' . $post_id . ' 게시글열람',
	// 			'post_read',
	// 			$post_id,
	// 			'게시글열람'
	// 		);

	// 		if (element('point_read', $board) < 0 && $point < 0
	// 			&& $this->cbconfig->item('block_read_zeropoint')) {
	// 			$this->point->delete_point(
	// 				$mem_id,
	// 				'post_read',
	// 				$post_id,
	// 				'게시글열람'
	// 			);
	// 			alert('회원님은 포인트가 부족하므로 글을 열람하실 수 없습니다. 글 읽기시 ' . (element('point_read', $board) * -1) . ' 포인트가 차감됩니다');
	// 			return false;
	// 		}
	// 	}
	// 	if (element('use_personal', $board) && $is_admin === false
	// 		&& $mem_id !== abs(element('mem_id', $post))) {
	// 		alert('1:1 게시판은 본인의 글 이외의 열람이 금지되어있습니다.');
	// 		return false;
	// 	}

	// 	// 이벤트가 존재하면 실행합니다
	// 	$view['view']['event']['step1'] = Events::trigger('step1', $eventname);

	// 	$this->_stat_count_board(element('brd_id', $board)); // stat_count_board ++

	// 	// 세션 생성
	// 	if ( ! $this->session->userdata('post_id_' . $post_id)) {
	// 		$this->Post_model->update_plus($post_id, 'post_hit', 1);
	// 		$this->session->set_userdata(
	// 			'post_id_' . $post_id,
	// 			'1'
	// 		);
	// 	}

	// 	$use_sideview = ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('use_mobile_sideview', $board)
	// 		: element('use_sideview', $board);
	// 	$use_sideview_icon = ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('use_mobile_sideview_icon', $board)
	// 		: element('use_sideview_icon', $board);
	// 	$view_date_style = ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('mobile_view_date_style', $board)
	// 		: element('view_date_style', $board);
	// 	$view_date_style_manual = ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('mobile_view_date_style_manual', $board)
	// 		: element('view_date_style_manual', $board);

	// 	if (element('mem_id', $post) >= 0) {
	// 		$dbmember = $this->Member_model
	// 			->get_by_memid(element('mem_id', $post), 'mem_icon');
	// 		$view['view']['post']['display_name'] = display_username(
	// 			element('post_userid', $post),
	// 			element('post_nickname', $post),
	// 			($use_sideview_icon ? element('mem_icon', $dbmember) : ''),
	// 			($use_sideview ? 'Y' : 'N')
	// 		);
	// 	} else {
	// 		$view['view']['post']['display_name'] = '익명사용자';
	// 	}
	// 	$view['view']['post']['display_datetime'] = display_datetime(
	// 		element('post_datetime', $post),
	// 		$view_date_style,
	// 		$view_date_style_manual
	// 	);
	// 	$view['view']['post']['is_mobile'] = (element('post_device', $post) === 'mobile') ? true : false;
	// 	$view['view']['post']['category'] = '';
	// 	if (element('use_category', $board) && element('post_category', $post)) {
	// 		$this->load->model('Board_category_model');
	// 		$view['view']['post']['category'] = $this->Board_category_model
	// 			->get_category_info(element('brd_id', $post), element('post_category', $post));
	// 	}

	// 	$view['view']['post']['display_ip'] = '';

	// 	$show_ip = ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('show_mobile_ip', $board)
	// 		: element('show_ip', $board);

	// 	if ($this->member->is_admin() === 'super' OR $show_ip === '2') {
	// 		$view['view']['post']['display_ip'] = display_ipaddress(element('post_ip', $post), '1111');
	// 	} elseif ($show_ip === '1') {
	// 		$view['view']['post']['display_ip'] = display_ipaddress(element('post_ip', $post), $this->cbconfig->item('ip_display_style'));
	// 	}
	// 	$image_width = ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('post_mobile_image_width', $board)
	// 		: element('post_image_width', $board);

	// 	$board['target_blank'] = $target_blank
	// 		= ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('mobile_content_target_blank', $board)
	// 		: element('content_target_blank', $board);

	// 	$board['show_url_qrcode'] = ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('use_mobile_url_qrcode', $board)
	// 		: element('use_url_qrcode', $board);

	// 	$board['show_attached_url_qrcode'] = ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('use_mobile_attached_url_qrcode', $board)
	// 		: element('use_attached_url_qrcode', $board);

	// 	$link_player = '';
	// 	$view['view']['link'] = $link = array();

	// 	if (element('post_link_count', $post)) {
	// 		$this->load->model('Post_link_model');
	// 		$linkwhere = array(
	// 			'post_id' => $post_id,
	// 		);
	// 		$view['view']['link'] = $link = $this->Post_link_model
	// 			->get('', '', $linkwhere, '', '', 'pln_id', 'ASC');
	// 		if ($link && is_array($link)) {
	// 			foreach ($link as $key => $value) {
	// 				$view['view']['link'][$key]['link_link'] = site_url('postact/link/' . element('pln_id', $value));
	// 				if (element('use_autoplay', $board)) {
	// 					$link_player .= $this->videoplayer->
	// 						get_video(prep_url(element('pln_url', $value)));
	// 				}
	// 			}
	// 		}
	// 	}
	// 	$view['view']['link_count'] = $link_count = count($link);

	// 	$file_player = '';
	// 	if (element('post_file', $post) OR element('post_image', $post)) {
	// 		$this->load->model('Post_file_model');
	// 		$filewhere = array(
	// 			'post_id' => $post_id,
	// 		);
	// 		$view['view']['file'] = $file = $this->Post_file_model
	// 			->get('', '', $filewhere, '', '', 'pfi_id', 'ASC');
	// 		$view['view']['file_download'] = array();
	// 		$view['view']['file_image'] = array();

	// 		$play_extension = array('acc', 'flv', 'f4a', 'f4v', 'mov', 'mp3', 'mp4', 'm4a', 'm4v', 'oga', 'ogg', 'rss', 'webm');

	// 		if ($file && is_array($file)) {
	// 			foreach ($file as $key => $value) {
	// 				if (element('pfi_is_image', $value)) {
	// 					$value['origin_image_url'] = site_url(config_item('uploads_dir') . '/post/' . element('pfi_filename', $value));
	// 					$value['thumb_image_url'] = thumb_url('post', element('pfi_filename', $value), $image_width);
	// 					$view['view']['file_image'][] = $value;
	// 				} else {
	// 					$value['download_link'] = site_url('postact/download/' . element('pfi_id', $value));
	// 					$view['view']['file_download'][] = $value;
	// 					if (element('use_autoplay', $board) && in_array(element('pfi_type', $value), $play_extension)) {
	// 						$file_player .= $this->videoplayer->get_jwplayer(site_url(config_item('uploads_dir') . '/post/' . element('pfi_filename', $value)), $image_width);
	// 					}
	// 				}
	// 			}
	// 		}
	// 		$view['view']['file_count'] = count($file);
	// 		$view['view']['file_download_count'] = count($view['view']['file_download']);
	// 		$view['view']['file_image_count'] = count($view['view']['file_image']);
	// 	}

	// 	$autourl = ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('use_mobile_auto_url', $board)
	// 		: element('use_auto_url', $board);

	// 	$autolink = $autourl ? true : false;
	// 	$popup = $target_blank ? true : false;

	// 	$view['view']['post']['content'] = '';

	// 	if (element('post_del', $post)) {

	// 		$view['view']['post']['post_title'] = '게시물이 삭제되었습니다';
	// 		$view['view']['post']['content'] = '<div class="alert alert-danger">이 게시물은 '
	// 			. html_escape(element('delete_mem_nickname', element('meta', $post)))
	// 			. '님에 의해 '
	// 			. html_escape(element('delete_datetime', element('meta', $post)))
	// 			. ' 에 삭제 되었습니다</div>';

	// 	} else {
	// 		$is_blind = (element('blame_blind_count', $board) > 0 && element('post_blame', $post) >= element('blame_blind_count', $board)) ? true : false;
	// 		if ($is_blind === true) {
	// 			$view['view']['post']['content'] .= '<div class="alert alert-danger">신고가 접수된 게시글입니다. 본인과 관리자만 확인이 가능합니다</div>';
	// 		}

	// 		if ($is_blind === false OR $is_admin !== false
	// 			OR (element('mem_id', $post) && abs(element('mem_id', $post)) === $mem_id)) {
	// 			$view['view']['post']['content'] .= $file_player . $link_player
	// 				. display_html_content(
	// 					element('post_content', $post),
	// 					element('post_html', $post),
	// 					$image_width,
	// 					$autolink,
	// 					$popup
	// 				);

	// 			if (element('syntax_highlighter', $board)) {
	// 				if (element('post_html', $post)) {
	// 					$view['view']['post']['content'] = preg_replace_callback(
	// 						"/(\[code\]|\[code=(.*)\])(.*)\[\/code\]/iUs",
	// 						"content_syntaxhighlighter_html",
	// 						$view['view']['post']['content']
	// 					); // SyntaxHighlighter
	// 				} else {
	// 					$view['view']['post']['content'] = preg_replace_callback(
	// 						"/(\[code\]|\[code=(.*)\])(.*)\[\/code\]/iUs",
	// 						"content_syntaxhighlighter",
	// 						$view['view']['post']['content']
	// 					); // SyntaxHighlighter
	// 				}
	// 			}
	// 		}

	// 		$view['view']['tag'] = '';
	// 		if (element('use_post_tag', $board)) {
	// 			$this->load->model('Post_tag_model');
	// 			$tagwhere = array(
	// 				'post_id' => $post_id,
	// 			);
	// 			$view['view']['post']['tag'] = $tag = $this->Post_tag_model
	// 				->get('', '', $tagwhere, '', '', 'pta_id', 'ASC');
	// 		}

	// 		$extravars = element('extravars', $board);
	// 		$form = json_decode($extravars, true);
	// 		$extra_content = '';
	// 		$k = 0;
	// 		if ($form && is_array($form)) {
	// 			foreach ($form as $key => $value) {
	// 				if ( ! element('use', $value)) {
	// 					continue;
	// 				}

	// 				$item = element(element('field_name', $value), element('extravars', $post));
	// 				$extra_content[$k]['field_name'] = element('field_name', $value);
	// 				$extra_content[$k]['display_name'] = element('display_name', $value);
	// 				if (element('field_type', $value) === 'checkbox') {
	// 					$tmp_value = json_decode($item);
	// 					$tmp = '';
	// 					if ($tmp_value) {
	// 						foreach ($tmp_value as $val) {
	// 							if ($tmp) {
	// 								$tmp .= ', ';
	// 							}
	// 							$tmp .= $val;
	// 						}
	// 					}
	// 					$item = $tmp;
	// 				}
	// 				$extra_content[$k]['output'] = $item;
	// 				$k++;
	// 			}
	// 		}

	// 		$view['view']['extra_content'] = $extra_content;
	// 	}
	// 	$show_list_from_view = ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('mobile_show_list_from_view', $board)
	// 		: element('show_list_from_view', $board);

	// 	$board['headercontent'] = ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('mobile_header_content', $board)
	// 		: element('header_content', $board);

	// 	if (empty($show_list_from_view)) {
	// 		$board['footercontent'] = ($this->cbconfig->get_device_view_type() === 'mobile')
	// 			? element('mobile_footer_content', $board)
	// 			: element('footer_content', $board);
	// 	}

	// 	$skindir = ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? (element('board_mobile_skin', $board)
	// 			? element('board_mobile_skin', $board)
	// 			: element('board_skin', $board))
	// 		: element('board_skin', $board);
	// 	$skinurl = base_url( VIEW_DIR . 'board/' . $skindir);

	// 	$view['view']['post_url'] = $post_url = post_url(element('brd_key', $board), $post_id);

	// 	$param =& $this->querystring;

	// 	$view['view']['board'] = $board;
	// 	$this->load->model('Scrap_model');
	// 	$countwhere = array(
	// 		'post_id' => element('post_id', $post),
	// 	);
	// 	$view['view']['post']['scrap_count'] = $this->Scrap_model->count_by($countwhere);

	// 	$view['view']['comment']['is_cmt_name'] = $is_cmt_name
	// 		= ($this->member->is_member() === false) ? true : false;

	// 	$view['view']['comment']['use_emoticon']
	// 		= ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('use_mobile_comment_emoticon', $board)
	// 		: element('use_comment_emoticon', $board);

	// 	$view['view']['comment']['use_specialchars']
	// 		= ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('use_mobile_comment_specialchars', $board)
	// 		: element('use_comment_specialchars', $board);

	// 	$view['view']['comment']['show_textarea']
	// 		= ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('mobile_always_show_comment_textarea', $board)
	// 		: element('always_show_comment_textarea', $board);

	// 	$check = array(
	// 		'group_id' => element('bgr_id', $board),
	// 		'board_id' => element('brd_id', $board)
	// 	);
	// 	$can_write = $this->accesslevel->is_accessable(
	// 		element('access_write', $board),
	// 		element('access_write_level', $board),
	// 		element('access_write_group', $board),
	// 		$check
	// 	);
	// 	$can_comment_write = $this->accesslevel->is_accessable(
	// 		element('access_comment', $board),
	// 		element('access_comment_level', $board),
	// 		element('access_comment_group', $board),
	// 		$check
	// 	);

	// 	$can_comment_write_message = '';
	// 	if ($can_comment_write === false) {
	// 		$can_comment_write_message = '비회원은 댓글쓰기 권한이 없습니다. 회원이시라면 로그인후 이용해보십시오';
	// 	}
	// 	$can_reply = $this->accesslevel->is_accessable(
	// 		element('access_reply', $board),
	// 		element('access_reply_level', $board),
	// 		element('access_reply_group', $board),
	// 		$check
	// 	);

	// 	$can_modify = ($is_admin !== false OR ! element('mem_id', $post)
	// 		OR (element('mem_id', $post) && $mem_id === abs(element('mem_id', $post)))) ? true : false;
	// 	$can_delete = ($is_admin !== false OR ! element('mem_id', $post)
	// 		OR (element('mem_id', $post) && $mem_id === abs(element('mem_id', $post)))) ? true : false;

	// 	$view['view']['write_url'] = '';
	// 	if ($can_write === true) {
	// 		$view['view']['write_url'] = write_url(element('brd_key', $board));
	// 	} elseif ($this->cbconfig->get_device_view_type() !== 'mobile'
	// 		&& element('always_show_write_button', $board)) {
	// 		$view['view']['write_url'] = 'javascript:alert(\'비회원은 글쓰기 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.\');';
	// 	} elseif ($this->cbconfig->get_device_view_type() === 'mobile'
	// 		&& element('mobile_always_show_write_button', $board)) {
	// 		$view['view']['write_url'] = 'javascript:alert(\'비회원은 글쓰기 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.\');';
	// 	}

	// 	$view['view']['reply_url'] = ($can_reply === true && ! element('post_del', $post))
	// 		? reply_url(element('post_id', $post)) : '';
	// 	$view['view']['modify_url'] = ($can_modify && ! element('post_del', $post))
	// 		? modify_url(element('post_id', $post) . '?' . $param->output()) : '';
	// 	$view['view']['delete_url'] = ($can_delete && ! element('post_del', $post))
	// 		? site_url('postact/delete/' . element('post_id', $post) . '?' . $param->output()) : '';

	// 	if ($skeyword) {
	// 		$view['view']['list_url'] = board_url(element('brd_key', $board));
	// 		$view['view']['search_list_url'] = board_url(element('brd_key', $board) . '?' . $param->output());
	// 	} else {
	// 		$view['view']['list_url'] = board_url(element('brd_key', $board) . '?' . $param->output());
	// 		$view['view']['search_list_url'] = '';
	// 	}
	// 	$view['view']['trash_url'] = site_url('boards/trash/' . element('post_id', $post) . '?' . $param->output());

	// 	if (element('notice_comment_block', $board) && element('post_notice', $post)) {
	// 		$can_comment_write = false;
	// 		$can_comment_write_message = '공지사항 글에는 댓글 입력이 제한되어 있습니다.';
	// 	}
	// 	if (element('post_del', $post)) {
	// 		$can_comment_write = false;
	// 		$can_comment_write_message = '삭제된 글에는 댓글 입력이 제한되어 있습니다.';
	// 	}

	// 	$use_sns_button = false;
	// 	if ($this->cbconfig->get_device_view_type() !== 'mobile' && element('use_sns', $board)) {
	// 		$use_sns_button = true;
	// 	}
	// 	if ($this->cbconfig->get_device_view_type() === 'mobile'
	// 		&& element('use_mobile_sns', $board)) {
	// 		$use_sns_button = true;
	// 	}
	// 	$view['view']['use_sns_button'] = $use_sns_button;

	// 	$highlight_keyword = '';
	// 	if ($skeyword) {
	// 		$key_explode = explode(' ', $skeyword);
	// 		if ($key_explode) {
	// 			foreach ($key_explode as $seval) {
	// 				if ($highlight_keyword) {
	// 					$highlight_keyword .= ',';
	// 				}
	// 				$highlight_keyword .= '\'' . html_escape($seval) . '\'';
	// 			}
	// 		}
	// 	}
	// 	$view['view']['highlight_keyword'] = $highlight_keyword;

	// 	// 이벤트가 존재하면 실행합니다
	// 	$view['view']['event']['step2'] = Events::trigger('step2', $eventname);


	// 	$view['view']['next_post'] = '';
	// 	$view['view']['prev_post'] = '';
	// 	$use_prev_next = false;
	// 	if ($this->cbconfig->get_device_view_type() !== 'mobile'
	// 		&& element('use_prev_next_post', $board)) {
	// 		$use_prev_next = true;
	// 	}
	// 	if ($this->cbconfig->get_device_view_type() === 'mobile'
	// 		&& element('use_mobile_prev_next_post', $board)) {
	// 		$use_prev_next = true;
	// 	}
	// 	if ($use_prev_next) {
	// 		$where = array();
	// 		$where['brd_id'] = element('brd_id', $post);
	// 		$where['post_del <>'] =2;
	// 		$where['post_secret'] = 0;
	// 		if (element('except_notice', $board)
	// 			&& $this->cbconfig->get_device_view_type() !== 'mobile') {
	// 			$where['post_notice'] = 0;
	// 		}
	// 		if (element('mobile_except_notice', $board)
	// 			&& $this->cbconfig->get_device_view_type() === 'mobile') {
	// 			$where['post_notice'] = 0;
	// 		}
	// 		if (element('use_personal', $board) && $is_admin === false) {
	// 			$where['post.mem_id'] = $mem_id;
	// 		}
	// 		$sfield = $sfieldchk = $this->input->get('sfield', null, '');
	// 		if ($sfield === 'post_both') {
	// 			$sfield = array('post_title', 'post_content');
	// 		}
	// 		$skeyword = $this->input->get('skeyword', null, '');
	// 		$view['view']['next_post'] = $next_post
	// 			= $this->Post_model
	// 			->get_prev_next_post(
	// 				element('post_id', $post),
	// 				element('post_num', $post),
	// 				'next',
	// 				$where,
	// 				$sfield,
	// 				$skeyword
	// 			);

	// 		if (element('post_id', $next_post)) {
	// 			$view['view']['next_post']['url'] = post_url(element('brd_key', $board), element('post_id', $next_post)) . '?' . $param->output();
	// 		}

	// 		$view['view']['prev_post'] = $prev_post
	// 			= $this->Post_model
	// 			->get_prev_next_post(
	// 				element('post_id', $post),
	// 				element('post_num', $post),
	// 				'prev',
	// 				$where,
	// 				$sfield,
	// 				$skeyword
	// 			);
	// 		if (element('post_id', $prev_post)) {
	// 			$view['view']['prev_post']['url'] = post_url(element('brd_key', $board), element('post_id', $prev_post)) . '?' . $param->output();
	// 		}
	// 	}

	// 	$view['view']['comment']['can_comment_write'] = $can_comment_write;
	// 	$view['view']['comment']['can_comment_write_message']
	// 		= $can_comment_write_message;
	// 	$view['view']['comment']['can_comment_view'] = true;

	// 	$view['view']['comment']['is_comment_name']
	// 		= ($this->member->is_member() === false) ? true : false;
	// 	$view['view']['comment']['can_comment_secret']
	// 		= (element('use_comment_secret', $board) === '1' && $this->member->is_member())
	// 		? true : false;
	// 	$view['view']['comment']['cmt_secret']
	// 		= element('use_comment_secret_selected', $board) ? '1' : '';

	// 	$password_length = $this->cbconfig->item('password_length');
	// 	$view['view']['comment']['password_length'] = $password_length;
	// 	$view['view']['comment']['cmt_content']
	// 		= ($this->cbconfig->get_device_view_type() === 'mobile')
	// 		? element('mobile_comment_default_content', $board)
	// 		: element('comment_default_content', $board);

	// 	if ($show_list_from_view) {
	// 		$view['view']['list'] = $list = $this->_get_list(element('brd_key', $board), 1);
	// 	}


	// 	// 이벤트가 존재하면 실행합니다
	// 	$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

	// 	/**
	// 	 * 레이아웃을 정의합니다
	// 	 */
	// 	$page_title = $this->cbconfig->item('site_meta_title_board_post');
	// 	$meta_description = $this->cbconfig->item('site_meta_description_board_post');
	// 	$meta_keywords = $this->cbconfig->item('site_meta_keywords_board_post');
	// 	$meta_author = $this->cbconfig->item('site_meta_author_board_post');
	// 	$page_name = $this->cbconfig->item('site_page_name_board_post');

	// 	$searchconfig = array(
	// 		'{게시판명}',
	// 		'{게시판아이디}',
	// 		'{글제목}',
	// 		'{작성자명}',
	// 	);
	// 	$replaceconfig = array(
	// 		element('board_name', $board),
	// 		element('brd_key', $board),
	// 		element('post_title', $post),
	// 		element('post_nickname', $post),
	// 	);

	// 	$page_title = str_replace($searchconfig, $replaceconfig, $page_title);
	// 	$meta_description = str_replace($searchconfig, $replaceconfig, $meta_description);
	// 	$meta_keywords = str_replace($searchconfig, $replaceconfig, $meta_keywords);
	// 	$meta_author = str_replace($searchconfig, $replaceconfig, $meta_author);
	// 	$page_name = str_replace($searchconfig, $replaceconfig, $page_name);

	// 	if ($print === false) {

	// 		// 이벤트가 존재하면 실행합니다
	// 		$view['view']['event']['before_post_layout'] = Events::trigger('before_post_layout', $eventname);

	// 		$view['view']['short_url'] = $view['view']['canonical'] = post_url(element('brd_key', $board), $post_id);

	// 		if(element('use_bitly', $board)) {
	// 			if(element('bitly_url', element('meta', $post))) {
	// 				$view['view']['short_url'] = element('bitly_url', element('meta', $post));
	// 			} elseif($this->cbconfig->item('bitly_access_token')) {
	// 				$this->load->helper('bitly_helper');
	// 				$bitlyparams = array();
	// 				$bitlyparams['access_token'] = $this->cbconfig->item('bitly_access_token');
	// 				$bitlyparams['longUrl'] = post_url(element('brd_key', $board), $post_id);
	// 				$bitlyparams['domain'] = 'bit.ly';
	// 				$bitlyresult = bitly_get('shorten', $bitlyparams);
	// 				if(element('status_code', $bitlyresult) === 200) {
	// 					$bitlydata = array('bitly_url' => element('url', element('data', $bitlyresult)));
	// 					$this->Post_meta_model->save($post_id, element('brd_id', $board), $bitlydata);
	// 					$view['view']['short_url'] = element('url', element('data', $bitlyresult));
	// 				}
	// 			}
	// 		}

	// 		$layout_dir = element('board_layout', $board) ? element('board_layout', $board) : $this->cbconfig->item('layout_board');
	// 		$mobile_layout_dir = element('board_mobile_layout', $board) ? element('board_mobile_layout', $board) : $this->cbconfig->item('mobile_layout_board');
	// 		$use_sidebar = element('board_sidebar', $board) ? element('board_sidebar', $board) : $this->cbconfig->item('sidebar_board');
	// 		$use_mobile_sidebar = element('board_mobile_sidebar', $board) ? element('board_mobile_sidebar', $board) : $this->cbconfig->item('mobile_sidebar_board');
	// 		$skin_dir = element('board_skin', $board) ? element('board_skin', $board) : $this->cbconfig->item('skin_board');
	// 		$mobile_skin_dir = element('board_mobile_skin', $board) ? element('board_mobile_skin', $board) : $this->cbconfig->item('mobile_skin_board');
	// 		$layoutconfig = array(
	// 			'path' => 'board',
	// 			'layout' => 'layout',
	// 			'skin' => 'post',
	// 			'layout_dir' => $layout_dir,
	// 			'mobile_layout_dir' => $mobile_layout_dir,
	// 			'use_sidebar' => $use_sidebar,
	// 			'use_mobile_sidebar' => $use_mobile_sidebar,
	// 			'skin_dir' => $skin_dir,
	// 			'mobile_skin_dir' => $mobile_skin_dir,
	// 			'page_title' => $page_title,
	// 			'meta_description' => $meta_description,
	// 			'meta_keywords' => $meta_keywords,
	// 			'meta_author' => $meta_author,
	// 			'page_name' => $page_name,
	// 		);
	// 		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
	// 		$this->data = $view;
	// 		$this->layout = element('layout_skin_file', element('layout', $view));
	// 		if ($show_list_from_view) {
	// 			$list_skin_file = element('use_gallery_list', $board) ? 'gallerylist' : 'list';
	// 			$listskindir = ($this->cbconfig->get_device_view_type() === 'mobile')
	// 				? $mobile_skin_dir : $skin_dir;
	// 			if (empty($listskindir)) {
	// 				$listskindir
	// 					= ($this->cbconfig->get_device_view_type() === 'mobile')
	// 					? $this->cbconfig->item('mobile_skin_default')
	// 					: $this->cbconfig->item('skin_default');
	// 			}
	// 			$this->view = array(
	// 				element('view_skin_file', element('layout', $view)),
	// 				'board/' . $listskindir . '/' . $list_skin_file,
	// 			);
	// 		} else {
	// 			$this->view = element('view_skin_file', element('layout', $view));
	// 		}
	// 	} else {

	// 		// 이벤트가 존재하면 실행합니다
	// 		$view['view']['event']['before_print_layout'] = Events::trigger('before_print_layout', $eventname);

	// 		$layoutconfig = array(
	// 			'path' => 'helptool',
	// 			'layout' => 'layout_popup',
	// 			'skin' => 'print',
	// 			'layout_dir' => $this->cbconfig->item('layout_helptool'),
	// 			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_helptool'),
	// 			'skin_dir' => $this->cbconfig->item('skin_helptool'),
	// 			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_helptool'),
	// 			'page_title' => $page_title,
	// 		);
	// 		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
	// 		$this->data = $view;
	// 		$this->layout = element('layout_skin_file', element('layout', $view));
	// 		$this->view = element('view_skin_file', element('layout', $view));

	// 	}
	// }
}
