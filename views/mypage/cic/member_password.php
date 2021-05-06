<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>

<div id="container-wrap">
	<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="member-wrap modify">

			<?php
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
				<a href="#n" class="leave-btn"><span>뒤로가기</span></a>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>


<script type="text/javascript">
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
</script>
