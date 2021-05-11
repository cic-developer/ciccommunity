<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="container-wrap">
	<div id="contents" class="div-cont">
		<?php
			echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
			echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
			$attributes = array('class' => 'form-horizontal', 'name' => 'fwrite', 'id' => 'fwrite', 'onsubmit' => 'return submitContents(this)');
			echo form_open_multipart(current_full_url(), $attributes);
		?>
		<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('post', $view)); ?>" />
		<!-- page start // --><div class="board-wrap write">
			<h3><?php echo html_escape(element('board_name', element('board', $view))); ?> 글쓰기</h3>
			<div class="entry">
				<ul>
					<li>
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
				</ul>
			</div>

			<?php
			if (element('link_count', element('board', $view)) > 0) {
				$link_count = element('link_count', element('board', $view));
				for ($i = 0; $i < $link_count; $i++) {
					$link = html_escape(element('pln_url', element($i, element('link', $view))));
					$link_column = $link ? 'post_link_update[' . element('pln_id', element($i, element('link', $view))) . ']' : 'post_link[' . $i . ']';
			?>
				<div class="form-group">
					<label for="<?php echo $link_column; ?>" class="col-sm-2 control-label">링크 #<?php echo $i+1; ?></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="<?php echo $link_column; ?>" id="<?php echo $link_column; ?>" value="<?php echo set_value($link_column, $link); ?>" />
					</div>
				</div>
			<?php
				}
			}
			if (element('use_upload', element('board', $view))) {
				$file_count = element('upload_file_count', element('board', $view));
				for ($i = 0; $i < $file_count; $i++) {
					$download_link = html_escape(element('download_link', element($i, element('file', $view))));
					$file_column = $download_link ? 'post_file_update[' . element('pfi_id', element($i, element('file', $view))) . ']' : 'post_file[' . $i . ']';
					$del_column = $download_link ? 'post_file_del[' . element('pfi_id', element($i, element('file', $view))) . ']' : '';
			?>
				<div class="form-group">
					<div class="thumbnail" style="width: 80px; height: 80px; outline: 1px dotted red;"><img src="../assets/images/visual-img03.jpg" alt="썸네일"></div>
					<label for="<?php echo $file_column; ?>" class="col-sm-2 control-label">대표이미지 #</label>
					<div class="col-sm-10">
						<input type="file" class="form-control" name="<?php echo $file_column; ?>" id="<?php echo $file_column; ?>" />
						<?php if ($download_link) { ?>
							<a href="<?php echo $download_link; ?>"><?php echo html_escape(element('pfi_originname', element($i, element('file', $view)))); ?></a>
							<label for="<?php echo $del_column; ?>">
								<input type="checkbox" name="<?php echo $del_column; ?>" id="<?php echo $del_column; ?>" value="1" <?php echo set_checkbox($del_column, '1'); ?> /> 삭제
							</label>
						<?php } ?>
					</div>
				</div>
			<?php
				}
			}
			?>
			<?php if (element('use_post_tag', element('board', $view)) && element('can_tag_write', element('board', $view))) { ?>
				<div class="form-group">
					<label for="post_tag" class="col-sm-2 control-label">태그</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="post_tag" id="post_tag" value="<?php echo set_value('post_tag', element('post_tag', element('post', $view))); ?>" /> <div class="help-block">태그를 콤마(,)로 구분해 입력해주세요. 예) 자유,인기,질문</div>
					</div>
				</div>
			<?php } ?>
			<?php if ( element('is_use_captcha', element('board', $view)) ) { ?>
				<div class="well well-sm form-inline passcord">
					<?php if ($this->cbconfig->item('use_recaptcha')) { ?>
						<div class="captcha" id="recaptcha"><button type="button" id="captcha"></button></div>
						<input type="hidden" name="recaptcha" />
					<?php } else { ?>
						<ul>
							<li><img src="<?php echo base_url('assets/images/preload.png'); ?>" width="160" height="40" id="captcha" alt="captcha" title="captcha" /></li>
							<li><input type="text" class="form-control col-md-4" id="captcha_key" name="captcha_key" /></li>
							<li>좌측에 보이는 문자를 입력해주세요.</li>
						</ul>
					<?php } ?>
				</div>
			<?php } ?>
			<div class="lower">
				<button type="submit" class="enter-btn"><span>등록하기</span></button>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>


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
