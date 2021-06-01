

<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/hotfix.css'); ?>

<div id="container-wrap">
	<div id="contents" class="div-cont">
	<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fwrite', 'id' => 'fwrite', 'onsubmit' => 'return submitContents(this)');
		echo form_open_multipart(current_full_url(), $attributes);
	?>
		<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('post', $view)); ?>" />
		<input type="hidden" class="input px150" name="post_nickname" id="post_nickname" value="<?php echo set_value('post_nickname', element('post_nickname', element('post', $view))); ?>" />
		<input type="hidden" class="input px400" name="post_email" id="post_email" value="<?php echo set_value('post_email', element('post_email', element('post', $view))); ?>" />
		<input type="hidden" class="input px400" name="post_homepage" id="post_homepage" value="<?php echo set_value('post_homepage', element('post_homepage', element('post', $view))); ?>" />
		<!-- page start // -->
		<div class="board-wrap write">
			<h3>도전 포럼 등록 <span>설명 텍스트 입니다.설명 텍스트 입니다.설명 텍스트 입니다.설명 텍스트 입니다.설명 텍스트 입니다.</span></h3>
			<div class="entry">
				<ul>
					<li>
						<p class="btxt">포럼 주제</p>
						<div class="field">
							<p class="chk-input w100p">
								<input id="post_title" type="text" name="post_title" placeholder="포럼 주제를 입력해주세요" value="<?php echo set_value('post_title', element('post_title', element('post', $view))); ?>">
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
				<!-- <a href="#n" class="enter-btn"><span>포럼 등록하기</span></a> -->
				<button type="submit" class="enter-btn"><span>등록하기</span></button>
			</div>
		</div>
		<?php echo form_close(); ?>
		<!-- page end // -->
	</div>
</div>
