<div class="list">
	<ul>
	<?php
	if (element('list', element('data', $view))) {
		foreach (element('list', element('data', $view)) as $result) {
	?>

		<li class="item" id="comment_<?php echo element('cmt_id', $result); ?>">
			<div class="vcon">
				<div class="info">
					<a href="#n" class="nickname">
						<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
								alt=""></p>
						<p class="txt"><?php echo element('cmt_nickname', $result); ?></p>
					</a>
					<div class="vp-point">
						<ul>
							<li>
								<p class="up" data-contenttype="comment" data-cmtidx="1">12</p>
							</li>
							<li>
								<p class="down" data-contenttype="comment" data-cmtidx="1">35</p>
							</li>
						</ul>

					</div>
					
				</div>
				<div class="vtxt">
					<?php echo element('content', $result); ?>
				</div>
				<div class="ctrls">
					<ul>
						<li>
							<p class="date">21. 03. 04 19:08</p>
						</li>
						<li><a href="#n" class="cmmt-btn"><span>답글</span></a></li>
						<li><a href="#n" class="singo-btn"><span>신고</span></a></li>
					</ul>
				</div>
				<div class="comment">
					<textarea
						placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."></textarea>
					<div class="btns">
						<a href="#n" class="write-btn"><span>답글등록</span></a>
					</div>
				</div>
			</div>
			<div class="reply cdepth1">
				<div class="info">
					<a href="#n" class="nickname">
						<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
								alt=""></p>
						<p class="txt">힘을내포포</p>
					</a>
					<div class="vp-point">
						<ul>
							<li>
								<p class="up" data-contenttype="comment" data-cmtidx="1">12</p>
							</li>
							<li>
								<p class="down" data-contenttype="comment" data-cmtidx="1">35</p>
							</li>
						</ul>
					</div>
				</div>
				<div class="vtxt">
					<p>머야 준다는건가용? 사랑합니당 </p>
				</div>
				<div class="ctrls">
					<ul>
						<li>
							<p class="date">21. 03. 04 19:08</p>
						</li>
						<li><a href="#n" class="cmmt-btn"><span>답글</span></a></li>
						<li><a href="#n" class="singo-btn"><span>신고</span></a></li>
					</ul>
				</div>
				<div class="comment">
					<textarea
						placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."></textarea>
					<div class="btns">
						<a href="#n" class="write-btn"><span>답글등록</span></a>
					</div>
				</div>
			</div>
			<div class="reply cdepth2">
				<div class="info">
					<a href="#n" class="nickname">
						<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
								alt=""></p>
						<p class="txt">힘을내포포</p>
					</a>
					<div class="vp-point">
						<ul>
							<li>
								<p class="up" data-contenttype="comment" data-cmtidx="1">12</p>
							</li>
							<li>
								<p class="down" data-contenttype="comment" data-cmtidx="1">35</p>
							</li>
						</ul>
					</div>
				</div>
				<div class="vtxt">
					<p>회원님께서는 이미 답글 컨텐츠의 긍정적인 영향을 미친 회원으로 선정되어 최초 1회에 한해 보상을 받으신것으로 확인됩니다.^^;;; </p>
				</div>
				<div class="ctrls">
					<ul>
						<li>
							<p class="date">21. 03. 04 19:08</p>
						</li>
						<li><a href="#n" class="cmmt-btn"><span>답글</span></a></li>
						<li><a href="#n" class="singo-btn"><span>신고</span></a></li>
					</ul>
				</div>
				<div class="comment">
					<textarea
						placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."></textarea>
					<div class="btns">
						<a href="#n" class="write-btn"><span>답글등록</span></a>
					</div>
				</div>
			</div>
		</li>
	<?php
		}
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
				<input type="radio" name="jselGroup" id="jsel01" checked=""><label
					for="jsel01">욕설/비방</label>
			</p>
			<p class="chk-radio">
				<input type="radio" name="jselGroup" id="jsel02"><label for="jsel02">홍보/상업성</label>
			</p>
			<p class="chk-radio">
				<input type="radio" name="jselGroup" id="jsel03"><label for="jsel03">기타</label>
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
<script>
	$(function () {
		var istotal = $('.cmmt').find('.item').length;
		var ischk = (istotal / 2) + 1
		$('.cmmt').find('.item:nth-child(n+' + ischk + ')').addClass('vfm');
		$('.ctrls').find('.cmmt-btn').click(function () {
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
		});
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
</script>
