<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Maincoin class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

/**
 * 관리자>CIC 설정>메인코인관리 controller 입니다.
 */
class Maincoin extends CB_Controller
{
	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cicconfigs/maincoin';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('CIC_maincoin_exchange','CIC_maincoin_coin', 'CIC_maincoin_coin_detail');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'CIC_maincoin_exchange_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'dhtml_editor');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring'));
	}

    /**
	 * 거래소목록을 가져오는 메소드입니다
	 */
	public function index()
	{
		$this->load->library('coinapi');
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cicconfigs_maincoin_index';
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
		$findex = $this->input->get('findex', null, 'cme_orderby');
		$forder = $this->input->get('forder', null, 'asc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;
		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('cme_id', 'cme_english_nm', 'cme_korean_nm'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('cme_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('cme_orderby'); // 정렬이 가능한 필드
		$checktime = cdate('Y-m-d H:i:s', ctimestamp() - 24 * 60 * 60);
		$where = array(
			'cme_del <>' => 1,
		);
		
		$result = $this->{$this->modelname}
			->get_admin_list($per_page, $offset, $where, '', $findex, '', $forder, $sfield, $skeyword);
		$list_num = 1 + ($page - 1) * $per_page;
		
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['num'] = $list_num++;
			}
		}
		$view['view']['data'] = $result;
		$view['view']['sort'] = array(
			'cme_orderby' => $param->sort('cme_orderby', 'desc'),
		);

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
		$search_option = array('cme_korean_nm' => '거래소명(한글)', 'cme_english_nm' => '거래소명(영어)');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/exchange_listdelete/?' . $param->output());
		$view['view']['write_url'] = admin_url($this->pagedir . '/exchange_write/?' . $param->output());
		
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
	 * 거래소 추가 또는 수정 페이지를 가져오는 메소드입니다
	 */
	public function exchange_write($cme_idx = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_ciccinfigs_maincoin_exchange_write';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */
		if ($cme_idx) {
			$cme_idx = (int) $cme_idx;
			if (empty($cme_idx) OR $cme_idx < 1) {
				show_404();
			}
		}
		$primary_key = $this->{$this->modelname}->primary_key;

		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($cme_idx) {
			$getdata = $this->{$this->modelname}->get_one($cme_idx);
		} else {
			// 기본값 설정
		}

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'cme_korean_nm',
				'label' => '거래소명 - 한글',
				'rules' => 'trim|required|min_length[2]|max_length[10]',
			),
			array(
				'field' => 'cme_english_nm',
				'label' => '거래소명 - 영문',
				'rules' => 'trim|required|min_length[2]|max_length[20]',
			),
			array(
				'field' => 'cme_logo',
				'label' => '거래소 로고 url',
				'rules' => 'trim|required|valid_url',
			),
		);
		if ($this->input->post($primary_key)) {
			$config[] = array(
				'field' => 'cme_id',
				'label' => '거래소 id',
				'rules' => 'trim|required|alpha_dash|min_length[2]|max_length[20]|is_unique[cic_maincoin_exchange.cme_id.cme_idx.' . element('cme_idx', $getdata) . ']',
			);
		} else {
			$config[] = array(
				'field' => 'cme_id',
				'label' => '거래소 id',
				'rules' => 'trim|required|alpha_dash|min_length[2]|max_length[20]|is_unique[cic_maincoin_exchange.cme_id]',
			);
		}
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

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			$updatedata = array(
				'cme_id' => $this->input->post('cme_id', null, ''),
				'cme_korean_nm' => $this->input->post('cme_korean_nm', null, ''),
				'cme_english_nm' => $this->input->post('cme_english_nm', null, ''),
				'cme_logo' => $this->input->post('cme_logo', null, ''),
				'cme_default' => $this->input->post('cme_default', null, '') ? 1 : 0,
			);

			/**
			 * 게시물을 수정하는 경우입니다
			 */
			if ($this->input->post($primary_key)) {
				$this->{$this->modelname}->update($this->input->post($primary_key), $updatedata);
				$this->session->set_flashdata(
					'message',
					'정상적으로 수정되었습니다'
				);
			} else {
				/**
				 * 게시물을 새로 입력하는 경우입니다
				 * 기본값 설정입니다
				 */
				$updatedata['cme_orderby'] = $this->{$this->modelname}->get_this_orderby();

				$cme_idx = $this->{$this->modelname}->insert($updatedata);
				$this->session->set_flashdata(
					'message',
					'정상적으로 추가되었습니다'
				);
			}

			$redirecturl = admin_url($this->pagedir);
			redirect($redirecturl);
		}

		$param =& $this->querystring;
		$getdata = array();
		if ($cme_idx) {
			$getdata = $this->{$this->modelname}->get_one($cme_idx);
		} else {
			// 기본값 설정
		}

		$view['view']['data'] = $getdata;
		$view['view']['list_url'] = admin_url($this->pagedir . '?' . $param->output());

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $primary_key;

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'exchange_write');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

    /**
	 * 코인목록을 가져오는 메소드입니다
	 */
	public function coin()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_ciccinfigs_maincoin_coin';
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
		$findex = $this->input->get('findex', null, 'cmc_orderby');
		$forder = $this->input->get('forder', null, 'asc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;
		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->CIC_maincoin_coin_model->allow_search_field = array('cmc_id', 'cmc_english_nm', 'cmc_korean_nm', 'cmc_symbol'); // 검색이 가능한 필드
		$this->CIC_maincoin_coin_model->search_field_equal = array('cmc_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->CIC_maincoin_coin_model->allow_order_field = array('cmc_orderby'); // 정렬이 가능한 필드
		$checktime = cdate('Y-m-d H:i:s', ctimestamp() - 24 * 60 * 60);
		$where = array(
			'cmc_del <>' => 1,
		);
		
		$result = $this->CIC_maincoin_coin_model
			->get_admin_list($per_page, $offset, $where, '', $findex, '', $forder, $sfield, $skeyword);
		$list_num = 1 + ($page - 1) * $per_page;
		
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['num'] = $list_num++;
			}
		}
		$view['view']['data'] = $result;

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->CIC_maincoin_coin_model->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '/coin?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;
		$view['view']['sort'] = array(
			'cmc_orderby' => $param->sort('cmc_orderby', 'desc'),
		);
		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('cmc_symbol' => '코인심볼','cmc_korean_nm' => '코인이름(한글)', 'cmc_english_nm' => '코인이름(영어)');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir . '/coin');
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/coin_listdelete/?' . $param->output());
		$view['view']['write_url'] = admin_url($this->pagedir . '/coin_write/?' . $param->output());
		
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'coin');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 코인 추가 또는 수정 페이지를 가져오는 메소드입니다
	 */
	public function coin_write($cmc_idx = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_ciccinfigs_maincoin_coin_write';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */
		
		if ($cmc_idx) {
			$cmc_idx = (int) $cmc_idx;
			if (empty($cmc_idx) OR $cmc_idx < 1) {
				show_404();
			}
		}


		$primary_key = $this->CIC_maincoin_coin_model->primary_key;

		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($cmc_idx) {
			$getdata = $this->CIC_maincoin_coin_model->get_one($cmc_idx);
		} else {
			// 기본값 설정
		}

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'cmc_korean_nm',
				'label' => '코인 이름 - 한글',
				'rules' => 'trim|required|min_length[1]|max_length[10]',
			),
			array(
				'field' => 'cmc_english_nm',
				'label' => '코인 이름 - 영문',
				'rules' => 'trim|required|min_length[1]|max_length[20]',
			),
		);
		if ($this->input->post($primary_key)) {
			$config[] = array(
				'field' => 'cmc_symbol',
				'label' => '코인 심볼',
				'rules' => 'trim|required|alpha_numeric|min_length[2]|max_length[6]|is_unique[cic_maincoin_coin.cmc_symbol.cmc_idx.' . element('cmc_idx', $getdata) . ']',
			);
		} else {
			$config[] = array(
				'field' => 'cmc_symbol',
				'label' => '코인 심볼',
				'rules' => 'trim|required|alpha_numeric|min_length[2]|max_length[6]|is_unique[cic_maincoin_coin.cmc_symbol]',
			);
		}
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

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			$updatedata = array(
				'cmc_korean_nm' => $this->input->post('cmc_korean_nm', null, ''),
				'cmc_english_nm' => $this->input->post('cmc_english_nm', null, ''),
				'cmc_symbol' => $this->input->post('cmc_symbol', null, ''),
			);
			if($this->input->post('cmc_default') != 2){
				$updatedata['cmc_default'] = $this->input->post('cmc_default', null, '') ? 1 : 0;
			}

			/**
			 * 게시물을 수정하는 경우입니다
			 */
			if ($this->input->post($primary_key)) {
				$this->CIC_maincoin_coin_model->update($this->input->post($primary_key), $updatedata);
				$this->session->set_flashdata(
					'message',
					'정상적으로 수정되었습니다'
				);
			} else {
				/**
				 * 게시물을 새로 입력하는 경우입니다
				 * 기본값 설정입니다
				 */
				$updatedata['cmc_orderby'] = $this->CIC_maincoin_coin_model->get_this_orderby();


				$cmc_idx = $this->CIC_maincoin_coin_model->insert($updatedata);
				$this->session->set_flashdata(
					'message',
					'정상적으로 추가되었습니다'
				);
			}

			$redirecturl = admin_url($this->pagedir . '/coin/');
			redirect($redirecturl);
		}

		$param =& $this->querystring;
		$getdata = array();
		if ($cmc_idx) {
			$getdata = $this->CIC_maincoin_coin_model->get_one($cmc_idx);
		} else {
			// 기본값 설정
		}

		$view['view']['data'] = $getdata;
		$view['view']['list_url'] = admin_url($this->pagedir . '/coin/?' . $param->output());

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $primary_key;

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'coin_write');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 코인 거래소 수정 페이지를 가져오는 메소드입니다
	 */
	public function coin_write_exchange($cmc_idx = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_ciccinfigs_maincoin_coin_write_exchange';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 프라이머리키가 입력되지 않으면 에러처리합니다
		 */
		
		$cmc_idx = (int) $cmc_idx;
		if (empty($cmc_idx) OR $cmc_idx < 1) {
			show_404();
		}
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$findex = 'cmc_orderby';
		$forder = 'desc';


		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'cmcd_cmc_idx',
				'label' => '코인 idx',
				'rules' => 'trim|is_natural_no_zero',
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

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			$updatedata = $this->input->post();

			$this->CIC_maincoin_coin_detail_model->update_exchange($updatedata);
			$view['view']['alert_message'] = '정상적으로 저장되었습니다';
		}

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_order_field = array('cme_orderby'); // 정렬이 가능한 필드

		$where = array(
			'cme_del <>' => 1,
		);
		$exchange_list = $this->{$this->modelname}
			->get_admin_list('', '', $where, '', 'cme_orderby', '', 'asc');
		$coin_detail_list = $this->CIC_maincoin_coin_detail_model->get_this_exchange($cmc_idx);
		$list_num = 1;
		if (element('list', $exchange_list)) {
			foreach (element('list', $exchange_list) as $key => $val) {
				$exchange_list['list'][$key]['num'] = $list_num++;
				$exchange_list['list'][$key]['detail'] = $coin_detail_list[element('cme_idx', $val)];
			}
		}
		$view['view']['exchange_list'] = $exchange_list;
		$result = $this->CIC_maincoin_coin_model->get_one($cmc_idx);
		$view['view']['data'] = $result;
		$view['view']['list_url'] = admin_url($this->pagedir . '/coin/?' . $param->output());

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->CIC_maincoin_coin_model->primary_key;

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'coin_write_exchange');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 목록 페이지에서 선택삭제를 하는 경우 실행되는 메소드입니다
	 */
	public function coin_listdelete()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_ciccinfigs_maincoin_coin_listdelete';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */

		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					$where = array(
						'cmc_idx' => $val,
					);
					$this->CIC_maincoin_coin_model->delete_where($where);
					$where = array(
						'cmcd_cmc_idx' => $val,
					);
					$this->CIC_maincoin_coin_detail_model->delete_where($where);
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
		$redirecturl = admin_url($this->pagedir . '/coin?' . $param->output());

		redirect($redirecturl);
	}


	/**
	 * 거래소 순서를 변경하는 메소드입니다
	 */
	public function ajax_set_exchange_orderby()
	{

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'cme_idx',
				'label' => '선택 거래소',
				'rules' => 'trim|required|is_natural_no_zero|max_length[10]',
			),
			array(
				'field' => 'type',
				'label' => '타입',
				'rules' => 'trim|required|in_list[up,down]',
			),
		);
		$this->form_validation->set_rules($config);

		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false) {
			$result = array('error' => '비정상적인 접근입니다.');
			exit(json_encode($result));
		}

		$this_exchange = $this->{$this->modelname}->get_one($this->input->post('cme_idx'));
		if(!$this_exchange){
			$result = array('error' => '선택한 거래소를 찾을 수 없습니다.');
			exit(json_encode($result));
		}

		$next_exchange = $this->{$this->modelname}->get_beside_exchange(element('cme_orderby', $this_exchange), $this->input->post('type'));

		if(!$next_exchange){
			$result = array('error' => $this->input->post('type') == 'up' ? '이미 최상단입니다.' : '이미 최하단입니다.');
			exit(json_encode($result));
		}

		$this->{$this->modelname}->update(
			element('cme_idx',$this_exchange), 
			array(
				'cme_orderby' => element('cme_orderby', $next_exchange)
			)
		);
		$this->{$this->modelname}->update(
			element('cme_idx',$next_exchange), 
			array(
				'cme_orderby' => element('cme_orderby', $this_exchange)
			)
		);
		$result = array('success' => '성공적으로 수정하였습니다.');
		exit(json_encode($result));
	}


	/**
	 * 코인 순서를 변경하는 메소드입니다
	 */
	public function ajax_set_coin_orderby()
	{

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'cmc_idx',
				'label' => '선택 코인',
				'rules' => 'trim|required|is_natural_no_zero|max_length[10]',
			),
			array(
				'field' => 'type',
				'label' => '타입',
				'rules' => 'trim|required|in_list[up,down]',
			),
		);
		$this->form_validation->set_rules($config);

		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false) {
			$result = array('error' => '비정상적인 접근입니다.');
			exit(json_encode($result));
		}

		$this_coin = $this->CIC_maincoin_coin_model->get_one($this->input->post('cmc_idx'));
		if(!$this_coin){
			$result = array('error' => '선택한 거래소를 찾을 수 없습니다.');
			exit(json_encode($result));
		}

		$next_coin = $this->CIC_maincoin_coin_model->get_beside_coin(element('cmc_orderby', $this_coin), $this->input->post('type'));
		// print_r($this->db->last_query());
		// exit;
		if(!$next_coin){
			$result = array('error' => $this->input->post('type') == 'up' ? '이미 최상단입니다.' : '이미 최하단입니다.');
			exit(json_encode($result));
		}

		$this->CIC_maincoin_coin_model->update(
			element('cmc_idx',$this_coin), 
			array(
				'cmc_orderby' => element('cmc_orderby', $next_coin)
			)
		);
		$this->CIC_maincoin_coin_model->update(
			element('cmc_idx',$next_coin), 
			array(
				'cmc_orderby' => element('cmc_orderby', $this_coin)
			)
		);
		$result = array('success' => '성공적으로 수정하였습니다.');
		exit(json_encode($result));
	}
}
