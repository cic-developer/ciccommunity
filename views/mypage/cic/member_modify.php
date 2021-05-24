<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/member_modify.js'); ?>"></script>

<div id="container-wrap">
	<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="member-wrap modify">
			<?php
			$attributes = array('class' => 'form-horizontal', 'name' => 'fregisterform', 'id' => 'fregisterform');
			echo form_open_multipart('membermodify/update', $attributes);
		?>
			<h3>개인정보변경</h3>
			<div class="entry">
				<ul>
					<li>
						<p class="btxt">ID (Email)</p>
						<div class="field">
							<p class="chk-input w210 readonly">
								<input type="text" placeholder=""
									value="<?php echo $this->member->item('mem_email'); ?>" readonly="">
							</p>
						</div>
					</li>
					<li>
						<p class="btxt">닉네임</p>
						<div class="field">
							<p class="chk-input w210 readonly">
								<input type="text" placeholder=""
									value="<?php echo $this->member->item('mem_nickname'); ?>" readonly="">
							</p>
						</div>
					</li>
					<li>
						<p class="btxt">핸드폰</p>
						<div class="field modify">
							<p class="chk-input w380 readonly">
								<input type="text" id="mem_phone" name="mem_phone" placeholder=""
									value="<?php echo $this->member->item('mem_phone'); ?>" readonly="">
							</p>
							<!-- <a href="#n" class="modify-btn"><span>핸드폰번호변경</span></a> -->
							<a href="javascript:void(0);" id="modal_btn_phone" class="modify-btn"><span>핸드폰번호변경</span></a>
						</div>
					</li>
					<!-- <li>
						<p class="btxt">E-mail</p>
						<div class="field">
							<p class="chk-input w380">
								<input type="text" placeholder="" value="dltngh2236@naver.com">
							</p>
						</div>
					</li> -->
					<li>
						<p class="btxt">비밀번호</p>
						<div class="field modify">
							<p class="chk-input w380 readonly">
								<input type="password" id="mem_password" name="mem_password" placeholder="" value="**************" readonly="">
							</p>
							<!-- <a href="#n" class="modify-btn"><span>비밀번호변경</span></a> -->
							<a href="javascript:void(0);" id="modal_btn_password" class="modify-btn"><span>비밀번호변경</span></a>
						</div>
					</li>
					<li>
						<p class="btxt"><span>PER</span> 지갑주소</p>
						<div class="field modify">
							<p class="chk-input w380 readonly">
								<input type="text" id="mem_wallet" name="mem_wallet" placeholder="" value="<?php echo $this->member->item('mem_wallet_address'); ?>" readonly="">
							</p>
							<!-- <a href="#n" class="modify-btn"><span>지갑주소수정</span></a> -->
							<a href="javascript:void(0);" id="modal_btn_wallet" class="modify-btn"><span>지갑주소수정</span></a>
						</div>
					</li>
				</ul>
			</div>
			<div class="lower">
				<a href="javascript:fnPopup();" id="submitButton" class="update-btn"><span>정보업데이트</span></a>
				<a href="javascript:void(0);" id="submitUserDelete" class="leave-btn"><span>회원탈퇴</span></a>
			</div>
			

			<!-- 새 핸드폰번호 modal -->
			<div id="myModal_phone" class="modal">
				<div class="modal-content">
					<ul class="entry modify-box">
						<li class="">
							<p class="btxt">새 핸드폰번호</p>
							<div class="field modify">
								<p class="chk-input w380">
									<input type="text" placeholder="" onkeyup="inputPhoneNumber(this);" id="new_phone" name="new_phone" value="" readonly disabled style="background-color:#efefef;">
								</p>
								<a href="javascript:void(0);" id="confirm_phone_number" class="modify-btn confirm-btn" style="display:none;">
									<span>확인</span>
								</a>
								<a href="javascript:void(0);" data-type="phone" class="modify-btn send_ath_email">
									<span>이메일인증</span>
								</a>
							</div>
						</li>
					</ul>
					<ul class="entry ath-email-box" style="display:none;">
						<li class="">
							<p class="btxt">인증번호</p>
							<div class="field modify">
								<p class="chk-input w380">
									<input type="text" placeholder="인증번호를 입력해주세요" class="ath_num" name="ath_num" value="">
								</p>
								<a href="javascript:void(0);" data-type="phone" class="modify-btn confirm_ath_email">
									<span>확인</span>
								</a>
							</div>
						</li>
					</ul>
				</div>
				
			</div>

			<!-- 핸드폰번호 변경 -->
			<!-- <div id="myModal_phone" class="modal"> -->
				<!-- Modal content -->
				<!-- <a href="javascript:void(0);" class="ath-email modify-btn modal-btn" data-type="phone"><span>이메일인증</span></a>
			</div> -->

			<!-- 새 비밀번호 modal -->
			<div id="myModal_password" class="modal">
				<div class="modal-content">
					<ul class="entry modify-box">
						<li class="password-modify-content">
							<p class="btxt">새 비밀번호</p>
							<div class="field modify">
								<p class="chk-input w380">
									<input type="text" placeholder="비밀번호" id="new_password" name="new_password" value="" readonly disabled style="background-color:#efefef;">
								</p>
								<p class="chk-input w380" style="margin-top:35px;">
									<input type="text" placeholder="비밀번호확인" id="new_password_re" name="new_password_re" value="" readonly disabled style="background-color:#efefef;">
								</p>
								<a href="javascript:void(0);" data-type="password" class="modify-btn view_ath_box">
									<span>이메일+핸드폰인증</span>
								</a>
							</div>
							<a href="javascript:void(0);" id="confirm_password_number" class="modify-btn confirm-btn" style="display:none;">
								<span>확인</span>
							</a>
						</li>
					</ul>
					<ul class="entry ath-email-box" style="display:none;">
						<li class="">
							<p class="btxt">이메일인증</p>
							<div class="all-email-box">
								<div class="field modify">
									<p class="chk-input w380">
										<input type="text" placeholder="인증번호를 입력해주세요" class="ath_num" name="ath_num" value="">
									</p>
									<a href="javascript:void(0);" data-type="password" class="modify-btn send-ath-email">
										<span>이메일인증</span>
									</a>
									<a href="javascript:void(0);" data-type="password" class="modify-btn confirm-ath-email" style="display:none;">
										<span>확인</span>
									</a>
									
								</div>
								<div class="password-resend-email" style="display:none;">
									<a href="javascript:void(0);" data-type="password" class="modify-btn resend-ath-email" style="display:block;">
										<span>인증번호 재전송</span>
									</a>	
								</div>
								<div class="password-timer-box" style="display:none;">
									<span id="postTestMin">00</span><!-- 분 -->
									<span>:</span>
									<span id="postTestSec">10</span><!--초-->
									<!-- <span id="postTestMilisec">00</span>밀리초 -->
								</div>
							</div>
							<div class="success" style="display:none;"><p class="cblue">인증이 완료되었습니다.</p></div>
						</li>
					</ul>
					<ul class="entry ath-nice-box" style="display:none;">
						<li>
							<p class="btxt">핸드폰인증</p>
							<div class="all-nice-box">
								<form name="form_chk" method="post" id="password_form_chk">
									<input type="hidden" name="m" value="checkplusService">
									<input type="hidden" name="EncodeData" value="<?php echo html_escape(element('password_enc_data', $view)); ?>">
									<a href="javascript:fnPopup();" id="ath_nice_phone" class="ath-nice-phone modify-btn modal-btn">
										<span>핸드폰인증</span>
									</a>
								</form>
								<form name="form_chk" method="post" id="password_form_chk" style="display:none;">
									<input type="hidden" name="m" value="checkplusService">
									<input type="hidden" name="EncodeData" value="<?php echo html_escape(element('password_enc_data', $view)); ?>">
									<a href="javascript:fnPopup();" id="ath_nice_phone" class="ath-nice-phone modify-btn modal-btn">
										<span>핸드폰인증x</span>
									</a>
								</form>
							</div>
							<div class="success" style="display:none;"><p class="cblue">인증이 완료되었습니다.</p></div>
						</li>
					</ul>
				</div>
			</div>

			<!-- 비밀번호 변경 -->
			<!-- <div id="myModal_password" class="modal">  -->
				<!-- Modal content -->
				<!-- <a href="javascript:void(0);" class="ath-email modify-btn modal-btn" data-type="password"><span>이메일인증</span></a>
			</div> -->

			<!-- 새 지갑주소 modal -->
			<div id="myModal_wallet" class="modal">
				<div class="modal-content">
					<ul class="entry modify-box">
						<li class="wallet-modify-content">
							<p class="btxt">새 비밀번호</p>
							<div class="field modify">
								<p class="chk-input w380">
									<input type="text" placeholder="비밀번호" id="new_wallet" name="new_wallet" value="" readonly disabled style="background-color:#efefef;">
								</p>
								<a href="javascript:void(0);" data-type="wallet" class="modify-btn view_ath_box">
									<span>이메일+핸드폰인증</span>
								</a>
							</div>
							<a href="javascript:void(0);" id="confirm_wallet_number" class="modify-btn confirm-btn" style="display:none;">
								<span>확인</span>
							</a>
						</li>
					</ul>
					<ul class="entry ath-email-box" style="display:none;">
						<li class="">
							<p class="btxt">이메일인증</p>
							<div class="all-email-box">
								<div class="field modify">
									<p class="chk-input w380">
										<input type="text" placeholder="인증번호를 입력해주세요" class="ath_num" name="ath_num" value="">
									</p>
									<a href="javascript:void(0);" data-type="wallet" class="modify-btn send-ath-email">
										<span>이메일인증</span>
									</a>
									<a href="javascript:void(0);" data-type="wallet" class="modify-btn confirm-ath-email" style="display:none;">
										<span>확인</span>
									</a>
									
								</div>
								<div class="wallet-resend-email" style="display:none;">
									<a href="javascript:void(0);" data-type="wallet" class="modify-btn resend-ath-email" style="display:block;">
										<span>인증번호 재전송</span>
									</a>	
								</div>
								<div class="wallet-timer-box" style="display:none;">
									<span id="postTestMin">00</span><!-- 분 -->
									<span>:</span>
									<span id="postTestSec">10</span><!--초-->
									<!-- <span id="postTestMilisec">00</span>밀리초 -->
								</div>
							</div>
							<div class="success" style="display:none;"><p class="cblue">인증이 완료되었습니다.</p></div>
						</li>
					</ul>
					<ul class="entry ath-nice-box" style="display:none;">
						<li>
							<p class="btxt">핸드폰인증</p>
							<div class="all-nice-box">
								<form name="form_chk" method="post" id="wallet_form_chk">
									<input type="hidden" name="m" value="checkplusService">
									<input type="hidden" name="EncodeData" value="<?php echo html_escape(element('wallet_enc_data', $view)); ?>">
									<a href="javascript:fnPopup();" id="ath_nice_phone" class="ath-nice-phone modify-btn modal-btn">
										<span>핸드폰인증</span>
									</a>
								</form>
								<form name="form_chk" method="post" id="wallet_form_chk" style="display:none;">
									<input type="hidden" name="m" value="checkplusService">
									<input type="hidden" name="EncodeData" value="<?php echo html_escape(element('wallet_enc_data', $view)); ?>">
									<a href="javascript:fnPopup();" id="ath_nice_phone" class="ath-nice-phone modify-btn modal-btn">
										<span>핸드폰인증x</span>
									</a>
								</form>
							</div>
							<div class="success" style="display:none;"><p class="cblue">인증이 완료되었습니다.</p></div>
						</li>
					</ul>
				</div>
			</div>

			<!-- 지갑주소 변경 -->
			<div id="myModal_wallet" class="modal"> 
				<!-- Modal content -->
				<a href="javascript:void(0);" class="ath-email modify-btn modal-btn" data-type="wallet"><span>이메일인증</span></a>
			</div>

			<!-- 로딩바 -->
			<!-- <div id = "Progress_Loading">
				<img src="../../../assets/images/ajax-loader.gif"/>
			</div> -->
			<?php echo form_close(); ?>
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
	width: 33%; /* Could be more or less, depending on screen size */                          
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
    color: #111;
    background: #efefefef;
    font-weight: 500;
    display: inline-block;
    vertical-align: top;
    margin-left: 15px;
    min-width: 120px;
    text-align: center;
    box-sizing: border-box;
	position:absolute;
	left:50%;
	top:50%;
	transform: translatex(-50%) translatey(-50%);
}

