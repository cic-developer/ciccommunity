<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<!-- s : #container-wrap //-->
<div id="container-wrap">
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
								<a class="popup_menuu2" search_id="<?php echo element('mem_id', element('post', $view)); ?>"><p class="rtxt"><?php echo element('post_nickname', element('post', $view)); ?></p></a>
							</div>
						</li>
						<li>등록일 : <?php echo element('display_datetime', element('post', $view)); ?> </li>
						<li>조회 : <?php echo number_format(element('post_hit', element('post', $view))); ?> </li>
						<li>좋아요 : <?php echo number_format(element('post_like', element('post', $view))); ?> </li>
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
								<p class="stxt"><?php echo rs_number_format(element('cic_forum_total_cp', $forum), 2, 0); ?></p>
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

				<?php
				if (element('extra_content', $view)) {
					foreach (element('extra_content', $view) as $key => $value) {
						if(element('field_name', $value) == 'A_opinion') {
				?>
					<li>
						<div class="bar">
							<div class="vbar"></div>
							<p class="percent"><span><?php echo element('A_per', $forum) ? number_format(element('A_per', $forum)) : '0' ?>%</span></p>
							<p class="nums"><i class="counter"><?php echo rs_number_format(element('cic_A_cp', $forum), 2, 0); ?></i><span>cp</span></p>
							<p class="popo"><img src="<?php echo base_url('assets/images/forum_popo1.png')?>" alt="" style="cursor:pointer;" /></p>
							<div class="tx">
							<a href="javascript:void(0);" id="btn_a"><p class="OpinionB">A. <?php echo nl2br(html_escape(element('output', $value))); ?></p>
							<button class="btnvote">A 투표!</button>
								</a>
							</div>
						</div>
					</li>
				<?php
					} else if(element('field_name', $value) == 'B_opinion'){
				?>
					<li>
						<div class="bar">
							<div class="vbar"></div>
							<p class="percent"><span><?php echo element('B_per', $forum) ? number_format(element('B_per', $forum)) : '0' ?>%</span></p>
							<p class="nums"><i class="counter"><?php echo rs_number_format(element('cic_B_cp', $forum), 2, 0); ?></i><span>cp</span></p>
							<p class="popo"><img src="<?php echo base_url('assets/images/forum_popo2.png')?>" alt="" style="cursor:pointer;" /></p>
							<div class="tx">
							<a href="javascript:void(0);" id="btn_b"><p class="OpinionB">B.  <?php echo nl2br(html_escape(element('output', $value))); ?></p>
							<button class="btnvote">B 투표!</button>
								</a>
							</div>
						</div>
					</li>
				<?php
						}
					}
				}
				?>
				
				</ul>
			</div>
			<?php if(element('is_bat', $forum) == 1 || element('is_bat', $forum) == 2){ ?>
				<div class="result" >
					<?php if(element('is_bat', $forum) == 1){ ?>
						<p class="btxt">A. <?php echo element('extra_content', $view)[0]['output'] ?> <span>참여</span></p>
					<?php }else if(element('is_bat', $forum) == 2) { ?>
						<p class="btxt">A. <?php echo element('extra_content', $view)[1]['output'] ?> <span>참여</span></p>
					<?php }else { ?>
						<p class="btxt"><span>미참여</span></p>
					<?php } ?>
					<div class="abr">
						<p class="cp"><span><?php echo rs_number_format(element('bat_cp', $forum), 2, 0); ?></span> CP</p>
						<a href="javascript:void(0);" id="more_btn"><span>추가 참여!</span></a>
						<a href="javascript:void(0);" id="change_btn"><span>의견 변경</span></a>
					</div>
				</div>
			<?php } ?>
			<?php //if(element('is_bat', $forum) == 1 || element('is_bat', $forum) == 2){ ?>
				<!-- <div class="btns">
					<a href="javascript:void(0);" class="enter"><span>투표 참여하기</span></a>
				</div> -->
			<?php //}?>
		</div>
		<div class="gap50"></div>
		<div class="gap50"></div>
		<!-- s: cmmt -->
		<div class="cmmt-upper">
			<?php if ( ! element('post_del', element('post', $view)) && (element('use_post_like', element('board', $view)) OR element('use_post_dislike', element('board', $view)))) { ?>
				<div class="recommand vp-point">
					<?php if (element('use_post_like', element('board', $view))) { ?>
						<div class="btns">
							<a class="cmmt-like" href="javascript:;" id="btn-post-like" onClick="post_like_forum('<?php echo element('post_id', element('post', $view)); ?>', '1', 'post-like');" title="추천하기">좋아요<span class="post-like"></span><br /><i class="fa fa-thumbs-o-up fa-lg"></i></a>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
			<div style="position:absolute; right:0; top:-30%;">
			

			<?php if(element('is_admin', $forum) == 1){
					if(element('modify_url', $view) && element('type', $forum) == 1){ 
			?>
				<a href="<?php echo element('modify_url', $view); ?>" class="bw-btn"><span>수정</span></a>
			<?php 
					} 
				}
			?>

			<?php if ( ! element('post_del', element('post', $view)) && element('use_blame', element('board', $view)) && ( ! element('blame_blind_count', element('board', $view)) OR element('post_blame', element('post', $view)) < element('blame_blind_count', element('board', $view)))) { ?>
				<button style="position:relative; " type="button" class="bw-btn btn btn-black cmmt-singo" id="btn-blame" onClick="post_blame('<?php echo element('post_id', element('post', $view)); ?>', 'post-blame');">신고 <span class="post-blame"><?php echo element('post_blame', element('post', $view)) ? '+' . number_format(element('post_blame', element('post', $view))) : ''; ?></span></button>
			<?php } ?>
			</div>
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
	var regex = /^[0-9]+(\.[0-9]+)?$/g; // 실수 검사
	var reg_num = /^[0-9]*$/; // 정수 검사
	var post_id = "<?php echo element('post_id', element('post', $view)); ?>"
	var is_bat = "<?php echo element('is_bat', $forum); ?>" // 유저 배팅 진영 1, 2
	var cfc_state = "<?php echo element('cfc_state', $forum); ?>" // 유저 배팅 진영 1, 2
	var forum_bat_max = "<?php echo element('forum_bat_max', $forum); ?>" // 최대 배팅 금액
	var forum_bat_min = "<?php echo element('forum_bat_min', $forum); ?>" // 최소 배팅 금액

	// 의견 변경
	$(document).on('click', '#change_btn', function(){
		change_forum_bat(post_id, is_bat);
	})

	// 포포클릭
	$(document).on('click', '.popo', function(){
		$(this).parent().find('#btn_a, #btn_b').trigger('click');
	})

	// 추가참여!
	$(document).on('click', '#more_btn', function(){
		update_forum_cp(post_id, is_bat);
	})

	// 의견A
	$(document).on('click', '#btn_a', function(){
		var option = 1;
        
		insert_forum_cp(post_id, option);
	})

	// 의견B
	$(document).on('click', '#btn_b', function(){
		var option = 2;
		
		insert_forum_cp(post_id, option);
	})

	// 의견 변경 function
	function change_forum_bat(post_id, option){
		const allowed_option = ['1', '2'];

		if(!reg_num.test(post_id)){
			alert('비정상적인 시도입니다.');
			return false;
		}

		if(allowed_option.indexOf(option) == -1){
			alert('투표 후 이용해주세요');
			return false;
		}
		
		const num = cfc_state == 1 ? 0 : 1;
		// const confirm_content = ' ' + (option === '1' ? 'A' :'B') + '의견을 ' + (option === '2' ? 'A' :'B') + '의견으로 변경 하시겠습니까? (기회 ' + num + '회 남음)';
		const confirm_content = '의견을 변경하시겠습니까? (변경은 1회만 가능합니다.)\n'+`소유 CP : ${mem_cp}`;
		var isConfirm = confirm(confirm_content);
		
		if(isConfirm){
			if(cfc_state == 1) {
				alert('의견 변경횟수를 초과하였습니다');
				return false;
			}
		}

		if(isConfirm){
			$.ajax({
				url: cb_url + '/postact/change_bat',
				type: 'POST',
				data: {
					post_id: post_id,
					option: option,
					csrf_test_name : cb_csrf_hash
				},
				dataType: 'json',
				async: false,
				cache: false,
				success: function(data){
					if(data.state == 1){
						alert(data.message);
						location.reload();
					}
					if(data.state == 0){
						alert(data.message);
						location.reload();
					}
				},
				error: function(){
					alert('에러가 발생했습니다!');
				}
			})
		}
	}

	// 추가참여 function
	function update_forum_cp(post_id, option){
		const allowed_option = ['1', '2'];
		
		if(!is_member){
			alert('로그인이 필요한 서비스입니다.');
			return false;
		}
        
		if(!reg_num.test(post_id)){
			alert('비정상적인 시도입니다.2');
			return false;
		}

		if(allowed_option.indexOf(option) == -1){
			alert('투표 후 이용해주세요');
			return false;
		}
        
		// 추가 참여 가능 여부 확인
		$.ajax({
			url: cb_url + '/postact/more_bat_confirm',
			type: 'POST',
			data: {
				post_id: post_id,
				option: option,
				csrf_test_name : cb_csrf_hash
			},
			dataType: 'json',
			async: false,
			cache: false,
			success: function(data) {
				if(data.state == 1){

					var title = 'CP를 '+ (option === '1' ? 'A' :'B') + '의견에 투표합니다.\n'+`소유 CP: ${mem_cp} 투표 가능 CP : `;
					var max = '';
					var min = '';
					// if(priceToString(forum_bat_max) != 0){
					// 	// max = '(최대 배팅금액: ' + priceToString(forum_bat_max) + ')';
					// 	max = '(최대 행사금액: ' + priceToString(forum_bat_max) + ')';
					// }
					if(priceToString(forum_bat_min) != 0){
						// min = '(최소 배팅금액: ' + priceToString(forum_bat_min) + ')';
						min = priceToString(forum_bat_min) + ' ~ ';
					}else{
						min = ' 0 ~ ';
					}
					if(priceToString(forum_bat_max) != 0){
						// max = '(최대 배팅금액: ' + priceToString(forum_bat_max) + ')';
						max = priceToString(forum_bat_max);
					}else{
						max = '0';
					}
					// title = title + max + min;
					title = title + min + max;
					const _point = prompt(title, 0);
					
					//취소버튼 누를시
					if(_point === null){
						return false;
					}
					
					//숫자를 잘 입력했나 검증
					if(!regex.test(_point)){
						alert('숫자만 입력할 수 있습니다.');
						return false;
					}

					// 추가참여!
					$.ajax({
						url: cb_url + '/postact/more_bat_cp',
						type: 'POST',
						data: {
							usePoint: _point,
							post_id: post_id,
							option: option,
							csrf_test_name : cb_csrf_hash
						},
						dataType: 'json',
						async: false,
						cache: false,
						success: function(data) {
							if(data.state == 1){
								alert(data.message);
								location.reload();
							}
							if(data.state == 0){
								alert(data.message);
								location.reload();
							}
						},
						error: function(){
							alert('에러가 발생했습니다.');
						}
					});
				}
				if(data.state == 0){
					alert(data.message);
					location.reload();
				}
			},
			error: function(){
				alert('에러가 발생했습니다.');
			}
		});
		return true;
	}

	// 투표(배팅, 참여) function
	function insert_forum_cp(post_id, option){
        
		const allowed_option = [1, 2];
		
		if(!is_member){
			alert('로그인이 필요한 서비스입니다.');
			return false;
		}
        
		if(!reg_num.test(post_id)){
			alert('비정상적인 시도입니다.2');
			return false;
		}
        
		if(allowed_option.indexOf(option) == -1){
			alert('비정상적인 시도입니다.3');
			return false;
		}
        
		var title = 'CP를 '+ (option === 1 ? 'A' :'B') + '의견에 투표합니다.\n'+`소유 CP: ${mem_cp} 투표 가능 CP : `;
		var max = '';
		var min = '';
		// if(priceToString(forum_bat_max) != 0){
		// 	// max = '(최대 배팅금액: ' + priceToString(forum_bat_max) + ')';
		// 	max = '(최대 행사금액: ' + priceToString(forum_bat_max) + ')';
		// }
		if(priceToString(forum_bat_min) != 0){
			// min = '(최소 배팅금액: ' + priceToString(forum_bat_min) + ')';
			min = priceToString(forum_bat_min) + ' ~ ';
		}else{
			min = 0 + ' ~ ';
		}
		if(priceToString(forum_bat_max) != 0){
			// max = '(최대 배팅금액: ' + priceToString(forum_bat_max) + ')';
			max = priceToString(forum_bat_max) + '';
		}else{
			max = 0 + '';
		}
		// title = title + max + min;
		title = title + min + max;
		const _point = prompt(title, 0);
        
		//취소버튼 누를시
		if(_point === null){
			return false;
		}
        
		//숫자를 잘 입력했나 검증
		if(!regex.test(_point)){
			alert('숫자만 입력할 수 있습니다.');
			return false;
		}
		$.ajax({
			url: cb_url + '/postact/bat_forum',
			type: 'POST',
			data: {
				usePoint: _point,
				post_id: post_id,
				option: option,
				csrf_test_name : cb_csrf_hash
			},
			dataType: 'json',
			async: false,
			cache: false,
			success: function(data) {
				if(data.state == 1){
					alert(data.message);
					location.reload();
				}
				if(data.state == 0){
					alert(data.message);
					location.reload();
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

	var istotal = $('.cmmt').find('.item').length;
	var ischk = (istotal / 2) + 1
	$('.cmmt').find('.item:nth-child(n+' + ischk + ')').addClass('vfm');

	// 전적 확인
	$(document).on('click','.nickname', function(){
		var id = $(this).data('id');

		var isParent = $(this).closest('.info');
		$(this).closest('.list').find('.item').removeClass('zdex')
		$(this).closest('.item').addClass('zdex');
		$('.layer-wrap.userInfo-'+id).bPopup({
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

	// 신고 하기
	// $(document).on('click','.singo-btn', function(){
	// 	$('.cmmt-wrap').find('.singo-btn').removeClass('active');
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

		// $('.poll-wrap').find('.btns > .enter').click(function () {
		// 	if ($(this).closest('.poll-wrap').hasClass('active')) {
		// 		$(this).closest('.poll-wrap').removeClass('active');
		// 		$('.poll-wrap').find('.result').hide();
		// 	} else {
		// 		$(this).closest('.poll-wrap').addClass('active');
		// 		$('.poll-wrap').find('.result').show();
		// 	}
		// });
		$('.cmmt-like').click(function () {
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
			} else {
				$(this).addClass('active');
			}
		})
	})
</script>

<script>
	function post_like_forum(post_id, like_type, classname) {
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

	function priceToString(price) {
		return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
	}
</script>
<div class="popupLayer2" style="display:none; z-index:1200;">
    <a href="" class="layer_link2"> 작성 글 보기</a>
</div>
<script>
    $(function(){
        /* 클릭 클릭시 클릭을 클릭한 위치 근처에 레이어가 나타난다. */
        $('.popup_menuu2').click(function(e)
        {
            var sWidth = window.innerWidth;
            var sHeight = window.innerHeight;

            var oWidth = $('.popupLayer2').width();
            var oHeight = $('.popupLayer2').height();

            // 레이어가 나타날 위치를 셋팅한다.
            var divLeft = e.clientX + 10;
            var divTop = e.clientY + 5;

            // 레이어 위치를 바꾸었더니 상단기준점(0,0) 밖으로 벗어난다면 상단기준점(0,0)에 배치하자.
            if( divLeft < 0 ) divLeft = 0;
            if( divTop < 0 ) divTop = 0;
            
            $('.layer_link2').prop('href', `<?php echo base_url('board/forum').'/?type='.$this->input->get('type').'&sfield=mem_id&skeyword='?>${$(this).attr('search_id')}`);
						//(element('type', $view) == 1 ? '?type=1' : '?type=2')
            $('.popupLayer2').css({
                "top": divTop,
                "left": divLeft,
                "display" : "block"
            }).show();
        });
    });
    $(document).mouseup(function (e){
        var container = $('.popupLayer2');
        if( container.has(e.target).length === 0){
        container.css('display','none');
        }
    });
    $(window).on("wheel", function (event){
        $('.popupLayer2').css('display','none');
    });
    </script>