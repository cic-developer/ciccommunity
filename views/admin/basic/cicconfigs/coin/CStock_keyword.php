<div class="box">
	<div class="box-table">
		<div class="box-table-header">
				<input type="hidden" name="pointType" value="<?php echo $_pointType?>">
				<ul class="nav nav-pills">
					<li role="presentation" <?php echo $_pointType === 'cp' ? '': 'class="active"'?>><a href="<?php echo admin_url($this->pagedir.'/CStock_keyword')?>">검색키워드 관리</a></li>
					<li role="presentation" <?php echo $_pointType === 'cp' ? 'class="active"': ''?>><a href="<?php echo admin_url($this->pagedir.'CStock')?>">Coin 관리</a></li>
				</ul>

				<?php
				ob_start();
				?>
					<div class="btn-group pull-right" role="group" aria-label="...">
						<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
						<button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected disabled" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택삭제</button>
						<a href="<?php echo element('write_url', $view); ?>" class="btn btn-outline btn-danger btn-sm">포인트추가</a>
					</div>
				<?php
				$buttons = ob_get_contents();
				ob_end_flush();
				?>
			</div>
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>

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
					<div class="col-sm-2"><button type="submit" class="btn btn-primary btn-xs btn-add-rows">추가</button></div>
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
				<form method = 'post'>	
					<table class="table table-hover table-striped table-bordered">
					<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
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
							<td><?php echo $stocks['market']. " - " .$stocks['name_ko']; ?></td>
							<td><?php echo $stocks['keyword']; ?></td>
							<td><input type="checkbox" name="d_id[]" value="<?php echo $stocks['idx']; ?>"></td>
							<td><input type="checkbox" name="u_id[]" value="<?php echo $stocks['idx']; ?>"></td>
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
				</form>
			</div>	
		</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<script type="text/javascript">
//<![CDATA[

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
