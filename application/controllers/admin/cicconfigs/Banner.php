<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Banner class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>CIC 설정>배너관리 controller 입니다.
 */
class Banner extends CB_Controller
{
	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cicconfigs/banner';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('CIC_Banner');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'CIC_Banner_model';

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
	 * 목록을 가져오는 메소드입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_ciccinfigs_banner_index';
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
			'ban_id' => $param->sort('ban_id', 'asc'),
			'ban_start_date' => $param->sort('ban_start_date', 'asc'),
			'ban_end_date' => $param->sort('ban_end_date', 'asc'),
			'ban_hit' => $param->sort('ban_hit', 'asc'),
			'ban_order' => $param->sort('ban_order', 'asc'),
			'ban_activated' => $param->sort('ban_activated', 'asc'),
		);
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('ban_id', 'ban_title', 'ban_content'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('ban_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('ban_id', 'ban_start_date', 'ban_end_date', 'ban_hit', 'ban_order', 'ban_activated'); // 정렬이 가능한 필드

		$where = array();
		if ($this->input->get('ban_activated') === 'Y') {
			$where['ban_activated'] = '1';
		}
		if ($this->input->get('ban_activated') === 'N') {
			$where['ban_activated'] = '0';
		}

		$result = $this->{$this->modelname}
			->get_admin_list($per_page, $offset, $where, '', $findex, '', $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				if (empty($val['ban_start_date']) OR $val['ban_start_date'] === '0000-00-00') {
					$result['list'][$key]['ban_start_date'] = '미지정';
				}
				if (empty($val['ban_end_date']) OR $val['ban_end_date'] === '0000-00-00') {
					$result['list'][$key]['ban_end_date'] = '미지정';
				}
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
		$search_option = array('ban_title' => '제목');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['write_url'] = admin_url($this->pagedir . '/write');
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/listdelete/?' . $param->output());

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
	 * 게시판 글쓰기 또는 수정 페이지를 가져오는 메소드입니다
	 */
	public function write($pid = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cicconfig_banner_write';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */
		if ($pid) {
			$pid = (int) $pid;
			if (empty($pid) OR $pid < 1) {
				show_404();
			}
		}
		$primary_key = $this->{$this->modelname}->primary_key;

		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($pid) {
			$getdata = $this->{$this->modelname}->get_one($pid);
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
				'field' => 'ban_title',
				'label' => '배너명',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'ban_start_date',
				'label' => '배너시작일',
				'rules' => 'trim|alpha_dash|exact_length[10]',
			),
			array(
				'field' => 'ban_end_date',
				'label' => '배너종료일',
				'rules' => 'trim|alpha_dash|exact_length[10]',
			),
			array(
				'field' => 'ban_activated',
				'label' => '배너활성화',
				'rules' => 'trim|required|numeric',
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

			if ($pid) {
				if (empty($getdata['ban_start_date']) OR $getdata['ban_start_date'] === '0000-00-00') {
					$getdata['ban_start_date'] = '';
				}
				if (empty($getdata['ban_end_date']) OR $getdata['ban_end_date'] === '0000-00-00') {
					$getdata['ban_end_date'] = '';
				}
				$view['view']['data'] = $getdata;
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
			$layoutconfig = array('layout' => 'layout', 'skin' => 'write');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));

		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			 // $upload_path => uploads/banner/
            $this->load->library('upload');
			if (isset($_FILES) && isset($_FILES['ban_image']) && isset($_FILES['ban_image']['name']) && $_FILES['ban_image']['name']) {
				$upload_path = config_item('uploads_dir') . '/banner/';
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
				$uploadconfig['max_size'] = 12 * 1024;
				// $uploadconfig['max_width'] = '1000';
				// $uploadconfig['max_height'] = '1000';
				$uploadconfig['encrypt_name'] = true;

				$this->upload->initialize($uploadconfig);

				if ($this->upload->do_upload('ban_image')) {
					$img = $this->upload->data();
					$updatephoto = cdate('Y') . '/' . cdate('m') . '/' . element('file_name', $img);
				} else {
					$file_error = $this->upload->display_errors('','');
					$this->session->set_flashdata(
						'message',
						$file_error
					);
	
					$param =& $this->querystring;
					$redirecturl = admin_url($this->pagedir . '?' . $param->output());
		
					redirect($redirecturl);
				}
            }


			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			$ban_start_date = $this->input->post('ban_start_date') ? $this->input->post('ban_start_date') : null;
			$ban_end_date = $this->input->post('ban_end_date') ? $this->input->post('ban_end_date') : null;
			$ban_page = $this->input->post('ban_page') ? $this->input->post('ban_page') : 0;
			$ban_disable_hours = $this->input->post('ban_disable_hours') ? $this->input->post('ban_disable_hours') : 0;
			$ban_activated = $this->input->post('ban_activated') ? $this->input->post('ban_activated') : 0;

			$updatedata = array(
				'ban_title' => $this->input->post('ban_title', null, ''),
				'ban_start_date' => $ban_start_date,
				'ban_end_date' => $ban_end_date,
				'ban_activated' => $ban_activated,
                'ban_url'    =>  $this->input->post('ban_url', null, ''),
                'ban_target' =>  $this->input->post('ban_target', null, ''),
                'ban_order' =>  $this->input->post('ban_order', null, ''),
			);

            if($updatephoto){
                $updatedata['ban_image'] = $updatephoto;
            }
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
				 */
				$updatedata['ban_datetime'] = cdate('Y-m-d H:i:s');
				$updatedata['ban_ip'] = $this->input->ip_address();
				$updatedata['mem_id'] = $this->member->item('mem_id');
                $updatedata['ban_hit'] = 0;

				$this->{$this->modelname}->insert($updatedata);
				$this->session->set_flashdata(
					'message',
					'정상적으로 입력되었습니다'
				);
			}
			//오늘 생성된 배너 캐시를 삭제합니다.
			$this->cache->delete('banner/banner-info-' . cdate('Y-m-d'));

			// 이벤트가 존재하면 실행합니다
			Events::trigger('after', $eventname);

			/**
			 * 게시물의 신규입력 또는 수정작업이 끝난 후 목록 페이지로 이동합니다
			 */
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());

			redirect($redirecturl);
		}
	}

    /**
	 * 목록 페이지에서 선택삭제를 하는 경우 실행되는 메소드입니다
	 */
	public function listdelete()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cicconfigs_banner_listdelete';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					$this->{$this->modelname}->delete($val);
				}
			}
		}

        //오늘 생성된 배너 캐시를 삭제합니다.
        $this->cache->delete('banner/banner-info-' . cdate('Y-m-d'));

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
