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
						<a href="#" data-toggle="modal" data-target="#idModal"><span>아이디 찾기</span></a>
					</li>
					<li>
						<p>* 비밀번호를 잊어버렸나요? </p>
						<a href="#" data-toggle="modal" data-target="#pwdModal"><span>비밀번호 찾기</span></a>
					</li>
				</ul>
			</div>

		</div>
		<!-- page end // -->
	</div>
</div>
<!-- 아이디 Modal -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>
	.modal-dialog{
		width:100%;
	}
	.idpwdModal{
	position: fixed;
	top: 50%;
	left: 50%;
	-webkit-transform: translate(-50%, -50%);
	-moz-transform: translate(-50%, -50%);
	-ms-transform: translate(-50%, -50%);
	-o-transform: translate(-50%, -50%);
	transform: translate(-50%, -50%);
}
</style>

  <!-- Modal -->
  <div class="modal fade idpwdModal" id="idModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">아이디 찾기</h4>
        </div>
		<!-- 핸드폰 본인인증 후 화면 -->
        <div class="modal-body">
          <h3>회원님의 아이디는 ---- 입니다.</h3>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<!-- -------------------------------- -->

<!--비밀번호 Modal Start-->
<div class="modal fade idpwdModal" id="pwdModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">비밀번호 찾기</h4>
        </div>
        <div class="modal-body">
					<div class="form-group">
    				<label for="exampleInputEmail1">이메일 주소</label>
    				<input type="email" class="form-control" id="exampleInputEmail1" placeholder="이메일을 입력하세요">
  				</div>
        </div>
        <div class="modal-footer">
					<button type="submit" class="btn btn-default">제출</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<!--비밀번호 Modal End -->

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

