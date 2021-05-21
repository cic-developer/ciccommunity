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
					?>
					<ul>
						<li class="active"><a href="<?php base_url('/search') ?>"><span>통합검색</span></a></li>
						<li><a href="<?php base_url('/search') ?>/search?group_id=<?php echo $bgr_name ?>"><span>제목</span></a></li>
						<li><a href="#n"><span>내용</span></a></li>
						<li><a href="#n"><span>작성자</span></a></li>
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
					<p class="chk-input"><input type="text" placeholder="검색어를 입력해주세요" autocomplete="off" name="skeyword"></p>
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
				<div class="result">
					<img style= "width: 30px" src="https://static.upbit.com/logos/<?php echo $symbole; ?>.png"></img>
					<strong  class="btxt"> <?php echo $korean; ?></strong>
					<p class="stxt"><span> KRW-<?php echo $symbole; ?> </span></p></br>
						<p class="stxt"> <span style="color:blue">고가  ￦ <?php echo $high; ?> </span>
							<span style="color:red">저가 ￦ <?php echo $low; ?> </span>
						
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container text-center">
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
						{
							"symbol": "BITHUMB:<?php echo $symbole ?>KRW",
							"width": 300,
							"height": 150,
							"locale": "en",
							"dateRange": "12M",
							"colorTheme": "light",
							"trendLineColor": "#37a6ef",
							"underLineColor": "#E3F2FD",
							"isTransparent": false,
							"autosize": false,
							"largeChartUrl": ""
						}
						</script>
					</div></p>
					<!-- TradingView Widget END -->
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
											<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png')?>"
													alt=""></p>
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
					<a href="#n" class="more"><span>more</span></a>
				</div>
				<div class="list vimg vp">
					<ul>
					<?php
						if (element('list', element('data', $view))) {
							foreach (element('list', element('data', $view)) as $result) {
					?>		
						<li>
							<a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('post_title', $result)); ?>">
								<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
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
										<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt=""></p>
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
						<tr>
							<td colspan="5" class="nopost text-center">게시물이 없습니다</td>
						</tr>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script>
var ctx = document.getElementById('canvas');
var context = ctx.getContext("2d");

var high = <?php echo $high ?>;
var low = <?php echo $low ?>; 
var opening_price = <?php echo $opening_price ?>;
var prev_price = <?php echo $prev_price ?>;
var trade = <?php echo $trade ?>;

ctx.width = 200; 
// ctx.heigh = 100;
var data = {
labels: ['', '', '', '', '', ''],
datasets: [{
	label: 'Bitcoin',
    data: [trade, prev_price, opening_price, trade,  prev_price, opening_price ],
	backgroundColor: "white",
	borderColor: "#3e95cd"
    }]
};
var option = {
	responsive: false,
    maintainAspectRatio: false,
	elements: {
        line: {
            tension: 0.4 // disables bezier curves
        }
	},
	legend: {
        display: false
    },
	scales: {
		yAxes:[{
    		stacked:true,
			ticks: {			
				max: high,
				min: low
				
			},
        	gridLines: {
        		display:false,
            }
    	}],
		xAxes:{
			gridLines: {
				display: true,
			}
    	}
    }
};
var myBarChart = Chart.Line(canvas,{
	data:data,
  	options:option
});
</script>
