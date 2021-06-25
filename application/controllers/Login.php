<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Login class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 로그인 페이지와 관련된 controller 입니다.
 */
class Login extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array();

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
		$this->load->library(array('checkplus'));


	}


	/**
	 * 로그인 페이지입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_login_index';
		$this->load->event($eventname);

		if ($this->member->is_member() !== false && ! ($this->member->is_admin() === 'super' && $this->uri->segment(1) === config_item('uri_segment_admin'))) {
			redirect();
		}

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$view['view']['id_enc_data'] = $this->checkplus->main('login', 'find_id_auth_phone_success', 'find_id_auth_phone_fail');
		$view['view']['pw_enc_data'] = $this->checkplus->main('login', 'find_pw_auth_phone_success', 'find_pw_auth_phone_fail');
		// $view['view']['dec_data'] = $this->session->userdata('dec_data');

		$this->load->library(array('form_validation'));

		if ( ! function_exists('password_hash')) {
			$this->load->helper('password');
		}

		$use_login_account = $this->cbconfig->item('use_login_account');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		if ($use_login_account === 'both') {
			$config[] = array(
				'field' => 'mem_userid',
				'label' => '아이디 또는 이메일',
				'rules' => 'trim|required',
			);
			$view['view']['userid_label_text'] = '아이디 또는 이메일';
		} elseif ($use_login_account === 'email') {
			$config[] = array(
				'field' => 'mem_userid',
				'label' => '이메일',
				'rules' => 'trim|required|valid_email',
			);
			$view['view']['userid_label_text'] = '이메일';
		} else {
			$config[] = array(
				'field' => 'mem_userid',
				'label' => '아이디',
				'rules' => 'trim|required|alphanumunder|min_length[3]|max_length[20]',
			);
			$view['view']['userid_label_text'] = '아이디';
		}
		$config[] = array(
			'field' => 'mem_password',
			'label' => '패스워드',
			'rules' => 'trim|required|min_length[4]|callback__check_id_pw[' . $this->input->post('mem_userid') . ']',
		);

		$this->form_validation->set_rules($config);
		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);
			if ($this->input->post('returnurl')) {
				if (validation_errors('<div class="alert alert-warning" role="alert">', '</div>')) {
					$this->session->set_flashdata(
						'loginvalidationmessage',
						validation_errors('<div class="alert alert-warning" role="alert">', '</div>')
					);
				}
				$this->session->set_flashdata(
					'loginuserid',
					$this->input->post('mem_userid')
				);
				redirect(urldecode($this->input->post('returnurl')));
			}

			$view['view']['canonical'] = site_url('login');

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

			/**
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_login');
			$meta_description = $this->cbconfig->item('site_meta_description_login');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_login');
			$meta_author = $this->cbconfig->item('site_meta_author_login');
			$page_name = $this->cbconfig->item('site_page_name_login');

			$layoutconfig = array(
				'path' => 'login',
				'layout' => 'layout',
				'skin' => 'login',
				'layout_dir' => $this->cbconfig->item('layout_login'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_login'),
				'use_sidebar' => $this->cbconfig->item('sidebar_login'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_login'),
				'skin_dir' => $this->cbconfig->item('skin_login'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_login'),
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

			if ($use_login_account === 'both') {
				$userinfo = $this->Member_model->get_by_both($this->input->post('mem_userid'), 'mem_id, mem_userid');
			} elseif ($use_login_account === 'email') {
				$userinfo = $this->Member_model->get_by_email($this->input->post('mem_userid'), 'mem_id, mem_userid');
			} else {
				$userinfo = $this->Member_model->get_by_userid($this->input->post('mem_userid'), 'mem_id, mem_userid');
			}
			$this->member->update_login_log(element('mem_id', $userinfo), $this->input->post('mem_userid'), 1, '로그인 성공');
			$this->session->set_userdata(
				'mem_id',
				element('mem_id', $userinfo)
			);

			if ($this->input->post('autologin')) {
				$vericode = array('$', '/', '.');
				$hash = str_replace(
					$vericode,
					'',
					password_hash(random_string('alnum', 10) . element('mem_id', $userinfo) . ctimestamp() . element('mem_userid', $userinfo), PASSWORD_BCRYPT)
				);
				$insertautologin = array(
					'mem_id' => element('mem_id', $userinfo),
					'aul_key' => $hash,
					'aul_ip' => $this->input->ip_address(),
					'aul_datetime' => cdate('Y-m-d H:i:s'),
				);
				$this->load->model(array('Autologin_model'));
				$this->Autologin_model->insert($insertautologin);

				$cookie_name = 'autologin';
				$cookie_value = $hash;
				$cookie_expire = 2592000; // 30일간 저장
				set_cookie($cookie_name, $cookie_value, $cookie_expire);
			}

			$change_password_date = $this->cbconfig->item('change_password_date');
			$site_title = $this->cbconfig->item('site_title');
			if ($change_password_date) {

				$meta_change_pw_datetime = $this->member->item('meta_change_pw_datetime');
				if ( ctimestamp() - strtotime($meta_change_pw_datetime) > $change_password_date * 86400) {
					$this->session->set_userdata(
						'membermodify',
						'1'
					);
					$this->session->set_flashdata(
						'message',
						html_escape($site_title) . ' 은(는) 회원님의 비밀번호를 주기적으로 변경하도록 권장합니다.
						<br /> 오래된 비밀번호를 사용중인 회원님께서는 안전한 서비스 이용을 위해 비밀번호 변경을 권장합니다'
					);
					redirect('membermodify/password_modify');
				}
			}

			$url_after_login = $this->cbconfig->item('url_after_login');
			if ($url_after_login) {
				$url_after_login = site_url($url_after_login);
			}
			if (empty($url_after_login)) {
				$url_after_login = $this->input->get_post('url') ? urldecode($this->input->get_post('url')) : site_url();
			}

			//admin이 아닌 경우
			if(! $this->member->is_admin( element('mem_id', $userinfo) ) ){	
				//로그인시 CP, VP 설정에 따라 포인트 지급하자
				$this->load->model(array('CIC_vp_config_model', 'CIC_cp_config_model', 'CIC_vp_model', 'CIC_cp_model'));
				$_vpConfig = $this->CIC_vp_config_model->get_one('','',"vpc_id = 3 AND vpc_enable = 1 AND vpc_value > 0");
				$_cpConfig = $this->CIC_cp_config_model->get_one('','',"cpc_id = 3 AND cpc_enable = 1 AND cpc_value > 0");
				//VP 설정이 있는경우 로그인시 VP 지급
				if($_vpConfig){
					$this->point->insert_vp(
						element('mem_id', $userinfo),
						element('vpc_value', $_vpConfig),
						'로그인 VP 지급',
						'login',
						1,
						'로그인 보상 VP 지급'
					);
				}

				//CP 설정이 있는경우 로그인시 VP 지급
				if($_cpConfig){
					$this->point->insert_cp(
						element('mem_id', $userinfo),
						element('cpc_value', $_cpConfig),
						'로그인 CP 지급',
						'login',
						1,
						'로그인 보상 CP 지급'
					);
				}
				
				if($this->member->item('mem_warn_1')){
					alert(
						'1차 경고를 받았습니다. 경고 2회 누적시 영구정지처리됩니다. 경고 사유: '.$this->member->item('mem_warn_1')
					);
				}
			} 


			// 이벤트가 존재하면 실행합니다
			Events::trigger('after', $eventname);

			redirect($url_after_login);
		}
	}


	/**
	 * 로그인시 아이디와 패스워드가 일치하는지 체크합니다
	 */
	public function _check_id_pw($password, $userid)
	{
		 if ( ! function_exists('password_hash')) {
			$this->load->helper('password');
		}

		$max_login_try_count = (int) $this->cbconfig->item('max_login_try_count');
		$max_login_try_limit_second = (int) $this->cbconfig->item('max_login_try_limit_second');

		$loginfailnum = 0;
		$loginfailmessage = '';
		if ($max_login_try_count && $max_login_try_limit_second) {
			$select = 'mll_id, mll_success, mem_id, mll_ip, mll_datetime';
			$where = array(
				'mll_ip' => $this->input->ip_address(),
				'mll_datetime > ' => strtotime(ctimestamp() - 86400 * 30),
			);
			$this->load->model('Member_login_log_model');
			$logindata = $this->Member_login_log_model
				->get('', $select, $where, '', '', 'mll_id', 'DESC');

			if ($logindata && is_array($logindata)) {
				foreach ($logindata as $key => $val) {
					if ((int) $val['mll_success'] === 0) {
						$loginfailnum++;
					} elseif ((int) $val['mll_success'] === 1) {
						break;
					}
				}
			}
			if ($loginfailnum > 0 && $loginfailnum % $max_login_try_count === 0) {
				$lastlogintrydatetime = $logindata[0]['mll_datetime'];
				$next_login = strtotime($lastlogintrydatetime)
					+ $max_login_try_limit_second
					- ctimestamp();
				if ($next_login > 0) {
					$this->form_validation->set_message(
						'_check_id_pw',
						'회원님은 패스워드를 연속으로 ' . $loginfailnum . '회 잘못 입력하셨기 때문에 '
						. $next_login . '초 후에 다시 로그인 시도가 가능합니다'
					);
					return false;
				}
			}
			$loginfailmessage = '\n회원님은 ' . ($loginfailnum + 1)
				. '회 연속으로 패스워드를 잘못입력하셨습니다. ';
		}

		$use_login_account = $this->cbconfig->item('use_login_account');

		$this->load->model(array('Member_dormant_model'));

		$userselect = 'mem_id, mem_password, mem_denied, mem_email_cert, mem_is_admin';
		$is_dormant_member = false;
		if ($use_login_account === 'both') {
			$userinfo = $this->Member_model->get_by_both($userid, $userselect);
			if ( ! $userinfo) {
				$userinfo = $this->Member_dormant_model->get_by_both($userid, $userselect);
				if ($userinfo) {
					$is_dormant_member = true;
				}
			}
		} elseif ($use_login_account === 'email') {
			$userinfo = $this->Member_model->get_by_email($userid, $userselect);
			if ( ! $userinfo) {
				$userinfo = $this->Member_dormant_model->get_by_email($userid, $userselect);
				if ($userinfo) {
					$is_dormant_member = true;
				}
			}
		} else {
			$userinfo = $this->Member_model->get_by_userid($userid, $userselect);
			if ( ! $userinfo) {
				$userinfo = $this->Member_dormant_model->get_by_userid($userid, $userselect);
				if ($userinfo) {
					$is_dormant_member = true;
				}
			}
		}
		$hash = password_hash($password, PASSWORD_BCRYPT);

		if ( ! element('mem_id', $userinfo) OR ! element('mem_password', $userinfo)) {
			$this->form_validation->set_message(
				'_check_id_pw',
				'회원 아이디와 패스워드가 서로 맞지 않습니다' . $loginfailmessage
			);
			$this->member->update_login_log(0, $userid, 0, '회원 아이디가 존재하지 않습니다');
			return false;
		} elseif ( ! password_verify($password, element('mem_password', $userinfo))) {
			$this->form_validation->set_message(
				'_check_id_pw',
				'회원 아이디와 패스워드가 서로 맞지 않습니다' . $loginfailmessage
			);
			$this->member->update_login_log(element('mem_id', $userinfo), $userid, 0, '패스워드가 올바르지 않습니다');
			return false;
		} elseif (element('mem_denied', $userinfo)) {
			$this->form_validation->set_message(
				'_check_id_pw',
				'회원님의 아이디는 접근이 금지된 아이디입니다'
			);
			$this->member->update_login_log(element('mem_id', $userinfo), $userid, 0, '접근이 금지된 아이디입니다');
			return false;
		} elseif ($this->cbconfig->item('use_register_email_auth') && ! element('mem_email_cert', $userinfo)) {
			$this->form_validation->set_message(
				'_check_id_pw',
				'회원님은 아직 이메일 인증을 받지 않으셨습니다'
			);
			$this->member->update_login_log(element('mem_id', $userinfo), $userid, 0, '이메일 인증을 받지 않은 회원아이디입니다');
			return false;
		} elseif (element('mem_is_admin', $userinfo) && $this->input->post('autologin')) {
			$this->form_validation->set_message(
				'_check_id_pw',
				'최고관리자는 자동로그인 기능을 사용할 수 없습니다'
			);
			return false;
		}

		if ($is_dormant_member === true) {
			$this->member->recover_from_dormant(element('mem_id', $userinfo));
		}

		return true;
	}


	/**
	 * 로그아웃합니다
	 */
	public function logout()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_logout_index';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);
		
		if ($this->member->is_member() === false) {
			redirect();
		}


		$where = array(
			'mem_id' => $this->member->item('mem_id'),
		);
		$this->load->model(array('Autologin_model'));
		$this->Autologin_model->delete_where($where);

		delete_cookie('autologin');

		$this->session->sess_destroy();
		$url_after_logout = $this->cbconfig->item('url_after_logout');
		if ($url_after_logout) {
			$url_after_logout = site_url($url_after_logout);
		}
		if (empty($url_after_logout)) {
			$url_after_logout = $this->input->get_post('url') ? $this->input->get_post('url') : site_url();
		}

		// 이벤트가 존재하면 실행합니다
		Events::trigger('after', $eventname);

		redirect($url_after_logout, 'refresh');
	}

	/**
	 * 아이디 찾기 시작
	 */
	public function find_id_auth_phone_success(){
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_login_find_id_auth_phone_success';
		$this->load->event($eventname);

		
		
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		
		$EncodeData = $this->input->get("EncodeData") ? $this->input->get("EncodeData") : $this->input->post("EncodeData");
		$this->checkplus->success($EncodeData);
		
		$data = $this->session->userdata('dec_data');
		$DI = $data['dupinfo'];
		
		$isDI = $this->Member_model->get_by_memDI($DI, '');
		
		if($isDI){ // 중복 이면 인증완료
			$_DI = $new_phone = $isDI['mem_dup_info'];

			if($DI == $_DI){ // 인증완료
				// 인증 결과 저장
				// $this->session->set_userdata('find_id_auth_phone_result', '1');
				// 휴대폰 인증 데이터 삭제
				$this->session->unset_userdata('dec_data');
				
				echo("<script>");
				echo("alert('핸드폰 인증이 완료되었습니다');"); // 인증완료 문구
				echo("window.opener.document.getElementById('find_id').innerText = '".$isDI['mem_email']."';"); // 인증완료 문구
				echo("var id_modal = window.opener.document.getElementById('myModal_id');");
				echo("id_modal.setAttribute('style', 'z-index:1500; display:block;');");
				echo("self.close();");
				echo("</script>");
				exit;
			}else{
				// 휴대폰 인증 결과 저장
				// $this->session->set_userdata('find_id_auth_phone_result', '');
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

			echo("<script>alert('회원가입된 아이디가 없습니다.');</script>");
			echo("<script>self.close()</script>");
		}
	}

	public function find_id_auth_phone_fail(){
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_login_find_id_auth_phone_fail';
		$this->load->event($eventname);
		$EncodeData = $this->input->get("EncodeData") ? $this->input->get("EncodeData") : $this->input->post("EncodeData");

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		// $this->session->set_userdata('find_id_auth_phone_result', '');

		if($EncodeData){
			$this->checkplus->fail($EncodeData);

			$returnMsg = $this->session->userdata('returnMsg');
			if($returnMsg){
				$data = array('returnMsg' => $returnMsg);
			}else{
				$requestnumber = $this->session->userdata('requestnumber');
				$errcode = $this->session->userdata('errcode');
				$authtype = $this->session->userdata('authtype');
                
				$data = array(
					'requestnumber' => $requestnumber,
					'errcode' => $errcode,
					'authtype' => $authtype,
				);
			}
			
			log_message('error', '======== 아이디찾기 폰 인증 Error! Start ========');
			log_message('error', json_encode($data, JSON_UNESCAPED_UNICODE));
			log_message('error', '======== 아이디찾기 폰 인증 Error! End ========');
			
			echo("<script>alert('인증에 실패하였습니다!');</script>");
			echo("<script>self.close()</script>");
		} 

		echo("<script>alert('인증에 실패하였습니다!');</script>");
		echo("<script>self.close()</script>");
	}
	/**
	 * 아이디 찾기 끝
	 */

	/**
	 * 비밀번호 찾기 시작
	 */
	public function find_pw_auth_phone_success(){
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_login_find_pw_auth_phone_success';
		$this->load->event($eventname);
		
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		
		$EncodeData = $this->input->get("EncodeData") ? $this->input->get("EncodeData") : $this->input->post("EncodeData");
		$this->checkplus->success($EncodeData);
		
		$data = $this->session->userdata('dec_data');
		$DI = $data['dupinfo'];
		
		$isDI = $this->Member_model->get_by_memDI($DI, '');

		$email = $isDI['mem_email'];
		$id = $isDI['mem_id'];
		$name = $isDI['mem_username'];
		
		if($isDI){ // 중복 이면 인증완료
			$_DI = $new_phone = $isDI['mem_dup_info'];

			if($DI == $_DI){ // 인증완료
				// 인증 결과 저장
				$this->session->set_userdata('find_pw_auth_phone_result', '1');
				$this->session->set_userdata('email', $email);
				// 휴대폰 인증 데이터 삭제
				$this->session->unset_userdata('dec_data');
				
				echo("<script>");
				echo("alert('핸드폰 인증이 완료되었습니다');"); // 인증완료 문구
				echo("window.opener.send_email('".$id."', '".$name."');"); // 이메일 전송 실행
				echo("self.close();");
				echo("</script>");
				exit;
			}else{
				// 휴대폰 인증 결과 저장
				$this->session->set_userdata('find_pw_auth_phone_result', '');
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

	public function find_pw_auth_phone_fail(){
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_login_find_pw_auth_phone_fail';
		$this->load->event($eventname);
		$EncodeData = $this->input->get("EncodeData") ? $this->input->get("EncodeData") : $this->input->post("EncodeData");

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		// $this->session->set_userdata('find_pw_auth_phone_result', '');

		if($EncodeData){
			$this->checkplus->fail($EncodeData);

			$returnMsg = $this->session->userdata('returnMsg');
			if($returnMsg){
				$data = array('returnMsg' => $returnMsg);
			}else{
				$requestnumber = $this->session->userdata('requestnumber');
				$errcode = $this->session->userdata('errcode');
				$authtype = $this->session->userdata('authtype');
                
				$data = array(
					'requestnumber' => $requestnumber,
					'errcode' => $errcode,
					'authtype' => $authtype,
				);
			}
			
			log_message('error', '======== 비번찾기 폰 인증 Error! Start ========');
			log_message('error', json_encode($data, JSON_UNESCAPED_UNICODE));
			log_message('error', '======== 비번찾기 폰 인증 Error! End ========');
			
			echo("<script>alert('인증에 실패하였습니다!');</script>");
			echo("<script>self.close()</script>");
		} 

		echo("<script>alert('인증에 실패하였습니다!');</script>");
		echo("<script>self.close()</script>");
	}
	/**
	 * 비밀번호 찾기 끝
	 */

	/**
	 * 이메일 전송 시작
	 */
	public function ajax_imsh_pw_email_send() {
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_login_ajax_imsh_pw_email_send';
		$this->load->event($eventname);
		
		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$id = $this->input->post('id');
		$email = $this->input->post('email');
		$name = $this->input->post('name');

		if($email !== $this->session->userdata('email')){
			$this->session->unset_userdata('email');
			exit;
		}
		// 비밀번호 찾기 이메일 전송을 위한, 핸드폰인증 여부 확인
		$isMobileAth = $this->session->userdata('find_pw_auth_phone_result');

		// 임시 비밀번호 생성
		$timestamp = $this->getMillisecond();
		$cc32 = base_convert($timestamp, 10, 32);
		$imPw = $cc32.''.'@';

		// => 비밀번호 변경 시작
		$new_password = password_hash($imPw, PASSWORD_BCRYPT);
		$arr = array(
			'mem_password' => $new_password,
		);
		$result = $this->Member_model->set_user_modify($id, $arr);
        
		if($result == 0){
			$result = array(
				'state' => '0',
				'message' => '이메일을 발송하지 못하였습니다. (관리자 문의)',
			);
			exit(json_encode($result));
		}
		// => 비밀번호 변경 끝

		// 이메일에 포함될 데이터
		$getdata['imPw'] = $imPw;
		$getdata['name'] = $name;
		$getdata['site_title'] = $this->cbconfig->item('site_title');
		$getdata['webmaster_email'] = $this->cbconfig->item('webmaster_email');
		$getdata['webmaster_name'] = $this->cbconfig->item('webmaster_name');
		
		$this->load->library('email');
		$emailform['emailform'] = $getdata;
		$message = $this->load->view('login/cic/email_form', $emailform, true);
		$this->email->from(element('webmaster_email', $getdata), element('webmaster_name', $getdata));
		$this->email->to($email);
		$this->email->subject('[CIC Community] 비밀번호 찾기 안내메일입니다');
        
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
				'message' => '해당 이메일로 임시 비밀번호를 발송하였습니다',
			);
			exit(json_encode($result));
		}
	}

	private function getMillisecond()
	{
		list($microtime,$timestamp) = explode(' ',microtime());
		$time = $timestamp.substr($microtime, 2, 3);
		
		return $time;
	}
	/**
	 * 이메일 전송 끝
	 */
}
