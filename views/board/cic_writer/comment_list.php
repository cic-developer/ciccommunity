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
					<a href="javascript:void(0);" class="nickname popup_menuu">
						<p class="ico"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', element('level', $result)), 35, 35); ?>"
								alt="" ></p>
						<p class="txt"><?php echo element('cmt_nickname', $result); ?></p>
					</a>
					<div class="vp-point">
						<ul>
							<li>
								<p class="up" data-contenttype="comment" data-cmtidx="<?php echo element('cmt_id', $result); ?>" style="cursor:pointer;"><?php echo element('cmt_like_point', $result); ?></p>
							</li>
							<li>
								<p class="down" data-contenttype="comment" data-cmtidx="<?php echo element('cmt_id', $result); ?>" style="cursor:pointer;"><?php echo element('cmt_dislike_point', $result); ?></p>
							</li>
						</ul>

					</div>
					
				</div>
				<div class="vtxt" comment-data="<?php echo element('cmt_id', $result); ?>">
					<?php echo element('content', $result); ?>
				</div>
				<div class="ctrls">
					<ul>
						<li>
							<p class="date"><?php echo cdate('Y. m. d H:i' ,strtotime(element('cmt_datetime', $result))); ?></p>
						</li>
						
						<?php if (element('can_update', $result)) { ?>
						<li>
							<a href="javascript:;" onClick="comment_box('<?php echo element('cmt_id', $result); ?>', 'cu'); return false;">수정</a>
						</li>
						<?php } ?>
						<?php if (element('can_delete', $result)) { ?>
						<li>
							<a href="javascript:;" onClick="delete_comment('<?php echo element('cmt_id', $result); ?>', '<?php echo element('post_id', $result); ?>', '<?php echo element('page', $view); ?>');">삭제</a>
						</li>
						<?php } ?>
						<li><a href="javascript:;" class="cmmt-btn" onClick="comment_box('<?php echo element('cmt_id', $result); ?>', 'c'); return false;"><span>답글</span></a></li>
						<?php if (element('use_comment_blame', element('board', $view)) && ( ! element('comment_blame_blind_count', element('board', $view)) OR element('cmt_blame', $result) < element('comment_blame_blind_count', element('board', $view)))) { ?>
							<li><a href="javascript:;" id="cmt-btn-blame" onClick="comment_blame('<?php echo element('cmt_id', $result); ?>', 'comment-blame-<?php echo element('cmt_id', $result); ?>');" title="신고하기"><i class="fa fa-bell fa-xs"></i>신고 <span class="comment-blame-<?php echo element('cmt_id', $result); ?>"><?php echo element('cmt_blame', $result) ? '+' . number_format(element('cmt_blame', $result)) : ''; ?></span></a></li>
						<?php } ?>
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
		<a href="javascript:void(0);" class="close singo-close"><span class="blind">닫기</span></a>
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
		<a href="javascript:void(0);" class="enter-btn singo-close"><span>확인</span></a>
		<a href="javascript:void(0);" class="cancel-btn singo-close"><span>취소</span></a>
	</div>
</div>
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
            
            // $('.layer_link').prop('href', 'https://dev.ciccommunity.com/board/freetalk?sfield=post_nickname&skeyword='+ $(this).text() +'&search_submit=');
            $('.layer_link').prop('href', `<?php echo base_url('board/cicwriter').'?sfield=post_nickname&skeyword='?>${$(this).text()}`);
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

<!-- s: layer-wrap.singo -->
<script>

	$('.more').on('click', function(){
		let parent = $(this).parent('.vtxt');
		let _index = parent.attr('comment-data');
		$.ajax({
			url: "<?php echo base_url('Comment_list/ajax_allCommentData')?>",
			type: "POST",
			dataType: "json",
			data: {
				csrf_test_name: cb_csrf_hash,
				index: _index
			},
			success: function(data){
				parent.children().remove();
				parent.text('');
				try{
					parent.append(data);
				}catch(error){
					parent.text(data);
				}
				
			},
			error: function (request, status, error){
				console.log(request, status, error)
			}
		});
	})

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
</script>
