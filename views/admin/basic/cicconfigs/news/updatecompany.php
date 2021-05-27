<div class="box">
	<div class="box-header">
		<h4 class="pb10 pull-left">거래소 <?php echo element(element('primary_key', $view), element('data', $view)) ? '수정' : '추가';?></h4>
		<div class="clearfix"></div>
	</div>
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">신문사 이름</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="cme_id" value="<?php echo set_value('comp_name', element('comp_name', element('data', $view))); ?>" />
					<p class="help-block">신문사 명을 입력하세요.</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">URL</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="cme_korean_nm" value="<?php echo set_value('cme_korean_nm', element('cme_korean_nm', element('data', $view))); ?>" />
                    <p class="help-block">신문사 URL을 입력 하세요.</p>
                </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Segment</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="cme_english_nm" value="<?php echo set_value('cme_english_nm', element('cme_english_nm', element('data', $view))); ?>" />
                    <p class="help-block">크롤링에 사용되는 segment를 입력하세요.</p>
                </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">활성화/비활성화</label>
				<div class="col-sm-10 form-inline">
					<select name="cme_api" class="form-control">
						<option value="coingecko" <?php echo set_select('cme_api', 'coingecko', element('cme_api', element('data', $view)) === 'coingecko' ? true : false); ?>>Coingecko</option>
						<option value="hotbit_korea" <?php echo set_select('cme_api', 'hotbit_korea', element('cme_api', element('data', $view)) === 'hotbit_korea' ? true : false); ?>>핫빗코리아</option>
					</select>
					<p class="help-block">해당 신문사를 크롤링 하려면 활성화 그렇지 않다면 비활성화를 선택하세요.</p>
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
			cme_logo: {required :true},
			cme_api: {required :true},
		}
	});
});
//]]>
</script>
