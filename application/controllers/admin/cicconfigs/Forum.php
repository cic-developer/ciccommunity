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
	protected $models = array('CIC_forum');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'CIC_forum_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'chkstring',  'dhtml_editor');

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
        print_r("Hi");
        exit;
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_withdraw_withdraws_index';
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
		$view['view']['sort'] = array(
			'wid_idx' => $param->sort('wid_idx', 'asc'),
			'wid_admin_id' => $param->sort('wid_admin_id', 'asc'),
			'wid_userid' => $param->sort('wid_userid', 'asc'),
			'wid_admin_ip' => $param->sort('wid_admin_ip', 'asc'),
			'wid_userip' => $param->sort('wid_userip', 'asc'),
			'wid_nickname' => $param->sort('wid_nickname', 'asc'),
			'wid_wallet_address' => $param->sort('wid_wallet_address', 'asc'),
			'wid_req_money' => $param->sort('wid_req_money', 'asc'),
			'wid_req_datetime' => $param->sort('wid_req_datetime', 'asc'),
			'wid_res_datetime' => $param->sort('wid_res_datetime', 'asc'),
			'wid_state' => $param->sort('wid_state', 'asc'),
		);
		$findex = $this->input->get('findex', null, 'wid_idx');
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		// 'wid_admin_id', 'wid_admin_ip', 'wid_res_datetime', 'wid_content'
		$this->{$this->modelname}->allow_search_field = array('wid_idx', 'wid_userid', 'wid_userip', 'wid_nickname', 
																	'wid_wallet_address', 'wid_req_money', 'wid_req_datetime'); // 검색이 가능한 필드

		$this->{$this->modelname}->search_field_equal = array('wid_idx', 'wid_req_money', 'wid_wallet_address',
																	'wid_userid', 'wid_userip'); // 검색중 like 가 아닌 = 검색을 하는 필드
		
		$this->{$this->modelname}->allow_order_field = array('wid_idx', 'wid_userid', 'wid_userip', 'wid_nickname', 
																	'wid_wallet_address', 'wid_req_money', 'wid_req_datetime', 'wid_state'); // 정렬이 가능한 필드

		$where = array();
		if (! $this->input->get('wid_state') && $this->input->get('wid_state') != '0') {
			//
		}
		if ($this->input->get('wid_state') == 'null') {
			$where['wid_state'] = null;
		}
		if ($this->input->get('wid_state') == '1') {
			$where['wid_state'] = 1;
		}
		if ($this->input->get('wid_state') == '0') {
			$where['wid_state'] = 0;
		}

		$result = $this->{$this->modelname}->get_withdraw_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {

				$where = array(
					'wid_idx' => element('wid_idx', $val),
				);
				$result['list'][$key]['display_name'] = display_username(
					element('wid_userid', $val),
					element('wid_nickname', $val),
				);
				
				$result['list'][$key]['num'] = $list_num--;
			}
		}

		$view['view']['data'] = $result;
		// $view['view']['all_group'] = $this->Member_group_model->get_all_group();

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
		// 'wid_admin_id' => '관리자아이디', 'wid_admin_ip' => '관리자아이피', 'wid_res_datetime' => '출금요청 처리날짜', 'wid_content' => '처리사유'
		$search_option = array('wid_idx' => '번호',  'wid_userid' => '회원아이디', 'wid_userip' => '회원아이피', 
									'wid_nickname' => '닉네임', 'wid_wallet_address' => '지갑주소', 'wid_req_money' => '출금요청금액', 
										'wid_req_datetime' => '출금요청날짜');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['approve_url'] = admin_url($this->pagedir . '/approve');
		$view['view']['retire_url'] = admin_url($this->pagedir . '/retire');
		
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		// $view['data'] = $result['list'];
		
		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'index');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
}
