

<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/hotfix.css'); ?>

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
			<h3>도전 포럼 등록 <p style="font-size: 13px; margin-top: 9px; color: red;">cic 포럼은 한번에 하나의 포럼만 개설 하실 수 있으며 포럼 개설 신청 후 승인-마감 혹은 반려 전까지 다른 포럼을 개설 하실수 없습니다 포럼 개설 신청은 신중하게 진행해 주세요 </p></h3>
			<div class="entry">
				<ul>
					<li>
						<p class="btxt">포럼 주제</p>
						<div class="field">
							<p class="chk-input w100p">
								<input id="post_title" type="text" name="post_title" placeholder="포럼 주제를 입력해주세요" value="<?php echo set_value('post_title', element('post_title', element('post', $view))); ?>">
							</p>
						</div>
					</li>
					<li class="no-pad">
						<!-- <div class="field report">
							<p class="btxt">A.의견</p>
							<p class="chk-input w100p">
								<input type="text" placeholder="" value="간다">
							</p>
						</div>
						<div class="field report mg20t">
							<p class="btxt">B.의견</p>
							<p class="chk-input w100p">
								<input type="text" placeholder="" value="안간다">
							</p>
						</div> -->
						<?php
						if (element('extra_content', $view)) {
							foreach (element('extra_content', $view) as $key => $value) {
								if(element('field_name', $value) == 'A_opinion' 
										|| element('field_name', $value) == 'B_opinion' ){
						?>
							<span><?php echo element('display_name', $value); ?></span>
							<?php echo element('input', $value); ?>
						<?php
										}
							}
						}
						?>
					</li>
					<li class="no-pad">
					<?php echo display_dhtml_editor('post_content', set_value('post_content', element('post_content', element('post', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = element('use_dhtml', element('board', $view)), $editor_type = $this->cbconfig->item('post_editor_type')); ?>
					</li>
				</ul>
			</div>
			<div class="lower">
				<!-- <a href="javascript:void(0);" class="enter-btn"><span>포럼 등록하기</span></a> -->
				<button type="submit" class="enter-btn"><span>등록하기</span></button>
			</div>
		</div>
		<?php echo form_close(); ?>
		<!-- page end // -->
	</div>
</div>


<style>
#element_to_pop_up { 
    background-color:#fff;
    border-radius:15px;
    color:#000;
    display:none; 
    padding:20px;
    min-width: 500px;
    min-height: 180px;
}
.b-close{
    cursor:pointer;
    position:absolute;
    right:15px;
    top:10px;
}
.modal-header{
	height : 35px;
	border-bottom : 1px solid rgba(0,0,0,0.2);
}
.modal-body{
	margin-top : 20px;
}
.header_text{
	font-size : 25px;
	font-weight : bold;
}
.body-text__header{
	font-size : 18px;
	font-weight : bold;
}
.body-text{
	font-size:15px;
}
</style>

<!-- 모달 팝업 -->
<div id="element_to_pop_up">
    <div class="modal-content" >
			<div class="modal-header">
					<span class="header_text">미션 참여 안내</span>
					<a class="b-close" style="font-size:25px" >×</a>
			</div>
			<div class="modal-body">
					<p class="body-text__header"><span style="color:red; font-size:22px;">잠깐!</span> 포럼등록 전에 확인해주세요.<br></p><br>
					<p class="body-text">
						- 포럼은 동시에 하나의 포럼만 등록할 수 있어요.<br>
						<br>
						- 게시된 포럼의 내용은 수정하거나 삭제할 수 없으니 신중하게 작성해 주세요.<br>
						<br>
						- 포럼이 종료되거나 반려 처리된 후 다시 포럼을 등록할 수 있어요.<br>
						<br>
						- 포럼의 내용은 <span style="color:blue; font-weight:bold">[포럼 가이드]</span> 안내에 따라 작성하셔야 반려 처리되지 않으니 꼭 참고해 주세요.<br>
						<br>
						- 포럼 예치 CP는 포럼이 진행 중이지 않을 때 언제든 예치 해제하실 수 있어요.<br>
						<br>
					</p>
			</div>
			<div class="modal-footer">
					<div class="btn-group">
					</div>
			</div>
	</div>
</div>

<!-- bpopup 스크립트 불러오기-->
<script src="jquery.bpopup-0.1.1.min.js"></script>

<script>
$( document ).ready(function() {
	$('#element_to_pop_up').bPopup({
		easing: 'easeOutBack', //uses jQuery easing plugin
    speed: 450,
    transition: 'slideDown'
	});
});
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