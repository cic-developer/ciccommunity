<div class="list">
	<ul>
	<?php
	$_is_depth = false;
	if (element('list', element('data', $view))) {
		foreach (element('list', element('data', $view)) as $result) {
			$_cmt_depth = element('cmt_depth', $result)/30;
			$_classname = $_cmt_depth > 0 ? 'reply cdepth'.$_cmt_depth : 'vcon';
	?>
		<?php
		if($_cmt_depth == 0){
		?>
		<li class="item" id="comment_<?php echo element('cmt_id', $result); ?>">
		<?php
		}
		?>
			<div class="<?php echo $_classname; ?>">
				<div class="info">
					<a href="#n" class="nickname">
						<p class="ico"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', element('level', $result)), 35, 35); ?>"
								alt=""></p>
						<p class="txt"><?php echo element('cmt_nickname', $result); ?></p>
					</a>
					<!-- <div class="vp-point">
						<ul>
							<li>
								<p class="up" data-contenttype="comment" data-cmtidx="<?php echo element('cmt_id', $result); ?>" style="cursor:pointer;"><?php echo element('cmt_like_point', $result); ?></p>
							</li>
							<li>
								<p class="down" data-contenttype="comment" data-cmtidx="<?php echo element('cmt_id', $result); ?>" style="cursor:pointer;"><?php echo element('cmt_dislike_point', $result); ?></p>
							</li>
						</ul>

					</div> -->
					
				</div>
				<div class="vtxt">
					<?php echo element('content', $result); ?>
				</div>
				<div class="ctrls">
					<ul>
						<li>
							<p class="date"><?php echo cdate('Y. m. d H:i' ,strtotime(element('cmt_datetime', $result))); ?></p>
						</li>
						
						<?php if (element('can_update', $result)) { ?>
						<li>
							<a href="javascript:;" class="modify-btn" onClick="comment_box('<?php echo element('cmt_id', $result); ?>', 'cu'); return false;">수정</a>
						</li>
						<?php } ?>
						<?php if (element('can_delete', $result)) { ?>
						<li>
							<a href="javascript:;" onClick="delete_comment('<?php echo element('cmt_id', $result); ?>', '<?php echo element('post_id', $result); ?>', '<?php echo element('page', $view); ?>');">삭제</a>
						</li>
						<?php } ?>
						<li><a href="javascript:;" class="cmmt-btn" onClick="comment_box('<?php echo element('cmt_id', $result); ?>', 'c'); return false;"><span>답글</span></a></li>
						<li><a href="#n" class="singo-btn"><span>신고</span></a></li>
					</ul>
				</div>

				<div class="comment" id="edit_<?php echo element('cmt_id', $result); ?>">
				</div>

				<div class="comment" id="reply_<?php echo element('cmt_id', $result); ?>">
				</div>

				<input type="hidden" value="<?php echo element('cmt_secret', $result); ?>" id="secret_comment_<?php echo element('cmt_id', $result); ?>" />
				
				<textarea id="save_comment_<?php echo element('cmt_id', $result); ?>" style="display:none"><?php echo html_escape(element('cmt_content', $result)); ?></textarea>
			</div>
	<?php
		}
	?>
	</li>
	<?php
	}
	?>
	</ul>
</div>
<!-- e: paging-wrap -->
<div class="paging-wrap">
	<?php echo element('paging', $view); ?>
</div>

<!-- e: paging-wrap -->
<!-- s: layer-wrap.singo -->
<div class="layer-wrap singo">
	<div class="is-top">
		<h2>신고하기</h2>
		<a href="#n" class="close singo-close"><span class="blind">닫기</span></a>
	</div>
	<div class="is-con">
		<div class="sel">
			<p class="chk-radio">
				<input type="radio" name="jselGroup" id="jsel01" checked /><label
					for="jsel01">욕설/비방</label>
			</p>
			<p class="chk-radio">
				<input type="radio" name="jselGroup" id="jsel02" /><label for="jsel02">홍보/상업성</label>
			</p>
			<p class="chk-radio">
				<input type="radio" name="jselGroup" id="jsel03" /><label for="jsel03">기타</label>
			</p>
		</div>
		<textarea placeholder="신고내용을 작성해주세요"></textarea>
	</div>
	<div class="is-btm">
		<a href="#n" class="enter-btn singo-close"><span>확인</span></a>
		<a href="#n" class="cancel-btn singo-close"><span>취소</span></a>
	</div>
