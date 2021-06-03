<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<!-- s : #container-wrap //-->
<div id="container-wrap">
	<!-- <div id="top-vis" class="bg01">
	<h2>Notice</h2>
	<div class="img"><img src="<?php echo base_url('assets/images/top-vis01.jpg')?>" alt=""/></div>
</div> -->
	<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="board-wrap detail">
			<div class="detail">
				<div class="binfo">
					<h4><span>포럼</span> 입니다.</h4>
					<p>디지털 자산 관련 어떤 이슈가 주목 받을 때 혹은 커뮤니티 운영과 관련해 의사결정을 하는 투표를 진행 할 수 있습니다.</p>
					<p>보유 포인트를 이용해 투표에 참여 가능하고 투표 결과에 따라 <span class="cblack b">순차적</span>으로 보상 포인트를 지급 받습니다.</p>
				</div>
				<div class="gap30"></div>
				<div class="upper r">
					<a href="<?php echo element('list_url', $view); ?>" class="bw-btn"><span>목록</span></a>
					<a href="<?php echo element('url', element('prev_post', $view)); ?>" class="bw-btn"><span>이전</span></a>
					<a href="<?php echo element('url', element('next_post', $view)); ?>" class="bw-btn"><span>다음</span></a>
				</div>
				<div class="tits poll">
					<h3><?php echo html_escape(element('post_title', element('post', $view))); ?></h3>
					<ul>
						<li>
							<div class="my-info">
								<p class="pimg"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', element('level', element('post', $view))), 20, 20); ?>"
										alt="<?php echo element('mlc_title', element('level', element('post', $view))); ?>">
								</p>
								<p class="rtxt"><?php echo element('post_nickname', element('post', $view)); ?></p>
							</div>
						</li>
						<li>등록일 : <?php echo element('display_datetime', element('post', $view)); ?> </li>
						<li>조회 : <?php echo number_format(element('post_hit', element('post', $view))); ?> </li>
					</ul>
					<div class="poll-abr">
						<ul>
							<li>
								<p class="btxt">참여마감</p>
								<p class="stxt cred"><?php echo display_datetime(element('frm_bat_close_datetime', $forum), 'full'); ?></p>
							</li>
							<li>
								<p class="btxt">포럼마감</p>
								<p class="stxt"><?php echo display_datetime(element('frm_close_datetime', $forum), 'full'); ?></p>
							</li>
							<li class="full">
								<p class="btxt">포인트</p>
								<p class="stxt"><?php echo number_format(element('cic_forum_total_cp', $forum), 2); ?></p>
							</li>
						</ul>
					</div>
				</div>
				<div class="cons no-bd">
					<div class="txt">
						<?php echo element('content', element('post', $view)); ?>
					</div>
				</div>
			</div>
			<!-- <div class="lower r">
		<a href="#n" class="bb-btn"><span>목록</span></a>
		<a href="#n" class="bw-btn"><span>이전</span></a>
		<a href="#n" class="bw-btn"><span>다음</span></a>
	</div> -->
		</div>
		<div class="gap50"></div>
		<div class="poll-wrap">
			<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
			<script src="<?php echo base_url('assets/js/jquery/jquery.countup.js')?>"></script>
			<script>
				$(function () {
					$('.counter').countUp();
				});
			</script>
			<div class="cont">
				<h3><?php echo html_escape(element('post_title', element('post', $view))); ?></h3>
				<ul>
					<li>
						<div class="bar">
							<div class="vbar"></div>
							<p class="percent"><span><?php echo number_format(element('A_per', $forum)); ?>%</span></p>
							<p class="nums"><i class="counter"><?php echo number_format(element('cic_A_cp', $forum), 2); ?></i><span>cp</span></p>
							<p class="popo"><img src="<?php echo base_url('assets/images/forum_popo1.png')?>" alt="" style="cursor:pointer;" /></p>
							<a href="#n"><span>A. 간다</span></a>
							
						</div>
					</li>
					
					<li>
						<div class="bar">
							<div class="vbar"></div>
							<p class="percent"><span><?php echo number_format(element('B_per', $forum)); ?>%</span></p>
							<p class="nums"><i class="counter"><?php echo number_format(element('cic_B_cp', $forum), 2); ?></i><span>cp</span></p>
							<p class="popo"><img src="<?php echo base_url('assets/images/forum_popo2.png')?>" alt="" style="cursor:pointer;" /></p>
							<a href="#n"><span>B. 안간다</span></a>
						</div>
					</li>
				</ul>
			</div>
			<div class="result" style="display:none">
				<p class="btxt">A. 간다 <span>참여</span></p>
				<div class="abr">
					<p class="cp"><span>150</span> CP</p>
					<a href="#n"><span>추가 참여!</span></a>
					<a href="#n"><span>의견 변경</span></a>
				</div>
			</div>
			<div class="btns">
				<a href="#n" class="enter"><span>투표 참여하기</span></a>
			</div>
		</div>
		<div class="gap50"></div>
		<div class="gap50"></div>
		<!-- s: cmmt -->
		<div class="cmmt-upper">
			<!-- <a href="#n" class="cmmt-like">좋아요 <span><?php echo number_format(element('post_like', element('post', $view))); ?></span></a> -->

			<?php if ( ! element('post_del', element('post', $view)) && (element('use_post_like', element('board', $view)) OR element('use_post_dislike', element('board', $view)))) { ?>
				<div class="recommand vp-point">
					<?php if (element('use_post_like', element('board', $view))) { ?>
						<div class="btns">
							<a class="cmmt-like" href="javascript:;" id="btn-post-like" onClick="post_like('<?php echo element('post_id', element('post', $view)); ?>', '1', 'post-like');" title="추천하기">좋아요<span class="post-like"></span><br /><i class="fa fa-thumbs-o-up fa-lg"></i></a>
						</div>
					<?php } ?>
				</div>
			<?php } ?>

			<!-- <a href="#n" class="cmmt-singo">신고</a> -->
			<?php if ( ! element('post_del', element('post', $view)) && element('use_blame', element('board', $view)) && ( ! element('blame_blind_count', element('board', $view)) OR element('post_blame', element('post', $view)) < element('blame_blind_count', element('board', $view)))) { ?>
				<button type="button" class="bw-btn btn btn-black cmmt-singo" id="btn-blame" onClick="post_blame('<?php echo element('post_id', element('post', $view)); ?>', 'post-blame');">신고 <span class="post-blame"><?php echo element('post_blame', element('post', $view)) ? '+' . number_format(element('post_blame', element('post', $view))) : ''; ?></span></button>
			<?php } ?>
		</div>
		<div class="cmmt-wrap">
			<div class="comment">
				<h4>댓글 <span><?php echo number_format(element('post_comment_count', element('post', $view))); ?></span></h4>
				<?php
					$this->load->view(element('view_skin_path', $layout) . '/comment_write');
				?>
			</div>
			<div class="cmmt" id="viewcomment">
			</div>
		</div>
	</div>
