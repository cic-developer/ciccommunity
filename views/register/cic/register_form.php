<div id="container-wrap" class="register">
	<div id="contents" class="div-cont table-box">
		<!-- page start // -->
		<div class="member-wrap join table-body">
			<h2><span class="blind">cic community</span></h2>
			<?php
			echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
			echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
			$attributes = array('class' => 'form-horizontal', 'name' => 'fregisterform', 'id' => 'fregisterform');
			echo form_open_multipart(current_full_url(), $attributes);
			?>
			<div class="entry">
				<ul class="registerform">

				<!-- <?php
				foreach (element('html_content', $view) as $key => $value) {
				?>
					<li>
						<span><?php echo element('display_name', $value); ?></span>
						<div class="form-text text-primary group">
							<?php echo element('input', $value); ?>
							<?php if (element('description', $value)) { ?>
								<p class="help-block"><?php echo element('description', $value); ?></p>
							<?php } ?>
						</div>
					</li>
				<?php
				}
				?> -->
			

				<!--  -->
				<?php
				foreach (element('html_content', $view) as $key => $value) {

					// userid 히든으로 숨기기
					if(element('field_name', $value) == "mem_userid" ||
							element('field_name', $value) == "mem_username" ||
								element('field_name', $value) == "mem_sex"||
									element('field_name', $value) == "mem_phone"||
										element('field_name', $value) == "mem_birthday"){
				?>
					<?php echo element('input', $value); ?>
				<?php
					} else {
				?>
					
					<!-- 기본 회원가입 폼 엘리먼트 그리기 -->
					<li class="<?php echo element('field_name', $value) ?>">
						<p class="btxt"><?php echo element('display_name', $value); ?></p>
						<div class="field">
							<p class="chk-input">
								<?php echo element('input', $value); ?>
							</p>

							<!-- 이메일 인증 버튼 -->
							<?php
								if(element('field_name', $value) == "mem_email"){
							?>
								<a id="ath_email" class="cerfity-btn"><span>인증하기</span></a>
							<?php
								}
							?>

							<!-- 닉네임 확인 버튼 -->
							<?php
								if(element('field_name', $value) == "mem_nickname"){
							?>
								<!-- 굳이 닉네임 확인안하고 비동기로 체크해도 될거같습니다. -->
								<a id="ath_nickname" class="chk-btn"><span>닉네임 확인</span></a>
							<?php
								}
							?>

						</div>
						<p class="rtxt mg10t">
							<?php if (element('description', $value)) { ?>
								<p class="help-block"><?php echo element('description', $value); ?></p>
							<?php } ?>
						</p>
					</li>
				<?php
					}
				}
				?>

				<?php
				if ($this->cbconfig->item('use_member_photo') && $this->cbconfig->item('member_photo_width') > 0 && $this->cbconfig->item('member_photo_height') > 0) {
				?>
					<li>
						<span>프로필사진</span>
							<div class="form-text text-primary group">
								<input type="file" name="mem_photo" id="mem_photo" />
								<p class="help-block">가로길이 : <?php echo number_format($this->cbconfig->item('member_photo_width')); ?>px, 세로길이 : <?php echo number_format($this->cbconfig->item('member_photo_height')); ?>px 에 최적화되어있습니다, gif, jpg, png 파일 업로드가 가능합니다</p>
							</div>
						</li>
					<?php
					}
					if ($this->cbconfig->item('use_member_icon') && $this->cbconfig->item('member_icon_width') > 0 && $this->cbconfig->item('member_icon_height') > 0) {
					?>
						<li>
							<span>회원아이콘</span>
							<div class="form-text text-primary group">
								<input type="file" name="mem_icon" id="mem_icon" />
								<p class="help-block">가로길이 : <?php echo number_format($this->cbconfig->item('member_icon_width')); ?>px, 세로길이 : <?php echo number_format($this->cbconfig->item('member_icon_height')); ?>px 에 최적화되어있습니다, gif, jpg, png 파일 업로드가 가능합니다</p>
							</div>
						</li>
					<?php
					}
					?>
					<!-- <li>
						<span>정보공개</span>
						<div class="form-text text-primary group">
							<label for="mem_open_profile"> -->
								<input type="hidden" name="mem_open_profile" id="mem_open_profile" value="1" <?php echo set_checkbox('mem_open_profile', '1', true); ?> />
								<!-- 다른분들이 나의 정보를 볼 수 있도록 합니다.
							</label>
							<?php if (element('open_profile_description', $view)) { ?>
								<p class="help-block"><?php echo element('open_profile_description', $view); ?></p>
							<?php } ?>
						</div>
					</li> -->
					<!-- <?php if ($this->cbconfig->item('use_note')) { ?>
						<li>
							<span>쪽지기능사용</span>
							<div class="form-text text-primary group">
								<div class="checkbox">
									<label for="mem_use_note"> -->
										<input type="hidden" name="mem_use_note" id="mem_use_note" value="1" <?php echo set_checkbox('mem_use_note', '1', true); ?> />
										<!-- 쪽지를 주고 받을 수 있습니다.
									</label>
									<?php if (element('use_note_description', $view)) { ?>
										<p class="help-block"><?php echo element('use_note_description', $view); ?></p>
									<?php } ?>
								</div>
							</div>
						</li>
					<?php } ?> -->
					<!-- <li>
						<span>이메일수신여부</span>
						<div class="form-text text-primary group">
							<div class="checkbox">
								<label for="mem_receive_email" > -->
									<input type="hidden" name="mem_receive_email" id="mem_receive_email" value="1" <?php echo set_checkbox('mem_receive_email', '1', true); ?> /> 
									<!-- 수신 -->
								<!-- </label>
							</div>
						</div>
					</li> -->
					<!-- <li>
						<span>SMS 문자수신</span>
						<div class="form-text text-primary group">
							<div class="checkbox">
								<label for="mem_receive_sms"> -->
									<input type="hidden" name="mem_receive_sms" id="mem_receive_sms" value="1" <?php echo set_checkbox('mem_receive_sms', '1', true); ?> /> 
									<!-- 수신 -->
								<!-- </label>
							</div>
						</div>
					</li> -->
					<!-- <li>
						<?php if ($this->cbconfig->item('use_recaptcha')) { ?>
							<span></span>
							<div class="form-text text-primary group captcha" id="recaptcha"><button type="button" id="captcha"></button></div>
							<input type="hidden" name="recaptcha" />
						<?php } else { ?>
							<span><img src="<?php echo base_url('assets/images/preload.png'); ?>" width="160" height="40" id="captcha" alt="captcha" title="captcha" /></span>
							<div class="form-text text-primary group">
								<input type="text" name="captcha_key" id="captcha_key" class=" input px150" value="" />
								<p class="help-block">좌측에 보이는 문자를 입력해주세요</p>
							</div>
						<?php } ?>
					</li> -->
					<!-- <li>
						<span></span>
						<div class="group">
							<button type="submit" class="btn btn-success">회원가입</button>
							<a href="<?php echo site_url(); ?>" class="btn btn-default">취소</a>
						</div>
					</li> -->
				</ul>
				<a id="submitButton" class="join-btn"><span>가입하기</span></a>
			<?php echo form_close(); ?>
			</div>
			<a href="#" class="join-btn"></a>
		</div>
		<a href="#" class="join-btn">
			<!-- page end // -->
		</a>
	</div>
	<a href="#" class="join-btn"></a>
