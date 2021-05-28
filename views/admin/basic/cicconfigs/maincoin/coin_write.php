<div class="box">
<?php
if (element(element('primary_key', $view), element('data', $view))) {
	// print_r(element(element('primary_key', $view), element('data', $view)));
	// exit;
?>
	<div class="box-header">
		<h4 class="pb10 pull-left"><?php echo element('cmc_symbol', element('data', $view)) ? element('cmc_symbol', element('data', $view)).' ' : '' ?>코인 <?php echo element(element('primary_key', $view), element('data', $view)) ? '수정' : '추가';?></h4>
		<div class="clearfix"></div>
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/coin_write/' . element('cmc_idx', element('data', $view))); ?>" onclick="return check_form_changed();">기본정보</a></li>
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/coin_write_exchange/' . element('cmc_idx', element('data', $view))); ?>" onclick="return check_form_changed();">거래소 설정</a></li>
		</ul>
	</div>
<?php
} else {
?>
	<div class="box-header">
		<h4 class="pb10 pull-left">코인 <?php echo element(element('primary_key', $view), element('data', $view)) ? '수정' : '추가';?></h4>
		<div class="clearfix"></div>
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="javascript:;" >기본정보</a></li>
			<li role="presentation"><a href="javascript:;" onClick="alert('기본정보를 저장하신 후에 다른 정보 수정이 가능합니다');">거래소 설정</a></li>
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
				<label class="col-sm-2 control-label">코인 심볼</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="cmc_symbol" value="<?php echo set_value('cmc_symbol', element('cmc_symbol', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">코인이름 - 한글</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="cmc_korean_nm" value="<?php echo set_value('cmc_korean_nm', element('cmc_korean_nm', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">코인이름 - 영문</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="cmc_english_nm" value="<?php echo set_value('cmc_english_nm', element('cmc_english_nm', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">기본노출 설정</label>
				<div class="col-sm-10">
					<label for="cmc_default" class="checkbox-inline">
						<input type="checkbox" name="cmc_default" id="cmc_default" value="1" <?php echo set_checkbox('cmc_default', '1', (element('cmc_default', element('data', $view)) ? true : false)); ?> <?php echo element('cmc_default', element('data', $view)) == 2 ? 'disabled' : '' ?>/> 기본 코인으로 설정합니다.
						<?php 
							if(element('cmc_default', element('data', $view)) == 2){
						?>
							<input type="hidden" name="cmc_default" value="2"/>
						<?php
							}
						?>
					</label>
					<p class="help-block">비회원이거나, 유저가 별도 설정하지 않은 경우 기본적으로 노출됩니다.</p>
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
			cmc_korean_nm: {required :true, minlength:2, maxlength:10 },
			cmc_english_nm: {required :true, minlength:2, maxlength:20 },
			cmc_symbol: {required :true, minlength:2, maxlength:20 },
		}
	});
});
//]]>
</script>
