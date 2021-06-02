<div class="box">
		<div class="box-table">
				<div class="box-table-header">
					<ul class="nav nav-pills">
                        <li role="presentation"><a href="<?php echo admin_url($this->pagedir); ?>" onclick="return check_form_changed();">기본정보</a></li>
                        <li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/disapproval_forum'); ?>" onclick="return check_form_changed();"> 승인대기포럼 </a></li>
                        <li role="presentation"><a href="<?php echo admin_url($this->pagedir . ''); ?>" onclick="return check_form_changed();"> - </a></li>
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
								<th>제목</th>
								<th>내용</th>
								<th>작성자</th>
								<th>게시일</th>
                                <th>좋아요</th>
								<th>승인</th>
								<!-- <th><input type="checkbox" name="chkall" id="chkall" /></th> -->
							</tr>
						</thead>
						<tbody>
						<?php
						if (element('list', element('data', $view))) {
							foreach (element('list', element('data', $view)) as $result) {
						?>
							<tr>
								<td><?php echo number_format(element('num', $result)); ?></td>
								<td><a href="<?php echo goto_url(element('posturl', $result)); ?>" target="_blank"><?php echo html_escape(element('post_title', $result)); ?></a></td>
								<td><a href="<?php echo goto_url(element('posturl', $result)); ?>" target="_blank"><?php echo html_escape(strip_tags(element('post_content', $result))); ?></a></td>
								<td><?php echo element('post_display_name', $result); ?> <?php if (element('post_userid', $result)) { ?> ( <a href="?sfield=mem_id&amp;skeyword=<?php echo element('mem_id', $result); ?>"><?php echo html_escape(element('post_userid', $result)); ?></a> ) <?php } ?></td>
								<td><?php echo display_datetime(element('post_datetime', $result))?></td>
								<td><?php echo number_format(element('post_like', $result))?></td>
                                <td><a href="<?php echo admin_url($this->pagedir); ?>/update_forum_approval/<?php echo element(element('primary_key', $view), $result); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>" class="btn btn-outline btn-default btn-xs">승인</a></td>
								<!-- <td><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element(element('primary_key', $view), $result); ?>" /></td> -->
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