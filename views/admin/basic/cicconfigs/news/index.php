<div class="box">
		<div class="box-table">
			<?php
			echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
			$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
			echo form_open(current_full_url(), $attributes);
			?>
				<div class="box-table-header">
					<ul class="nav nav-pills">
						<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir); ?>">인기게시글목록</a></li>
						<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/exeptpost'); ?>">제외목록</a></li>
					</ul>
					<?php
					ob_start();
					?>
						<div class="btn-group pull-right" role="group" aria-label="...">
							<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
							<button type="button" class="btn btn-outline btn-default btn-sm btn-list-update btn-list-selected disabled" data-list-update-url = "<?php echo element('list_update_url', $view); ?>" >선택제외</button>
							
						</div>
					<?php
					$buttons = ob_get_contents();
					ob_end_flush();
					?>
					<?php if (element('boardlist', $view)) { ?>
						<div class="pull-right mr10">
							<select name="brd_id" class="form-control" onChange="location.href='<?php echo current_url(); ?>?brd_id=' + this.value;">
								<option value="">전체게시판</option>
								<?php foreach (element('boardlist', $view) as $key => $value) { ?>
								<option value="<?php echo element('brd_id', $value); ?>" <?php echo set_select('brd_id', element('brd_id', $value), ($this->input->get('brd_id') === element('brd_id', $value) ? true : false)); ?>><?php echo html_escape(element('brd_name', $value)); ?></option>
						<?php } ?>
					</select>
				</div>
			<?php } ?>
				</div>
				<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
				<div class="table-responsive">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th><a href="<?php echo element('news_id', element('sort', $view)); ?>">번호</a></th>
								<th>신문사</th>
								<th>이미지</th>
								<th>제목</th>
								<th>작성일</th>
								<th>조회</th>
								<th><input type="checkbox" name="chkall" id="chkall" /></th>
							</tr>
						</thead>
						<tbody>
						<?php
						if (element('list', element('data', $view))) {
							foreach (element('list', element('data', $view)) as $result) {
						?>
							<tr>
								<td><?php echo number_format(element('num', $result)); ?></td>
								<!-- <td><a href="?comp_id=<?php echo element('comp_id', $result); ?>"><?php echo html_escape(element('comp_name', element('company', $result))); ?></a> <a href="<?php echo goto_url(element('boardurl', $result)); ?>" target="_blank"><span class="fa fa-external-link"></span></a></td> -->
								<!-- <td>
									<?php if (element('thumb_url', $result)) {?>
										<a href="<?php echo goto_url(element('newsurl', $result)); ?>" target="_blank">
											<img src="<?php echo element('thumb_url', $result); ?>" alt="<?php echo html_escape(element('post_title', $result)); ?>" title="<?php echo html_escape(element('post_title', $result)); ?>" class="thumbnail mg0" style="width:80px;" />
										</a>
									<?php } ?>
								</td> -->
								<td>
									<?php if (element('category', $result)) { ?><span class="label label-default"><?php echo html_escape(element('bca_value', element('category', $result))); ?></span><?php } ?>
									<a href="<?php echo goto_url(element('newsurl', $result)); ?>" target="_blank"><?php echo html_escape(element('news_title', $result)); ?></a>
								</td>
								<td><?php echo display_datetime(element('news_wdate', $result), 'full'); ?></td>
								<td><?php echo number_format(element('news_reviews', $result)); ?></td>
								<td><?php echo element('post_secret', $result) === '1' ? '비밀' : '공개'; ?></td>
								<td><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element(element('primary_key', $view), $result); ?>" /></td>
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