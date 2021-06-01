
<div id="container-wrap">
    <div id="contents" class="div-cont">
        <!-- page start // -->
        <div class="member-wrap appear">
            <div class="filter">
                <div class="month">
                    <p><?php echo cdate('Y.m', strtotime($_date)); ?></p>
                </div>
                <div class="abr">
                    <div class="field date">
                        <p class="chk-input">
                            <input type="text" value="<?php echo cdate('Y-m', strtotime($_date))?>" autocomplete="off">
                        </p>
                    </div>
                    <a href="<?php echo base_url("attendance?date=".cdate('Y-m-d', strtotime('-1 month', strtotime($_date)))); ?>" class="cprev"><span class="blind">이전</span></a>
                    <a href="<?php echo base_url("attendance?date=".cdate('Y-m-d', strtotime('+1 month', strtotime($_date)))); ?>" class="cnext"><span class="blind">다음</span></a>
                </div>
            </div>
            <div class="calendar">
                <table>
                    <colgroup>
                        <col width="14.2857%">
                        <col width="14.2857%">
                        <col width="14.2857%">
                        <col width="14.2857%">
                        <col width="14.2857%">
                        <col width="14.2857%">
                        <col width="14.2857%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>일<span>요일</span></th>
                            <th>월<span>요일</span></th>
                            <th>화<span>요일</span></th>
                            <th>수<span>요일</span></th>
                            <th>목<span>요일</span></th>
                            <th>금<span>요일</span></th>
                            <th>토<span>요일</span></th>
                        </tr>
                    </thead>
                    <tbody>
					<?php for($n = 1, $i = 0; $i < $total_week; $i++){ ?>
						<tr>
							<!-- 1일부터 7일 (한 주) -->
							<?php for ($k = 0; $k < 7; $k++){ ?>
									<!-- 시작 요일부터 마지막 날짜까지만 날짜를 보여주도록 -->
									<?php 
									if ( ($n > 1 || $k >= $start_week) && ($total_day >= $n) ){ 
										$_active = in_array($n, $view['my_attend']);
									?>
									<!-- 현재 날짜를 보여주고 1씩 더해줌 -->
									<td>
										<div class="con <?php echo $_active ? 'active' : ''; ?>">
											<p class="day"><?php echo $n++ ?></p>
											<a href="#n" class="chk-btn"><span class="blind">출석체크</span></a>
										</div>
									</td>
										
									<?php } else if ($total_day < $n){ ?>

										<td class="after">
											<div class="con">
												<p class="day"><?php echo $after_date++; ?></p>
											</div>
										</td>

									<?php } else if($n <= 1 && $k < $start_week) { ?>
										<td class="before">
											<div class="con">
												<p class="day"><?php echo $before_date++; ?></p>
											</div>
										</td>
									<?php } ?>
							<?php } ?> 
						</tr>
					<?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="lower">
				<?php
				$attributes = array('class' => '', 'name' => 'attendanceform', 'id' => 'attendanceform');
				echo form_open('', $attributes);
				?>
				<input type="hidden" name="memo" value="<?php echo html_escape(element(0, element('default_memo', $view))); ?>" id="att_memo" class="input" onClick="this.value='';" />
                <button type="button" id="add_attendance" class="enter-btn"><span>출석하기</span></button>
				<?php echo form_close(); ?>
            </div>
        </div>
        <!-- page end // -->
    </div>
</div>
<script type="text/javascript">
//<![CDATA[

var memos = new Array();
<?php
if (element('default_memo', $view)) {
	foreach (element('default_memo', $view) as $key => $val) {
?>
	memos[<?php echo $key; ?>] = '<?php echo html_escape($val);?>';
<?php
	}
}
?>

var is_submit_attendance = false;

$(document).on('click', '#add_attendance', function() {
	if (is_submit_attendance === true) {
		return false;
	}

	is_submit_attendance = true;

	$('#attendanceform').validate();
	if ($('#attendanceform').valid()) // check if form is valid
	{
		// do some stuff
	}
	else
	{
		is_submit_attendance = false;
		return false;
		// just show validation errors, dont post
	}

	$.ajax({
		url : cb_url + '/attendance/update',
		type : 'POST',
		cache : false,
		data : $('#attendanceform').serialize(),
		dataType : 'json',
		success : function(data) {
			is_submit_attendance = false;
			if (data.error) {
				alert(data.error);
				return false;
			} else if (data.success) {
				alert(data.success);
				location.reload();
			}
		},
		error : function(data) {
			is_submit_attendance = false;
			alert('오류가 발생하였습니다.');
			return false;
		}
	});
});

$(function() {
	$('#attendanceform').validate({
		rules: {
			memo : { required:true
			<?php if ($this->cbconfig->item('attendance_memo_length')) {?>
				, maxlength:<?php echo $this->cbconfig->item('attendance_memo_length'); ?>
			<?php } ?>
			}
		}
	});
});
//]]>
</script>