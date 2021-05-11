<div class="box">
	<div class="box-table">
		<div class="box-table-header">
			<ul class="nav nav-pills">
				<li role="presentation"><a href="<?php echo admin_url($this->pagedir.'/CStock')?>">Coin 관리</a></li>
				<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/CStock_keyword'); ?>">검색키워드 설정</a></li>
			</ul>
		</div>
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
			<div class="list-group">
				<form class="form-inline">
					<?php $myId = $_GET['id']; ?>
					<div class="form-group">
						<label>Market id</label>
						<input type="text"  class="form-control" name = "coin_idx" value='<?php echo $myId ?>'>
					</div>
					<div class="form-group">
						<label>Keyword</label>
						<input type="text" class="form-control" name = "keyword">
					</div>
					<div class="col-sm-2"><button type="button" class="btn btn-primary btn-xs btn-add-rows">추가</button></div>
				</form>
				</div>
				<div id="sortable">
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
							<?php echo element('coin_idx', $result); ?> 
					<?php
						}
					}
					?>
				</div>
				<div class="table-responsive">
			<table class="table table-hover table-striped table-bordered">
				<tr>
					<th>S.no</th>
					<th>마겟 명</th>
					<th>한국어 명</th>
					<th>Delete</th>
					<th>Update</th>
				</tr>
				<?php 
				$sno = $row+1;
				foreach($keylist as $stocks){ ?>
				<tr>
					<td><?php echo $sno; ?></td>
					<td><?php echo $stocks['market']; ?></td>
					<td><?php $stocks['keyword']; ?></td>
					<td><div class="col-sm-2"><button type="button" class="btn btn-primary"><i class="far fa-trash-alt"></i></button></div></td>
					<td><div class="col-sm-2"><button type="button" class="btn btn-primary"><i class="far fa-trash-alt"></i></button></div></td>
				</tr>
				<?php
					$sno++;
				}
				
				if(count($keylist) == 0){
					echo "<tr>";
					echo "<td colspan='3'>No record found.</td>";
					echo "</tr>";
				}
				?>
			</table>
		</div>	
			</div>
		<?php echo form_close(); ?>
	</div>
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
</script>
