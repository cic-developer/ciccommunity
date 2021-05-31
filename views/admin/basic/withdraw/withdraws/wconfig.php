<div class="box">
		<div class="box-table">
			<div class="box-table-header">
				<ul class="nav nav-pills">
					<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir); ?>" onclick="return check_form_changed();">기본정보</a></li>
					<li role="presentation"><a href="<?php echo admin_url($this->pagedir . ''); ?>" onclick="return check_form_changed();"> - </a></li>
					<li role="presentation"><a href="<?php echo admin_url($this->pagedir . ''); ?>" onclick="return check_form_changed();"> - </a></li>
					<li role="presentation"><a href="<?php echo admin_url($this->pagedir . ''); ?>" onclick="return check_form_changed();"> - </a></li>
					<li role="presentation"><a href="<?php echo admin_url($this->pagedir . ''); ?>" onclick="return check_form_changed();"> - </a></li>
					<li role="presentation"><a href="<?php echo admin_url($this->pagedir . ''); ?>" onclick="return check_form_changed();"> - </a></li>
					<li role="presentation"><a href="<?php echo admin_url($this->pagedir . ''); ?>" onclick="return check_form_changed();"> - </a></li>
				</ul>
			</div>
			<div class="box-table">
			<?php
			echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
			echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
			$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
			echo form_open(current_full_url(), $attributes);
			?>
				<input type="hidden" name="is_submit" value="2" />
				<div class="form-group">
					<label class="col-sm-2 control-label">출금요청 수수료 설정</label>
					<div class="col-sm-10">
						<input type="number" class="form-control" name="withdraw_deposit" id="withdraw_deposit" value="<?php echo set_value('withdraw_deposit', (int) element('withdraw_deposit', element('data', $view))); ?>" style="width:180px;" /> CP &nbsp;&nbsp;&nbsp; 출금요청 수수료를 설정할 수 있습니다.
					</div>
					<label class="col-sm-2 control-label">출금요청 최소금액 설정</label>
					<div class="col-sm-10">
						<input type="number" class="form-control" name="withdraw_minimum" id="withdraw_minimum" value="<?php echo set_value('withdraw_minimum', (int) element('withdraw_minimum', element('data', $view))); ?>" style="width:180px;" /> % &nbsp;&nbsp;&nbsp; 출금요청 최소금액을 설정할 수 있습니다.
					</div>
				</div>

				<div class="btn-group pull-right" role="group" aria-label="...">
					<button type="submit" class="btn btn-success btn-sm">저장하기</button>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fadminwrite').validate({
		rules: {
			forum_deposit: {required :true, number : true, min:1},
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