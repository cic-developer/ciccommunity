
<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/tooltip.css'); ?>
<div id="container-wrap">
    <div id="contents" class="div-cont">
        
        <!-- page start // -->
        <div class="member-wrap withdraw">
            <?php
            echo show_alert_message($this->session->flashdata('message'), '<script>alert("', '")</script>');
            $attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
            echo form_open(current_full_url(), $attributes);
            ?>
            <h3>출금요청</h3>
            <div class="entry">
                <ul>
                    <li>
                        <p class="btxt">출금가능</p>
                        <p class="stxt"><?php echo number_format(element('mem_cp', $view), 2); ?> <span>CP</span>&nbsp;&nbsp; (최소신청금액: <?php echo number_format(element('withdraw_minimum', $view), 2); ?>&nbsp;cp/ 수수료: <?php echo number_format(element('withdraw_deposit', $view), 2); ?>&nbsp;%)</p> 
                        <input type="hidden"id="html_mem_cp" value="<?php echo number_format(element('mem_cp', $view), 2); ?>" />
                    </li>
                    <li>
                        <p class="btxt">출금액</p>
                        <div class="field draw">
                            <p class="chk-input w210">
                                <input id="money" type="text" name="money" placeholder="금액을 입력해주세요." value="">
                            </p>
                            <p class="ctxt">CP</p>
                            <a href='javascript:void(0);' id="withdraw-request" class="draw-btn withdraw-request" onclick="validateForm()" data-wid-req-url="<?php echo element('req_url', $view); ?>"><span>출금요청</span></a>
                        </div>
                        <p id="help-text" style="color:red;"></p>
                    </li>
                </ul>
            </div>
            <div class="gap50"></div>
            <h3 class="no-mgt">출금요청현황</h3>
            <div class="list">
                <table>
                    <colgroup>
                        <col width="20%">
                        <col width="15%">
                        <col width="15%">
                        <col width="40%">
                        <col width="10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>출금 신청일</th>
                            <th>신청한 CP</th>
                            <th>받은 PER</th>
                            <th>트랜잭션</th>
                            <th>상태</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (element('list', element('data', $view))) {
                        foreach (element('list', element('data', $view)) as $result) {
                    ?>
                        <tr>
                            <td><?php echo html_escape(element('wid_req_datetime', $result)); ?></td>
                            <td><?php echo number_format(element('wid_req_money', $result), 2); ?>CP</td>
                            <td><?php echo element('wid_percoin', $result) != null ? (number_format(element('wid_percoin', $result), 2)).' PER': ''; ?></td>
                            <td><?php echo html_escape(element('wid_transaction', $result)); ?></td>
                            <td>
                                <?php echo html_escape(element('wid_state', $result)) != null ? (html_escape(element('wid_state', $result)) == 1 
                                    ? '<span data-tooltip-text="'.html_escape(element('wid_content', $result)).'"><p class="cblue">승인</p></span>' 
                                    : '<span data-tooltip-text="'.html_escape(element('wid_content', $result)).'"><p class="cred">반려</p></span>' ) 
                                    : '<p class="text-body">미처리</p>';
                                ?>
                            </td>
                        </tr>
                    <?php
                        }
                    }
					?>
                    </tbody>
                </table>
            </div>
            <?php echo form_close(); ?>
            <div class="paging-wrap">
				<?php echo element('paging', $view); ?>
			</div>

            <!-- modal -->
            <div id="myModal_withdraw" class="modal">
				<div class="modal-content">
					<!-- <ul class="entry modify-box"> -->
                        <table>
                            <colgroup>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td>최소신청금액(CP)</td>
                                    <td><?php echo number_format(element('withdraw_minimum', $view), 2); ?></td>
                                </tr>
                                <tr>
                                    <td>출금수수료(%)</td>
                                    <td><?php echo number_format(element('withdraw_deposit', $view), 2); ?></td>
                                </tr>
                                <tr>
                                    <td>보유포인트(CP)</td>
                                    <td><?php echo number_format(element('mem_cp', $view), 2); ?></td>
                                </tr>
                                <tr>
                                    <td>예상 잔여포인트(CP)</td>
                                    <td><?php echo number_format(element('change_cp', $view), 2); ?></td>
                                </tr>
                                <tr>
                                    <td>예상 교환포인트(PER))</td>
                                    <td>????</td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="javascript:void(0);" id="withdraw_request_confirm"  class="modify-btn" data-deposit-url="<?php echo site_url(element('deposit_url', $view)); ?>">
                            <span>확인</span>
                        </a>
					<!-- </ul> -->
				</div>
			</div>

        </div>
        <!-- page end // -->
    </div>
