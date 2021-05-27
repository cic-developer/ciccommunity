<div class="box">
		<div class="box-table">
			<?php
			echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
			$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
			echo form_open(current_full_url(), $attributes);
			?>
				<div class="box-table-header">
					<ul class="nav nav-pills">
						<li role="presentation"><a href="<?php echo admin_url($this->pagedir); ?>">뉴스목록</a></li>
                    	<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/enable'); ?>">비활성화 뉴스목록</a></li>
						<li role="presentation"class="active"><a href="<?php echo admin_url($this->pagedir . '/show'); ?>">비공개 뉴스목록</a></li>
						<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/most_view_news'); ?>">많이 본 뉴스 관리</a></li>
						<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/important'); ?>">주요 뉴스 관리</a></li>
						<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/show'); ?>">신문사 관리</a></li>
					</ul>
					<?php
					ob_start();
					?>
						<div class="btn-group pull-right" role="group" aria-label="...">
							<button type="button" class="btn btn-outline btn-default btn-sm btn-list-update btn-list-selected disabled" data-list-update-url = "<?php echo element('update_news_show_1_url', $view); ?>" >공개설정</button>
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
								<th><a href="<?php echo element('news_id', element('sort', $view)); ?>">번호</a></th>
								<th>뉴스 제목</th>
								<th>스크랩 날짜</th>
								<th>조회수</th>
								<th>활성상태</th>
								<th>공개여부</th>
								<th><input type="checkbox" name="chkall" id="chkall" /></th>
							</tr>
						</thead>
						<tbody>
						<?php
						if (element('list', element('data', $view))) {
							foreach (element('list', element('data', $view)) as $result) {
								?>
							<tr>
								<td><?php echo number_format(element('news_id', $result)); ?></td>
								<td><?php echo html_escape(element('news_title', $result)); ?></td>
								<td><?php echo display_datetime(element('news_wdate', $result), 'full'); ?></td>
								<td><?php echo number_format(element('news_reviews', $result)); ?></td>
								<td><?php echo element('news_enable', $result) === '1' ? '활성' : '비활성화'; ?></td>
								<td><?php echo element('news_show', $result) === '1' ? '공개' : '비공개'; ?></td>
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