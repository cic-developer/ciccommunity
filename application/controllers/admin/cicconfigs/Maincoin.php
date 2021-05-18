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
	protected $models = array('CIC_maincoin_exchange');

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
	 * 기본 목록을 설정하는 메소드입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_ciccinfigs_maincoin_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

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
	 * 거래소목록을 가져오는 메소드입니다
	 */
	public function exchange()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_ciccinfigs_maincoin_exchange';
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
		$findex = 'cme_orderby';
		$forder = 'desc';
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
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['num'] = $list_num--;
				// if ($board) {
				// 	$result['list'][$key]['boardurl'] = board_url(element('brd_key', $board));
				// 	$result['list'][$key]['posturl'] = post_url(element('brd_key', $board), element('post_id', $val));
				// }
				// $result['list'][$key]['category'] = '';
				// if (element('post_category', $val)) {
				// 	$result['list'][$key]['category'] = $this->Board_category_model->get_category_info(element('brd_id', $val), element('post_category', $val));
				// }
				// if (element('post_image', $val)) {
				// 	$imagewhere = array(
				// 		'post_id' => element('post_id', $val),
				// 		'pfi_is_image' => 1,
				// 	);
				// 	$file = $this->Post_file_model->get_one('', '', $imagewhere, '', '', 'pfi_id', 'ASC');
				// 	$result['list'][$key]['thumb_url'] = thumb_url('post', element('pfi_filename', $file), 80);
				// } else {
				// 	$result['list'][$key]['thumb_url'] = get_post_image_url(element('post_content', $val), 80);
				// }
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
		$search_option = array('cme_korean_nm' => '거래소명(한글)', 'cme_english_nm' => '거래소명(영어)');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir . '/exchange');
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/exchange_listdelete/?' . $param->output());
		$view['view']['write_url'] = admin_url($this->pagedir . '/exchange_write/?' . $param->output());
		
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'exchange');
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
			$board_meta = $this->Board_meta_model->get_all_meta(element('brd_id', $getdata));
			if (is_array($board_meta)) {
				$getdata = array_merge($getdata, $board_meta);
			}
		} else {
			// 기본값 설정
			$getdata['brd_search'] = 1;
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
				'field' => 'is_submit',
				'label' => '전송',
				'rules' => 'trim|numeric',
			),
			array(
				'field' => 'brd_name',
				'label' => '게시판이름',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'brd_mobile_name',
				'label' => '게시판모바일이름',
				'rules' => 'trim',
			),
			array(
				'field' => 'bgr_id',
				'label' => '그룹명',
				'rules' => 'trim|required|numeric',
			),
			array(
				'field' => 'board_layout',
				'label' => '레이아웃',
				'rules' => 'trim',
			),
			array(
				'field' => 'board_mobile_layout',
				'label' => '모바일레이아웃',
				'rules' => 'trim',
			),
			array(
				'field' => 'board_sidebar',
				'label' => '사이드바',
				'rules' => 'trim',
			),
			array(
				'field' => 'board_mobile_sidebar',
				'label' => '모바일사이드바',
				'rules' => 'trim',
			),
			array(
				'field' => 'board_skin',
				'label' => '스킨',
				'rules' => 'trim',
			),
			array(
				'field' => 'board_mobile_skin',
				'label' => '모바일스킨',
				'rules' => 'trim',
			),
			array(
				'field' => 'header_content',
				'label' => '상단내용',
				'rules' => 'trim',
			),
			array(
				'field' => 'footer_content',
				'label' => '하단내용',
				'rules' => 'trim',
			),
			array(
				'field' => 'mobile_header_content',
				'label' => '모바일상단내용',
				'rules' => 'trim',
			),
			array(
				'field' => 'mobile_footer_content',
				'label' => '모바일하단내용',
				'rules' => 'trim',
			),
			array(
				'field' => 'brd_order',
				'label' => '정렬순서',
				'rules' => 'trim|required|numeric|is_natural|less_than_equal_to[10000]',
			),
			array(
				'field' => 'brd_search',
				'label' => '검색여부',
				'rules' => 'trim|numeric',
			),
			array(
				'field' => 'board_use_captcha',
				'label' => '검색여부',
				'rules' => 'trim|numeric',
			),
			/**
			 * 2021 03 15 추가
			 * CIC 포럼 및 QnA등을 위한 설정
			*/
			array(
				'field' => 'board_extra_type',
				'label' => '게시판설정',
				'rules' => 'trim'
			),
		);
		if ($this->input->post($primary_key)) {
			$config[] = array(
				'field' => 'brd_key',
				'label' => '게시판주소',
				'rules' => 'trim|required|alpha_dash|min_length[3]|max_length[50]|is_unique[board.brd_key.brd_id.' . element('brd_id', $getdata) . ']',
			);
		} else {
			$config[] = array(
				'field' => 'brd_key',
				'label' => '게시판주소',
				'rules' => 'trim|required|alpha_dash|min_length[3]|max_length[50]|is_unique[board.brd_key]',
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

			$this->load->model('Board_group_model');
			$group_cnt = $this->Board_group_model->count_by();
			if ($group_cnt === 0) {
				alert('최소 1개 그룹이 생성되어야 합니다. 그룹관리 페이지로 이동합니다', admin_url('board/boardgroup'));
			}

		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			$brd_order = $this->input->post('brd_order') ? $this->input->post('brd_order') : 0;
			$brd_search = $this->input->post('brd_search') ? $this->input->post('brd_search') : 0;
			$updatedata = array(
				'bgr_id' => $this->input->post('bgr_id', null, ''),
				'brd_key' => $this->input->post('brd_key', null, ''),
				'brd_name' => $this->input->post('brd_name', null, ''),
				'brd_mobile_name' => $this->input->post('brd_mobile_name', null, ''),
				'brd_order' => $brd_order,
				'brd_search' => $brd_search,
			);

			$array = array('board_layout', 'board_mobile_layout', 'board_sidebar',
				'board_mobile_sidebar', 'board_skin', 'board_mobile_skin', 'header_content',
				'footer_content', 'mobile_header_content', 'mobile_footer_content', 'board_use_captcha', 'board_extra_type');

			$metadata = array();
			$groupdata = array();
			$alldata = array();
			$grp = $this->input->post('grp');
			$all = $this->input->post('all');

			foreach ($array as $value) {
				$metadata[$value] = $this->input->post($value, null, '');
				if (element($value, $grp)) {
					$groupdata[$value] = $this->input->post($value, null, '');
				}
				if (element($value, $all)) {
					$alldata[$value] = $this->input->post($value, null, '');
				}
			}

			/**
			 * 게시물을 수정하는 경우입니다
			 */
			if ($this->input->post($primary_key)) {
				$this->{$this->modelname}->update($this->input->post($primary_key), $updatedata);
				$this->Board_meta_model->save($cme_idx, $metadata);

				$getdata = $this->{$this->modelname}->get_one($cme_idx);
				if ($groupdata) {
					$where = array(
						'bgr_id' => $getdata['bgr_id'],
					);
					$res = $this->Board_model->get_board_list($where);
					foreach ($res as $bkey => $bval) {
						if ($bval['brd_id'] === $getdata['brd_id']) {
							continue;
						}
						$this->Board_meta_model->save($bval['brd_id'], $groupdata);
					}
				}
				if ($alldata) {
					$res = $this->Board_model->get_board_list();
					foreach ($res as $bkey => $bval) {
						if ($bval['brd_id'] === $getdata['brd_id']) {
							continue;
						}
						$this->Board_meta_model->save($bval['brd_id'], $alldata);
					}
				}
				$view['view']['alert_message'] = '기본정보 설정이 저장되었습니다';
			} else {
				/**
				 * 게시물을 새로 입력하는 경우입니다
				 * 기본값 설정입니다
				 */
				$upload_max_filesize = ini_get('upload_max_filesize');
				if ( ! preg_match("/([m|M])$/", $upload_max_filesize)) {
					$upload_max_filesize = (int)($upload_max_filesize / 1048576);
				} else {
					$array = array('m', 'M');
					$upload_max_filesize = str_replace($array, '', $upload_max_filesize);
				}
				$metadata['order_by_field'] = 'post_num, post_reply';
				$metadata['list_count'] = 20;
				$metadata['mobile_list_count'] = 10;
				$metadata['page_count'] = 5;
				$metadata['mobile_page_count'] = 3;
				$metadata['show_list_from_view'] = 1;
				$metadata['new_icon_hour'] = 24;
				$metadata['hot_icon_hit'] = 100;
				$metadata['hot_icon_day'] = 30;
				$metadata['subject_length'] = 60;
				$metadata['mobile_subject_length'] = 40;
				$metadata['reply_order'] = 'asc';
				$metadata['gallery_cols'] = 4;
				$metadata['gallery_image_width'] = 120;
				$metadata['gallery_image_height'] = 80;
				$metadata['mobile_gallery_cols'] = 2;
				$metadata['mobile_gallery_image_width'] = 120;
				$metadata['mobile_gallery_image_height'] = 80;
				$metadata['use_scrap'] = 1;
				$metadata['use_post_like'] = 1;
				$metadata['use_post_dislike'] = 1;
				$metadata['use_print'] = 1;
				$metadata['use_sns'] = 1;
				$metadata['use_prev_next_post'] = 1;
				$metadata['use_mobile_prev_next_post'] = 1;
				$metadata['use_blame'] = 1;
				$metadata['blame_blind_count'] = 3;
				$metadata['syntax_highlighter'] = 1;
				$metadata['comment_syntax_highlighter'] = 1;
				$metadata['use_autoplay'] = 1;
				$metadata['post_image_width'] = 600;
				$metadata['post_mobile_image_width'] = 400;
				$metadata['content_target_blank'] = 1;
				$metadata['use_auto_url'] = 1;
				$metadata['use_mobile_auto_url'] = 1;
				$metadata['use_post_dhtml'] = 1;
				$metadata['link_num'] = 2;
				$metadata['use_upload_file'] = 1;
				$metadata['upload_file_num'] = 2;
				$metadata['mobile_upload_file_num'] = 2;
				$metadata['upload_file_max_size'] = $upload_max_filesize;
				$metadata['comment_count'] = 20;
				$metadata['mobile_comment_count'] = 20;
				$metadata['comment_page_count'] = 5;
				$metadata['mobile_comment_page_count'] = 3;
				$metadata['use_comment_like'] = 1;
				$metadata['use_comment_dislike'] = 1;
				$metadata['use_comment_profile'] = 1;
				$metadata['use_mobile_comment_profile'] = 1;
				$metadata['comment_best'] = 1;
				$metadata['mobile_comment_best'] = 1;
				$metadata['comment_best_like_num'] = 3;
				$metadata['use_comment_secret'] = 1;
				$metadata['comment_order'] = 'asc';
				$metadata['use_comment_blame'] = 1;
				$metadata['comment_blame_blind_count'] = 3;
				$metadata['protect_comment_num'] = 5;
				$metadata['use_sideview'] = 1;
				$metadata['use_sideview_icon'] = 1;
				$metadata['use_tempsave'] = 1;
				$metadata['use_download_log'] = 1;
				$metadata['use_posthistory'] = 1;
				$metadata['use_link_click_log'] = 1;
				$metadata['use_sitemap'] = 1;

				$cme_idx = $this->{$this->modelname}->insert($updatedata);
				$this->Board_meta_model->save($cme_idx, $metadata);

				$getdata = $this->{$this->modelname}->get_one($cme_idx);
				if ($groupdata) {
					$where = array(
						'bgr_id' => $getdata['bgr_id'],
					);
					$res = $this->Board_model->get_board_list($where);
					foreach ($res as $bkey => $bval) {
						if ($bval['brd_id'] === $getdata['brd_id']) {
							continue;
						}
						$this->Board_meta_model->save($bval['brd_id'], $groupdata);
					}
				}
				if ($alldata) {
					$res = $this->Board_model->get_board_list();
					foreach ($res as $bkey => $bval) {
						if ($bval['brd_id'] === $getdata['brd_id']) {
							continue;
						}
						$this->Board_meta_model->save($bval['brd_id'], $alldata);
					}
				}
				$this->session->set_flashdata(
					'message',
					'기본정보 설정이 저장되었습니다'
				);

				$redirecturl = admin_url($this->pagedir . '/write/' . $cme_idx);
				redirect($redirecturl);
			}
		}

		$getdata = array();
		if ($cme_idx) {
			$getdata = $this->{$this->modelname}->get_one($cme_idx);
			$board_meta = $this->Board_meta_model->get_all_meta(element('brd_id', $getdata));
			if (is_array($board_meta)) {
				$getdata = array_merge($getdata, $board_meta);
			}
		} else {
			// 기본값 설정
			$getdata['brd_search'] = 1;
		}

		$view['view']['data'] = $getdata;
		$view['view']['data']['group_option'] = $this->{$this->modelname}
		->get_group_select(set_value('bgr_id', element('bgr_id', $getdata)));
		$view['view']['data']['board_layout_option'] = get_skin_name(
			'_layout',
			set_value('board_layout', element('board_layout', $getdata)),
			'기본설정따름'
		);
		$view['view']['data']['board_mobile_layout_option'] = get_skin_name(
			'_layout',
			set_value('board_mobile_layout', element('board_mobile_layout', $getdata)),
			'기본설정따름'
		);
		$view['view']['data']['board_skin_option'] = get_skin_name(
			'board',
			set_value('board_skin', element('board_skin', $getdata)),
			'기본설정따름'
		);
		$view['view']['data']['board_mobile_skin_option'] = get_skin_name(
			'board',
			set_value('board_mobile_skin', element('board_mobile_skin', $getdata)),
			'기본설정따름'
		);

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $primary_key;
		$view['view']['boardlist'] = $this->Board_model->get_board_list();

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
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

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
}