</div>
<!-- s: layer-wrap.singo -->
<!-- s: layer-wrap userInfo -->
<div class="layer-wrap userInfo">
	<p>포럼 전적 <span>7승3패</span></p>
</div>
<!-- e: layer-wrap userInfo -->

<script>
	$(function () {
		// $('.info').find('.nickname').click(function () {
		// 	var isParent = $(this).closest('.info');
		// 	$(this).closest('.list').find('.item').removeClass('zdex')
		// 	$(this).closest('.item').addClass('zdex');
		// 	$('.layer-wrap.userInfo').bPopup({
		// 		closeClass: "userInfo-close",
		// 		speed: 0,
		// 		appendTo: isParent,
		// 		follow: [false, false],
		// 		position: [false, false],
		// 		onClose: function () {
		// 			$('.cmmt').find('.item').removeClass('zdex');
		// 		},
		// 		modalColor: 'transparent',
		// 		modal: true,
		// 	});
		// });
		// var istotal = $('.cmmt').find('.item').length;
		// var ischk = (istotal / 2) + 1
		// $('.cmmt').find('.item:nth-child(n+' + ischk + ')').addClass('vfm');

		// $('.ctrls').find('.cmmt-btn').click(function () {
		// 	$('.cmmt-wrap').find('.singo-btn').removeClass('active');
		// 	if ($(this).hasClass('active')) {
		// 		$(this).removeClass('active');
		// 		$(this).closest('.vcon').removeClass('active');
		// 		$(this).closest('.reply').removeClass('active');
		// 		$(this).closest('.ctrls').removeClass('active');
		// 	} else {
		// 		$(this).addClass('active');
		// 		$(this).closest('.vcon').addClass('active');
		// 		$(this).closest('.reply').addClass('active');
		// 		$(this).closest('.ctrls').addClass('active');
		// 	}
		// 	$('.layer-wrap.singo').bPopup({
		// 		speed: 0,
		// 		follow: [false, false],
		// 		position: [false, false],
		// 		modalColor: false,
		// 		modal: false,
		// 		onClose: function () {
		// 			$('.cmmt').find('.cread').removeClass('cread')
		// 		},
		// 	}).close();
		// });
		// $('.cmmt-wrap').find('.singo-btn').click(function () {
		// 	$('.cmmt-wrap').find('.singo-btn').removeClass('active');
		// 	$(this).addClass('active');
		// 	$('.layer-wrap.singo').bPopup({
		// 		speed: 0,
		// 		follow: [false, false],
		// 		position: [false, false],
		// 		modalColor: false,
		// 		modal: false,
		// 		onClose: function () {
		// 			$('.cmmt').find('.cread').removeClass('cread')
		// 		},
		// 	}).close();
		// 	var obj = $(this).position();
		// 	var abj = $(this).position();
		// 	var thispar = $(this).closest('.ctrls');
		// 	$(this).closest('.ctrls').parent().addClass('cread');
		// 	$(this).closest('.ctrls').parent().parent('li').addClass('cread');
		// 	$('.layer-wrap.singo').css({
		// 		'top': obj.top,
		// 		'left': obj.left,
		// 		'margin-top': '20px',
		// 		'margin-left': '0'
		// 	});
		// 	$('.layer-wrap.singo').bPopup({
		// 		closeClass: "singo-close",
		// 		speed: 0,
		// 		appendTo: $(thispar),
		// 		onClose: function () {
		// 			$('.cmmt').find('.cread').removeClass('cread')
		// 		},
		// 		follow: [false, false],
		// 		position: [false, false],
		// 		modalColor: false,
		// 		modal: false,
		// 	});
		// });
	})
