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
			<h3>cic community <br>LOGIN</h3>
			<div class="entry">
				<ul>
					<li>
						<p class="chk-input">
							<input type="text" name="mem_userid" value="<?php echo set_value('mem_userid'); ?>" accesskey="L" placeholder="Email" autocomplete="off">
						</p>
					</li>
					<li>
						<p class="chk-input">
							<input type="password" name="mem_password" placeholder="PASSWORD" autocomplete="off">
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
						<a href="javascript:;" onClick="social_connect_on('facebook');" title="페이스북 로그인"><img src="<?php echo base_url('assets/images/social_facebook.png'); ?>" width="22" height="22" alt="페이스북 로그인" title="페이스북 로그인" /></a>
					<?php } ?>
					<?php if ($this->cbconfig->item('use_sociallogin_twitter')) {?>
						<a href="javascript:;" onClick="social_connect_on('twitter');" title="트위터 로그인"><img src="<?php echo base_url('assets/images/social_twitter.png'); ?>" width="22" height="22" alt="트위터 로그인" title="트위터 로그인" /></a>
					<?php } ?>
					<?php if ($this->cbconfig->item('use_sociallogin_google')) {?>
						<a href="javascript:;" onClick="social_connect_on('google');" title="구글 로그인"><img src="<?php echo base_url('assets/images/social_google.png'); ?>" width="22" height="22" alt="구글 로그인" title="구글 로그인" /></a>
					<?php } ?>
					<?php if ($this->cbconfig->item('use_sociallogin_naver')) {?>
						<a href="javascript:;" onClick="social_connect_on('naver');" title="네이버 로그인"><img src="<?php echo base_url('assets/images/social_naver.png'); ?>" width="22" height="22" alt="네이버 로그인" title="네이버 로그인" /></a>
					<?php } ?>
					<?php if ($this->cbconfig->item('use_sociallogin_kakao')) {?>
						<a href="javascript:;" onClick="social_connect_on('kakao');" title="카카오 로그인"><img src="<?php echo base_url('assets/images/social_kakao.png'); ?>" width="22" height="22" alt="카카오 로그인" title="카카오 로그인" /></a>
					<?php } ?>
					</div>
				</div>
			<?php } ?>
			<!-- 여기에 소셜로그인을 등록!! -->
			<a class="login-btn"><span>SIGN IN</span></a>
			<?php echo form_close(); ?>
			<div class="other">
				<ul>
					<li>
						<p>* 아이디를 잊어버렸나요?</p>
						<a href="#n"><span>아이디 찾기</span></a>
					</li>
					<li>
						<p>* 비밀번호를 잊어버렸나요? </p>
						<a href="#n"><span>비밀번호 찾기</span></a>
					</li>
				</ul>
			</div>
			
		</div>
		<!-- page end // -->
	</div>
</div>


<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#flogin').validate({
		rules: {
			mem_userid : { required:true, minlength:3 },
			mem_password : { required:true, minlength:4 }
		}
	});
});
$(document).on('change', "input:checkbox[name='autologin']", function() {
	if (this.checked) {
		$('.autologinalert').show(300);
	} else {
		$('.autologinalert').hide(300);
	}
});

$(document).on('click', ".login-btn", function(){
	$('#flogin').submit();
})
//]]>
</script>