/* #Progress_Loading
{
	position: fixed;
	left: 50%;
	top: 50%;
	background: #ffffff;
	z-index:99;
	transform: translatex(-40%) translatey(-50%);
} */

</style>

<script>

	// $(document).ready(function(){
	// 	$('#Progress_Loading').hide(); //첫 시작시 로딩바를 숨겨준다.
	// })
	// .ajaxStart(function(){
	// 	$('#Progress_Loading').show(); //ajax실행시 로딩바를 보여준다.
	// })
	// .ajaxStop(function(){
	// 	$('#Progress_Loading').hide(); //ajax종료시 로딩바를 숨겨준다.
	// });
/*****************************************************************************/
	/*
	** 회원탈퇴 시작
	*/
	$(document).on('click', '#submitUserDelete', function(){
		alert('회원탈퇴시 vp/cp 및 정보를 복구하실 수 없습니다.');
		var isDelete = confirm('정말로 탈퇴하시겠습니까?');
		if( isDelete ){
			location.href = "userdelete";
			return;
		}
	})
	/*
	** 회원탈퇴 끝
	*/
/*****************************************************************************/
	/*
	** 모달 시작
	*/
	$(document).ready(function(){
		$("#submitButton").on('click',function(){
			$("#fregisterform").submit();
		});
	});

	// Get the modal
	var modal1 = document.getElementById('myModal_phone');
	var modal2 = document.getElementById('myModal_password');
	var modal3 = document.getElementById('myModal_wallet');

	// Get the button that opens the modal
	var btn1 = document.getElementById("modal_btn_phone");
	var btn2 = document.getElementById("modal_btn_password");
	var btn3 = document.getElementById("modal_btn_wallet");

	// Get the <span> element that closes the modal
	// var span = document.getElementsByClassName("close")[0];                                          

	// When the user clicks on the button, open the modal 
	btn1.onclick = function() {
		modal1.style.display = "block";
	}
	btn2.onclick = function() {
		modal2.style.display = "block";
	}
	btn3.onclick = function() {
		modal3.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	// span.onclick = function() {
	// 	modal.style.display = "none";
	// }

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal1) {
			modal1.style.display = "none";
		}
		if (event.target == modal2) {
			modal2.style.display = "none";
		}
		if (event.target == modal3) {
			modal3.style.display = "none";
		}
	}
