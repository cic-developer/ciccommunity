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
				<label class="col-sm-2 control-label">거래소 id</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="cme_id" value="<?php echo set_value('cme_id', element('cme_id', element('data', $view))); ?>" />
					<p class="help-block">고유한 거래소 id입니다. Coingecko API를 사용하는 경우 거래소 구분자로 활용됩니다.</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">거래소명 - 한글</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="cme_korean_nm" value="<?php echo set_value('cme_korean_nm', element('cme_korean_nm', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">거래소명 - 영문</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="cme_english_nm" value="<?php echo set_value('cme_english_nm', element('cme_english_nm', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">API 선택</label>
				<div class="col-sm-10 form-inline">
					<select name="cme_api" class="form-control">
						<option value="coingecko" <?php echo set_select('cme_api', 'coingecko', element('cme_api', element('data', $view)) === 'coingecko' ? true : false); ?>>Coingecko</option>
						<option value="hotbit_korea" <?php echo set_select('cme_api', 'hotbit_korea', element('cme_api', element('data', $view)) === 'hotbit_korea' ? true : false); ?>>핫빗코리아</option>
					</select>
					<p class="help-block">레벨을 수동으로 설정하여도 해당 유저의 명예포인트에 따라 자동으로 변동됩니다.</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">기본으로 설정</label>
				<div class="col-sm-10">
					<label for="cme_default" class="checkbox-inline">
						<input type="checkbox" name="cme_default" id="cme_default" value="1" <?php echo set_checkbox('cme_default', '1', (element('cme_default', element('data', $view)) ? true : false)); ?> /> 기본 거래소로 설정합니다.
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
			cme_id: { required: true, minlength:2, maxlength:20 },
			cme_korean_nm: {required :true, minlength:2, maxlength:10 },
			cme_english_nm: {required :true, minlength:2, maxlength:20 },
			cme_api: {required :true},
		}
	});
});
//]]>
</script>
