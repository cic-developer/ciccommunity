<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '../css/hotfix.css'); ?>

<div id="container-wrap">
	<div id="contents" class="div-cont">
		<?php
			echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
			echo show_alert_message($this->session->flashdata('message'), '<script>alert("', '");</script>');
			$attributes = array('class' => 'form-horizontal', 'name' => 'fwrite', 'id' => 'fwrite', 'onsubmit' => 'return submitContents(this)');
			echo form_open_multipart(current_full_url(), $attributes);
		?>
		<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('post', $view)); ?>" />
		<!-- page start // -->
		<div class="board-wrap write">
			<h3>Writer 신청</h3>
			<div class="entry">
				<ul>
					<li class="title-box">
						<p class="btxt">제목</p>
						<div class="field">
							<p class="chk-input w100p">
								<input id="contactus_title" type="text" name="contactus_title" placeholder="제목을 입력해주세요" value="<?php echo set_value('contactus_title', element('contactus_title', element('post', $view))); ?>" />
							</p>
						</div>
					</li>
					<li class="no-pad">
						<?php echo display_dhtml_editor('contactus_content', set_value('contactus_content', element('contactus_content', element('post', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = true, $editor_type = 'smarteditor'); ?>
					</li>
					<li class="title-box">
						<p class="btxt">스팸방지</p>
						<div class="field">
							<p class="chk-input">
                                <img src="<?php echo base_url('assets/images/preload.png'); ?>" width="160" height="40" id="captcha" alt="captcha" title="captcha" />
                                <input type="text" class="input col-md-4" id="captcha_key" name="captcha_key" />
							</p>
						</div>
					</li>
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

<script type="text/javascript">
$('#fwrite').on('submit', function(){
    //여러번 클릭 방지
    $('.enter-btn').attr('disabled', 'disabled');
})

function submitContents(f) {
	if ($('#char_count')) {
		if (char_min > 0 || char_max > 0) {
			var cnt = parseInt(check_byte('contactus_content', 'char_count'));
			if (char_min > 0 && char_min > cnt) {
				alert('내용은 ' + char_min + '글자 이상 쓰셔야 합니다.');
				$('#contactus_content').focus();
				return false;
			} else if (char_max > 0 && char_max < cnt) {
				alert('내용은 ' + char_max + '글자 이하로 쓰셔야 합니다.');
				$('#contactus_content').focus();
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
			title: f.contactus_title.value,
			content: f.contactus_content.value,
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
		f.contactus_title.focus();
		return false;
	}
	if (content) {
		alert('내용에 금지단어(\'' + content + '\')가 포함되어있습니다');
		f.contactus_content.focus();
		return false;
	}
}
</script>

<?php
    //Codeigniter Captcha
    $this->managelayout->add_js(base_url('assets/js/captcha.js'));
?>
<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fwrite').validate({
		rules: {
			contactus_title: {required :true, minlength:2, maxlength:60},
			contactus_content : {required_smarteditor : true }
			, captcha_key : {required: true, captchaKey:true}
		},
		messages: {
			recaptcha: '',
			captcha_key: '자동등록방지용 코드가 올바르지 않습니다.'
		}
	});
});
//]]>
</script>