<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Point class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>회원설정>포인트관리 controller 입니다.
 */
class Level extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'member/Level';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Member','CIC_member_level_config');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'CIC_member_level_config_model';

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
		$this->load->library(array('pagination', 'querystring', 'point'));
	}

    public function index()
    {
        // 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_member_level_index';
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
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->CIC_member_level_config_model->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->CIC_member_level_config_model->allow_search_field 
			= array('vp_id', 'cic_vp.mem_id', 'vp_datetime', 'vp_content', 'vp_type', 'vp_action'); // 검색이 가능한 필드
		$this->CIC_member_level_config_model->search_field_equal = array('vp_id', 'cic_vp.mem_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->CIC_member_level_config_model->allow_order_field = array('vp_id'); // 정렬이 가능한 필드
		$result = $this->CIC_member_level_config_model
			->get_list($per_page, $offset, '', '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		$view['view']['data'] = $result;

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->CIC_member_level_config_model->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) .'?'. $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('mlc_title' => '등급 이름', 'mlc_level' => '레벨');
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
	public function write($level_id = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_member_level_write';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$primary_key = $this->{$this->modelname}->primary_key;

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */		
        $config = array(
            array(
                'field' => 'mlc_title',
                'label' => '등급 이름',
                'rules' => 'required|max_length[254]',
            ),
            array(
                'field' => 'mlc_level',
                'label' => '등급 레벨',
                'rules' => 'required|numeric',
            ),
            array(
                'field' => 'mlc_target_point',
                'label' => '도달 포인트',
                'rules' => 'required|numeric'
            ),
            array(
                'field' => 'mlc_enable',
                'label' => '활성화',
                'rules' => 'required|in_list[0,1]'
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

			/**
			 * primary key 정보를 저장합니다
			 */
			$view['view']['primary_key'] = $primary_key;

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
            $view['view']['data'] = $this->CIC_member_level_config_model->get_one($level_id);
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

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);
            $postData = $this->input->post();

			$this->session->set_flashdata(
				'message',
				'정상적으로 입력되었습니다'
			);

            $this->load->library('upload');
			if (isset($_FILES) && isset($_FILES['mlc_attach']) && isset($_FILES['mlc_attach']['name']) && $_FILES['mlc_attach']['name']) {
				$upload_path = config_item('uploads_dir') . '/mlc_attach/';
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

				if ($this->upload->do_upload('mlc_attach')) {
					$img = $this->upload->data();
					$updatephoto = cdate('Y') . '/' . cdate('m') . '/' . element('file_name', $img);
				} else {
					$file_error = $this->upload->display_errors();
                    print_r($file_error); exit;
				}
            }

            $postData = $this->input->post();

            $Arr = array(
                'mlc_title' => element('mlc_title', $postData),
                'mlc_level' => element('mlc_level', $postData),
                'mlc_attach'=> $updatephoto ? $updatephoto : '',
                'mlc_target_point' => element('mlc_target_point', $postData),
                'mlc_enable' => element('mlc_enable', $postData)
            );            

            if($mlc_id = element('mlc_id', $postData)){
                $this->CIC_member_level_config_model->update($mlc_id, $Arr);
            }else{
                $this->CIC_member_level_config_model->insert($Arr);
            }

			// 이벤트가 존재하면 실행합니다
			Events::trigger('after', $eventname);

			/**
			 * 게시물의 신규입력 또는 수정작업이 끝난 후 목록 페이지로 이동합니다
			 */
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir. '?' . $param->output());
			redirect($redirecturl);
		}
	}

}
?>