<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>

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
				<a href="/membermodify/userdelete" class="leave-btn"><span>회원탈퇴</span></a>
			</div>

			<!-- 핸드폰번호 변경 -->
			<div id="myModal_phone" class="modal">
				<!-- Modal content -->
				<a href="javascript:void(0);" class="ath-email modify-btn modal-btn" data-type="phone"><span>이메일인증</span></a>
			</div>

			<!-- 비밀번호 변경 -->
			<div id="myModal_password" class="modal"> 
				<!-- Modal content -->
				<a href="javascript:void(0);" class="ath-email modify-btn modal-btn" data-type="password"><span>이메일인증</span></a>
			</div>

			<!-- 지갑주소 변경 -->
			<div id="myModal_wallet" class="modal"> 
				<!-- Modal content -->
				<a href="javascript:void(0);" class="ath-email modify-btn modal-btn" data-type="wallet"><span>이메일인증</span></a>
			</div>
			<?php echo form_close(); ?>
		</div>
	 	<!-- page end // -->
	</div>
</div>

<div id="test">test</div>

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

	#back{
		position: absolute;
		z-index: 100;
		background-color: #000000;
		display:none;
		left:0;
		top:0;
	}
	#loadingBar{
		position:absolute;
		left:50%;
		top: 40%;
		display:none;
		z-index:200;
	}


</style>

<script>
	/*
	** 로딩바 시작
	*/
	$('#test').on('click', function() {
		FunLoadingBarStart();
	})

	function FunLoadingBarStart() {
		var backHeight = $(document).height(); //뒷 배경의 상하 폭
		var backWidth = window.document.body.clientWidth; //뒷 배경의 좌우 폭
		var backGroundCover = "<div id='back'></div>"; //뒷 배경을 감쌀 커버
		var loadingBarImage = '/pngwing.com.png'; //가운데 띄워 줄 이미지
		loadingBarImage += "<div id='loadingBar'>";
		loadingBarImage += " <img src='../../../assets/images/Spinner-1s-200px.gif'/>"; //로딩 바 이미지
		loadingBarImage += "</div>";
		$('.entry').append(backGroundCover).append(loadingBarImage);
		$('#back').css({ 'width': backWidth, 'height': backHeight, 'opacity': '0.3' });
		$('#back').show();
		$('#loadingBar').show();
	}

	function FunLoadingBarEnd() {
		$('#back, #loadingBar').hide();
		$('#back, #loadingBar').remove();
	}

	//
	function LoadingWithMask() {
		//화면의 높이와 너비를 구합니다.
		var maskHeight = $(document).height();
		var maskWidth  = window.document.body.clientWidth;
		
		//화면에 출력할 마스크를 설정해줍니다.
		var mask       ="<div id='mask' style='position:absolute; z-index:9000; background-color:#000000; display:none; left:0; top:0;'></div>";
		var loadingImg ='';
		
		loadingImg +="<div id='loadingImg'>";
		loadingImg +=" <img src='../../../assets/images/Spinner-1s-200px.gif' style='position: relative; display: block; margin: 0px auto;'/>";
		loadingImg +="</div>"; 
		
		//화면에 레이어 추가
		$('body')
			.append(mask)
			.append(loadingImg)
			
		//마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채웁니다.
		$('#mask').css({
				'width' : maskWidth
				,'height': maskHeight
				,'opacity' :'0.3'
		});
		
		//마스크 표시
		$('#mask').show();  
		
		//로딩중 이미지 표시
		$('#loadingImg').show();
	}	

	function closeLoadingWithMask() {
		$('#mask, #loadingImg').hide();
		$('#mask, #loadingImg').remove();  
	}



	/*
	** 로딩바 끝
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
/*****************************************************************************/
/**
 * 이메일 인증 시작
 */

	// 이메일 확인 + 인증번호 보내기
	$(document).ready(function(){
		$(".ath-email").on('click', function(){
			var type = $(this).data('type');

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
					FunLoadingBarStart(); // 로딩바 생성
				}
			});
			
			alert(message);

			// 실패
			if(state == 0){}

			// 성공
			if(state == 1){
				FunLoadingBarEnd(); // 로딩바 제거

				if(type == 'phone'){
					$('#myModal_phone > .ath-email').remove(); // 이메일 인증 실행 버튼 삭제
				}
				if(type == 'password'){
					$('#myModal_password > .ath-email').remove(); // 이메일 인증 실행 버튼 삭제
				}
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

				if(type == 'phone'){
					$('#myModal_phone').append(html); // 이메일 인증박스 추가
				}
				if(type == 'password'){
					$('#myModal_password').append(html); // 이메일 인증박스 추가
				}
				if(type == 'wallet'){
					$('#myModal_wallet').append(html); // 이메일 인증박스 추가
				}
			}
		})
	})

	// 이메일 인증 하기
	$(document).on('click', "#ath_mail_btn", function(){
		var ath_num = $("#ath_num").val();
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
			}
		});

		alert(reason);

		// 실패
		if(result == 0){}

		//성공
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
	});