/**
 * 모달 끝
 */
/*****************************************************************************/
/**
 * 이메일 재전송 시작
 */

	var stTime1;
	var timerStart1;
	var stTime2;
	var timerStart2;
    
	var startTime = function(type){
        
		if(type == "password"){
			if(! stTime1) {
				stTime1 = new Date().getTime() //클릭한 시점의 현재시간 timestamp를 stTime에 저장
			}
            
			timerStart1 = setInterval(function() {
				var nowTime = new Date().getTime() //1ms당 한 번씩 현재시간 timestamp를 불러와 nowTime에 저장
				var newTime = new Date(nowTime - stTime1) //(nowTime - stTime)을 new Date()에 넣는다
				var min = newTime.getMinutes() //분
				var sec = newTime.getSeconds() //초
				var milisec = Math.floor(newTime.getMilliseconds() / 10) //밀리초
				document.getElementById('postTestMin').innerText = addZero(min)
				document.getElementById('postTestSec').innerText = addZero(10- sec)
				// document.getElementById('postTestMilisec').innerText = addZero(milisec)
					if((addZero(10 - sec)) == 0){
						clearTime();
						$('.' + type + '-timer-box').attr('style', "display:none;");
						$('.' + type + '-resend-email').attr('style', "display:block; margin-top: 20px;");
					}
			}, 1000)
		}
        
		if(type == "wallet"){
			if(! stTime2) {
				stTime2 = new Date().getTime() //클릭한 시점의 현재시간 timestamp를 stTime에 저장
			}
            
			timerStart2 = setInterval(function() {
				var nowTime = new Date().getTime() //1ms당 한 번씩 현재시간 timestamp를 불러와 nowTime에 저장
				var newTime = new Date(nowTime - stTime2) //(nowTime - stTime)을 new Date()에 넣는다
				var min = newTime.getMinutes() //분
				var sec = newTime.getSeconds() //초
				var milisec = Math.floor(newTime.getMilliseconds() / 10) //밀리초
				document.getElementById('postTestMin').innerText = addZero(min)
				document.getElementById('postTestSec').innerText = addZero(10- sec)
				// document.getElementById('postTestMilisec').innerText = addZero(milisec)
					if((addZero(10 - sec)) == 0){
						clearTime();
						$('.' + type + '-timer-box').attr('style', "display:none;");
						$('.' + type + '-resend-email').attr('style', "display:block; margin-top: 20px;");
					}
			}, 1000)
		}
	}

	var clearTime = function(){
		if(timerStart) {
			clearInterval(timerStart)
		}
	}

	function addZero(num) {
		return (num < 10 ? '0'+num : ''+num)
	}

	var waitResend = function(type) {
		$('.' + type + '-timer-box').attr('style', "display:block;");
		$('.' + type + '-resend-email').attr('style', "display:none;");

		startTime(type);
	}

	$(document).ready(function(){
		$('.resend-ath-email').on('click', function() {
			var type = $(this).data('type'); // 해당 type으로 통일된 인증번호 로직 내에서, 'phone' 'password' wallet', 어떠한 값변경을 위한 인증로직인지 구분합니다.

			var state ='';
			var message = '';
			$.ajax({
				url: cb_url + '/membermodify/ajax_modify_email_send',
				type: 'POST',
				data: {
					type: type,
					csrf_test_name : cb_csrf_hash
				},
				dataType: 'json',
				async: false,
				cache: false,
				// beforeSend: function () {
				// var vm = this;
				// 	vm.setAttribute("disabled", "disabled");
				// },
				success: function(data) {
					state = data.state;
					message = data.message;
                    
					// 성공
					if(state == 1){
						// 성공 메세지
                        alert(message);
					}
					// 실패
					if(state == 0){
						// 실패 메세지
						alert(message);
					}

					waitResend(type);
				},
				error: function() {
					alert("에러가 발생했습니다");
				}
			});
		})
	})
