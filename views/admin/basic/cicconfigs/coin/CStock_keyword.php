<div class="box">
	<div class="box-table">
		<div class="box-table-header">
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
					?>
					<div class="form-group col-md-6">
						<label><?php echo $myId ?></label>
					</div>
					<div class="input-group col-md-6">
						<input type="hidden" name="coin_market" value = "<?php echo $myId; ?>" >
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
			<div class="table-responsive text-center">
				<form method = 'post'>	
					<table class="table table-hover table-striped table-bordered">
						<colgroup>
							<col style="width:60%;" />
							<col style="width:20%;" />
							<col style="width:20%;" />
						</colgroup>
						<tr>
							<th>키워드</th>
							<th>삭제</th>
							<th>수정</th>
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
								<td><a href="delete_keyword/?id=<?php echo $stocks['idx']; ?>" class="btn btn-danger btn-xs">삭제 </a></td>
								<!-- <td><a href="<?php echo site_url('admin/cicconfigs/Coin/delete_keyword/'.$stocks['idx']) ?> ">delete<a></td> -->
								<td><button type=submit><a href="update_keyword/?id=<?php echo $stocks['idx']; ?>" class="btn btn-info btn-xs">수정 </a></td> 
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
<!-- search -->
	<form class="example" action="post">
		<input type="text" id="search" placeholder="Search.." name="search">
		<button type="submit"><i class="fa fa-search"></i></button>
	</form>

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
//]]>
</script>



