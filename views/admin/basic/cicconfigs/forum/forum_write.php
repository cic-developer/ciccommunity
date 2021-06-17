<script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
<div class="box">


	<div class="box-table">
	
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>" value="<?php echo element(element('primary_key', $view), element('frminfodata', $view)); ?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">대표 이미지 선택</label>
				<div class="col-sm-10">
					<?php
					if (element('frm_image', element('data', $view))) {
					?>
						<img src="<?php echo forum_image_url(element('frm_image', element('data', $view)), '', 150); ?>" alt="포럼 이미지" title="포럼 이미지" />
					<?php
					}
					?>
					<input type="file" name="frm_image" id="frm_image" />
					<p class="help-block">gif, jpg, png 파일 업로드가 가능합니다</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">배팅 변경 마감일</label>
				<div class="col-sm-10 form-inline" style="height:130px;">
					<div class="form-group">
						<div class='input-group date' id='datetimepicker12'>
							<input type='text' class="form-control" name="frm_change_close_datetime" value="<?php echo set_value('frm_close_datetime', element('frm_close_datetime', element('frminfodata', $view))); ?>"/>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
						<p class="help-block"> 포럼 마감일은 배팅 마감일 이후로 설정해야합니다.</p>
					</div>
				</div>
				<label class="col-sm-2 control-label">배팅 마감일</label>
				<div class="col-sm-10 form-inline" style="height:130px;">
					<div class="form-group">
						<div class='input-group date' id='datetimepicker10'>
							<input type='text' class="form-control" name="frm_bat_close_datetime" value="<?php echo set_value('frm_bat_close_datetime',element('frm_bat_close_datetime', element('frminfodata', $view))); ?>"/>
							<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar">
							</span>
							</span>
						</div>
						<p class="help-block">배팅 마감일은 포럼 마감일 이전으로 설정해야합니다.</p>
					</div>
				</div>
				<label class="col-sm-2 control-label">포럼 마감일</label>
				<div class="col-sm-10 form-inline" style="height:130px;">
					<div class="form-group">
						<div class='input-group date' id='datetimepicker11'>
							<input type='text' class="form-control" name="frm_close_datetime" value="<?php echo set_value('frm_close_datetime', element('frm_close_datetime', element('frminfodata', $view))); ?>"/>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
						<p class="help-block"> 포럼 마감일은 배팅 마감일 이후로 설정해야합니다.</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">포럼 TITLE</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="post_title" value="<?php echo set_value('post_title', element('post_title', element('postdata', $view))); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">포럼 CONTENT</label>
					<div class="col-sm-10">
						<div class="form-group col-sm-12">
							<?php echo display_dhtml_editor('post_content', set_value('post_content', element('post_content', element('postdata', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = true, $editor_type = "smarteditor"); ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">투표 A</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="pev_value_0" value="<?php echo set_value('pev_value_0', element('pev_value', element('pevdata0', $view))); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">투표 B</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="pev_value_1" value="<?php echo set_value('pev_value_1', element('pev_value', element('pevdata1', $view))); ?>" />
					</div>
				</div>
	
				<script type="text/javascript">
				var frmbatclosedatetime = "<?php echo set_value('frm_bat_lose_datetime', element('frm_bat_close_datetime', element('frminfodata', $view))); ?>";
				var frmclosedatetime = "<?php echo set_value('frm_close_datetime', element('frm_close_datetime', element('frminfodata', $view))); ?>";
				var frmchangeclosedatetime = "<?php echo set_value('frm_change_close_datetime', element('frm_change_close_datetime', element('frminfodata', $view))); ?>";

					$(document).ready(function(){
						$('#datetimepicker10').datetimepicker({
							format : 'YYYY-MM-DD HH:mm:ss',
							defaultDate : frmbatclosedatetime ? frmbatclosedatetime : new Date()
						});
						$('#datetimepicker11').datetimepicker({
							format : 'YYYY-MM-DD HH:mm:ss',
							defaultDate : frmclosedatetime ? frmclosedatetime : new Date()
						});
						$('#datetimepicker12').datetimepicker({
							format : 'YYYY-MM-DD HH:mm:ss',
							defaultDate : frmchangeclosedatetime ? frmchangeclosedatetime : new Date()
						});
					})
				</script>
			</div>
			
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-default btn-sm btn-history-back" >취소하기</button>
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
			frm_bat_close_datetime: {'required' : true},
			frm_close_datetime: {'required' : true},
			frm_change_close_datetime: {'required' : true},
			post_title: {'required' : true},
			post_content : {'required_smarteditor' : true },
		}
	});
});
//]]>
</script>
