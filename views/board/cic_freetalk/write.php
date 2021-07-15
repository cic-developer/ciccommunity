<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/hotfix.css'); ?>
<!-- bpopup 스크립트 불러오기-->
<script src="../../../assets/js/jquery.bpopup-0.1.1.min.js"></script>

<div id="container-wrap">
	<div id="contents" class="div-cont">
		<?php
			echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
			echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
			$attributes = array('class' => 'form-horizontal', 'name' => 'fwrite', 'id' => 'fwrite', 'onsubmit' => 'return submitContents(this)');
			echo form_open_multipart(current_full_url(), $attributes);
		?>
		<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('post', $view)); ?>" />
		<input type="hidden" class="input px150" name="post_nickname" id="post_nickname" value="<?php echo set_value('post_nickname', element('post_nickname', element('post', $view))); ?>" />
		<input type="hidden" class="input px400" name="post_email" id="post_email" value="<?php echo set_value('post_email', element('post_email', element('post', $view))); ?>" />
		<input type="hidden" class="input px400" name="post_homepage" id="post_homepage" value="<?php echo set_value('post_homepage', element('post_homepage', element('post', $view))); ?>" />
		<!-- page start // -->
		<div class="board-wrap write">
		<h3><?php echo html_escape(element('board_name', element('board', $view))); ?> 글쓰기 <p style="font-size: 13px; margin-top: 9px; color: red;">작성된 게시글은 수정이 불가합니다 신중하게 작성해주세요</p></h3>
			<div class="entry">
				<ul>
					<li class="title-box">
						<p class="btxt">제목</p>
						<div class="field">
							<p class="chk-input w100p">
								<input id="post_title" type="text" name="post_title" placeholder="제목을 입력해주세요" value="<?php echo set_value('post_title', element('post_title', element('post', $view))); ?>" />
							</p>
						</div>
					</li>
					<li class="no-pad">
						<?php echo display_dhtml_editor('post_content', set_value('post_content', element('post_content', element('post', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = element('use_dhtml', element('board', $view)), $editor_type = $this->cbconfig->item('post_editor_type')); ?>
					</li>
					<?php if (element('can_post_notice', element('post', $view))) { ?>
					<div class="main-check">
						<label> <input type="checkbox" class="checkbox" name="post_notice" value="1"> <p>메인으로 게시</p> </label>
					</div>
					<?php } ?>
				</ul>
			</div>
			<div class="lower">
				<button type="submit" class="enter-btn"><span>등록하기</span></button>
			</div>
		</div>
		<!-- page end // -->
		<?php echo form_close(); ?>
	</div>
</div>



<!-- 모달 css -->
<style>
#element_to_pop_up {
    background-color: #fff;
    border-radius: 15px;
    color: #000;
    display: none;
    padding: 20px;
}
.b-close {
    cursor: pointer;
    position: absolute;
    right: 15px;
    top: 10px;
}
.modal-header {
    height: 35px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.2);
}
.modal-body {
    margin-top: 20px;
}
.header_text {
    font-size: 25px;
    font-weight: bold;
}
.body-text__header {
    font-size: 18px;
    font-weight: bold;
}
.body-text {
    font-size: 15px;
}
.btn-group{
	width:100%;
	background-color: skyblue;
	color:white;
	text-align :center;
}
.b-close {
    cursor: pointer;
    position: static;
    right: 0;
    top: 0;
		padding : 10px 0;
		border-radius : 10px;
}
.close-modal{
    cursor: pointer;
    position: absolute;
    right: 15px;
    top: 10px;
}
.modal-footer{
	display : flex;
	flex-direction : column;
	align-items: flex-end;
	padding-bottom: 10px;
}
</style>

<!-- 모달 팝업 -->
<div id="element_to_pop_up">
    <div class="modal-content" >
			<div class="modal-header">
					<span class="header_text">글 작성 전 필독사항</span>
					<a class="close-modal" style="font-size:25px" onclick="x_modal()">×</a>
			</div>
			<div class="modal-body">
					<p class="body-text__header"><span style="color:red; font-size:22px;">잠깐!</span> 글 작성 전에 확인해 주세요!<br></p><br>
					<p class="body-text">
						- 저격성 글 및 특정 인물 지목 작성을 금지합니다.<br>
						<br>
						- 도배하는 글 작성을 금지합니다.<br>
						<br>
						- 추천 유도 글 작성 또는 추천 코드 가입을 금지합니다.<br>
						<br>
						- 뉴스 기사 자료 업로드 시 출처 명시를 꼭 부탁드립니다.<br>
						<br>
						- 카카오톡, 텔레그램 등 모든 SNS 회원 모집을 금지합니다.<br>
						<br>
						<span style="color:red">※ 위 사항이 지켜지지 않을 시 경고 없이 차단될 수 있습니다.</span><br>
					</p>
			</div>
			<div style="margin:20px 0 10px 0;border-bottom: 1px solid rgba(0, 0, 0, 0.2);"></div>
			<div class="modal-footer">
				<div class="b-close btn-group">
					☑ 모두 확인했고 내용에 동의합니다
				</div>
			</div>
			
			<p align="right" style="font-size:12px;"><input type="checkbox" name="close_week" id="close_week" style="vertical-align: middle;"> 7일간 보지 않기</p>
	</div>
</div>


<script> 
var box_check;

$(document).ready(function() { 
	$(".b-close").on('click', function() {
		if(box_check){
			setCookie("close_weeks", "check", "7");
		}
	});
	$("input:checkbox").on('click', function() { 
		if ( $(this).prop('checked') ) { 
			box_check = true;
		} else{
			box_check = false;
		}
	}); 
});
</script>

<script>
$( document ).ready(function() {
	let checkCookie = getCookie("close_weeks");
	if(!checkCookie){
	$('#element_to_pop_up').bPopup({
		easing: 'easeOutBack', //uses jQuery easing plugin
    speed: 1500,
    transition: 'slideDown',
		modalClose: false,
    opacity: 0.6,
    positionStyle: 'fixed'
	});
	};
});




function x_modal(){
	history.back();
}

// 쿠키 설정 함수(modalWarning)
var setCookie = function(name, value, exp) {
var date = new Date();
date.setTime(date.getTime() + exp * 24 * 60 * 60 * 1000);
document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
};

// 쿠키 가져오기 함수(modalWarning)
var getCookie = function(name) {
var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
return value ? value[2] : null;
};
</script>




<script type="text/javascript">
// 글자수 제한
var char_min = parseInt(<?php echo (int) element('post_min_length', element('board', $view)); ?>); // 최소
var char_max = parseInt(<?php echo (int) element('post_max_length', element('board', $view)); ?>); // 최대

<?php if ( ! element('use_dhtml', element('board', $view)) AND (element('post_min_length', element('board', $view)) OR element('post_max_length', element('board', $view)))) { ?>

check_byte('post_content', 'char_count');
$(function() {
	$('#post_content').on('keyup', function() {
		check_byte('post_content', 'char_count');
	});
});
<?php } ?>

	// var oldTitle= '';
	// $(document).on("propertychange change keyup paste input","#post_title",function(){
		
	// 	var title = $(this).val();
	// 	if(title == oldTitle) {
	// 		return;
	// 	}
		
	// 	$('#post_title-error').remove();
		
	// 	var titleLen = title.length;
	// 	var html = '';	
	// 	html += '<label id="post_title-error" class="error" for="post_title">';
		
	// 	if(titleLen < 2 || titleLen > 60){
		
	// 		if(titleLen == 0){
	// 			html += '필수 항목입니다.';
	// 		}else if(titleLen < 2){
	// 			html += '최소 2자 이상 입력하세요.';
	// 		}else if(titleLen  > 59){
	// 			html += '60자를 넘을 수 없습니다.';
	// 		}

	// 		html += '</label>';
	// 		$('.title-box').append(html)
	// 	}
		
	// 	oldTitle = title;
	// });

function submitContents(f) {
	if ($('#char_count')) {
		if (char_min > 0 || char_max > 0) {
			var cnt = parseInt(check_byte('post_content', 'char_count'));
			if (char_min > 0 && char_min > cnt) {
				alert('내용은 ' + char_min + '글자 이상 쓰셔야 합니다.');
				$('#post_content').focus();
				return false;
			} else if (char_max > 0 && char_max < cnt) {
				alert('내용은 ' + char_max + '글자 이하로 쓰셔야 합니다.');
				$('#post_content').focus();
				return false;
			}
		}
	}
	var title = '';
	var content = '';
	$.ajax({
		url: cb_url + '/postact/filter_spam_keyword',
		type: 'POST',
		data: {
			title: f.post_title.value,
			content: f.post_content.value,
			csrf_test_name : cb_csrf_hash
		},
		dataType: 'json',
		async: false,
		cache: false,
		success: function(data) {
			title = data.title;
			content = data.content;
		}
	});
	if (title) {
		alert('제목에 금지단어(\'' + title + '\')가 포함되어있습니다');
		f.post_title.focus();
		return false;
	}
	if (content) {
		alert('내용에 금지단어(\'' + content + '\')가 포함되어있습니다');
		f.post_content.focus();
		return false;
	}
}
</script>

<?php
if ( element('is_use_captcha', element('board', $view)) ) {
	if ($this->cbconfig->item('use_recaptcha')) {
		$this->managelayout->add_js(base_url('assets/js/recaptcha.js'));
	} else {
		$this->managelayout->add_js(base_url('assets/js/captcha.js'));
	}
}
?>
<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fwrite').validate({
		rules: {
			post_title: {required :true, minlength:2, maxlength:60},
			post_content : {<?php echo (element('use_dhtml', element('board', $view))) ? 'required_' . $this->cbconfig->item('post_editor_type') : 'required'; ?> : true }
<?php if (element('is_post_name', element('post', $view))) { ?>
			, post_nickname: {required :true, minlength:2, maxlength:20}
			, post_email: {required :true, email:true}
<?php } ?>
<?php if ($this->member->is_member() === false) { ?>
			, post_password: {required :true, minlength:4, maxlength:100}
<?php } ?>
<?php if ( element('is_use_captcha', element('board', $view)) ) { ?>
<?php if ($this->cbconfig->item('use_recaptcha')) { ?>
			, recaptcha : {recaptchaKey:true}
<?php } else { ?>
			, captcha_key : {required: true, captchaKey:true}
<?php } ?>
<?php } ?>
<?php if (element('use_category', element('board', $view))) { ?>
			, post_category : {required: true}
<?php } ?>
		},
		messages: {
			recaptcha: '',
			captcha_key: '자동등록방지용 코드가 올바르지 않습니다.'
		}
	});
});

<?php if (element('has_tempsave', $view)) { ?>get_tempsave(cb_board); <?php } ?>
<?php if ( ! element('post_id', element('post', $view))) { ?>window.onbeforeunload = function () { auto_tempsave(cb_board); } <?php } ?>
//]]>
</script>