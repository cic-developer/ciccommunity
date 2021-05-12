<div class="box">
	<div class="box-table">
		<div class="box-table-header">
				<input type="hidden" name="pointType" value="<?php echo $_pointType?>">
				<ul class="nav nav-pills">
					<li role="presentation"><a href="<?php echo admin_url($this->pagedir.'/CStock')?>">Coin 관리</a></li>
					<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir.'/CStock_keyword')?>">검색키워드 관리</a></li>
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
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>

			<div class="list-group">
				<form class="form-inline">
					<?php 
					$myId = $_GET['id']; 
					$myKeyword = $keyword['myId'];
					echo $myKeyword;
					?>
					<div class="form-group col-md-6">
						<label><?php echo $myId ?></label>
					</div>
					<div class="input-group col-md-6">
						<input type="text" class="form-control rounded  " name = "keyword" placeholder = "Keyword">
						<span class=input-group-btn>
							<button type="submit" class="btn btn-outline-primary" >추가</button>
						</span>			
					</div>
					
				</form>
			</div>
			<div id="sortable">
				<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
				?>
					<?php echo element('market', $result); ?> 
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
							<th>한국어 명</th>
							<th>Delete</th>
							<th>Update</th>
						</tr>
						<?php 
						$sno = $row+1;
						foreach($keylist as $stocks){ ?>
						<?php $myId = $_GET['id']; ?> 
							<?php if($myId == $stocks['market']) { ?>
							<tr>
								<td>
									<?php 
									echo $stocks['keyword'];
									?>
								
								</td>
								<td><input type="checkbox" name="d_id[]" value="<?php echo $stocks['market']; ?>"></td>
								<td><input type="checkbox" name="u_id[]" value="<?php echo $stocks['market']; ?>"></td> 
							</tr>
							<?php } ?>	
						<?php
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
