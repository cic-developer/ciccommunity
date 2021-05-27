<div id="container-wrap">
	<div id="contents" class="div-cont">
	<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fwrite', 'id' => 'fwrite', 'onsubmit' => 'return submitContents(this)');
		echo form_open_multipart(current_full_url(), $attributes);
	?>
		<!-- page start // -->
		<div class="board-wrap write">
			<h3>도전 포럼 등록 <span>설명 텍스트 입니다.설명 텍스트 입니다.설명 텍스트 입니다.설명 텍스트 입니다.설명 텍스트 입니다.</span></h3>
			<div class="entry">
				<ul>
					<li>
						<p class="btxt">포럼 주제</p>
						<div class="field">
							<p class="chk-input w100p">
								<input type="text" placeholder="" value="도지코인 1,000원 갈까?">
							</p>
						</div>
					</li>
					<li class="no-pad">
						<div class="field report">
							<p class="btxt">A.의견</p>
							<p class="chk-input w100p">
								<input type="text" placeholder="" value="간다">
							</p>
						</div>
						<div class="field report mg20t">
							<p class="btxt">B.의견</p>
							<p class="chk-input w100p">
								<input type="text" placeholder="" value="안간다">
							</p>
						</div>
					</li>
					<li class="no-pad">
					<?php echo display_dhtml_editor('post_content', set_value('post_content', element('post_content', element('post', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = element('use_dhtml', element('board', $view)), $editor_type = $this->cbconfig->item('post_editor_type')); ?>
					</li>
				</ul>
			</div>
			<div class="lower">
				<a href="#n" class="enter-btn"><span>포럼 등록하기</span></a>
			</div>
		</div>
		<?php echo form_close(); ?>
		<!-- page end // -->
	</div>
</div>

<style>
	.chk-input label {
		font-size:14px;
		color:#f47523
	}
</style>