
<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">배팅 마감일</label>
				<div class="col-sm-10 form-inline">
					<input type="datetime" class="form-control datepicker" name="frm_bat_close_datetime" value="<?php echo element('frm_bat_close_datetime', element('forum', $view)); ?>" disabled required />
					<p class="help-block"></p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">포럼 마감일</label>
				<div class="col-sm-10 form-inline" id="datetimepicker1">
					<input type="datetime" class="form-control datepicker" name="frm_bat_close_datetime" value="<?php echo element('frm_close_datetime', element('forum', $view)); ?>" disabled required />
					<p class="help-block"></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">참여금액</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="post_id" id="post_id" value="<?php echo number_format(element('total_cp', $view), 2); ?>" disabled required />
					<p class="help-block"></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">A 의견</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="post_id" id="post_id" value="<?php echo number_format(element('cic_A_cp', $view), 2); ?>" disabled required />
					<p class="help-block"></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">B 의견</label>
				<div class="col-sm-10">
					<input style="" type="text" class="form-control" name="post_id" id="post_id" value="<?php echo number_format(element('cic_B_cp', $view), 2); ?>" disabled required />
					<p class="help-block"></p>
				</div>
			</div>

			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-default btn-sm btn-history-back" >취소하기</button>
				<button type="submit" class="btn btn-success btn-sm">저장하기</button>
			</div>

		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fadminwrite').validate({
		rules: {
			frm_bat_close_datetime: { alpha_dash:true, minlength:10, maxlength:10 },
			frm_close_datetime: { alpha_dash:true, minlength:10, maxlength:10 },
		}
	});
});
//]]>
</script>
