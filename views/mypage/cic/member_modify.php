<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/modal.css'); ?>
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
								<input type="text" id="mem_nickname" name="mem_nickname" placeholder=""
									value="<?php echo $this->member->item('mem_nickname'); ?>">
							</p>
							<a href="javascript:void(0);" class="modify-btn" id="ath_nickname"><span>닉네임 확인</span></a>
						</div>
					</li>
					<li>
						<p class="btxt">핸드폰</p>
						<div class="field modify">
							<p class="chk-input w380 readonly">
								<input type="text" id="mem_phone" name="mem_phone" placeholder=""
									value="<?php echo $this->member->item('mem_phone'); ?>" readonly="">
							</p>
							<a href="javascript:void(0);" id="modal_btn_phone" class="modify-btn"><span>핸드폰번호변경</span></a>
						</div>
					</li>
					<li>
						<p class="btxt">비밀번호</p>
						<div class="field modify">
							<p class="chk-input w380 readonly">
								<input type="password" id="mem_password" name="mem_password" placeholder="" value="**************" readonly="">
							</p>
							<a href="javascript:void(0);" id="modal_btn_password" class="modify-btn"><span>비밀번호변경</span></a>
						</div>
					</li>
					<li>
						<p class="btxt"><span></span> 지갑주소</p>
						<div class="field modify">
							<p class="chk-input w380 readonly">
								<input type="text" id="mem_wallet" name="mem_wallet" placeholder="" value="<?php echo $this->member->item('mem_wallet_address'); ?>" readonly="">
							</p>
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
						<li class="ath-email-content">
							<p class="btxt">이메일인증</p>
							<div class="all-email-box">
								<div class="field modify">
									<p class="chk-input w380">
										<input type="text" placeholder="인증번호를 입력해주세요" class="ath_num" name="ath_num" value="">
									</p>
									<a href="javascript:void(0);" data-type="phone" class="modify-btn send-ath-email">
										<span>이메일인증</span>
									</a>
									<a href="javascript:void(0);" data-type="phone" class="modify-btn confirm-ath-email" style="display:none;">
										<span>확인</span>
									</a>
									
								</div>
								<div class="phone-resend-email" style="display:none;">
									<a href="javascript:void(0);" data-type="phone" class="modify-btn resend-ath-email" style="display:block;">
										<span>인증번호 재전송</span>
									</a>	
								</div>
								<div class="phone-timer-box" style="display:none;">
									<span id="postTestMin1">00</span><!-- 분 -->
									<span>:</span>
									<span id="postTestSec1">10</span><!--초-->
									<!-- <span id="postTestMilisec">00</span>밀리초 -->
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
						</li>
					</ul>
				</div>
			</div>

			<!-- 새 비밀번호 modal -->
			<div id="myModal_password" class="modal">
				<div class="modal-content">
					<ul class="entry modify-box">
						<li class="ath-email-content">
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
									<span id="postTestMin2">00</span><!-- 분 -->
									<span>:</span>
									<span id="postTestSec2">10</span><!--초-->
									<!-- <span id="postTestMilisec">00</span>밀리초 -->
								</div>
							</div>
							<div class="success" style="display:none;"><p class="cblue">인증이 완료되었습니다.</p></div>
						</li>
						<li class="ath-nice-content">
							<p class="btxt">핸드폰인증</p>
							<div class="all-nice-box">
							
							</div>
							<div class="success" style="display:none;"><p class="cblue">인증이 완료되었습니다.</p></div>
						</li>
						<li class="password-modify-content">
							<p class="btxt">새 비밀번호</p>
							<div class="field modify">
								<p class="chk-input w380">
									<input type="password" placeholder="비밀번호" id="new_password" name="new_password" value="" readonly disabled style="background-color:#efefef;">
								</p>
								<p class="chk-input w380" style="margin-top:35px;">
									<input type="password" placeholder="비밀번호확인" id="new_password_re" name="new_password_re" value="" readonly disabled style="background-color:#efefef;">
								</p>
								<a href="javascript:void(0);" id="confirm_password" data-type="password" class="modify-btn">
									<span>확인</span>
								</a>
							</div>
						</li>
					</ul>
				</div>
			</div>

			<!-- 새 지갑주소 modal -->
			<div id="myModal_wallet" class="modal">
				<div class="modal-content">
					<ul class="entry modify-box">
						<li class="ath-email-content">
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
									<span id="postTestMin3">00</span><!-- 분 -->
									<span>:</span>
									<span id="postTestSec3">10</span><!--초-->
									<!-- <span id="postTestMilisec">00</span>밀리초 -->
								</div>
							</div>
							<div class="success" style="display:none;"><p class="cblue">인증이 완료되었습니다.</p></div>
						</li>
						<li class="ath-nice-content">
							<p class="btxt">핸드폰인증</p>
							<div class="all-nice-box">
								<!--  -->
							</div>
							<div class="success" style="display:none;"><p class="cblue">인증이 완료되었습니다.</p></div>
						</li>
						<li class="wallet-modify-content">
							<p class="btxt">새 지갑주소</p>
							<div class="field modify">
								<p class="chk-input w380">
									<input type="text" placeholder="지갑주소" id="new_wallet" name="new_wallet" value="" readonly disabled style="background-color:#efefef;">
								</p>
								<a href="javascript:void(0);" id="confirm_wallet" data-type="wallet" class="modify-btn">
									<span>확인</span>
								</a>
							</div>
						</li>
					</ul>
				</div>
			</div>

			<?php echo form_close(); ?>
		</div>
	 	<!-- page end // -->
	</div>