/**
 * 이메일 인증 끝
 */
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

	var phone = '';
	$(document).on('click', "#phone_modify_btn", function(){

		var _phone = $("#new_phone").val();
		phone = _phone;
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
			}
		});

		alert(message);

		if(state == 1){
			$("#mem_phone").val(phone);
			modal1.style.display = "none";
		}

	})
/**
 * 휴대폰번호변경 끝
 */
/********************************************************/
/**
 * 비밀번호변경 시작
 */
	// 비밀번호 == 비밀번호 확인 check
	oldVal1 = '';
	$(document).on("propertychange change keyup paste input","#new_password",function(){
		var currentVal = $(this).val();
		if(currentVal == oldVal1) {
			return;
		}
		
		password2 = $("#new_password_re").val();
		if(password2 != currentVal ){ // && currentVal.length > 0){
			$('.agree-password').remove();
			html = '<p class="agree-password cred" class="rtxt mg10t">비밀번호가 일치하지 않습니다.</p>';
			$('.password-re-modify-content').append(html);
		} else{
			$('.agree-password').remove();
			html = '<p class="agree-password cblue" class="rtxt mg10t">비밀번호가 일치합니다.</p>';
			$('.password-re-modify-content').append(html);
		}
		
		oldVal1 = currentVal;
	});

	oldVal2 = '';
	$(document).on("propertychange change keyup paste input","#new_password_re",function(){
		var currentVal = $(this).val();
		if(currentVal == oldVal2) {
			return;
		}
		
		password1 = $("#new_password").val();
		if(password1 != currentVal ){ // && currentVal.length > 0){
			$('.agree-password').remove();
			html = '<p class="agree-password cred" class="rtxt mg10t">비밀번호가 일치하지 않습니다.</p>';
			$('.password-re-modify-content').append(html);
		} else{
			$('.agree-password').remove();
			html = '<p class="agree-password cblue" class="rtxt mg10t">비밀번호가 일치합니다.</p>';
			$('.password-re-modify-content').append(html);
		}
		
		oldVal2 = currentVal;
	});

	function createPasswordModify(){
		var html = '';
		html += '<div class="modal-content entry">';
		html += '<ul class="password-modify-box">';
		html += '<li class="password-modify-content">';
		html += '<p class="btxt">새 비밀번호</p>';
		html += '<div class="field modify">';
		html += '<p class="chk-input w380">';
		html += '<input type="password" placeholder="" id="new_password" name="new_password" value="">';
		html += '</p>';
		html += '</div>';
		html += '</li>';
		html += '<li class="password-re-modify-content">';
		html += '<p class="btxt">새 비밀번호 확인</p>';
		html += '<div class="field modify">';
		html += '<p class="chk-input w380">';
		html += '<input type="password" placeholder="" id="new_password_re" name="new_password_re" value="">';
		html += '</p>';
		html += '<a href="javascript:void(0);" id="password_modify_btn" class="modify-btn"><span>확인</span></a>';
		html += '</div>';
		html += '</li>';
		html += '</ul>';
		html += '</div>';

		$('#password_form_chk').remove(); // 휴대폰 인증 박스 삭제		
		$('#myModal_password').append(html); 
	}

	var password = '';
	$(document).on('click', "#password_modify_btn", function(){
		$('.password-modify-box > p').remove();

		var _password = $("#new_password").val();
		var _password_re = $("#new_password_re").val();
		password = _password;
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
			}
		});

		if(state == 1){
			alert(message);
			$("#mem_password").val(password);
			modal2.style.display = "none";
		}
		if(state == 0){
			$('.password-modify-box').append(message);
		}
	});
/**
 * 비밀번호변경 끝
 */
/********************************************************/
/**
 * 지갑주소변경 시작
 */
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

		$('#wallet_form_chk').remove(); // 휴대폰 인증 박스 삭제		
		$('#myModal_wallet').append(html); 
	}

	var wallet = '';
	$(document).on('click', "#wallet_modify_btn", function(){
		$('.wallet-modify-box > p').remove();

		var _wallet = $("#new_wallet").val();
		wallet = _wallet;
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
			}
		});

		if(state == 1){
			alert(message);
			$("#mem_wallet").val(wallet);
			modal3.style.display = "none";
		}
		if(state == 0){
			// $('.wallet-modify-box').append(message);
			alert(message);
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
		window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
		document.form_chk.target = "popupChk";
		document.form_chk.submit();
	}
/**
 * 나이스 휴대폰 인증 끝
 */


</script>