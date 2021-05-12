<div class="box">
	<div class="box-table">
		<div class="box-table-header">
				<input type="hidden" name="pointType" value="<?php echo $_pointType?>">
				<ul class="nav nav-pills">
					<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir.'/CStock')?>">Coin 관리</a></li>
					<li role="presentation" ><a href="<?php echo admin_url($this->pagedir.'/CStock_keyword')?>">검색키워드 관리</a></li>
				</ul>

				<?php
				ob_start();
				?>
					<div class="btn-group pull-right" role="group" aria-label="...">
						<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
					</div>
				<?php
				$buttons = ob_get_contents();
				ob_end_flush();
				?>
		</div>
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			
			<div class="table-responsive">
			
				<form action="post" name='selected_market'>
				
					<table class="table table-hover table-striped table-bordered">
						<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
						<div class="btn-group pull-right" role="group" aria-label="...">
							<input type="submit" id = "refresh" name="refresh" class="btn btn-outline btn-default btn-sm" value="Rafresh">
						</div>	
						<thead>
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
								<td><a href="?sfield=Coin.coin_idx&amp;skeyword=<?php echo element('market', $result); ?>"><?php echo html_escape(element('market', $result)); ?></a></td>
								<td><?php echo element('name_ko', $result); ?></td>
								<td><?php echo element('name_en', $result); ?></td>
								<td><button  type="button" id="myBtn" class="btn btn-link" onClick="document.location.href='https://dev.ciccommunity.com/admin/cicconfigs/coin/CStock_keyword?id=<?php echo element('market', $result); ?>'">Link</button></td>
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
	document.location.href = 'CStock_keyword';
});

//Buton to rafresh pasge
$(".btn-sm").on('click', function(e){
    e.preventDefault(); // this will prevent the defualt behavior of the button

    // find which button was clicked
    butId = $(this).attr('id');

    $.ajax({
        method: "POST",
        url: "/controllerDummy/run/",
        data: { button: butId }
    })
    .done(function( msg ) {
        // do something
    });        
});
</script>

