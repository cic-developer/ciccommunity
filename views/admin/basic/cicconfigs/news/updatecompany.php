<div class="box">
	<div class="box-header">
		<h4 class="pb10 pull-left">거래소 <?php echo element(element('primary_key', $view), element('data', $view)) ? '수정' : '추가';?></h4>
        <?php
        print_r(element('primary_key', $view), $result);
        exit;
        ?>
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
					<input type="text" class="form-control" name="cme_korean_nm" value="<?php echo set_value('comp_url', element('comp_url', element('data', $view))); ?>" />
                    <p class="help-block">신문사 URL을 입력 하세요.</p>
                </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Segment</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="cme_english_nm" value="<?php echo set_value('comp_segment', element('comp_segment', element('data', $view))); ?>" />
                    <p class="help-block">크롤링에 사용되는 segment를 입력하세요.</p>
                </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">활성화/비활성화</label>
				<div class="col-sm-10 form-inline">
					<select name="cme_api" class="form-control">
						<option value="0" <?php echo set_select('comp_active', 0 , element('comp_active', element('data', $view)) === '0' ? true : false); ?>>바활성화</option>
						<option value="1" <?php echo set_select('comp_active', 1 , element('comp_active', element('data', $view)) === '1' ? true : false); ?>>활성화</option>
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
			comp_url: {required :true, minlength:2, maxlength:50 },
			comp_segment: {required :true, minlength:2, maxlength:50 },
		}
	});
});
//]]>
</script>
