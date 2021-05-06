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
class Withdraws_log extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'withdraw/withdraws_log';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('CIC_withdraw_log');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'CIC_withdraw_log_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'chkstring');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring', 'member'));
	}

	/**
	 * 관리자 출금요청 처리 로그 메인 페이지입니다.
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_withdraw_withdraws_log_index';
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
			'cwl_idx' => $param->sort('cwl_idx', 'asc'),
			'cwl_wallet_address' => $param->sort('cwl_wallet_address', 'asc'),
			'cwl_res_admin_id' => $param->sort('cwl_res_admin_id', 'asc'),
			'cwl_req_user_id' => $param->sort('cwl_req_user_id', 'asc'),
			'cwl_res_admin_ip' => $param->sort('cwl_res_admin_ip', 'asc'),
			'cwl_req_user_ip' => $param->sort('cwl_req_user_ip', 'asc'),
			'cwl_cp_point' => $param->sort('cwl_cp_point', 'asc'),
			// 'cwl_content' => $param->sort('cwl_content', 'asc'),
			'cwl_datetime' => $param->sort('cwl_datetime', 'asc'),
			'cwl_result' => $param->sort('cwl_result', 'asc'),
		);
		$findex = $this->input->get('findex', null, 'cwl_idx');
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('cwl_idx', 'cwl_wallet_address', 'cwl_res_admin_id', 'cwl_req_user_id', 'cwl_res_admin_ip', 'cwl_req_user_ip', 'cwl_cp_point', 'cwl_datetime', 'cwl_result'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('cwl_idx', 'cwl_cp_point', 'cwl_wallet_address', 'cwl_res_admin_ip', 'cwl_req_user_ip'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('cwl_idx', 'cwl_wallet_address', 'cwl_res_admin_id', 'cwl_req_user_id', 'cwl_res_admin_ip', 'cwl_req_user_ip', 'cwl_cp_point', 'cwl_datetime', 'cwl_result'); // 정렬이 가능한 필드

		$where = array();
		if (! $this->input->get('cwl_result') && $this->input->get('cwl_result') != '0') {
			//
		}
		if ($this->input->get('cwl_result') == '1') {
			$where['cwl_result'] = 1;
		}
		if ($this->input->get('cwl_result') == '0') {
			$where['cwl_result'] = 0;
		}

		$result = $this->{$this->modelname}->get_withdraw_log_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {

				$where = array(
					'cwl_idx' => element('cwl_idx', $val),
				);
				
				$result['list'][$key]['display_name'] = display_username(
					element('cwl_res_admin_id', $val),
					element('cwl_req_user_id', $val),
				);
				
				$result['list'][$key]['num'] = $list_num--;
			}
		}

		$view['view']['data'] = $result;

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
		$search_option = array('cwl_res_admin_id' => '관리자아이디', 'cwl_req_user_id' => '유저아이디', 
									'cwl_res_admin_ip' => '관리자아이피', 'cwl_req_user_ip' => '유저아이피', 
										'cwl_cp_point' => '출금요청금액', 'cwl_wallet_address' => '지갑주소',
											'cwl_datetime' => '처리날짜');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		
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

}


// print_r($view['data']);
// echo $view['view']['data'];
// exit;

// echo '<script>'; echo 'console.log("'.$sql_notice.'")'; echo '</script>';

// echo '<script>'; echo 'alert("isMobile : '.$isMobile .'");'; echo '</script>';

