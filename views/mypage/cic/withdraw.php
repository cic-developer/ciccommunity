
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
                        <p class="stxt"><?php echo number_format(element('mem_cp', $view), 2); ?> <span>CP</span></p>
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
        </div>
        <!-- page end // -->
    </div>
</div>

<script>
    // 출금금액 validation
    function validateForm() {
        var x, text;
        var mem_cp = $("#html_mem_cp").val();

        // // Get the value of the input field with id="numb"
        x = document.getElementById("money").value;
        btn = document.getElementById("withdraw-request");

        // // If x is Not a Number or less than one or greater than 10
        if (isNaN(x) || x < 1 || x > mem_cp) {
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