/**
 * 이메일 재전송 끝
 */
/*****************************************************************************/
/**
 * 이메일 전송 시작
 */
	$(document).ready(function(){
		$(".send-ath-email").on('click', function() {
			var type = $(this).data('type'); // 해당 type으로 통일된 인증번호 로직 내에서, 'phone' 'password' wallet', 어떠한 값변경을 위한 인증로직인지 구분합니다.

			var state ='';
			var message = '';
			$.ajax({
				url: cb_url + '/membermodify/ajax_modify_email_send',
				type: 'POST',
				data: {
					type: type,
					csrf_test_name : cb_csrf_hash
				},
				dataType: 'json',
				async: false,
				cache: false,
				success: function(data) {
					state = data.state;
					message = data.message;
                    
					// 성공
					if(state == 1){
						// 성공 메세지
                        alert(message);
                        
						$('#myModal_' + type + ' .ath-email-box .send-ath-email').attr('style', "display:none;"); // 이메일 전송 버튼 제거
						$('#myModal_' + type + ' .ath-email-box .confirm-ath-email').attr('style', "display:block;"); // 이메일 인증 버튼 생성					}
						$('#myModal_' + type + ' .ath-email-box .' + type + '-resend-email').attr('style', "display:block; margin-top: 20px;"); // 이메일 인증 버튼 생성					}
					}
					// 실패
					if(state == 0){
						// 실패 메세지
						alert(message);
					}
				},
				error: function() {
					alert("에러가 발생했습니다");
				}
			});
		})
	})
