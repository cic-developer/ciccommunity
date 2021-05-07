<script type="text/javascript" src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">명예 등급 이름</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="mlc_title" value="<?php echo set_value('mlc_title', element('mlc_title', element('data', $view))); ?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">명예 등급 Lv</label>
				<div class="col-sm-10 form-inline">
					<input type="number" class="form-control" name="mlc_level" value="<?php echo set_value('mlc_level', element('mlc_level', element('data', $view))); ?>" />
					명예 기본 등급은 1부터 시작입니다. 관리자 레벨은 100입니다. 1보다 큰 수를 입력하는것이 좋습니다.
				</div>
			</div>
            
			<div class="form-group">
				<label class="col-sm-2 control-label">명예 등급 도달 포인트</label>
				<div class="col-sm-10 form-inline">
					<input type="number" class="form-control" name="mlc_target_point" value="<?php echo set_value('mlc_target_point', element('mlc_target_point', element('data', $view))); ?>" />
				</div>
			</div>
            
			<div class="form-group">
				<label class="col-sm-2 control-label">활성화 여부</label>
				<div class="col-sm-10 form-inline">
                    <select name="mlc_enable" class="form-control">
                        <option value="0" <?php echo element('mlc_enable', element('data', $view)) == 0 ? 'selected':''?>>비활성</option>
                        <option value="1" <?php echo element('mlc_enable', element('data', $view)) == 1 ? 'selected':''?>>활성</option>
                    </select>
				</div>
			</div>
            
			<div class="form-group">
				<label class="col-sm-2 control-label">아이콘</label>
				<div class="col-sm-10 form-inline">
                    <img class="col-sm-2" src="<?php echo thumb_url('mlc_attach', element('mlc_attach', element('data', $view)), 200, 160); ?>" alt="등급 아이콘" title="등급 아이콘" />
                    <input type="file" name="mlc_attach" id="mlc_attach" />
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
			mem_userid: { required: true, minlength:3, maxlength:20 },
			mem_username: {minlength:2, maxlength:20 },
			mem_nickname: {required :true, minlength:2, maxlength:20 },
			mem_email: {required :true, email:true },
			mem_password: {minlength :4 }
		}
	});
});
//]]>
</script>
