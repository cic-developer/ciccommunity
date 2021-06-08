<div id="container-wrap" class="register">
	<div id="contents" class="div-cont table-box">
		<!-- page start // -->
		<div class="member-wrap join table-body">
			<h2><span class="blind">cic community</span></h2>

			<?php
			//에러가 발생 할 경우 알럿			
			echo validation_errors('<script>alert("', '");</script>');
			echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
			$attributes = array('class' => 'form-horizontal', 'name' => 'fregisterform', 'id' => 'fregisterform');
			echo form_open_multipart(current_full_url(), $attributes);
			?>
			<div class="entry">
				<ul class="registerform">

				<!--  -->
				<?php
				foreach (element('html_content', $view) as $key => $value) {
					$hidden_field_name = array("mem_userid" ,"mem_username" ,"mem_sex" ,"mem_phone" ,"mem_birthday");
					// userid 히든으로 숨기기
					if(in_array(element('field_name', $value), $hidden_field_name)){
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
				</ul>
				<a id="submitButton" class="join-btn"><span>가입하기</span></a>
			<?php echo form_close(); ?>
			</div>
		</div>
		<!-- page end // -->
	</div>
</div>


<script>
	// $(window).load(function(){
	// 	var ath_mail = "<?php echo element('ath_result', $view); ?>";
	// 	if(ath_mail){
	// 		var html = '<p class="success-email rtxt mg10t cblue">승인이 완료되었습니다</p>';
	// 		html += '<input type="hidden" id="ath_num" name="ath_num" class="" required value="'+ ath_num +'" />'
	// 		$('.mem_email').append(html); // 승인 메세지
	// 	}
	// })

	$(document).ready(function(){
		$("#submitButton").on('click',function(){

			var email = $("#mem_email").val();
			var password = $("#mem_password").val();
			var password_re = $("#mem_password_re").val();
			var nickname = $("#mem_nickname").val();
			// var csrf = $("#csrf_test_name").val();
			var userid = $("#mem_userid").val();
			var username = $("#mem_username").val();
			var phone = $("#mem_phone").val();
			var birthday = $("#mem_birthday").val();
			var sex = $("#mem_sex").val();

			if(email.length == 0) {alert('이메일을 입력해주세요'); return;}
			if(password.length == 0) {alert('비밀번호를 입력해주세요'); return;}
			if(password.length < 4) {alert('비밀번호를 4자리 이상 입력해주세요'); return;}
			if(password != password_re ) {alert('비밀번호가 일치하지 않습니다'); return;}
			if(password_re.length == 0) {alert('비밀번호 확인을 입력해주세요'); return;}
			if(nickname.length == 0) {alert('닉네임을 입력해주세요'); return;}
			// if(csrf.length == 0) {alert('(csrf 오류) 휴대폰 재인증이 필요합니다'); return;}
			if(userid.length == 0) {alert('이메일 인증이 필요합니다'); return;}
			if(username.length == 0) {alert('(name 오류) 휴대폰 재인증이 필요합니다'); return;}
			if(phone.length == 0) {alert('(phone 오류) 휴대폰 재인증이 필요합니다'); return;}
			if(birthday.length == 0) {alert('(birtyday 오류) 휴대폰 재인증이 필요합니다'); return;}
			if(sex.length == 0) {alert('(gender 오류) 휴대폰 재인증이 필요합니다'); return;}
			

			$("#fregisterform").submit();
		});
	});

	// 이메일 확인 + 인증번호 보내기
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
				$('#ath_num').remove();
				if(state == 1){
					html = '';
					html += '<div class="field con-mail">'
					html += '<p class="chk-input">'
					html += '<input type="text" id="ath_num" name="ath_num" class="" required />'
					html += '<p class="rtxt mg10t">'
					html += '<a class="con-mail-btn cerfity-btn" id="con-mail-btn">메일인증 확인</a>'
					html += '</p>'
					html += '</p>'
					html += '</div>'
					$('.mem_email').append(html);
				}
			}
		})
	})

	// 이메일 인증 하기
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

		// 실패
		if(result == 0){
			alert(reason);
		}

		//성공
		if(result == 1) {
			var _email = $("#mem_email").val();
			_email = _email.split('@');

			var html = '<p class="success-email rtxt mg10t cblue">승인이 완료되었습니다</p>';
			html += '<input type="hidden" id="ath_num" name="ath_num" class="" required value="'+ ath_num +'" />'

			$('.con-mail').remove(); // 인증 박스 삭제
			$("#mem_userid").val(_email[0] + '' + ath_num); // 유저 아이디 
			$('.mem_email').append(html); // 승인 메세지
		}
	});

	// 닉네임 확인
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

	// 비밀번호 == 비밀번호 확인 check
	oldVal1 = '';
	$("#mem_password").on("propertychange change keyup paste input", function() {
		var currentVal = $(this).val();
		if(currentVal == oldVal1) {
			return;
		}
		
		password2 = $("#mem_password_re").val();
		if(password2 != currentVal){
			$('.agree-password').remove();
			html = '<p class="agree-password cred" class="rtxt mg10t">비밀번호가 일치하지 않습니다.</p>';
			$('.mem_password_re').append(html);
		} else{
			$('.agree-password').remove();
			html = '<p class="agree-password cblue" class="rtxt mg10t">비밀번호가 일치합니다.</p>';
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
			html = '<p class="agree-password cred" class="rtxt mg10t">비밀번호가 일치하지 않습니다.</p>';
			$('.mem_password_re').append(html);
		} else{
			$('.agree-password').remove();
			html = '<p class="agree-password cblue" class="rtxt mg10t">비밀번호가 일치합니다.</p>';
			$('.mem_password_re').append(html);
		}
		
		oldVal2 = currentVal;
	});

</script>


<!-- var timestamp = + new Date();
var year = today.getFullYear(); // 년도
var month = today.getMonth() + 1;  // 월
var date = today.getDate();  // 날짜
var day = today.getDay();  // 요일
var day = today.getDay();  // 요일
var hours = today.getHours(); // 시
var minutes = today.getMinutes();  // 분
var seconds = today.getSeconds();  // 초
var milliseconds = today.getMilliseconds(); // 밀리초 -->