/**
 * 이메일 전송 끝
 */
/*****************************************************************************/
/**
 * 인증 박스 보이기 시작
 */
	$(document).ready(function(){
		$(".view_ath_box").on('click', function() {
			var type = $(this).data('type'); // 해당 type으로 통일된 인증번호 로직 내에서, 'phone' 'password' wallet', 어떠한 값변경을 위한 인증로직인지 구분합니다.
            
			if($(this).hasClass("active")){
				$('#myModal_' + type + ' .ath-email-box').attr('style', "display:none;"); // 이메일 인증 박스 제거
                
				if(type == "password" || type == "wallet"){
					$('#myModal_' + type + ' .ath-nice-box').attr('style', "display:none;"); // 핸드폰 인증 박스 제거
				}
                
				$(this).removeClass("active");
			} else{
				$('#myModal_' + type + ' .ath-email-box').attr('style', "display:block;"); // 이메일 인증 박스 생성
                
				if(type == "password" || type == "wallet"){
					$('#myModal_' + type + ' .ath-nice-box').attr('style', "display:block;"); // 핸드폰 인증 박스 생성
				}
                
				$(this).addClass("active");
			}
		})
	})
/**
 * 인증 박스 보이기 끝
 */
/*****************************************************************************/
/**
 * 이메일 인증 하기 시작
 */
	$(document).ready(function(){
		$(".confirm-ath-email").on('click', function() {
			var type = $(this).data('type');
			var ath_num = $('#myModal_' + type + ' .ath-email-box .ath_num').val();

			var result = '';
			var reason = '';
			$.ajax({
				url: cb_url + '/membermodify/ajax_modify_ath_mail',
				type: 'POST',
				data: {
					type: type,
					ath_num: ath_num,
					csrf_test_name : cb_csrf_hash
				},
				dataType: 'json',
				async: false,
				cache: false,
				success: function(data) {
					result = data.result;
					reason = data.reason;
					
					//성공
					if(result == 1) {
						// 성공 메세지
						alert(reason);
						$('#myModal_' + type + ' .ath-email-box .all-email-box').attr('style', "display:none;"); // 이메일 인증 박스 제거
						$('#myModal_' + type + ' .ath-email-box .success').attr('style', "display:block;"); // 이메일 성공 메세지 생성
                        
						$('#myModal_' + type + ' .ath-email-box').addClass("agree") // 인증 완료 표식
                        
						isAgreeForModify(type);
					}
					// 실패
					if(result == 0){
						// 실패 메세지
						alert(reason);
					}
				},
				error: function(){
					alert('에러가 발생했습니다.');
				}
			});
		})
	})
/**
 * 이메일 인증 하기 끝
 */
/*****************************************************************************/
/**
 * 나이스 핸드폰 인증 하기 시작
 */
	var successNiceForPassword = function(type){
		$('#myModal_' + type + ' .ath-nice-box .all-nice-box').attr('style', "display:none");
		$('#myModal_' + type + ' .ath-nice-box .success').attr('style', "display:block");
        
		$('#myModal_' + type + ' .ath-nice-box').addClass("agree") // 인증 완료 표식
        
		isAgreeForModify(type);
	}
/**
 * 나이스 핸드폰 인증 하기 끝
 */
