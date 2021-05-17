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
								<td><a href="delete_keyword?id=<?php echo $stocks['idx']; ?>" class="btn btn-danger btn-xs" onclick="myFunction()" name='deleted' value = "<?php echo $stocks['idx']; ?>">삭제 </a></td> 
								<td>
									<button type="button" class="btn btn-info btn-xs modal_open1" data-toggle="modal" 
                                            data-idx="$stocks['idx'"; ?>수정</button>
								
								</td>
							</tr>
							<?php } ?>	
						<?php
						}
						?>
					</table>
				</form>


                        <!-- The Modal approve -->
                        <div class="modal fade" id="myModal-approve">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">입력해주세요 <button type="button" class="close" data-dismiss="modal">&times;</button></h4>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                                <!-- <label for="usr"></label> -->
                                                <input type="hidden" name="wid_idx1" id="wid_idx1" value="" />
                                                <div class="form-group">
                                                    <label for="cp_content1">키워드:</label>
                                                    <input class="form-control" value='<?php echo $stocks['keyword'] ?> ' rows="3" cols="75" id="cp_content1" name="cp_content1" placeholder="처리사유를 입력해주세요">
                                                </div>
                                        </div>
                                        
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <h6 class="pull-left">* 필수값</h6>
                                            <button type="button" class="btn btn-success btn-approve" data-one-modal-url="<?php echo element("approve_url", $view); ?>">수정</button>
                                        </div>

                                </div>
                            </div>
                        </div>

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
function myFunction() {
	var r = confirm("Do you want to delete?");
	if(r == true){
		window.open(" https://dev.ciccommunity.com/admin/cicconfigs/coin/CStock_keyword?id=<?php echo $_GET['id'];?>");
	}
}

$('.modal_open1').on('click', function(){
        $('#myModal-approve').modal({backdrop: false, keyboard: false});
})
// set modal data
    $(document).on('click', '.modal_open1', function() {
		var widIdx = $(this).data('idx');
        $("#myModal-approve .modal-body #wid_idx1").val( widIdx ); 
	});
	$(document).on('click', '.modal_open1', function() {
		var widIdx = $(this).data('idx');
        $("#myModal-approve .modal-body #wid_idx1").val( widIdx ); 
	});



</script>



