<div class="box">
	<div class="box-table">
        <?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>

            <div class="box-table-header">
                <div class="btn-group btn-group-sm" role="group">
					<a href="?" class="btn btn-sm <?php echo ( ! $this->input->get('wid_state') && $this->input->get('wid_state') != '0') ? 'btn-success' : 'btn-default'; ?>">전체목록</a>
					<a href="?wid_state=null" class="btn btn-sm <?php echo ($this->input->get('wid_state') == 'null') ? 'btn-success' : 'btn-default'; ?>">미처리</a>
					<a href="?wid_state=1" class="btn btn-sm <?php echo ($this->input->get('wid_state') == '1') ? 'btn-success' : 'btn-default'; ?>">승인</a>
					<a href="?wid_state=0" class="btn btn-sm <?php echo ($this->input->get('wid_state') == '0') ? 'btn-success' : 'btn-default'; ?>">반려</a>
				</div>

				<?php
				ob_start();
				?>
					<div class="btn-group pull-right" role="group" aria-label="...">
						<button type="button" class="btn btn-outline btn-success btn-sm" id="export_to_excel"><i class="fa fa-file-excel-o"></i> 엑셀 다운로드</button>
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
                            <th><a href="<?php echo element('wid_idx', element('sort', $view)); ?>">번호</a></th>
                            <th><a href="<?php echo element('wid_admin_id', element('sort', $view)); ?>">관리자아이디</a></th>
                            <th><a href="<?php echo element('wid_userid', element('sort', $view)); ?>">유저아이디</a></th>
                            <th><a href="<?php echo element('wid_admin_ip', element('sort', $view)); ?>">관리자아이피</a></th>
                            <th><a href="<?php echo element('wid_userip', element('sort', $view)); ?>">회원아이피</a></th>
                            <th><a href="<?php echo element('wid_nickname', element('sort', $view)); ?>">닉네임</a></th>
                            <th><a href="<?php echo element('wid_wallet_address', element('sort', $view)); ?>">지갑주소</a></th>
                            <th><a href="<?php echo element('wid_req_money', element('sort', $view)); ?>">출금요청금액</a></th>
                            <th><a href="<?php echo element('wid_req_datetime', element('sort', $view)); ?>">요청날짜</a></th>
                            <th><a href="<?php echo element('wid_res_datetime', element('sort', $view)); ?>">처리날짜</a></th>
                            <th><a href="<?php echo element('wid_state', element('sort', $view)); ?>">결과</a></th>
                            <th>승인</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (element('list', element('data', $view))) {
                        foreach (element('list', element('data', $view)) as $result) {
                    ?>
                        <tr>
                            <td><?php echo number_format(element('wid_idx', $result)); ?></td>
                            <td><?php echo html_escape(element('wid_admin_id', $result)); ?></td>
                            <td><?php echo html_escape(element('wid_userid', $result)); ?></td>
                            <td><?php echo html_escape(element('wid_admin_ip', $result)); ?></td>
                            <td><?php echo html_escape(element('wid_userip', $result)); ?></td>
                            <td><?php echo element('display_name', $result); ?></td>
                            <td><?php echo html_escape(element('wid_wallet_address', $result)); ?></td>
                            <td><?php echo number_format(element('wid_req_money', $result), 2); ?></td>
                            <td><?php echo html_escape(element('wid_req_datetime', $result)); ?></td>
                            <td><?php echo html_escape(element('wid_res_datetime', $result)); ?></td>
                            <td><?php echo html_escape(element('wid_state', $result)) != null ? (element('wid_state', $result) == 1 ? '<p class="text-success">승인</p>' : '<p class="text-danger">반려</p>' ) : '<p class="text-body">미처리</p>';?></td>
                            <td>
                                <?php
                                if (element('wid_state', $result) != null) {
                                ?>
                                    <p class="text-primary"><strong>처리완료</strong></p>
                                <?php 
                                } else{
                                ?>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-success modal_open1" 
                                            data-idx="<?php echo element("wid_idx", $result); ?>" 
                                        >
                                            승인
                                        </button>
                                        <button type="button" class="btn btn-danger modal_open2" data-toggle="modal" 
                                            data-idx="<?php echo element("wid_idx", $result); ?>" 
                                        >
                                            반려
                                        </button>
                                    </div>
                                <?php 
                                }
                                ?>
                            </td>
                        </tr>
                    <?php
                        }
                    }
                    if ( ! element('list', element('data', $view))) {
                    ?>
                        <tr>
							<td colspan="17" class="nopost">자료가 없습니다</td>
						</tr>
					<?php
					}
					?>
                        <!-- The Modal approve -->
                        <div class="modal fade" id="myModal-approve">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">출금 승인 <button type="button" class="close" data-dismiss="modal">&times;</button></h4>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                                <!-- <label for="usr"></label> -->
                                                <input type="hidden" name="wid_idx" id="wid_idx" value="" />
                                                <textarea class="form-control" rows="5" cols="75" id="cp_content" name="cp_content" placeholder="출금 승인 사유를 입력해주세요." style="width:100%;"></textarea>
                                        </div>
                                        
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success btn-approve" data-one-modal-url="<?php echo element("approve_url", $view); ?>">승인</button>
                                        </div>

                                </div>
                            </div>
                        </div>
                        <!-- data-dismiss="modal-->

                        <!-- The Modal retire -->
                        <div class="modal fade" id="myModal-retire">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">출금 반려 <button type="button" class="close" data-dismiss="modal">&times;</button></h4>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                                <!-- <label for="usr"></label> -->
                                                <input type="hidden" name="wid_idx" id="wid_idx" value="" />
                                                <textarea class="form-control" rows="5" cols="75" id="cp_content" name="cp_content" placeholder="출금 반려 사유를 입력해주세요." style="width:100%;"></textarea>
                                        </div>
                                        
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-retire" data-one-modal-url="<?php echo element("retire_url", $view); ?>">반려</button>
                                        </div>

                                </div>
                            </div>
                        </div>
                        <!-- data-dismiss="modal-->
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

    
<script>
    // modal options
    $('.modal_open1').on('click', function(){
        $('#myModal-approve').modal({backdrop: false, keyboard: false});
    })
    $('.modal_open2').on('click', function(){
        $('#myModal-retire').modal({backdrop: false, keyboard: false});
    })

    // approve submit
    // function wid_approve_submit(f, acttype, actpage) {
	// 	var str = '';

    //     // console.log(" => ", f)

	// 	if (acttype === 'approve' && ! confirm('선택한 요청을 정말 승인 하시겠습니까?')) return;

	// 	f.action = actpage;
	// 	f.submit();
	// }
	// $(document).on('click', '.btn-approve', function() {
	// 	var userid = $(this).data('userid');

    //     $(".modal-body #wid_userid").val( userid ); // cic_withdraw_log

	// 	wid_approve_submit(document.flist, 'approve', $(this).attr('data-one-wid-url'));
	// });

    // approve submit
    function wid_approve_submit(f, acttype, actpage){
        var str = '';
        // console.log(" => ", f)
        if (acttype === 'approve' && ! confirm('선택한 요청을 정말 승인 하시겠습니까?')) return;
        f.action = actpage;
		f.submit();
    }   
    // retier submit
    function wid_retire_submit(f, acttype, actpage){
        var str = '';
        // console.log(" => ", f)
        if (acttype === 'retire' && ! confirm('선택한 요청을 정말 반려 하시겠습니까?')) return;
        f.action = actpage;
		f.submit();
    }   

    //
    $(document).on('click', '.btn-approve', function() {
		wid_approve_submit(document.flist, 'approve', $(this).attr('data-one-modal-url'));
	});
    $(document).on('click', '.btn-retire', function() {
		wid_retire_submit(document.flist, 'retire', $(this).attr('data-one-modal-url'));
	});

    // set modal data
    $(document).on('click', '.modal_open1', function() {
		var widIdx = $(this).data('idx');
        $("#myModal-approve .modal-body #wid_idx").val( widIdx ); // cic_withdraw
	});
    $(document).on('click', '.modal_open2', function() {
		var widIdx = $(this).data('idx');
        $("#myModal-retire .modal-body #wid_idx").val( widIdx ); // cic_withdraw
	});


    // excel
    $(document).on('click', '#export_to_excel', function(){
        exporturl = '<?php echo admin_url($this->pagedir . '/excel' . '?' . $this->input->server('QUERY_STRING', null, '')); ?>';
        document.location.href = exporturl;
    })
</script>
