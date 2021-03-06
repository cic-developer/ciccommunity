<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Forum class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
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
	protected $models = array('CIC_forum', 'CIC_cp','Board', 'Post', 'Board_category', 'Post_file', 'Post_extra_vars', 'CIC_forum_config', 'CIC_forum_info', 'Member');

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
		$this->load->library(array('pagination', 'querystring', 'member', 'upload', 'point'));
	}

	/**
	 * 관리자 포럼설정 기본정보 페이지입니다
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

		$getdata = $this->CIC_forum_config_model->get_all_meta();
		$view['view']['data'] = $getdata;
		
		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		$config = array(
			array(
				'field' => 'forum_deposit',
				// 'label' => '포럼 예치금',
				'label' => '포럼 예치CP',
				'rules' => 'trim|required|greater_than_equal_to[0]|callback__deposit_decimal_check',
			),
			array(
				'field' => 'forum_bat_change_commission',
				// 'label' => '포럼 배팅 진영 변경 수수료',
				'label' => '포럼 진영 변경 수수료',
				'rules' => 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]|callback__bat_change_commission_decimal_check',
			),
			array(
				'field' => 'forum_bat_max',
				// 'label' => '포럼 최대 배팅금액',
				'label' => '포럼 최대 행사금액',
				'rules' => 'trim|required|greater_than_equal_to[0]|less_than_equal_to[1000]|callback__bat_max_decimal_check',
			),
			array(
				'field' => 'forum_bat_min',
				// 'label' => '포럼 최소 배팅금액',
				'label' => '포럼 최소 행사금액',
				'rules' => 'trim|required|greater_than_equal_to[0]|less_than_equal_to[1000]|callback__bat_min_decimal_check',
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
				'forum_bat_change_commission',
				'forum_bat_max',
				'forum_bat_min',
			);
			foreach ($array as $value) {
				$savedata[$value] = $this->input->post($value, null, '');
			}

			$this->CIC_forum_config_model->save($savedata);
			$view['view']['alert_message'] = '기본정보 설정이 저장되었습니다';

			// 기존 설정 예치금과, 저장시 설정 예치금이 다를 경우
			if($getdata['forum_deposit'] != $savedata['forum_deposit']){

				// 예치금이 있는 유저
				$members_Is_deposit = $this->Member_model->getMembersIsDeposit();

				// 1. 예치금 설정이 변경되면 실행
				// 2. 예치금이 존재하는 유저들의 정보를 가져옴
				// 3. 해당 유저가 작성한 포럼 게시물이 있는지 확인
				// 4. 해당 유저가 작성한 포럼 게시물이 있으면, 분배가 이루어지지 않은 진행중인 포럼이 있는지 확인 (없으면 반환, 게시물은 존재하나 분배가 완료된 게시물임)
				// 5. 해당 유저가 작성한 포럼 게시물이 없으면, 해당 유저가 작성한 도전! CIC 포럼 게시물이 있는지 확인
				// 6. 해당 유저가 작성한 도전! CIC 포럼 게시물이 있으면, 반려되지 않은 포럼이 있는지 확인 (없으면 반환, 게시물은 존재하나 반려된 게시물임)
				// 7. 해당 유저가 작성한 도전! CIC 포럼 게시물이 없으면, 반환 (모든 게시물이 존재하지 않음)
				foreach($members_Is_deposit['list'] as $val){

					$mem_id = (int) $val['mem_id'];
					$mem_cp = (double) $val['mem_cp'];
					$mem_deposit = (double) $val['mem_deposit'];
					$return_cp = $mem_cp + $mem_deposit;
					$admin_id = (int) $this->member->item('mem_id');

					$forumWhere = array(
						'brd_id' => 3,
						'mem_id' => $mem_id
					);
					$forum = $this->Post_model->get_one('', '', $forumWhere);
					if($forum){
						// 포럼 게시물이 있으면

						$forumRepartWhere = array(
							'brd_id' => 3,
							'mem_id' => $mem_id,
							'cic_forum_info.frm_repart_state' => null
						);
						$select = 'post.*, cic_forum_info.frm_repart_state';
						$join = array(
							'cic_forum_info',
							'post.post_id = cic_forum_info.pst_id',
							'left'
						);

						$forum_repart_null = $this->Post_model->get_one_join('', $select, $where3, $join);
						if($forum_repart_null){
							// 존재하는 포럼 게시물 중, 분배가 완료되지 않은 게시물이 있으면 
							// 반환 안됨
						}else {
							// 존재하는 포럼 게시물 중, 분배가 완료되지 않은 게시물이 없으면

							// cp 반환
							$arr = array(
								'mem_deposit' => null,
							);
							$where = array(
							);
							$result = $this->Member_model->set_user_modify($mem_id, $arr);
							
							// 반환 기록
							if($result == 1){
								$content = '관리자로부터 CP가 변경되었습니다. 사용되지 않은 CP는 반환됩니다.';
								// $content = '관리자로부터 예치금 금액이 변경되었습니다. 사용되지 않은 예치금은 반환됩니다.';
								$action = '포럼 CP 반환';
								// $action = '포럼예치금 반환';


								// insert_cp +
								$this->point->insert_cp($mem_id, $mem_deposit, $content, 'member', $mem_id, $this->member->item('mem_id') . '-' . uniqid(''));

							}
						}
					}else {
						// 포럼 게시물이 없으면

						$userforumWhere = array(
							'brd_id' => 6,
							'mem_id' => $mem_id
						);
						$userforum = $this->Post_model->get_one('', '', $userforumWhere);
						if($userforum){
							// 도전! CIC 포럼 게시물이 있으면
							$userforumCateWhere = array(
								'brd_id' => 6,
								'mem_id' => $mem_id,
								'post_category' => 1
							);
							$userforum_cate_one = $this->Post_model->get_one('', '', $userforumCateWhere);

							if($userforum_cate_one){
								// 반려되지 않은 진행중인 도전! CIC 포럼 게시물이 있으면
								// 반환 안됨
							}else{
								// 반려되지 않은 진행중이 도전! CIC 포럼 게시물이 없으면

								// cp 반환
								$arr = array(
									'mem_deposit' => null,
								);
								$where = array(
								);
								$result = $this->Member_model->set_user_modify($mem_id, $arr);
								
								// 반환 기록
								if($result == 1){
									$content =  '관리자로부터 CP가 변경되었습니다. 사용되지 않은 CP는 반환됩니다.';
									$action = '포럼 CP 반환';
									// $content = '관리자로부터 예치금 금액이 변경되었습니다. 사용되지 않은 예치금은 반환됩니다.';
									// $action = '포럼예치금 반환';

									// insert_cp
									$this->point->insert_cp($mem_id, $mem_deposit, $content, 'member', $mem_id, $this->member->item('mem_id') . '-' . uniqid(''));
								}
							}
						}else {
							// 도전! CIC 포람 게시물이 없으면

							// cp 반환
							$arr = array(
								'mem_deposit' => null,
							);
							$where = array(
							);
							$result = $this->Member_model->set_user_modify($mem_id, $arr);
							
							// 반환 기록
							if($result == 1){
								$content =  '관리자로부터 CP가 변경되었습니다. 사용되지 않은 CP는 반환됩니다.';
								$action = '포럼 CP 반환';
								// $content = '관리자로부터 예치금 금액이 변경되었습니다. 사용되지 않은 예치금은 반환됩니다.';
								// $action = '포럼예치금 반환';
								
								// insert_cp
								$this->point->insert_cp($mem_id, $mem_deposit, $content, 'member', $mem_id, $this->member->item('mem_id') . '-' . uniqid(''));
							}
						}
					}
				}
			}
		}
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
			// '포럼 예치금은 소수점 2자리 까지 설정이 가능합니다'
			'포럼 CP는 소수점 2자리 까지 설정이 가능합니다'
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
			// '포럼 배팅 진영 변경 수수료는 소수점 2자리 까지 설정이 가능합니다'
			'포럼 행사 진영 변경 수수료는 소수점 2자리 까지 설정이 가능합니다'
			
		);
		return false;
	}

	/**
	 * 최대 배팅금액 설정, 소수점 두자리 이내 확인
	 */
	public function _bat_max_decimal_check($_str)
	{
		
		$str = explode( '.', $_str );
		if( strlen($str[1]) < 3){
			return true;
		}
        
		$this->form_validation->set_message(
			'_bat_max_decimal_check',
			// '최대 배팅금액은 소수점 2자리 까지 설정이 가능합니다'
			'최대 행사금액은 소수점 2자리 까지 설정이 가능합니다'
		);
		return false;
	}

	/**
	 * 최소 배팅금액 설정, 소수점 두자리 이내 확인
	 */
	public function _bat_min_decimal_check($_str)
	{
		
		$str = explode( '.', $_str );
		if( strlen($str[1]) < 3){
			return true;
		}
        
		$this->form_validation->set_message(
			'_bat_min_decimal_check',
			// '최소 배팅금액은 소수점 2자리 까지 설정이 가능합니다'
			'최소 행사금액은 소수점 2자리 까지 설정이 가능합니다'
		);
		return false;
	}

	//도전 CIC 포럼 리스트 함수 
	public function disapproval_forum()
	{
		$eventname = 'event_admin_cicconfigs_disapproval_forum_list';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();
		
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		
		$param =& $this->querystring;
		$view['view']['sort'] = array(
			'post_id' => $param->sort('post_id', 'asc'),
			'post_datetime' => $param->sort('post_datetime', 'asc'),
			'post_like' => $param->sort('post_like', 'asc'),
		);
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex', null, 'post_id');
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');
		
		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;
		
		$this->Post_model->allow_search_field = array('post_id', 'post_title', 'post_content', 'post.brd_id',); // 검색이 가능한 필드
		$this->Post_model->search_field_equal = array('post_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->Post_model->allow_order_field = array('post_id','post_datetime','post_like');
		
		
		

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

		$config['base_url'] = admin_url($this->pagedir) . '/disapproval_forum' . '?' . $param->replace('page');
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

	// 도전! CIC 포럼을 반려하는 함수 
	public function upadte_forum_return()
	{
		
		$eventname = 'event_admin_update_disapproval_return';
		$this->load->event($eventname);
		Events::trigger('before', $eventname);
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {

					$post = $this->Post_model->get_one($val);
					$writer_id = $val['mem_id'];
					$writer_info = $this->Member_model->get_one($writer_id);
					$writer_deposit = (int) $writer_info['mem_deposit'];

					$arr = array(
						'mem_deposit' => null,
					);
					$memResult = $this->Member_model->set_user_modify($writer_id, $arr);

					$this->point->insert_cp($writer_id, $writer_deposit, '포럼 마감 및 배분 완료', 'member', $writer_id, $this->member->item('mem_id') . '-' . uniqid(''));

					$this->Post_model->upadte_forum_return($val);
				}
			}
		}


		// $deposit = ???;

		// $arr = array(
		// 	'mem_deposit' => null,
		// );
		// $memResult = $this->Member_model->set_user_modify($writer_id, $arr);

		// $this->point->insert_cp($writer_id, $deposit, '포럼 마감 및 배분 완료', 'member', $writer_id, $this->member->item('mem_id') . '-' . uniqid(''));

		

		Events::trigger('after', $eventname);
		$this->session->set_flashdata(
			'message',
			'성공적으로 반려되었습니다.'
		);
		$param =& $this->querystring;
		$redirecturl = admin_url($this->pagedir . '/disapproval_forum' . $param->output());
		redirect($redirecturl);
	}

	// 진행중포럼 페이지입니다
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
			'cic_forum_total_cp' => $param->sort('cic_forum_total_cp', 'asc'),
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

		// 현재 시간이 포럼 마감시간보다 작을 경우
		$checktime = cdate('Y-m-d H:i:s', ctimestamp());// - 24 * 60 * 60);
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

		$config['base_url'] = admin_url($this->pagedir) . '/proceeding_forum' . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		$search_option = array('post_title' => '제목', 'post_content' => '내용');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['forum_midway_closing_url'] = admin_url($this->pagedir . '/forum_midway_closing/?' . $param->output());

	$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

	$layoutconfig = array('layout' => 'layout', 'skin' => 'proceeding_forum');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	// 마감된포럼 페이지입니다
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
			'cic_forum_total_cp' => $param->sort('cic_forum_total_cp', 'asc'),
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
																, 'cic_forum_info.frm_close_datetime', 'cic_forum_total_cp');
		// 현재 시간이 포럼 종료 시간보다 많을 경우
		$checktime = cdate('Y-m-d H:i:s', ctimestamp());
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

		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		$config['base_url'] = admin_url($this->pagedir) . '/close_forum' . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		$search_option = array('post_title' => '제목', 'post_content' => '내용');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['list_delete_url'] = site_url('admin/cicconfigs/forum/listDeleteToCloseForum');

		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		$layoutconfig = array('layout' => 'layout', 'skin' => 'close_forum');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 마감된 포럼 중에서도 배분이 끝난 게시물을 삭제하는 기능입니다
	 */
	public function listDeleteToCloseForum()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_forum_listDeleteToCloseForum';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					$post = $this->CIC_forum_model->get_one($val);

					if($post['frm_repart_state'] == 1){
						$this->board->delete_post($val);

						$where = array(
							'pst_id' => $val
						);
						$this->CIC_forum_model->delete_forum_where($where, 'cic_forum_info');
						$this->CIC_forum_model->delete_forum_where($where, 'cic_forum_cp');
					}
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
		$redirecturl = admin_url($this->pagedir . '/close_forum');
		redirect($redirecturl);
	}

	// 마감된 포럼의 cp 포인트를 관리자가 분배하는 페이지
	public function forum_repart($pst_id = 0)
	{
		$this->db->trans_start();
		// 이벤트 라이브러리를 로딩합니다.
		$eventname = 'event_admin_cicconfig_forum_repart';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventame);

		// 해당 게시물이 존재하지 않는 경우
		if($pst_id) {
			$pst_id = (int) $pst_id;
			if(empty($pst_id) OR $pst_id < 1 ){
				show_404();
			}
		}

		// get forum data && total cp, a cp, b cp
		$getdata = array();
		$dead_line = $this->input->post('application_deadline');
		if($dead_line){
			$getdata = $this->CIC_forum_model->get_one_apply_deadline($pst_id, $dead_line);
		}else{
			$getdata = $this->CIC_forum_model->get_one($pst_id);
		}
        
		// 배분이 끝난 게시물 접근 제한
		if($getdata['frm_repart_state'] == 1){
			$redirecturl = admin_url($this->pagedir . '/close_forum');
			redirect($redirecturl);
			exit;
		}

		$total_cp = (double) $getdata['cic_forum_total_cp']; // 총 cp

		$view['view']['forum'] = $getdata;
		$view['view']['total_cp'] = $total_cp;

		$b_cp = 0;
		$a_cp = 0;
		$view['view']['A_per'] = 0;
		$view['view']['B_per'] = 0;
		if($total_cp){
			$a_cp = (double) $getdata['cic_A_cp']; // A cp
			$b_cp = (double) $getdata['cic_B_cp']; // B cp

			$view['view']['cic_A_cp'] = $a_cp; // A cp
			$view['view']['cic_B_cp'] = $b_cp; // B cp
			$view['view']['A_per'] = ($a_cp/$total_cp) * 100; // A cp %
			$view['view']['B_per'] = ($b_cp/$total_cp) * 100; // B cp %

			// validation을 위한 임시 데이터 저장
			$win_cp = $this->input->post('win_option') == 'A' ? $a_cp : $b_cp;
			$lose_cp = $this->input->post('win_option') == 'A' ? $b_cp : $a_cp;
			$win_option = $this->input->post('win_option') == 'A' ? 1 : 2;
		}
		$total_cp_vali = $lose_cp;

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
				array(
					'field' => 'forum_commission',
					'lable' => '수수료 설정',
					'rules' => 'required|trim|greater_than_equal_to[0]|less_than_equal_to[100]|callback__forum_commission_check',
				),
				array(
					'field' => 'prop_writer_reward',
					'lable' => '작성자 보상 설정',
					'rules' => 'required|trim|greater_than_equal_to[0]|less_than_equal_to[100]|callback__forum_commission_check',
				),
				array(
					'field' => 'win_option',
					'lable' => '승리 진영 선택',
					'rules' => 'required|in_list[A,B]',
				),
			);

		$this->form_validation->set_rules($config);	

		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false || ($this->input->post('writer_reward') == NULL && $this->input->post('prop_writer_reward') == NULL)) {
			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

			/**
			 * primary key 정보를 저장합니다
			 */
			// $view['view']['primary_key'] = $primary_key;

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

			/**
			 * 어드민 레이아웃을 정의합니다
			 */
			$layoutconfig = array('layout' => 'layout', 'skin' => 'forum_repart');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}else {
			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);
            
			//승리 옵션이 A인 경우 B의견 cp가 보상 cp 반대도 마찬가지
			switch($this->input->post('win_option')){
				case 'A' :
					$total_cp = (double) $getdata['cic_B_cp']; // B cp
					$win_cp = (double) $getdata['cic_A_cp'];
					$win_option =  1;
					break;
				case 'B' :
					$total_cp = (double) $getdata['cic_A_cp']; // A cp
					$win_cp = (double) $getdata['cic_B_cp'];
					$win_option =  2;
					break;
				default :
					show_404();
					exit;
			}

			$_forum_commission = (double) $this->input->post('forum_commission'); // 포럼 수수료
			$forum_commission = sprintf("%.2f", $total_cp * ($_forum_commission / 100)); // 포럼 수수료를 계산한 후 CP
			$_prop_writer_reward = (double) $this->input->post('prop_writer_reward'); // 작성자 보상수수료
			$prop_writer_reward = sprintf("%.2f" ,$total_cp * ($_prop_writer_reward / 100)); // 작성자 보상수수료를 계산한 후 CP

			$deducted_cost = $forum_commission + $prop_writer_reward; //최종적으로 보상 cp에서 빠지는 금액
			$repart_cp =  $total_cp - $deducted_cost; //최종적으로 나눠 먹을 수 있는 패자 진영측 cp

            if($repart_cp == 0){
				$repart_ratio = 0;
			}else {
				$repart_ratio = $repart_cp / $win_cp; // 1cp당 지급 비율
			}

			$admin_id = $this->member->item('mem_id'); // 관리자 id

			/**
			 * 작성자 보상 지급 시작
			 */
			$post = $this->Post_model->get_one($pst_id); // 게시물 정보
			$writer_id = $post['mem_id']; // 작성자 id
			$writer_info = $this->Member_model->get_one($writer_id);
			$writer_cp = (double) element('mem_cp', $writer_info);
			$writer_deposit = (int) element('mem_deposit', $writer_info);
			$writer_reward = $this->input->post('writer_reward');
			if($writer_reward){
				$writer_changed_cp = $writer_cp + $writer_reward + $prop_writer_reward;
				$writer_reward_sum = $writer_reward + $prop_writer_reward;
			}else{
				$writer_changed_cp = $writer_cp + $prop_writer_reward;
				$writer_reward_sum = $prop_writer_reward;
			}

			if($writer_reward_sum) $this->point->insert_cp($writer_id, $writer_reward_sum, '포럼 게시물 작성자', 'post', $pst_id,  $this->member->item('mem_id') . '-' . uniqid(''));
			
			/**
			 * 투표자 보상 지급 시작
			 */
			// 배팅 가져오기 ( 유저들의 배팅 정보들 )
			$where = array(
				'pst_id' => $pst_id
			);
			
			if($dead_line){
				$forum_bats = $this->CIC_forum_model->get_forum_bat($where, '', $dead_line);
			}else{
				$forum_bats = $this->CIC_forum_model->get_forum_bat($where);
			}
			
            
			// 실제 배분될 총 cp를 계산할 변수
			$repart_real_cp = 0;

			// 배팅 분배
			if ($forum_bats && is_array($forum_bats)) {
				foreach ($forum_bats as $key => $value) {
					// => 회원id
					$mem_id = $value['mem_id'];
					// => 회원 정보
					$member_info = $this->Member_model->get_one($mem_id);
                    
					if($value['cfc_option'] != $win_option){
                        
						// 패배 진영
						// => 회원 패배 전적
						$mem_forum_lose = (int) $member_info['mem_forum_lose'];
						$change_mem_forum_lose = $mem_forum_lose + 1;
                        
						// 전적 갱신
						$arr = array(
							'mem_forum_lose' => $change_mem_forum_lose
						);
						$result = $this->Member_model->set_user_modify($mem_id, $arr);
					}else {
						// 승리 진영
						// => 회원 배팅 cp
						$cfc_cp = (double) $value['cfc_cp'];
						// => 승리 배분 cp
						$give_cp =  $cfc_cp + round($cfc_cp * $repart_ratio, 2);
						$mem_cp = (double) $member_info['mem_cp'];
						$changed_cp = $mem_cp + $give_cp;
						// => 회원 승리 전적
						$mem_forum_win = (int) $member_info['mem_forum_win'];
						$change_mem_forum_win = $mem_forum_win + 1;

						$repart_real_cp .= $give_cp;
						
						// member테이블에 전적 갱신
						$arr = array(
							'mem_forum_win' => $change_mem_forum_win
						);
						$this->Member_model->set_user_modify($mem_id, $arr);

						// insert cp
						$this->point->insert_cp($mem_id, $give_cp, '포럼승리 포인트 배분', 'post', $pst_id,  $this->member->item('mem_id') . '-' . uniqid(''));
					}
				}
			}

			//참여 마감 시간이 지켜지지 않은 참여에 대해 cp 되돌려주는 기능
			$where = array(
				'pst_id' => $pst_id
			);
			if($dead_line){
				$forum_bats = $this->CIC_forum_model->get_forum_bat($where, '', $dead_line, '>');
				if ($forum_bats && is_array($forum_bats)) {
					foreach ($forum_bats as $key => $value) {
						// => 회원id
						$mem_id = $value['mem_id'];
						// => 회원 정보
						$member_info = $this->Member_model->get_one($mem_id);
						
						// => 회원 배팅 cp
						$cfc_cp = (double) $value['cfc_cp'];
						// => 승리 배분 cp
						$give_cp =  $cfc_cp;
						$mem_cp = (double) $member_info['mem_cp'];
						$changed_cp = $mem_cp + $give_cp;

						// insert cp
						$this->point->insert_cp($mem_id, $give_cp, '이슈 마감후 참여 CP 반려', 'post', $pst_id,  $this->member->item('mem_id') . '-' . uniqid(''));
					}
				}
			}

			/**
			 * 투표자 보상 지급 끝
			 */

			/**
			 * 배분 완료 = state 1로 변경 ( cic_forum_info table)
			 * cic_forum_info 컬럼 디자인을 보시면 확인할수 있습니다.
			 */

			$updatedata = array(
				'frm_repart_state' => 1,
				'frm_repart_commission' => $_forum_commission,
				'frm_repart_reward' => $_prop_writer_reward,
				'frm_total_cp' => $getdata['cic_B_cp'] + $getdata['cic_A_cp'],
				'frm_repart_cp' => $total_cp,
				'frm_repart_ratio' => $repart_ratio,
				'frm_repart_real_cp' => $repart_cp,
				'frm_win_opinion' => $win_option,
			);
			$where = array(
				'pst_id' => $pst_id,
			);
			$result = $this->CIC_forum_model->change_repart_state('cic_forum_info', $updatedata, $where);
			/**
			 * 배분 완료 state
			 */

 			// 1 2 3 test
			// 예치금 제거 + cp 반환
			if($writer_deposit){
				$arr = array(
					'mem_deposit' => null,
				);
				$memResult = $this->Member_model->set_user_modify($writer_id, $arr);
				
				if($memResult == 1){

					// insert_cp
					$this->point->insert_cp($writer_id, $writer_deposit, '포럼 마감 및 배분 완료', 'member', $writer_id, $this->member->item('mem_id') . '-' . uniqid(''));
					
					$this->session->set_flashdata(
						'message',
						// '예치금이 반환 되었습니다'
						'예치CP가 반환 되었습니다'
					);
				}else {
					$this->session->set_flashdata(
						'message',
						// '예치금이 반환에 실패하였습니다'
						'예치CP 반환에 실패하였습니다'
					);
				}
			}else {
				$this->session->set_flashdata(
					'message',
					// '반환할 예치금이 없습니다'
					'반환할 CP가 없습니다'
				);
			}

			$param =& $this->querystring; 
			$redirecturl = admin_url($this->pagedir . '/close_forum');
			$this->db->trans_complete();
			redirect($redirecturl);
			// 게시물이 삭제될 경우, 모든 포인트 반환 및 원상복귀 && cic_forum_cp 데이터 삭제 필수 && cic_forum_info 데이터 삭제 필수
			// 마감후 분배여부 status 필요
			// 중도마감 흠
		}
	}

	// 수수료 확인
	public function _forum_commission_check($_str)
	{
		// 소수점 2자리 검사
		$str = explode( '.', $_str );
		if( strlen($str[1]) > 2){
			$this->form_validation->set_message(
				'_forum_commission_check',
				'수수료 설정은 소수점 2자리 까지 설정이 가능합니다'
			);
			return false;
		}

		return true;
	}

	// 작성자 보상 확인
	public function _writer_reward_check($_str)
	{
		// 소수점 2자리 검사
		$str = explode( '.', $_str );
		if( strlen($str[1]) > 2){
			$this->form_validation->set_message(
				'_writer_reward_check',
				'작성자 보상 설정은 소수점 2자리 까지 설정이 가능합니다'
			);
			return false;
		}
        

		return true;
	}
	
	// 포럼 폼벨리데이션
	public function forum_write($post_id = 0)
	{
		
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cicconfig_banner_write';
		$this->load->event($eventname);
		
		$view = array();
		$view['view'] = array();
		
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		
		if ($post_id) {
			$post_id = (int) $post_id;
			if (empty($post_id) OR $post_id < 1) {
				show_404();
			}
		}
		
		$primary_key = $this->Post_model->primary_key;

		$postdata = array();
		$pevdata = array();
		$cfidata = array();
		if($post_id) {
			$postdata = $this->Post_model->get_one($post_id);
			$pevdata = $this->Post_extra_vars_model->get($post_id);
			$cfidata = $this->CIC_forum_info_model->get_one($post_id);
			
		}
		
		$this->load->library('form_validation');
		$batclose = $this->input->post('frm_bat_close_datetime');
		$frmclose = $this->input->post('frm_close_datetime');
		$config = array(
			array(
				'field' => 'frm_bat_close_datetime',
				// 'label' => '배팅 종료일',
				'label' => '행사 종료일',
				'rules' => 'trim|required|callback__minbatclosetime',
			),
			array(
				'field' => 'frm_close_datetime',
				'label' => '포럼 종료일',
				'rules' => 'trim|required|callback__minfrmclosetime',
			),
			array(
				'field' => 'frm_bat_close_datetime',
				// 'label' => '배팅 변경 마감일',
				'label' => '행사 변경 마감일',
				'rules' => 'trim|required|callback__minfrmclosetime',
			),
			array(
				'field' => 'post_title',
				'label' => '포럼 제목',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'post_content',
				'label' => '포럼 제목',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'frm_repart_commission',
				'label' => '수수료 설정',
				'rules' => 'required|greater_than_equal_to[0]'
			),
			array(
				'field' => 'frm_repart_reward',
				'label' => '작성자 보상 설정',
				'rules' => 'required|greater_than_equal_to[0]'
			)
			);
			
			$this->form_validation->set_rules($config);
			
			if ($this->form_validation->run() === false) {
				
				// 이벤트가 존재하면 실행합니다
				$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);
				
				if ($post_id) {
					if (empty($cfidata['frm_bat_close_datetime']) OR $cfidata['frm_bat_close_datetime'] === '0000-00-00 00:00:00') {
						$cfidata['frm_bat_close_datetime'] = '';
					}
					if (empty($cfidata['frm_close_datetime']) OR $cfidata['frm_close_datetime'] === '0000-00-00 00:00:00') {
						$cfidata['frm_close_datetime'] = '';
					}
					if (empty($cfidata['frm_change_close_datetime']) OR $cfidata['frm_change_close_datetime'] === '0000-00-00 00:00:00') {
						$cfidata['frm_change_close_datetime'] = '';
					}
					$view['view']['postdata'] = $postdata;
					$view['view']['frminfodata'] = $cfidata;
					$view['view']['pevdata0'] = $pevdata[0];
					$view['view']['pevdata1'] = $pevdata[1];
				}
			
			/**
			 * primary key 정보를 저장합니다
			 */
			$view['view']['primary_key'] = $primary_key;
			
			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
			
			/**
			 * 어드민 레이아웃을 정의합니다
			 */
			$layoutconfig = array('layout' => 'layout', 'skin' => 'forum_write');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
			
			
		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */
			
			// $upload_path => uploads/forum_image/
            $this->load->library('upload');
			if (isset($_FILES) && isset($_FILES['frm_image']) && isset($_FILES['frm_image']['name']) && $_FILES['frm_image']['name']) {
				$upload_path = config_item('uploads_dir') . '/forum_image/';
				if (is_dir($upload_path) === false) {
					mkdir($upload_path, 0707);
					$file = $upload_path . 'index.php';
					$f = @fopen($file, 'w');
					@fwrite($f, '');
					@fclose($f);
					@chmod($file, 0644);
				}
				$upload_path .= cdate('Y') . '/';
				if (is_dir($upload_path) === false) {
					mkdir($upload_path, 0707);
					$file = $upload_path . 'index.php';
					$f = @fopen($file, 'w');
					@fwrite($f, '');
					@fclose($f);
					@chmod($file, 0644);
				}
				$upload_path .= cdate('m') . '/';
				if (is_dir($upload_path) === false) {
					mkdir($upload_path, 0707);
					$file = $upload_path . 'index.php';
					$f = @fopen($file, 'w');
					@fwrite($f, '');
					@fclose($f);
					@chmod($file, 0644);
				}
				
				$uploadconfig = array();
				$uploadconfig['upload_path'] = $upload_path;
				$uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
				$uploadconfig['max_size'] = '2000';
				$uploadconfig['max_width'] = '1000';
				$uploadconfig['max_height'] = '1000';
				$uploadconfig['encrypt_name'] = true;
				
				$this->upload->initialize($uploadconfig);
				
				if ($this->upload->do_upload('frm_image')) {
					$img = $this->upload->data();
					$updatephoto = cdate('Y') . '/' . cdate('m') . '/' . element('file_name', $img);
				} else {
					$file_error = $this->upload->display_errors();
				}
            }
			
			
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);
			
			//set value
			$frm_bat_close_datetime = $this->input->post('frm_bat_close_datetime') ? $this->input->post('frm_bat_close_datetime') : null;
			$frm_close_datetime = $this->input->post('frm_close_datetime') ? $this->input->post('frm_close_datetime') : null;
			$frm_change_close_datetime = $this->input->post('frm_change_close_datetime') ? $this->input->post('frm_change_close_datetime') : null;
			$frm_repart_commission = $this->input->post('frm_repart_commission') ? $this->input->post('frm_repart_commission') : 0;
			$frm_repart_reward = $this->input->post('frm_repart_reward') ? $this->input->post('frm_repart_reward') : 0;
			$post_title = $this->input->post('post_title', null, '');
			$post_content = $this->input->post('post_content', null, '');
			$pev_value_0 = $this->input->post('pev_value_0', null, '');
			$pev_value_1 = $this->input->post('pev_value_1', null, '');
			
			
			//set value 이외 update data
			$updatedata = array(				
				'frm_bat_close_datetime' => $frm_bat_close_datetime,
				'frm_close_datetime' => $frm_close_datetime,
				'frm_change_close_datetime' => $frm_change_close_datetime,
			);
			$_updatedata = array(
				'post_title' => $post_title,
				'post_content' => $post_content,
			);
			$postupdatedata = array(
				'brd_id' => 3,
			);
			$brd_updatedata = array(
				'brd_id' => 3,
			);
			$pevupdate_0 = array(
				'A_opinion' => $pev_value_0
			);
			$pevupdate_1 = array(
				'B_opinion' => $pev_value_1
			);
			if($updatephoto){
				$updatedata['frm_image'] = $updatephoto;
			}
			if($post_id){
				if($this->input->get('type') == 'a'){
					//도전 cic 포럼에서 진행중인 포럼으로 승격
					$updatedata['frm_bat_close_datetime'] = $frm_bat_close_datetime;
					$updatedata['frm_close_datetime'] = $frm_close_datetime;
					$updatedata['frm_repart_commission'] = $frm_repart_commission;
					$updatedata['frm_repart_reward'] = $frm_repart_reward;
					$updatedata['pst_id'] = $post_id;
					$where = array(
						'post_id' => $post_id,
					);
					$this->Post_model->update($post_id, $brd_updatedata, $where);
					$this->Post_model->update($post_id, $_updatedata, $where);
					$this->CIC_forum_info_model->insert($updatedata);
					$this->Post_extra_vars_model->update($post_id, $brd_updatedata, $where);
					$this->Post_extra_vars_model->save($post_id, 6, $pevupdate_0,);
					$this->Post_extra_vars_model->save($post_id, 6, $pevupdate_1);
					$this->session->set_flashdata(
						'message',
						'정상적으로 입력되었습니다'
					);
					
				}else if($this->input->get('type') == 'b'){
					// 진행중인 포럼에서 수정
					$this->Post_model->update($post_id, $brd_updatedata, $where);
					$this->Post_model->update($post_id, $_updatedata, $where);
					$updatedata['frm_repart_commission'] = $frm_repart_commission;
					$updatedata['frm_repart_reward'] = $frm_repart_reward;
					$this->CIC_forum_info_model->update($post_id, $updatedata, $where);
					$this->Post_extra_vars_model->update($post_id, $brd_updatedata, $where);
					$this->Post_extra_vars_model->save($post_id, 3, $pevupdate_0,);
					$this->Post_extra_vars_model->save($post_id, 3, $pevupdate_1);
					$this->session->set_flashdata(
						'message',
						'정상적으로 수정되었습니다'
					);
				}
			} else {
				/**
				 *  관리자 페이지에서 새로운 글 작성 
				 */
				$postUpdatedata = array(
					'post_num' => $this->Post_model->next_post_num(),
					'post_title' => $post_title,
					'post_content' => $post_content,
					'post_datetime' => cdate('Y-m-d H:i:s'),
					'post_updated_datetime' => cdate('Y-m-d H:i:s'),
					'post_ip' => $this->input->ip_address(),
					'post_html' => 1,
					'brd_id' => 3,
					'mem_id' => $this->member->item('mem_id'),
					'post_userid' => $this->member->item('mem_userid'),
					'post_username' => $this->member->item('mem_username'),
					'post_nickname' => $this->member->item('mem_nickname'),
					'post_email' => $this->member->item('mem_email'),
					'post_homepage' => '',
				);


				$postUpdatedata['post_device'] = ($this->cbconfig->get_device_type() === 'mobile') ? 'mobile' : 'desktop';
				$post_id = $this->Post_model->insert($postUpdatedata);
				
				$forumInfoUpdatedata = array(
					'frm_bat_close_datetime' => $frm_bat_close_datetime,
					'frm_close_datetime' => $frm_close_datetime,
					'pst_id' => $post_id
				);
				$forumInfoUpdatedata['frm_image'] = $updatephoto;
				$forumInfoUpdatedata['frm_repart_commission'] = $frm_repart_commission;
				$forumInfoUpdatedata['frm_repart_reward'] = $frm_repart_reward;
				$this->CIC_forum_info_model->insert($forumInfoUpdatedata);
				
				
				$this->Post_extra_vars_model->add_meta($post_id, 3, 'A_opinion' , $pev_value_0);
				$this->Post_extra_vars_model->add_meta($post_id, 3, 'B_opinion' , $pev_value_1);
			}

			$this->cache->delete('forum/forum-info-' . cdate('Y-m-d'));

			// 이벤트가 존재하면 실행합니다
			Events::trigger('after', $eventname);

			/**
			 * 게시물의 신규입력 또는 수정작업이 끝난 후 목록 페이지로 이동합니다
			 */
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '/proceeding_forum');
			
			

			redirect($redirecturl);
		}
	}


	public function return_forum()
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
			'post_datetime' => $param->sort('post_datetime', 'asc'),
			'post_hit' => $param->sort('post_hit', 'asc'),
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
		$this->{$this->modelname}->allow_order_field = array('post_id', 'post_hit', 'post_datetime',);
		// 현재 시간이 포럼 종료 시간보다 많을 경우
		$checktime = cdate('Y-m-d H:i:s', ctimestamp());
		$where = array(
			'brd_id' => 6,
			'post_category' => '2',
			// 'cic_forum_info.frm_close_datetime <' => $checktime
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

		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		$config['base_url'] = admin_url($this->pagedir) . '/return_forum' . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		$search_option = array('post_title' => '제목', 'post_content' => '내용');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['listdelete_url'] = admin_url($this->pagedir . '/listdelete/?' . $param->output());

		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		$layoutconfig = array('layout' => 'layout', 'skin' => 'return_forum');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	public function forum_midway_closing()
	{
				// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_update_forum_midway_closing';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);
		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					$this->CIC_forum_info_model->forum_midway_closing($val);
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
			'정상적으로 중도마감 되었습니다.'
		);
		$param =& $this->querystring;
		$redirecturl = admin_url($this->pagedir . '/proceeding_forum?' . $param->output());
		redirect($redirecturl);
	}

	public function listdelete()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_board_post_listdelete';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					$post = $this->Post_model->get_one($val);
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
		$redirecturl = admin_url($this->pagedir . '/return_forum' . $param->output());
		redirect($redirecturl);
	}
	
	//포럼 마감시간 확인 함수 
	public function _minfrmclosetime($frmclose)
	{
		$batclose = $this->input->post('frm_bat_close_datetime');
		
		if($frmclose < $batclose){
			$this->form_validation->set_message(
				'_minfrmclosetime',
				// '포럼 마감일은 배팅 마감일보다 이후로 설정해야합니다.'
				'포럼 마감일은 행사 마감일보다 이후로 설정해야합니다.'
			);
			return false;
		}
		return true;
	}


	//배팅마감시간 확인 함수 
	public function _minbatclosetime($batclose)
	{
		$now = cdate('Y-m-d H:i:s');
		if($batclose < $now){
			$this->form_validation->set_message(
				'_minbatclosetime',
				// '배팅 마감일은 현재 시간 이후로 설정해야합니다.'
				'행사 마감일은 현재 시간 이후로 설정해야합니다.'
			);
			return false;
		} 
		return true;
	}
}
