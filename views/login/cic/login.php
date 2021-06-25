<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/modal.css'); ?>
<div id="container-wrap" class="login-bg">
	<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="member-wrap login">
			<?php 
				echo show_alert_message(trim(validation_errors(' ', ' ')), '<script>alert("', '");</script>');
				$attributes = array('class' => 'form-horizontal', 'name' => 'flogin', 'id' => 'flogin');
				echo form_open(current_full_url(), $attributes); 
			?>
			<input type="hidden" name="url" value="<?php echo html_escape($this->input->get_post('url')); ?>" />
			<h3>CIC COMMUNITY <br>LOGIN</h3>
			<div class="entry">
				<ul>
					<li>
						<p class="chk-input">
							<input type="text" id="mem_userid" name="mem_userid"
								value="<?php echo set_value('mem_userid'); ?>" accesskey="L" placeholder="Email" autocomplete="off" onkeypress="loginEnter(event)">
						</p>
					</li>
					<li>
						<p class="chk-input">
							<input type="password" id="mem_password" name="mem_password" placeholder="PASSWORD" autocomplete="off" onkeypress="loginEnter(event)">
						</p>
					</li>
				</ul>
			</div>
			<!-- 만일 소셜 로그인을 사용하게 된다면 -->
			<?php
			if ($this->cbconfig->item('use_sociallogin')) {
				$this->managelayout->add_js(base_url('assets/js/social_login.js'));
			?>
			<div class="form-group mt30 form-horizontal">
				<label class="col-lg-4 control-label">소셜로그인</label>
				<div class="col-lg-7">
					<?php if ($this->cbconfig->item('use_sociallogin_facebook')) {?>
					<a href="javascript:;" onClick="social_connect_on('facebook');" title="페이스북 로그인"><img
							src="<?php echo base_url('assets/images/social_facebook.png'); ?>" width="22" height="22"
							alt="페이스북 로그인" title="페이스북 로그인" /></a>
					<?php } ?>
					<?php if ($this->cbconfig->item('use_sociallogin_twitter')) {?>
					<a href="javascript:;" onClick="social_connect_on('twitter');" title="트위터 로그인"><img
							src="<?php echo base_url('assets/images/social_twitter.png'); ?>" width="22" height="22"
							alt="트위터 로그인" title="트위터 로그인" /></a>
					<?php } ?>
					<?php if ($this->cbconfig->item('use_sociallogin_google')) {?>
					<a href="javascript:;" onClick="social_connect_on('google');" title="구글 로그인"><img
							src="<?php echo base_url('assets/images/social_google.png'); ?>" width="22" height="22"
							alt="구글 로그인" title="구글 로그인" /></a>
					<?php } ?>
					<?php if ($this->cbconfig->item('use_sociallogin_naver')) {?>
					<a href="javascript:;" onClick="social_connect_on('naver');" title="네이버 로그인"><img
							src="<?php echo base_url('assets/images/social_naver.png'); ?>" width="22" height="22"
							alt="네이버 로그인" title="네이버 로그인" /></a>
					<?php } ?>
					<?php if ($this->cbconfig->item('use_sociallogin_kakao')) {?>
					<a href="javascript:;" onClick="social_connect_on('kakao');" title="카카오 로그인"><img
							src="<?php echo base_url('assets/images/social_kakao.png'); ?>" width="22" height="22"
							alt="카카오 로그인" title="카카오 로그인" /></a>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
			<!-- 여기에 소셜로그인을 등록!! -->
			<button type="submit" class="login-btn"><span>SIGN IN</span></button>
			<?php echo form_close(); ?>
			<div class="other">
				<ul>
					<li>
						<form name="form_chk1" action="post" id="id_form_chk">
							<p>* 아이디를 잊어버렸나요?</p>
							<input type="hidden" name="m" value="checkplusService">
							<input type="hidden" name="EncodeData" value="<?php echo html_escape(element('id_enc_data', $view)); ?>">
							<a href="javascript:fnPopup1();" id="idModal" class="modify-btn"><span>아이디 찾기</span></a>
						</form>
					</li>
					<li>
						<p>* 비밀번호를 잊어버렸나요? </p>
						<a id="pwdModal"><span>비밀번호 찾기</span></a>
					</li>
				</ul>
			</div>

		</div>
		<!-- page end // -->
	</div>
</div>

<!--아이디 Modal Start-->
	<div id="myModal_id" class="modal" style="z-index:1500;">
		<div class="modal-content" style="z-index:1550;">
			<!-- 휴대전화 번호 인증 후 화면 -->
			<p class="chk-input">회원님의 아이디는 <b id="find_id" style="font-size:20px"></b> 입니다.</p>
		</div>
	</div>
<!--아이디 Modal End -->

<!--비밀번호 Modal Start-->
<div id="myModal_pwd" class="modal" style="z-index:1500;">
	<div class="modal-content" style="z-index:1550;">
		<ul class="entry modify-box">
			<li class="ath-email-content">
				<p class="btxt" style="font-size:18px"><b>비밀번호 찾기</b></p><br>

				<form name="form_chk2" action="post" id="id_form_chk2">
					<input type="hidden" name="m" value="checkplusService">
					<input type="hidden" name="EncodeData" value="<?php echo html_escape(element('pw_enc_data', $view)); ?>">
					<p class="chk-input" style="width:60%">
						<input id="email" name="email" type="email" placeholder="이메일 입력" value="">
					</p>
					<a href="javascript:fnPopup2();" id="ath_nice_phone2" class="modify-btn pwdBtn"><span>인증</span></a>
				</form>
			</li>
		</ul>
	</div>
</div>
<!--비밀번호 Modal End -->

<!-- 모달 스크립트 -->
<script>
	var modal1 = document.getElementById('myModal_pwd');
	var modal2 = document.getElementById('myModal_id');
	var btn1 = document.getElementById("pwdModal");
	var btn2 = document.getElementById("idModal");
	btn1.onclick = function() {
		modal1.style.display = "block";
		}
	// btn2.onclick = function() {
	// 	modal2.style.display = "block";
	// }
	window.onclick = function(event) {
		if (event.target == modal1) {
			modal1.style.display = "none";
		}
		if (event.target == modal2) {
			modal2.style.display = "none";
		}
	}

</script>

<!-- 테스트 -->
<script type="text/javascript">
	//<![CDATA[
	$(function () {
		$('#flogin').validate({
			rules: {
				mem_userid: {
					required: true,
					minlength: 3
				},
				mem_password: {
					required: true,
					minlength: 4
				}
			}
		});
	});

	$(document).on('click', ".login-btn", function () {
		$('#flogin').submit();
	});

	function loginEnter(e) {
		let fc_element = document.activeElement;
		let is_focused = (document.getElementById('mem_password') == fc_element || document.getElementById('mem_userid') == fc_element);
		if (e.keyCode == 13 && is_focused ) {
			$('#flogin').submit();
		}
	}


	//]]>

/********************************************************/
	/**
	* 나이스 핸드폰인증 시작
	*/
	window.name ="Parent_window";
		function fnPopup1(){
			window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
			document.form_chk1.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
			document.form_chk1.target = "popupChk";
			document.form_chk1.submit();
		}
		function fnPopup2(){

			var email = $('#email').val();
			// sessionStorage.setItem("check_email", email);
			// console.log(sessionStorage.getItem('check_email'));
			var regExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
			if(email.length == 0){
				alert('이메일을 입력해주세요');
				return;
			}
			if (email.match(regExp) == null) {
				alert('이메일 형식에 맞게 입력해주세요');
				return;
			}
			$.ajax({
				url: cb_url + '/login/ajax_setemail',
				type: 'GET',
				data: {
					email: email,
				},
				dataType: 'json',
				async: false,
				success: function(data) {
					result = data.result;
					
					// 성공
					if(result){
						window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
						document.form_chk2.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
						document.form_chk2.target = "popupChk";
						document.form_chk2.submit();
					}else{
						alert('이메일 인증중에 에러가 발생하였습니다.\n네트워크 상태를 확인해주세요');
					}
				},
				error: function() {
					alert("에러가 발생했습니다");
				}
			});

		}
	/**
	* 나이스 핸드폰인증 끝
	*/

	/**
	* 이메일 전송 시작
	*/
	var send_email = function(id, name){

		var email = $('#email').val();

		var state ='';
		var message = '';
		$.ajax({
			url: cb_url + '/login/ajax_imsh_pw_email_send',
			type: 'POST',
			data: {
				id: id,
				email: email,
				name: name,
				csrf_test_name : cb_csrf_hash
			},
			dataType: 'json',
			async: false,
			cache: false,
			success: function(data) {
				state = data.state;
				message = data.message;
				
				// 성공
				if(state == 1){
					// 성공 메세지
					alert(message);
				}
				// 실패
				if(state == 0){
					// 실패 메세지
					alert(message);
				}
			},
			error: function() {
				alert("에러가 발생했습니다");
			}
		});
	}
	/**
	* 이메일 전송 끝
	*/
</script>

