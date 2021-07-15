<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<div id="container-wrap">
	<div id="top-vis">
		<div class="txt">
			<h2>도전 포럼</h2>
			<p>등록된 회원들이 양질의 정보전달 글, 본인의 칼럼을 게시하는 공간 입니다.</p>
		</div>
		<div class="img-forum"></div>
	</div>
	<div id="contents" class="div-cont">
		<div class="board-wrap detail">
			<div class="detail">
				<div class="binfo">
					<h4><span>도전 포럼</span> 입니다.</h4>
					<p>유저들의 의견을 자유롭게 공유할 수 있는 공간입니다. 단, 사이트 내에 명시 된 ‘운영정책’ 을 따릅니다. </p>
					<p>게시글에 대해서 좋아요를 이용하여 의견을 표출할 수 있습니다. </p>
					<p>도전포럼은 포럼으로 승격하기 전까지는 댓글기능을 사용할수 없습니다. </p>
					<p>많은 추천을 받은 게시물은 포럼으로 승격할수 있습니다. </p>
				</div>
				<div class="gap30"></div>
				<div class="upper r">
					<a href="<?php echo element('list_url', $view); ?>" class="bw-btn"><span>목록</span></a>
					<a href="<?php echo element('url', element('prev_post', $view)); ?>" class="bw-btn"><span>이전</span></a>
					<a href="<?php echo element('url', element('next_post', $view)); ?>" class="bw-btn"><span>다음</span></a>
				</div>
				<div class="tits vp">
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
							<span class="cyellow">좋아요: <?php echo number_format(element('post_like', element('post', $view))); ?></span>
						</div>
					</div>
				</div>

				<div class="cons">
					<!-- 본문 내용 시작 -->
					<div class="txt">
						<?php echo element('content', element('post', $view)); ?>
					</div>
					<!-- 본문 내용 끝 -->

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
							<?php
							if (element('extra_content', $view)) {
								foreach (element('extra_content', $view) as $key => $value) {
									if(element('field_name', $value) == 'A_opinion') {
							?>
								<li>
									<div class="bar">
										<div class="vbar"></div>
										<p class="percent"><span>??</span></p>
										<p class="nums"><i class="counter">0</i><span></span></p>
										<p class="popo"><img src="<?php echo base_url('assets/images/forum_popo1.png')?>" alt="" style="cursor:pointer;" /></p>
										<a><span>A. <?php echo nl2br(html_escape(element('output', $value))); ?></span></a>
									</div>
								</li>
							<?php
								} else if(element('field_name', $value) == 'B_opinion'){
							?>
								<li>
									<div class="bar">
										<div class="vbar"></div>
										<p class="percent"><span>??</span></p>
										<p class="nums"><i class="counter">0</i><span></span></p>
										<p class="popo"><img src="<?php echo base_url('assets/images/forum_popo2.png')?>" alt="" style="cursor:pointer;" /></p>
										<a><span>B. <?php echo nl2br(html_escape(element('output', $value))); ?></span></a>
									</div>
								</li>
							<?php
									}
								}
							}
							?>
							</ul>
						</div>

						<?php if ( ! element('post_del', element('post', $view)) && (element('use_post_like', element('board', $view)) OR element('use_post_dislike', element('board', $view)))) { ?>
						<div class="recommand vp-point">
							<?php if (element('use_post_like', element('board', $view))) { ?>
								<div class="btns">
									<a class="good enter" style="display:flex; justify-content: center; align-items: center;" href="javascript:;" id="btn-post-like" onClick="post_like_userforum('<?php echo element('post_id', element('post', $view)); ?>', '1', 'post-like')" title="추천하기"><span class="post-like">좋아요 up</span><br /><i class="fa fa-thumbs-o-up fa-lg" style="padding-left:12px;"></i></a>
								</div>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
					<div class="gap50"></div>

				</div>
			</div>
			<?php if(element('is_admin', $view)) {?>
			<div class="lower r">
				<?php if(element('delete_url', $view)){ ?>
				<?php } ?>
				<?php if ( ! element('post_del', element('post', $view)) && element('use_blame', element('board', $view)) && ( ! element('blame_blind_count', element('board', $view)) OR element('post_blame', element('post', $view)) < element('blame_blind_count', element('board', $view)))) { ?>
					<button type="button" class="bw-btn btn btn-black" id="btn-blame" onClick="post_blame('<?php echo element('post_id', element('post', $view)); ?>', 'post-blame');">신고 <span class="post-blame"><?php echo element('post_blame', element('post', $view)) ? '+' . number_format(element('post_blame', element('post', $view))) : ''; ?></span></button>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
	</div>
</div>

<script>
	function post_like_userforum(post_id, like_type, classname) {
        var href;

        if (post_id == "") {
            return false;
        }

        href = cb_url + "/postact/post_like/" + post_id + "/" + like_type;

        $.ajax({
            url: href,
            type: "get",
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                } else if (data.success) {
                    //alert(data.success);
                    // $("." + classname).text(number_format(String(data.count)));
                    // $("#btn-" + classname).effect("highlight", { color: "#f37f60" }, 300);
					alert(data.success);
					location.reload(true);
                }
            },
        });
    }
</script>

<div class="popupLayer" style="display:none; z-index:1200">
	<a href="" class="layer_link"> 작성 글 보기</a>
</div>
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
            
            $('.layer_link').prop('href', `<?php echo base_url('board/userforum').'?sfield=post_nickname&skeyword='?>${$(this).text()}`);
            $('.popupLayer').css({
                "top": divTop,
                "left": divLeft,
                "display" : "block"
            }).show();
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