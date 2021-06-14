<div id="container-wrap">
    <div id="contents">
        <!-- page start // -->
        <!-- s : msec-visual -->
        <div class="msec-visual">
            <div class="bg">
                <p class="desktop"><img src="<?php echo base_url('assets/images/visual-bg.jpg') ?>" alt="" /></p>
                <p class="mobile"><img src="<?php echo base_url('assets/images/visual-bgm.jpg') ?>" alt="" /></p>
            </div>
            <div class="cont">
                <div class="search">
                    <?php 
						$attributes = array('class' => 'search_box', 'name' => 'searchForm', 'id' => 'searchForm', 'method' => 'get');
						echo form_open(base_url('/search'), $attributes);
					?>
                    <input type="hidden" name="group_id" value="" />
                    <input type="hidden" name="sfield" value="post_both" />
                    <input type="hidden" name="sop" value="OR" />
                    <p class="chk-input"><input type="text" placeholder="검색어를 입력해주세요" autocomplete="off" name="skeyword" /></p>
                    <button class="enter"><span class="blind">검색</span></button>
                    <?php echo form_close(); ?>
                </div>
                <!-- banner start; -->
                <div class="vis">
                    <a href="#n" class="prev"><span class="blind">이전</span></a>
                    <div class="visual-slide">
                    
                    <?php
                    if (element('list',element('banner', $view))) {
                        foreach (element('list',element('banner', $view)) as $banner) {
                    ?>
                        <div class="item banner-hit" data-banner-id="<?php echo element('ban_id', $banner) ?>">
                            <a href="<?php echo element('ban_url', $banner) ?>" target="<?php echo element('ban_target', $banner) ?>">
                                <img src="<?php echo base_url('uploads/banner/'.element('ban_image', $banner)) ?>" alt="<?php echo element('ban_title', $banner) ?>" />
                            </a>
                        </div>
                    <?php
                        }
                    }
                    ?>

                    <?php for($i=0; $i<element('banner_noimage_count', $view); $i=$i+1){ ?>
                            <div class="item">
                            <a href="#n">
                                <img src="<?php echo base_url('assets/images/noimage.jpg') ?>" alt="" />
                            </a>
                        </div>
                    <?php }?>

                    </div>
                    <a href="#n" class="next"><span class="blind">다음</span></a>
                </div>
                <!-- banner end; -->
            </div>
        </div>
        <!-- e : msec-visual -->
        <!-- s : msec-cont -->
        <div class="msec-cont">
            <!-- s : msec-01 -->
            <div class="msec-01">
                <div class="tab">
                    <ul>
                        <?php
                            $i = 0;
                            foreach(element('coin', element('maincoin', $view)) as  $thisCoin){
                        ?>
                            <li <?php echo  $i == 0 ? 'class="active"' : '' ?>>
                                <a href="#n" class="maincoin_symbol" data-symbol="<?php echo element('cmc_symbol', $thisCoin); ?>"><span><?php echo element('cmc_symbol' ,$thisCoin); ?></span></a>
                            </li>
                        <?php
                                $i++;
                            }
                        ?>
                        <li class="cyellow"><a href="#n" class="maincoin_symbol" data-symbol="PER"><span>PER</span></a></li>
                    </ul>
                    <a href="<?php echo $this->member->is_member() ? base_url('/main/coin') : 'javascript:alert(\'로그인이 필요한 서비스입니다.\');'?>" class="more"><span>더 많은 코인 보기</span></a>
                </div>
                <div class="list" id="maincoin_table">
                    <table>
                        <colgroup>
                            <col width="*" />
                            <col width="24%" />
                            <col width="20%" />
                            <col width="20%" />
                            <col width="20%" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th>거래소</th>
                                <th>시세(<?php echo element('money', element('maincoin', $view)) == 'usd' ? 'USD' : 'KRW'; ?>)</th>
                                <th>한국프리미엄</th>
                                <th>거래금액</th>
                                <th>변동률(24h)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 0;
                                foreach(element('exchange', element('maincoin', $view)) as  $thisExchange){
                                    $thisPrice = element($i, element('first_block', element('maincoin', $view)));
                                    $volume = element('volume', $thisPrice);
                                    $money = element('money', element('maincoin', $view));
                                    $price = $money == 'usd' ? element('price_usd', $thisPrice) : element('price', $thisPrice);
                                    $korea_premium = element('korea_premium', $thisPrice);
                                    $change_rate = element('change_rate', $thisPrice);
                                    $percent_class = $change_rate > 0 ? 'up' : $change_rate < 0 ? 'down' : '';
                            ?>
                                <tr>
                                    <td>
                                        <div class="vlogo">
                                            <p class="img"><img
                                                    src="<?php echo element('cme_logo', $thisExchange); ?>" alt="<?php echo element('cme_korean_nm', $thisExchange); ?> 로고" />
                                            </p>
                                            <p class="txt"><?php echo element('cme_korean_nm', $thisExchange); ?></p>
                                        </div>
                                    </td>
                                    <td><?php echo rs_get_price($price, $money); ?></td>
                                    <td><?php echo rs_number_format($korea_premium, 2) ? rs_number_format($korea_premium, 2).' %' : '-'; ?></td>
                                    <td><?php echo number_unit_to_korean($volume); ?></td>
                                    <td>
                                        <?php
                                        // if($change_rate){
                                        ?>
                                        <p class="percent <?php echo $percent_class; ?>"><span><?php echo rs_number_format($change_rate, 2, 0); ?> %</span></p>
                                        <?php
                                        // }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                                    $i++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- e : msec-01 -->
            <!-- s : msec-02 -->
            <div class="msec-02">
                <div class="cont">
                    <div class="fl">
                        <h3>실시간 인기 게시물</h3>
                        <a href="/board/freetalk" class="more"><span>더보기</span></a>
                        <div class="list">
                            <ul>
						<?php
						if (element('list',element('popularpost', $view))) {
							foreach (element('list',element('popularpost', $view)) as $popularpost) {
						?>
							<li>
                                <a href="<?php echo goto_url(element('posturl', $popularpost)); ?>" class="new">
                                    <p class="num"><?php echo number_format(element('num', $popularpost));?></p>
                                    <p class="btxt">
                                        <span class="txt"><?php echo html_escape(element('post_title', $popularpost));?></span>
                                        <span class="hit">(<?php echo number_format(element('post_comment_count', $popularpost));?>)</span>
                                    </p>
                                    <div>
                                        <p class="stxt"><?php echo element('post_nickname', $popularpost); ?><span><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', $popularpost), 30, 30); ?>"alt="" /></span></p>
                                        <p class="date"><?php echo number_format(element('post_hit', $popularpost)); ?>
                                        <span><?php echo display_datetime(element('post_datetime', $popularpost), 'full'); ?></span></p>
                                    </div>                        
                                </a>
							</li>
						<?php
							}
						}
						if ( ! element('list', element('popularpost', $view))) {
						?>
							<li style="text-align:center; padding: 9px 0;">
								자료가 없습니다
							</li>
						<?php
						}
						?>
                            </ul>
                        </div>
                    </div>
                    <div class="fr tab-ov">
                        <h3>실시간 인기 검색어</h3>
                        <div class="ov">
                            <div class="tab">
                                <ul>
                                    <li class="active"><a href="#n" data-tabs="#rtab01"><span>1~10위</span></a></li>
                                    <li><a href="#n" data-tabs="#rtab02"><span>11~20위</span></a></li>
                                </ul>
                            </div>
                            <div class="list tab-con" id="rtab01">
                                <ul>
                                    <?php 
                                    if(element('searchrank', $view)){
                                        for($i = 0; $i < 10; $i++){
                                            $val = element($i, element('searchrank', $view));
                                    ?>
                                        <li><a href="/search?group_id=&sfield=post_both&skeyword=<?php echo element('key', $val); ?>&sop=OR"><span><?php echo $i + 1; ?></span><?php echo element('key', $val); ?></a></li>
                                    <?php 
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="list tab-con hide" id="rtab02">
                                <ul>
                                    <?php 
                                    if(element('searchrank', $view)){
                                        for($i = 10; $i < 20; $i++){
                                            $val = element($i, element('searchrank', $view));
                                    ?>
                                        <li><a href="/search?group_id=&sfield=post_both&skeyword=<?php echo element('key', $val); ?>&sop=OR"><span><?php echo $i + 1; ?></span><?php echo element('key', $val); ?></a></li>
                                    <?php 
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- e : msec-02 -->
            <!-- s : msec-03 -->
            <div class="msec-03">
                <div class="tits">
                    <h3>실시간 <span>HOT</span> 포럼</h3>
                    <p>이슈 투표에서 배팅 수수료의 일급을 지급 받을 수 있습니다</p>
                    <a href="<?php echo base_url('/board/forum')?>" class="more"><span>바로가기</span></a>
                </div>
                <div class="cont">
                    <a href="#n" class="prev"><span class="blind">이전</span></a>
                    <div class="forum-slide">

                        <?php
                        if (element('list',element('forum_banner', $view))) {
                            foreach (element('list',element('forum_banner', $view)) as $forum_banner) {
                        ?>
                            <div class="item">
                                <div class="img">
                                    <img src="<?php echo element('frm_image', $forum_banner) ? base_url('uploads/forum_image/'.element('frm_image', $forum_banner)) : base_url('uploads/forum_banner/2021/06/forum-img01.jpg') ?>" alt="" />
                                </div>

                                <div class="txt">
                                    <div class="vc">
                                        <p><?php echo html_escape(element('post_title', $forum_banner)); ?></p>
                                        <a href="<?php echo element('post_url', $forum_banner); ?>"><span>click!</span></a>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        }
                        ?>

                        <!-- 포럼 기본 이미지 입니다. 승인대기포럼 승인시 설정된 포럼 이미지가 없을 경우 해당 기본 이미지가 보여집니다 -->
                        <!-- 슬라이드바에 보여지는 포럼은, 마감되지 않은 진행중인 포럼에 한해서만 보여집니다 -->
                        <!-- 현재 기본이미지 경로는 두 경우가 있습니다. 편하신대로 사용하시면 됩니다. -->
                        <!-- 1. assets/images/forum-img01.jpg -->
                        <!-- 2. uploads/forum_banner/2021/06/forum-img01.jpg ( 이 이미지의 경로는 대기포럼 승인시 설정한 이미지가 저장되는 경로입니다 ) -->
                        <?php for($i=0; $i<element('forum_banner_noimage_count', $view); $i=$i+1){ ?>

                            <div class="item">
                                <div class="img">
                                <img src="<?php echo base_url('uploads/forum_banner/2021/06/forum-img01.jpg') ?>" alt="" />
                                </div>

                                <div class="txt">
                                    <div class="vc">
                                        <p>빈 게시물 입니다 :)</p>
                                        <a href="#n"><span>wait!</span></a>
                                    </div>
                                </div>
                            </div>

                        <?php }?>

                        <!-- <div class="item">
                            <div class="img">
                                <img src="<?php echo base_url('assets/images/forum-img01.jpg') ?>" alt="" />
                            </div>
                            <div class="txt">
                                <div class="vc">
                                    <p>‘PER’ 코인 <span class="b">떡락</span> vs <span class="b">떡상</span></p>
                                    <a href="#n"><span>click</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img">
                                <img src="<?php echo base_url('assets/images/forum-img02.jpg') ?>" alt="" />
                            </div>
                            <div class="txt">
                                <div class="vc">
                                    <p>코로나 백신 출시 text <br />두줄 텍스트 예시 입니다. <br />세줄 텍스트 예시 입니다.</p>
                                    <a href="#n"><span>click</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img">
                                <img src="<?php echo base_url('assets/images/forum-img03.jpg') ?>" alt="" />
                            </div>
                            <div class="txt">
                                <div class="vc">
                                    <p>코로나 백신 출시 text</p>
                                    <a href="#n"><span>click</span></a>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <a href="#n" class="next"><span class="blind">이전</span></a>
                </div>
            </div>
            <!-- e : msec-03 -->
            <!-- s : msec-04 -->
            <div class="msec-04">
                <div class="cont">
                    <p class="btxt">퍼퍼맨 ‘퍼 내려온다’</p>
                    <p class="stxt">요즘 핫한 퍼 패 맨의 '퍼 내려온다'를 감상해 <br />보세요!</p>
                    <a href="https://www.youtube.com/channel/UC-akAISl4l5sNBI00A1ykqQ" class="more"
                        target="_blink"><span>동영상 더보기</span></a>
                    <div class="img">
                        <a href="https://www.youtube.com/watch?v=bMqQXK64jac" class="play-btn" target="_blink"><span
                                class="blind">재생</span></a>
                        <p><img src="<?php echo base_url('assets/images/movie-img.png') ?>" alt="" /></p>
                    </div>
                </div>
            </div>
            <!-- e : msec-04 -->
            <!-- s : msec-05 -->
            <div class="msec-05">
                <div class="tits">
                    <h3>Use cic</h3>
                </div>
                <div class="cont">
                    <ul>
                        <li>
                            <a href="<?php echo $this->member->is_member() ? base_url('/attendance') : 'javascript:alert(\'로그인이 필요한 서비스입니다.\');';?>">
                                <p class="desktop"><img src="<?php echo base_url('assets/images/use-img01.png') ?>"
                                        alt="" /></p>
                                <p class="mobile"><img src="<?php echo base_url('assets/images/use-img01m.jpg') ?>"
                                        alt="" /></p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->member->is_member() ? base_url('/mypage/charge') : 'javascript:alert(\'로그인이 필요한 서비스입니다.\');';?>">
                                <p class="desktop"><img src="<?php echo base_url('assets/images/use-img02.png') ?>"
                                        alt="" /></p>
                                <p class="mobile"><img src="<?php echo base_url('assets/images/use-img02m.jpg') ?>"
                                        alt="" /></p>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:alert('현재 준비중입니다.');">
                                <p class="desktop"><img src="<?php echo base_url('assets/images/use-img03.png') ?>"
                                        alt="" /></p>
                                <p class="mobile"><img src="<?php echo base_url('assets/images/use-img03m.jpg') ?>"
                                        alt="" /></p>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            <!-- e : msec-05 -->
        </div>
        <!-- e : msec-cont -->
        <!-- page end // -->
    </div>
</div>
<script>
    setInterval(() => $('.visual-slide').trigger('prev.owl.carousel', [600]), 3000);

    $(document).on('click', ".banner-hit", function() {
        var banner_id = $(this).data('banner-id');

        var state = '';
        var message = '';
        $.ajax({
            url: cb_url + '/main/bannerHit',
            type: 'POST',
            data: {     
                ban_id: banner_id,
                csrf_test_name : cb_csrf_hash
            },
            dataType: 'json',
            async: false,
            cache: false,
            success: function(data){
                state = data.state;
                message = data.message;
                
                if(state == '1'){
                    // alert('Banner Hit Success!');
                }
                if(state == '0'){
                    // alert('Banner Hit fail!');
                }
            },
            error: function(){
                // alert('Banner Hit Error!');
            }
        });
    })

    //코인 가격 로딩
    //무한클릭방지
    var getting_maincoin_data = false;
    $(document).on('click', ".maincoin_symbol", function(){
        if(getting_maincoin_data) return false;
        getting_maincoin_data = true;
        var symbol = $(this).data('symbol');
        
        $.ajax({
            url: cb_url + '/main/ajax_get_maincoin',
            type: 'POST',
            data: {     
                cmc_symbol: symbol,
                csrf_test_name : cb_csrf_hash
            },
            dataType: 'json',
            async: false,
            cache: false,
            success: function(data){
                if(data.error){
                    alert(data.error);
                }
                if(data.success){
                    $('#maincoin_table').html(data.success);
                }
            },
            error: function(){
                // alert('Banner Hit Error!');
            }
        });
        getting_maincoin_data = false;
    })
</script>