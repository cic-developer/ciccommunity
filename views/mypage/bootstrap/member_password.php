<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<div class="mypage">
	<div class="page-header">
		<h4>회원 비밀번호 확인</h4>
	</div>

	<?php
	echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
	echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
	?>

	<div class="form-horizontal mt20">
		<?php
		$attributes = array('class' => 'form-horizontal', 'name' => 'fconfirmpassword', 'id' => 'fconfirmpassword');
		echo form_open(current_url(), $attributes);
		?>
			<div class="form-group">
				<label for="mem_userid" class="col-sm-3 control-label">아이디</label>
				<div class="col-sm-9">
					<p class="form-control-static"><strong><?php echo $this->member->item('mem_userid'); ?></strong></p>
				</div>
			</div>
			<div class="form-group">
				<label for="mem_password" class="col-sm-3 control-label">비밀번호</label>
				<div class="col-sm-9">
					<input type="password" class="form-control px150" id="mem_password" name="mem_password" />
					<button type="submit" class="btn btn-primary btn-sm">확인</button>
					<span class="help-block">
						<span class="fa fa-exclamation-circle"></span>
						외부로부터 회원님의 정보를 안전하게 보호하기 위해 비밀번호를 확인하셔야 합니다.
					</span>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fconfirmpassword').validate({
		rules: {
			mem_password : { required:true, minlength:4 }
		}
	});
});
//]]>
</script>
