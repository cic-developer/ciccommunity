<div id="container-wrap">
    <div id="top-vis">
        <div class="txt">
            <h2>Forum</h2>
            <p>이슈에 관련해서 투표를 진행하거나 PER 생태계에 대한 의사결정을 하며 의견을 교환할 수 있는 공간입니다. <br />포인트로 투표에 참여할 수 있으며 ‘운영정책’에 따라 지급 포인트를
                지출하거나 받게 됩니다. </p>
        </div>
        <div class="img forum"><img src="<?php echo base_url('assets/images/top-vis05.jpg')?>" alt="" /></div>
    </div>
    <div id="contents" class="div-cont">
        <!-- page start / -->

        <?php
		echo show_alert_message($this->session->flashdata('message'), '<script>alert("', '");</script>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
        <div class="board-wrap list">
            <div class="forums">
                <h3>진행중인 <span>BEST</span> 포럼</h3>
                <div class="cont">
                    <a href="#n" class="prev"><span class="blind">이전</span></a>
                    <div class="forum-slide">
                        <div class="item active">
                            <div class="img"><img src="<?php echo base_url('assets/images/forum-img01.jpg')?>" alt="" /></div>
                            <div class="ov">
                                <div class="txt">
                                    <p class="btxt">“ 도지 코인” <br />1,000원 간다!</p>
                                </div>
                                <p class="stxt">총 3,145,789VP</p>
                                <a href="#n"><span>참여하기!</span></a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img"><img src="<?php echo base_url('assets/images/forum-img02.jpg')?>" alt="" /></div>
                            <div class="ov">
                                <div class="txt">
                                    <p class="btxt">“ 도지 코인” <br />1,000원 간다!</p>
                                </div>
                                <p class="stxt">총 3,145,789VP</p>
                                <a href="#n"><span>참여하기!</span></a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img"><img src="<?php echo base_url('assets/images/forum-img03.jpg')?>" alt="" /></div>
                            <div class="ov">
                                <div class="txt">
                                    <p class="btxt">“ 도지 코인” <br />1,000원 간다!</p>
                                </div>
                                <p class="stxt">총 3,145,789VP</p>
                                <a href="#n"><span>참여하기!</span></a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img"><img src="<?php echo base_url('assets/images/forum-img04.jpg')?>" alt="" /></div>
                            <div class="ov">
                                <div class="txt">
                                    <p class="btxt">“ 도지 코인” <br />1,000원 간다!</p>
                                </div>
                                <p class="stxt">총 3,145,789VP</p>
                                <a href="#n"><span>참여하기!</span></a>
                            </div>
                        </div>
                    </div>
                    <a href="#n" class="next"><span class="blind">다음</span></a>
                </div>
            </div>
            <div class="gap50"></div>
            <div class="ftab">
                <ul>
                    <li><a href="<?php echo base_url('board/forum')?>"><span>진행중 포럼</span></a></li>
                    <li class="active"><a href="<?php echo base_url('board/userforum')?>"><span>승인대기 포럼</span></a></li>
                    <li><a href="#n"><span>마감된 포럼</span></a></li>
                </ul>
            </div>
            <div class="gap20"></div>
            <div class="forum-filter">
                <div class="sel-box c03">
                    <a href="#n" class="sel-btn"><span>최신순</span></a>
                    <ul>
                        <li class="active"><a href="#n"><span>최신 순</span></a></li>
                        <li><a href="#n"><span>관련도 순</span></a></li>
                        <li><a href="#n"><span>인기 순</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="list forum">
                <table>
                    <colgroup>
                        <col width="170" />
                        <col width="*" />
                        <col width="100" />
                        <col width="170" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th>제안자</th>
                            <th>제목</th>
                            <th>등록일</th>
                            <th><span class="cyellow">좋아요</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="my-info">
                                    <p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt="" /></p>
                                    <p class="rtxt">코알못259 코알못259</p>
                                </div>
                            </td>
                            <td class="l"><a href="#n">정치 자료, 성인물은 엄격하게 금지하며 강력하게 제재합니다. <span
                                        class="reply">(12)</span></a></td>
                            <td>방금</td>
                            <td>
                                <p class="cyellow">10,000,000</p>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="lower r">
                <div class="ov">
                    <?php if (element('isDeposit', $view)) { ?>
                    <a href="#n" class="by-btn" id="deposit_subtract" data-deposit-url="<?php echo site_url(element('deposit_url', $view)); ?>"><span>예치금 빼기</span></a>
                    <?php }else { ?>
                    <a href="#n" class="by-btn" id="deposit_insert" data-deposit-url="<?php echo site_url(element('deposit_url', $view)); ?>"><span>예치금 넣기</span></a>
                    <?php } ?>

                    <a href="#n" class="by-btn"><span>글쓰기</span></a>
                    <!-- 글쓰기시 관리자가 설정한 포인트보다 적으면... alert하면 어떨까 -->
                    
                    <p class="ex-cp">보유 예치금 : <?php echo number_format(element('mem_deposit', $view)); ?> CP</p>
                </div>
            </div>
            <!-- s: paging-wrap -->
            <div class="paging-wrap">
                <!-- <a href="#" class="prev ctrl"><span>이전</span></a> -->
                <ul>
                    <li><a href="#" class="active">1</a></li>
                    <li><a href="#n">2</a></li>
                    <li><a href="#n">3</a></li>
                    <li><a href="#n">4</a></li>
                    <li><a href="#n">5</a></li>
                </ul>
                <p class="num"><span>1</span> / 10 </p>
                <a href="#" class="next ctrl"><span>다음</span></a>
            </div>
            <!-- e: paging-wrap -->
            <!-- s: board-filter -->
            <div class="board-filter sel">
                <!-- <p class="chk-select">
					<select>
						<option value="">제목</option>
						<option value="">내용</option>
					</select>
				</p> -->
                <div class="ov">
                    <div class="sel-box">
                        <a href="#n" class="sel-btn"><span>제목</span></a>
                        <ul>
                            <li class="active"><a href="#n"><span>제목+내용</span></a></li>
                            <li><a href="#n"><span>제목</span></a></li>
                            <li><a href="#n"><span>내용</span></a></li>
                            <li><a href="#n"><span>닉네임</span></a></li>
                        </ul>
                    </div>
                    <p class="chk-input">
                        <input type="text" placeholder="검색어를 입력해주세요" autocomplete="off" />
                        <a href="#n" class="search-btn"><span>검색</span></a>
                    </p>
                </div>
            </div>
            <!-- e: board-filter -->

            <!-- 새 핸드폰번호 modal -->
            <div id="myModal_deposit" class="modal">
				<div class="modal-content">
					<ul class="entry modify-box">
                        <table>
                            <colgroup>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td>필요 예치금</td>
                                    <td>11</td>
                                </tr>
                                <tr>
                                    <td>보유 CP</td>
                                    <td>22</td>
                                </tr>
                                <tr>
                                    <td>예상 잔여 CP</td>
                                    <td>33</td>
                                </tr>
                            </tbody>
                        </table>
						<!-- <li class="ath-email-content">
							<p class="btxt">이메일인증</p>
							<div class="all-email-box">
								<div class="field modify">
									<p class="chk-input w380">
										<input type="text" placeholder="인증번호를 입력해주세요" class="ath_num" name="ath_num" value="">
									</p>
                                    
                                    <label for="deposit_confirm">확인</label>
									<input type="checkbox" id="deposit_confirm" >
									
								</div>
								<div class="phone-resend-email" style="display:none;">
									<a href="javascript:void(0);" data-type="phone" class="modify-btn resend-ath-email" style="display:block;">
										<span>인증번호 재전송</span>
									</a>	
								</div>
							</div>
							<div class="success" style="display:none;"><p class="cblue">인증이 완료되었습니다.</p></div>
						</li>
						<li class="wallet-modify-content">
							<p class="btxt">새 핸드폰번호</p>
							<div class="field modify">
								<p class="chk-input w380">
									<input type="text" placeholder="핸드폰번호" onkeyup="inputPhoneNumber(this);" id="new_phone" name="new_phone" value="" readonly disabled style="background-color:#efefef;">
								</p>
								<a href="javascript:void(0);" id="confirm_phone"  data-type="phone" class="modify-btn">
									<span>확인</span>
								</a>
							</div>
						</li> -->
					</ul>
				</div>
			</div>

        </div>
        <!-- page end / -->
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

    // $(document).on('click', '#deposit_subtract', function() {
	// 	deposit_subtract_submit(document.flist, 'subtract', $(this).attr('data-deposit-url'));
	// });

    // function deposit_subtract_submit(f, acttype, actpage){

    //     alert("예치한 금액이 전부 반환됩니다")

    //     if (acttype === 'subtract' && ! confirm('선택한 요청을 정말 승인 하시겠습니까?')) return;
    //     f.action = actpage;
	// 	f.submit();
    // }   

    // Get the modal
    var modal = document.getElementById('myModal_deposit');

    // Get the button that opens the modal
    var btn = document.getElementById("deposit_insert");

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



    // $(document).on('click', '#deposit_insert', function() {




        // alert("예치한 금액이 전부 반환됩니다");

        // var isConfirm = confirm('선택한 요청을 정말 승인 하시겠습니까?');

        // if(isConfirm){

        //     $.ajax({
        //         url: cb_url + '/deposit/subtract',
        //         type: 'POST',
        //         data: {
        //             csrf_test_name : cb_csrf_hash
        //         },
        //         dataType: 'json',
        //         async: false,
        //         cache: false,
        //         success: function(data) {
        //             state = data.state;
        //             message = data.message;
                    
                    
        //             if(state == 1){
        //                 // 성공 메세지 출력
        //                 alert(message); 
        //                 location.reload(true);
        //             }
        //             if(state == 0){
        //                 // 실패 메세지 출력
        //                 alert(message);
        //             }
        //         },
        //         error: function(){
        //             alert('에러가 발생했습니다.');
        //         }
        //     });
        // }
    // })

    $(document).on('click', '#deposit_subtract', function() {
        alert("예치한 금액이 전부 반환됩니다");

        var isConfirm = confirm('선택한 요청을 정말 승인 하시겠습니까?');

        if(isConfirm){

            $.ajax({
                url: cb_url + '/deposit/subtract',
                type: 'POST',
                data: {
                    csrf_test_name : cb_csrf_hash
                },
                dataType: 'json',
                async: false,
                cache: false,
                success: function(data) {
                    state = data.state;
                    message = data.message;
                    
                    
                    if(state == 1){
                        // 성공 메세지 출력
                        alert(message); 
                        location.reload(true);
                    }
                    if(state == 0){
                        // 실패 메세지 출력
                        alert(message);
                    }
                },
                error: function(){
                    alert('에러가 발생했습니다.');
                }
            });
        }
    })

</script>