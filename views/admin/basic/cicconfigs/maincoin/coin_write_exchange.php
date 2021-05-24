<div class="box">
	<div class="box-header">
		<h4 class="pb10 pull-left">코인 <?php echo element(element('primary_key', $view), element('data', $view)) ? '수정' : '추가';?></h4>
		<div class="clearfix"></div>
		<ul class="nav nav-tabs">
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/coin_write/' . element('cmc_idx', element('data', $view))); ?>" onclick="return check_form_changed();">기본정보</a></li>
			<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/coin_write_exchange/' . element('cmc_idx', element('data', $view))); ?>" onclick="return check_form_changed();">거래소 설정</a></li>
		</ul>
	</div>
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
					<div class="col-sm-1">순번</div>
					<div class="col-sm-4">거래소명</div>
					<div class="col-sm-5">코인 id</div>
					<div class="col-sm-2">사용여부</div>
				</div>
				<div id="sortable">
					<?php
					if (element('list', element('exchange_list', $view))) {
						foreach (element('list', element('exchange_list', $view)) as $result) {
					?>
						<div class="form-group list-group-item">
							<div class="col-sm-1"><?php echo element('num', $result); ?></div>
							<div class="col-sm-4"><input type="text" class="form-control" name="mgr_title[<?php echo element('mgr_id', $result); ?>]" value="<?php echo html_escape(element('mgr_title', $result)); ?>"/></div>
							<div class="col-sm-5"><input type="text" class="form-control" name="mgr_description[<?php echo element('mgr_id', $result); ?>]" value="<?php echo html_escape(element('mgr_description', $result)); ?>" /></div>
							<div class="col-sm-2"><input type="checkbox" name="mgr_is_default[<?php echo element('mgr_id', $result); ?>]" value="1" <?php echo element('mgr_is_default', $result) ? ' checked="checked" ' : ''; ?> /></div>
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
