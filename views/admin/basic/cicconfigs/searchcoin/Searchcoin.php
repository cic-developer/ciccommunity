<div class="box">
	<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
		<div class="box-table-header">

				<?php
				ob_start();
				?>
					<div class="btn-group pull-right" role="group" aria-label="...">
						<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
						<form action='post'>
								<input type="submit" id = "refresh" name="refresh" class="btn btn-default btn-sm" value="새로고침">
						</form>	
					</div>
				<?php
				
				ob_end_flush();
				?>
			</div>
			<div class="table-responsive">
			
				<form action="post" name='selected_market'>
				
					<table class="table table-hover table-striped table-bordered">
						<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
						<thead >
							<tr>
								<th>번호</th>
								<th>마켓명</th>
								<th>한국어명</th>
								<th>영문명</th>
								<th>키워드 추가</th>
							</tr>
						</thead>
						
						<tbody>
						
						<?php
						if (element('list', element('data', $view))) {
							foreach (element('list', element('data', $view)) as $result) {
						?>
							<tr>
								<td><?php echo number_format(element('num', $result)); ?></td>
								<td><a href='https://dev.ciccommunity.com/admin/cicconfigs/searchcoin/CStock_keyword?id=<?php echo element('clist_market', $result); ?>'><?php echo html_escape(element('clist_market', $result)); ?></a></td>
								<td><?php echo element('clist_name_ko', $result); ?></td>
								<td><?php echo element('clist_name_en', $result); ?></td>
								<td><button  type="button" id="myBtn" class="btn btn-default btn-xs" onClick="document.location.href='https://dev.ciccommunity.com/admin/cicconfigs/searchcoin/CStock_keyword?id=<?php echo element('clist_market', $result); ?>'">추가</button></td>
							</tr>
						<?php
							}
						}
						?>
						</tbody>
					</table>
				</form>
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

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).on('click', '.btn-add-rows', function() {
	$('#sortable').append(' <div class="form-group list-group-item"><div class="col-sm-1"><div class="fa fa-arrows" style="cursor:pointer;"></div><input type="hidden" name="mgr_id[]" /></div><div class="col-sm-3"><input type="text" class="form-control" name="mgr_title[]"/></div><div class="col-sm-4"><input type="text" class="form-control" name="mgr_description[]"/></div><div class="col-sm-1"><input type="checkbox" name="mgr_is_default[]" value="1" /></div><div class="col-sm-1"></div><div class="col-sm-2"><button type="button" class="btn btn-outline btn-default btn-xs btn-delete-row" >삭제</button></div></div>');
});
$(document).on('click', '.btn-delete-row', function() {
	$(this).parents('div.list-group-item').remove();
});
$(function () {
	$('#sortable').sortable({
		handle:'.fa-arrows'
	});
})
//]]>
var btn = document.getElementById(id);
btn.addEventListener('click', function() {
	document.location.href = 'Searchcoin_keyword';
});

</script>

