<div id="container-wrap">
	<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="member-wrap join">
			<h2><span class="blind">cic community</span></h2>
			<?php
			echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
			echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
			$attributes = array('class' => 'form-horizontal', 'name' => 'fregisterform', 'id' => 'fregisterform');
			echo form_open_multipart(current_full_url(), $attributes);
			?>

<?php
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
				}?>


			<div class="entry">
				<ul>

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

					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<!-- <li>
						<p class="btxt">E-mail (ID)</p>
						<div class="field">
							<p class="chk-input">
								<input id="mem_email" name="mem_email" type="text" value="dltngh2236@naver.com" autocomplete="off">
							</p>
							<a id="ath_email" class="cerfity-btn"><span>인증하기</span></a>
						</div>
						<p class="rtxt mg10t">승인이 완료되었습니다</p>
					</li>
					<li>
						<p class="btxt">비밀번호</p>
						<div class="field password">
							<p class="chk-input">
								<input name="password" type="password" value="***********" autocomplete="off">
							</p>
						</div>
						<p class="rtxt mg10t">비밀번호는 4자리 이상이어야 합니다.</p>
					</li>
					<li>
						<p class="btxt">비밀번호 확인</p>
						<div class="field password">
							<p class="chk-input">
								<input name="password2" type="password" value="***********" autocomplete="off">
							</p>
						</div>
						<p class="rtxt error mg10t">비밀번호가 일치하지 않습니다.</p>
					</li>
					<li>
						<p class="btxt">닉네임</p>
						<div class="field nick">
							<p class="chk-input">
								<input name="nickname" type="text" value="코린이1253" autocomplete="off">
							</p> -->
							<!-- 굳이 닉네임 확인안하고 비동기로 체크해도 될거같습니다. -->
							<!-- <a href="#n" class="chk-btn"><span>닉네임 확인</span></a>
						</div>
						<p class="rtxt mg10t">공백없이 한글, 영문, 숫자만 입력 가능 2글자 이상 <br>닉네임 설정 시 변경이 불가능합니다.</p>
						<p class="rtxt nec mg10t">적합하지 않은 별명의 경우 임의 변경될 수 있습니다.</p>
					</li>
					<li>
						<p class="btxt">PER 지갑주소</p>
						<div class="field nick">
							<p class="chk-input">
								<input name="walet_address" type="text" value="ox12344556619982389" autocomplete="off">
							</p>
						</div>
						<p class="rtxt mg10t">PER 지갑주소 입력은 선택사항 입니다. <br>지갑주소를 등록하여 다양한 혜택을 즐겨보세요.</p>
					</li> -->
				</ul>
				<a id="submitButton" class="join-btn"><span>가입하기</span>
				</a>
			</div><a href="#" class="join-btn">
			</a>
			<?php echo form_close(); ?>
		</div><a href="#" class="join-btn">
			<!-- page end // -->
		</a>
	</div><a href="#" class="join-btn">
	</a>
</div>

<script>
	$(document).ready(function(){
		$("#submitButton").on('click',function(){

			email = $("#mem_email").val();
			password1 = $("#mem_password").val();
			password2 = $("#mem_password_re").val();
			nickname = $("#mem_nickname").val();

			$("#fregisterform").submit();
		});
	});

	$(document).ready(function(){
		$("#ath_email").on('click', function(){
			var _email = $("#mem_email").val();
			// alert(email);

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
			$('.con-mail').remove();
			html = '<p class="success-email rtxt mg10t">승인이 완료되었습니다</p>';
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

	// $("#mem_password").change(function(){
	// 	alert("id name 값이 변경되었습니다.");
	// });


</script>



<!-- <script type="text/javascript">
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
			email: {required :true, email:true, is_email_available:true},
			password: {required :true, is_password_available:true},
			password2 : {required: true, equalTo : '#mem_password' },
			nickname: {required :true, is_nickname_available:true}
		},
		
	});
});
//]]>
</script> -->
