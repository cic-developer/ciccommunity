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
						<a id="popup_open_btn"><span>비밀번호 찾기</span></a>
					</li>
				</ul>
			</div>

		</div>
		<!-- page end // -->
	</div>
</div>
<!-- 모달 스크립트 -->
<style>
    #my_modal {
        display: none;
        width: 300px;
        padding: 20px 60px;
        background-color: #fefefe;
        border: 1px solid #888;
        border-radius: 3px;
    }

    #my_modal .modal_close_btn {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>

<!-- 모달 스크립트 -->

<!--비밀번호 Modal Start-->


<div id="my_modal">
    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Expedita dolore eveniet laborum repellat sit distinctio, ipsa rem dicta alias velit? Repellat doloribus mollitia dolorem voluptatum ex
    reiciendis aut in incidunt?
    <a class="modal_close_btn">닫기</a>
</div>

<!--비밀번호 Modal End -->

<!-- 테스트 -->
<script>
function modal(id) {
    var zIndex = 9999;
    var modal = document.getElementById(id);

    // 모달 div 뒤에 희끄무레한 레이어
    var bg = document.createElement('div');
    bg.setStyle({
        position: 'fixed',
        zIndex: zIndex,
        left: '0px',
        top: '0px',
        width: '100%',
        height: '100%',
        overflow: 'auto',
        // 레이어 색갈은 여기서 바꾸면 됨
        backgroundColor: 'rgba(0,0,0,0.4)'
    });
    document.body.append(bg);

    // 닫기 버튼 처리, 시꺼먼 레이어와 모달 div 지우기
    modal.querySelector('.modal_close_btn').addEventListener('click', function() {
        bg.remove();
        modal.style.display = 'none';
    });

    modal.setStyle({
        position: 'fixed',
        display: 'block',
        boxShadow: '0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)',

        // 시꺼먼 레이어 보다 한칸 위에 보이기
        zIndex: zIndex + 1,

        // div center 정렬
        top: '50%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        msTransform: 'translate(-50%, -50%)',
        webkitTransform: 'translate(-50%, -50%)'
    });
}

// Element 에 style 한번에 오브젝트로 설정하는 함수 추가
Element.prototype.setStyle = function(styles) {
    for (var k in styles) this.style[k] = styles[k];
    return this;
};

document.getElementById('popup_open_btn').addEventListener('click', function(event) {
    // 모달창 띄우기
		event.preventDefault()
    modal('my_modal');
});
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

