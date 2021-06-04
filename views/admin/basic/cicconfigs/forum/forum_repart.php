
<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">배팅 마감일</label>
				<div class="col-sm-10 form-inline">
					<input type="datetime" class="form-control datepicker" name="frm_bat_close_datetime" value="<?php echo element('frm_bat_close_datetime', element('forum', $view)); ?>" disabled required />
					<p class="help-block"></p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">포럼 마감일</label>
				<div class="col-sm-10 form-inline" id="datetimepicker1">
					<input type="datetime" class="form-control datepicker" name="frm_bat_close_datetime" value="<?php echo element('frm_close_datetime', element('forum', $view)); ?>" disabled required />
					<p class="help-block"></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">참여금액</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="total_cp" id="total_cp" value="<?php echo number_format(element('total_cp', $view), 2); ?>" disabled required />
					<p class="help-block"></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">A 의견</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="option_a" id="option_a" value="<?php echo number_format(element('cic_A_cp', $view), 2); ?>" disabled required />
					<progress value="<?php echo element('A_per', $view); ?>" max="100"><?php echo element('A_per', $view); ?> %</progress>
					<p class="help-block"><?php echo number_format(element('A_per', $view), 2); ?> %</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">B 의견</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="option_b" id="option_b" value="<?php echo number_format(element('cic_B_cp', $view), 2); ?>" disabled required />
					<progress value="<?php echo element('B_per', $view); ?>" max="100"></progress>
					<p class="help-block"><?php echo number_format(element('B_per', $view), 2); ?> %</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">수수료 설정</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" name="forum_commission" id="forum_commission" style="width:180px;" />
					<p class="help-inline">% &nbsp;&nbsp; 수수료를 설정해주세요.(예: 참여금액10,000cp -> *수수료10% -> 배분시작9,000cp)</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">작성자 보상 설정</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" name="writer_reward" id="writer_reward" style="width:180px;" />
					<p class="help-inline">CP &nbsp;&nbsp; 글 작성자에게 지급할 보상을 설정해주세요.(예: 배분시작9,000cp -> *보상지급1,000cp -> 승리진영에  배분시작8,000cp )</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">배분시작금액</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" name="repart_cp" id="repart_cp" style="width:180px;" disabled required />
					<p class="help-inline">CP &nbsp;&nbsp; 수수료와 보상을 설정하면 확인할수 있습니다</p>
				</div>
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
			frm_bat_close_datetime: { alpha_dash:true, minlength:10, maxlength:10 },
			frm_close_datetime: { alpha_dash:true, minlength:10, maxlength:10 },
		}
	});
});
//]]>
</script>

<script>

	var total_cp = "<?php echo element('total_cp', $view); ?>"

	// 수수료 설정
	var oldVal1 = '';
	$(document).on("propertychange change keyup paste input","#forum_commission",function(){
		var currentVal = $(this).val();
		if(currentVal == oldVal1) {
			return;
		}

		var writer_reward = $('#writer_reward').val(); // 작성자 보상
		var commission = total_cp * (currentVal / 100); // 수수료

		var repart_cp = Number(total_cp) - (Number(writer_reward) + Number(commission));

		$('#repart_cp').val(repart_cp);
		
		oldVal1 = currentVal;
	});

	// 작성자 보상 설정
	var oldVal2 = '';
	$(document).on("propertychange change keyup paste input","#writer_reward",function(){
		var currentVal = $(this).val();
		if(currentVal == oldVal2) {
			return;
		}

		var commission = $('#forum_commission').val();
		commission = total_cp * (commission / 100); // 수수료

		var repart_cp = Number(total_cp) - (Number(currentVal) + Number(commission));
		
		$('#repart_cp').val(repart_cp);
		
		oldVal2 = currentVal;
	});
</script>