</div>


<style>

	/* The Modal (background) */
	.modal {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 1; /* Sit on top */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content/Box */
	.modal-content {
		background-color: #fefefe;
		margin: 15% auto; /* 15% from the top and centered */
		padding: 20px;
		border: 1px solid #888;
		width: 20%; /* Could be more or less, depending on screen size */                          
	}

	/* The Close Button */
	.close {
		color: #aaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}
	.close:hover,
	.close:focus {
		color: black;
		text-decoration: none;
		cursor: pointer;
	}

	.modal-btn {
		line-height: 35px;
		border-radius: 35px;
		font-size: 14px;
		color: #fff;
		background: #111;
		font-weight: 500;
		display: inline-block;
		vertical-align: top;
		margin-left: 15px;
		min-width: 120px;
		text-align: center;
		box-sizing: border-box;
	}
</style>

<script>
    // Get the modal
    var modal = document.getElementById('myModal_withdraw');

    // Get the button that opens the modal
    var btn = document.getElementById("withdraw-request");

    // When the user clicks on the button, open the modal 
	btn.onclick = function() {
		modal.style.display = "block";
	}

    // When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}

    /*
     *
     */
    
    function isNumeric(num){
        // 좌우 trim(공백제거)을 해준다.
        num = String(num).replace(/^\s+|\s+$/g, "");
        /*
        if(typeof opt == "undefined" || opt == "1"){
            // 모든 10진수 (부호 선택, 자릿수구분기호 선택, 소수점 선택)
            var regex = /^[+\-]?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+){1}(\.[0-9]+)?$/g;
        }else if(opt == "2"){
            // 부호 미사용, 자릿수구분기호 선택, 소수점 선택
            var regex = /^(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+){1}(\.[0-9]+)?$/g;
        }else if(opt == "3"){
            // 부호 미사용, 자릿수구분기호 미사용, 소수점 선택
            var regex = /^[0-9]+(\.[0-9]+)?$/g;
        }else{
            // only 숫자만(부호 미사용, 자릿수구분기호 미사용, 소수점 미사용)
            var regex = /^[0-9]$/g;
        }*/

        var regex = /^[0-9]+(\.[0-9]+)?$/g;
        
        if( regex.test(num) ){
            num = num.replace(/,/g, "");
            return isNaN(num) ? false : true;
        }else{ return false;  }
    }


    // 출금금액 validation
    function validateForm() {
        var x, text;
        var mem_cp = $("#html_mem_cp").val();

        // // Get the value of the input field with id="numb"
        x = document.getElementById("money").value;
        btn = document.getElementById("withdraw_request_confirm");

        // // If x is Not a Number or less than one or greater than 10
        if (!isNumeric(x) || x < 1 || x > Number(mem_cp)) {
            text = "금액을 올바르게 입력해주세요.";
        } else {
            // text = "Input OK";
            // document.flist.submit();
            wid_req_submit(document.flist, 'req', btn.getAttribute('data-wid-req-url'));
        }

        if(text != undefined){
            document.getElementById("help-text").innerHTML = text;
        }
    }

    // 출금금액 요청 submit
    function wid_req_submit(f, acttype, actpage){
        var money = '';

        money = document.getElementById('money').value;

        if(!money){
            alert("warnning!")
        }

        if(acttype === 'req' && ! confirm('입력한 금액을 정말로 출금 하시겠습니까?')) return;

        f.action = actpage;
		f.submit();
    }

    $('input[type="text"]').keydown(function() {
        if (event.keyCode === 13) {
            event.preventDefault();
        };
    }); 
</script>

<!-- <tr>
    <td>2021. 03. 21</td>
    <td>200,000 CP</td>
    <td>100 PER</td>
    <td>fasdfsa68bn4a3hg7h4a3ba6ava99</td>
    <td>
        <p class="cblue">승인</p>
    </td>
</tr>
<tr>
    <td>2021. 03. 21</td>
    <td>200,000 CP</td>
    <td></td>
    <td></td>
    <td>
        <p class="cred">미승인</p>
    </td>
</tr> -->

