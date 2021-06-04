<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<div id="container-wrap" class="login-bg">
	<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="member-wrap login">
			<?php 
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
						<p>* 아이디를 잊어버렸나요?</p>
						<a id="idModal"><span>아이디 찾기</span></a>
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
<!-- 모달 css -->
<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<style>
/* The Modal (background) */
.modal {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 1; /* Sit on top */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content/Box */
	.modal-content {
		background-color: #fefefe;
		margin: 15% auto; /* 15% from the top and centered */
		padding: 20px;
		border: 1px solid #888;
		width: 40%; /* Could be more or less, depending on screen size */                          
	}

	/* The Close Button */
	.close {
		color: #aaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}
	.close:hover,
	.close:focus {
		color: black;
		text-decoration: none;
		cursor: pointer;
	}

	.modal-btn {
		line-height: 35px;
		border-radius: 35px;
		font-size: 14px;
		color: #fff;
		background: #111;
		font-weight: 500;
		display: inline-block;
		vertical-align: top;
		margin-left: 15px;
		min-width: 120px;
		text-align: center;
		box-sizing: border-box;
	}
</style>

<!--아이디 Modal Start-->
<div id="myModal_id" class="modal" style="z-index:1500;">
				<div class="modal-content" style="z-index:1550;">
							<p class="btxt">회원님의 아이디는 <b>----</b> 입니다.</p>
				</div>
			</div>
<!--아이디 Modal End -->

<!--비밀번호 Modal Start-->
<div id="myModal_pwd" class="modal" style="z-index:1500;">
				<div class="modal-content" style="z-index:1550;">
					<ul class="entry modify-box">
						<li class="ath-email-content">
							<p class="btxt">이메일인증</p>
							<div class="all-email-box">
								<div class="field modify">
									<p class="chk-input w380">
										<input type="text" placeholder="인증번호를 입력해주세요" class="ath_num" name="ath_num" value="">
									</p>
									<a href="javascript:void(0);" data-type="phone" class="modify-btn send-ath-email">
										<span>이메일인증</span>
									</a>
									<a href="javascript:void(0);" data-type="phone" class="modify-btn confirm-ath-email" style="display:none;">
										<span>확인</span>
									</a>
									
								</div>
								<div class="phone-resend-email" style="display:none;">
									<a href="javascript:void(0);" data-type="phone" class="modify-btn resend-ath-email" style="display:block;">
										<span>인증번호 재전송</span>
									</a>	
								</div>
								<div class="phone-timer-box" style="display:none;">
									<span id="postTestMin1">00</span><!-- 분 -->
									<span>:</span>
									<span id="postTestSec1">10</span><!--초-->
									<!-- <span id="postTestMilisec">00</span>밀리초 -->
								</div>
							</div>
							<div class="success" style="display:none;"><p class="cblue">인증이 완료되었습니다.</p></div>
						</li>
						<li class="wallet-modify-content">
							<p class="btxt">새 핸드폰번호</p>
							<div class="field modify">
								<p class="chk-input w380">
									<input type="text" placeholder="핸드폰번호" onkeyup="inputPhoneNumber(this);" id="new_phone" name="new_phone" value="" readonly disabled style="background-color:#efefef;">
								</p>
								<a href="javascript:void(0);" id="confirm_phone"  data-type="phone" class="modify-btn">
									<span>확인</span>
								</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
<!--비밀번호 Modal End -->

<!-- 모달 스크립트 -->
<script>
var modal1 = document.getElementById('myModal_pwd');
var btn1 = document.getElementById("pwdModal");
btn1.onclick = function() {
		modal1.style.display = "block";
	}
	window.onclick = function(event) {
		if (event.target == modal1) {
			modal1.style.display = "none";
		}
		if (event.target == modal2) {
			modal2.style.display = "none";
            
			$('#myModal_password .ath-nice-content .all-nice-box > *').remove(); // 핸드폰인증 버튼 제거
		}
		if (event.target == modal3) {
			modal3.style.display = "none";
            
			$('#myModal_wallet .ath-nice-content .all-nice-box > *').remove(); // 핸드폰인증 버튼 제거
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
</script>

