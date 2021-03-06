<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		echo show_alert_message(element('alert_warning_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-warning"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>

		<div class="box-table-header">
			<div class="btn-group pull-right" role="group" aria-label="...">
				<a href="<?php echo admin_url($this->pagedir.'?'.$this->input->server('QUERY_STRING', null, '')); ?>" class="btn btn-outline btn-default btn-sm">목록</a>
			</div>

		</div>

			<div class="list-group">
				<form class="form-inline">
					<div class="form-group col-md-6">
						<div class="form-group col-md-6">
							<label><?php echo element('clist_market', $coin). " - " . element('clist_name_ko', $coin); ?></label>
						</div>
					</div>
					<div class="input-group col-md-6">
						<input type="hidden" name="coin_market" value = "<?php echo element('clist_market', $coin);?>" >
						<input type="text" class="form-control" name = "keyword" placeholder = "Keyword">
						<span class=input-group-btn>
							<input type="submit" class="btn btn-primary" value='추가'>
						</span>			
					</div>
					
				</form>
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
							<th class="text-center">키워드</th>
							<th class="text-center">수정</th>
							<th class="text-center">삭제</th>

						</tr>
						<?php 
						foreach($keyword_list as $stocks){ ?>
							<tr>
								<td>
									<?php 
										echo $stocks['coin_keyword'];
									?>
								</td>
								<td>
									<button type="button" class="btn btn-info btn-xs modal_open1" data-toggle="modal" 
                                            data-idx="<?php echo $stocks['idx']; ?>" id="<?php echo $stocks['idx']; ?>" >수정</button>								
								</td>
								<td><a onclick="deleteKeyword()" href="delete_keyword?id=<?php echo $stocks['idx'];?>&pageId=<?php echo element('clist_market', $coin);?>"  class="btn btn-danger btn-xs bdelete" name='deleted' value = "<?php echo $stocks['idx']; ?>">삭제 </a></td> 
							</tr>	
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
                                <h4 class="modal-title text-left">검색키워드 수정 <button type="button" class="close" data-dismiss="modal">&times;</button></h4>
                            </div>
							<form method="get" action="<?php echo admin_url('/cicconfigs/searchcoin/update_keyword')?>">
                            <!-- Modal body -->
                                <div class="modal-body">
                                <!-- <label for="usr"></label> -->
                                    <input type="hidden" name="wid_idx1" id="wid_idx1" value="" />
									<input type="hidden" name="coin_market" id="coin_market" value="" />
									<input type="hidden" name="pageId" id="pageId" value="<?php echo element('clist_market', $coin); ?>" />
                                    <div class="form-group text-left">
                                        <label for="cp_content1" >키워드</label>
                                            <input class="form-control" rows="3" cols="75" id="cp_content1" name="cp_content1" placeholder="처리사유를 입력해주세요">
									</div>
                                </div> 
								<!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success btn-approve" data-one-modal-url="<?php echo element("approve_url", $view); ?>">수정</button>
                                </div>
							</form>                                     
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

$(document).ready(function(){
    $("a.bdelete").click(function(e){
        if(!confirm('정말 삭제 하시겠습니까 ?')){
            e.preventDefault();
            return false;
        }
        return true;
    });
});


// set modal data
$('.modal_open1').click(function() {
	var widIdx = $(this).data('idx');
	$.ajax({
        method: "GET",
        url: "<?php echo admin_url('/cicconfigs/searchcoin/get_keyword'); ?>",
        data: { id: widIdx }, 
		success: function(result){
		result = JSON.parse(result);
		console.log(result);
		$("#cp_content1").val(result.coin_keyword); //wid_idx1
		$("#wid_idx1").val(result.idx);
		$("#coin_market").val(result.coin_market);
		$('#myModal-approve').modal({backdrop: false, keyboard: false});
}
    })      
});
</script>



