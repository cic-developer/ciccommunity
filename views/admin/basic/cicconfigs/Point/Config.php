<div class="box">
	<div class="box-header">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/config'); ?>" onclick="return check_form_changed();">명예포인트 설정</a></li>
		</ul>
	</div>
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open(current_full_url(), $attributes);
		?>
			<input type="hidden" name="is_submit" value="1" />
		<?php foreach(element('list',element('data', $view)) as $value) {?>
			<div class="form-group">
				<input type="hidden" name="pc_id[]" value="<?php echo element('pc_id', $value) ?>"/>
				<label class="col-sm-3 control-label"><?php echo element('pc_title', $value)."<br/>(".element('pc_description', $value).")"?></label>
					<div class="col-sm-8">
						활성화 -
						<label for="pc_enable" class="control-label">
							<select name="pc_enable[]" id="doc_layout" class="form-control">
								<option value="0" <?php echo element('pc_enable', $value) === '0' ? 'selected' : ''; ?>>비활성</option>
								<option value="1" <?php echo element('pc_enable', $value) === '1' ? 'selected' : '';; ?>>활성</option>
							</select>
						</label>
				
						지급 비율/절대값 -
						<label for="pc_value" class="control-label">
							<input type="number" class="form-control" name="pc_value[]" id="pc_value" value="<?php echo element('pc_value', $value)?>">
							<?php echo element('pc_class', $value) === '1' ? '%' : ''; ?>
						</label>
					</div>
			</div>
		<?php } ?>
			
			<div class="btn-group pull-right" role="group" aria-label="...">
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
			point_register: {required :true, number:true},
			point_login: {required :true, number:true},
			point_recommended: {required :true, number:true},
			point_recommender: {required :true, number:true}
		}
	});
});

var form_original_data = $('#fadminwrite').serialize();
function check_form_changed() {
	if ($('#fadminwrite').serialize() !== form_original_data) {
		if (confirm('저장하지 않은 정보가 있습니다. 저장하지 않은 상태로 이동하시겠습니까?')) {
			return true;
		} else {
			return false;
		}
	}
	return true;
}
//]]>
</script>