</div>

<script>
var nickname_ath_result  = 0;
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
	* modal1: 핸드폰변경
	* modal2: 비밀번호변경
	* modal3: 지갑주소변경
	*/
	$(document).ready(function(){
		$("#submitButton").on('click',function(){
			if(<?php echo $this->member->item('mem_nickname')?> === 
				$("#mem_nickname").val()){
					alert('닉네임이 같구나'); return;
				}
			if(nickname_ath_result == 0){
				alert('닉네임을 확인해주세요'); return;
			}
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
        
		var html = '';
		html += '<div class="field modify">';
		html += '<form name="form_chk1" method="post" id="password_form_chk">';
		html += '<input type="hidden" name="m" value="checkplusService">';
		html += '<input type="hidden" name="EncodeData" value="<?php echo html_escape(element('password_enc_data', $view)); ?>">';
		html += '<a href="javascript:fnPopup1();" id="ath_nice_phone" class="modify-btn"><span>핸드폰인증</span></a>';
		html += '</form>';
		html += '</div>';
		$('#myModal_password .ath-nice-content .all-nice-box').append(html); // 핸드폰인증 버튼 생성
	}
	btn3.onclick = function() {
		modal3.style.display = "block";
        
		var html = '';
		html += '<div class="field modify">';
		html += '<form name="form_chk2" method="post" id="wallet_form_chk">';
		html += '<input type="hidden" name="m" value="checkplusService">';
		html += '<input type="hidden" name="EncodeData" value="<?php echo html_escape(element('wallet_enc_data', $view)); ?>">';
		html += '<a href="javascript:fnPopup2();" id="ath_nice_phone" class="modify-btn"><span>핸드폰인증</span></a>';
		html += '</form>';
		html += '</div>';
		$('#myModal_wallet .ath-nice-content .all-nice-box').append(html); // 핸드폰인증 버튼 생성
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
            
			$('#myModal_password .ath-nice-content .all-nice-box > *').remove(); // 핸드폰인증 버튼 제거
		}
		if (event.target == modal3) {
			modal3.style.display = "none";
            
			$('#myModal_wallet .ath-nice-content .all-nice-box > *').remove(); // 핸드폰인증 버튼 제거
		}
	}
/**
 * 모달 끝
 */
/*****************************************************************************/
/**
 * 이메일 재전송 시작
 */

	var timerStart1;
	var timerStart2;
	var timerStart3;
    
	var startTime = function(type){
        
		if(type == "phone"){
			
			timerStart1 = setInterval(function() {
				var num = Number(document.getElementById('postTestSec1').textContent);
				
				document.getElementById('postTestSec1').innerText = num - 1;
				if( num - 1 == 0){
					clearTime(type);
					$('.' + type + '-timer-box').attr('style', "display:none;");
					$('.' + type + '-resend-email').attr('style', "display:block; margin-top: 20px;");
					document.getElementById('postTestSec1').innerText = 10;
				}
			}, 1000)
		}

		if(type == "password"){
			timerStart2 = setInterval(function() {
				var num = Number(document.getElementById('postTestSec2').textContent);
				
				document.getElementById('postTestSec2').innerText = num - 1;
				if( num - 1 == 0){
					clearTime(type);
					$('.' + type + '-timer-box').attr('style', "display:none;");
					$('.' + type + '-resend-email').attr('style', "display:block; margin-top: 20px;");
					document.getElementById('postTestSec2').innerText = 10;
				}
			}, 1000)
		}
        
		if(type == "wallet"){
			timerStart3 = setInterval(function() {
				var num = Number(document.getElementById('postTestSec3').textContent);
				
				document.getElementById('postTestSec3').innerText = num - 1;
				if( num - 1 == 0){
					clearTime(type);
					$('.' + type + '-timer-box').attr('style', "display:none;");
					$('.' + type + '-resend-email').attr('style', "display:block; margin-top: 20px;");
					document.getElementById('postTestSec3').innerText = 10;
				}
			}, 1000)
		}
	}

	var clearTime = function(type){
		if(type == "phone" && timerStart1) {
			clearInterval(timerStart1)
		}

		if(type == "password" && timerStart2) {
			clearInterval(timerStart2)
		}

		if(type == "wallet" && timerStart3) {
			clearInterval(timerStart3)
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

	var _is_re_sended = false;
	$(document).ready(function(){
		$('.resend-ath-email').on('click', function() {
			if(_is_re_sended) return false;
			_is_re_sended = true;
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
				async: true,
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
					
                    // 이메일 재전송까지 10초...
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
	var _is_sended = false;
	$(document).ready(function(){
		$(".send-ath-email").on('click', function() {
			if(_is_sended) return false;
			_is_sended = true;
			var type = $(this).data('type'); // 해당 type으로 통일된 인증번호 로직 내에서, 'phone' 'password' wallet', 어떠한 값변경을 위한 인증로직인지 구분합니다.

			$('.send-ath-email > span').text('발송중...');

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
				async: true,
				cache: false,
				success: function(data) {
					state = data.state;
					message = data.message;
                    
					// 성공
					if(state == 1){
						// 성공 메세지
                        alert(message);
						$('.send-ath-email > span').text('발송완료');
						$('.send-ath-email').attr('disabled', 'disabled');
                        
						$('#myModal_' + type + ' .ath-email-content .send-ath-email').attr('style', "display:none;"); // 이메일 전송 버튼 제거
						$('#myModal_' + type + ' .ath-email-content .confirm-ath-email').attr('style', "display:block;"); // 이메일 인증 버튼 생성
						$('#myModal_' + type + ' .ath-email-content .' + type + '-resend-email').attr('style', "display:block; margin-top: 20px;"); // 이메일 인증 버튼 생성
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
 * 이메일 인증 하기 시작
 */
	$(document).ready(function(){
		$(".confirm-ath-email").on('click', function() {
			var type = $(this).data('type');
			var ath_num = $('#myModal_' + type + ' .ath-email-content .ath_num').val();

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
						$('#myModal_' + type + ' .ath-email-content .all-email-box').attr('style', "display:none;"); // 이메일 인증 박스 제거
						$('#myModal_' + type + ' .ath-email-content .success').attr('style', "display:block;"); // 이메일 성공 메세지 생성
                        
						$('#myModal_' + type + ' .ath-email-content').addClass("agree") // 인증 완료 표식
                        
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
 * 모든 인증 완료 후 => input 태그 활성화 시작
 */
	var isAgreeForModify = function(type) {
		var isAgreeEmail = $('#myModal_' + type + ' .ath-email-content').hasClass("agree");
		var isAgreeNice = $('#myModal_' + type + ' .ath-nice-content').hasClass("agree");

		if(type == "phone" && isAgreeEmail){
			$('#myModal_' + type + ' #new_phone').attr('readonly', false);
			$('#myModal_' + type + ' #new_phone').attr('disabled', false);
			$('#myModal_' + type + ' #new_phone').attr('style', '');
            
			$('#myModal_' + type + ' .confirm-btn').attr('style', 'display:block; margin-top:20px;');
		}
        
		if(type == "password" && ( isAgreeEmail && isAgreeNice )){
			$('#myModal_' + type + ' #new_password').attr('readonly', false);
			$('#myModal_' + type + ' #new_password').attr('disabled', false);
			$('#myModal_' + type + ' #new_password').attr('style', '');
            
			$('#myModal_' + type + ' #new_password_re').attr('readonly', false);
			$('#myModal_' + type + ' #new_password_re').attr('disabled', false);
			$('#myModal_' + type + ' #new_password_re').attr('style', '');
            
			$('#myModal_' + type + ' .confirm-btn').attr('style', 'display:block; margin-top:20px;');
		}

		if(type == "wallet" && ( isAgreeEmail && isAgreeNice )){
			$('#myModal_' + type + ' #new_wallet').attr('readonly', false);
			$('#myModal_' + type + ' #new_wallet').attr('disabled', false);
			$('#myModal_' + type + ' #new_wallet').attr('style', '');
            
			$('#myModal_' + type + ' .confirm-btn').attr('style', 'display:block; margin-top:20px;');
		}
	}
/**
 * 모든 인증 완료 후 => input 태그 활성화 끝
 */
/*****************************************************************************/
/**
 * 핸드폰번호변경 시작
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
	$(document).on('click', "#confirm_phone", function(){

		if(! $('#myModal_phone .ath-email-content').hasClass("agree")){
			alert("이메일 인증이 필요합니다");
			return;
		}
        
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
 * 핸드폰번호변경 끝
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
			$('.password-modify-content').append(html);
		} else{
			$('.agree-password').remove();
			html = '<p class="agree-password cblue" class="rtxt mg10t">비밀번호가 일치합니다.</p>';
			$('.password-modify-content').append(html);
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
			$('.password-modify-content').append(html);
		} else{
			$('.agree-password').remove();
			html = '<p class="agree-password cblue" class="rtxt mg10t">비밀번호가 일치합니다.</p>';
			$('.password-modify-content').append(html);
		}
		
		oldVal2 = currentVal;
	});

	// 비밀번호 validation
	$(document).on('click', "#confirm_password", function(){
        
		if(! $('#myModal_password .ath-email-content').hasClass("agree")){
			alert("이메일 인증이 필요합니다");
			return;
		}
        
		if(! $('#myModal_password .ath-nice-content').hasClass("agree")){
			alert("핸드폰인증이 필요합니다");
			return;
		}
        
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
/**
 * 지갑주소변경 시작
 */
	// 지갑주소 validation
	$(document).on('click', "#confirm_wallet", function(){
        
		if(! $('#myModal_wallet .ath-email-content').hasClass("agree")){
			alert("이메일 인증이 필요합니다");
			return;
		}
        
		if(! $('#myModal_wallet .ath-nice-content').hasClass("agree")){
			alert("핸드폰인증이 필요합니다");
			return;
		}
        
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
 * 지갑주소변경 끝
 */
/********************************************************/
/**
 * 나이스 핸드폰인증 시작
 */
	window.name ="Parent_window";
	function fnPopup1(){
		window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		document.form_chk1.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
		document.form_chk1.target = "popupChk";
		document.form_chk1.submit();
	}
	function fnPopup2(){
		window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		document.form_chk2.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
		document.form_chk2.target = "popupChk";
		document.form_chk2.submit();
	}

	var successNice = function(type){
		$('#myModal_' + type + ' > .modal-content > .ath-nice-content .all-nice-box').attr('style', "display:none"); // 인증버튼 제거
		$('#myModal_' + type + ' > .modal-content .ath-nice-content .success').attr('style', "display:block"); // 인증완료 메세지
        
		$('#myModal_' + type + ' > .modal-content .ath-nice-content').addClass("agree") // 인증 완료 표식
        
		isAgreeForModify(type);
	}
	/**
	* 나이스 핸드폰인증 끝
	*/

	$(".ath_num").bind("change keyup input",function(){ 
		$(this).val( $(this).val().replace(/[^0-9]/g,"").substr(0,6) ); 
	});
	
	// 닉네임 확인
	$("#ath_nickname").on('click', function(){
		$(document).ready(function(){
			console.log("<?php echo $this->member->item('mem_nickname'); ?>");
			var _nickname = $("#mem_nickname").val();
			// alert(email);

			var result = '';
			var reason = '';
			$.ajax({
				url: cb_url + '/register/ajax_nickname_check',
				type: 'POST',
				data: {
					nickname: _nickname,
					csrf_test_name : cb_csrf_hash
				},
				dataType: 'json',
				async: true,
				cache: false,
				success: function(data) {
					result = data.result;
					reason = data.reason;
					if(result == "no"){
						alert(reason);
					}

					if(result == "available"){
						nickname_ath_result = 1;
						alert(reason);
					}
				}
			});
		})
	})

</script>