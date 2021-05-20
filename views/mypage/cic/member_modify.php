<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>

<div id="container-wrap">
	<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="member-wrap modify">
			<?php
			$attributes = array('class' => 'form-horizontal', 'name' => 'fregisterform', 'id' => 'fregisterform');
			echo form_open_multipart(current_url(), $attributes);
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
								<input type="text" id="mem_phone" placeholder=""
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
								<input type="password" id="mem_password" placeholder="" value="**************" readonly="">
							</p>
							<!-- <a href="#n" class="modify-btn"><span>비밀번호변경</span></a> -->
							<a href="javascript:void(0);" id="modal_btn_password" class="modify-btn"><span>비밀번호변경</span></a>
						</div>
					</li>
					<li>
						<p class="btxt"><span>PER</span> 지갑주소</p>
						<div class="field modify">
							<p class="chk-input w380 readonly">
								<input type="text" placeholder="" value="tttttttttttttttttttttttttt" readonly="">
							</p>
							<a href="#n" class="modify-btn"><span>지갑주소수정</span></a>
						</div>
					</li>
				</ul>
			</div>
			<div class="lower">
				<a href="#n" class="update-btn"><span>정보업데이트</span></a>
				<a href="#n" class="leave-btn"><span>회원탈퇴</span></a>
			</div>

			<!-- 핸드폰번호 변경 -->
			<div id="myModal_phone" class="modal">
				<!-- Modal content -->
				<div class="modal-content entry">
					<span class="close"></span>
					<!-- &times; -->
					<ul class="new-phone-box">
						<li>
							<p class="btxt">새 핸드폰번호</p>
							<div class="field modify">
								<p class="chk-input w380">
									<input type="text" onKeyup="inputPhoneNumber(this);" placeholder="" id="new_phone" name="new_phone" value="">
								</p>
								<a href="javascript:void(0);" id="send_email1" class="modify-btn"><span>이메일인증</span></a>
							</div>
						</li>
					</ul>
				</div>
			</div>

			<!-- 비밀번호 변경 -->
			<div id="myModal_password" class="modal"> 
				<!-- Modal content -->
				<div class="modal-content entry">
					<span class="close"></span>
					<!-- &times; -->
					<ul class="new-password-box">
						<li class="new-password">
							<p class="btxt">새 비밀번호</p>
							<div class="field modify">
								<p class="chk-input w380">
									<input type="password" placeholder="" id="new_password" name="new_password" value="">
								</p>
								<!-- <a href="javascript:void(0);" id="send_email2" class="modify-btn"><span>이메일인증</span></a> -->
							</div>
						</li>
						<li class="new-password-re">
							<p class="btxt">새 비밀번호 확인</p>
							<div class="field modify">
								<p class="chk-input w380">
									<input type="password" placeholder="" id="new_password_re" name="new_password_re" value="">
								</p>
								<a href="javascript:void(0);" id="send_email2" class="modify-btn"><span>이메일인증</span></a>
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
	width: 50%; /* Could be more or less, depending on screen size */                          
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

</style>

<script>
// Get the modal
var modal1 = document.getElementById('myModal_phone');
var modal2 = document.getElementById('myModal_password');

// Get the button that opens the modal
var btn1 = document.getElementById("modal_btn_phone");
var btn2 = document.getElementById("modal_btn_password");

// Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];                                          

// When the user clicks on the button, open the modal 
btn1.onclick = function() {
	modal1.style.display = "block";
}
btn2.onclick = function() {
	modal2.style.display = "block";
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
}
/*****************************************************************************/
/**
 * 휴대폰번호변경 시작
 */
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

var phone_num = '';
// 이메일 확인 + 인증번호 보내기
$(document).ready(function(){
	$("#send_email1").on('click', function(){
		var _phone = $("#new_phone").val();
		phone_num = _phone;
		var state = '';
		var message = '';
		$.ajax({
			url: cb_url + '/membermodify/ajax_phone_modify_email_send',
			type: 'POST',
			data: {
				mem_phone: _phone,
				csrf_test_name : cb_csrf_hash
			},
			dataType: 'json',
			async: false,
			cache: false,
			success: function(data) {
				state = data.state;
				message = data.message;
			}
		});
		alert(message);
		$('.phone-success-email').remove();
		$('.con-mail1').remove();
		if(state == 1){
			html = '';
			html += '<li class="con-mail1">'
			html += '<p class="btxt">이메일 인증</p>'
			html += '<div class="field modify">'
			html += '<p class="chk-input w380">'
			html += '<input type="text" placeholder="" id="ath_num1" name="ath_num1" value="">'
			html += '</p>'
			html += '<a href="javascript:void(0);" id="con_phone_mail_btn" class="modify-btn"><span>메일인증 확인</span></a>'
			html += '</div>'
			html += '</li>'
			$('.new-phone-box').append(html);
		}
	})
})

// 이메일 인증 하기
$(document).on('click', "#con_phone_mail_btn", function(){
	var ath_num = $("#ath_num1").val();

	var result = '';
	var reason = '';
	$.ajax({
		url: cb_url + '/membermodify/ajax_phone_modify_ath_mail',
		type: 'POST',
		data: {
			ath_num: ath_num,
			csrf_test_name : cb_csrf_hash
		},
		dataType: 'json',
		async: false,
		cache: false,
		success: function(data) {
			result = data.result;
			reason = data.reason;
		}
	});

	// 실패
	if(result == 0){
		alert(reason);
	}

	//성공
	if(result == 1) {
		html = '';
		html += '<li class="phone-success-email-box">'
		html += '<p class="btxt"></p>'
		html += '<div class="">'
		html += '<p class="phone-success-email rtxt mg10t cblue">이메일 인증이 완료되었습니다</p>'
		html += '</div>'
		html += '</li>'

		$('.con-mail1').remove(); // 인증 박스 삭제		
		$('.new-phone-box').append(html); // 승인 메세지
		$("#mem_phone").val(phone_num);
	}
});
/**
 * 휴대폰번호변경 끝
 */

