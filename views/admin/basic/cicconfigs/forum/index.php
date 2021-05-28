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
				<input type="hidden" name="is_submit" value="1" />
				<div class="form-group">
					<label class="col-sm-2 control-label">회원가입시 포인트</label>
					<div class="col-sm-10">
						<input type="number" class="form-control" name="point_register" id="point_register" value="<?php echo set_value('point_register', (int) element('point_register', element('data', $view))); ?>" />
					</div>
				</div>

				<div class="btn-group pull-right" role="group" aria-label="...">
					<button type="submit" class="btn btn-success btn-sm">저장하기</button>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>