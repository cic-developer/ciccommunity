<div class="box">
<?php
if (element(element('primary_key', $view), element('data', $view))) {
	// print_r(element(element('primary_key', $view), element('data', $view)));
	// exit;
?>
	<div class="box-header">
		<h4 class="pb10 pull-left">신문사 정보 <?php echo element(element('primary_key', $view), element('data', $view)) ? '수정' : '추가';?></h4>
		<div class="clearfix"></div>
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/company_write/' . element('cmc_idx', element('data', $view))); ?>" onclick="return check_form_changed();">기본정보</a></li>
		</ul>
	</div>
<?php
} else {
?>
	<div class="box-header">
		<h4 class="pb10 pull-left">신문사 정보 <?php echo element(element('primary_key', $view), element('data', $view)) ? '수정' : '추가';?></h4>
		<div class="clearfix"></div>
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="javascript:;" >신문사 정보</a></li>
		</ul>
	</div>
<?php
}
?>
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
					<input type="text" class="form-control" name="comp_name" value="<?php echo set_value('comp_name', element('comp_name', element('data', $view))); ?>" />
					<p class="help-block">신문사 명을 입력하세요.</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">URL</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="comp_url" value="<?php echo set_value('comp_url', element('comp_url', element('data', $view))); ?>" />
                    <p class="help-block">신문사 URL을 입력 하세요.</p>
                </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Segment</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="comp_segment" value="<?php echo set_value('comp_segment', element('comp_segment', element('data', $view))); ?>" />
                    <p class="help-block">크롤링에 사용되는 segment를 입력하세요.</p>
                </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Title_select</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="comp_title_select" value="<?php echo set_value('comp_title_select', element('comp_title_select', element('data', $view))); ?>" />
                    <p class="help-block">뉴스 제목을 가져오는 부분을 입력하십시오.</p>
                </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Contents_select</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="comp_contents_select" value="<?php echo set_value('comp_contents_select', element('comp_contents_select', element('data', $view))); ?>" />
                    <p class="help-block">뉴스 본문을 가져오는 부분을 입력하시오.</p>
                </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Contents_select</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="comp_img_select" value="<?php echo set_value('comp_img_select', element('comp_img_select', element('data', $view))); ?>" />
                    <p class="help-block">뉴스 이미지를 가져오는 부분을 입력하시오.</p>
                </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Wrapper</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="comp_wrapper" value="<?php echo set_value('comp_wrapper', element('comp_wrapper', element('data', $view))); ?>" />
                    <p class="help-block">뉴스 contents 감싸는 id 또는 class.</p>
                </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">활성화/비활성화</label>
				<div class="col-sm-10 form-inline">
					<label for="cmc_default" class="checkbox-inline">
						<input type="checkbox" name="comp_active" id="comp_active" value="1" <?php echo set_checkbox('comp_active', '1', (element('comp_active', element('data', $view)) ? true : false)); ?> /> 활성화
					</label>
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
			comp_name:{required :true, minlength:2, maxlength:15},
			comp_url: {required :true, minlength:2, maxlength:50 },
			comp_segment: {required :true, minlength:2, maxlength:50 },
			comp_title_select: {required :true, minlength:2, maxlength:50 },
			comp_contents_select: {required :true, minlength:2, maxlength:50 },
			comp_img_select: {required :true, minlength:2, maxlength:50 },
			comp_wrapper: {required :true, minlength:2, maxlength:50 }
		}
	});
});
//]]>
</script>
