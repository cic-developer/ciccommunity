<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<div id="container-wrap">
	<div id="top-vis">
		<div class="txt">
			<h2>자유게시판</h2>
			<p>유저들이 자유롭게 소통하는 공간입니다</p>
		</div>
		<div class="img-freetalk"></div>
	</div>
	<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="board-wrap detail">

			<div class="detail">
				<div class="binfo">
					<h4><span>자유게시판</span> 입니다.</h4>
					<p>유저들의 의견을 자유롭게 공유할 수 있는 공간입니다. 단, 사이트 내에 명시 된 ‘운영정책’ 을 따릅니다. </p>
					<p>게시글에 대해서 up / down으로 의견을 표출할 수 있습니다. 작성자는 참여에 따라 지급 포인트를 받습니다.</p>
				</div>
				<div class="gap30"></div>
				<div class="upper r">
					<a href="<?php echo element('list_url', $view); ?>" class="bw-btn"><span>목록</span></a>
					<a href="<?php echo element('url', element('prev_post', $view)); ?>" class="bw-btn"><span>이전</span></a>
					<a href="<?php echo element('url', element('next_post', $view)); ?>" class="bw-btn"><span>다음</span></a>
				</div>
				<div class="tits vp">
					<!-- <p class="logo"><img src="<?php echo base_url('assets/images/record-logo.jpg') ?>" alt=""/></p> -->
					<h3><?php echo html_escape(element('post_title', element('post', $view))); ?></h3>
					<ul>
						<li>
							<div class="my-info">
								<p class="pimg"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', element('level', element('post', $view))), 20, 20); ?>"
										alt="<?php echo element('mlc_title', element('level', element('post', $view))); ?>">
								</p>
								<div class="tooltip popup_menuu" search_id="<?php echo element('mem_id', element('post', $view)); ?>">
									<p class="rtxt">
										<?php echo element('post_nickname', element('post', $view)); ?>
									</p>
									<span class="tooltiptext" >
										<?php if(number_format(element('mlc_level',element('level',element('post', $view))) > 30)){
											echo '관리자';
										}else{ ?>
											<b>레벨 <?php echo element('mlc_level',element('level',element('post', $view))) ?> 
											<?php echo html_escape(element('mlc_title',element('level',element('post', $view)))); ?></b>
										<?php	
										}
											?>
										<br><b><a href="javascript:void(0);" class="layer_link" style="padding:5px; color:#1e5fc9;"> 
										작성 글 보기
										</a></b>
									</span>
								</div>
							</div>
						</li>
						<li>등록일 : <?php echo element('display_datetime', element('post', $view)); ?> </li>
						<li>조회 : <?php echo number_format(element('post_hit', element('post', $view))); ?> </li>
					</ul>
					<div class="abr">
						<?php if((element('mlc_level',element('level',element('post', $view))) >= 30)){ ?>
							<p style="color:#444;">관리자</p>
						<?php }else{
								if(element('level',element('post', $view))) {
						?>
						<p <?php echo (element('mlc_level',element('level',element('post', $view))) >= 0) ? 'style="color:#444;"' : '' ?>>
							<?php echo element('mlc_level',element('level',element('post', $view))).' '.html_escape(element('mlc_title',element('level',element('post', $view)))); ?>
						</p>
						<?php 
								} 
							}
						?>

						<?php if(html_escape(element('post_notice', element('post', $view))) == 0){ ?>
						<div class="vp-point">
							<ul>
								<li><a href="javascript:void(0);" class="up" data-contenttype="post"><?php echo number_format(element('post_like_point', element('post', $view))); ?></a></li>
								<li><a href="javascript:void(0);" class="down" data-contenttype="post"><?php echo number_format(element('post_dislike_point', element('post', $view))); ?></a></li>
							</ul>
						</div>
						<?php } ?>

					</div>
				</div>
				<div class="cons">
					<!-- 본문 내용 시작 -->
					<div class="txt">
						<?php echo element('content', element('post', $view)); ?>
					</div>
					<!-- 본문 내용 끝 -->

					<?php if(html_escape(element('post_notice', element('post', $view))) == 0){ ?>
					<div class="vp-point">
						<ul>
							<li><a href="javascript:void(0);" class="up" data-contenttype="post"><?php echo number_format(element('post_like_point', element('post', $view))); ?></a></li>
							<li><a href="javascript:void(0);" class="down" data-contenttype="post"><?php echo number_format(element('post_dislike_point', element('post', $view))); ?></a></li>
						</ul>
					</div>
					<?php } ?>
				</div>
			</div>
			<div class="lower r">
				<?php if(element('modify_url', $view) && $this->member->is_admin()){ ?>
				<a href="<?php echo element('modify_url', $view); ?>" class="bw-btn"><span>수정</span></a>
				<?php } ?>
				<?php //if(element('delete_url', $view) && ($this->member->is_admin() || element('post_comment_count', element('post', $view)) < 5)){ ?>
				<?php if(element('delete_url', $view)){ ?>
				<a href="javascript:void(0);" class="bw-btn btn-one-delete" data-one-delete-url="<?php echo element('delete_url', $view); ?>"><span>삭제</span></a>
				<?php } ?>
				<?php if (( ! element('post_del', element('post', $view)) && element('use_blame', element('board', $view)) && ( ! element('blame_blind_count', element('board', $view)) OR element('post_blame', element('post', $view)) < element('blame_blind_count', element('board', $view)))) && ! element('post_notice', element('post', $view)) ) { ?>
					<button type="button" class="bw-btn btn btn-black" id="btn-blame" onClick="post_blame('<?php echo element('post_id', element('post', $view)); ?>', 'post-blame');">신고 <span class="post-blame"><?php echo element('post_blame', element('post', $view)) ? '+' . number_format(element('post_blame', element('post', $view))) : ''; ?></span></button>
				<?php } ?>
			
			</div>
			<div class="gap60"></div>
			
		</div>

		<div class="gap60"></div>
		<!-- s: cmmt -->
		<?php if(html_escape(element('post_notice', element('post', $view))) == 0){ ?>
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
		<?php } ?>
		<!-- e: cmmt -->
		<!-- page end // -->
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

		const title = 'VP를 '+ (like_type === 'up' ? 'UP' :'DOWN') + ' 합니다.\n'+`소유 VP는 ${mem_vp} 입니다.`;
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
					// alert('성공적으로 처리되었습니다.');

					location.href = location.href.split('?')[0] + '?page='+ $('#comment_page').val();
					
				}
			},
			error: function(){
				alert('에러가 발생했습니다.');
			}
		});
		return true;
	}