/*****************************************************************************/
/**
 * 모든 인증 완료 후 => input 태그 활성화 시작
 */
	var isAgreeForModify = function(type) {
		var isAgreeEmail = $('#myModal_' + type + ' .ath-email-box').hasClass("agree");
		var isAgreeNice = $('#myModal_' + type + ' .ath-nice-box').hasClass("agree");
        
		if(type == "password" && ( isAgreeEmail && isAgreeNice )){
			$('#myModal_' + type + ' #new_password').attr('readonly', false);
			$('#myModal_' + type + ' #new_password').attr('disabled', false);
			$('#myModal_' + type + ' #new_password').attr('style', '');
            
			$('#myModal_' + type + ' #new_password_re').attr('readonly', false);
			$('#myModal_' + type + ' #new_password_re').attr('disabled', false);
			$('#myModal_' + type + ' #new_password_re').attr('style', '');
            
			$('#myModal_' + type + ' .confirm-btn').attr('style', 'display:block; margin-top:20px;');
		}
	}
/**
 * 모든 인증 완료 후 => input 태그 활성화 끝
 */
/*****************************************************************************/
/**
 * 비밀번호변경 시작
 */
	// 비밀번호 == 비밀번호 확인 check
	var oldVal1 = '';
	$(document).on("propertychange change keyup paste input","#new_password",function(){
		var currentVal = $(this).val();
		if(currentVal == oldVal1) {
			return;
		}
		
		password2 = $("#new_password_re").val();
		if(password2 != currentVal ){ // && currentVal.length > 0){
			$('.agree-password').remove();
			html = '<p class="agree-password cred" class="rtxt mg10t">비밀번호가 일치하지 않습니다.</p>';
			$('#confirm_password_number').before(html);
		} else{
			$('.agree-password').remove();
			html = '<p class="agree-password cblue" class="rtxt mg10t">비밀번호가 일치합니다.</p>';
			$('#confirm_password_number').before(html);
		}
		
		oldVal1 = currentVal;
	});

	// 비밀번호 확인 == 비밀번호 check
	var oldVal2 = '';
	$(document).on("propertychange change keyup paste input","#new_password_re",function(){
		var currentVal = $(this).val();
		if(currentVal == oldVal2) {
			return;
		}
		
		password1 = $("#new_password").val();
		if(password1 != currentVal ){ // && currentVal.length > 0){
			$('.agree-password').remove();
			html = '<p class="agree-password cred" class="rtxt mg10t">비밀번호가 일치하지 않습니다.</p>';
			$('#confirm_password_number').before(html);
		} else{
			$('.agree-password').remove();
			html = '<p class="agree-password cblue" class="rtxt mg10t">비밀번호가 일치합니다.</p>';
			$('#confirm_password_number').before(html);
		}
		
		oldVal2 = currentVal;
	});

	// 비밀번호 validation
	$(document).on('click', "#confirm_password_number", function(){
		$('#myModal_password .modify-box > p').remove(); // append된 validation 메세지 일괄 삭제

		var _password = $("#new_password").val(); // 입력한 비밀번호
		var _password_re = $("#new_password_re").val(); // 입력한 비밀번호 확인
		var password = _password;
		var state = '';
		var message = '';
		$.ajax({
			url: cb_url + '/membermodify/ajax_password_confirm',
			type: 'POST',
			data: {
				new_password: _password,
				new_password_re: _password_re,
				csrf_test_name : cb_csrf_hash
			},
			dataType: 'json',
			async: false,
			cache: false,
			success: function(data) {
				state = data.state;
				message = data.message;
                
				if(state == 1){
					alert(message); // 성공 메세지 출력
					$("#mem_password").val(password); // 유저에게 보이는(readonly input tag)부분에 값 변경: 해당 값은 최종 정보업데이트 시 post로 넘어갑니다
					modal2.style.display = "none"; // modal 종료
				}
				if(state == 0){
					// validation 메세지 append (해당 메세지는 여러개가 생성될수 있기때문에 append를 하였습니다.)
					$('#myModal_password .modify-box').append(message);
				}
			},
			error: function(){
				alert('에러가 발생했습니다.');
			}
		});
	});
/**
 * 비밀번호변경 끝
 */
