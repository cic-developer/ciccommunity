<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Membermodify class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 회원 정보 수정시 담당하는 controller 입니다.
 */
class Membermodify extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Member_nickname', 'Member_meta', 'Member_auth_email', 'Member_extra_vars');

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'string');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('querystring', 'form_validation', 'email', 'notelib', 'checkplus'));
	}


	/**
	 * 회원정보 수정 페이지입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_index';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$mem_id = (int) $this->member->item('mem_id');

		if ( ! $this->member->item('mem_password')) {
			redirect('membermodify/defaultinfo');
		}

		$this->load->library(array('form_validation'));

		if ( ! function_exists('password_hash')) {
			$this->load->helper('password');
		}

		$login_fail = false;
		$valid_fail = false;

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'mem_password',
				'label' => '패스워드',
				'rules' => 'trim|required|min_length[4]|callback__cur_password_check',
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

			$skin = 'member_password';

			$view['view']['canonical'] = site_url('membermodify');

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

			/**
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_membermodify');
			$meta_description = $this->cbconfig->item('site_meta_description_membermodify');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_membermodify');
			$meta_author = $this->cbconfig->item('site_meta_author_membermodify');
			$page_name = $this->cbconfig->item('site_page_name_membermodify');

			$layoutconfig = array(
				'path' => 'mypage',
				'layout' => 'layout',
				'skin' => $skin,
				'layout_dir' => $this->cbconfig->item('layout_mypage'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
				'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
				'skin_dir' => $this->cbconfig->item('skin_mypage'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
				'page_title' => $page_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'meta_author' => $meta_author,
				'page_name' => $page_name,
			);
			$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
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

			$this->session->set_userdata(
				'membermodify',
				'1'
			);
			redirect('membermodify/modify');
		}
	}

	/**
	 * 회원정보 수정 페이지입니다
	 */
	public function modify()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_modify';
		$this->load->event($eventname);

		if ( ! $this->session->userdata('membermodify')) {
			redirect('membermodify');
		}

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();
		$mem_id = (int) $this->member->item('mem_id');
		
		
		if ( ! function_exists('password_hash')) {
			$this->load->helper('password');
		}
		
		$view = array();
		$view['view'] = array();
		
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		
		// 페이지 접근시 기존 인증내역 삭제
		$this->session->unset_userdata('phone_modify_ath_mail_result');
		$this->session->unset_userdata('password_modify_ath_mail_result');
		$this->session->unset_userdata('wallet_modify_ath_mail_result');
		$this->session->unset_userdata('password_modify_ath_nice_phone_result');
		$this->session->unset_userdata('wallet_modify_ath_nice_phone_result');

		$view['view']['password_enc_data'] = $this->checkplus->main('membermodify', 'password_auth_phone_success', 'password_auth_phone_fail');
		$view['view']['wallet_enc_data'] = $this->checkplus->main('membermodify', 'wallet_auth_phone_success', 'wallet_auth_phone_fail');
		// $view['view']['dec_data'] = $this->session->userdata('dec_data');

		$email_description = '';
		if ($this->cbconfig->item('use_register_email_auth')) {
			$email_description = '이메일을 변경하시면 메일 인증 후에 계속 사용이 가능합니다';
		}

		$configbasic = array();

		$can_update_nickname = false;
		$change_nickname_date = $this->cbconfig->item('change_nickname_date');
		if (empty($change_nickname_date)) {
			$can_update_nickname = true;
		} elseif (strtotime($this->member->item('meta_nickname_datetime')) < ctimestamp() - $change_nickname_date * 86400) {
			$can_update_nickname = true;
		}

		$when_can_update_nickname
			= cdate('Y-m-d H:s', strtotime($this->member->item('meta_nickname_datetime'))
			+ $change_nickname_date * 86400);

		$can_update_open_profile = false;
		$change_open_profile_date = $this->cbconfig->item('change_open_profile_date');
		if (empty($change_open_profile_date)) {
			$can_update_open_profile = true;
		} elseif (strtotime($this->member->item('meta_open_profile_datetime')) < ctimestamp() - $change_open_profile_date * 86400) {
			$can_update_open_profile = true;
		}
		$view['view']['can_update_open_profile'] = $can_update_open_profile;
		$when_can_update_open_profile
			= cdate('Y-m-d H:s', strtotime($this->member->item('meta_open_profile_datetime'))
			+ $change_open_profile_date * 86400);

		$can_update_use_note = false;
		$change_use_note_date = $this->cbconfig->item('change_use_note_date');
		if (empty($change_use_note_date)) {
			$can_update_use_note = true;
		} elseif (strtotime($this->member->item('meta_use_note_datetime')) < ctimestamp() - $change_use_note_date * 86400) {
			$can_update_use_note = true;
		}
		$view['view']['can_update_use_note'] = $can_update_use_note;
		$when_can_update_use_note
			= cdate('Y-m-d H:s', strtotime($this->member->item('meta_use_note_datetime'))
			+ $change_use_note_date * 86400);

		$nickname_description = '';
		if ($this->cbconfig->item('change_nickname_date')) {
			if ($can_update_nickname === false) {
				$nickname_description = '<br />닉네임을 변경하시면 ' . $this->cbconfig->item('change_nickname_date')
					. '일 이내에는 변경할 수 없습니다<br>회원님은 ' . $when_can_update_nickname
					. ' 이후에 닉네임 변경이 가능합니다';
			} else {
				$nickname_description = '<br />닉네임을 변경하시면 ' . $this->cbconfig->item('change_nickname_date') . '일 이내에는 변경할 수 없습니다';
			}
		}

		$configbasic['mem_username'] = array(
			'field' => 'mem_username',
			'label' => '이름',
			'rules' => 'trim|min_length[2]|max_length[20]',
		);
		$configbasic['mem_nickname'] = array(
			'field' => 'mem_nickname',
			'label' => '닉네임',
			'rules' => 'trim|required|min_length[2]|max_length[20]|callback__mem_nickname_check',
			'description' => '공백없이 한글, 영문, 숫자만 입력 가능 2글자 이상' . $nickname_description,
		);
		$configbasic['mem_email'] = array(
			'field' => 'mem_email',
			'label' => '이메일',
			'rules' => 'trim|required|valid_email|max_length[50]|is_unique[member.mem_email.mem_id.' . $mem_id . ']|callback__mem_email_check',
			'description' => $email_description,
		);
		$configbasic['mem_homepage'] = array(
			'field' => 'mem_homepage',
			'label' => '홈페이지',
			'rules' => 'prep_url|valid_url',
		);
		$configbasic['mem_phone'] = array(
			'field' => 'mem_phone',
			'label' => '전화번호',
			'rules' => 'trim|valid_phone',
		);
		$configbasic['mem_birthday'] = array(
			'field' => 'mem_birthday',
			'label' => '생년월일',
			'rules' => 'trim|exact_length[10]',
		);
		$configbasic['mem_sex'] = array(
			'field' => 'mem_sex',
			'label' => '성별',
			'rules' => 'trim|exact_length[1]',
		);
		$configbasic['mem_zipcode'] = array(
			'field' => 'mem_zipcode',
			'label' => '우편번호',
			'rules' => 'trim|min_length[5]|max_length[7]',
		);
		$configbasic['mem_address1'] = array(
			'field' => 'mem_address1',
			'label' => '기본주소',
			'rules' => 'trim',
		);
		$configbasic['mem_address2'] = array(
			'field' => 'mem_address2',
			'label' => '상세주소',
			'rules' => 'trim',
		);
		$configbasic['mem_address3'] = array(
			'field' => 'mem_address3',
			'label' => '참고항목',
			'rules' => 'trim',
		);
		$configbasic['mem_address4'] = array(
			'field' => 'mem_address4',
			'label' => '지번',
			'rules' => 'trim',
		);
		$configbasic['mem_profile_content'] = array(
			'field' => 'mem_profile_content',
			'label' => '자기소개',
			'rules' => 'trim',
		);
		$configbasic['mem_open_profile'] = array(
			'field' => 'mem_open_profile',
			'label' => '정보공개',
			'rules' => 'trim|exact_length[1]',
		);
		if ($this->cbconfig->item('use_note')) {
			$configbasic['mem_use_note'] = array(
				'field' => 'mem_use_note',
				'label' => '쪽지사용',
				'rules' => 'trim|exact_length[1]',
			);
		}
		$configbasic['mem_receive_email'] = array(
			'field' => 'mem_receive_email',
			'label' => '이메일수신여부',
			'rules' => 'trim|exact_length[1]',
		);
		$configbasic['mem_receive_sms'] = array(
			'field' => 'mem_receive_sms',
			'label' => 'SMS 문자수신여부',
			'rules' => 'trim|exact_length[1]',
		);

		$this->load->library(array('form_validation'));
		$login_fail = false;
		$valid_fail = false;

		$registerform = $this->cbconfig->item('registerform');
		$form = json_decode($registerform, true);

		$config = array();
		if ($form && is_array($form)) {
			foreach ($form as $key => $value) {
				if ( ! element('use', $value)) {
					continue;
				}
				if ($key === 'mem_userid' OR $key === 'mem_password' OR $key === 'mem_recommend') {
					continue;
				}

				if (element('func', $value) === 'basic') {
					if ($key === 'mem_address') {
						if (element('required', $value) === '1') {
							$configbasic['mem_zipcode']['rules'] = $configbasic['mem_zipcode']['rules'] . '|required';
						}
						$config[] = $configbasic['mem_zipcode'];
						if (element('required', $value) === '1') {
							$configbasic['mem_address1']['rules'] = $configbasic['mem_address1']['rules'] . '|required';
						}
						$config[] = $configbasic['mem_address1'];
						if (element('required', $value) === '1') {
							$configbasic['mem_address2']['rules'] = $configbasic['mem_address2']['rules'] . '|required';
						}
						$config[] = $configbasic['mem_address2'];
					} else {
						if (element('required', $value) === '1') {
							$configbasic[$value['field_name']]['rules'] = $configbasic[$value['field_name']]['rules'] . '|required';
						}
						if (element('field_type', $value) === 'phone') {
							$configbasic[$value['field_name']]['rules'] = $configbasic[$value['field_name']]['rules'] . '|valid_phone';
						}
						$config[] = $configbasic[$value['field_name']];
					}
				} else {
					$required = element('required', $value) ? '|required' : '';
					if (element('field_type', $value) === 'checkbox') {
						$config[] = array(
							'field' => element('field_name', $value) . '[]',
							'label' => $value['display_name'],
							'rules' => 'trim' . $required,
						);
					} else {
						$config[] = array(
							'field' => element('field_name', $value),
							'label' => $value['display_name'],
							'rules' => 'trim' . $required,
						);
					}
				}
			}
		}
		

		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();
		$file_error = '';
		$updatephoto = '';
		$file_error2 = '';
		$updateicon = '';

		if ($form_validation) {
			$this->load->library('upload');
			if ($this->cbconfig->item('use_member_photo')
				&& $this->cbconfig->item('member_photo_width') > 0
				&& $this->cbconfig->item('member_photo_height') > 0) {
				if (isset($_FILES) && isset($_FILES['mem_photo']) && isset($_FILES['mem_photo']['name']) && $_FILES['mem_photo']['name']) {
					$upload_path = config_item('uploads_dir') . '/member_photo/';
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

					if ($this->upload->do_upload('mem_photo')) {
						$img = $this->upload->data();
						$updatephoto = cdate('Y') . '/' . cdate('m') . '/' . $img['file_name'];
					} else {
						$file_error = $this->upload->display_errors();

					}
				}
			}

			if ($this->cbconfig->item('use_member_icon')
				&& $this->cbconfig->item('member_icon_width') > 0
				&& $this->cbconfig->item('member_icon_height') > 0) {
				if (isset($_FILES)
					&& isset($_FILES['mem_icon'])
					&& isset($_FILES['mem_icon']['name'])
					&& $_FILES['mem_icon']['name']) {
					$upload_path = config_item('uploads_dir') . '/member_icon/';
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

					if ($this->upload->do_upload('mem_icon')) {
						$img = $this->upload->data();
						$updateicon = cdate('Y') . '/' . cdate('m') . '/' . $img['file_name'];
					} else {
						$file_error2 = $this->upload->display_errors();

					}
				}
			}
		}

		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($form_validation === false OR $file_error !== '' OR $file_error2 !== '') {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

			$view['view']['message'] = $file_error . $file_error2;

			$html_content = array();
			$k = 0;
			if ($form && is_array($form)) {
				foreach ($form as $key => $value) {
					if ( ! element('use', $value)) {
						continue;
					}
					if ($key === 'mem_userid' OR $key === 'mem_password' OR $key === 'mem_recommend') {
						continue;
					}

					$required = element('required', $value) ? 'required' : '';

					$item = $this->member->item(element('field_name', $value));
					$html_content[$k] = array();
					$html_content[$k]['field_name'] = element('field_name', $value);
					$html_content[$k]['display_name'] = element('display_name', $value);
					$html_content[$k]['input'] = '';

					//field_type : text, url, email, phone, textarea, radio, select, checkbox, date
					if (element('field_type', $value) === 'text'
						OR element('field_type', $value) === 'url'
						OR element('field_type', $value) === 'email'
						OR element('field_type', $value) === 'phone'
						OR element('field_type', $value) === 'date') {
						if (element('field_type', $value) === 'date') {
							$html_content[$k]['input'] .= '<input type="text" id="' . element('field_name', $value) . '" name="' . element('field_name', $value) . '" class="form-control input datepicker" value="' . set_value(element('field_name', $value), $item) . '" readonly="readonly" ' . $required . ' />';
						} elseif (element('field_type', $value) === 'phone') {
							$html_content[$k]['input'] .= '<input type="text" id="' . element('field_name', $value) . '" name="' . element('field_name', $value) . '" class="form-control input validphone" value="' . set_value(element('field_name', $value), $item) . '" ' . $required . ' />';
						} else {
							$readonly = '';
							if (element('field_name', $value) === 'mem_nickname' && $can_update_nickname === false) {
								$readonly = 'readonly="readonly"';
							}
							$html_content[$k]['input'] .= '<input type="' . element('field_type', $value) . '" id="' . element('field_name', $value) . '" name="' . element('field_name', $value) . '" class="form-control input" value="' . set_value(element('field_name', $value), $item) . '" ' . $readonly . ' ' . $required . ' />';
						}
					} elseif (element('field_type', $value) === 'textarea') {
						$html_content[$k]['input'] .= '<textarea id="' . element('field_name', $value) . '" name="' . element('field_name', $value) . '" class="form-control input" ' . $required . ' >' . set_value(element('field_name', $value), $item) . '</textarea>';
					} elseif (element('field_type', $value) === 'radio') {
						$html_content[$k]['input'] .= '<div class="checkbox">';
						if (element('field_name', $value) === 'mem_sex') {
							$options = array(
								'1' => '남성',
								'2' => '여성',
							);
						} else {
							$options = explode("\n", element('options', $value));
						}
						$i =1;
						if ($options) {
							foreach ($options as $okey => $oval) {
								$oval = trim($oval);
								$radiovalue = (element('field_name', $value) === 'mem_sex') ? $okey : $oval;
								$html_content[$k]['input'] .= '<label for="' . element('field_name', $value) . '_' . $i . '"><input type="radio" name="' . element('field_name', $value) . '" id="' . element('field_name', $value) . '_' . $i . '" value="' . $radiovalue . '" ' . set_radio(element('field_name', $value), $radiovalue, ($item === $radiovalue ? true : false)) . ' /> ' . $oval . ' </label> ';
							$i++;
							}
						}
						$html_content[$k]['input'] .= '</div>';
					} elseif (element('field_type', $value) === 'checkbox') {
						$html_content[$k]['input'] .= '<div class="checkbox">';
						$options = explode("\n", element('options', $value));
						$item = json_decode($item, true);
						$i =1;
						if ($options) {
							foreach ($options as $okey => $oval) {
								$oval = trim($oval);
								$chkvalue = is_array($item) && in_array($oval, $item) ? $oval : '';
								$html_content[$k]['input'] .= '<label for="' . element('field_name', $value) . '_' . $i . '"><input type="checkbox" name="' . element('field_name', $value) . '[]" id="' . element('field_name', $value) . '_' . $i . '" value="' . $oval . '" ' . set_checkbox(element('field_name', $value), $oval, ($chkvalue === $oval ? true : false)) . ' /> ' . $oval . ' </label> ';
							$i++;
							}
						}
						$html_content[$k]['input'] .= '</div>';
					} elseif (element('field_type', $value) === 'select') {
						$html_content[$k]['input'] .= '<div class="input-group">';
						$html_content[$k]['input'] .= '<select name="' . element('field_name', $value) . '" class="form-control input" ' . $required . '>';
						$html_content[$k]['input'] .= '<option value="" >선택하세요</option> ';
						$options = explode("\n", element('options', $value));
						if ($options) {
							foreach ($options as $okey => $oval) {
								$oval = trim($oval);
								$html_content[$k]['input'] .= '<option value="' . $oval . '" ' . set_select(element('field_name', $value), $oval, ($item === $oval ? true : false)) . ' >' . $oval . '</option> ';
							}
						}
						$html_content[$k]['input'] .= '</select>';
						$html_content[$k]['input'] .= '</div>';
					} elseif (element('field_name', $value) === 'mem_address') {
						$html_content[$k]['input'] .= '
							<label for="mem_zipcode">우편번호</label>
							<label>
								<input type="text" name="mem_zipcode" value="' . set_value('mem_zipcode', $this->member->item('mem_zipcode')) . '" id="mem_zipcode" class="form-control input" size="7" maxlength="7" ' . $required . ' />
							</label>
							<label>
								<button type="button" class="btn btn-black btn-sm" style="margin-top:0px;" onclick="win_zip(\'fregisterform\', \'mem_zipcode\', \'mem_address1\', \'mem_address2\', \'mem_address3\', \'mem_address4\');">주소 검색</button>
							</label>
							<div class="addr-line mt10">
								<label for="mem_address1">기본주소</label>
								<input type="text" name="mem_address1" value="' . set_value('mem_address1', $this->member->item('mem_address1')) . '" id="mem_address1" class="form-control input" placeholder="기본주소" ' . $required . ' />
							</div>
							<div class="addr-line mt10 ">
								<label for="mem_address2">상세주소</label>
								<input type="text" name="mem_address2" value="' . set_value('mem_address2', $this->member->item('mem_address2')) . '" id="mem_address2" class="form-control input" placeholder="상세주소" ' . $required . ' />
							</div>
							<div class="addr-line mt10 ">
								<label for="mem_address3">참고항목</label>
								<input type="text" name="mem_address3" value="' . set_value('mem_address3', $this->member->item('mem_address3')) . '" id="mem_address3" class="form-control input" readonly="readonly" placeholder="참고항목" />
							</div>
							<input type="hidden" name="mem_address4" value="' . set_value('mem_address4', $this->member->item('mem_address4')) . '" />
						';
					}

					$html_content[$k]['description'] = '';
					if (isset($configbasic[$value['field_name']]['description']) && $configbasic[$value['field_name']]['description']) {
						$html_content[$k]['description'] = $configbasic[$value['field_name']]['description'];
					}
					$k++;
				}
			}

			$view['view']['html_content'] = $html_content;
			$view['view']['open_profile_description'] = '';
			if ($this->cbconfig->item('change_open_profile_date')) {
				if ($can_update_open_profile === false) {
					$view['view']['open_profile_description'] = '정보공개 설정을 변경하시면 ' . $this->cbconfig->item('change_open_profile_date') . '일 이내에는 다시 변경할 수 없습니다<br>회원님은 ' . $when_can_update_open_profile . ' 이후에 정보공개설정변경이 가능합니다';
				} else {
					$view['view']['open_profile_description'] = '정보공개 설정을 변경하시면 ' . $this->cbconfig->item('change_open_profile_date') . '일 이내에는 다시 변경할 수 없습니다';
				}
			}

			$view['view']['use_note_description'] = '';
			if ($this->cbconfig->item('change_use_note_date')) {
				if ($can_update_use_note === false) {
					$view['view']['use_note_description'] = '쪽지 사용 설정을 변경하시면 ' . $this->cbconfig->item('change_use_note_date') . '일 이내에는 다시 변경할 수 없습니다<br>회원님은 ' . $when_can_update_use_note . ' 이후에 쪽지사용설정변경이 가능합니다';
				} else {
					$view['view']['use_note_description'] = '쪽지 사용 설정을 변경하시면 ' . $this->cbconfig->item('change_use_note_date') . '일 이내에는 다시 변경할 수 없습니다';
				}
			}

			$view['view']['canonical'] = site_url('membermodify/modify');

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

			/**
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_membermodify');
			$meta_description = $this->cbconfig->item('site_meta_description_membermodify');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_membermodify');
			$meta_author = $this->cbconfig->item('site_meta_author_membermodify');
			$page_name = $this->cbconfig->item('site_page_name_membermodify');

			$layoutconfig = array(
				'path' => 'mypage',
				'layout' => 'layout',
				'skin' => 'member_modify',
				'layout_dir' => $this->cbconfig->item('layout_mypage'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
				'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
				'skin_dir' => $this->cbconfig->item('skin_mypage'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
				'page_title' => $page_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'meta_author' => $meta_author,
				'page_name' => $page_name,
			);
			$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
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

			$updatedata = array();
			$metadata = array();
			$updatedata['mem_email'] = $this->input->post('mem_email');
			if ($this->member->item('mem_email') !== $this->input->post('mem_email')) {
				$updatedata['mem_email_cert'] = 0;
				$metadata['meta_email_cert_datetime'] = '';
			}
			if ($can_update_nickname
				&& $this->member->item('mem_nickname') !== $this->input->post('mem_nickname')) {
				$updatedata['mem_nickname'] = $this->input->post('mem_nickname');
				$metadata['meta_nickname_datetime'] = cdate('Y-m-d H:i:s');

				$upnick = array(
					'mni_end_datetime' => cdate('Y-m-d H:i:s'),
				);
				$nickwhere = array(
					'mem_id' => $mem_id,
					'mni_nickname' => $this->member->item('mem_nickname'),
				);
				$this->Member_nickname_model->update('', $upnick, $nickwhere);

				$nickinsert = array(
					'mem_id' => $mem_id,
					'mni_nickname' => $this->input->post('mem_nickname'),
					'mni_start_datetime' => cdate('Y-m-d H:i:s'),
				);
				$this->Member_nickname_model->insert($nickinsert);
			}
			if (isset($form['mem_username']['use']) && $form['mem_username']['use']) {
				$updatedata['mem_username'] = $this->input->post('mem_username', null, '');
			}
			if (isset($form['mem_homepage']['use']) && $form['mem_homepage']['use']) {
				$updatedata['mem_homepage'] = $this->input->post('mem_homepage', null, '');
			}
			if (isset($form['mem_phone']['use']) && $form['mem_phone']['use']) {
				$updatedata['mem_phone'] = $this->input->post('mem_phone', null, '');
			}
			if (isset($form['mem_birthday']['use']) && $form['mem_birthday']['use']) {
				$updatedata['mem_birthday'] = $this->input->post('mem_birthday', null, '');
			}
			if (isset($form['mem_sex']['use']) && $form['mem_sex']['use']) {
				$updatedata['mem_sex'] = $this->input->post('mem_sex', null, '');
			}
			if (isset($form['mem_address']['use']) && $form['mem_address']['use']) {
				$updatedata['mem_zipcode'] = $this->input->post('mem_zipcode', null, '');
				$updatedata['mem_address1'] = $this->input->post('mem_address1', null, '');
				$updatedata['mem_address2'] = $this->input->post('mem_address2', null, '');
				$updatedata['mem_address3'] = $this->input->post('mem_address3', null, '');
				$updatedata['mem_address4'] = $this->input->post('mem_address4', null, '');
			}
			$updatedata['mem_receive_email'] = $this->input->post('mem_receive_email') ? 1 : 0;
			if ($this->cbconfig->item('use_note')
				&& $can_update_use_note
				&& (
						($this->member->item('mem_use_note') === '1' && $this->input->post('mem_use_note') !== '1')
						OR
						($this->member->item('mem_use_note') !== '1' && $this->input->post('mem_use_note') === '1')
					)
				) {
				$updatedata['mem_use_note'] = $this->input->post('mem_use_note') ? 1 : 0;
				$metadata['meta_use_note_datetime'] = cdate('Y-m-d H:i:s');
			}
			$updatedata['mem_receive_sms'] = $this->input->post('mem_receive_sms') ? 1 : 0;
			if ($can_update_open_profile
				&& (
						($this->member->item('mem_open_profile') === '1' && $this->input->post('mem_open_profile') !== '1')
						OR
						($this->member->item('mem_open_profile') !== '1' && $this->input->post('mem_open_profile') === '1')
					)
				) {
				$updatedata['mem_open_profile'] = $this->input->post('mem_open_profile') ? 1 : 0;
				$metadata['meta_open_profile_datetime'] = cdate('Y-m-d H:i:s');
			}
			if (isset($form['mem_profile_content']['use']) && $form['mem_profile_content']['use']) {
				$updatedata['mem_profile_content'] = $this->input->post('mem_profile_content', null, '');
			}

			if ($this->input->post('mem_photo_del')) {
				$updatedata['mem_photo'] = '';
			} elseif ($updatephoto) {
				$updatedata['mem_photo'] = $updatephoto;
			}
			if ($this->member->item('mem_photo')
				&& ($this->input->post('mem_photo_del') OR $updatephoto)) {
				// 기존 파일 삭제
				@unlink(config_item('uploads_dir') . '/member_photo/' . $this->member->item('mem_photo'));
			}
			if ($this->input->post('mem_icon_del')) {
				$updatedata['mem_icon'] = '';
			} elseif ($updateicon) {
				$updatedata['mem_icon'] = $updateicon;
			}
			if ($this->member->item('mem_icon')
				&& ($this->input->post('mem_icon_del') OR $updateicon)) {
				// 기존 파일 삭제
				@unlink(config_item('uploads_dir') . '/member_icon/' . $this->member->item('mem_icon'));
			}

			$this->Member_model->update($mem_id, $updatedata);
			$this->Member_meta_model->save($mem_id, $metadata);

			$extradata = array();
			if ($form && is_array($form)) {
				foreach ($form as $key => $value) {
					if ( ! element('use', $value)) {
						continue;
					}
					if (element('func', $value) === 'basic') {
						continue;
					}
					$extradata[element('field_name', $value)] = $this->input->post(element('field_name', $value), null, '');
				}
				$this->Member_extra_vars_model->save($mem_id, $extradata);
			}

			if ($this->cbconfig->item('use_register_email_auth')
				&& $this->member->item('mem_email') !== $this->input->post('mem_email')) {

				$vericode = array('$', '/', '.');
				$verificationcode = str_replace(
					$vericode,
					'',
					password_hash($mem_id . '-' . $this->input->post('mem_email') . '-' . random_string('alnum', 10), PASSWORD_BCRYPT)
				);

				$beforeauthdata = array(
					'mem_id' => $mem_id,
					'mae_type' => 2,
				);
				$this->Member_auth_email_model->delete_where($beforeauthdata);
				$authdata = array(
					'mem_id' => $mem_id,
					'mae_key' => $verificationcode,
					'mae_type' => 2,
					'mae_generate_datetime' => cdate('Y-m-d H:i:s'),
				);
				$this->Member_auth_email_model->insert($authdata);

				$verify_url = site_url('verify/confirmemail?user=' . $this->member->item('mem_userid') . '&code=' . $verificationcode);

				$searchconfig = array(
					'{홈페이지명}',
					'{회사명}',
					'{홈페이지주소}',
					'{회원아이디}',
					'{회원닉네임}',
					'{회원실명}',
					'{회원이메일}',
					'{변경전이메일}',
					'{메일수신여부}',
					'{쪽지수신여부}',
					'{문자수신여부}',
					'{회원아이피}',
					'{메일인증주소}',
				);
				$receive_email = $this->member->item('mem_receive_email') ? '동의' : '거부';
				$receive_note = $this->member->item('mem_use_note') ? '동의' : '거부';
				$receive_sms = $this->member->item('mem_receive_sms') ? '동의' : '거부';
				$replaceconfig = array(
					$this->cbconfig->item('site_title'),
					$this->cbconfig->item('company_name'),
					site_url(),
					$this->member->item('mem_userid'),
					$this->member->item('mem_nickname'),
					$this->member->item('mem_username'),
					$this->input->post('mem_email'),
					$this->member->item('mem_email'),
					$receive_email,
					$receive_note,
					$receive_sms,
					$this->input->ip_address(),
					$verify_url,
				);

				$replaceconfig_escape = array(
					html_escape($this->cbconfig->item('site_title')),
					html_escape($this->cbconfig->item('company_name')),
					site_url(),
					$this->member->item('mem_userid'),
					html_escape($this->member->item('mem_nickname')),
					html_escape($this->member->item('mem_username')),
					html_escape($this->input->post('mem_email')),
					html_escape($this->member->item('mem_email')),
					$receive_email,
					$receive_note,
					$receive_sms,
					$this->input->ip_address(),
					$verify_url,
				);

				$title = str_replace(
					$searchconfig,
					$replaceconfig,
					$this->cbconfig->item('send_email_changeemail_user_title')
				);
				$content = str_replace(
					$searchconfig,
					$replaceconfig_escape,
					$this->cbconfig->item('send_email_changeemail_user_content')
				);

				$this->email->clear(true);
				$this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
				$this->email->to($this->input->post('mem_email'));
				$this->email->subject($title);
				$this->email->message($content);
				$this->email->send();

				$view['view']['result_message'] = $this->input->post('mem_email') . '로 인증메일이 발송되었습니다. <br />발송된 인증메일을 확인하신 후에 사이트 이용이 가능합니다';

				$this->session->sess_destroy();

			} else {
				$view['view']['result_message'] = '회원정보가 변경되었습니다. <br />감사합니다';
			}

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_result_layout'] = Events::trigger('before_result_layout', $eventname);

			$page_title = $this->cbconfig->item('site_meta_title_membermodify');
			$meta_description = $this->cbconfig->item('site_meta_description_membermodify');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_membermodify');
			$meta_author = $this->cbconfig->item('site_meta_author_membermodify');
			$page_name = $this->cbconfig->item('site_page_name_membermodify');

			$layoutconfig = array(
				'path' => 'mypage',
				'layout' => 'layout',
				'skin' => 'member_modify_result',
				'layout_dir' => $this->cbconfig->item('layout_mypage'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
				'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
				'skin_dir' => $this->cbconfig->item('skin_mypage'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
				'page_title' => $page_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'meta_author' => $meta_author,
				'page_name' => $page_name,
			);
			$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}
	}

	/**
	 * 소셜로그인 한 회원의 회원정보 수정 페이지입니다
	 */
	public function defaultinfo()
	{

		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_defaultinfo';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		if ($this->member->item('mem_password')) {
			redirect('membermodify');
		}

		if ( ! function_exists('password_hash')) {
			$this->load->helper('password');
		}

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);


		$password_length = $this->cbconfig->item('password_length');
		$view['view']['password_length'] = $password_length;

		$config = array();

		$config['mem_userid'] = array(
			'field' => 'mem_userid',
			'label' => '아이디',
			'rules' => 'trim|required|alphanumunder|min_length[3]|max_length[20]|is_unique[member_userid.mem_userid]|callback__mem_userid_check',
		);
		$config['mem_password'] = array(
			'field' => 'mem_password',
			'label' => '패스워드',
			'rules' => 'trim|required|min_length[' . $password_length . ']|callback__mem_password_check',
		);
		$config['mem_password_re'] = array(
			'field' => 'mem_password_re',
			'label' => '패스워드 확인',
			'rules' => 'trim|required|min_length[' . $password_length . ']|matches[mem_password]',
		);
		$config['mem_nickname'] = array(
			'field' => 'mem_nickname',
			'label' => '닉네임',
			'rules' => 'trim|required|min_length[2]|max_length[20]|callback__mem_nickname_check',
		);
		$config['mem_email'] = array(
			'field' => 'mem_email',
			'label' => '이메일',
			'rules' => 'trim|required|valid_email|max_length[50]|is_unique[member.mem_email.mem_id.' . $mem_id . ']|callback__mem_email_check',
		);

		$this->load->library(array('form_validation'));

		$this->form_validation->set_rules($config);
		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

			/**
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_membermodify');
			$meta_description = $this->cbconfig->item('site_meta_description_membermodify');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_membermodify');
			$meta_author = $this->cbconfig->item('site_meta_author_membermodify');
			$page_name = $this->cbconfig->item('site_page_name_membermodify');

			$layoutconfig = array(
				'path' => 'mypage',
				'layout' => 'layout',
				'skin' => 'member_defaultinfo',
				'layout_dir' => $this->cbconfig->item('layout_mypage'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
				'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
				'skin_dir' => $this->cbconfig->item('skin_mypage'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
				'page_title' => $page_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'meta_author' => $meta_author,
				'page_name' => $page_name,
			);
			$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
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

			$updatedata = array();
			$metadata = array();

			$updatedata['mem_userid'] = $this->input->post('mem_userid');
			$updatedata['mem_email'] = $this->input->post('mem_email');
			if ($this->member->item('mem_email') !== $this->input->post('mem_email')) {
				$updatedata['mem_email_cert'] = 0;
				$metadata['meta_email_cert_datetime'] = '';
			}

			if ($this->member->item('mem_nickname') !== $this->input->post('mem_nickname')) {
				$updatedata['mem_nickname'] = $this->input->post('mem_nickname');
				$metadata['meta_nickname_datetime'] = cdate('Y-m-d H:i:s');

				$upnick = array(
					'mni_end_datetime' => cdate('Y-m-d H:i:s'),
				);
				$nickwhere = array(
					'mem_id' => $mem_id,
					'mni_nickname' => $this->member->item('mem_nickname'),
				);
				$this->Member_nickname_model->update('', $upnick, $nickwhere);

				$nickinsert = array(
					'mem_id' => $mem_id,
					'mni_nickname' => $this->input->post('mem_nickname'),
					'mni_start_datetime' => cdate('Y-m-d H:i:s'),
				);
				$this->Member_nickname_model->insert($nickinsert);
			}
			$updatedata['mem_password'] = password_hash($this->input->post('mem_password'), PASSWORD_BCRYPT);

			$this->Member_model->update($mem_id, $updatedata);
			$this->Member_meta_model->save($mem_id, $metadata);

			if ($this->cbconfig->item('use_register_email_auth')
				&& $this->member->item('mem_email') !== $this->input->post('mem_email')) {

				$vericode = array('$', '/', '.');
				$verificationcode = str_replace(
					$vericode,
					'',
					password_hash($mem_id . '-' . $this->input->post('mem_email') . '-' . random_string('alnum', 10), PASSWORD_BCRYPT)
				);

				$beforeauthdata = array(
					'mem_id' => $mem_id,
					'mae_type' => 2,
				);
				$this->Member_auth_email_model->delete_where($beforeauthdata);
				$authdata = array(
					'mem_id' => $mem_id,
					'mae_key' => $verificationcode,
					'mae_type' => 2,
					'mae_generate_datetime' => cdate('Y-m-d H:i:s'),
				);
				$this->Member_auth_email_model->insert($authdata);

				$verify_url = site_url('verify/confirmemail?user=' . $this->input->post('mem_userid') . '&code=' . $verificationcode);

				$searchconfig = array(
					'{홈페이지명}',
					'{회사명}',
					'{홈페이지주소}',
					'{회원아이디}',
					'{회원닉네임}',
					'{회원실명}',
					'{회원이메일}',
					'{변경전이메일}',
					'{메일수신여부}',
					'{쪽지수신여부}',
					'{문자수신여부}',
					'{회원아이피}',
					'{메일인증주소}',
				);
				$receive_email = $this->member->item('mem_receive_email') ? '동의' : '거부';
				$receive_note = $this->member->item('mem_use_note') ? '동의' : '거부';
				$receive_sms = $this->member->item('mem_receive_sms') ? '동의' : '거부';
				$replaceconfig = array(
					$this->cbconfig->item('site_title'),
					$this->cbconfig->item('company_name'),
					site_url(),
					$this->member->item('mem_userid'),
					$this->member->item('mem_nickname'),
					$this->member->item('mem_username'),
					$this->input->post('mem_email'),
					$this->member->item('mem_email'),
					$receive_email,
					$receive_note,
					$receive_sms,
					$this->input->ip_address(),
					$verify_url,
				);

				$replaceconfig_escape = array(
					html_escape($this->cbconfig->item('site_title')),
					html_escape($this->cbconfig->item('company_name')),
					site_url(),
					$this->member->item('mem_userid'),
					html_escape($this->member->item('mem_nickname')),
					html_escape($this->member->item('mem_username')),
					html_escape($this->input->post('mem_email')),
					html_escape($this->member->item('mem_email')),
					$receive_email,
					$receive_note,
					$receive_sms,
					$this->input->ip_address(),
					$verify_url,
				);

				$title = str_replace(
					$searchconfig,
					$replaceconfig,
					$this->cbconfig->item('send_email_changeemail_user_title')
				);
				$content = str_replace(
					$searchconfig,
					$replaceconfig_escape,
					$this->cbconfig->item('send_email_changeemail_user_content')
				);

				$this->email->clear(true);
				$this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
				$this->email->to($this->input->post('mem_email'));
				$this->email->subject($title);
				$this->email->message($content);
				$this->email->send();

				$view['view']['result_message'] = $this->input->post('mem_email') . '로 인증메일이 발송되었습니다. <br />발송된 인증메일을 확인하신 후에 사이트 이용이 가능합니다';


			} else {
				$view['view']['result_message'] = '회원정보가 변경되었습니다. <br />감사합니다';
			}

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_result_layout'] = Events::trigger('before_result_layout', $eventname);

			$page_title = $this->cbconfig->item('site_meta_title_membermodify');
			$meta_description = $this->cbconfig->item('site_meta_description_membermodify');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_membermodify');
			$meta_author = $this->cbconfig->item('site_meta_author_membermodify');
			$page_name = $this->cbconfig->item('site_page_name_membermodify');

			$layoutconfig = array(
				'path' => 'mypage',
				'layout' => 'layout',
				'skin' => 'member_modify_result',
				'layout_dir' => $this->cbconfig->item('layout_mypage'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
				'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
				'skin_dir' => $this->cbconfig->item('skin_mypage'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
				'page_title' => $page_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'meta_author' => $meta_author,
				'page_name' => $page_name,
			);
			$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}
	}


	/**
	 * 회원정보 수정중 패스워드 변경 페이지입니다
	 */
	public function password_modify()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_password_modify';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		if ( ! $this->session->userdata('membermodify')) {
			redirect('membermodify');
		}

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		if ( ! function_exists('password_hash')) {
			$this->load->helper('password');
		}

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */

		$password_length = $this->cbconfig->item('password_length');
		$view['view']['password_length'] = $password_length;

		$config = array(
			array(
				'field' => 'cur_password',
				'label' => '현재패스워드',
				'rules' => 'trim|required|callback__cur_password_check',
			),
			array(
				'field' => 'new_password',
				'label' => '새로운패스워드',
				'rules' => 'trim|required|min_length[' . $password_length . ']|callback__mem_password_check',
			),
			array(
				'field' => 'new_password_re',
				'label' => '새로운패스워드',
				'rules' => 'trim|required|min_length[' . $password_length . ']|matches[new_password]',
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

			$view['view']['canonical'] = site_url('membermodify/password_modify');

			$password_description = '비밀번호는 ' . $password_length . '자리 이상이어야 ';
			if ($this->cbconfig->item('password_uppercase_length')
				OR $this->cbconfig->item('password_numbers_length')
				OR $this->cbconfig->item('password_specialchars_length')) {
				$password_description .= '하며 ';
				if ($this->cbconfig->item('password_uppercase_length')) {
					$password_description .= ', ' . $this->cbconfig->item('password_uppercase_length') . '개의 대문자';
				}
				if ($this->cbconfig->item('password_numbers_length')) {
					$password_description .= ', ' . $this->cbconfig->item('password_numbers_length') . '개의 숫자';
				}
				if ($this->cbconfig->item('password_specialchars_length')) {
					$password_description .= ', ' . $this->cbconfig->item('password_specialchars_length') . '개의 특수문자';
				}
				$password_description .= '를 포함해야 ';
			}
			$password_description .= '합니다';

			$view['view']['info'] = $password_description;

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

			/**
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_membermodify');
			$meta_description = $this->cbconfig->item('site_meta_description_membermodify');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_membermodify');
			$meta_author = $this->cbconfig->item('site_meta_author_membermodify');
			$page_name = $this->cbconfig->item('site_page_name_membermodify');

			$layoutconfig = array(
				'path' => 'mypage',
				'layout' => 'layout',
				'skin' => 'password_modify',
				'layout_dir' => $this->cbconfig->item('layout_mypage'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
				'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
				'skin_dir' => $this->cbconfig->item('skin_mypage'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
				'page_title' => $page_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'meta_author' => $meta_author,
				'page_name' => $page_name,
			);
			$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));

		} else {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			$hash = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT);

			$updatedata = array(
				'mem_password' => $hash,
			);
			$this->Member_model->update($mem_id, $updatedata);
			$metadata = array(
				'meta_change_pw_datetime' => cdate('Y-m-d H:i:s'),
			);
			$this->Member_meta_model->save($mem_id, $metadata);


			$emailsendlistadmin = array();
			$notesendlistadmin = array();
			$smssendlistadmin = array();
			$emailsendlistuser = array();
			$notesendlistuser = array();
			$smssendlistuser = array();

			$superadminlist = '';
			if ($this->cbconfig->item('send_email_changepw_admin')
				OR $this->cbconfig->item('send_note_changepw_admin')
				OR $this->cbconfig->item('send_sms_changepw_admin')) {
				$mselect = 'mem_id, mem_email, mem_nickname, mem_phone';
				$superadminlist = $this->Member_model->get_superadmin_list($mselect);
			}
			if ($this->cbconfig->item('send_email_changepw_admin') && $superadminlist) {
				foreach ($superadminlist as $key => $value) {
					$emailsendlistadmin[$value['mem_id']] = $value;
				}
			}
			if (($this->cbconfig->item('send_email_changepw_user') && $this->member->item('mem_receive_email'))
				OR $this->cbconfig->item('send_email_changepw_alluser')) {
				$emailsendlistuser['mem_email'] = $this->member->item('mem_email');
			}
			if ($this->cbconfig->item('send_note_changepw_admin') && $superadminlist) {
				foreach ($superadminlist as $key => $value) {
					$notesendlistadmin[$value['mem_id']] = $value;
				}
			}
			if ($this->cbconfig->item('send_note_changepw_user')
				&& $this->member->item('mem_use_note')) {
				$notesendlistuser['mem_id'] = $mem_id;
			}
			if ($this->cbconfig->item('send_sms_changepw_admin') && $superadminlist) {
				foreach ($superadminlist as $key => $value) {
					$smssendlistadmin[$value['mem_id']] = $value;
				}
			}
			if (($this->cbconfig->item('send_sms_changepw_user') && $this->member->item('mem_receive_sms'))
				OR $this->cbconfig->item('send_sms_changepw_alluser')) {
				if ($this->member->item('mem_phone')) {
					$smssendlistuser['mem_id'] = $mem_id;
					$smssendlistuser['mem_nickname'] = $this->member->item('mem_nickname');
					$smssendlistuser['mem_phone'] = $this->member->item('mem_phone');
				}
			}

			$searchconfig = array(
				'{홈페이지명}',
				'{회사명}',
				'{홈페이지주소}',
				'{회원아이디}',
				'{회원닉네임}',
				'{회원실명}',
				'{회원이메일}',
				'{메일수신여부}',
				'{쪽지수신여부}',
				'{문자수신여부}',
				'{회원아이피}',
			);
			$receive_email = $this->member->item('mem_receive_email') ? '동의' : '거부';
			$receive_note = $this->member->item('mem_use_note') ? '동의' : '거부';
			$receive_sms = $this->member->item('mem_receive_sms') ? '동의' : '거부';
			$replaceconfig = array(
				$this->cbconfig->item('site_title'),
				$this->cbconfig->item('company_name'),
				site_url(),
				$this->member->item('mem_userid'),
				$this->member->item('mem_nickname'),
				$this->member->item('mem_username'),
				$this->member->item('mem_email'),
				$receive_email,
				$receive_note,
				$receive_sms,
				$this->input->ip_address(),
			);
			$replaceconfig_escape = array(
				html_escape($this->cbconfig->item('site_title')),
				html_escape($this->cbconfig->item('company_name')),
				site_url(),
				html_escape($this->member->item('mem_userid')),
				html_escape($this->member->item('mem_nickname')),
				html_escape($this->member->item('mem_username')),
				html_escape($this->member->item('mem_email')),
				$receive_email,
				$receive_note,
				$receive_sms,
				$this->input->ip_address(),
			);
			if ($emailsendlistadmin) {
				$title = str_replace(
					$searchconfig,
					$replaceconfig,
					$this->cbconfig->item('send_email_changepw_admin_title')
				);
				$content = str_replace(
					$searchconfig,
					$replaceconfig_escape,
					$this->cbconfig->item('send_email_changepw_admin_content')
				);
				foreach ($emailsendlistadmin as $akey => $aval) {
					$this->email->clear(true);
					$this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
					$this->email->to(element('mem_email', $aval));
					$this->email->subject($title);
					$this->email->message($content);
					$this->email->send();
				}
			}
			if ($emailsendlistuser) {
				$title = str_replace(
					$searchconfig,
					$replaceconfig,
					$this->cbconfig->item('send_email_changepw_user_title')
				);
				$content = str_replace(
					$searchconfig,
					$replaceconfig_escape,
					$this->cbconfig->item('send_email_changepw_user_content')
				);
				$this->email->clear(true);
				$this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
				$this->email->to(element('mem_email', $emailsendlistuser));
				$this->email->subject($title);
				$this->email->message($content);
				$this->email->send();
			}
			if ($notesendlistadmin) {
				$title = str_replace(
					$searchconfig,
					$replaceconfig,
					$this->cbconfig->item('send_note_changepw_admin_title')
				);
				$content = str_replace(
					$searchconfig,
					$replaceconfig_escape,
					$this->cbconfig->item('send_note_changepw_admin_content')
				);
				foreach ($notesendlistadmin as $akey => $aval) {
					$note_result = $this->notelib->send_note(
						$sender = 0,
						$receiver = element('mem_id', $aval),
						$title,
						$content,
						1
					);
				}
			}
			if ($notesendlistuser && element('mem_id', $notesendlistuser)) {
				$title = str_replace(
					$searchconfig,
					$replaceconfig,
					$this->cbconfig->item('send_note_changepw_user_title')
				);
				$content = str_replace(
					$searchconfig,
					$replaceconfig_escape,
					$this->cbconfig->item('send_note_changepw_user_content')
				);
				$note_result = $this->notelib->send_note(
					$sender = 0,
					$receiver = element('mem_id', $notesendlistuser),
					$title,
					$content,
					1
				);
			}
			if ($smssendlistadmin) {
				if (file_exists(APPPATH . 'libraries/Smslib.php')) {
					$this->load->library(array('smslib'));
					$content = str_replace(
						$searchconfig,
						$replaceconfig,
						$this->cbconfig->item('send_sms_changepw_admin_content')
					);
					$sender = array(
						'phone' => $this->cbconfig->item('sms_admin_phone'),
					);
					$receiver = array();
					foreach ($smssendlistadmin as $akey => $aval) {
						$receiver[] = array(
							'mem_id' => element('mem_id', $aval),
							'name' => element('mem_nickname', $aval),
							'phone' => element('mem_phone', $aval),
						);
					}
					$smsresult = $this->smslib->send($receiver, $sender, $content, $date = '', '회원패스워드변경알림');
				}
			}
			if ($smssendlistuser) {
				if (file_exists(APPPATH . 'libraries/Smslib.php')) {
					$this->load->library(array('smslib'));
					$content = str_replace(
						$searchconfig,
						$replaceconfig,
						$this->cbconfig->item('send_sms_changepw_user_content')
					);
					$sender = array(
						'phone' => $this->cbconfig->item('sms_admin_phone'),
					);
					$receiver = array();
					$receiver[] = $smssendlistuser;
					$smsresult = $this->smslib->send($receiver, $sender, $content, $date = '', '회원패스워드변경알림');
				}
			}


			$view['view']['result_message'] = '회원님의 패스워드가 변경되었습니다';

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_result_layout'] = Events::trigger('before_result_layout', $eventname);

			/**
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_membermodify');
			$meta_description = $this->cbconfig->item('site_meta_description_membermodify');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_membermodify');
			$meta_author = $this->cbconfig->item('site_meta_author_membermodify');
			$page_name = $this->cbconfig->item('site_page_name_membermodify');

			$layoutconfig = array(
				'path' => 'mypage',
				'layout' => 'layout',
				'skin' => 'member_modify_result',
				'layout_dir' => $this->cbconfig->item('layout_mypage'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
				'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
				'skin_dir' => $this->cbconfig->item('skin_mypage'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
				'page_title' => $page_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'meta_author' => $meta_author,
				'page_name' => $page_name,
			);
			$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}
	}


	/**
	 * 회원탈퇴 페이지입니다
	 */
	public function memberleave()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_memberleave';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->library(array('form_validation'));
		$login_fail = false;
		$valid_fail = false;

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'mem_password',
				'label' => '패스워드',
				'rules' => 'trim|required|min_length[4]|callback__cur_password_check',
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
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_membermodify_memberleave');
			$meta_description = $this->cbconfig->item('site_meta_description_membermodify_memberleave');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_membermodify_memberleave');
			$meta_author = $this->cbconfig->item('site_meta_author_membermodify_memberleave');
			$page_name = $this->cbconfig->item('site_page_name_membermodify_memberleave');

			if ($this->member->is_admin() === 'super') {
				$skin = 'member_admin';
			} else {
				$skin = 'memberleave_password';
			}

			$layoutconfig = array(
				'path' => 'mypage',
				'layout' => 'layout',
				'skin' => $skin,
				'layout_dir' => $this->cbconfig->item('layout_mypage'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
				'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
				'skin_dir' => $this->cbconfig->item('skin_mypage'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
				'page_title' => $page_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'meta_author' => $meta_author,
				'page_name' => $page_name,
			);
			$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
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

			$emailsendlistadmin = array();
			$notesendlistadmin = array();
			$smssendlistadmin = array();
			$emailsendlistuser = array();
			$notesendlistuser = array();
			$smssendlistuser = array();

			$superadminlist = '';
			if ($this->cbconfig->item('send_email_memberleave_admin')
				OR $this->cbconfig->item('send_note_memberleave_admin')
				OR $this->cbconfig->item('send_sms_memberleave_admin')) {
				$mselect = 'mem_id, mem_email, mem_nickname, mem_phone';
				$superadminlist = $this->Member_model->get($mselect);
			}

			if ($this->cbconfig->item('send_email_memberleave_admin') && $superadminlist) {
				foreach ($superadminlist as $key => $value) {
					$emailsendlistadmin[$value['mem_id']] = $value;
				}
			}
			if (($this->cbconfig->item('send_email_memberleave_user') && $this->member->item('mem_receive_email'))
				OR $this->cbconfig->item('send_email_memberleave_alluser')) {
				$emailsendlistuser['mem_email'] = $this->member->item('mem_email');
			}
			if ($this->cbconfig->item('send_note_memberleave_admin') && $superadminlist) {
				foreach ($superadminlist as $key => $value) {
					$notesendlistadmin[$value['mem_id']] = $value;
				}
			}
			if ($this->cbconfig->item('send_sms_memberleave_admin') && $superadminlist) {
				foreach ($superadminlist as $key => $value) {
					$smssendlistadmin[$value['mem_id']] = $value;
				}
			}
			if (($this->cbconfig->item('send_sms_memberleave_user') && $this->member->item('mem_receive_sms'))
				OR $this->cbconfig->item('send_sms_memberleave_alluser')) {
				if ($this->member->item('mem_phone')) {
					$smssendlistuser['mem_id'] = $mem_id;
					$smssendlistuser['mem_nickname'] = $this->member->item('mem_nickname');
					$smssendlistuser['mem_phone'] = $this->member->item('mem_phone');
				}
			}

			$searchconfig = array(
				'{홈페이지명}',
				'{회사명}',
				'{홈페이지주소}',
				'{회원아이디}',
				'{회원닉네임}',
				'{회원실명}',
				'{회원이메일}',
				'{메일수신여부}',
				'{쪽지수신여부}',
				'{문자수신여부}',
				'{회원아이피}',
			);
			$receive_email = $this->member->item('mem_receive_email') ? '동의' : '거부';
			$receive_note = $this->member->item('mem_use_note') ? '동의' : '거부';
			$receive_sms = $this->member->item('mem_receive_sms') ? '동의' : '거부';
			$replaceconfig = array(
				$this->cbconfig->item('site_title'),
				$this->cbconfig->item('company_name'),
				site_url(),
				$this->member->item('mem_userid'),
				$this->member->item('mem_nickname'),
				$this->member->item('mem_username'),
				$this->member->item('mem_email'),
				$receive_email,
				$receive_note,
				$receive_sms,
				$this->input->ip_address(),
			);
			$replaceconfig_escape = array(
				html_escape($this->cbconfig->item('site_title')),
				html_escape($this->cbconfig->item('company_name')),
				site_url(),
				html_escape($this->member->item('mem_userid')),
				html_escape($this->member->item('mem_nickname')),
				html_escape($this->member->item('mem_username')),
				html_escape($this->member->item('mem_email')),
				$receive_email,
				$receive_note,
				$receive_sms,
				$this->input->ip_address(),
			);
			if ($emailsendlistadmin) {
				$title = str_replace(
					$searchconfig,
					$replaceconfig,
					$this->cbconfig->item('send_email_memberleave_admin_title')
				);
				$content = str_replace(
					$searchconfig,
					$replaceconfig_escape,
					$this->cbconfig->item('send_email_memberleave_admin_content')
				);
				foreach ($emailsendlistadmin as $akey => $aval) {
					$this->email->clear(true);
					$this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
					$this->email->to(element('mem_email', $aval));
					$this->email->subject($title);
					$this->email->message($content);
					$this->email->send();
				}
			}
			if ($emailsendlistuser) {
				$title = str_replace(
					$searchconfig,
					$replaceconfig,
					$this->cbconfig->item('send_email_memberleave_user_title')
				);
				$content = str_replace(
					$searchconfig,
					$replaceconfig_escape,
					$this->cbconfig->item('send_email_memberleave_user_content')
				);
				$this->email->clear(true);
				$this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
				$this->email->to(element('mem_email', $emailsendlistuser));
				$this->email->subject($title);
				$this->email->message($content);
				$this->email->send();
			}
			if ($notesendlistadmin) {
				$title = str_replace(
					$searchconfig,
					$replaceconfig,
					$this->cbconfig->item('send_note_memberleave_admin_title')
				);
				$content = str_replace(
					$searchconfig,
					$replaceconfig_escape,
					$this->cbconfig->item('send_note_memberleave_admin_content')
				);
				foreach ($notesendlistadmin as $akey => $aval) {
					$note_result = $this->notelib->send_note(
						$sender = 0,
						$receiver = element('mem_id', $aval),
						$title,
						$content,
						1
					);
				}
			}
			if ($smssendlistadmin) {
				if (file_exists(APPPATH . 'libraries/Smslib.php')) {
					$this->load->library(array('smslib'));
					$content = str_replace(
						$searchconfig,
						$replaceconfig,
						$this->cbconfig->item('send_sms_memberleave_admin_content')
					);
					$sender = array(
						'phone' => $this->cbconfig->item('sms_admin_phone'),
					);
					$receiver = array();
					foreach ($smssendlistadmin as $akey => $aval) {
						$receiver[] = array(
							'mem_id' => element('mem_id', $aval),
							'name' => element('mem_nickname', $aval),
							'phone' => element('mem_phone', $aval),
						);
					}
					$smsresult = $this->smslib->send($receiver, $sender, $content, $date = '', '회원탈퇴알림');
				}
			}
			if ($smssendlistuser) {
				if (file_exists(APPPATH . 'libraries/Smslib.php')) {
					$this->load->library(array('smslib'));
					$content = str_replace(
						$searchconfig,
						$replaceconfig,
						$this->cbconfig->item('send_sms_memberleave_user_content')
					);
					$sender = array(
						'phone' => $this->cbconfig->item('sms_admin_phone'),
					);
					$receiver = array();
					$receiver[] = $smssendlistuser;
					$smsresult = $this->smslib->send($receiver, $sender, $content, $date = '', '회원탈퇴알림');
				}
			}

			$this->member->delete_member($mem_id);
			$this->session->sess_destroy();

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

			/**
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_membermodify_memberleave');
			$meta_description = $this->cbconfig->item('site_meta_description_membermodify_memberleave');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_membermodify_memberleave');
			$meta_author = $this->cbconfig->item('site_meta_author_membermodify_memberleave');
			$page_name = $this->cbconfig->item('site_page_name_membermodify_memberleave');

			$layoutconfig = array(
				'path' => 'mypage',
				'layout' => 'layout',
				'skin' => 'memberleave',
				'layout_dir' => $this->cbconfig->item('layout_mypage'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
				'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
				'skin_dir' => $this->cbconfig->item('skin_mypage'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
				'page_title' => $page_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'meta_author' => $meta_author,
				'page_name' => $page_name,
			);
			$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}
	}


	/**
	 * 회원가입시 회원아이디를 체크하는 함수입니다
	 */
	public function _mem_userid_check($str)
	{
		if (preg_match("/[\,]?{$str}/i", $this->cbconfig->item('denied_userid_list'))) {
			$this->form_validation->set_message(
				'_mem_userid_check',
				$str . ' 은(는) 예약어로 사용하실 수 없는 회원아이디입니다'
			);
			return false;
		}
		return true;
	}


	/**
	 * 닉네임체크 함수입니다
	 */
	public function _mem_nickname_check($str)
	{
		if ($str === $this->member->item('mem_nickname')) {
			return true;
		}

		$this->load->helper('chkstring');
		if (chkstring($str, _HANGUL_ + _ALPHABETIC_ + _NUMERIC_) === false) {
			$this->form_validation->set_message(
				'_mem_nickname_check',
				'닉네임은 공백없이 한글, 영문, 숫자만 입력 가능합니다'
			);
			return false;
		}

		if (preg_match("/[\,]?{$str}/i", $this->cbconfig->item('denied_nickname_list'))) {
			$this->form_validation->set_message(
				'_mem_nickname_check',
				$str . ' 은(는) 예약어로 사용하실 수 없는 닉네임입니다'
			);
			return false;
		}
		$countwhere = array(
			'mem_nickname' => $str,
		);
		$row = $this->Member_model->count_by($countwhere);

		if ($row > 0) {
			$this->form_validation->set_message(
				'_mem_nickname_check',
				$str . ' 는 이미 다른 회원이 사용하고 있는 닉네임입니다'
			);
			return false;
		}

		$countwhere = array(
			'mni_nickname' => $str,
		);
		$row = $this->Member_nickname_model->count_by($countwhere);

		if ($row > 0) {
			$this->form_validation->set_message(
				'_mem_nickname_check',
				$str . ' 는 이미 다른 회원이 사용하고 있는 닉네임입니다'
			);
			return false;
		}
		return true;
	}


	/**
	 * 이메일 체크 함수입니다
	 */
	public function _mem_email_check($str)
	{
		list($emailid, $emaildomain) = explode('@', $str);
		$denied_list = explode(',', $this->cbconfig->item('denied_email_list'));
		$emaildomain = trim($emaildomain);
		$denied_list = array_map('trim', $denied_list);
		if (in_array($emaildomain, $denied_list)) {
			$this->form_validation->set_message(
				'_mem_email_check',
				$emaildomain . ' 은(는) 사용하실 수 없는 이메일입니다'
			);
			return false;
		}
		return true;
	}


	/**
	 * 현재 패스워드가 맞는지 체크합니다
	 */
	public function _cur_password_check($str)
	{
		if ( ! function_exists('password_hash')) {
			$this->load->helper('password');
		}

		if ( ! $this->member->item('mem_id') OR ! $this->member->item('mem_password')) {
			$this->form_validation->set_message(
				'_cur_password_check',
				'패스워드가 맞지 않습니다'
			);
			return false;
		} elseif ( ! password_verify($str, $this->member->item('mem_password'))) {
			$this->form_validation->set_message(
				'_cur_password_check',
				'패스워드가 맞지 않습니다'
			);
			return false;
		}
		return true;
	}


	/**
	 * 새로운 패스워드가 환경설정에 정한 글자수를 채웠는지를 체크합니다
	 */
	public function _mem_password_check($str)
	{
		$uppercase = $this->cbconfig->item('password_uppercase_length');
		$number = $this->cbconfig->item('password_numbers_length');
		$specialchar = $this->cbconfig->item('password_specialchars_length');

		$this->load->helper('chkstring');
		$str_uc = count_uppercase($str);
		$str_num = count_numbers($str);
		$str_spc = count_specialchars($str);

		if ($str_uc < $uppercase OR $str_num < $number OR $str_spc < $specialchar) {

			$description = '비밀번호는 ';
			if ($str_uc < $uppercase) {
				$description .= ' ' . $uppercase . '개 이상의 대문자';
			}
			if ($str_num < $number) {
				$description .= ' ' . $number . '개 이상의 숫자';
			}
			if ($str_spc < $specialchar) {
				$description .= ' ' . $specialchar . '개 이상의 특수문자';
			}
			$description .= '를 포함해야 합니다';

			$this->form_validation->set_message(
				'_mem_password_check',
				$description
			);
			return false;
			// $result = array(
			// 	'state' => '0',
			// 	'message' => $description,
			// );
			// exit(json_encode($result));
		}
		return true;
	}
/**
 * 이메일 인증 시작
 */
	public function ajax_modify_email_send() {
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_ajax_modify_email_send';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();
		
		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		// 세션에 기존 인증된 내역 삭제
		$type = $this->input->post('type');
		if($type == 'phone'){
			$this->session->unset_userdata('phone_modify_ath_mail_result');
		}
		if($type == 'password'){
			$this->session->unset_userdata('password_modify_ath_mail_result');
		}
		if($type == 'wallet'){
			$this->session->unset_userdata('wallet_modify_ath_mail_result');
		}

		$rand_num = sprintf('%06d',rand(000000,999999));
		// 로그인한 회원 정보
		$member_info = $this->member->get_member();
		$email = element('mem_email', $member_info);

		// 세션에 인증번호 저장
		if($type == 'phone'){
			$this->session->set_userdata('phone_ath_num', $rand_num);
		}
		if($type == 'password'){
			$this->session->set_userdata('password_ath_num', $rand_num);
		}
		if($type == 'wallet'){
			$this->session->set_userdata('wallet_ath_num', $rand_num);
		}

		// 이메일에 포함될 데이터
		$getdata['rand_num'] = $rand_num;
		$getdata['name'] = $member_info['mem_username'];
		$getdata['site_title'] = $this->cbconfig->item('site_title');
		$getdata['webmaster_email'] = $this->cbconfig->item('webmaster_email');
		$getdata['webmaster_name'] = $this->cbconfig->item('webmaster_name');
		
		// $this->load->library('email');
		$emailform['emailform'] = $getdata;
		$message = $this->load->view('mypage/cic/email_form', $emailform, true);
		$this->email->from(element('webmaster_email', $getdata), element('webmaster_name', $getdata));
		$this->email->to($email);
		if($type == 'phone'){
			$this->email->subject('[CIC Community] 핸드폰번호변경 이메일 인증 안내메일입니다');
		}
		if($type == 'password'){
			$this->email->subject('[CIC Community] 비밀번호변경 이메일 인증 안내메일입니다');
		}
		if($type == 'wallet'){
			$this->email->subject('[CIC Community] 지갑주소변경 이메일 인증 안내메일입니다');
		}
		$this->email->message($message);

		if ($this->email->send() === false) {
			$result = array(
				'state' => '0',
				'message' => '이메일을 발송하지 못하였습니다. 메일 설정을 확인하여주세요',
			);
			exit(json_encode($result));
		} else {
			$result = array(
				'state' => '1',
				'message' => '해당 이메일로 인증 번호를 발송하였습니다',
			);
			exit(json_encode($result));
		}
	}


	public function ajax_modify_ath_mail()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_ajax_modify_ath_mail';
		$this->load->event($eventname);
		
		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$result = array();
		$this->output->set_content_type('application/json');

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		// 인증 진행 타입
		$type = trim($this->input->post('type'));
		// 입력한 인증번호
		$_ath_num = trim($this->input->post('ath_num'));
		
		if (empty($_ath_num)) {
			$result = array(
				'result' => '0',
				'reason' => '인증번호를 입력해주세요',
			);
			exit(json_encode($result));
		}

		// 이메일 발송시 세션에 저장했던 인증번호
		if($type == 'phone'){
			$ath_num = $this->session->userdata('phone_ath_num');
		}
		if($type == 'password'){
			$ath_num = $this->session->userdata('password_ath_num');
		}
		if($type == 'wallet'){
			$ath_num = $this->session->userdata('wallet_ath_num');
		}

		// 세션에 저장한 인증번호 == 입력한 인증번호
		if($ath_num == $_ath_num){
            
			// 핸드폰
			if($type == 'phone'){
				// 인증결과 세션 저장
				$this->session->set_userdata('phone_modify_ath_mail_result', '1');
				// 세션에 저장 되어있던 인증번호 삭제
				$this->session->unset_userdata('phone_ath_num');
                
				$result = array(
					'result' => '1',
					'reason' => '인증 되었습니다',
				);
				exit(json_encode($result));
			}
            
			// 이메일
			if($type == 'password'){
				// 인증결과 세션 저장
				$this->session->set_userdata('password_modify_ath_mail_result', '1');
				// 세션에 저장 되어있던 인증번호 삭제
				$this->session->unset_userdata('password_ath_num');
                
				$result = array(
					'result' => '1',
					'reason' => '인증 되었습니다',
				);
				exit(json_encode($result));
			}
            
			// 지갑
			if($type == 'wallet'){
				// 인증결과 세션 저장
				$this->session->set_userdata('wallet_modify_ath_mail_result', '1');
				// 세션에 저장 되어있던 인증번호 삭제
				$this->session->unset_userdata('wallet_ath_num');
                
				$result = array(
					'result' => '1',
					'reason' => '인증 되었습니다',
				);
				exit(json_encode($result));
			}

		} else{

			// 핸드폰
			if($type == 'phone'){
				$this->session->set_userdata('phone_modify_ath_mail_result', '');

				$result = array(
					'result' => '0',
					'reason' => '인증번호를 확인해주세요',
				);
				exit(json_encode($result));
			}

			// 이메일
			if($type == 'password'){
				$this->session->set_userdata('password_modify_ath_mail_result', '');

				$result = array(
					'result' => '0',
					'reason' => '인증번호를 확인해주세요',
				);
				exit(json_encode($result));
			}
			
			// 지갑
			if($type == 'wallet'){
				$this->session->set_userdata('wallet_modify_ath_mail_result', '');

				$result = array(
					'result' => '0',
					'reason' => '인증번호를 확인해주세요',
				);
				exit(json_encode($result));
			}
		}
		
	}
/**
 * 이메일 인증 끝
 */
/*****************************************************************************/
/**
 * 핸드폰번호변경 시작
 */
	public function ajax_phone_confirm() {
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_ajax_phone_confirm';
		$this->load->event($eventname);
        
		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();
        
		$view = array();
		$view['view'] = array();
        
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
        
		$this->session->set_userdata('phone_confirm', '');
        
		if($this->session->userdata('phone_modify_ath_mail_result') != '1'){
			$result = array(
				'state' => '0',
				'message' => '이메일 인증이 필요합니다',
			);
			exit(json_encode($result));
		}
		
		$new_phone = $this->input->post('new_phone');
		$isPhone = $this->Member_model->get_by_memPhone($new_phone, '');
        
		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');
        
		$config = array(
			array(
				'field' => 'new_phone',
				'label' => '새번호',
				'rules' => 'trim|required|valid_phone',
			),
		);
		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();
        
		if(!$form_validation){
			$result = array(
				'state' => '0',
				'message' => '번호를 정확히 입력해주세요',
			);
			exit(json_encode($result));
		}else{
            
			// if(strlen($new_phone) < 1){
			// 	$result = array(
			// 		'state' => '0',
			// 		'message' => '번호를 입력해주세요',
			// 	);
			// 	exit(json_encode($result));
			// }
			if(count($isPhone) > 0){ // 중복 이면
				$result = array(
					'state' => '0',
					'message' => '이미 사용중인 번호입니다',
				);
				exit(json_encode($result));
			}else{
				
				$this->session->set_userdata('phone_confirm', '1');
				$result = array(
					'state' => '1',
					'message' => '사용 가능한 번호입니다',
				);
				exit(json_encode($result));
			}
		}
	}

/**
 * 핸드폰번호 변경 끝
 */
/*****************************************************************************/
/**
 * 비밀번호변경 시작
 */
	public function ajax_password_confirm() {
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_ajax_password_confirm';
		$this->load->event($eventname);
        
		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();
        
		$view = array();
		$view['view'] = array();
        
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
        
		$this->session->set_userdata('password_confirm', '');
        
		if($this->session->userdata('password_modify_ath_mail_result') != '1'){
			$result = array(
				'state' => '0',
				'message' => '이메일 인증이 필요합니다',
			);
			exit(json_encode($result));
		}
		if($this->session->userdata('password_modify_ath_nice_phone_result') != '1'){
			$result = array(
				'state' => '0',
				'message' => '핸드폰 인증이 필요합니다',
			);
			exit(json_encode($result));
		}
        
		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');
		$password_length = $this->cbconfig->item('password_length');
        
		$config = array(
			array(
				'field' => 'new_password',
				'label' => '새 비밀번호',
				'rules' => 'trim|required|min_length[' . $password_length . ']|callback__mem_password_check',
			),
			array(
				'field' => 'new_password_re',
				'label' => '새 비밀번호 확인',
				'rules' => 'trim|required|min_length[' . $password_length . ']|matches[new_password]',
			),
		);
		// password_description
		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();
        
		if(!$form_validation){
			$result = array(
				'state' => '0',
				'message' => $this->form_validation->error_string(),
			);
			exit(json_encode($result));
		}else{
			$this->session->set_userdata('password_confirm', '1');
            
			$result = array(
				'state' => '1',
				'message' => '사용 가능한 비밀번호입니다',
			);
			exit(json_encode($result));
		}
	}
/**
 * 비밀번호변경 끝
 */
/********************************************************/
/**
 * 지갑주소변경 시작
 */
	public function ajax_wallet_confirm() {
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_ajax_wallet_confirm';
		$this->load->event($eventname);
        
		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();
        
		$view = array();
		$view['view'] = array();
        
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
        
		$this->session->set_userdata('wallet_confirm', '');
        
		if($this->session->userdata('wallet_modify_ath_mail_result') != '1'){
			$result = array(
				'state' => '0',
				'message' => '이메일 인증이 필요합니다',
			);
			exit(json_encode($result));
		}
		if($this->session->userdata('wallet_modify_ath_nice_phone_result') != '1'){
			$result = array(
				'state' => '0',
				'message' => '핸드폰 인증이 필요합니다',
			);
			exit(json_encode($result));
		}
		
		$new_wallet = $this->input->post('new_wallet');
		$isWallet = $this->Member_model->get_by_memWallet($new_wallet, '');
        
		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');
		$password_length = $this->cbconfig->item('password_length');
        
		$config = array(
			array(
				'field' => 'new_wallet',
				'label' => '새 지갑주소',
				'rules' => 'trim|required',
			),
		);
		
		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();
        
		if(!$form_validation){
			$result = array(
				'state' => '0',
				'message' => '지갑주소를 입력해주세요',
			);
			exit(json_encode($result));
		}else{
            
			if(count($isWallet) > 0){ // 중복 이면
				$result = array(
					'state' => '0',
					'message' => '이미 사용중인 지갑주소입니다',
				);
				exit(json_encode($result));
			}else{
                
				$this->session->set_userdata('wallet_confirm', '1');
				$result = array(
					'state' => '1',
					'message' => '등록되었습니다',
				);
				exit(json_encode($result));
			}
		}
	}
/**
* 지갑주소변경 끝
*/
/********************************************************/
/**
 * 휴대폰 인증 시작
 */

	// 비밀번호 변경
	public function password_auth_phone_success(){
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_password_auth_phone_success';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$EncodeData = $this->input->get("EncodeData") ? $this->input->get("EncodeData") : $this->input->post("EncodeData");
		$this->checkplus->success($EncodeData);

		$data = $this->session->userdata('dec_data');
		$DI = $data['dupinfo'];
		
		$isDI = $this->Member_model->get_by_memDI($DI, '');

		if($isDI){ // 중복 이면
			$_DI = $new_phone =  $this->member->item('mem_dup_info');

			if($DI == $_DI){ // 인증완료
				// 인증 결과 저장
				$this->session->set_userdata('password_modify_ath_nice_phone_result', '1');
				// 휴대폰 인증 데이터 삭제
				$this->session->unset_userdata('dec_data');

				echo("<script>");
				echo("alert('핸드폰 인증이 완료되었습니다');"); // 인증완료 문구
				echo("window.opener.successNice('password');"); // 패스워드 변경 폼 생성
				echo("self.close();");
				echo("</script>");
				exit;
			}else{
				// 휴대폰 인증 결과 저장
				$this->session->set_userdata('password_modify_ath_nice_phone_result', '');
				// 휴대폰 인증 데이터 삭제
				$this->session->unset_userdata('dec_data');

				echo("<script>");
				echo("alert('회원가입시 사용한 핸드폰번호를 이용해주세요');"); // 인증완료 문구
				echo("self.close();");
				echo("</script>");
				exit;
			}
		} else {
			// 휴대폰 인증 데이터 삭제
			$this->session->unset_userdata('dec_data');

			echo("<script>alert('인증에 실패하였습니다');</script>");
			echo("<script>self.close()</script>");
		}
	}

	// 지갑주소 변경
	public function wallet_auth_phone_success(){
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_wallet_auth_wallet_success';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$EncodeData = $this->input->get("EncodeData") ? $this->input->get("EncodeData") : $this->input->post("EncodeData");
		$this->checkplus->success($EncodeData);

		$data = $this->session->userdata('dec_data');
		$DI = $data['dupinfo'];
		
		$isDI = $this->Member_model->get_by_memDI($DI, '');

		if($isDI){ // 중복 이면
			$_DI = $new_phone =  $this->member->item('mem_dup_info');

			if($DI == $_DI){ // 인증완료
				// 휴대폰 인증 결과 저장
				$this->session->set_userdata('wallet_modify_ath_nice_phone_result', '1');
				// 휴대폰 인증 데이터 삭제
				$this->session->unset_userdata('dec_data');

				echo("<script>");
				echo("alert('핸드폰 인증이 완료되었습니다');"); // 인증완료 문구
				echo("window.opener.successNice('wallet');"); // 패스워드 변경 폼 생성
				echo("self.close();");
				echo("</script>");
				exit;
			} else{
				// 휴대폰 인증 결과 저장
				$this->session->set_userdata('wallet_modify_ath_nice_phone_result', '');
				// 휴대폰 인증 데이터 삭제
				$this->session->unset_userdata('dec_data');

				echo("<script>");
				echo("alert('회원가입시 사용한 핸드폰번호를 이용해주세요');"); // 인증완료 문구
				echo("self.close();");
				echo("</script>");
				exit;
			}

			
		} else {
			// 휴대폰 인증 데이터 삭제
			$this->session->unset_userdata('dec_data');

			echo("<script>alert('인증에 실패하였습니다');</script>");
			echo("<script>self.close()</script>");
		}
	}

	public function password_auth_phone_fail(){
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_password_auth_phone_fail';
		$this->load->event($eventname);
		$EncodeData = $this->input->get("EncodeData") ? $this->input->get("EncodeData") : $this->input->post("EncodeData");

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();


		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->session->set_userdata('password_modify_ath_nice_phone_result', '');

		if($EncodeData){
			$this->checkplus->fail($EncodeData);

			$mem_id = $this->member->item('mem_id');
			$returnMsg = $this->session->userdata('returnMsg');
			if($returnMsg){
				$data = array(
					'mem_id' => $mem_id,
					'returnMsg' => $returnMsg,
				);
			}else{
				$requestnumber = $this->session->userdata('requestnumber');
				$errcode = $this->session->userdata('errcode');
				$authtype = $this->session->userdata('authtype');
                
				$data = array(
					'mem_id' => $mem_id,
					'requestnumber' => $requestnumber,
					'errcode' => $errcode,
					'authtype' => $authtype,
				);
			}
			
			log_message('error', '======== 비밀번호 변경 폰 인증 Error! Start ========');
			log_message('error', json_encode($data, JSON_UNESCAPED_UNICODE));
			log_message('error', '======== 비밀번호 변경 폰 인증 Error! End ========');
			
			echo("<script>alert('인증에 실패하였습니다!');</script>");
			echo("<script>self.close()</script>");
		} 

		echo("<script>alert('인증에 실패하였습니다!');</script>");
		echo("<script>self.close()</script>");
	}

	public function wallet_auth_phone_fail(){
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_wallet_auth_phone_fail';
		$this->load->event($eventname);
		$EncodeData = $this->input->get("EncodeData") ? $this->input->get("EncodeData") : $this->input->post("EncodeData");

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->session->set_userdata('wallet_modify_ath_nice_phone_result', '');

		if($EncodeData){
			$this->checkplus->fail($EncodeData);

			$mem_id = $this->member->item('mem_id');
			$returnMsg = $this->session->userdata('returnMsg');
			if($returnMsg){
				$data = array(
					'mem_id' => $mem_id,
					'returnMsg' => $returnMsg,
				);
			}else{
				$requestnumber = $this->session->userdata('requestnumber');
				$errcode = $this->session->userdata('errcode');
				$authtype = $this->session->userdata('authtype');
                
				$data = array(
					'mem_id' => $mem_id,
					'requestnumber' => $requestnumber,
					'errcode' => $errcode,
					'authtype' => $authtype,
				);
			}
			
			log_message('error', '======== 지갑주소 변경 폰 인증 Error! Start ========');
			log_message('error', json_encode($data, JSON_UNESCAPED_UNICODE));
			log_message('error', '======== 지갑주소 변경 폰 인증 Error! End ========');
			
			echo("<script>alert('인증에 실패하였습니다!');</script>");
			echo("<script>self.close()</script>");
		} 

		echo("<script>alert('인증에 실패하였습니다!');</script>");
		echo("<script>self.close()</script>");
	}
/**
 * 휴대폰 인증 끝
 */
/********************************************************/

	/**
	 * 회원정보 업데이트
	 */
	public function update() {
		
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_update';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		
		// 인증 결과 세션데이터 가져오기
		$phone_mail_ath_result = $this->session->userdata('phone_modify_ath_mail_result');	// 휴대폰수정 이메일 인증 결과
		$password_mail_ath_result = $this->session->userdata('password_modify_ath_mail_result');// 비밀번호수정 이메일 인증 결과
		$wallet_mail_ath_result = $this->session->userdata('wallet_modify_ath_mail_result');	// 지갑주소수정 이메일 인증 결과
		$password_nice_ath_result = $this->session->userdata('password_modify_ath_nice_phone_result'); // 비밀번호수정 휴대폰 인증 결과
		$wallet_nice_ath_result = $this->session->userdata('wallet_modify_ath_nice_phone_result'); // 지갑주소수정 휴대폰 인증 결과
        
		$phone_validation_result = $this->session->userdata('phone_confirm'); // phone validation 결과
		$password_validation_result = $this->session->userdata('password_confirm'); // password validation 결과
		$wallet_validation_result = $this->session->userdata('wallet_confirm'); // wallet validation 결과

		$mem_id = (int) $this->member->item('mem_id');
		$new_phone =  $this->member->item('mem_phone');
		$new_password =  $this->member->item('mem_password');
		$new_wallet = $this->member->item('mem_wallet_address');

		
		// 수정할 데이터 가져오기
		if($phone_mail_ath_result == '1'
			&& $phone_validation_result == '1'){
			$new_phone = $this->input->post('mem_phone');
		}
		if($password_mail_ath_result == '1'
			&&  $password_nice_ath_result == '1'
				&& $password_validation_result == '1'){
			$new_password = password_hash($this->input->post('mem_password'), PASSWORD_BCRYPT);
			
			// 2021 07 03 구진모 비밀번호 변경시 임시비밀번호를 변경한 사람인지 확인하여 데이터 업데이트
			$this->db->where('mem_id', $mem_id);
			$this->db->where('change_password', 0);
			$this->db->set('change_password', 1);
			$this->db->update('tmp_password');
			// 2021 07 03 구진모 비밀번호 변경시 임시비밀번호를 변경한 사람인지 확인하여 데이터 업데이트 끝
		}
		if($wallet_mail_ath_result == '1'
			&& $wallet_nice_ath_result == '1'
				&& $wallet_validation_result == '1'){
			$new_wallet = $this->input->post('mem_wallet');
		}

		$_post_nickname = $this->input->post('mem_nickname');

		$config[0] = array(
			'field' => 'mem_nickname',
			'label' => '닉네임',
			'rules' => 'trim|required|min_length[2]|max_length[20]|callback__mem_nickname_check',
		);

		$can_update_nickname = false;
		$change_nickname_date = $this->cbconfig->item('change_nickname_date');
		if (empty($change_nickname_date)) {
			$can_update_nickname = true;
		} elseif (strtotime($this->member->item('meta_nickname_datetime')) < ctimestamp() - $change_nickname_date * 86400) {
			$can_update_nickname = true;
		}

		$_change_nickname = false;

		$_origin_nickname = $this->member->item('mem_nickname');
		if(strcmp($_post_nickname, $_origin_nickname)){
			$_change_nickname = true;
		}

		$_do_change = true;
		if($_change_nickname){
			$_do_change = $can_update_nickname ? true : false;
		}
		
		$this->load->library(array('form_validation'));
		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();

		if($form_validation && $_do_change){
			$data = array(
				'mem_wallet_address' => $new_wallet,
				// 'mem_wallet_address' => '123123123',
			);
	
	
			$arr = array(
				'mem_phone' => $new_phone,
				'mem_password' => $new_password,
			);
			if($_change_nickname){
				$arr['mem_nickname'] = $_post_nickname;
				$metadata['meta_nickname_datetime'] = cdate('Y-m-d H:i:s');
				$this->Member_meta_model->save($mem_id, $metadata);
			}
	
			$this->Member_extra_vars_model->save($mem_id, $data); // memo: return 값이 없다
			$result = $this->Member_model->set_user_modify($mem_id, $arr);
	
			// 세션데이터 지우기
			$this->session->unset_userdata('phone_modify_ath_mail_result');
			$this->session->unset_userdata('password_modify_ath_mail_result');
			$this->session->unset_userdata('wallet_modify_ath_mail_result');
			$this->session->unset_userdata('password_modify_ath_nice_phone_result');
			$this->session->unset_userdata('wallet_modify_ath_nice_phone_result');
			$this->session->unset_userdata('phone_confirm');
			$this->session->unset_userdata('password_confirm');
			$this->session->unset_userdata('wallet_confirm');
			if($result == 1){
				$this->session->set_userdata(
					'membermodify',
					''
				);			
				$this->session->set_flashdata('message', '정보수정이 완료되었습니다');
				redirect('mypage');
			}
		}else{
			$_err_message = $this->form_validation->error_string();
			print_r($this->input->post());
			exit;
			echo("<script>alert(`".$_err_message."`);</script>");
			redirect('membermodify/modify');
		}

	}

	/**
	 * 회원탈퇴
	 */
	public function userdelete()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_membermodify_userdelete';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 회원 삭제를 실행합니다
		 */
		$mem_id = (int) $this->member->item('mem_id');
		$this->member->delete_member($mem_id);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('after', $eventname);

		/**
		 * 삭제가 끝난 후 메인페이지로 이동됩니다
		 */
		// echo ("<script>alert('');</script>");
		redirect('/');
	}
}
