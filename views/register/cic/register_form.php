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


				
			<div class="entry">
				<ul>

					<?php
					foreach (element('html_content', $view) as $key => $value) {
						if(element('field_name', $value) == "mem_userid"){
					?>
						<?php echo element('input', $value); ?>
					<?php
						} else {
					?>
						<li>
							<p class="btxt"><?php echo element('display_name', $value); ?></p>
							<div class="field">
								<p class="chk-input">
									<?php echo element('input', $value); ?>
								</p>

								<?php
									if(element('field_name', $value) == "mem_email"){
								?>
									<a id="ath_email" class="cerfity-btn"><span>인증하기</span></a>
								<?php
									}
								?>

								<?php
									if(element('field_name', $value) == "mem_nickname"){
								?>
									<!-- 굳이 닉네임 확인안하고 비동기로 체크해도 될거같습니다. -->
									<a href="#n" class="chk-btn"><span>닉네임 확인</span></a>
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
					<li>
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
							</p>
							<!-- 굳이 닉네임 확인안하고 비동기로 체크해도 될거같습니다. -->
							<a href="#n" class="chk-btn"><span>닉네임 확인</span></a>
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
					</li>
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
			$("#fregisterform").submit();
		});
	});

	$(document).ready(function(){
		$("#ath_email").on('click', function(){
			var email = $("#mem_email").val();
			alert(email);
		})
	})

	$.ajax({
        url: "myname.php",
        type: "post",
    }).done(function(data) {
        $('#name').text(data);
    });
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
