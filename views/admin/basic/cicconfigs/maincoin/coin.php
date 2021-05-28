<div class="box">
		<div class="box-table">
			<?php
			// print_r(get_coin_price('coingecko', 'ethereum', 'KRW', 'upbit'));
			echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
			$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
			echo form_open(current_full_url(), $attributes);
			?>
				<div class="box-table-header">
					<ul class="nav nav-pills">
						<li role="presentation"><a href="<?php echo admin_url($this->pagedir); ?>">거래소목록</a></li>
						<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/coin'); ?>">코인목록</a></li>
					</ul>
					<?php
					ob_start();
					?>
						<div class="btn-group pull-right" role="group" aria-label="...">
							<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
							<button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected disabled" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택삭제</button>
							<a href="<?php echo element('write_url', $view); ?>" class="btn btn-outline btn-danger btn-sm " >코인 추가</a>
						</div>
					<?php
					$buttons = ob_get_contents();
					ob_end_flush();
					?>
				</div>
				<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
				<div class="table-responsive">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th><a href="<?php echo element('cme_orderby', element('sort', $view)); ?>">번호</a></th>
								<th>코인 이름</th>
								<th>코인 심볼</th>
								<th>기본노출설정</th>
								<th>순서변경</th>
								<th>수정</th>
								<th><input type="checkbox" name="chkall" id="chkall" /></th>
							</tr>
						</thead>
						<tbody>
						<?php
						if (element('list', element('data', $view))) {
							foreach (element('list', element('data', $view)) as $result) {
						?>
							<tr data-idx="<?php echo element('cmc_idx', $result)?>">
								<td><?php echo number_format(element('num', $result)); ?></td>
								<td><?php echo html_escape(element('cmc_korean_nm', $result)); ?></td>
								<td><?php echo html_escape(element('cmc_symbol', $result)); ?></td>
								<td><?php echo (element('cmc_default', $result) == 1) ? '기본' : (element('cmc_default', $result) == 2 ? '필수' : ''); ?></td>
								<td><span class="orderby_up" style="cursor:pointer;">업</span> / <span class="orderby_down" style="cursor:pointer;">다운</span></td>
								<td><a href="<?php echo admin_url($this->pagedir); ?>/coin_write/<?php echo element(element('primary_key', $view), $result); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>" class="btn btn-outline btn-default btn-xs">수정</a></td>
								<td><input type="checkbox"  class="list-chkbox" value="<?php echo element(element('primary_key', $view), $result); ?>" <?php echo element('cmc_default', $result) == 2 ? 'disabled' : 'name="chk[]"'?> /></td>
							</tr>
						<?php
							}
						}
						if ( ! element('list', element('data', $view))) {
						?>
							<tr>
								<td colspan="12" class="nopost">자료가 없습니다</td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="box-info">
				<?php echo element('paging', $view); ?>
				<div class="pull-left ml20"><?php echo admin_listnum_selectbox();?></div>
				<?php echo $buttons; ?>
			</div>
		<?php echo form_close(); ?>
	</div>
	<form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
		<div class="box-search">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<select class="form-control" name="sfield" >
						<?php echo element('search_option', $view); ?>
					</select>
					<div class="input-group">
						<input type="text" class="form-control" name="skeyword" value="<?php echo html_escape(element('skeyword', $view)); ?>" placeholder="Search for..." />
						<span class="input-group-btn">
							<button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
						</span>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	$('.orderby_up').on('click', function(){
		set_orderby(this, 'up');
	});
	$('.orderby_down').on('click', function(){
		set_orderby(this, 'down');
	});

	function set_orderby(_this, type){
		const cmc_idx = $(_this).parents('tr').attr('data-idx');
        $.ajax({
            url: cb_admin_url + '/cicconfigs/maincoin/ajax_set_coin_orderby',
            type: 'post',
            data: {
                cmc_idx: cmc_idx,
                type: type,
                csrf_test_name: cb_csrf_hash
            },
            dataType: 'json',
            async: false,
            cache: false,
            success: function(data) {
				if(data.error){
					alert(data.error);
				}
				if(data.success){
					alert(data.success);
					location.reload();
				}
            }
        });
	}
</script>