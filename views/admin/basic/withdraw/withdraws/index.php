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
                            <th><a href="<?php echo element('wid_userid', element('sort', $view)); ?>">회원아이디</a></th>
                            <th><a href="<?php echo element('wid_userip', element('sort', $view)); ?>">회원아이피</a></th>
                            <th><a href="<?php echo element('wid_nickname', element('sort', $view)); ?>">닉네임</a></th>
                            <th><a href="<?php echo element('wid_wallet_address', element('sort', $view)); ?>">지갑주소</a></th>
                            <th><a href="<?php echo element('wid_req_money', element('sort', $view)); ?>">출금요청금액</a></th>
                            <th><a href="<?php echo element('wid_req_datetime', element('sort', $view)); ?>">요청날짜</a></th>
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
                            <td><?php echo html_escape(element('wid_userid', $result)); ?></td>
                            <td><?php echo html_escape(element('wid_userip', $result)); ?></td>
                            <td><?php echo element('display_name', $result); ?></td>
                            <td><?php echo html_escape(element('wid_wallet_address', $result)); ?></td>
                            <td><?php echo number_format(element('wid_req_money', $result), 2); ?></td>
                            <td><?php echo html_escape(element('wid_req_datetime', $result)); ?></td>
                            <td><?php echo html_escape(element('wid_state', $result)) != null ? (html_escape(element('wid_state', $result)) == 1 ? '<p class="text-success">승인</p>' : '<p class="text-danger">반려</p>' ) : '<p class="text-body">미처리</p>';?></td>
                            <td>
                                <?php
                                if (element('wid_state', $result) != null) {
                                ?>
                                    <button type="button" class="text-primary withdraw-result modal_open3" 
                                        style="cursor:pointer; border:0; outline:0; background-color:inherit;"
                                            data-idx="<?php echo number_format(element('wid_idx', $result)); ?>"
                                                data-userid="<?php echo html_escape(element('wid_userid', $result)); ?>"
                                                    data-userip="<?php echo html_escape(element('wid_userip', $result)); ?>"
                                                        data-nickname="<?php echo html_escape(element('wid_nickname', $result)); ?>"
                                                            data-wallet-address="<?php echo html_escape(element('wid_wallet_address', $result)); ?>"
                                                                data-commission="<?php echo number_format(element('wid_commission', $result), 2); ?>"
                                                                    data-req-money="<?php echo number_format(element('wid_req_money', $result), 2); ?>"
                                                                        data-cal-money="<?php echo number_format(element('wid_cal_money', $result), 2); ?>"
                                                                            data-req-datetime="<?php echo html_escape(element('wid_req_datetime', $result)); ?>"
                                            data-adminid="<?php echo html_escape(element('wid_admin_id', $result)); ?>"
                                                data-adminip="<?php echo html_escape(element('wid_admin_ip', $result)); ?>"           
                                            data-res-datetime="<?php echo html_escape(element('wid_res_datetime', $result)); ?>"
                                                data-state="<?php echo html_escape(element('wid_state', $result)) != null ? (html_escape(element('wid_state', $result)) == 1 ? '승인' : '반려' ) : '';?>"
                                                    data-content="<?php echo html_escape(element('wid_content', $result)); ?>"
                                            data-percoin="<?php echo element('wid_percoin', $result) != null ? (number_format(element('wid_percoin', $result), 2)) : ''; ?>"
                                                data-transaction="<?php echo html_escape(element('wid_transaction', $result)); ?>"
                                            data-memo="<?php echo html_escape(element('wid_memo', $result)); ?>"       
                                    >
                                        <strong>처리완료</strong>
                                    </button>
                                <?php 
                                } else{
                                ?>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-success modal_open1" 
                                            data-idx="<?php echo number_format(element('wid_idx', $result)); ?>" 
                                        >
                                            승인
                                        </button>
                                        <button type="button" class="btn btn-danger modal_open2" data-toggle="modal" 
                                            data-idx="<?php echo number_format(element('wid_idx', $result)); ?>" 
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
                                                <input type="hidden" name="wid_idx1" id="wid_idx1" value="" />
                                                <div class="form-group">
                                                    <label for="cp_transaction">트랜잭션*:</label>
                                                    <textarea class="form-control" rows="1" cols="75" id="cp_transaction" name="cp_transaction" placeholder="트랜잭션을 입력해주세요" required style="width:100%;"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="cp_percoin">퍼코인*:</label>
                                                    <textarea class="form-control" rows="1" cols="75" id="cp_percoin" name="cp_percoin" placeholder="퍼코인을 입력해주세요" required style="width:100%;"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="cp_content1">사유*:</label>
                                                    <textarea class="form-control" rows="3" cols="75" id="cp_content1" name="cp_content1" placeholder="처리사유를 입력해주세요" required style="width:100%;"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="cp_memo">메모:</label>
                                                    <textarea class="form-control" rows="5" cols="75" id="cp_memo" name="cp_memo" placeholder="메모" style="width:100%;"></textarea>
                                                </div>
                                        </div>
                                        
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <h6 class="pull-left">* 필수값</h6>
                                            <button type="button" class="btn btn-success btn-approve" data-one-modal-url="<?php echo element("approve_url", $view); ?>">승인</button>
                                        </div>

                                </div>
                            </div>
                        </div>
                        <!-- The Modal approve -->

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
                                                <input type="hidden" name="wid_idx2" id="wid_idx2" value="" />
                                                <div class="form-group">
                                                    <label for="cp_content2">사유*:</label>
                                                    <textarea class="form-control" rows="3" cols="75" id="cp_content2" name="cp_content2" placeholder="처리사유를 입력해주세요" required style="width:100%;"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="cp_memo2">메모:</label>
                                                    <textarea class="form-control" rows="5" cols="75" id="cp_memo2" name="cp_memo2" placeholder="메모" style="width:100%;"></textarea>
                                                </div>
                                        </div>
                                        
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <h6 class="pull-left">* 필수값</h6>
                                            <button type="button" class="btn btn-danger btn-retire" data-one-modal-url="<?php echo element("retire_url", $view); ?>">반려</button>
                                        </div>

                                </div>
                            </div>
                        </div>
                        <!-- The Modal retire -->
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

<!-- The Modal result -->
<div class="modal fade" id="myModal-result">
    <div class="modal-dialog">
        <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">처리 결과 <button type="button" class="close" data-dismiss="modal">&times;</button></h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <table class="table table-hover table-striped table-bordered">
                        <!-- 번호 -->
                        <tr>
                            <th width="135">번호</th>
                            <td colspan="2" class="text-center" id="wid-idx"></td>
                        </tr>

                        <!-- 신청회원 정보 -->
                        <tr>
                            <td rowspan="9">신청 회원 정보</td>
                        </tr>
                        <tr>
                            <th width="95">아이디</th>
                            <td id="wid-userid"></td>
                        </tr>
                        <tr>
                            <th>아이피</th>
                            <td id="wid-userip"></td>
                        </tr>
                        <tr>
                            <th>닉네임</th>
                            <td id="wid-nickname"></td>
                        </tr>
                        <tr>
                            <th>지갑주소</th>
                            <td id="wid-wallet-address"></td>
                        </tr>
                        <tr>
                            <th>수수료(%)</th>
                            <td id="wid-commission"></td>
                        </tr>
                        <tr>
                            <th>신청금액(CP)</th>
                            <td id="wid-req-money"></td>
                        </tr>
                        <tr>
                            <th>출금금액(CP)</th>
                            <td id="wid-cal-money"></td>
                        </tr>
                        <tr>
                            <th>요청날짜</th>
                            <td id="wid-req-datetime"></td>
                        </tr>

                        <!-- 처리관리자 정보 -->
                        <tr>
                            <td rowspan="3">처리 관리자 정보</td>
                        </tr>
                        <tr>
                            <th>아이디</th>
                            <td id="wid-admin-id"></td>
                        </tr>
                        <tr>
                            <th>아이피</th>
                            <td id="wid-admin-ip"></td>
                        </tr>

                        <!-- 처리결과 정보 -->
                        <tr>
                            <td rowspan="4">처리 결과 정보</td>
                        </tr>
                        <tr>
                            <th>처리날짜</th>
                            <td id="wid-res-datetime"></td>
                        </tr>
                        <tr>
                            <th>처리결과</th>
                            <td id="wid-state"></td>
                        </tr>
                        <tr>
                            <th>처리사유</th>
                            <td id="wid-content"></td>
                        </tr>

                        <!-- percoin 정보 -->
                        <tr class="tr-percoin">
                            <td rowspan="3">PER COIN 정보</td>
                        </tr>
                        <tr class="tr-percoin">
                            <th>퍼코인</th>
                            <td id="wid-percoin"></td>
                        </tr>
                        <tr class="tr-percoin">
                            <th>트랜잭션</th>
                            <td id="wid-transaction"></td>
                        </tr>
                        
                    </table>
                    <!-- 메모 -->
                    <div class="form-group">
                        <label for="cp_content3">메모:</label>
                        <textarea name="cp_content3" id="cp_content3" rows="10" style="width:100%;" disabled readonly></textarea>
                    </div>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

        </div>
    </div>
</div>
<!-- The Modal result -->

    
<script>
    // modal options
    $('.modal_open1').on('click', function(){
        $('#myModal-approve').modal({backdrop: false, keyboard: false});
    })
    $('.modal_open2').on('click', function(){
        $('#myModal-retire').modal({backdrop: false, keyboard: false});
    })
    $('.modal_open3').on('click', function(){
        $('#myModal-result').modal({backdrop: false, keyboard: false});
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
        var cp_transaction = $('#cp_transaction').val().trim();
        if(cp_transaction.length < 1){
            alert("필수값 입니다")
            $('#cp_transaction').focus();
            return;
        }

        // 0.01보다 작거나 숫자가 아닌경우도 검사해야 한다. ...
        var cp_percoin = $('#cp_percoin').val().trim();
        if(cp_percoin.length < 1){
            alert("필수값 입니다")
            $('#cp_percoin').focus();
            return;
        }

        var cp_content1 = $('#cp_content1').val().trim();
        if(cp_content1.length < 1){
            alert("필수값 입니다")
            $('#cp_content1').focus();
            return;
        }


        if (acttype === 'approve' && ! confirm('선택한 요청을 정말 승인 하시겠습니까?')) return;
        f.action = actpage;
		f.submit();
    }   
    // retier submit
    function wid_retire_submit(f, acttype, actpage){
        var cp_content2 = $('#cp_content2').val().trim();
        if(cp_content2.length < 1){
            alert("필수값 입니다")
            $('#cp_content2').focus();
            return;
        }

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
        $("#myModal-approve .modal-body #wid_idx1").val( widIdx ); 
	});
    $(document).on('click', '.modal_open2', function() {
		var widIdx = $(this).data('idx');
        $("#myModal-retire .modal-body #wid_idx2").val( widIdx ); 
	});
    $(document).on('click', '.modal_open3', function() {
		var idx = $(this).data('idx');
		var userid = $(this).data('userid');
		var userip = $(this).data('userip');
		var nickname = $(this).data('nickname');
		var wallet_address = $(this).data('wallet-address');
		var commission = $(this).data('commission');
		var req_money = $(this).data('req-money');
		var cal_money = $(this).data('cal-money');
		var req_datetime = $(this).data('req-datetime');

		var adminid = $(this).data('adminid');
		var adminip = $(this).data('adminip');

		var res_datetime = $(this).data('res-datetime');
		var state = $(this).data('state');
		var content = $(this).data('content');

		var percoin = $(this).data('percoin');
		var transaction = $(this).data('transaction');

		var memo = $(this).data('memo');

        // 신청회원정보
        document.getElementById("wid-idx").innerHTML = idx;
        document.getElementById("wid-userid").innerHTML = userid;
        document.getElementById("wid-userip").innerHTML = userip;
        document.getElementById("wid-nickname").innerHTML = nickname;
        document.getElementById("wid-wallet-address").innerHTML = wallet_address;
        document.getElementById("wid-commission").innerHTML = commission;
        document.getElementById("wid-req-money").innerHTML = req_money;
        document.getElementById("wid-cal-money").innerHTML = cal_money;
        document.getElementById("wid-req-datetime").innerHTML = req_datetime;

        // 처리관리자정보
        document.getElementById("wid-admin-id").innerHTML = adminid;
        document.getElementById("wid-admin-ip").innerHTML = adminip;

        // 처리결과정보
        document.getElementById("wid-res-datetime").innerHTML = res_datetime;
        document.getElementById("wid-state").innerHTML = state;
        document.getElementById("wid-content").innerHTML = content;

        // 퍼코인정보
        document.getElementById("wid-percoin").innerHTML = percoin;
        document.getElementById("wid-transaction").innerHTML = transaction;

        // 퍼코인 정보가 없을경우 ( 반려인 경우 ) => 필요없는 태그 숨기기 visibility:hidden 
        if(!percoin && !transaction){
            $('.tr-percoin').css('display', 'none');
        }else{
            $('.tr-percoin').css('display', '');
        }

        // 메모
        $("#cp_content3").val( memo ); 
	});


    // excel
    $(document).on('click', '#export_to_excel', function(){
        exporturl = '<?php echo admin_url($this->pagedir . '/excel' . '?' . $this->input->server('QUERY_STRING', null, '')); ?>';
        document.location.href = exporturl;
    })
</script>
