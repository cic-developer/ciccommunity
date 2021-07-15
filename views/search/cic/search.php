<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"
/>
<div id="container-wrap">
		<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="search-wrap list">
			<div class="filter">
				<div class="sel-box c01">
                    <!-- PAGE 검색 기능 START -->
					<a href="javascript:void(0);" id="optionb" class="sel-btn"><span><?php echo element('type_word', $view); ?></span></a>
					<ul>
						<li class="<?php echo element('is_all', $view) ? 'active' : ''; ?>"><a href="javascript:void(0);" class="li_type" data-value=""><span>통합검색</span></a></li>
						<li class="<?php echo element('is_free', $view) ? 'active' : ''; ?>"><a href="javascript:void(0);" class="li_type" data-value="free"><span>자유게시판</span></a></li>
						<li class="<?php echo element('is_writer', $view) ? 'active' : ''; ?>"><a href="javascript:void(0);" class="li_type" data-value="writer"><span>WRITER</span></a></li>
						<li class="<?php echo element('is_news', $view) ? 'active' : ''; ?>"><a href="javascript:void(0);" class="li_type" data-value="news"><span>뉴스</span></a></li>
						<li class="<?php echo element('is_forum', $view) ? 'active' : ''; ?>"><a href="javascript:void(0);" class="li_type" data-value="forum"><span>포럼</span></a></li>
					</ul>		
				</div>
				<div class="field search">
                    <?php 
						$attributes = array('class' => 'search_box', 'name' => 'searchForm', 'id' => 'searchForm', 'method'=> 'get', 'action' => base_url('/search'));
						echo form_open(current_full_url(), $attributes);
					?>
					<input type="hidden" name="type" value="<?php echo $this->input->get('type'); ?>" />
					<input type="hidden" name="sfield" value="<?php echo $this->input->get('sfield'); ?>" />
					<input type="hidden" name="findex" value="<?php echo $this->input->get('findex'); ?>" />
					<p class="chk-input"><input type="text" placeholder="검색어를 입력해주세요" autocomplete="off" name="skeyword"
						value="<?php echo $this->input->get('skeyword');?>"></p>
					<button class="enter"><span class="blind">검색</span></button>
                    <?php echo form_close(); ?>
				</div>
				<div class="abr">
					<div class="sel-box c02">
						<a href="javascript:void(0);" id="optionb" class="sel-btn"><span><?php echo element('sfield_word', $view); ?></span></a>
						<ul>
							<li class="<?php echo !in_array(element('sfield', $view), array('post_title','post_content','post_nickname')) ? 'active' : ''; ?>"><a href="javascript:void(0);" class="li_sfield" data-value="post_both"><span>전체</span></a></li>
							<li class="<?php echo element('sfield', $view) == 'post_title' ? 'active' : ''; ?>"><a href="javascript:void(0);" class="li_sfield" data-value="post_title"><span>제목</span></a></li>
							<li class="<?php echo element('sfield', $view) == 'post_content' ? 'active' : ''; ?>"><a href="javascript:void(0);" class="li_sfield" data-value="post_content"><span>내용</span></a></li>
							<!-- <li class="<?php //echo element('sfield', $view) == 'post_nickname' ? 'active' : ''; ?>"><a href="javascript:void(0);" class="li_sfield" data-value="post_nickname"><span>작성자</span></a></li> -->
						</ul>
					</div>
					<div class="sel-box c03">
						<a href="javascript:void(0);" class="sel-btn"><span><?php echo element('findex_word', $view); ?></span></a>
						<ul>
							<li class="<?php echo !in_array(element('findex', $view), array('view')) ? 'active' : ''; ?>"><a href="javascript:void(0);" class="li_findex" data-value="latest"><span>최신 순</span></a></li>
							<li class="<?php echo element('findex', $view) == 'view' ? 'active' : ''; ?>"><a href="javascript:void(0);" class="li_findex" data-value="view"><span>조회 순</span></a></li>
						</ul>
					</div>
				</div>
				
			</div>
			<div class="result">
				<p class="btxt"><span><?php echo element('highlight_keyword', $view);?></span> 에 대한 <?php echo element('type_word', $view); ?> 결과 총</p>
				<p class="stxt"><?php echo number_format($total_rows); ?>건</p>
			</div>
			<!-- PAGE 검색 기능 끝 -->
			<!-- HERE THE MARKET PRICE VALUES -->
			<?php if($trade && element('is_all', $view)){ ?>
				<div class="result" style="overflow:hidden; padding-bottom:40px; padding-left:40px; padding-right:40px;">
					<!-- TradingView CANVAS BEGIN -->
					<div class="text-center">
						<canvas id="canvas" width="400" height="200"></canvas>
					</div>	
						<!-- TradingView CANVAS END -->
						<div class="right_content_all">
							<div style="text-align:left; border-bottom:5px solid #ddd; padding-bottom:5px;">
								<?php if($symbole == "PER"){ ?>
									<img src="https://upload-hotbit-co-kr.oss-ap-southeast-1.aliyuncs.com/NEW_PER_LOGO.png" alt="퍼토큰 로고" style="width:30px; height:auto; padding-right:10px;" />
								<?php }else {?>
									<img style= "width: 30px; padding-right:10px;" src="https://static.upbit.com/logos/<?php echo $symbole; ?>.png"></img>
								<?php } ?>
								<strong class="btxt"><?php echo $korean; ?></strong>
								<p class="stxt" style="display:none;">
									<span> <?php echo $symbole; ?></span>
									<u class="btc" >
										<small class="doller">1.0000BTC $30,971</small>
									</u>
								</p>	
							</div>
							<p class="stxt">
								<?php if($symbole === "PER"){?>
									<?php if($trade < $prev){ ?>
										<h6 style="color: #228be6;" class="price_now"> ￦<?php echo rs_get_price($trade, 'krw'); ?></h6>
									<?php }elseif($trade > $prev) {?>
										<h6 class="price_now" style="color: #fa5252"> ￦<?php echo rs_get_price($trade, 'krw'); ?></h6>
									<?php } else{ ?>
										<h6 class="price_now"> ￦<?php echo rs_get_price($trade, 'krw'); ?></h6>
									<?php }?>
									<!--상한가와 하한가 전체-->
									<h6 class="high_mnp_all">
										<?php if($trade < $prev){?>
											<u class="low_money" style="color: #228be6;"> <?php echo rs_get_price($difference, 'krw'); ?> <i class="fas fa-long-arrow-alt-down"></i></u>
											<u class="low_money_percent" style="color: #228be6"> <?php echo rs_number_format($rate, 2); ?>% <i class="fas fa-long-arrow-alt-down"></i>
											</u>
											<!-- IF RISE  -->
										<?php } else if($trade > $prev){?>
											<u class="low_money" style="color: #fa5252"> + <?php echo rs_get_price($difference, 'krw'); ?> <i  class="fas fa-long-arrow-alt-up"></i>
											</u>
											<u class="low_money_percent" style="color: #fa5252"> + <?php echo rs_number_format($rate, 2); ?>% <i class="fas fa-long-arrow-alt-up"></i>
											</u>	
										<?php }else {?>
											<u class="low_money" style= "color: black" > <?php echo rs_get_price($difference, 'krw'); ?><i class="fas fa-long-arrow-alt-right"></i> </u>
											<u class="low_money_percent" style= "color: black"> <?php echo rs_number_format($rate, 2); ?>% <i class="fas fa-long-arrow-alt-right"></i></u>
										<?php }?>
										<!--상한가와 하한가 전체-->	
											<!--하한가 끝-->
											<h5 class="price_all">
												<span class="high"><u>고가</u> ￦ <?php echo rs_get_price($high, 'krw'); ?></span>
												<span class="low"><u>저가</u> ￦ <?php echo rs_get_price($low, 'krw'); ?></span>
											</h5>
										<!-- </h6> -->
										<!--상한가와 하한가 전체 끝-->>
									</h6>
								<?php } else {?>
									<?php if($change == 'FALL'){ ?>
										<h6 style="color: #228be6;" class="price_now"> ￦<?php echo rs_get_price($trade, 'krw'); ?></h6>
									<?php }else if($change == 'RISE'){?>
										<h6 class="price_now" style="color: #fa5252"> ￦<?php echo rs_get_price($trade, 'krw'); ?></h6>
									<?php }else{?>
										<h6 class="price_now"> ￦<?php echo rs_get_price($trade, 'krw'); ?></h6>
									<?php }?>
									
									<!--상한가와 하한가 전체-->
									<h6 class="high_mnp_all">
										<?php if($change == 'FALL'){?>
											<u class="low_money" style="color: #228be6;"> - <?php echo rs_get_price($difference, 'krw'); ?> <i class="fas fa-long-arrow-alt-down"></i></u>
											<u class="low_money_percent" style="color: #228be6"> - <?php echo rs_number_format($rate, 2); ?>% <i class="fas fa-long-arrow-alt-down"></i>
											</u>
											<!-- IF RISE  -->
										<?php } else if($change == 'RISE'){?>
											<u class="low_money" style="color: #fa5252"> + <?php echo rs_get_price($difference, 'krw'); ?> <i  class="fas fa-long-arrow-alt-up"></i>
											</u>
											<u class="low_money_percent" style="color: #fa5252"> + <?php echo rs_number_format($rate, 2); ?>% <i class="fas fa-long-arrow-alt-up"></i>
											</u>	
										<?php }else {?>
											<u class="low_money" style= "color: black" > -<?php echo rs_get_price($difference, 'krw'); ?><i class="fas fa-long-arrow-alt-right"></i> </u>
											<u class="low_money_percent" style= "color: black"> - <?php echo rs_number_format($rate, 2); ?>% <i class="fas fa-long-arrow-alt-right"></i></u>
										<?php }?>
										<!--상한가와 하한가 전체-->	
											<!--하한가 끝-->
											<h5 class="price_all">
												<span class="high"><u>고가</u> ￦ <?php echo rs_get_price($high, 'krw'); ?></span>
												<span class="low"><u>저가</u> ￦ <?php echo rs_get_price($low, 'krw'); ?></span>
											</h5>
										<!-- </h6> -->
										<!--상한가와 하한가 전체 끝-->>
									</h6>
									<?php
									}?>	
									<!--상한가와 하한가 전체 끝-->
							</p>
						</div>
				</div>
			<?php
			}
			?>
			<!-- PRICE UNTIL HERE -->
			<div class="gap35"></div>
			<div class="cont">
				<?php
				if(element('is_all', $view) || element('is_free', $view)){
				?>
				<!-- 자유게시판 시작 -->
				<div class="tits">
					<h3>자유게시판</h3>
					<?php
					if(element('is_all', $view)){
					?>
						<a href="javascript:void(0);" class="more" data-type="free"><span>more</span></a>
					<?php 
					}
					?>
				</div>
				<div class="list vimg vp">
					<div class="list community">
						<table>
							<colgroup>
								<col width="170">
								<col width="*">
								<col width="100">
								<col width="100">
								<col width="100">
							</colgroup>
							<tbody>
							<?php
							if (element('list', element('free_data', $view))) {
								foreach (element('list', element('free_data', $view)) as $result) {
							?>
								<tr>
									<td>
										<div class="my-info">
											<p class="pimg"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', $result), 28, 28); ?>" alt=""></p>
											<p class="rtxt"><a class="popup_menuu"><?php echo element('post_nickname', $result); ?></a></p>
										</div>
									</td>
									<td class="l notice"><a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('post_title', $result)); ?>" style="padding-right:5px; max-width:80%;">
										<?php echo html_escape(element('post_title', $result)); ?></a>
										<?php if(element('post_comment_count', $result) != 0) {?>
											(<?php echo element('post_comment_count', $result); ?>)
										<?php } ?>
										
										<?php if(strpos(element('post_content', $result),'<img') !== false){?>
											<img src="<?php echo base_url('assets/images/list-img.png'); ?>">
										<?php } ?>
										</td>
									<td><?php echo element('display_datetime', $result); ?></td>
									<td><?php echo number_format(element('post_hit', $result)); ?></td>
									<td>
										<?php if(number_format(element('post_like_point', $result)-element('post_dislike_point', $result)) >= 0){ ?>
											<p class="cyellow">
											<?php } else{?>
											<p class="cblue">
										<?php }?>
										<?php echo number_format(element('post_like_point', $result)-element('post_dislike_point', $result)); ?></p>
									</td>
								</tr>
							<?php
								}
							} else {
							?>
								<tr>
									<td colspan="5" class="nopost">게시물이 없습니다</td>
								</tr>
							<?php 
							} 
							?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="gap75"></div>
				<!-- 자유게시판 끝!!! -->
				<?php
				}
				?>

				<?php
				if(element('is_all', $view) || element('is_writer', $view)){
				?>
				<!-- CIC WRITER 시작 -->
				<div class="tits">
					<h3>WRITER</h3>
					<?php
					if(element('is_all', $view)){
					?>
						<a href="javascript:void(0);" class="more" data-type="writer"><span>more</span></a>
					<?php 
					}
					?>
				</div>
				<div class="list vimg vp">
					<ul>
					<?php
						if (element('list', element('writer_data', $view))) {
							foreach (element('list', element('writer_data', $view)) as $result) {
					?>		
						<li>
							<a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('post_title', $result)); ?>">
								<div class="img"><img src="<?php echo thumb_url('post', element('pfi_filename', element('images', $result))); ?>" 
									alt="<?php echo html_escape(element('post_title', $result)); ?>"></div>
								<div class="txt">
									<div class="vc">
										<p class="btxt"><?php echo html_escape(element('post_title', $result)); ?>
												<?php if(element('post_comment_count', $result)>0) {?>
												<span>(<?php echo element('post_comment_count', $result); ?>)</span>
												<?php } ?>
											</p>
											<p class="stxt"><?php echo html_escape(cut_str(str_replace("&nbsp;"," ",strip_tags(element('post_content', $result))), 60)); ?></p>
										<p class="ctxt">
											<span><?php echo html_escape(element('post_nickname', $result)); ?></span>
											<span><?php echo element('display_datetime', $result); ?></span>
											<span>조회 <?php echo number_format(element('post_hit', $result));?></span>
										</p>
									</div>
								</div>
							</a>
								<div class="abr">
									<div class="photo">
										<p class="pimg"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', $result), 28, 28);?>"
                                            alt="<?php echo element('mlc_title', $result); ?>"></p>

										<p class="rtxt popup_menuu2"><?php echo element('post_nickname', $result); ?></p>
									</div>
									<p class="vp"><?php echo number_format(element('post_like_point', $result)-element('post_dislike_point', $result)); ?> VP</p>
								</div>	
						</li>
					<?php	
						}
					} else {
					?>
						<li class="nopost" style="text-align: center">게시물이 없습니다</li>
					<?php 
					} 	
					?>	
					</ul>
					<script>
						$(function(){
							$('.list.vimg').find('li').each(function(){
								var chkimg = $(this).find('.img').length;
								if(chkimg<1){
									$(this).addClass('no-img');
								}
							})
						})
					</script>
				</div>
				<div class="gap75"></div>
				<!-- CIC WRITER 끝 -->
				<?php
				}
				?>

				<?php
				if(element('is_all', $view) || element('is_forum', $view)){
				?>
				<!-- NEWS 시작 -->
				<div class="tits">
					<h3>포럼</h3>
					<?php
					if(element('is_all', $view)){
					?>
					<a href="javascript:void(0);" class="more" data-type="forum"><span>more</span></a>
					<?php 
					}
					?>
				</div>
				<div class="list vimg vp">
					<ul>
						<?php
						if (element('list', element('forum_data', $view))) {
							foreach (element('list', element('forum_data', $view)) as $result) {
								$image_url = element('frm_image',element('images', $result)) ? base_url('uploads/forum_image/').html_escape(element('frm_image',element('images', $result))) :base_url('assets/images/news-img02.png');
						?>
						<li>
							<a href="<?php echo site_url('/post/'.element('post_id', $result)); ?>" target="_blank">
								<div class="img"><img src="<?php echo html_escape($image_url) ?>" alt=""></div>
								
								<div class="txt">
									<div class="vc">
										<p class="btxt"><?php echo html_escape(element('post_title', $result)); ?></p>	
										<p class="stxt"><?php echo html_escape(cut_str(str_replace("&nbsp;"," ",strip_tags(element('post_content', $result))), 60)); ?></p>
										<p class="ctxt">
											<span><?php echo html_escape(element('post_nickname', $result)); ?></span>
											<span><?php echo display_datetime(element('post_datetime', $result)); ?></span>
											<span>조회 <?php echo number_format(element('post_hit', $result)); ?></span>
										</p>
									</div>
								</div>
							</a>
						</li>
						<?php
							}
						} else {
						?>
							<li class="nopost" style="text-align: center">게시물이 없습니다</li>
						<?php	
						}
						?>
					</ul>
				</div>
				<!-- NEWS 끝 -->
				<?php
				}
				?>
				<div class="gap75"></div>

				<?php
				if(element('is_all', $view) || element('is_news', $view)){
				?>
				<!-- NEWS 시작 -->
				<div class="tits">
					<h3>NEWS</h3>
					<?php
					if(element('is_all', $view)){
					?>
					<a href="javascript:void(0);" class="more" data-type="news"><span>more</span></a>
					<?php 
					}
					?>
				</div>
				<div class="list vimg vp">
					<ul>
						<?php
						if (element('list', element('news_data', $view))) {
							foreach (element('list', element('news_data', $view)) as $result) {
								$image_url = element('news_image', $result) ? element('news_image', $result) : base_url('assets/images/news-img02.png');
						?>
						<li>
							<a href="<?php echo site_url('/news/news_url/'.element('news_id', $result)); ?>" target="_blank">
								<div class="img"><img src="<?php echo html_escape($image_url) ?>" alt=""></div>
								<div class="txt">
									<div class="vc">
										<p class="btxt"><?php echo html_escape(element('news_title', $result)); ?><!--<span>(<?php echo number_format(element('news_reviews', $result)); ?>)</span>--></p>	
										<p class="stxt"><?php echo html_escape(element('news_contents', $result)); ?></p>
										<p class="ctxt">
											<span><?php echo html_escape(element('comp_name', $result)); ?></span>
											<span><?php echo display_datetime(element('news_wdate', $result)); ?></span>
											<span>조회 <?php echo number_format(element('news_reviews', $result)); ?></span>
										</p>
									</div>
								</div>
							</a>
						</li>
						<?php
							}
						} else {
						?>
							<li class="nopost" style="text-align: center">게시물이 없습니다</li>
						<?php	
						}
						?>
					</ul>
				</div>
				<!-- NEWS 끝 -->
				<?php
				}
				?>
			<!-- s: paging-wrap -->
			<div class="paging-wrap">
				<?php echo element('paging', $view); ?>
			</div>
			<!-- e: paging-wrap -->
		</div>		
		<!-- page end // -->
		</div>
	</div>
	<!-- e: #container-wrap //-->