/*****************************************************************************/






	// 인증번호 이메일 발송
	$(document).ready(function(){
		$(".ath-email").on('click', function(){
			var type = $(this).data('type'); // 해당 type으로 통일된 인증번호 로직 내에서, 'phone' 'password' wallet', 어떠한 값변경을 위한 인증로직인지 구분합니다.
            
			$.ajax({
				url: cb_url + '/membermodify/ajax_modify_email_send',
				type: 'POST',
				data: {
					type: type,
					csrf_test_name : cb_csrf_hash
				},
				dataType: 'json',
				async: false,
				cache: false,
				success: function(data) {
					state = data.state;
					message = data.message;
                    
					// 성공
					if(state == 1){
						// 성공 메세지
                        alert(message);
                        
						// 핸드폰번호변경 이메일 인증
						if(type == 'phone'){
							$('#myModal_phone > .ath-email').remove(); // 이메일 인증 실행 버튼 삭제
						}
						// 비밀번호변경 이메일 인증
						if(type == 'password'){
							$('#myModal_password > .ath-email').remove(); // 이메일 인증 실행 버튼 삭제
						}
						// 지갑주소변경 이메일 인증
						if(type == 'wallet'){
							$('#myModal_wallet > .ath-email').remove(); // 이메일 인증 실행 버튼 삭제
						}
						var html = '';
						html += '<div class="modal-content ' + type + '-modal-content entry">';
						html += '<ul class="ath-email-box">';
						html += '<li class="ath-email-content">';
						html += '<p class="btxt">';
						html += '이메일 인증';
						html += '<i class="fas fa-recycle"></i>';
						html += '</p>';
						html += '<div class="field modify">';
						html += '<p class="chk-input w380">';
						html += '<input type="text" placeholder="" id="ath_num" name="ath_num" value="">';
						html += '<input type="hidden" id="modify_type" name="modify_type" value="' + type + '">';
						html += '</p>';
						html += '<a href="javascript:void(0);" id="ath_mail_btn" class="modify-btn"><span>인증번호 확인</span></a>';
						html += '</div>';
						html += '</li>';
						html += '</ul>';
						html += '</div>';
                        
						// 핸드폰번호변경 이메일 인증
						if(type == 'phone'){
							$('#myModal_phone').append(html); // 이메일 인증박스 추가
						}
						// 비밀번호변경 이메일 인증
						if(type == 'password'){
							$('#myModal_password').append(html); // 이메일 인증박스 추가
						}
						// 지갑주소변경 이메일 인증
						if(type == 'wallet'){
							$('#myModal_wallet').append(html); // 이메일 인증박스 추가
						}
					}
					// 실패
					if(state == 0){
						// 실패 메세지
						alert(message);
					}
				},
				error: function(){
					alert('에러가 발생했습니다.');
				}
			});
		})
	})

	// 이메일 인증 하기
	$(document).on('click', "#ath_mail_btn", function(){
		var ath_num = $(".ath_num").val();
		var modify_type = $("#modify_type").val();
        
		var result = '';
		var reason = '';
		$.ajax({
			url: cb_url + '/membermodify/ajax_modify_ath_mail',
			type: 'POST',
			data: {
				ath_num: ath_num,
				modify_type: modify_type,
				csrf_test_name : cb_csrf_hash
			},
			dataType: 'json',
			async: false,
			cache: false,
			success: function(data) {
				result = data.result;
				reason = data.reason;
                
				alert(reason);
                
				// 실패
				if(result == 0){}
                
				//성공
				//// => 핸드폰변경 박스
				if(result == 1) {
					
					var html = '';
					html += '<ul class="phone-modify-box">';
					html += '<li class="phone-modify-content">';
					html += '<p class="btxt">새 핸드폰번호</p>';
					html += '<div class="field modify">';
					html += '<p class="chk-input w380">';
					html += '<input type="text" placeholder="" onKeyup="inputPhoneNumber(this);" id="new_phone" name="new_phone" value="">';
					html += '</p>';
					html += '<a href="javascript:void(0);" id="phone_modify_btn" class="modify-btn"><span>완료</span></a>';
					html += '</div>';
					html += '</li>';
					html += '</ul>';
                    
					$('.phone-modal-content > .ath-email-box').remove(); // 이메일 인증 박스 삭제		
					$('.phone-modal-content').append(html); // 수정 박스 생성
				}
                
				//// => 비밀번호변경 휴대폰인증 버튼
				if(result == 2){
                    
					var html = '';
					html += '<form name="form_chk" method="post" id="password_form_chk">'
					html += '<input type="hidden" name="m" value="checkplusService">'
					html += '<input type="hidden" name="EncodeData" value="<?php echo html_escape(element('phone_enc_data', $view)); ?>">'
					html += '<a href="javascript:fnPopup();" id="ath_nice_phone" class="ath-nice-phone modify-btn modal-btn"><span>휴대폰 인증</span></a>'
					html += '</form>'
					
					$('.password-modal-content').remove(); // 이메일 인증 박스 삭제		
					$('#myModal_password').append(html); // 수정 박스 생성
				}
				
				//// => 지갑주소변경 휴대폰인증 버튼
				if(result == 3){
					
					var html = '';
					html += '<form name="form_chk" method="post" id="wallet_form_chk">'
					html += '<input type="hidden" name="m" value="checkplusService">'
					html += '<input type="hidden" name="EncodeData" value="<?php echo html_escape(element('wallet_enc_data', $view)); ?>">'
					html += '<a href="javascript:fnPopup();" id="ath_nice_phone" class="ath-nice-phone modify-btn modal-btn"><span>휴대폰 인증</span></a>'
					html += '</form>'
                    
					$('.wallet-modal-content').remove(); // 이메일 인증 박스 삭제		
					$('#myModal_wallet').append(html); // 수정 박스 생성
				}
			},
				error: function(){
					alert('에러가 발생했습니다.');
				}
		});
	});

