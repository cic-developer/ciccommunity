<div class="box">
		<div class="box-table">
			<div class="box-table-header">
				<ul class="nav nav-pills">
				<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir); ?>" onclick="return check_form_changed();">기본정보</a></li>
					<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/disapproval_forum'); ?>" onclick="return check_form_changed();"> 도전! CIC포럼 </a></li>
					<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/proceeding_forum'); ?>" onclick="return check_form_changed();">진행중포럼</a></li>
					<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/close_forum'); ?>" onclick="return check_form_changed();">마감된포럼</a></li>
					<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/return_forum'); ?>" onclick="return check_form_changed();">반려된포럼</a></li>
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
					<label class="col-sm-2 control-label">포럼 예치CP</label>
					<div class="col-sm-10">
						<input type="number" class="form-control" name="forum_deposit" id="forum_deposit" value="<?php echo set_value('forum_deposit', element('forum_deposit', element('data', $view))); ?>" style="width:180px;" /> CP &nbsp;&nbsp;&nbsp; 도전 CIC포럼 기본 CP를 설정할 수 있습니다.
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">포럼 진영 변경 수수료</label>
					<div class="col-sm-10">
						<input type="number" class="form-control" name="forum_bat_change_commission" id="forum_bat_change_commission" value="<?php echo set_value('forum_bat_change_commission', element('forum_bat_change_commission', element('data', $view))); ?>" style="width:180px;" /> % &nbsp;&nbsp;&nbsp; CIC포럼 행사 진영 변경 수수료를 설정할 수 있습니다.
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">포럼 최대 행사금액</label>
					<div class="col-sm-10">
						<input type="number" class="form-control" name="forum_bat_max" id="forum_bat_max" value="<?php echo set_value('forum_bat_max', element('forum_bat_max', element('data', $view))); ?>" style="width:180px;" /> CP &nbsp;&nbsp;&nbsp; CIC포럼 최대 행사금액을 설정할 수 있습니다. ( 0 입력시 해당 설정이 비활성화 됩니다. )
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">포럼 최소 행사금액</label>
					<div class="col-sm-10">
						<input type="number" class="form-control" name="forum_bat_min" id="forum_bat_min" value="<?php echo set_value('forum_bat_min', element('forum_bat_min', element('data', $view))); ?>" style="width:180px;" /> CP &nbsp;&nbsp;&nbsp; CIC포럼 최소 행사금액을 설정할 수 있습니다. ( 0 입력시 해당 설정이 비활성화 됩니다. )
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