</div>
<!-- e: #container-wrap //-->

<script>

	var istotal = $('.cmmt').find('.item').length;
	var ischk = (istotal / 2) + 1
	$('.cmmt').find('.item:nth-child(n+' + ischk + ')').addClass('vfm');

	$(document).on('click','.nickname', function(){
		var isParent = $(this).closest('.info');
		$(this).closest('.list').find('.item').removeClass('zdex')
		$(this).closest('.item').addClass('zdex');
		$('.layer-wrap.userInfo').bPopup({
			closeClass: "userInfo-close",
			speed: 0,
			appendTo: isParent,
			follow: [false, false],
			position: [false, false],
			onClose: function () {
				$('.cmmt').find('.item').removeClass('zdex');
			},
			modalColor: 'transparent',
			modal: true,
		});
	})

	$(document).on('click','.cmmt-modify-btn', function(){
		$('.cmmt-wrap').find('.singo-btn').removeClass('active');
			if ($(this).hasClass('active')) {
				$('.cmmt-btn').removeClass('active');
				$(this).removeClass('active');
				$(this).closest('.vcon').removeClass('active');
				$(this).closest('.reply1').removeClass('active');
				$(this).closest('.ctrls1').removeClass('active');
			} else {
				$('.cmmt-btn').removeClass('active');
				$(this).addClass('active');
				$(this).closest('.vcon').addClass('active');
				$(this).closest('.reply1').addClass('active');
				$(this).closest('.ctrls1').addClass('active');
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
	})

	$(document).on('click','.cmmt-btn', function(){
		$('.cmmt-wrap').find('.singo-btn').removeClass('active');
			if ($(this).hasClass('active')) {
				$('.cmmt-modify-btn').removeClass('active');
				$(this).removeClass('active');
				$(this).closest('.vcon').removeClass('active');
				$(this).closest('.reply2').removeClass('active');
				$(this).closest('.ctrls2').removeClass('active');
			} else {
				$('.cmmt-modify-btn').removeClass('active');
				$(this).addClass('active');
				$(this).closest('.vcon').addClass('active');
				$(this).closest('.reply2').addClass('active');
				$(this).closest('.ctrls2').addClass('active');
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
	})

	$(document).on('click','.singo-btn', function(){
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
	})
	
    // ▲▲▲▲▲원본▲▲▲▲▲
	// $(function () {
	// 	$('.info').find('.nickname').click(function () {
	// 		var isParent = $(this).closest('.info');
	// 		$(this).closest('.list').find('.item').removeClass('zdex')
	// 		$(this).closest('.item').addClass('zdex');
	// 		$('.layer-wrap.userInfo').bPopup({
	// 			closeClass: "userInfo-close",
	// 			speed: 0,
	// 			appendTo: isParent,
	// 			follow: [false, false],
	// 			position: [false, false],
	// 			onClose: function () {
	// 				$('.cmmt').find('.item').removeClass('zdex');
	// 			},
	// 			modalColor: 'transparent',
	// 			modal: true,
	// 		});
	// 	});
	// 	var istotal = $('.cmmt').find('.item').length;
	// 	var ischk = (istotal / 2) + 1
	// 	$('.cmmt').find('.item:nth-child(n+' + ischk + ')').addClass('vfm');
	// 	$('.ctrls').find('.cmmt-btn').click(function () {
	// 		$('.cmmt-wrap').find('.singo-btn').removeClass('active');
	// 		if ($(this).hasClass('active')) {
	// 			$(this).removeClass('active');
	// 			$(this).closest('.vcon').removeClass('active');
	// 			$(this).closest('.reply').removeClass('active');
	// 			$(this).closest('.ctrls').removeClass('active');
	// 		} else {
	// 			$(this).addClass('active');
	// 			$(this).closest('.vcon').addClass('active');
	// 			$(this).closest('.reply').addClass('active');
	// 			$(this).closest('.ctrls').addClass('active');
	// 		}
	// 		$('.layer-wrap.singo').bPopup({
	// 			speed: 0,
	// 			follow: [false, false],
	// 			position: [false, false],
	// 			modalColor: false,
	// 			modal: false,
	// 			onClose: function () {
	// 				$('.cmmt').find('.cread').removeClass('cread')
	// 			},
	// 		}).close();
	// 	});
	// 	$('.cmmt-wrap').find('.singo-btn').click(function () {
	// 		$('.cmmt-wrap').find('.singo-btn').removeClass('active');
	// 		$(this).addClass('active');
	// 		$('.layer-wrap.singo').bPopup({
	// 			speed: 0,
	// 			follow: [false, false],
	// 			position: [false, false],
	// 			modalColor: false,
	// 			modal: false,
	// 			onClose: function () {
	// 				$('.cmmt').find('.cread').removeClass('cread')
	// 			},
	// 		}).close();
	// 		var obj = $(this).position();
	// 		var abj = $(this).position();
	// 		var thispar = $(this).closest('.ctrls');
	// 		$(this).closest('.ctrls').parent().addClass('cread');
	// 		$(this).closest('.ctrls').parent().parent('li').addClass('cread');
	// 		$('.layer-wrap.singo').css({
	// 			'top': obj.top,
	// 			'left': obj.left,
	// 			'margin-top': '20px',
	// 			'margin-left': '0'
	// 		});
	// 		$('.layer-wrap.singo').bPopup({
	// 			closeClass: "singo-close",
	// 			speed: 0,
	// 			appendTo: $(thispar),
	// 			onClose: function () {
	// 				$('.cmmt').find('.cread').removeClass('cread')
	// 			},
	// 			follow: [false, false],
	// 			position: [false, false],
	// 			modalColor: false,
	// 			modal: false,
	// 		});
	// 	});
	// })
</script>

<script>
	$(function () {
		$('.poll-wrap').find('.cont').find('a').click(function () {
			if ($(this).closest('li').hasClass('active')) {
				$(this).closest('li').find('a').removeClass('active');
			} else {
				$(this).closest('li').find('a').addClass('active');
			}
			$(this).closest('li').siblings('li').find('a').removeClass('active');
		});

		$('.poll-wrap').find('.cont').find('li').each(function () {
			var isbar = $(this).find('.percent > span').text();
			$(this).find('.vbar').delay(300).animate({
				'height': isbar
			}, 450);
		});

		$('.poll-wrap').find('.btns > .enter').click(function () {
			if ($(this).closest('.poll-wrap').hasClass('active')) {
				$(this).closest('.poll-wrap').removeClass('active');
				$('.poll-wrap').find('.result').hide();
			} else {
				$(this).closest('.poll-wrap').addClass('active');
				$('.poll-wrap').find('.result').show();
			}

		});
		$('.cmmt-like').click(function () {
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
			} else {
				$(this).addClass('active');
			}
		})
	})
</script>

<!-- 

<script>
	var reg_num = /^[0-9]*$/;
	var post_id = "<?php echo element('post_id', element('post', $view)); ?>"

	$(document).on('click', '.up', function(){
		const content_type = $(this).attr('data-contenttype');
		const content_idx = content_type === 'post' ? post_id : $(this).attr('data-cmtidx');
		update_vp(content_idx, content_type, 'up');
	});
	
	$(document).on('click', '.down', function(){
		const content_type = $(this).attr('data-contenttype');
		const content_idx = content_type === 'post' ? post_id : $(this).attr('data-cmtidx');
		update_vp(content_idx, content_type, 'down');
	});

	function update_vp(content_idx, content_type, like_type){
		if(!is_member){
			alert('로그인이 필요한 서비스입니다.');
			return false;
		}
		const allowed_content_type = ['post', 'comment'];
		const allowed_like_type = ['up', 'down'];

		if(allowed_content_type.indexOf(content_type) == -1){
			alert('비정상적인 시도입니다.1');
			return false;
		}
		
		if(!reg_num.test(content_idx)){
			alert('비정상적인 시도입니다.2');
			return false;
		}

		if(allowed_like_type.indexOf(like_type) == -1){
			alert('비정상적인 시도입니다.3');
			return false;
		}

		const title = 'VP를 '+ (like_type === 'up' ? 'UP' :'DOWN') + ' 합니다.';
		const _point = prompt(title, 0);

		//취소버튼 누를시
		if(_point === null){
			return false;
		}

		//숫자를 잘 입력했나 검증
		if(!reg_num.test(_point)){
			alert('숫자만 입력할 수 있습니다.');
			return false;
		}
		$.ajax({
			url: cb_url + '/postact/'+content_type+'_like/'+content_idx+'/'+(like_type === 'up' ? '1' :'2'),
			type: 'get',
			data: {
				usePoint: Number(_point),
			},
			dataType: 'json',
			async: false,
			cache: false,
			success: function(data) {
				if(data.error !== undefined){
					alert(data.error);
				} else {
					alert('성공적으로 처리되었습니다.');
					location.reload();
				}
			},
			error: function(){
				alert('에러가 발생했습니다.');
			}
		});
		return true;
	}
</script> -->