<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<div id="container-wrap">
	<div id="top-vis">
		<div class="txt">
			<h2>Writer</h2>
			<p>등록된 회원들이 양질의 정보전달 글, 본인의 칼럼을 게시하는 공간 입니다.</p>
		</div>
		<div class="img"><img src="<?php echo base_url('assets/images/top-vis03.jpg') ?>" alt=""></div>
	</div>
	<div id="contents" class="div-cont">
		<div class="board-wrap detail">
			<div class="detail">
				<div class="binfo">
					<h4><span>Writer</span> 입니다.</h4>
					<p>유저들의 의견을 자유롭게 공유할 수 있는 공간입니다. 단, 사이트 내에 명시 된 ‘운영정책’ 을 따릅니다. </p>
					<p>게시글에 대해서 up / down으로 의견을 표출할 수 있습니다. 작성자는 참여에 따라 지급 포인트를 받습니다.</p>
				</div>
				<div class="gap30"></div>
				<div class="upper r"><a href="<?php echo element('list_url', $view); ?>" class="bw-btn"><span>목록</span></a>
					<a href="<?php echo element('url', element('prev_post', $view)); ?>" class="bw-btn"><span>이전</span></a>
					<a href="<?php echo element('url', element('next_post', $view)); ?>" class="bw-btn"><span>다음</span></a>
				</div>
				<div class="tits vp">
					<!-- <p class="logo"><img src="../_Img/Content/record-logo.jpg" alt=""/></p> -->
					<h3><?php echo html_escape(element('post_title', element('post', $view))); ?> </h3>
					<ul>
						<li>
							<div class="my-info">
								<p class="pimg"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', element('level', element('post', $view))), 20, 20);?>" alt="<?php echo element('mlc_title', element('level', element('post', $view))); ?>">
								</p>
								<p class="rtxt"><?php echo html_escape(element('post_nickname', element('post', $view))); ?></p>
							</div>
						</li>
						<li>등록일 : <?php echo element('display_datetime', element('post', $view)); ?> </li>
						<li>조회 : <?php echo number_format(element('post_hit', element('post', $view))); ?> </li>
					</ul>
					<div class="abr">
						<?php 
						if(element('level',element('post', $view))) {
						?>
						<p <?php echo (element('mlc_level',element('level',element('post', $view))) >= 0) ? 'style="color:#444;"' : '' ?>>
							<?php echo element('mlc_level',element('level',element('post', $view))).' '.html_escape(element('mlc_title',element('level',element('post', $view)))); ?>
						</p>
						<?php 
						} 
						?>
						<div class="vp-point">
							<ul>
								<li><a href="javascript:void(0);" class="up" data-contenttype="post"><?php echo number_format(element('post_like_point', element('post', $view))); ?></a></li>
								<li><a href="javascript:void(0);" class="down" data-contenttype="post"><?php echo number_format(element('post_dislike_point', element('post', $view))); ?></a></li>
							</ul>
						</div>
						
					</div>
				</div>
				<div class="cons">
					<!-- 본문 내용 시작 -->
					<div class="txt">
						<?php echo element('content', element('post', $view)); ?>
					</div>
					<!-- 본문 내용 끝 -->
					<div class="vp-point">
						<ul>
							<li><a href="javascript:void(0);" class="up" data-contenttype="post"><?php echo number_format(element('post_like_point', element('post', $view))); ?></a></li>
							<li><a href="javascript:void(0);" class="down" data-contenttype="post"><?php echo number_format(element('post_dislike_point', element('post', $view))); ?></a></li>
						</ul>
					</div>
				</div>
				<div class="lower r">
					<?php if(element('modify_url', $view)){ ?>
					<a href="<?php echo element('modify_url', $view); ?>" class="bw-btn"><span>수정</span></a>
					<?php } ?>
					<?php if(element('delete_url', $view)){ ?>
					<a href="javascript:void(0);" class="bw-btn btn-one-delete" data-one-delete-url="<?php echo element('delete_url', $view); ?>"><span>삭제</span></a>
					<?php } ?>
					<!-- <?php if(element('delete_url', $view)){ ?>
					<a href="javascript:void(0);" class="bw-btn btn-one-delete" data-one-delete-url="<?php echo element('delete_url', $view); ?>"><span>신고</span></a>
					<?php } ?> -->
					<?php if ( ! element('post_del', element('post', $view)) && element('use_blame', element('board', $view)) && ( ! element('blame_blind_count', element('board', $view)) OR element('post_blame', element('post', $view)) < element('blame_blind_count', element('board', $view)))) { ?>
						<button type="button" class="bw-btn btn btn-black" id="btn-blame" onClick="post_blame('<?php echo element('post_id', element('post', $view)); ?>', 'post-blame');">신고 <span class="post-blame"><?php echo element('post_blame', element('post', $view)) ? '+' . number_format(element('post_blame', element('post', $view))) : ''; ?></span></button>
					<?php } ?>
				</div>
			</div>
			<div class="gap60"></div>
			<div class="best">
				<div class="fl">
					<h4>BEST VP UP</h4>
					<ul>						
						<?php
						if (element('list',element('like_point_ranking', $view))) {
							foreach (element('list',element('like_point_ranking', $view)) as $like_point_ranking) {
								?>
								<li>
									<a href="javascript:void(0);" style="cursor:text;">
										<span class="num"><?php echo number_format(element('num', $like_point_ranking)); ?></span>
										<div class="my-info">
											<p class="pimg"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', $like_point_ranking), 30, 30)?>" alt=""></p>
											<p class="rtxt"><?php echo html_escape(element('cmt_nickname', $like_point_ranking)); ?></p>
										</div>
										<span class="txt"><?php echo html_escape(element('cmt_content', $like_point_ranking)); ?></span>
										<span class="vp"><?php echo number_format(element('cmt_like_point', $like_point_ranking)); ?></span>
									</a>
								</li>
						<?php
							}
						} else {
						?>
							<li>
								<span class="nopost">댓글이 없습니다</span>
							</li>
						<?php
						}
						?>
					</ul>
				</div>
				<div class="fr">
					<h4>BEST VP DOWN</h4>
					<ul>
						<?php
						if (element('list',element('dislike_point_ranking', $view))) {
							foreach (element('list',element('dislike_point_ranking', $view)) as $dislike_point_ranking) {
								?>
								<li>
									<a href="javascript:void(0);" style="cursor:text;">
										<span class="num"><?php echo number_format(element('num', $dislike_point_ranking)); ?></span>
										<div class="my-info">
											<p class="pimg"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', $dislike_point_ranking), 30, 30)?>" alt=""></p>
											<p class="rtxt"><?php echo html_escape(element('cmt_nickname', $dislike_point_ranking)); ?></p>
										</div>
										<span class="txt"><?php echo html_escape(element('cmt_content', $dislike_point_ranking)); ?></span>
										<span class="vp"><?php echo number_format(element('cmt_dislike_point', $dislike_point_ranking)); ?></span>
									</a>
								</li>
						<?php
							}
						} else {
						?>
							<li>
								<span class="nopost">댓글이 없습니다</span>
							</li>
						<?php
						}
						?>
					</ul>
				</div>
			</div>
		</div>


		<div class="gap60"></div>
		<!-- s: cmmt -->
		<div class="cmmt-wrap">
			<div class="comment">
				<h4>댓글 <span><?php echo number_format(element('post_comment_count', element('post', $view))); ?></span></h4>
				<?php
					$this->load->view(element('view_skin_path', $layout) . '/comment_write');
				?>
			</div>
			<div class="cmmt" id="viewcomment">
			</div>
			<!-- e: cmmt -->
			<!-- page end // -->
		</div>
	</div>
</div>

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
			error: function(err){
				alert('에러가 발생했습니다.');
			}
		});
		return true;
	}
</script>