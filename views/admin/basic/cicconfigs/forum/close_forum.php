<div class="box">
		<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
				<div class="box-table-header">
					<ul class="nav nav-pills">
                        <li role="presentation"><a href="<?php echo admin_url($this->pagedir); ?>" onclick="return check_form_changed();">기본정보</a></li>
                        <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/disapproval_forum'); ?>" onclick="return check_form_changed();"> 도전! CIC포럼 </a></li>
                        <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/proceeding_forum'); ?>" onclick="return check_form_changed();">진행중포럼</a></li>
                        <li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/close_forum'); ?>" onclick="return check_form_changed();">마감된포럼</a></li>
                        <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/return_forum'); ?>" onclick="return check_form_changed();">반려된포럼</a></li>
					</ul>
					<?php
					ob_start();
					?>
						<div class="btn-group pull-right" role="group" aria-label="...">
						<!-- 분배가 완료된 게시물만 삭제가 가능합니다 -->
							<button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected disabled" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택삭제</button>
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
								<th><a href="<?php echo element('post_id', element('sort', $view)); ?>">번호</a></th>
								<th>이미지</th>
								<th>제목</th>
								<th>작성자</th>
								<th><a href="<?php echo element('post_hit', element('sort', $view)); ?>">조회</a></th>
								<th><a href="<?php echo element('post_datetime', element('sort', $view)); ?>">날짜</a></th>
								<th><a href="<?php echo element('cic_forum_info.frm_bat_close_datetime', element('sort', $view)); ?>">배팅마감</a></th>
								<th><a href="<?php echo element('cic_forum_info.frm_close_datetime', element('sort', $view)); ?>">포럼마감</a></th>
								<th><a href="<?php echo element('cic_forum_total_cp', element('sort', $view)); ?>">참여금액</a></th>
								<th>수정</th>
								<th><input type="checkbox" name="chkall" id="chkall" /></th>
							</tr>
						</thead>
						<tbody>
						<?php
						if (element('list', element('data', $view))) {
							foreach (element('list', element('data', $view)) as $result) {
						?>
							<tr data-idx="<?php echo element('post_id', $result)?>">
                                <td><?php echo number_format(element('num', $result)); ?></td>
                                <td><img src="<?php echo thumb_url('forum_image', element('frm_image', $result), '', 150); ?>" class="<?php echo element('frm_image', $result) ? 'thumbnail':'' ?> mg0" style="width:80px;" /></td>
                                <td>
									<?php if (element('category', $result)) { ?><span class="label label-default"><?php echo html_escape(element('bca_value', element('category', $result))); ?></span><?php } ?>
									<a href="<?php echo goto_url(element('posturl', $result)); ?>" target="_blank"><?php echo html_escape(element('post_title', $result)); ?></a>
								</td>
                                <td><?php echo element('post_display_name', $result); ?> <?php if (element('post_userid', $result)) { ?> ( <a href="?sfield=mem_id&amp;skeyword=<?php echo element('mem_id', $result); ?>"><?php echo html_escape(element('post_userid', $result)); ?></a> ) <?php } ?></td>
                                <td><?php echo number_format(element('post_hit', $result)); ?></td>
                                <td><?php echo display_datetime(element('post_datetime', $result), 'full'); ?></td>
                                <td><?php echo display_datetime(element('frm_bat_close_datetime', $result), 'full'); ?></td>
								<td><?php echo display_datetime(element('frm_close_datetime', $result), 'full'); ?></td>
                                <td><?php echo number_format(element('cic_forum_total_cp', $result), 2); ?></td>
                                <td>
									<?php if( element('frm_repart_state', $result) != 1) { ?>
									<a href="<?php echo admin_url($this->pagedir); ?>/forum_repart/<?php echo element(element('primary_key', $view), $result); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>" class="btn btn-outline btn-default btn-xs">포인트 배분</a>
									<?php }else { ?>
									<p class="text-success">배분완료</p>
									<?php } ?>
								</td>
								<td><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element(element('primary_key', $view), $result); ?>" <?php echo element('frm_repart_state', $result) == 1 ? '' : 'disabled readonly' ?>/></td>
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