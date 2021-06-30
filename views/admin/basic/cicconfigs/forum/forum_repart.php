
<div class="box">
	<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<script>alert("', '")</script>');
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">행사 마감일</label>
				<div class="col-sm-10 form-inline">
					<input type="datetime" class="form-control datepicker" name="frm_bat_close_datetime" value="<?php echo element('frm_bat_close_datetime', element('forum', $view)); ?>" disabled />
					<p class="help-block"></p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">포럼 마감일</label>
				<div class="col-sm-10 form-inline" id="datetimepicker1">
					<input type="datetime" class="form-control datepicker" name="frm_bat_close_datetime" value="<?php echo element('frm_close_datetime', element('forum', $view)); ?>" disabled />
					<p class="help-block"></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">참여CP</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="total_cp" id="total_cp" value="<?php echo number_format(element('total_cp', $view), 2); ?>" disabled />
					<p class="help-block"></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">A 의견 </label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="option_a" id="option_a" value="<?php echo number_format(element('cic_A_cp', $view), 2); ?>" disabled />
					<progress value="<?php echo element('A_per', $view); ?>" max="100"><?php echo element('A_per', $view); ?> %</progress>
					<p class="help-block"><?php echo number_format(element('A_per', $view), 2); ?> %</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">B 의견</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="option_b" id="option_b" value="<?php echo number_format(element('cic_B_cp', $view), 2); ?>" disabled />
					<progress value="<?php echo element('B_per', $view); ?>" max="100"></progress>
					<p class="help-block"><?php echo number_format(element('B_per', $view), 2); ?> %</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">수수료 설정</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" name="forum_commission" id="forum_commission" style="width:180px;" required />
					<p class="help-inline">% &nbsp;&nbsp; 수수료를 설정해주세요.(예: 참여CP10,000cp -> *수수료10% -> 배분시작9,000cp)</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">작성자 보상 설정</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" name="writer_reward" id="writer_reward" style="width:180px;" onchange="reward_check(this)" required/>
					<p class="help-inline">CP &nbsp;&nbsp; 글 작성자에게 지급할 보상을 설정해주세요.(예: 배분시작9,000cp -> *보상지급1,000cp -> 승리진영에  배분시작8,000cp)</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">작성자 보상 설정</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" name="prop_writer_reward" id="prop_writer_reward" style="width:180px;" onchange="reward_check(this)" required/>
					<p class="help-inline">% &nbsp;&nbsp; 글 작성자에게 지급할 보상을 설정(%)해주세요.(예: 배분시작9,000cp -> *보상지급1,000cp -> 승리진영에  배분시작8,000cp)</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">배분시작금액</label>
				<div class="col-sm-10 repart-cp-box">
					<input type="number" class="form-control" name="repart_cp" id="repart_cp" style="width:180px;" disabled />
					<p class="help-inline">CP &nbsp;&nbsp; 수수료와 보상을 설정하면 확인할수 있습니다 (배분 시작금액을 승리의견 금액보다 높게 설정해주세요)</p>
					<p class="repart-msg" style="color:red; display:none;">배분 시작금액이 승리의견금액 보다 낮습니다!</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">배분 비율</label>
				<div class="col-sm-10 repart-cp-box">
					<input type="number" class="form-control" name="repart_ratio" id="repart_ratio" style="width:180px;" disabled />
					<p class="help-inline">CP &nbsp;&nbsp; 1cp당 지급 비율</p>
					<p class="repart-msg" style="color:red; display:none;">배분 시작금액이 승리의견금액 보다 낮습니다!</p>
				</div>
			</div>

			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-default btn-sm btn-history-back" >취소하기</button>
				<!-- <?php echo element('B_per', $view); ?> -->
				<button type="submit" class="btn btn-success btn-sm">보상배분</button>
			</div>

		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
$(function() {

	$('#fadminwrite').validate({
		rules: {
			forum_commission: { required: true, min:0 , max: 100 },
			writer_reward: { required: true, min: 0 }//, max: total_cp },
			prop_writer_reward: { required: true, min:0 , max: 100 },
		}
	});
});
//]]>
</script>

<script>

	var total_cp = "<?php echo element('total_cp', $view); ?>"; // 총 cp
	var win_cp = "<?php echo element('cic_A_cp', $view) >= element('cic_B_cp', $view) ? element('cic_A_cp', $view) : element('cic_B_cp', $view); ?>"; // 승리 진영 cp

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
	

		$('#repart_cp').val(repart_cp.toFixed(2));

		if($('#repart_cp').val()){
			var repart_ratio = repart_cp / Number(win_cp);
			$('#repart_ratio').val(repart_ratio.toFixed(2));
		}

		if(Number(win_cp) > repart_cp){
			$('.repart-msg').attr('style', "color:red; display:block;");
		}else{
			$('.repart-msg').attr('style', "display:none;");
		}

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
		
		$('#repart_cp').val(repart_cp.toFixed(2));

		if($('#repart_cp').val()){
			var repart_ratio = repart_cp / Number(win_cp);
			$('#repart_ratio').val(repart_ratio.toFixed(2));
		}

		if(Number(win_cp) > repart_cp){
			$('.repart-msg').attr('style', "color:red; display:block;");
		}else{
			$('.repart-msg').attr('style', "display:none;");
		}

		oldVal2 = currentVal;
	});

	var oldVal3 = '';
	$(document).on("propertychange change keyup paste input","#prop_writer_reward",function(){
		var currentVal = $(this).val();
		if(currentVal == oldVal3) {
			return;
		}

		var commission = $('#forum_commission').val();
		commission = total_cp * (commission / 100); // 수수료
		var repart_cp = Number(total_cp) - ((Number(total_cp) * (Number(currentVal) / 100))+ Number(commission));

		$('#repart_cp').val(repart_cp.toFixed(2));

		if($('#repart_cp').val()){
			var repart_ratio = repart_cp / Number(win_cp);
			$('#repart_ratio').val(repart_ratio.toFixed(2));
		}

		if(Number(win_cp) > repart_cp){
			$('.repart-msg').attr('style', "color:red; display:block;");
		}else{
			$('.repart-msg').attr('style', "display:none;");
		}

		oldVal3 = currentVal;
	});

	function reward_check(e){
		if($(e).attr('id') === 'writer_reward'){
			$("#writer_reward").attr("required" , true);
			$('#prop_writer_reward').val('');
			$("#prop_writer_reward").attr("required" , false);
		}else{
			$("#prop_writer_reward").attr("required" , true);
			$('#writer_reward').val('');
			$("#writer_reward").attr("required" , false);
		}
	}
</script>
