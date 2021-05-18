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
								<input type="text" placeholder=""
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
								<input type="password" placeholder="" value="**************" readonly="">
							</p>
							<a href="#n" class="modify-btn"><span>비밀번호변경</span></a>
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

			<!-- The Modal - phone -->
			<div id="myModal_phone" class="modal">
				<!-- Modal content -->
				<div class="modal-content entry">
					<span class="close"></span>
					<!-- &times; -->
					<ul>
						<li>
							<p class="btxt">새 핸드폰번호</p>
							<div class="field modify">
								<p class="chk-input w380">
									<input type="text" onKeyup="inputPhoneNumber(this);" placeholder="" id="new_phone" name="new_phone" value="">
								</p>
								<a href="javascript:void(0);" id="ath_email" class="modify-btn"><span>이메일인증</span></a>
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
var modal = document.getElementById('myModal_phone');

// Get the button that opens the modal
var btn = document.getElementById("modal_btn_phone");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];                                          

// When the user clicks on the button, open the modal 
btn.onclick = function() {
	modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
	modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}
/*****************************************************************************/

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


// 이메일 확인 + 인증번호 보내기
$(document).ready(function(){
	$("#ath_email").on('click', function(){

		LoadingWithMask();
		var _phone = $("#new_phone").val();

		var state = '';
		var message = '';
		$.ajax({
			url: cb_url + '/membermodify/ajax_email_send',
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

		// 	$('.success-email').remove();
		// 	$('.con-mail').remove();
		// 	if(state == 1){
		// 		html = '';
		// 		html += '<div class="field con-mail">'
		// 		html += '<p class="chk-input">'
		// 		html += '<input type="text" id="ath_num" name="ath_num" class="" required />'
		// 		html += '<p class="rtxt mg10t">'
		// 		html += '<a class="con-mail-btn cerfity-btn" id="con-mail-btn">메일인증 확인</a>'
		// 		html += '</p>'
		// 		html += '</p>'
		// 		html += '</div>'
		// 		$('.mem_email').append(html);
		// 	}
		// }
	})
})


/********************************************************/
function test(imageName) {
    LoadingWithMask('your site\'s image path');
    setTimeout("closeLoadingWithMask()", 3000);
}


function LoadingWithMask() {
    //화면의 높이와 너비를 구합니다.
    var maskHeight = $(document).height();
    var maskWidth  = window.document.body.clientWidth;

    //화면에 출력할 마스크를 설정해줍니다.
    var mask       ="<div id='mask' style='position:absolute; z-index:9000; background-color:#000000; display:none; left:0; top:0;'></div>";
    var loadingImg ='';
	
    loadingImg +="<div id='loadingImg'>";
    // loadingImg +=" <img src='pngwing.com.png' style='position: relative; display: block; margin: 0px auto;'/>";
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

</script>