</script>

<script>
	// $(function () {
	// 	$('.poll-wrap').find('.cont').find('a').click(function () {
	// 		if ($(this).closest('li').hasClass('active')) {
	// 			$(this).closest('li').find('a').removeClass('active');
	// 		} else {
	// 			$(this).closest('li').find('a').addClass('active');
	// 		}
	// 		$(this).closest('li').siblings('li').find('a').removeClass('active');
	// 	});

	// 	$('.poll-wrap').find('.cont').find('li').each(function () {
	// 		var isbar = $(this).find('.percent > span').text();
	// 		$(this).find('.vbar').delay(300).animate({
	// 			'height': isbar
	// 		}, 450);
	// 	});

	// 	$('.poll-wrap').find('.btns > .enter').click(function () {
	// 		if ($(this).closest('.poll-wrap').hasClass('active')) {
	// 			$(this).closest('.poll-wrap').removeClass('active');
	// 			$('.poll-wrap').find('.result').hide();
	// 		} else {
	// 			$(this).closest('.poll-wrap').addClass('active');
	// 			$('.poll-wrap').find('.result').show();
	// 		}

	// 	});
	// 	$('.cmmt-like').click(function () {
	// 		if ($(this).hasClass('active')) {
	// 			$(this).removeClass('active');
	// 		} else {
	// 			$(this).addClass('active');
	// 		}
	// 	})
	// })
</script>

<!-- <script>
	$(function () {
		var istotal = $('.cmmt').find('.item').length;
		var ischk = (istotal / 2) + 1
		$('.cmmt').find('.item:nth-child(n+' + ischk + ')').addClass('vfm');
		/*$('.ctrls').find('.cmmt-btn').click(function () {
			$('.cmmt-wrap').find('.singo-btn').removeClass('active');
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
				$(this).closest('.vcon').removeClass('active');
				$(this).closest('.reply').removeClass('active');
				$(this).closest('.ctrls').removeClass('active');
			} else {
				$(this).addClass('active');
				$(this).closest('.vcon').addClass('active');
				$(this).closest('.reply').addClass('active');
				$(this).closest('.ctrls').addClass('active');
			}
			$('.layer-wrap.singo').bPopup({
				speed: 0,
				follow: [false, false],
				position: [false, false],
				modalColor: false,
				modal: false,
				onClose: function () {
					$('.cmmt').find('.cread').removeClass('cread')
				},
			}).close();
		});*/
		$('.cmmt-wrap').find('.singo-btn').click(function () {
			$('.cmmt-wrap').find('.singo-btn').removeClass('active');
			$(this).addClass('active');
			$('.layer-wrap.singo').bPopup({
				speed: 0,
				follow: [false, false],
				position: [false, false],
				modalColor: false,
				modal: false,
				onClose: function () {
					$('.cmmt').find('.cread').removeClass('cread')
				},
			}).close();
			var obj = $(this).position();
			var abj = $(this).position();
			var thispar = $(this).closest('.ctrls');
			$(this).closest('.ctrls').parent().addClass('cread');
			$(this).closest('.ctrls').parent().parent('li').addClass('cread');
			$('.layer-wrap.singo').css({
				'top': obj.top,
				'left': obj.left,
				'margin-top': '20px',
				'margin-left': '0'
			});
			$('.layer-wrap.singo').bPopup({
				closeClass: "singo-close",
				speed: 0,
				appendTo: $(thispar),
				onClose: function () {
					$('.cmmt').find('.cread').removeClass('cread')
				},
				follow: [false, false],
				position: [false, false],
				modalColor: false,
				modal: false,
			});
		});
	})


	
</script> -->
