<div class="box">
		<div class="box-table">
				<div class="box-table-header">
					<ul class="nav nav-pills">
                        <li role="presentation"><a href="<?php echo admin_url($this->pagedir); ?>" onclick="return check_form_changed();">기본정보</a></li>
                        <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/disapproval_forum'); ?>" onclick="return check_form_changed();"> 승인대기포럼 </a></li>
                        <li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/proceeding_forum'); ?>" onclick="return check_form_changed();">진행중포럼</a></li>
                        <li role="presentation"><a href="<?php echo admin_url($this->pagedir . ''); ?>" onclick="return check_form_changed();"> - </a></li>
                        <li role="presentation"><a href="<?php echo admin_url($this->pagedir . ''); ?>" onclick="return check_form_changed();"> - </a></li>
                        <li role="presentation"><a href="<?php echo admin_url($this->pagedir . ''); ?>" onclick="return check_form_changed();"> - </a></li>
                        <li role="presentation"><a href="<?php echo admin_url($this->pagedir . ''); ?>" onclick="return check_form_changed();"> - </a></li>
					</ul>
					<?php
					ob_start();
					?>
						<div class="btn-group pull-right" role="group" aria-label="...">
							<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
							<!-- <button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected disabled" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택삭제</button> -->
							<!-- <a href="<?php echo element('write_url', $view); ?>" class="btn btn-outline btn-danger btn-sm " >거래소 추가</a> -->
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
								<th>이미지</th>
								<th>제목</th>
								<th>작성자</th>
								<th>조회</th>
								<th>날짜</th>
								<th>배팅마감</th>
								<th>포럼마감</th>
								<th>참여금액</th>
								<th>수정</th>
								<!-- <th><input type="checkbox" name="chkall" id="chkall" /></th> -->
							</tr>
						</thead>
						<tbody>
						<?php
						if (element('list', element('data', $view))) {
							foreach (element('list', element('data', $view)) as $result) {
						?>
							<tr data-idx="<?php echo element('post_id', $result)?>">
								<!-- <td><?php echo number_format(element('num', $result)); ?></td>
								<td><?php echo html_escape(element('post_title', $result)); ?></td>
								<td><?php echo html_escape(element('cme_market', $result)); ?></td>
								<td><?php echo (element('cme_default', $result) == 1) ? '기본' : ''; ?></td>
								<td><span class="orderby_up" style="cursor:pointer;">업</span> / <span class="orderby_down" style="cursor:pointer;">다운</span></td>
								<td><a href="<?php echo admin_url($this->pagedir); ?>/exchange_write/<?php echo element(element('primary_key', $view), $result); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>" class="btn btn-outline btn-default btn-xs">수정</a></td>
								<td><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element(element('primary_key', $view), $result); ?>" /></td> -->
                                <td><?php echo number_format(element('num', $result)); ?></td>
                                <td><img src="<?php echo banner_image_url(element('frm_image', $result), '', 150); ?>" class="thumbnail mg0" style="width:80px;" /></td>
                                <td>
									<?php if (element('category', $result)) { ?><span class="label label-default"><?php echo html_escape(element('bca_value', element('category', $result))); ?></span><?php } ?>
									<a href="<?php echo goto_url(element('posturl', $result)); ?>" target="_blank"><?php echo html_escape(element('post_title', $result)); ?></a>
								</td>
                                <td><?php echo element('post_display_name', $result); ?> <?php if (element('post_userid', $result)) { ?> ( <a href="?sfield=mem_id&amp;skeyword=<?php echo element('mem_id', $result); ?>"><?php echo html_escape(element('post_userid', $result)); ?></a> ) <?php } ?></td>
                                <td><?php echo number_format(element('post_hit', $result)); ?></td>
                                <td><?php echo display_datetime(element('post_datetime', $result), 'full'); ?></td>
                                <td><?php echo display_datetime(element('frm_bat_close_datetime', $result), 'full'); ?></td>
								<td><?php echo display_datetime(element('frm_close_datetime', $result), 'full'); ?></td>
                                <td><?php echo number_format(element('frm_total_money', $result), 2); ?></td>
                                <td><a href="<?php echo admin_url($this->pagedir); ?>/exchange_write/<?php echo element(element('primary_key', $view), $result); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>" class="btn btn-outline btn-default btn-xs">수정</a></td>
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
		const cme_idx = $(_this).parents('tr').attr('data-idx');
        $.ajax({
            url: cb_admin_url + '/cicconfigs/maincoin/ajax_set_exchange_orderby',
            type: 'post',
            data: {
                cme_idx: cme_idx,
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