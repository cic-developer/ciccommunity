<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">코인 id</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="cml_id" value="<?php echo set_value('cml_id', element('cml_id', element('data', $view))); ?>" />
					<p class="help-block">API 사용시 구분자로 활용됩니다.</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">코인 심볼</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="cml_symbol" value="<?php echo set_value('cml_symbol', element('cml_symbol', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">코인이름 - 한글</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="cml_korean_nm" value="<?php echo set_value('cml_korean_nm', element('cml_korean_nm', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">코인이름 - 영문</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="cml_english_nm" value="<?php echo set_value('cml_english_nm', element('cml_english_nm', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">기본으로 설정</label>
				<div class="col-sm-10">
					<label for="cml_default" class="checkbox-inline">
						<input type="checkbox" name="cml_default" id="cml_default" value="1" <?php echo set_checkbox('cml_default', '1', (element('cml_default', element('data', $view)) ? true : false)); ?> /> 기본 코인으로 설정합니다.
					</label>
					<p class="help-block">비회원이거나, 유저가 별도 설정하지 않은 경우 기본적으로 노출됩니다.</p>
				</div>
			</div>
			<div class="btn-group pull-right" role="group" aria-label="...">
				<a href="<?php echo element('list_url', $view); ?>" class="btn btn-default btn-sm" >목록</a>
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
			cml_id: { required: true, minlength:2, maxlength:20 },
			cml_korean_nm: {required :true, minlength:2, maxlength:10 },
			cml_english_nm: {required :true, minlength:2, maxlength:20 },
			cml_api: {required :true},
		}
	});
});
//]]>
</script>