</script>
    <script>
    $(function(){
        /* 클릭 클릭시 클릭을 클릭한 위치 근처에 레이어가 나타난다. */
        $('.popup_menuu').click(function(e)
        {
            var sWidth = window.innerWidth;
            var sHeight = window.innerHeight;

            var oWidth = $('.popupLayer').width();
            var oHeight = $('.popupLayer').height();

            // 레이어가 나타날 위치를 셋팅한다.
            var divLeft = e.clientX + 10;
            var divTop = e.clientY + 5;

            // 레이어 위치를 바꾸었더니 상단기준점(0,0) 밖으로 벗어난다면 상단기준점(0,0)에 배치하자.
            if( divLeft < 0 ) divLeft = 0;
            if( divTop < 0 ) divTop = 0;
            
            $('.layer_link').prop('href', `<?php echo base_url('board/freetalk').'?sfield=mem_id&skeyword='?>${$(this).attr('search_id')}`);
            $('.popupLayer').css({
                "top": divTop,
                "left": divLeft,
                "display" : "block"
            }).show();
        });

				$('.popup_menuu').mouseover(function(e)
        {
					var sWidth = window.innerWidth;
            var sHeight = window.innerHeight;

            var oWidth = $('.popupLayer').width();
            var oHeight = $('.popupLayer').height();

            // 레이어가 나타날 위치를 셋팅한다.
            // var divLeft = e.clientX + 10;
            // var divTop = e.clientY + 5;
						var divLeft = e.clientX -5;
            var divTop = e.clientY -5;

            // 레이어 위치를 바꾸었더니 상단기준점(0,0) 밖으로 벗어난다면 상단기준점(0,0)에 배치하자.
            if( divLeft < 0 ) divLeft = 0;
            if( divTop < 0 ) divTop = 0;
            
            $('.layer_link').prop('href', `<?php echo base_url('board/freetalk').'?sfield=mem_id&skeyword='?>${$(this).attr('search_id')}`);
            $('.popupLayer').css({
                "top": divTop,
                "left": divLeft,
                "display" : "block"
            }).show();
        });
				$('.popupLayer').mouseleave(function(e)
        {
					$('.popupLayer').css('display','none');
        });
    });
    $(document).mouseup(function (e){
        var container = $('.popupLayer');
        if( container.has(e.target).length === 0){
        container.css('display','none');
        }
    });
    $(window).on("wheel", function (event){
        $('.popupLayer').css('display','none');
    });
    </script>

	<style>
		.tooltip .tooltiptext {
    visibility: hidden;
    width: 100px;
    background-color: rgb(255, 255, 255);
    border: solid 1px #fccb17;
    color: black;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;
    position: absolute;
    z-index: 9999;
    bottom: -230%;
    left: 80%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 0.3s;
    height: 40px;
    line-height: 20px;
	font-size: 15px;
}
	</style>