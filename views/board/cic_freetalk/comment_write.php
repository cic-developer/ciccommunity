

<div class="ov" id="comment_write_box">
	<?php
	$attributes = array('name' => 'fcomment', 'id' => 'fcomment');
	echo form_open('', $attributes);
	?>
		<input type="hidden" name="mode" id="mode" value="c" />
		<input type="hidden" name="post_id" value="<?php echo element('post_id', element('post', $view)); ?>" />
		<input type="hidden" name="cmt_id" value="" id="cmt_id" />
		<input type="hidden" name="cmt_page" value="" id="cmt_page" />
		<textarea class="form-control" name="cmt_content" id="cmt_content" accesskey="c" placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."<?php if ( ! element('can_comment_write', element('comment', $view))) {echo 'onClick="alert(\'' . html_escape(element('can_comment_write_message', element('comment', $view))) . '\');return false;"';} ?>><?php echo set_value('cmt_content', element('cmt_content', element('comment', $view))); ?></textarea>
		<div class="btns">
			<button type="button" class="write-btn" id="cmt_btn_submit"onClick="<?php if ( ! element('can_comment_write', element('comment', $view))) {echo 'alert(\'' . html_escape(element('can_comment_write_message', element('comment', $view))) . '\');return false;"';} else { ?>add_comment(this.form, '<?php echo element('post_id', element('post', $view)); ?>');<?php } ?> "><span>댓글등록</span></a>
		</div>
	<?php echo form_close(); ?>
</div>

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
