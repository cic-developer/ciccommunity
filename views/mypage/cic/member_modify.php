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
				<!-- Modal head -->
				<div class="modal-head">
					<span class="close">&times;</span>                                                               
					<!-- <p>Some text in the Modal..</p> -->
				</div>
				<div class="modal-content">
					<label for="new_number">새 핸드폰번호</label>
					<input type="text" name="mem_phone" id="new_number" value="" />
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
.modal-head {
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

</script>