</div>

<!-- <?php
$this->managelayout->add_css(base_url('assets/css/datepicker3.css'));
$this->managelayout->add_js('http://dmaps.daum.net/map_js_init/postcode.v2.js');
$this->managelayout->add_js(base_url('assets/js/bootstrap-datepicker.js'));
$this->managelayout->add_js(base_url('assets/js/bootstrap-datepicker.kr.js'));
$this->managelayout->add_js(base_url('assets/js/member_register.js'));
if ($this->cbconfig->item('use_recaptcha')) {
	$this->managelayout->add_js(base_url('assets/js/recaptcha.js'));
} else {
	$this->managelayout->add_js(base_url('assets/js/captcha.js'));
}
?>

<script type="text/javascript">
//<![CDATA[
$('.datepicker').datepicker({
	format: 'yyyy-mm-dd',
	language: 'kr',
	autoclose: true,
	todayHighlight: true
});
$(function() {
	$('#fregisterform').validate({
		onkeyup: false,
		onclick: false,
		rules: {
			mem_userid: {required :true, minlength:3, maxlength:20, is_userid_available:true},
			mem_email: {required :true, email:true, is_email_available:true},
			mem_password: {required :true, is_password_available:true},
			mem_password_re : {required: true, equalTo : '#mem_password' },
			mem_nickname: {required :true, is_nickname_available:true}
			<?php if ($this->cbconfig->item('use_recaptcha')) { ?>
				, recaptcha : {recaptchaKey:true}
			<?php } else { ?>
				, captcha_key : {required: true, captchaKey:true}
			<?php } ?>
		},
		messages: {
			recaptcha: '',
			captcha_key: '자동등록방지용 코드가 올바르지 않습니다.'
		}
	});
});
//]]>
</script> -->

