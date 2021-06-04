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
						<a id="idModal" ><span>아이디 찾기</span></a>
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
	.pwdBtn {
		width:100px;
		background-color: skyblue;
		border: none;
		color:#fff;
		padding: 7px 0;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 15px;
		margin-left: 15px;
		cursor: pointer;
		border-radius : 12px;
}

</style>

<!--아이디 Modal Start-->
	<div id="myModal_id" class="modal" style="z-index:1500;">
		<div class="modal-content" style="z-index:1550;">
					<!-- 휴대전화 번호 인증 후 화면 -->
					<p class="chk-input">회원님의 아이디는 <b style="font-size:20px">----</b> 입니다.</p>
		</div>
	</div>
<!--아이디 Modal End -->

<!--비밀번호 Modal Start-->
<div id="myModal_pwd" class="modal" style="z-index:1500;">
				<div class="modal-content" style="z-index:1550;">
					<ul class="entry modify-box">
						<li class="ath-email-content">
							<p class="btxt" style="font-size:18px"><b>비밀번호 찾기</b></p><br>
								<form action="">
								<p class="chk-input" style="width:60%">
									<input id="mem_password" name="mem_password" type="email" placeholder="이메일 입력" value="">
								</p>
								<button type="submit" class="pwdBtn">인증</button>
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
btn2.onclick = function() {
		modal2.style.display = "block";
	}
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
</script>

