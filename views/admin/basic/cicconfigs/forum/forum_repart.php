<script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
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
				<label class="col-sm-2 control-label">의견 변경 마감일</label>
				<div class="col-sm-10 form-inline">
					<input type="datetime" class="form-control datepicker" name="frm_change_close_datetime" value="<?php echo element('frm_change_close_datetime', element('forum', $view)); ?>" disabled />
					<p class="help-block"></p>
				</div>
			</div>
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
				<label class="col-sm-2 control-label">A 의견 <input id="win_option" name="win_option" value="A" type="radio" required/></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="option_a" id="option_a" value="<?php echo number_format(element('cic_A_cp', $view), 2); ?>" origin-value="<?php echo element('cic_A_cp', $view)?>" disabled />
					<progress value="<?php echo element('A_per', $view); ?>" max="100"><?php echo element('A_per', $view); ?> %</progress>
					<p class="help-block"><?php echo number_format(element('A_per', $view), 2); ?> %</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">B 의견 <input id="win_option" name="win_option" value="B" type="radio" required/></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="option_b" id="option_b" value="<?php echo number_format(element('cic_B_cp', $view), 2); ?>" origin-value="<?php echo element('cic_B_cp', $view)?>" disabled />
					<progress value="<?php echo element('B_per', $view); ?>" max="100"></progress>
					<p class="help-block"><?php echo number_format(element('B_per', $view), 2); ?> %</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">베팅 적용 마감일</label>
				<div class="col-sm-10 form-inline" >
					<div class="form-group">
						<div class='input-group date' id='datetimepicker'>
							<input type='text' class="form-control" name="application_deadline" value=""/>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar">
								</span>
							</span>
						</div>
						<p class="help-block">해당 마감일 이후에 베팅된 의견은 원금반환만 됩니다.</p>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">수수료 설정</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" name="forum_commission" id="forum_commission" 
					value="<?php echo element('frm_repart_commission', element('forum', $view)); ?>"
					style="width:180px;" required />
					<p class="help-inline">% &nbsp;&nbsp; 수수료를 설정해주세요.(예: 참여CP10,000cp -> *수수료10% -> 배분시작9,000cp)</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">작성자 보상 설정</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" name="writer_reward" id="writer_reward" style="width:180px;" />
					<p class="help-inline">CP &nbsp;&nbsp; 글 작성자에게 지급할 보상을 설정해주세요.(해당 보상은 관리자가 직접 수여하는 cp 입니다. 포럼 결과에 영향을 미치지 않습니다.)</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">작성자 보상 설정</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" name="prop_writer_reward" id="prop_writer_reward" 
					value="<?php echo element('frm_repart_reward', element('forum', $view)); ?>"
					style="width:180px;" required/>
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
			win_option: {required: true},
			forum_commission: { required: true, min:0 , max: 100 },
			prop_writer_reward: { required: true, min:0 , max: 100 },
		}
	});
});
//]]>
</script>

<script>

	var total_cp = 0; // 총 cp
	var win_cp = 0; // 승리 진영 cp
	// 수수료 설정
	var oldVal1 = 0;

	$("input[name=win_option]").on('change', function(){
		let _checked_val = $("input[type=radio][name=win_option]:checked").val();
		switch(_checked_val){
			case 'A' :
				win_cp = $("#option_a").attr('origin-value');
				total_cp = $("#option_b").attr('origin-value');
				break;
			case 'B' :
				win_cp = $("#option_b").attr('origin-value');
				total_cp = $("#option_a").attr('origin-value');
				break;
			default :
				alert('A 또는 B 의견을 선택해주세요');
				return;
		}

		var currentVal = $("#forum_commission").val() * 1;
		var value2 = $("#prop_writer_reward").val() * 1;

		var writer_reward = total_cp * ( value2 / 100); // 작성자 보상
		var commission = total_cp * (currentVal / 100); // 수수료
		

		var repart_cp = Number(total_cp) - (Number(writer_reward) + Number(commission));
		
		$('#repart_cp').val(repart_cp.toFixed(2));

		if($('#repart_cp').val()){
			var repart_ratio = repart_cp / Number(win_cp);
			$('#repart_ratio').val(repart_ratio.toFixed(2));
		}
	});


	$(document).on("propertychange change keyup paste input","#forum_commission",function(){
		let _checked_val = $("input[type=radio][name=win_option]:checked").val();
		switch(_checked_val){
			case 'A' :
				win_cp = $("#option_a").attr('origin-value');
				total_cp = $("#option_b").attr('origin-value');
				break;
			case 'B' :
				win_cp = $("#option_b").attr('origin-value');
				total_cp = $("#option_a").attr('origin-value');
				break;
			default :
				alert('A 또는 B 의견을 선택해주세요');
				return;
		}

		var currentVal = $("#forum_commission").val() * 1;
		var value2 = $("#prop_writer_reward").val() * 1;

		var writer_reward = total_cp * ( value2 / 100); // 작성자 보상
		var commission = total_cp * (currentVal / 100); // 수수료
		

		var repart_cp = Number(total_cp) - (Number(writer_reward) + Number(commission));
		
		$('#repart_cp').val(repart_cp.toFixed(2));

		if($('#repart_cp').val()){
			var repart_ratio = repart_cp / Number(win_cp);
			$('#repart_ratio').val(repart_ratio.toFixed(2));
		}

	});

	$(document).on("propertychange change keyup paste input","#prop_writer_reward",function(){
		let _checked_val = $("input[type=radio][name=win_option]:checked").val();
		switch(_checked_val){
			case 'A' :
				win_cp = $("#option_a").attr('origin-value');
				total_cp = $("#option_b").attr('origin-value');
				break;
			case 'B' :
				win_cp = $("#option_b").attr('origin-value');
				total_cp = $("#option_a").attr('origin-value');
				break;
			default :
				alert('A 또는 B 의견을 선택해주세요');
				return;
		}

		var currentVal = $("#forum_commission").val() * 1;
		var value2 = $("#prop_writer_reward").val() * 1;

		var writer_reward = total_cp * ( value2 / 100); // 작성자 보상
		var commission = total_cp * (currentVal / 100); // 수수료
		

		var repart_cp = Number(total_cp) - (Number(writer_reward) + Number(commission));
		
		$('#repart_cp').val(repart_cp.toFixed(2));

		if($('#repart_cp').val()){
			var repart_ratio = repart_cp / Number(win_cp);
			$('#repart_ratio').val(repart_ratio.toFixed(2));
		}
	});

	$(document).ready(function(){
		var frmbatclosedatetime = "<?php echo set_value('frm_bat_lose_datetime',  element('frm_bat_close_datetime', element('forum', $view))); ?>";
		$('#datetimepicker').datetimepicker({
			format : 'YYYY-MM-DD HH:mm:ss',
			defaultDate : frmbatclosedatetime
		});
	});

</script>
