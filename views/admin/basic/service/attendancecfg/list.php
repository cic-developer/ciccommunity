<div class="box">
	<div class="box-header">
		<ul class="nav nav-tabs">
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir); ?>">일반기능</a></li>
			<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/list'); ?>">출석체크 리스트</a></li>
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/points'); ?>">시간/포인트설정</a></li>
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/cleanlog'); ?>">오래된 로그삭제</a></li>
		</ul>
	</div>
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped">
            </table>
		</div>
		<div class="box-info">
		</div>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fadminwrite').validate({
		rules: {
			day: {required:true, number:true, min:0}
		}
	});
});
//]]>
</script>
