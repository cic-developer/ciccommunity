<div id="container-wrap">
    <div id="contents" class="div-cont">
        <!-- page start // -->
        <div class="member-wrap charge">
            <h3>충전하기</h3>
            <div class="entry">
                <ul>
                    <li>
                    <!-- 
                        충전하기 클릭시 카이카스라는 확장 프로그램이 실행되게끔 해놓으려고 합니다. 
                        이때 확인 누르면 나오는 결과값을 가지고 충전여부를 판단, 데이터베이스에 넣으시면 됩니다.
                    -->
                        <p class="btxt">충전액</p>
                        <div class="field draw">
                            <p class="chk-input w210">
                                <input id="charge_input" type="text" placeholder="금액을 입력해주세요." value="">
                            </p>
                            <p class="ctxt">PER</p>
                            <a id="charge_button" href="#n" class="draw-btn"><span>충전하기</span></a>
                        </div>
                        <!-- 아래 100CP는, 메인페이지 거래소 가격 해서 1PER 당 n CP(CP는 100원) 비율로 나타냈으면 합니다. -->
                        <div class="explan">1 PER 당 &rarr;<p style="display:inline;"> <?php echo rs_number_format($per2cp, 2); ?> CP 입니다.</p></div>
                    </li>
                </ul>
            </div>
            <div class="gap50"></div>
            <h3 class="no-mgt">충전요청현황</h3>
            <div class="list">
                <table>
                    <colgroup>
                        <col width="25%">
                        <col width="25%">
                        <col width="25%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>충전 신청일</th>
                            <th>사용 PER</th>
                            <th>충전한 CP 금액</th>
                            <th>상태</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (element('list', element('data', $view))) {
                        foreach (element('list', element('data', $view)) as $result) {
                    ?>
                        <tr>
                            <td><?php echo html_escape(element('cp_wdate', $result)); ?></td>
                            <td><?php echo element('cp_value', $result) != null ? (rs_number_format(element('cp_value', $result), 2, 0)).' PER': ''; ?></td>
                            <td><?php echo element('cp_charge_point', $result) != null ? (rs_number_format(element('cp_charge_point', $result), 2, 0)).' CP': '0 CP'; ?></td>
                            <td><?php echo element('cp_state', $result) ?></td>
                        </tr>
                    <?php
                        }
                    }
					?>
                    </tbody>
                </table>
                <!-- 페이지네이션 가능하면 부탁드립니다. -->
            </div>

            <div class="paging-wrap">
				<?php echo element('paging', $view); ?>
			</div>
        </div>
        <!-- page end // -->
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/chargecp.js'); ?>"></script>
<script>
    csrf_key = '<?php echo $this->security->get_csrf_token_name(); ?>';
    csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
    userWallet_in_mypage = '<?php echo $this->member->item('mem_wallet_address'); ?>';
    $("#charge_input").bind("change keyup input",function(){
        $(this).val( $(this).val().replace(/[^0-9]/g,"") );
    });
</script>