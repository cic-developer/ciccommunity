<div class="box">
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
				<input type="hidden" name="cpc_id[]" value="<?php echo element('cpc_id', $value) ?>"/>
				<label class="col-sm-3 control-label"><?php echo element('cpc_title', $value)."<br/>(".element('cpc_description', $value).")"?></label>
					<div class="col-sm-8">
						활성화 -
						<label for="cpc_enable" class="control-label">
							<select name="cpc_enable[]" id="doc_layout" class="form-control">
								<option value="0" <?php echo element('cpc_enable', $value) === '0' ? 'selected' : ''; ?>>비활성</option>
								<option value="1" <?php echo element('cpc_enable', $value) === '1' ? 'selected' : '';; ?>>활성</option>
							</select>
						</label>
		
						비율/절대값 -
						<label for="cpc_class" class="control-label">
							<select name="cpc_class[]" id="doc_layout" class="form-control">
								<option value="1" <?php echo element('cpc_class', $value) === '1' ? 'selected' : ''; ?>>비율</option>
								<option value="2" <?php echo element('cpc_class', $value) === '2' ? 'selected' : ''; ?>>절대값</option>
							</select>
						</label>
				
						지급 비율/절대값 -
						<label for="cpc_value" class="control-label">
							<input type="number" class="form-control" name="cpc_value[]" id="cpc_value" value="<?php echo element('cpc_value', $value)?>">
						</label>
					</div>
			</div>
		<?php } ?>

			<div class="form-group">
				<label class="col-sm-3 control-label">추천/비추천 최대최소 입력 포인트<br/>(게시글 추천/비추천 시 입력할 수 있는 VP)</label>
				<div class="col-sm-8">
					최소 입력 VP - 
					<label for="like_min_vp" class="control-label">
						<input type="number" id="like_min_vp" value="<?php echo element('cfg_value',element('like_min_vp', $view))?>" name="like_min_vp"/>
					</label>

					최대 입력 VP - <?php echo element('cfg', $view)?>
					<label for="like_max_vp" class="control-label">
						<input type="number" id="like_max_vp" value="<?php echo element('cfg_value',element('like_max_vp', $view))?>" name="like_max_vp"/>
					</label>
				</div>
			</div>
			
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
