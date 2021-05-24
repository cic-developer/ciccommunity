<div class="box">
<?php
if (element(element('primary_key', $view), element('data', $view))) {
?>
	<div class="box-header">
		<h4 class="pb10 pull-left">코인 <?php echo element(element('primary_key', $view), element('data', $view)) ? '수정' : '추가';?></h4>
		<div class="clearfix"></div>
		<ul class="nav nav-tabs">
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/coin_write/' . element('cmc_idx', element('data', $view))); ?>" onclick="return check_form_changed();">기본정보</a></li>
			<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/coin_write_exchange/' . element('cmc_idx', element('data', $view))); ?>" onclick="return check_form_changed();">거래소 설정</a></li>
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
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<input type="hidden" name="s" value="1" />
			<div class="box-table-header">
				<div class="btn-group pull-right" role="group" aria-label="...">
					<button type="submit" class="btn btn-outline btn-danger btn-sm">저장하기</button>
				</div>
			</div>
			<div class="row"><?php echo element('total_rows', element('data', $view), 0); ?>개의 그룹이 존재합니다</div>
			<div class="list-group">
				<div class="form-group list-group-item">
					<div class="col-sm-1">순서변경</div>
					<div class="col-sm-3">그룹명</div>
					<div class="col-sm-4">설명</div>
					<div class="col-sm-1">기본그룹</div>
					<div class="col-sm-1">회원수</div>
					<div class="col-sm-2"><button type="button" class="btn btn-outline btn-primary btn-xs btn-add-rows">추가</button></div>
				</div>
				<div id="sortable">
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<div class="form-group list-group-item">
							<div class="col-sm-1"><div class="fa fa-arrows" style="cursor:pointer;"></div><input type="hidden" name="mgr_id[<?php echo element('mgr_id', $result); ?>]" value="<?php echo element('mgr_id', $result); ?>" /></div>
							<div class="col-sm-3"><input type="text" class="form-control" name="mgr_title[<?php echo element('mgr_id', $result); ?>]" value="<?php echo html_escape(element('mgr_title', $result)); ?>"/></div>
							<div class="col-sm-4"><input type="text" class="form-control" name="mgr_description[<?php echo element('mgr_id', $result); ?>]" value="<?php echo html_escape(element('mgr_description', $result)); ?>" /></div>
							<div class="col-sm-1"><input type="checkbox" name="mgr_is_default[<?php echo element('mgr_id', $result); ?>]" value="1" <?php echo element('mgr_is_default', $result) ? ' checked="checked" ' : ''; ?> /></div>
							<div class="col-sm-1"><?php echo element('member_count', $result); ?></div>
							<div class="col-sm-2"><button type="button" class="btn btn-outline btn-default btn-xs btn-delete-row" >삭제</button></div>
						</div>
					<?php
						}
					}
					?>
				</div>
			</div>
			<div class="row">기본그룹에 체크하시면, 회원가입시 해당 그룹에 자동으로 추가됩니다. 그룹삭제시, 복구가 불가하므로 주의하여 주시기 바랍니다.</div>
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
