
<?php
$attributes = array('name' => 'fcomment', 'id' => 'fcomment');
echo form_open('', $attributes);
?>
	<input type="hidden" name="mode" id="mode" value="c" />
	<input type="hidden" name="post_id" value="<?php echo element('post_id', element('post', $view)); ?>" />
	<input type="hidden" name="cmt_id" value="" id="cmt_id" />
	<input type="hidden" name="cmt_page" value="" id="cmt_page" />
	<?php
	if (element('is_comment_name', element('comment', $view))) {
	?>
		<div class="form-group col-md-6">
			<label for="cmt_nickname">이름</label>
			<input type="text" class="form-control" id="cmt_nickname" name="cmt_nickname" value="<?php echo set_value('cmt_nickname'); ?>" />
		</div>
		<div class="form-group col-md-6">
			<label for="cmt_password">비밀번호</label>
			<input type="password" class="form-control" id="cmt_password" name="cmt_password" />
		</div>
	<?php
	}
	?>
	<textarea class="form-control" name="cmt_content" id="cmt_content" rows="5" accesskey="c" <?php if ( ! element('can_comment_write', element('comment', $view))) {echo 'onClick="alert(\'' . html_escape(element('can_comment_write_message', element('comment', $view))) . '\');return false;"';} ?>><?php echo set_value('cmt_content', element('cmt_content', element('comment', $view))); ?></textarea>
	<?php if (element('comment_min_length', element('board', $view)) OR element('comment_max_length', element('board', $view))) { ?>
		<div class="well well-sm" style="margin:15px 0;">
			현재 <strong><span id="char_count">0</span></strong> 글자이며,
			<?php if (element('comment_min_length', element('board', $view))) { ?>
				최소 <strong><?php echo number_format(element('comment_min_length', element('board', $view))); ?></strong> 글자 이상
			<?php } if (element('comment_max_length', element('board', $view))) { ?>
				최대 <strong><?php echo number_format(element('comment_max_length', element('board', $view))); ?></strong> 글자 이하
			<?php } ?>
			입력하실 수 있습니다.
		</div>
	<?php } ?>
	<div class="comment_write_button_area">
		<div class="form-group pull-left">
			<button type="button" class="btn btn-danger btn-sm" id="cmt_btn_submit" onClick="<?php if ( ! element('can_comment_write', element('comment', $view))) {echo 'alert(\'' . html_escape(element('can_comment_write_message', element('comment', $view))) . '\');return false;"';} else { ?>add_comment(this.form, '<?php echo element('post_id', element('post', $view)); ?>');<?php } ?> ">댓글등록</button>
		</div>

		<div class="btn-group pull-right" role="group" aria-label="...">
			<?php if (element('can_comment_secret', element('comment', $view))) { ?>
				<div class="checkbox pull-left mr10">
					<label for="cmt_secret">
						<input type="checkbox" name="cmt_secret" id="cmt_secret" value="1" <?php echo set_checkbox('cmt_secret', '1', (element('cmt_secret', element('comment', $view)) ? true : false)); ?> /> 비밀글
					</label>
				</div>
			<?php } ?>
			<?php if (element('use_emoticon', element('comment', $view))) { ?>
				<button type="button" class="btn btn-default btn-sm" title="이모티콘" onclick="window.open('<?php echo site_url('helptool/emoticon?id=cmt_content'); ?>', 'emoticon', 'width=600,height=400,scrollbars=yes')"><i class="fa fa-smile-o fa-lg"></i></button>
			<?php } ?>
			<?php if (element('use_specialchars', element('comment', $view))) { ?>
				<button type="button" class="btn btn-default btn-sm" title="특수문자" onclick="window.open('<?php echo site_url('helptool/specialchars?id=cmt_content'); ?>', 'specialchars', 'width=490,height=245,scrollbars=yes')"><i class="fa fa-star-o fa-lg"></i></button>
			<?php } ?>
			<button type="button" class="btn btn-default btn-sm" title="새글등록" onClick="comment_box('', 'c');"><i class="fa fa-pencil fa-lg"></i></button>
			<button type="button" class="btn btn-default btn-sm" title="창을크게" onClick="resize_textarea('cmt_content', 'down');"><i class="fa fa-plus fa-lg"></i></button>
			<button type="button" class="btn btn-default btn-sm" title="창을작게" onClick="resize_textarea('cmt_content', 'up');"><i class="fa fa-minus fa-lg"></i></button>
		</div>
	</div>
	<?php if ($this->member->is_member() === false) { ?>
		<div class="form-inline passcord">
			<?php if ($this->cbconfig->item('use_recaptcha')) { ?>
				<div class="captcha" id="recaptcha"></div>
				<button type="button" id="captcha" style="display:none;"></button>
				<input type="hidden" name="recaptcha" />
			<?php } else { ?>
				<div class="form-group"><img src="<?php echo base_url('assets/images/preload.png'); ?>" width="160" height="40" id="captcha" alt="captcha" title="captcha" /></div>
				<div class="form-group">
					<input type="text" class="form-control col-md-4" id="captcha_key" name="captcha_key" />
				</div>
				<div class="form-group">자동등록방지 숫자입력</div>
			<?php } ?>
		</div>
	<?php } ?>
<?php echo form_close(); ?>

<script type="text/javascript">
// 글자수 제한
var char_min = parseInt(<?php echo (int) element('comment_min_length', element('board', $view)); ?>); // 최소
var char_max = parseInt(<?php echo (int) element('comment_max_length', element('board', $view)); ?>); // 최대

<?php if (element('comment_min_length', element('board', $view)) OR element('comment_max_length', element('board', $view))) { ?>

check_byte('cmt_content', 'char_count');
$(function() {
	$(document).on('keyup', '#cmt_content', function() {
		check_byte('cmt_content', 'char_count');
	});
});
<?php } ?>
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/comment.js'); ?>"></script>

<script type="text/javascript">
$(document).ready(function($) {
	view_comment('viewcomment', '<?php echo element('post_id', element('post', $view)); ?>', '', '');
});
</script>

<?php if (element('is_comment_name', element('comment', $view))) { ?>
<?php if ($this->cbconfig->item('use_recaptcha')) { ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/recaptcha.js'); ?>"></script>
<?php } else { ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/captcha.js'); ?>"></script>
<?php } ?>
<?php } ?>
<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fcomment').validate({
		rules: {
<?php if (element('is_comment_name', element('comment', $view))) { ?>
			cmt_nickname: {required :true, minlength:2, maxlength:20},
			cmt_password: {required :true, minlength:<?php echo element('password_length', element('comment', $view)); ?>},
<?php if ($this->cbconfig->item('use_recaptcha')) { ?>
			recaptcha : {recaptchaKey:true},
<?php } else { ?>
			captcha_key : {required: true, captchaKey:true},
<?php } ?>
<?php } ?>
			cmt_content: {required :true},
			mode : {required : true}
		},
		messages: {
			recaptcha: '',
			captcha_key: '자동등록방지용 코드가 올바르지 않습니다.'
		}
	});
});
//]]>
</script>