</div>

<!-- CHARTJS CANVAS 시작 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
	<?php if($trade && element('is_all', $view)){ ?>
	var ctx = document.getElementById('canvas').getContext('2d');
	var label = '<?php echo $symbole; ?>';
	var time = new Array();
	<?php foreach ($his_time as $key => $val){ ?>
		time.push('<?php echo $val; ?>');
	<?php } ?>
	var price = new Array();
	<?php foreach ($his_price as $key => $val){ ?>
		price.push('<?php echo $val; ?>');
	<?php } ?>
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: time.reverse(),
			datasets: [{
				label: label,
				data: price.reverse(),
				backgroundColor: ['rgb(227,240,252)'],
				borderColor: [
					'rgba(0,0,255, 1.0)',
				],
				borderWidth: 0.5,
				fillColor: '#ffff00'
			}]	
		},
		options: {
			responsive: true,
			elements: { 
				points:{ hitRadius: 10, hoverRadius: 10 }
			},
			legend: {
				display: false,
			},
			scales: {
				xAxes: [{
					display: false,
					gridLines: {
						display: false,
					}
				}],
				yAxes: [{
					ticks: {
						display: false,
					},
					gridLines: {
						display: true,
					}
				}]
			}
		}
	});
	<?php } ?>

	$(document).on('click', '.li_type', function(){
		var value = $(this).data('value');
		$('input[name="type"]').val(value);
	})

	$(document).on('click', '.li_sfield', function(){
		var value = $(this).data('value');
		console.log(value);
		$('input[name="sfield"]').val(value);
	})

	$(document).on('click', '.li_findex', function(){
		var value = $(this).data('value');
		$('input[name="findex"]').val(value);
	})

	$(document).on('click', '.more', function(){
		var type = $(this).data('type');
		$('input[name="type"]').val(type);
		// $('#searchForm').submit();
		$('.enter').trigger('click');
	})
</script>

<div class="popupLayer" style="display:none; z-index:1200;">
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
            
            $('.layer_link').prop('href', `<?php echo base_url('board/freetalk').'?sfield=post_nickname&skeyword='?>${$(this).text()}`);
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

<div class="popupLayer2" style="display:none; z-index:1200">
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
            
            $('.layer_link2').prop('href', `<?php echo base_url('board/cicwriter').'?sfield=post_nickname&skeyword='?>${$(this).text()}`);
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