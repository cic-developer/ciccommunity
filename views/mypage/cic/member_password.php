<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>

<div id="container-wrap">
	<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="member-wrap modify">

		<?php
			echo validation_errors('<script>alert("', '");</script>');
			echo show_alert_message($this->session->flashdata('message'), '<script>alert("', '");</script>');
			$attributes = array('class' => 'form-horizontal', 'name' => 'fconfirmpassword', 'id' => 'fconfirmpassword');
			echo form_open(current_url(), $attributes);
		?>
			<h3>회원 비밀번호 확인</h3>
			<div class="entry">
				<ul>
					<li>
						<p class="btxt">비밀번호 확인</p>
						<div class="field">
							<p class="chk-input w210">
								<input id="mem_password" name="mem_password" type="password" placeholder="비밀번호 입력" value="">
							</p>
						</div>
					</li>
				</ul>
			</div>
			<div class="lower">
				<button type="submit" class="update-btn go-btn"><span>확인</span></button>
				<button type="button" class="leave-btn"><span>뒤로가기</span></button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>


<script type="text/javascript">
	// $.validator.setDefaults({
	// 	onkeyup:false,
	// 	onclick:false,
	// 	onfocusout:false,
	// 	showErrors:function(errorMap, errorList){
	// 		if(this.numberOfInvalids()) {
	// 			alert(errorList[0].message);
	// 		}
	// 	}
	// });

	$.validator.setDefaults({

showErrors: function(map, list) {

		// there's probably a way to simplify this

		var focussed = document.activeElement;

		if (focussed && $(focussed).is("input, textarea")) {

			   $(this.currentForm).tooltip("close", {

					   currentTarget: focussed

			   }, true)

		}

		var className = "ui-state-highlight"; //error시 변경될 class

	   

		this.currentElements.removeAttr("title").removeClass(className);

		$.each(list, function(index, error) {

			   $(error.element).attr("title", error.message).addClass(className);

		});

		/* tooltip 자동 open

		if (focussed && $(focussed).is("input, textarea")) {

			   $(this.currentForm).tooltip("open", {

					   target: focussed

			   });

		}*/

},



	//<![CDATA[
	$(function () {
		$('#fconfirmpassword').validate({
			rules: {
				mem_password: {
					required: true,
					minlength: 4
				}
			}
		});
	});
	//]]>

	$(document).on('click', '.go-btn',function(){
		var password = $('#mem_password').val();
	

		// if((password.trim()).length < 4){
		// 	alert('비밀번호를 4자 이상 입력해주세요');
		// }
	})
</script>
