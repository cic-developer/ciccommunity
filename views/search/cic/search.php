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
					<a href="#n" class="sel-btn"><span>통합검색</span></a>
					<?php
					if (element('grouplist', $view)) {
						foreach (element('grouplist', $view) as $key => $value) {
							//print_r($value);
					?>
					<ul>
						<li class="active"><a href="<?php base_url() ?>"><span>통합검색</span></a></li>
						<li value="post_title"><a href="<?php base_url() ?>/<?php echo element ('brd_order', $value) ?>"><span>제목</span></a></li>
						<li value="post_content"><a href="#n"><span>내용</span></a></li>
						<li value="post_nickname"><a href="#n"><span>작성자</span></a></li>
					</ul>
					<?php
					}
						}		
					?>
				</div>
				<div class="field search">
                    <?php 
						$attributes = array('class' => 'search_box', 'name' => 'searchForm', 'id' => 'searchForm', 'method'=> 'get', 'action' => base_url('/search'));
						echo form_open(current_full_url(), $attributes);
					?>
					<p class="chk-input"><input type="text" placeholder="검색어를 입력해주세요" autocomplete="off" name="skeyword"
						value="<?php echo $this->input->get('skeyword');?>"></p>
					<button class="enter"><span class="blind">검색</span></button>
                    <?php echo form_close(); ?>
				</div>
				<div class="abr">
					<div class="sel-box c02">
						<a href="#n" class="sel-btn"><span>제목만</span></a>
						<ul>
							<li class="active"><a href="#n"><span>제목만</span></a></li>
							<li><a href="#n"><span>내용만</span></a></li>
						</ul>
					</div>
					<div class="sel-box c03">
						<a href="#n" class="sel-btn"><span>최신순</span></a>
						<ul>
							<li class="active"><a href="#n"><span>최신 순</span></a></li>
							<li><a href="#n"><span>관련도 순</span></a></li>
							<li><a href="#n"><span>인기 순</span></a></li>
						</ul>
					</div>
				</div>
				
			</div>
			<div class="result">
				<p class="btxt"><span><?php echo element('highlight_keyword', $view);?></span> 에 대한 통합검색 총</p>
				<p class="stxt"><?php echo $total_rows; ?>건</p>
			</div>
			<!-- HERE THE PRICE -->
			<?php if($trade){ ?>
				<div class="result" style="overflow:hidden; padding-bottom:40px; padding-left:40px; padding-right:40px;">
				<!-- TradingView Widget BEGIN -->
				<div class="text-center" style="float: left">
				<canvas id="canvas" width="400" height="200"></canvas>
				</div>	
					<!-- TradingView Widget END -->
					<div class="right_content_all">
					<div style="text-align:left; border-bottom:5px solid #ddd; padding-bottom:5px;">
						<img style= "width: 30px; padding-right:10px;" src="https://static.upbit.com/logos/<?php echo $symbole; ?>.png"></img>
						<strong class="btxt"><?php echo $korean; ?></strong>
						<p class="stxt">
							<span> <?php echo $symbole; ?></span>
							<u class="btc" >
								<small hidden class="doller">1.0000BTC $30,971</small>
							</u>
						</p>	
					</div>
					<p class="stxt">
						<?php if($change === 'FALL'){?>
							<h6 style="color: blue" class="price_now"> ￦<?php echo $trade ?></h6>
						<?php } elseif($change === 'RISE'){?>
							<h6 class="price_now" style="color: red"> ￦<?php echo $trade ?></h6>
						<?php }else {?>
							<h6 class="price_now"> ￦<?php echo $trade ?></h6>
						<?php }?>
						<!--상한가와 하한가 전체-->
						<h6 class="high_mnp_all">
							<!--하한가-->
							<?php if($change === 'FALL'){?>
								<u class="low_money"> - <?php echo $difference; ?> <i class="fas fa-long-arrow-alt-down"></i>
							<?php } elseif($change === 'RISE'){ ?> </u>
								<u class="low_money" style="color: red"> + <?php echo $difference; ?> <i  class="fas fa-long-arrow-alt-up"></i>
							</u>
							<?php} else{ ?> </u>
								<u class="low_money" style="color: black"> + <?php echo $difference; ?> <i  class="fas fa-long-arrow-alt-up"></i>
							</u>
							<?php  }?>

							<!-- RATE -->
							<?php if($change === 'FALL'){?>
							<u class="low_money_percent"> - <?php echo round($rate, 2);  ?>% <i class="fas fa-long-arrow-alt-down"></i>
							</u>
							<?php } else{ ?> </u>
							<u class="low_money_percent" style="color: red">+ <?php echo round($rate, 2); ?>% <i class="fas fa-long-arrow-alt-up"></i>
							</u>
							<?php } ?>	
							<!--하한가 끝-->
							<h5 class="price_all">
								<span class="high"><u>고가</u> ￦ <?php echo $high; ?></span>
								<span class="low"><u>저가</u> ￦ <?php echo $low; ?></span>
							</h5>
						</h6>
						<!--상한가와 하한가 전체 끝-->
					</p>
					</div>
				</div>
			<?php
			}
			if(!$trade || is_string($trade)){?>
				<div></div>
			<?php } ?>	
			<!-- PRICE UNTIL HERE -->


			<div class="gap35"></div>
			<div class="cont">
				<div class="tits">
					<h3>자유게시판</h3>
					<a href="#n" class="more"><span>more</span></a>
				</div>
				<div class="list community">
					<table>
						<colgroup>
							<col width="170">
							<col width="*">
							<col width="100">
							<col width="100">
							<col width="100">
						</colgroup>
						<thead>
							<tr>
								<th>글쓴이</th>
								<th>제목</th>
								<th>등록일</th>
								<th>조회</th>
								<th><span class="cyellow">VP</span></th>
							</tr>
						</thead>
						<tbody>
							<?php

							if (element('list', element('data', $view))) {
								foreach (element('list', element('data', $view)) as $result) {
							?>
								<tr>
									<td>
										<div class="my-info">
											<p class="pimg"><img src="<?php echo thumb_url(element('mem_image', $result),30, 30)?>" alt=""></p>
											<p class="rtxt"><?php echo element('post_nickname', $result); ?></p>
										</div>
									</td>
									<td class="l notice"><a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('post_title', $result)); ?>">
										<?php echo html_escape(element('post_title', $result)); ?></a></td>
									<td><?php echo element('display_datetime', $result); ?></td>
									<td><?php echo number_format(element('post_hit', $result)); ?></td>
									<td>
										<p class="cyellow"><?php echo number_format(element('post_like_point', $result)-element('post_dislike_point', $result)); ?></p>
									</td>
								</tr>
							<?php
								}
							}
							if (!element('list', element('data', $view)))  {
							?>
								<tr>
									<td colspan="5" class="nopost">게시물이 없습니다</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					<div class="paging-wrap">
						<?php echo element('paging', $view); ?>
					</div>
				</div>
				<div class="gap75"></div>
				<div class="tits">
					<h3>WRITER</h3>
					<?php if (element('boardlist', $view)) {
						foreach (element('boardlist', $view) as $key => $value) {
							if(element ('brd_key', $value) == 'freetalk'){
					?>
					<a href="<?php echo base_url(). "search/?board_id="?><?php echo element('brd_id', $value) ?>" class="more"><span>more</span></a>
					<?php
							}
						}
					}
					?>
				</div>
				<div class="list vimg vp">
					<ul>
					<?php
						if (element('list', element('data', $view))) {
							foreach (element('list', element('data', $view)) as $result) {
					?>		
						<li>
							<a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('post_title', $result)); ?>">
								<div class="img"><img src="<?php echo thumb_url(element('images', $result))?>?>" alt=""></div>
								<div class="txt">
									<div class="vc">
										<p class="btxt"><?php echo html_escape(element('post_title', $result)); ?><span class="yellow-bg"></span> 
											<span>(<?php echo element('post_comment_count', $result); ?>)</span></p>
											<p class="stxt"><?php echo html_escape(cut_str(strip_tags(element('post_content', $result)), 60)); ?></p>
										<p class="ctxt">
											<span><?php echo html_escape(element('post_nickname', $result)); ?></span>
											<span><?php echo element('display_datetime', $result); ?></span>
											<span>조회 <?php echo number_format(element('post_hit', $result));?></span>
										</p>
									</div>
								</div>
								<div class="abr">
									<div class="photo">
										<p class="pimg"><img src="<?php echo thumb_url(element('mem_photo', $result),30, 30)?>" alt=""></p>
										<p class="rtxt"><?php echo element('post_nickname', $result); ?></p>
									</div>
									<p class="vp"><?php echo number_format(element('post_like_point', $result)-element('post_dislike_point', $result)); ?> VP</p>
								</div>	
							</a>
						</li>
					<?php	
							}
						}
					if (!element('list', element('data', $view)))  {		
					?>
							<li colspan="5" style="text-align: center"  class="nopost">게시물이 없습니다</li>
					<?php } ?>	
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
				<div class="tits">
					<h3>NEWS</h3>
					<a href="#n" class="more"><span>more</span></a>
				</div>
				<div class="list vimg">
				<ul>
					<li>
						<a href="#n">
							<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
							<div class="txt">
								<div class="vc">
									<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>	
									<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
									<p class="ctxt">
										<span>블록미디어</span>
										<span>02:18</span>
										<span>조회 82</span>
									</p>
								</div>
							</div>
						</a>
					</li>
					<li>
						<a href="#n">
							<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
							<div class="txt">
								<div class="vc">
									<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>	
									<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
									<p class="ctxt">
										<span>블록미디어</span>
										<span>02:18</span>
										<span>조회 82</span>
									</p>
								</div>
							</div>
						</a>
					</li>
					<li>
						<a href="#n">
							<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
							<div class="txt">
								<div class="vc">
									<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>	
									<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
									<p class="ctxt">
										<span>블록미디어</span>
										<span>02:18</span>
										<span>조회 82</span>
									</p>
								</div>
							</div>
						</a>
					</li>
					<li class="no-img">
						<a href="#n">
							<div class="txt">
								<div class="vc">
									<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>	
									<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
									<p class="ctxt">
										<span>블록미디어</span>
										<span>02:18</span>
										<span>조회 82</span>
									</p>
								</div>
							</div>
						</a>
					</li>
					<li>
						<a href="#n">
							<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
							<div class="txt">
								<div class="vc">
									<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>	
									<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
									<p class="ctxt">
										<span>블록미디어</span>
										<span>02:18</span>
										<span>조회 82</span>
									</p>
								</div>
							</div>
						</a>
					</li>
					<li>
						<a href="#n">
							<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
							<div class="txt">
								<div class="vc">
									<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>	
									<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
									<p class="ctxt">
										<span>블록미디어</span>
										<span>02:18</span>
										<span>조회 82</span>
									</p>
								</div>
							</div>
						</a>
					</li>
				</ul>
			</div>
			<!-- s: paging-wrap -->
			<div class="paging-wrap">
				<!-- <a href="#" class="prev ctrl"><span>이전</span></a> -->
				<ul>
					<li><a href="#" class="active">1</a></li>
					<li><a href="#n">2</a></li>
					<li><a href="#n">3</a></li>
					<li><a href="#n">4</a></li>
					<li><a href="#n">5</a></li>
				</ul>
				<p class="num"><span>1</span> / 10 </p>
				<a href="#" class="next ctrl"><span>다음</span></a>
			</div>
			<!-- e: paging-wrap -->
		</div>		
		<!-- page end // -->
		</div>
	</div>
	<!-- e: #container-wrap //-->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
	var ctx = document.getElementById('canvas').getContext('2d');
	var label = '<?php echo $symbole; ?>';
	var time = new Array();
	<?php foreach ($his_time as $key => $val){ ?>
		time.push('<?php echo $val; ?>');
	<?php } ?>
	console.log(time.length);
	var price = new Array();
	<?php foreach ($his_price as $key => $val){ ?>
		price.push('<?php echo $val; ?>');
	<?php } ?>
	console.log(price.length);
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
			line:{
				tension: 0.5
			},
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
</script>