/********************************************************/

/**
 * 비밀번호변경 시작
 */
// 비밀번호 == 비밀번호 확인 check
oldVal1 = '';
$("#new_password").on("propertychange change keyup paste input", function() {
	var currentVal = $(this).val();
	if(currentVal == oldVal1) {
		return;
	}
	
	password2 = $("#new_password_re").val();
	if(password2 != currentVal ){ // && currentVal.length > 0){
		$('.agree-password').remove();
		html = '<p class="agree-password cred" class="rtxt mg10t">비밀번호가 일치하지 않습니다.</p>';
		$('.new-password-re').append(html);
	} else{
		$('.agree-password').remove();
		html = '<p class="agree-password cblue" class="rtxt mg10t">비밀번호가 일치합니다.</p>';
		$('.new-password-re').append(html);
	}
	
	oldVal1 = currentVal;
});

oldVal2 = '';
$("#new_password_re").on("propertychange change keyup paste input", function() {
	var currentVal = $(this).val();
	if(currentVal == oldVal2) {
		return;
	}
	
	password1 = $("#new_password").val();
	if(password1 != currentVal ){ // && currentVal.length > 0){
		$('.agree-password').remove();
		html = '<p class="agree-password cred" class="rtxt mg10t">비밀번호가 일치하지 않습니다.</p>';
		$('.new-password-re').append(html);
	} else{
		$('.agree-password').remove();
		html = '<p class="agree-password cblue" class="rtxt mg10t">비밀번호가 일치합니다.</p>';
		$('.new-password-re').append(html);
	}
	
	oldVal2 = currentVal;
});


var password = '';
// 이메일 확인 + 인증번호 보내기
$(document).ready(function(){
	$("#send_email2").on('click', function(){
		$('.new-password-box > p').remove();

		var _password = $("#new_password").val();
		var _password_re = $("#new_password_re").val();
		password = _password;
		var state = '';
		var message = '';
		$.ajax({
			url: cb_url + '/membermodify/ajax_password_modify_email_send',
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
			}
		});

		if(state != -1){
			alert(message);
		} else {
			$('.new-password-box').append(message); // 승인 메세지
		}
		
		$('.password-success-email-box').remove();
		$('.con-mail2').remove();
		if(state == 1){
			html = '';
			html += '<li class="con-mail2">'
			html += '<p class="btxt">이메일 인증</p>'
			html += '<div class="field modify">'
			html += '<p class="chk-input w380">'
			html += '<input type="text" placeholder="" id="ath_num2" name="ath_num2" value="">'
			html += '</p>'
			html += '<a href="javascript:void(0);" id="con_password_mail_btn" class="modify-btn"><span>메일인증 확인</span></a>'
			html += '</div>'
			html += '</li>'
			$('.new-password-box').append(html);
		}
	})
})

// 이메일 인증 하기
$(document).on('click', "#con_password_mail_btn", function(){
	var ath_num = $("#ath_num2").val();

	var result = '';
	var reason = '';
	$.ajax({
		url: cb_url + '/membermodify/ajax_phone_modify_ath_mail',
		type: 'POST',
		data: {
			ath_num: ath_num,
			csrf_test_name : cb_csrf_hash
		},
		dataType: 'json',
		async: false,
		cache: false,
		success: function(data) {
			result = data.result;
			reason = data.reason;
		}
	});

	// 실패
	if(result == 0){
		alert(reason);
	}

	//성공
	if(result == 1) {
		html = '';
		html += '<li class="password-success-email-box">'
		html += '<p class="btxt"></p>'
		html += '<div class="password-success-message-box" id="password_success_message_box" style="display:inline-block;">'
		html += '<p class="password-success-email rtxt mg10t cblue">이메일 인증이 완료되었습니다</p>'
		html += '</div>'
		html += '<div class="nice-phone-ath-box" id="nice_phone_ath_box" style="display: inline-block; float: right;">'
		html += '<form name="form_chk" method="post">'
		html += '<input type="hidden" name="m" value="checkplusService">'
		html += '<input type="hidden" name="EncodeData" value="<?php echo html_escape(element('phone_enc_data', $view)); ?>">'
		html += '<a href="javascript:fnPopup();" id="nice_phone_ath" class="modify-btn"><span>휴대폰 인증</span></a>'
		html += '</form>'
		html += '</div>'
		html += '</li>'

		$('.con-mail2').remove(); // 인증 박스 삭제		
		$('.new-password-box').append(html); // 승인 메세지
		$("#mem_password").val(password);
	}
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
		// 체크여부 확인
		// if( $("input:checkbox[name=agree]").is(":checked") == true 
		// 		&& $("input:checkbox[name=agree2]").is(":checked") == true
		// 			&& $("input:checkbox[name=agree3]").is(":checked") == true ) {
			window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
			document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
			document.form_chk.target = "popupChk";
			document.form_chk.submit();
		// } else {
		// 	alert("이용약관을 확인해주세요")
		// }
	}
/**
 * 나이스 휴대폰 인증 끝
 */


</script>