<script>
	$(document).ready(function(){
		$("#submitButton").on('click',function(){

			// email = $("#mem_email").val();
			// password1 = $("#mem_password").val();
			// password2 = $("#mem_password_re").val();
			// nickname = $("#mem_nickname").val();

			$("#fregisterform").submit();
		});
	});

	$(document).ready(function(){
		$("#ath_email").on('click', function(){
			var _email = $("#mem_email").val();

			var result = '';
			var reason = '';
			var state = '';
			var message = '';
			$.ajax({
				url: cb_url + '/register/ajax_email_check',
				type: 'POST',
				data: {
					email: _email,
					csrf_test_name : cb_csrf_hash
				},
				dataType: 'json',
				async: false,
				cache: false,
				success: function(data) {
					result = data.result;
					reason = data.reason;
				}
			});
			if(result == "no"){
				alert(reason);
			}

			if(result == "available"){
				alert(reason);

				$.ajax({
					url: cb_url + '/register/ajax_email_send',
					type: 'POST',
					data: {
						email: _email,
						csrf_test_name : cb_csrf_hash
					},
					dataType: 'json',
					async: false,
					cache: false,
					success: function(data) {
						state = data.state;
						message = data.message;
					}
				});

				alert(message);

				$('.success-email').remove();
				$('.con-mail').remove();
				if(state == 1){
					html = '';
					html += '<div class="con-mail">'
					html += '<input type="text" id="ath_num" name="ath_num" class="" required />'
					html += '<a class="con-mail-btn cerfity-btn" id="con-mail-btn">메일인증 확인</a>'
					html += '</div>'
					$('.mem_email').append(html);
				}
			}
		})
	})

	// 이메일 인증
	$(document).on('click', "#con-mail-btn", function(){
		var ath_num = $("#ath_num").val();

		var result = '';
		var reason = '';
		$.ajax({
			url: cb_url + '/register/ajax_email_ath',
			type: 'POST',
			data: {
				ath_num: ath_num,
				csrf_test_name : cb_csrf_hash
			},
			dataType: 'json',
			async: false,
			cache: false,
			success: function(data) {
				result = data.result;
				reason = data.reason;
			}
		});

		if(result == 0){
			alert(reason);
		}

		if(result == 1) {
			var _email = $("#mem_email").val();
			var html = '<p class="success-email rtxt mg10t">승인이 완료되었습니다</p>';

			$('.con-mail').remove();
			$("#mem_userid").val(_email);
			$('.mem_email').append(html);
			// $('#ath_email').remove();
			// $("#mem_email").attr("readonly", true);
			// $("#mem_email").attr("disabled", true);
		}
	});


	$(document).ready(function(){
		$("#ath_nickname").on('click', function(){
			var _nickname = $("#mem_nickname").val();
			// alert(email);

			var result = '';
			var reason = '';
			$.ajax({
				url: cb_url + '/register/ajax_nickname_check',
				type: 'POST',
				data: {
					nickname: _nickname,
					csrf_test_name : cb_csrf_hash
				},
				dataType: 'json',
				async: false,
				cache: false,
				success: function(data) {
					result = data.result;
					reason = data.reason;
				}
			});
			if(result == "no"){
				alert(reason);
			}

			if(result == "available"){
				alert(reason);
			}
		})
	})

	// $(document).ready(function(){
	// 	_password1 = $(".mem_password").val();
	// 	_password2 = $(".mem_password_re").val();

	// 	if(_password1 != _password2){
	// 		alert("ho");
	// 	}
	// });

	//예전 jQuery라면 on이 아니라 bind나 live 
	oldVal1 = '';
	$("#mem_password").on("propertychange change keyup paste input", function() {
		var currentVal = $(this).val();
		if(currentVal == oldVal1) {
			return;
		}
		
		password2 = $("#mem_password_re").val();
		if(password2 != currentVal){
			$('.agree-password').remove();
			html = '<p class="agree-password" class="rtxt mg10t">비밀번호가 일치하지 않습니다.</p>';
			$('.mem_password_re').append(html);
		} else{
			$('.agree-password').remove();
			html = '<p class="agree-password" class="rtxt mg10t">비밀번호가 일치합니다.</p>';
			$('.mem_password_re').append(html);
		}
		
		oldVal1 = currentVal;
	});

	oldVal2 = '';
	$("#mem_password_re").on("propertychange change keyup paste input", function() {
		var currentVal = $(this).val();
		if(currentVal == oldVal2) {
			return;
		}
		
		password1 = $("#mem_password").val();
		if(password1 != currentVal){
			$('.agree-password').remove();
			html = '<p class="agree-password" class="rtxt mg10t">비밀번호가 일치하지 않습니다.</p>';
			$('.mem_password_re').append(html);
		} else{
			$('.agree-password').remove();
			html = '<p class="agree-password" class="rtxt mg10t">비밀번호가 일치합니다.</p>';
			$('.mem_password_re').append(html);
		}
		
		oldVal2 = currentVal;
	});

	$("#mem_email").on("propertychange change keyup paste input", function() {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		var currentVal = $(this).val();
		// if(currentVal == oldVal1) {
		// 	return;
		// }
		
		if (currentVal == '' || !re.test(currentVal)) {
			alert("올바른 이메일 주소를 입력하세요")
		return false;
		}

		oldVal1 = currentVal;
	});

	// $("#mem_password").change(function(){
	// 	alert("id name 값이 변경되었습니다.");
	// });


</script>
