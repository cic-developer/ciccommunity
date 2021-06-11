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
class Withdraws extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'withdraw/withdraws';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('CIC_withdraw', 'CIC_cp', 'Member', 'CIC_wconfig');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'CIC_withdraw_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'chkstring', 'coin_price');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring', 'member', 'coinapi'));
	}

	/**
	 * 관리자 출급요청목록 메인 페이지입니다.
	 */
	public function index()
	{

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

		// 코인 데이터
		$coinData = $this->coinapi->get_coin_data('gdac', 'PER', 'KRW'); // price, price_usd, korea_premium, volume, change_rate
		
		$view['view']['deposit'] = $withdraw_deposit;
		$view['view']['price'] = $coinData['price'];

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

	// 출금 요청 승인
	public function approve()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_withdraw_withdraws_approve';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */
		$widIdx = (int)$this->input->post('wid_idx1');
		if (empty($widIdx) OR $widIdx < 1) {
			$this->session->set_flashdata(
				'message',
				'존재하지 않는 출금요청 정보입니다.'
			);
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());
			redirect($redirecturl);
			// show_404();
		}
		$primary_key = $this->{$this->modelname}->primary_key;

		// 해당 출금요청 정보 불러오기
		$getdata = $this->{$this->modelname}->get_one($widIdx);
		if(!$getdata){
			$this->session->set_flashdata(
				'message',
				'존재하지 않는 출금요청 정보입니다.'
			);
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());
			redirect($redirecturl);
			// show_404();
		}
		$memIdx = $getdata['wid_mem_idx'];

		// 해당 출금요청 유저 정보 불러오기
		$member_info = $this->Member_model->get_one($memIdx);
		if(!$member_info){
			$this->session->set_flashdata(
				'message',
				'탈퇴 및 계정삭제에 의한 존재하지않는 계정의 신청정보입니다.'
			);
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());
			redirect($redirecturl);
			// show_404();
		}

		// 로그인한 관리자 정보 불라오기
		$member_info = $this->member->get_member();
		if(!$member_info){
			$this->session->set_flashdata(
				'message',
				'관리자 정보 에러'
			);
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());
			redirect($redirecturl);
			// show_404();
		}

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		$config = array(
			array(
				'field' => 'cp_transaction',
				'label' => '트랜잭션',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'cp_percoin',
				'label' => '퍼코인',
				'rules' => 'trim|required|greater_than_equal_to[0.01]',
			),
			array(
				'field' => 'cp_content1',
				'label' => '사유',
				'rules' => 'trim|required',
			),
		);
		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();

		if($form_validation){
				if($member_info['mem_userid'] 
					&& $this->input->ip_address() && $this->input->post('cp_transaction')
						&& $this->input->post('cp_percoin') && $this->input->post('cp_content1') ){
				$adminid = $member_info['mem_userid'];
				$adminip = $this->input->ip_address();
				$transaction = $this->input->post('cp_transaction');
				$percoin = $this->input->post('cp_percoin');
				$content = $this->input->post('cp_content1');
				$memo = $this->input->post('cp_memo');

				$result = $this->{$this->modelname}->set_withdraw_approve($widIdx, $adminid, $adminip, $transaction, $percoin, $content, $memo);
				if($result != 1){
					// 실패
				}
			} else {
				$this->session->set_flashdata(
					'message',
					'정보를 정확히 작성해주세요.'
				);
				$param =& $this->querystring;
				$redirecturl = admin_url($this->pagedir . '?' . $param->output());
				redirect($redirecturl);
			}
		} else {
			$this->session->set_flashdata(
				'message',
				'정보를 정확히 작성해주세요.'
			);
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());
			redirect($redirecturl);
		}
		
		// 이벤트가 존재하면 실행합니다
		Events::trigger('after', $eventname);

		/**
		 * 처리가 끝난 후 목록페이지로 이동합니다
		 */
		$this->session->set_flashdata(
			'message',
			'정상적으로 처리되었습니다.'
		);
		$param =& $this->querystring;
		$redirecturl = admin_url($this->pagedir . '?' . $param->output());

		redirect($redirecturl);
	}

	// 출금 요청 반려
	public function retire(){
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_withdraw_withdraws_retire';
		$this->load->event($eventname);
		
		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */
		$widIdx = (int)$this->input->post('wid_idx2');
		if (empty($widIdx) OR $widIdx < 1) {
			$this->session->set_flashdata(
				'message',
				'존재하지 않는 출금요청 정보입니다.'
			);
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());
			redirect($redirecturl);
			// show_404();
		}
		$primary_key = $this->{$this->modelname}->primary_key;

		// 해당 출금요청 정보 불러오기
		$getdata = $this->{$this->modelname}->get_one($widIdx);
		if(!$getdata){
			$this->session->set_flashdata(
				'message',
				'존재하지 않는 출금요청 정보입니다.'
			);
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());
			redirect($redirecturl);
			// show_404();
		}
		if($getdata['wid_mem_idx'] && $getdata['wid_req_money']){
			$memIdx = $getdata['wid_mem_idx'];
			$money = $getdata['wid_req_money'];
		}

		// 해당 출금요청 유저 정보 불러오기
		$member_info = $this->Member_model->get_one($memIdx);
		if(!$member_info){
			$this->session->set_flashdata(
				'message',
				'탈퇴 및 계정삭제에 의한 존재하지않는 계정의 신청정보입니다.'
			);
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());
			redirect($redirecturl);
			// show_404();
		}
		if($member_info['mem_cp']){
			$mem_cp = $member_info['mem_cp'];
		}

		// 로그인한 관리자 정보 불라오기
		$admin_info = $this->member->get_member();
		if(!$admin_info){
			$this->session->set_flashdata(
				'message',
				'관리자 정보 에러'
			);
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());
			redirect($redirecturl);
			// show_404();
		}
		if($admin_info['mem_userid'] && $this->input->ip_address()){
			$adminid = $admin_info['mem_userid'];
			$adminip = $this->input->ip_address();
		}

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		$config = array(
			array(
				'field' => 'cp_content2',
				'label' => '사유',
				'rules' => 'trim|required',
			),
		);
		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();

		if(!$form_validation){
			$this->session->set_flashdata(
				'message',
				'정보를 정확히 작성해주세요.'
			);
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());
			redirect($redirecturl);
		}

		/**
		 * 출금 요청한 금액을 반환합니다.
		 * member
		 */
		// $result = $this->Member_model->set_user_point($memIdx, -$money, $mem_cp);
		if($result != 1){
			$this->session->set_flashdata(
				'message',
				'포인트 반환에 실패하였습니다'
			);
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());
			redirect($redirecturl);
		} else{
			/**
			 * 반환 로그를 기록합니다.
			 * cic_cp
			 */
			$content = $this->input->post('cp_content2');
			$memo = $this->input->post('cp_memo2');
			$logResult = $this->CIC_cp_model->set_cic_cp($memIdx, $content, $money, '@byadmin', $admin_info['mem_id'], '출금반려');

			// insert_cp
			$this->point->insert_cp($memIdx, $content, $money, 'post', $pst_id, '출금반려');
            
			if($logResult == 0){
				// 실패
				// 이전 실행을 리셋
				$this->Member_model->set_user_point($memIdx, $money, $mem_cp);
                
				$this->session->set_flashdata(
					'message',
					'포인트 반환에 실패하였습니다'
				);
				$param =& $this->querystring;
				$redirecturl = admin_url($this->pagedir . '?' . $param->output());
				redirect($redirecturl);
			}
			/**
			 * 반려한 출금 요청건의 상태를 0으로 수정합니다.
			 * cic_withdraw
			 */
			$result = $this->{$this->modelname}->set_withdraw_retire($widIdx, $content, $adminid, $adminip, $memo);

			if($result != 1){
				// 실패
				// 이전 실행을 리셋
				$this->CIC_cp_model->set_cic_cp($memIdx, $content, -$money, '@byadmin', $admin_info['mem_id'], '출금반려 실패');
				$this->Member_model->set_user_point($memIdx, $money, $mem_cp);
                
				$this->session->set_flashdata(
					'message',
					'포인트 반환에 실패하였습니다'
				);
				$param =& $this->querystring;
				$redirecturl = admin_url($this->pagedir . '?' . $param->output());
				redirect($redirecturl);
			}
		
			// 이벤트가 존재하면 실행합니다
			Events::trigger('after', $eventname);
			/**
			 * 처리가 끝난 후 목록페이지로 이동합니다
			 */
			$this->session->set_flashdata(
				'message',
				'정상적으로 처리되었습니다.'
			);
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());

			redirect($redirecturl);
		}
	}

	/**
	 * 엑셀로 데이터를 추출합니다.
	 */
	public function excel()
	{

		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_withdraw_withdraws_excel';
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
			'wid_userid' => $param->sort('wid_userid', 'asc'),
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
		$this->{$this->modelname}->allow_search_field = array('wid_idx', 'wid_userid', 'wid_nickname', 'wid_req_money', 'wid_wallet_address', 'wid_req_datetime', 'wid_res_datetime', 'wid_res_date'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('wid_idx', 'wid_req_money', 'wid_wallet_address'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('wid_idx', 'wid_userid', 'wid_nickname', 'wid_req_money', 'wid_wallet_address', 'wid_req_datetime', 'wid_res_datetime', 'wid_res_date', 'wid_state'); // 정렬이 가능한 필드

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


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=출금요청목록' . cdate('Y_m_d') . '.xls');
		echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir . '/excel', $view, true);
	}

}


// print_r($view['data']);
// echo $view['view']['data'];
// exit;

// echo '<script>'; echo 'console.log("'.$sql_notice.'")'; echo '</script>';

// echo '<script>'; echo 'alert("isMobile : '.$isMobile .'");'; echo '</script>';

