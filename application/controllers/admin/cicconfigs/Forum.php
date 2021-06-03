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
 * 관리자 메인 controller 입니다.
 */
class Forum extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cicconfigs/forum';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('CIC_forum','Board', 'Post', 'Board_category', 'Post_file', 'CIC_forum_config');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'CIC_forum_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'chkstring',  'dhtml_editor', 'rs');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring', 'member'));
	}

	/**
	 * 관리자 출급요청목록 메인 페이지입니다.
	 */
	public function index()
	{

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_forum_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		$config = array(
			array(
				'field' => 'forum_deposit',
				'label' => '포럼 예치금',
				'rules' => 'trim|required|greater_than_equal_to[0]|callback__deposit_decimal_check',
			),
			// array(
			// 	'field' => 'forum_writer_commission',
			// 	'label' => '포럼 작성자 지급 포인트 수수료',
			// 	'rules' => 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]|callback__writer_commission_decimal_check',
			// ),
			array(
				'field' => 'forum_bat_change_commission',
				'label' => '포럼 배팅 진영 변경 수수료',
				'rules' => 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]|callback__bat_change_commission_decimal_check',
			),
		);
		$this->form_validation->set_rules($config);

		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			$array = array(
				'forum_deposit',
				// 'forum_writer_commission',
				'forum_bat_change_commission'
			);
			foreach ($array as $value) {
				$savedata[$value] = $this->input->post($value, null, '');
			}

			$this->CIC_forum_config_model->save($savedata);
			$view['view']['alert_message'] = '기본정보 설정이 저장되었습니다';
		}

		$getdata = $this->CIC_forum_config_model->get_all_meta();
		$view['view']['data'] = $getdata;
		
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
	 * 예치금 설정, 소수점 두자리 이내 확인
	 */
	public function _deposit_decimal_check($_str)
	{
        
		$str = explode( '.', $_str );
		if( strlen($str[1]) < 3){
			return true;
		}
        
		$this->form_validation->set_message(
			'_deposit_decimal_check',
			'포럼 예치금은 소수점 2자리 까지 설정이 가능합니다'
		);
		return false;
	}
	
	/**
	 * 포럼 작성자 지급 포인트 수수료 설정, 소수점 두자리 이내 확인
	 */
	public function _writer_commission_decimal_check($_str)
	{
        
		$str = explode( '.', $_str );
		if( strlen($str[1]) < 3){
			return true;
		}
        
		$this->form_validation->set_message(
			'_writer_commission_decimal_check',
			'포럼 작성자 지급 포인트 수수료는 소수점 2자리 까지 설정이 가능합니다'
		);
		return false;
	}
	
	/**
	 * 포럼 배팅 진영 변경 수수료 설정, 소수점 두자리 이내 확인
	 */
	public function _bat_change_commission_decimal_check($_str)
	{
		
		$str = explode( '.', $_str );
		if( strlen($str[1]) < 3){
			return true;
		}
        
		$this->form_validation->set_message(
			'_bat_change_commission_decimal_check',
			'포럼 배팅 진영 변경 수수료는 소수점 2자리 까지 설정이 가능합니다'
		);
		return false;
	}

	public function disapproval_forum()
	{
		$eventname = 'event_admin_cicconfigs_disapproval_forum_list';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();
		
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = 'post_id';
		$forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');
		
		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;
		
		$this->Post_model->allow_search_field = array('post_id', 'post_title', 'post_content', 'post.brd_id',); // 검색이 가능한 필드
		$this->Post_model->search_field_equal = array('post_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->Post_model->allow_order_field = array('post_id');
		
		
		

		$where = array(
			'brd_id' => 6,
			'post_del <>' => 2,
			'post_category' => 1,
		);
		if ($brdid = (int) $this->input->get('brd_id')) {
			$where['brd_id'] = $brdid;
		}

		
		$result = $this->Post_model->
			get_post_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		
		
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['post_display_name'] = display_username(
					element('post_userid', $val),
					element('post_nickname', $val)
				);
				$result['list'][$key]['board'] = $board = $this->board->item_all(element('brd_id', $val));
				$result['list'][$key]['num'] = $list_num++;
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

		$view['view']['primary_key'] = $this->Post_model->primary_key;

		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		$search_option = array('post_title' => '제목', 'post_content' => '내용');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['upadte_forum_return_url'] = admin_url($this->pagedir . '/upadte_forum_return/?' . $param->output());

		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		$layoutconfig = array('layout' => 'layout', 'skin' => 'disapproval_forum');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));

		
	}

	// public function update_forum_approval($post_id = 0)
	// {
	// 	$eventname = 'event_admin_ciccinfigs_update_forum_approval';
	// 	$this->load->event($eventname);

	// 	$view = array();
	// 	$view['view'] = array();

	// 	// 이벤트가 존재하면 실행합니다
	// 	$view['view']['event']['before'] = Events::trigger('before', $eventname);

	// 	if ($post_id) {
	// 		$post_id = (int) $post_id;
	// 		if (empty($post_id) OR $post_id < 1) {
	// 			show_404();
	// 		}
	// 	}
	// 	$primary_key = $this->Post_model->primary_key;
	// }

	// public function update_disapproval_return()
	// {
	// 	$eventname = 'event_admin_update_disapproval_return';
	// 	$this->load->event($eventname);
	// 	Events::trigger('before', $eventname);
	// 	if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
	// 		foreach ($this->input->post('chk') as $val) {
	// 			if ($val) {
	// 				$this->Post_model->upadte_forum_return($val);
	// 			}
	// 		}
	// 	}
	// 	Events::trigger('after', $eventname);
	// 	$this->session->set_flashdata(
	// 		'message',
	// 		'선택하신 포럼이 반려되었습니다.'
	// 	);
	// 	$param =& $this->querystring;
	// 	$redirecturl = admin_url($this->pagedir . '?' . $param->output());
	// 	redirect($redirecturl);
	// }

	public function upadte_forum_return()
	{
		
		$eventname = 'event_admin_update_disapproval_return';
		$this->load->event($eventname);
		Events::trigger('before', $eventname);
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					$this->Post_model->upadte_forum_return($val);
				}
			}
		}
		Events::trigger('after', $eventname);
		$this->session->set_flashdata(
			'message',
			'베스트 게시물에서 제외되었습니다'
		);
		$param =& $this->querystring;
		$redirecturl = admin_url($this->pagedir . '?' . $param->output());
		redirect($redirecturl);
	}

	public function proceeding_forum()
	{
		$eventname = 'event_admin_cicconfigs_proceeding_forum_list';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();
		
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$view['view']['sort'] = array(
			'post_id' => $param->sort('post_id', 'asc'),
			'post_hit' => $param->sort('post_hit', 'asc'),
			'post_datetime' => $param->sort('post_datetime', 'asc'),
			'cic_forum_info.frm_bat_close_datetime' => $param->sort('cic_forum_info.frm_bat_close_datetime', 'asc'),
			'cic_forum_info.frm_close_datetime' => $param->sort('cic_forum_info.frm_close_datetime', 'asc'),
			'cic_forum_info.frm_total_money' => $param->sort('cic_forum_info.frm_total_money', 'asc'),
		);
		$findex = $this->input->get('findex', null, 'post_id');
		$forder = $this->input->get('forder', null, 'desc');
		$findex = $findex.' '.$forder;
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');
		
		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;
		
		$this->{$this->modelname}->allow_search_field = array('post_id', 'post_title', 'post_content'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('post_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('post_id', 'post_hit', 'post_datetime', 'cic_forum_info.frm_bat_close_datetime', 'cic_forum_info.frm_close_datetime', 'cic_forum_info.frm_total_money');
		$checktime = cdate('Y-m-d H:i:s', ctimestamp() - 24 * 60 * 60);
		$where = array(
			'brd_id' => 3,
			'cic_forum_info.frm_close_datetime >=' => $checktime
		);
		
		$result = $this->{$this->modelname}->get_post_list($per_page, $offset, $where, '', $findex, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['post_display_name'] = display_username(
					element('post_userid', $val),
					element('post_nickname', $val)
				);
				$result['list'][$key]['board'] = $board = $this->board->item_all(element('brd_id', $val));
				$result['list'][$key]['num'] = $list_num++;
				if ($board) {
					$result['list'][$key]['boardurl'] = board_url(element('brd_key', $board));
					$result['list'][$key]['posturl'] = post_url(element('brd_key', $board), element('post_id', $val));
				}
			}
		}

		$view['view']['data'] = $result;

		$view['view']['primary_key'] = $this->Post_model->primary_key;

		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		$search_option = array('post_title' => '제목', 'post_content' => '내용');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);

	$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

	$layoutconfig = array('layout' => 'layout', 'skin' => 'proceeding_forum');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	public function close_forum()
	{
		$eventname = 'event_admin_cicconfigs_close_forum_list';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();
		
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$view['view']['sort'] = array(
			'post_id' => $param->sort('post_id', 'asc'),
			'post_hit' => $param->sort('post_hit', 'asc'),
			'post_datetime' => $param->sort('post_datetime', 'asc'),
			'cic_forum_info.frm_bat_close_datetime' => $param->sort('cic_forum_info.frm_bat_close_datetime', 'asc'),
			'cic_forum_info.frm_close_datetime' => $param->sort('cic_forum_info.frm_close_datetime', 'asc'),
			'cic_forum_info.frm_total_money' => $param->sort('cic_forum_info.frm_total_money', 'asc'),
		);
		$findex = $this->input->get('findex', null, 'post_id');
		$forder = $this->input->get('forder', null, 'desc');
		$findex = $findex.' '.$forder;
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');
		
		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;
		
		$this->{$this->modelname}->allow_search_field = array('post_id', 'post_title', 'post_content'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('post_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('post_id', 'post_hit', 'post_datetime', 'cic_forum_info.frm_bat_close_datetime'
																, 'cic_forum_info.frm_close_datetime', 'cic_forum_info.frm_total_money');
		$checktime = cdate('Y-m-d H:i:s', ctimestamp() - 24 * 60 * 60);
		$where = array(
			'brd_id' => 3,
			'cic_forum_info.frm_close_datetime <' => $checktime
		);
		
		$result = $this->{$this->modelname}->get_post_list($per_page, $offset, $where, '', $findex, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['post_display_name'] = display_username(
					element('post_userid', $val),
					element('post_nickname', $val)
				);
				$result['list'][$key]['board'] = $board = $this->board->item_all(element('brd_id', $val));
				$result['list'][$key]['num'] = $list_num++;
				if ($board) {
					$result['list'][$key]['boardurl'] = board_url(element('brd_key', $board));
					$result['list'][$key]['posturl'] = post_url(element('brd_key', $board), element('post_id', $val));
				}
			}
		}

		$view['view']['data'] = $result;

		$view['view']['primary_key'] = $this->Post_model->primary_key;

		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		$search_option = array('post_title' => '제목', 'post_content' => '내용');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);

	$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

	$layoutconfig = array('layout' => 'layout', 'skin' => 'close_forum');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	public function forum_write($post_id = 0)
	{
		$eventname = 'event_admin_ciccinfigs_update_company';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		if($post_id) {
			$post_id = (int) $post_id;
			if(empty($post_id) OR $post_id < 1 ){
				show_404();
			}
		}

		$primary_key = $this->Post_model->primary_key;

		$getdata = array();
		if ($post_id) {
			$getdata = $this->Post_model->get_one($post_id);
		} else {
			// 기본값 설정
		}

		$this->load->library('form_validation');

		$config = array(
				array(
					'field' => 'comp_url',
					'lable' => 'URL',
					'rules' => 'prep_url|valid_url',
				),
				array(
					'field' => 'comp_segment',
					'lable' => 'Segment',
					'rules' => 'trim|required|min_length[2]|max_length[30]',
				),
				array(
					'field' => 'comp_img_select',
					'lable' => 'Image_Select',
					'rules' => 'trim|required|min_length[2]|max_length[30]',
				),
			);

		$this->form_validation->set_rules($config);	
	}


}
