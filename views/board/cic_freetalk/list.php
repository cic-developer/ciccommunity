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
        <div class="board-wrap list">
            <div class="real">
                <div class="fl">
                    <h4>베스트 게시물</h4>
                    <ul>
                        <!-- <li><a href="<?php echo base_url('post/5')?>">1. [스압] 월급루팡이 만들어지는 과정 (5) <span>18</span></a>
                        </li> -->
                        <?php
						if (element('list',element('bestpost', $view))) {
							foreach (element('list',element('bestpost', $view)) as $bestpost) {
						?>
							<li>
								<a href="<?php echo goto_url(element('posturl', $bestpost)); ?>"><?php echo number_format(element("num",$bestpost));?>. <?php echo html_escape(element('post_title', $bestpost)); ?><span class="text-right"><?php //echo number_format(element('post_like_point', $bestpost)); ?></span></a>
							</li>
						<?php
                            if(element("num",$bestpost) > 6){break;}  
							}
						}
						if ( ! element('list', element('bestpost', $view))) {
						?>
							<tr>
								<td colspan="12" class="nopost">자료가 없습니다</td>
							</tr>
						<?php
						}
						?>
                    </ul>
                </div>
                <div class="fr">
                    <h4>실시간 인기 게시물</h4>
                    <ul>
                        <!-- <li><a href="<?php //echo base_url('post/5')?>">1. [스압] 월급루팡이 만들어지는 과정 (5) <span>28</span></a>
                        </li> -->
                        <?php
						if (element('list',element('popularpost', $view))) {
							foreach (element('list',element('popularpost', $view)) as $popularpost) {
						?>
							<li>
								<?php if (element('category', $popularpost)) { ?><span class="label label-default"><?php echo html_escape(element('bca_value', element('category', $popularpost))); ?></span><?php } ?>
								<a href="<?php echo goto_url(element('posturl', $popularpost)); ?>"><?php echo number_format(element("num",$popularpost));?>. <?php echo html_escape(element('post_title', $popularpost)); ?> <span class="text-right"><?php //echo number_format(element('post_like_point', $popularpost)); ?></span></a>
							</li>
						<?php
                            if(element("num",$popularpost) > 4) break;
							}
						}
						if ( ! element('list', element('popularpost', $view))) {
						?>
							<tr>
								<td colspan="12" class="nopost">자료가 없습니다</td>
							</tr>
						<?php
						}
						?>
                    </ul>
                </div>
            </div>
            <div class="gap60"></div>
            <?php
				ob_start();
				?>
                    <div class="board-filter02">
                        <form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
                            <p class="chk-select">
                                <select name="sfield">
                                    <?php echo element('search_option',  element('list', $view)); ?>
                                </select>
                            </p>
                            <p class="chk-input">
                                <input type="text" name="skeyword" value="<?php echo html_escape(element('skeyword',  element('list', $view))); ?>" placeholder="검색어를 입력해주세요" autocomplete="off" />
                                <button class="search-btn" name="search_submit" type="submit"></button>
                            </p>
                            <?php if (element('write_url', element('list', $view))) { ?>
                                <a href="<?php echo element('write_url', element('list', $view)); ?>" class="by-btn btn02">글쓰기</a>
                            <?php }?>
                        </form>
                    </div>
                <?php 
                $buttons = ob_get_contents();
				ob_end_flush();
                ?>
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
                        <tr style="border-bottom: 1px solid;">
                            <th>글쓴이</th>
                            <th>제목</th>
                            <th><span class="cyellow">VP</span></th>
                            <th>조회</th>
                            <th>등록일</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (element('notice_list', element('list', $view))) {
                        foreach (element('notice_list', element('list', $view)) as $result) {
                    ?>
                        <tr style="background-color: #f9f9f9;">
                            <td>
                                <div class="my-info">
                                    <p class="pimg">
                                        <img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', $result), 140, 140)?>"alt=""<?php echo element('mlc_title', $result); ?>"">
                                    </p>
                                    <div class="tooltip popup_menuu" search_id="<?php echo html_escape(element('mem_id', $result)); ?>">
                                        <p class="rtxt">
                                            <?php echo element('post_nickname', $result); ?>
                                            <span class="tooltiptext" >
                                                <?php if(number_format(element('mlc_level',$result) > 30)){
                                                    echo '관리자';
                                                }else{ ?>
                                                    <b>레벨 <?php echo element('mlc_level',$result) ?> 
                                                    <?php echo element('mlc_title',$result); ?></b>
                                                   <?php 
                                                   }
                                                    ?>
                                                <br><b><a href="javascript:void(0);" class="layer_link" style="padding:5px; color:#1e5fc9;"> 
                                                작성 글 보기
                                                </a></b>
                                            </span>
                                        </div>
                                    </p>
                                </div>
                            </td>
                            <td class="l notice"><a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('title', $result)); ?>"><span
                                        class="cate">공지</span><?php echo html_escape(element('title', $result)); ?></a></td>
                            <td>
                                <p class="cyellow">-</p>
                                <!-- <p class="cred">4 진정한 흑우</p> -->
                            </td>
                            <td><?php echo number_format(element('post_hit', $result)); ?></td>
                            <td><?php echo element('display_datetime', $result); ?></td>
                        </tr>
                    <?php
                        }
                    }
                    if (element('list', element('data', element('list', $view)))) {
                        foreach (element('list', element('data', element('list', $view))) as $result) {
                            // print_r($this->db->last_query());
                            // exit;
                    ?>
                        <tr>
                            <td>
                                <div class="my-info">
                                    <p class="pimg"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', $result), 140, 140); ?>"
                                        alt="<?php echo element('mlc_title', $result); ?>"></p>
                                        <div class="tooltip popup_menuu" search_id="<?php echo html_escape(element('mem_id', $result)); ?>">
                                            <p class="rtxt">
                                            <?php echo element('post_nickname', $result); ?>
                                            <span class="tooltiptext" >
                                                <?php if(number_format(element('mlc_level',$result) > 30)){
                                                    echo '관리자';
                                                }else{?>
                                                    <b>레벨 <?php echo element('mlc_level',$result) ?> 
                                                    <?php echo element('mlc_title',$result); ?></b>
                                                    <?php } ?>
                                                <br><b><a href="javascript:void(0);" class="layer_link" style="padding:5px; color:#1e5fc9;"> 
                                                작성 글 보기
                                                </a></b>
                                            </span>
                                        </p>
                                    </div>
                            </td>
                            <td class="l file">
                                <a href="<?php echo explode('?',element('post_url', $result))[0];//echo element('post_url', $result); ?>" title="<?php echo html_escape(element('title', $result)); ?>" style="padding-right:5px; max-width:80%;"><?php echo html_escape(element('title', $result)); ?>
                                </a>
                                <span style="color:#1e5fc9;">
                                    <?php if(element('post_comment_count', $result) != 0) {?>
                                        (<?php echo element('post_comment_count', $result); ?>)
                                    <?php } ?>
                                    
                                    <?php if(strpos(element('post_content', $result),'<img') !== false){?>
                                        <img src="<?php echo base_url('assets/images/list-img.png'); ?>">
                                    <?php } ?>
                                </span>
                            </td>
                            <td>
                                <?php if(number_format(element('post_like_point', $result)-element('post_dislike_point', $result)) >= 0){ ?>
                                <p class="cyellow">
                                <?php } else{?>
                                <p class="cblue">
                                <?php }?>
                                <?php echo number_format(element('post_like_point', $result)-element('post_dislike_point', $result)); ?></p> 
                            </td>
                            <td><?php echo number_format(element('post_hit', $result)); ?></td>
                            <td><?php echo element('display_datetime', $result); ?></td>
                        </tr>
                    <?php
                        }
                    }
                    if ( ! element('notice_list', element('list', $view)) && ! element('list', element('data', element('list', $view)))) {
                    ?>
                        <tr>
                            <td colspan="5" class="nopost">게시물이 없습니다</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <?php if (element('write_url', element('list', $view))) { ?>
            <div class="lower r">
                <a href="<?php echo element('write_url', element('list', $view)); ?>" class="by-btn">글쓰기</a>
            </div>
            <?php } ?>
            <!-- s: paging-wrap -->
            <div class="paging-wrap">
                <?php echo element('paging', element('list', $view)); ?>
            </div>
            <!-- e: paging-wrap -->
            <!-- s: board-filter -->
            <div class="board-filter">
                <form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
                    <div class="board-filter">
                        <p class="chk-select">
                            <select name="sfield">
                                <?php echo element('search_option',  element('list', $view)); ?>
                            </select>
                        </p>
                        <p class="chk-input">
                            <input type="text" name="skeyword" value="<?php echo html_escape(element('skeyword',  element('list', $view))); ?>" placeholder="검색어를 입력해주세요" autocomplete="off" />
                            <button class="search-btn" name="search_submit" type="submit"></button>
                        </p>
                    </div>
                </form>
            </div>
            <!-- e: board-filter -->
        </div>
        <!-- page end // -->
    </div>
    
    <!-- 작성 글 보기-->
    <script>
    var _is_hover = true;
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
            $('#gksghdls').html($(this).attr('search_id'));
            $('.popupLayer').css({
                "top": divTop,
                "left": divLeft,
                "display" : "block"
            }).show();
        });
        $('.popup_menuu').mouseover(function(e)
        {
            if(_is_hover){
                var sWidth = window.innerWidth;
                var sHeight = window.innerHeight;

                var oWidth = $('.popupLayer').width();
                var oHeight = $('.popupLayer').height();

                // 레이어가 나타날 위치를 셋팅한다.
                // var divLeft = e.clientX + 10;
                // var divTop = e.clientY + 5;
                var divLeft = e.clientX + 2;
                var divTop = e.clientY + 2;

                // 레이어 위치를 바꾸었더니 상단기준점(0,0) 밖으로 벗어난다면 상단기준점(0,0)에 배치하자.
                if( divLeft < 0 ) divLeft = 0;
                if( divTop < 0 ) divTop = 0;
                
                $('.layer_link').prop('href', `<?php echo base_url('board/freetalk').'?sfield=mem_id&skeyword='?>${$(this).attr('search_id')}`);
                $('.popupLayer').css({
                    "top": divTop,
                    "left": divLeft,
                    "display" : "block"
                }).show();
                _is_hover = false;
            }
        });
        // $('.popup_menuu').mouseout(function(e)
        // {
        //     $('.popupLayer').css('display','none');
        //     _is_hover = true;
        // });
    });
    $(document).mouseup(function (e){
        var container = $('.popupLayer');
        if( container.has(e.target).length === 0){
        container.css('display','none');
        _is_hover = true;
        }
    });
    $(window).on("wheel", function (event){
        $('.popupLayer').css('display','none');
        _is_hover = true;
    });
    $(window).on("scrollstart",function(){
        $('.popupLayer').css('display','none');
        _is_hover = true;
    });
    $(document).on("scrollstart",function(){
        $('.popupLayer').css('display','none');
        _is_hover = true;
    });
    
    </script>
</div>

<style>
    
</style>