/**
 * 이메일 인증 끝
 */
/*****************************************************************************/
/**
 * 휴대폰번호변경 시작
 */
	// 핸드폰번호 하이푼 자동 생성
	function inputPhoneNumber(obj) { 
		var number = obj.value.replace(/[^0-9]/g, ""); 
		var phone = ""; 
		if(number.length < 4) { 
			return number; 
		} else if(number.length < 7) { 
			phone += number.substr(0, 3); 
			phone += "-"; 
			phone += number.substr(3); 
		} else if(number.length < 11) { 
			phone += number.substr(0, 3); 
			phone += "-"; 
			phone += number.substr(3, 3);
			phone += "-"; 
			phone += number.substr(6); 
		} else { 
			phone += number.substr(0, 3); 
			phone += "-"; 
			phone += number.substr(3, 4); 
			phone += "-"; 
			phone += number.substr(7); 
		} 
		
		obj.value = phone; 
	}

	// 핸드폰번호 validation and 사용가능여부 check
	$(document).on('click', "#confirm_phone_number", function(){
        
		var _phone = $("#new_phone").val(); // 입력한 핸드폰번호
		var phone = _phone;
		var state = '';
		var message = '';
		$.ajax({
			url: cb_url + '/membermodify/ajax_phone_confirm',
			type: 'POST',
			data: {
				new_phone: _phone,
				csrf_test_name : cb_csrf_hash
			},
			dataType: 'json',
			async: false,
			cache: false,
			success: function(data) {
				state = data.state;
				message = data.message;
                
                
				if(state == 1){
					alert(message); // 성공 메세지 출력
					$("#mem_phone").val(phone); // 유저에게 보이는(readonly input tag)부분에 값 변경: 해당 값은 최종 정보업데이트 시 post로 넘어갑니다
					modal1.style.display = "none"; // modal 종료
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
	})
/**
 * 휴대폰번호변경 끝
 */
/********************************************************/

/********************************************************/
/**
 * 지갑주소변경 시작
 */
	// 지갑주소변경 박스 생성하기
	function createWalletModify(){
		var html = '';
		html += '<div class="modal-content entry">';
		html += '<ul class="wallet-modify-box">';
		html += '<li class="wallet-modify-content">';
		html += '<p class="btxt">새 지갑주소 확인</p>';
		html += '<div class="field modify">';
		html += '<p class="chk-input w380">';
		html += '<input type="text" placeholder="" id="new_wallet" name="new_wallet" value="">';
		html += '</p>';
		html += '<a href="javascript:void(0);" id="wallet_modify_btn" class="modify-btn"><span>확인</span></a>';
		html += '</div>';
		html += '</li>';
		html += '</ul>';
		html += '</div>';
        
		$('#wallet_form_chk').remove(); // 휴대폰 인증 버튼 삭제		
		$('#myModal_wallet').append(html);  // 지갑주소변경 박스 생성
	}

	$(document).on('click', "#wallet_modify_btn", function(){
        
		var _wallet = $("#new_wallet").val(); // 입력한 지갑주소
		var wallet = _wallet;
		var state = '';
		var message = '';
		$.ajax({
			url: cb_url + '/membermodify/ajax_wallet_confirm',
			type: 'POST',
			data: {
				new_wallet: _wallet,
				csrf_test_name : cb_csrf_hash
			},
			dataType: 'json',
			async: false,
			cache: false,
			success: function(data) {
				state = data.state;
				message = data.message;

				if(state == 1){
					alert(message); // 성공 메세지 출력
					$("#mem_wallet").val(wallet); // 유저에게 보이는(readonly input tag)부분에 값 변경: 해당 값은 최종 정보업데이트 시 post로 넘어갑니다
					modal3.style.display = "none"; // modal 종료
				}
				if(state == 0){
					// $('.wallet-modify-box').append(message);
					alert(message); // 실패 메세지 출력
				}
			},
			error: function(){
				alert('에러가 발생했습니다.');
			}
		});
	});
/**
 * 비밀번호변경 끝
 */

/********************************************************/

/**
 * 나이스 휴대폰 인증 시작
 */
window.name ="Parent_window";
function fnPopup(){
		window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
		document.form_chk.target = "popupChk";
		document.form_chk.submit();
	}
/**
 * 나이스 휴대폰 인증 끝
 */


</script>