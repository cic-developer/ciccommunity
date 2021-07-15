<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<?php 
    $_get_partici_order = $this->input->get('partici_order'); 
    $_get_partici_ordertype = $this->input->get('partici_ordertype');
?>
<div id="container-wrap">
    <div id="top-vis">
        <div class="txt">
            <h2 class="forumtitle">포럼</h2>
            <p class="issue">이슈와 관련해 투표를 진행하고, 의견을 교환할 수 있는 공간입니다</p>
        </div>
        <div class="img-forum"></div>
    </div>
    <div id="contents" class="div-cont">
        <!-- page start // -->

        <!-- 현황판 레이아웃 시작 -->
        <div class="forums status">
        <?php
            
            //if (element('mem_bat',element('mem_bat', $view)) && $this->member->is_member()) {
                // foreach (element('mem_bat', $view) as $mem_batting_cp) {
                //     foreach (element('mem_join_forum', $view) as $mem_join_forum) {

            ?>
            <h3>Status</h3>
            <!-- <button class="forum-guide">포럼 가이드</button> -->
        </div>
        <div class="conts">
            <div class="status-ray">
            <table class="bac table_card_view">
                    
				<tr>
					<td class="top op">총 투표</td>
					<td class="value op"><p><?php echo number_format(element('cfc_cp_sum' ,(element('mem_bat',element('mem_bat', $view))))) ? element('cfc_cp_sum' ,(element('mem_bat',element('mem_bat', $view)))) : '-' ?></p> CP</td>
                    <td class="top op">승패/승률</td>
					<td class="value op">
                        <?php echo number_format(element('win' ,(element('mem_bat',element('mem_bat', $view))))) ? element('win' ,(element('mem_bat',element('mem_bat', $view)))) : '0' ; ?>/<?php echo number_format(element('lose' ,(element('mem_bat',element('mem_bat', $view))))) ? element('lose' ,(element('mem_bat',element('mem_bat', $view)))) : '0'; ?> 
                        &nbsp;<?php $_mem_win_lose = number_format(element('win' ,(element('mem_bat',element('mem_bat', $view)))))/(number_format(element('win' ,(element('mem_bat',element('mem_bat', $view)))))+number_format(element('lose' ,(element('mem_bat',element('mem_bat', $view))))))*100;
                        echo $_mem_win_lose > 0 ? (int)$_mem_win_lose.'%' : '0%' ?></td>
				</tr>
				<tr>
					<td class="top op">총 예상 보상</td>
					<td class="value op"><p><?php echo number_format(element('total_expect_cp',$view), 2) ?></p> CP</td>
                    <td class="top op">포럼게시 현황</td>
					<td class="value op">
                        <?php if(element('ing' ,(element('mem_join_forum',element('mem_join_forum', $view)))) === '3'){?>
                            포럼 진행중
                        <?php }else if(element('ing' ,(element('mem_join_forum',element('mem_join_forum', $view)))) === '6'){?>
                            포럼 도전중
                        <?php }else{ ?>
                            도전해보세요!
                        <?php }?>
                    </td>
				</tr>
                <tr>
					<td class="top op">누적 보상</td>
					<td class="value op"><?php echo number_format(element('get_mem_battingCP', $view), 2) ?> CP</td>
                    <td class="top op">참여중인 포럼</td>
					<td class="value op" style="font-weight:bold;" ><a href="#ftab" class="go_to_list" style="border-bottom: 2px solid #666;"><?php echo number_format(element('partici_total_row',$view))?></a></td>
				</tr>
			</table>
            </div>
            <?php // }
          //  }
        //}?>
        </div>
        <!-- 현황판 레이아웃 끝  -->
        
        <div class="board-wrap list">
            <div class="forums">
                <h3>진행중인 <span>BEST</span> 포럼</h3>
                <div class="cont">
                    <a href="javascript:void(0);" class="prev"><span class="blind">이전</span></a>
                    <div class="forum-slide">

                        <?php
                        if (element('list',element('banner', $view))) {
                            foreach (element('list',element('banner', $view)) as $banner) {
                        ?>
                            <div class="item">
                                <div class="img">
                                    <img src="<?php echo element('frm_image', $banner) ? base_url('uploads/forum_image/'.element('frm_image', $banner)) : base_url('uploads/forum_banner/2021/06/forum-img01.jpg') ?>" alt="" />
                                </div>

                                <div class="ov">
                                    <div class="txt">
                                        <p class="btxt"><?php echo html_escape(element('post_title', $banner)); ?></p>
                                    </div>
                                    <p class="stxt">총 <?php echo rs_number_format(element('cic_forum_total_cp', $banner), 2, 0); ?> CP</p>
                                    <a href="<?php echo element('post_url', $banner); ?>"><span>참여하기!</span></a>
                                </div>
                            </div>
                        <?php
                            }
                        }
                        ?>

                        <!-- 포럼 기본 이미지 입니다. 도전! CIC포럼 승인시 설정된 포럼 이미지가 없을 경우 해당 기본 이미지가 보여집니다 -->
                        <!-- 슬라이드바에 보여지는 포럼은, 마감되지 않은 진행중인 포럼에 한해서만 보여집니다 -->
                        <!-- 현재 기본이미지 경로는 두 경우가 있습니다. 편하신대로 사용하시면 됩니다. -->
                        <!-- 1. assets/images/forum-img01.jpg -->
                        <!-- 2. uploads/forum_banner/2021/06/forum-img01.jpg ( 이 이미지의 경로는 대기포럼 승인시 설정한 이미지가 저장되는 경로입니다 ) -->
                        <?php for($i=0; $i<element('banner_noimage_count', $view); $i=$i+1){ ?>
                            <div class="item">
                                <div class="img"><img src="<?php echo base_url('uploads/forum_banner/2021/06/forum-img01.jpg') ?>" alt="" />
                                <!-- <div class="img"><img src="<?php echo base_url('assets/images/noimage.jpg') ?>" alt="" /> -->
                                </div>

                                <div class="ov">
                                    <div class="txt">
                                        <p class="btxt"  id="ftab">여러분의 포럼을 등록해 주세요!</p>
                                    </div>
                                    <p class="stxt">총 0 CP</p>
                                    <a href="javascript:void(0);"><span>참여불가!</span></a>
                                </div>
                            </div>
                        <?php }?>
                        
                    </div>
                    <a href="javascript:void(0);" class="next"><span class="blind">다음</span></a>
                </div>
            </div>
            
            <div class="gap50"></div>
            <div class="ftab">
                <ul>
                    <li class="<?php echo element('type', $view) == 1 ? 'active' : ';' ?>"><a href="<?php echo base_url('board/forum?type=1')?>"><span>진행중 포럼</span></a></li>
                    <li><a href="<?php echo base_url('board/userforum')?>"><span>도전! CIC 포럼</span></a></li>
                    <li class="<?php echo element('type', $view) == 2 ? 'active' : ';' ?>"><a href="<?php echo base_url('board/forum?type=2')?>"><span>마감된 포럼</span></a></li>
                </ul>
            </div>
            <!------------------------------ 참여 리스트 Table 시작 ------------------------>
            <?php if(element('partici_forum',$view)){ ?>
            <div class="gap20" style="height: 390px;"> <!-- overflow:auto; -->
                <form id="partici_forum_form" method="get" action="<?php echo current_url()?>">
                    <select id="partici_ordertype" name="partici_ordertype" style="float: right; margin-bottom: 15px; margin-right: 5px; width:100px;" >
                        <option value="DESC" <?php echo $_get_partici_ordertype == "DESC" ? "selected" : ""?> >내림차순</option>
                        <option value="ASC" <?php echo $_get_partici_ordertype == "ASC" ? "selected" : ""?> >오름차순</option>
                    </select>
                    <select id="partici_order" name="partici_order" style="float: right; margin-bottom: 15px; width:190px;" >
                        <option value="cfc_cp" <?php echo $_get_partici_order == "cfc_cp" ? "selected" : ""?> >참여 CP</option>
                        <option value="total_cp" <?php echo $_get_partici_order == "total_cp" ? "selected" : ""?> >총 참여 CP</option>
                        <option value="expect_cp" <?php echo $_get_partici_order == "expect_cp" ? "selected" : ""?> >예상 보상 CP</option>
                        <option value="frm_close_datetime" <?php echo $_get_partici_order == "frm_close_datetime" ? "selected" : ""?> >참여 마감</option>
                        <option value="frm_bat_close_datetime" <?php echo $_get_partici_order == "frm_bat_close_datetime" ? "selected" : ""?> >포럼 마감</option>
                    </select>
                </form>
        <div class="tbox">
            <table class="rwd-table">
            <thead style="background:#fff;">
                <tr>
                    <th class="under" colspan=7 style="font-size: 20px; color:#666; border-bottom:2px solid #f7c916 !important;"><p>참여 리스트</p></th>
                </tr>  
                <tr class="none_300" >
                    <th style="width:25%; padding-left: 25px !important;">포럼명</th>
                    <th style="margin-right:10px">참여CP</th>
                    <th style="background:#fff;">보상예상CP</th>
                    <th style="background:#fff;">상세</th>
                    <th style="background:#fff;">참여진영</th>
                    <th style="background:#fff;">총 참여CP</th>
                    <th style="background:#fff;">공유하기</th>
                </tr> 
            </thead>
            <tbody>  
                <?php foreach(element('partici_forum', $view) AS $prtici_row){?>
                <tr>
                    <td data-th="포럼명"  class="forum_join_list" style="padding-left: 5px; width:200px; height: 100%; display: inline-flex; align-content: center; align-items: center; justify-content: space-between;">
                        <ul><?php echo mb_strlen(element('post_title',$prtici_row)) > 16 ? mb_substr(element('post_title',$prtici_row),0,16)."<br/>".mb_substr(element('post_title',$prtici_row),16): element('post_title',$prtici_row)."<br/> "?></ul>
                            <li>
                                <button class="bt-go" go-to-url="<?php echo base_url('post/'.element('post_id',$prtici_row))?>"><a href="javascript:void(0);"></a>GO</button>
                            </li>
                    </td>
                    <td data-th="참여CP" class="color-yellow forum_join_list"><?php echo number_format(element('cfc_cp', $prtici_row), 2)?></td>
                    <td data-th="보상예상CP" class="color-yellow forum_join_list"><?php echo number_format(element('expect_cp', $prtici_row), 2)?></td>
                    <td data-th="상세" class="detail forum_join_list">포럼마감 <?php echo display_datetime(element('frm_close_datetime', $prtici_row), 'full') ?><br>투표마감 <?php echo display_datetime(element('frm_bat_close_datetime', $prtici_row), 'full') ?></td>
                    <td data-th="참여진영" class="detail forum_join_list"><?php echo element('cfc_option',$prtici_row) == 1? 'A.' : 'B.'?> <?php echo element('pev_value', $prtici_row)?></td>
                    <td data-th="총 참여CP" class="detail forum_join_list"><?php echo number_format(element('total_cp', $prtici_row), 2)?></td>
                    <td class="shere-t"><button class="bt-share"go-to-url="<?php echo base_url('post/'.element('post_id',$prtici_row))?>" content-title="<?php echo html_escape(element('post_title',$prtici_row))?>" content-description="<?php echo mb_substr(strip_tags(element('post_content', $prtici_row)), 0,100); ?>" ><a href="javascript:void(0);"></a>공유</button></td>
                </tr>
                <?php } ?>
                </table>
                </div> <!-- 티박스 끝 -->
                </tbody>
            </div>
            <?php }?>
            <!-- 참여 리스트 Table 끝 -->

            <div class="forum-filter">
                <div class="sel-box c02">
                    <a href="javascript:void(0);" class="sel-btn"><span>포럼마감순</span></a>
                    <ul>
                        
                        <li><a href="<?php echo element('cic_forum_info.frm_close_datetime', element('sort', $view)); ?>"><span>포럼마감순</span></a></li>
                    </ul>
                </div>
                <div class="sel-box">
                    <a href="javascript:void(0);" class="sel-btn"><span>
                    <?php if(element('sorted', $view) == 'post_id') { ?>
                        최신순
                    <?php } else if(element('sorted', $view) == 'cic_forum_total_cp') { ?>
                        인기순
                    <?php } else {?>
                        최신순
                    <?php } ?>
                    </span></a>
                    <ul>
                        <li class="<?php echo element('sorted', $view) == 'post_id' ? 'active' : '' ?>"><a href="<?php echo element('post_id', element('sort', $view)); ?>"><span>최신 순</span></a></li>
                        <li class="<?php echo element('sorted', $view) == 'cic_forum_total_cp' ? 'active' : '' ?>"><a href="<?php echo element('cic_forum_total_cp', element('sort', $view)); ?>"><span>인기 순</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="list forum">
                <table>
                    <colgroup>
                        <col width="170" />
                        <col width="*" />
                        <col width="100" />
                        <col width="100" />
                        <col width="170" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th>제안자</th>
                            <th>제목</th>
                            <th>참여마감<!-- 일:시:분 단위입니다. 일 시:분 이게 나을까요??--></th>
                            <th>포럼마감<!-- 위와 마찬가지이나 마감된 포럼 리스트에서는 연.월.일 형식으로 표시되었으면 합니다.--></th>
                            <th><span class="cyellow">총 참여CP</span></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    
                    if (element('list', element('data', element('list', $view)))) {
                        foreach (element('list', element('data', element('list', $view))) as $result) {
                            // var_dump($this->db->last_query());
                            // exit;
                    ?>
                        <tr>
                            <td>
                                <div class="my-info">
                                    <p class="pimg"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', $result), 30, 30); ?>"
                                            alt="<?php echo element('mlc_title', $result); ?>"></p>
                                    <div class="tooltip popup_menuu" search_id="<?php echo html_escape(element('mem_id', $result)); ?>">
                                        <p class="rtxt">
                                            <?php echo html_escape(element('post_nickname', $result)); ?>
                                            <span class="tooltiptext" >
                                                <b>포럼 전적 <br><span><?php echo number_format(element('mem_forum_win', $result)); ?>승<?php echo number_format(element('mem_forum_lose', $result)); ?>패</span><b>
                                                <br><a href="javascript:void(0);" class="layer_link" style="padding:5px; color:#1e5fc9;"> 
                                                    작성 글 보기
                                                </a>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="l">
                                <a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('title', $result)); ?>"><?php echo html_escape(element('title', $result)); ?>
                                    <span class="reply">
                                        <?php if(element('post_comment_count', $result) != 0) {?>
                                        (<?php echo element('post_comment_count', $result); ?>)
                                    </span>
                                        <?php } ?>
                                </a>
                            </td>
                            <td><?php echo display_datetime(element('frm_bat_close_datetime', $result), 'full'); ?></td>
                            <td><?php echo display_datetime(element('frm_close_datetime', $result), 'full'); ?></td>
                            <td><p class="cyellow"><?php echo rs_number_format(element('cic_forum_total_cp', $result), 2, 0); ?></p></td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <!-- s: paging-wrap -->
            <div class="paging-wrap">
                <?php echo element('paging', element('list', $view)); ?>
            </div>
            <!-- e: paging-wrap -->
            <!-- s: board-filter -->
            <div class="board-filter sel">
                <form name="fsearch" id="fsearch" action="<?php echo current_full_url() ?>" method="get">
                    <div class="board-filter">
                        <p class="chk-select">
                            <select name="sfield">
                                <?php echo element('search_option',  element('list', $view)); ?>
                            </select>
                        </p>
                        <p class="chk-input">
                            <input type="hidden" name="type" value="<?php echo $this->input->get('type')?>"> 
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
</div>

<script>
    $(".bt-go").on('click', function(){
        let _url = $(this).attr('go-to-url');
        location.href = _url;
    });

    $(".bt-share").on('click', function(){
        let _url = $(this).attr('go-to-url');
        let _title =  $(this).attr('content-title');
        let _description =  $(this).attr('content-description');
<?php if($this->cbconfig->get_device_type() == 'mobile') {?>
        window.navigator.share({
            title: _title,
            // text: _description,
            url: _url
        });
<?php }else { ?>
        var dummy   = document.createElement("input");
        var text    = _url;
        
        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);
        alert('링크가 복사되었습니다.');
<?php }?>
    });

    $("#partici_order").on('change', function(){
        $("#partici_forum_form").submit();
    });
    $("#partici_ordertype").on('change', function(){
        $("#partici_forum_form").submit();
    })
    
    
    $(function(){
        $('.go_to_list').click(function(e){
            document.getElementById('.ftab').scrollIntoView();
        })
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
            
            $('.layer_link').prop('href', `<?php echo base_url('board/forum').(element('type', $view) == 1 ? '?type=1' : '?type=2').'&sfield=mem_id&skeyword='?>${$(this).attr('search_id')}`);
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
<style>
    .b-close{
        position:none;
        right:0;
        top:0;
    }
    .b-close_ori{
        cursor: pointer;
        position: absolute;
        right: 15px;
        top: 10px;
    }
    .close_week_p{
        cursor:pointer;
    }
</style>
<!-- 모달 팝업 -->
<div id="element_to_pop_up" style="padding:0;">
    <div class="modal-content">
        <ul class="bxslider">
                    <li style="width:auto;">
                        <div class="modal-header" style="padding:20px;">
                                <span class="header_text">진행중인 포럼</span>
                                <a class="b-close" style="font-size:25px; right:16px; top:16px;">×</a>
                        </div>
                        <div class="modal-body">
                            <p class="body-text">
                                <img src= "../../../assets/images/forum_information.jpg" style="width:300px; margin-bottom: 25px;">
                                <p class="modal_txt" style="line-height:20px; padding:15px">보유한 CP로 포럼에서 투표에 참여해보세요!<br>
                                다양한 이슈에 대해 결과를 예측하고 토론하며,<br>
                                포럼에서 승리 시 상대진영의 CP를 획득할 수 있습니다.<br></p>
                            </p>
                            <br>
                            <br>
                            <p class="close_week_p" align="center" style="background-color:orange; height:50px; display:flex;justify-content:center;align-items:center"><a href=""  name="close_week" class="close_week" style="font-weight:bold; color:white"> 다시 보지 않기</a></p>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </li>
                
                    <li style="width:auto;">
                        <div class="modal-header" style="padding:20px;">
                                    <span class="header_text">도전 포럼</span>
                                    <a class="b-close" style="font-size:25px; right:16px; top:16px;" >×</a>
                        </div>
                        <div class="modal-body">
                            <p class="body-text">
                                <img src= "../../../assets/images/forum_information.jpg" style="width:300px; margin-bottom: 25px;">
                                <p class="modal_txt" style="line-height:20px; padding:15px">보유한 CP로 포럼에서 투표에 참여해보세요!<br>
                                다양한 이슈에 대해 결과를 예측하고 토론하며,<br>
                                포럼에서 승리 시 상대진영의 CP를 획득할 수 있습니다.<br></p>
                            </p>
                            <br>
                            <br>
                            <p class="close_week_p" align="center" style="background-color:orange; height:50px; display:flex;justify-content:center;align-items:center"><a href=""  name="close_week" class="close_week" style="font-weight:bold; color:white"> 다시 보지 않기</a></p>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </li>
                    <li style="width:auto;">
                        <div class="modal-header" style="padding:20px;">
                                <span class="header_text">마감된 포럼</span>
                                <a class="b-close" style="font-size:25px; right:16px; top:16px;" >×</a>
                        </div>
                        <div class="modal-body">
                            <p class="body-text">
                                <img src= "../../../assets/images/forum_information.jpg" style="width:300px; margin-bottom: 25px;">
                                <p class="modal_txt" style="line-height:20px; padding:15px">보유한 CP로 포럼에서 투표에 참여해보세요!<br>
                                다양한 이슈에 대해 결과를 예측하고 토론하며,<br>
                                포럼에서 승리 시 상대진영의 CP를 획득할 수 있습니다.<br>
                            </p>    
                            <br>
                            <br>
                                <p class="close_week_p" align="center" style="background-color:orange; height:50px; display:flex;justify-content:center;align-items:center"><a href=""  name="close_week" class="close_week" style="font-weight:bold; color:white"> 다시 보지 않기</a></p>
                            </p>
                        </div>
                        <div class="modal-footer">
                            
                        <div class="btn-group">
                        </div>
                    </li>
                </div>
            </ul>
            </div>
    </div>
</div>
<style>
@media only screen and (max-width: 480px) {
    .modal_txt{
        font-size:7px;
        line-height:13px !important;
    }
    .close_week{
        margin-top:0px !important;
        font-size:17px;
    }
}
</style>

<script>

// 쿠키 설정 함수(modalWarning)
var setCookie = function(name, value, exp) {
var date = new Date();
date.setTime(date.getTime() + exp * 24 * 60 * 60 * 1000);
document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
};

// 쿠키 가져오기 함수(modalWarning)
var getCookie = function(name) {
var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
return value ? value[2] : null;
};

$(document).ready(function() { 
    const divTag1 = document.getElementById("btn-group");
	// $(".close_week").on('click', function() {
    //     $('#element_to_pop_up').bPopup().close();
	// 	setCookie("close_for", "close_forever", "365000"); 
	// });
    $(".close_week_p").on('click', function() {
        $('#element_to_pop_up').bPopup().close();
		setCookie("close_for", "close_forever", "365000"); 
	});

});

if(window.matchMedia("(max-width: 600px)").matches == true) {
    $(window).load( function() {
    $('.bxslider').bxSlider({
      /*mode: 'horizontal',   //버티컬,페이드 로 수정하면 됨
      moveSlides: 1,
      slideMargin: 40,
      infiniteLoop: true,
      slideWidth: 660,
      minSlides: 3,
      maxSlides: 3,
      speed: 800,
    });*/
            // auto: true,
            // autoControls: true,
            // stopAutoOnClick: true,
            controls: true,
            pager: false,
            slideWidth: 300  //화면 꽉차게 100%하려면 얘 주석처리 하면 됨
        });
  });
$( document ).ready(function() {
    let checkCookie = getCookie("close_for");

    console.log(checkCookie);
	// if(!checkCookie){
        if(false){
	$('#element_to_pop_up').bPopup({
		easing: 'easeOutBack', //uses jQuery easing plugin
    speed: 1500,
    transition: 'slideDown',
		modalClose: true,
    opacity: 0.6,
    positionStyle: 'fixed',
    position: ["10%","10%"],
	});
};
});

}else{
    $(window).load( function() {
    $('.bxslider').bxSlider({
      /*mode: 'horizontal',   //버티컬,페이드 로 수정하면 됨
      moveSlides: 1,
      slideMargin: 40,
      infiniteLoop: true,
      slideWidth: 660,
      minSlides: 3,
      maxSlides: 3,
      speed: 800,
    });*/
            // auto: true,
            // autoControls: true,
            // stopAutoOnClick: true,
            pager: false,
            slideWidth: 300  //화면 꽉차게 100%하려면 얘 주석처리 하면 됨
        });
  });


$( document ).ready(function() {
    if(<?php echo $_get_partici_ordertype && $_get_partici_order ? true : 0 ?>){
        document.getElementById('ftab').scrollIntoView();
    }

    let checkCookie = getCookie("close_for");
	// if(!checkCookie){
        if(false){
	$('#element_to_pop_up').bPopup({
		easing: 'easeOutBack', //uses jQuery easing plugin
    speed: 1500,
    transition: 'slideDown',
		modalClose: true,
    opacity: 0.6,
    positionStyle: 'fixed',
    position: ["40%","30%"],
	});
};
});
}


</script>
<script type="text/javascript">
// 글자수 제한
var char_min = parseInt(<?php echo (int) element('post_min_length', element('board', $view)); ?>); // 최소
var char_max = parseInt(<?php echo (int) element('post_max_length', element('board', $view)); ?>); // 최대

<?php if ( ! element('use_dhtml', element('board', $view)) AND (element('post_min_length', element('board', $view)) OR element('post_max_length', element('board', $view)))) { ?>

check_byte('post_content', 'char_count');
$(function() {
	$('#post_content').on('keyup', function() {
		check_byte('post_content', 'char_count');
	});
});
<?php } ?>
</script>
<style>
#element_to_pop_up {
    background-color: #fff;
    /* border-radius: 15px; */
    color: #000;
    display: none;
    padding: 20px;
}
.b-close {
    cursor: pointer;
    position: absolute;
    right: 15px;
    top: 10px;
}
.modal-header {
    height: 35px;
    /* border-bottom: 1px solid rgba(0, 0, 0, 0.2); */
}
.modal-body {
    margin-top: 20px;
}
.header_text {
    font-size: 25px;
    font-weight: bold;
}
.body-text__header {
    font-size: 18px;
    font-weight: bold;
}
.body-text {
    font-size: 15px;
}
    
                            /* 현황판 시작  */
                            
                            .table_card_view {
                                border-collapse: collapse;
                            }
                            
                            @media only screen and (max-width:768px) and (min-width:200px) {
                                .table_card_view,
                                .table_card_view thead,
                                .table_card_view tbody,
                                .table_card_view th,
                                .table_card_view td,
                                .table_card_view tr {
                                    display: block;
                                }
                                .table_card_view thead tr {
                                    position: absolute;
                                    top: -9999px;
                                    left: -9999px;
                                }
                                .table_card_view tr {
                                    border: 1px solid #ccc;
                                    margin-top: 4%;
                                    border-radius: 7px;
                                }
                                .table_card_view td {
                                    border: none;
                                    border-bottom: 0px solid #eee;
                                    position: relative;
                                    padding-left: 50%;
                                }
                                .table_card_view td:before {
                                    top: 6px;
                                    left: 6px;
                                    width: 45%;
                                    padding-right: 10px;
                                    white-space: nowrap;
                                    content: attr(data-column);
                                    color: #000;
                                    font-weight: bold;
                                }
                                #contents .value {
                                    top: -41px;
                                }
                            }
                            
                            #contents .status {
                                display: flex;
                             /* flex-wrap: wrap; */
                            /* align-content: center; */
                                justify-content: space-between;
                            }

                            #contents .status h3 {
                                font-family: "GmarketSans";
                                font-size: 32px;
                                color: #111;
                                line-height: 1.2em;
                                font-weight: 400;
                                letter-spacing: -0.03em;
                            }

                            /* #contents .forum-guide {
                                font-family: "GmarketSans";
                                font-size: 32px;
                                color: #111;
                                line-height: 1.2em;
                                font-weight: 400;
                                letter-spacing: -0.03em;
                            } */ /* 포럼 가이드 버튼 */
                            
                            #contents .conts {
                                position: relative;
                                width: calc(100% + 80px);
                                margin-left: -40px;
                                margin-bottom: 80px;
                                overflow: hidden;
                                padding: 10px 40px 10px 40px;
                                box-sizing: border-box;
                            }
                            
                            #contents .status-ray {
                                /* overflow-x: auto; */
                            }
                            
                            #contents .bac {
                                width: 100%;
                                /* min-width: 500px; */
                                background-color: #f1efeb;
                                border-radius: 4px;
                                -webkit-border-radius: 4px;
                                -moz-border-radius: 4px;
                                -ms-border-radius: 4px;
                                -o-border-radius: 4px;
                            }
                            
                            #contents .op {
                                font-weight: 500;
                                padding: 10px 46px;
                            }
                            
                            #contents .value {
                                /* font-weight: bold; */
                                /* padding-right: 70px; */
                                float: right;
                                display: inline-block;
                                width: 100px;
                            }
                            
                            #contents .top {
                                font-weight: 400;
                            }
                            
                            #contents .value P {
                                display: inline;
                                color: #feb402;
                            }
                            /* 현황판 끝 */
                            
                            @media only screen and (max-width: 1160px) {
                                .board-wrap.list .forums .cont {
                                    padding: 0 50px;
                                }
                                .board-wrap.list .forums .cont .prev {
                                    left: 20px;
                                    background-size: 16px auto;
                                }
                                .board-wrap.list .forums .cont .next {
                                    right: 20px;
                                    background-size: 16px auto;
                                }
                            }
                            
                            @media only screen and (max-width: 999px) {
                                .board-wrap.list .forums h3 {
                                    font-size: 28px;
                                }
                                .board-wrap.list .forums .cont {
                                    padding: 0 30px;
                                }
                                .board-wrap.list .forums .cont {
                                    position: relative;
                                    width: calc(100% + 30px);
                                    margin-left: -15px;
                                }
                                .board-wrap.list .forums .cont .prev {
                                    margin-top: -27px;
                                    left: 5px;
                                    background-size: 12px auto;
                                }
                                .board-wrap.list .forums .cont .next {
                                    margin-top: -27px;
                                    right: 5px;
                                    background-size: 12px auto;
                                }
                                .board-wrap.list .forums .cont .item .txt .btxt {
                                    font-size: 21px;
                                }
                                .board-wrap.list .forums .cont .item .stxt {
                                    font-size: 18px;
                                }
                                .board-wrap.list .forums .owl-dots {
                                    display: block !important;
                                    margin-top: 20px;
                                }
                            }
                            
                            @media only screen and (max-width: 680px) {
                                .board-wrap.list .forums h3 {
                                    font-size: 24px;
                                    margin-bottom: 15px;
                                }
                                .board-wrap.list .forums .cont {
                                    padding-top: 0;
                                }
                                .board-wrap.list .forums .cont {
                                    width: 100%;
                                    margin: 0;
                                }
                                .board-wrap.list .forums .cont .item .txt .btxt {
                                    font-size: 18px;
                                }
                                .board-wrap.list .forums .cont .item .stxt {
                                    font-size: 16px;
                                }
                                .board-wrap.list .forums .owl-dots {
                                    height: 6px;
                                }
                                .board-wrap.list .forums .owl-dots .owl-dot {
                                    width: 6px;
                                    height: 6px;
                                    margin: 0 2px;
                                }
                                @media only screen and (max-width: 480px) {
                                    .board-wrap.list .forums h3 {
                                        font-size: 20px;
                                    }
                                    .board-wrap.list .forums .cont {
                                        overflow: visible;
                                    }
                                    .board-wrap.list .forums .owl-stage-outer {
                                        overflow: visible;
                                    }
                                    .board-wrap.list .forums .cont .owl-item.active .ov {
                                        opacity: 1;
                                    }
                                    .board-wrap.list .forums .cont .prev {
                                        display: none;
                                    }
                                    .board-wrap.list .forums .cont .next {
                                        display: none;
                                    }
                                    #contents .status h3 {
                                        font-size: 20px;
                                        font-weight: 400;
                                    }
                                }
                                /* ======================================================
   .board-wrap.write
=========================================================*/
                                .board-wrap.write {
                                    position: relative;
                                }
                                .board-wrap.write h3 {
                                    border: 1px solid #e1e1e1;
                                    background: #f8f8f8;
                                    font-size: 19px;
                                    font-weight: 500;
                                    letter-spacing: -0.03em;
                                    padding: 17px 35px;
                                    line-height: 1em;
                                    color: #111;
                                }
                                .board-wrap.write h3 span {
                                    display: inline-block;
                                    vertical-align: top;
                                    margin-left: 15px;
                                    font-size: 14px;
                                    color: #666;
                                    font-weight: 400;
                                    line-height: 1.3em;
                                    padding-top: 2px;
                                    word-break: keep-all;
                                }
                                .board-wrap.write .entry {}
                                .board-wrap.write .entry ul {
                                    border-bottom: 1px solid #dedede;
                                }
                                .board-wrap.write .entry li {
                                    position: relative;
                                    padding: 20px;
                                    padding-left: 125px;
                                }
                                .board-wrap.write .entry li.no-pad {
                                    padding-left: 20px;
                                }
                                .board-wrap.write .entry li:nth-child(n + 2) {
                                    border-top: 1px solid #eaeaea;
                                }
                                .board-wrap.write .entry .main-check {
                                    font-size: 14px;
                                    margin-left: 14px;
                                    margin-bottom: 16px;
                                }
                                .board-wrap.write .entry .main-check label {
                                    margin-bottom: 3px;
                                }
                                .board-wrap.write .entry .main-check label p {
                                    display: inline;
                                    margin-left: 5px;
                                }
                                .board-wrap.write .entry .main-check label input[type="checkbox"] {
                                    -webkit-appearance: checkbox;
                                    vertical-align: -3px;
                                }
                                .board-wrap.write .entry .main-check label input[type="checkbox"]:before {
                                    display: none;
                                }
                                label input[type="checkbox"] {
                                    display: inline;
                                    width: 20px;
                                    height: 18px;
                                }
                                .board-wrap.write .entry li .btxt {
                                    font-size: 15px;
                                    font-weight: 500;
                                    color: #333;
                                    letter-spacing: -0.03em;
                                    line-height: 35px;
                                    position: absolute;
                                    left: 40px;
                                    top: 20px;
                                }
                                .board-wrap.write .entry li .field {}
                                .board-wrap.write .entry li .field .chk-input {
                                    position: relative;
                                }
                                .board-wrap.write .entry li .field .chk-input input {
                                    border-radius: 4px;
                                    border: 1px solid #bababa;
                                    padding: 0 10px;
                                    font-size: 14px;
                                    color: #555;
                                }
                                .board-wrap.write .entry li .field .chk-btn {
                                    width: 100px;
                                    height: 35px;
                                    line-height: 35px;
                                    border-radius: 35px;
                                    background: #555;
                                    text-align: center;
                                    font-size: 14px;
                                    font-weight: 400;
                                    letter-spacing: -0.03em;
                                    position: absolute;
                                    right: 0;
                                    top: 0;
                                    color: #fff;
                                }
                                .board-wrap.write .entry li .field .cerfity-btn {
                                    width: 100px;
                                    height: 35px;
                                    line-height: 35px;
                                    border-radius: 35px;
                                    background: #555;
                                    text-align: center;
                                    font-size: 14px;
                                    font-weight: 400;
                                    letter-spacing: -0.03em;
                                    position: absolute;
                                    right: 0;
                                    top: 0;
                                    color: #fff;
                                }
                                .board-wrap.write .entry li .field .chk-btn:hover,
                                .board-wrap.write .entry li .field .cerfity-btn:hover {
                                    background: #111;
                                }
                                .board-wrap.write .entry li .field.report {
                                    padding-left: 85px;
                                }
                                .board-wrap.write .entry li .field.report .btxt {
                                    font-size: 15px;
                                    font-weight: 500;
                                    color: #333;
                                    letter-spacing: -0.03em;
                                    line-height: 35px;
                                    position: absolute;
                                    left: 20px;
                                    top: 0;
                                }
                                .board-wrap.write .entry li .sample {}
                                .board-wrap.write .entry li .sample img {
                                    width: 100%;
                                }
                                .board-wrap.write .lower {
                                    margin-top: 30px;
                                    text-align: center;
                                    font-size: 0;
                                }
                                .board-wrap.write .lower .enter-btn {
                                    border: 0;
                                    display: inline-block;
                                    vertical-align: top;
                                    width: 200px;
                                    line-height: 40px;
                                    font-size: 15px;
                                    font-weight: 500;
                                    letter-spacing: -0.03em;
                                    color: #fff;
                                    background: #333;
                                    border-radius: 55px;
                                    text-align: center;
                                    -webkit-transition: box-shadow 0.3s ease-out, background 0.3s ease-out;
                                    -moz-transition: box-shadow 0.3s ease-out, background 0.3s ease-out;
                                    -o-transition: box-shadow 0.3s ease-out, background 0.3s ease-out;
                                    transition: box-shadow 0.3s ease-out, background 0.3s ease-out;
                                }
                                .board-wrap.write .lower .enter-btn:hover {
                                    background: #000;
                                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
                                    -webkit-box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
                                    -moz-box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
                                }
                                @media only screen and (max-width: 999px) {
                                    .board-wrap.write h3 {
                                        font-size: 17px;
                                        padding: 15px 25px;
                                    }
                                    .board-wrap.write h3 span {
                                        display: block;
                                        margin-top: 5px;
                                        margin-left: 0;
                                        font-size: 13px;
                                    }
                                    .board-wrap.write .entry li {
                                        padding: 15px;
                                    }
                                    .board-wrap.write .entry li.no-pad {
                                        padding-left: 15px;
                                    }
                                    .board-wrap.write .entry li .btxt {
                                        position: relative;
                                        left: auto;
                                        top: auto;
                                        margin-bottom: 10px;
                                        line-height: 1.1em;
                                    }
                                    .board-wrap.write .entry li .field.report {
                                        padding-left: 0;
                                    }
                                    .board-wrap.write .entry li .field.report .btxt {
                                        position: relative;
                                        left: auto;
                                        top: auto;
                                        margin-bottom: 10px;
                                        line-height: 1.1em;
                                    }
                                    .board-wrap.write .entry .thumbnail {
                                        width: 100px;
                                        height: 100px;
                                        outline: 1px dotted red;
                                    }
                                }
                                @media only screen and (min-width: 997px) {}
                                @media only screen and (max-width: 680px) {
                                    .board-wrap.write {
                                        width: calc(100% + 30px);
                                        margin-left: -15px;
                                    }
                                    .board-wrap.write h3 {
                                        font-size: 16px;
                                        padding: 15px 15px;
                                        box-sizing: border-box;
                                        border-left: 0;
                                        border-right: 0;
                                    }
                                    .board-wrap.write .entry li {
                                        padding: 15px 15px;
                                    }
                                    .board-wrap.write .entry li .btxt {
                                        font-size: 14px;
                                    }
                                    .board-wrap.write .entry li .field.report .btxt {
                                        font-size: 14px;
                                    }
                                    #contents .bac {
                                        background-color: #fff;
                                    }
                                    .table_card_view td {
                                        background-color: #f1efeb;
                                    }
                                }
                                @media only screen and (max-width: 480px) {
                                    .board-wrap.write h3 {
                                        font-size: 15px;
                                        padding: 12px 15px;
                                    }
                                    .board-wrap.write .lower {
                                        padding: 0 15px;
                                    }
                                    .board-wrap.write .lower .enter-btn {
                                        display: block;
                                        width: auto;
                                    }
                                    .board-wrap.write .lower .enter-btn {
                                        border: 0;
                                        display: inline-block;
                                        vertical-align: top;
                                        width: 200px;
                                        line-height: 40px;
                                        font-size: 15px;
                                        font-weight: 500;
                                        letter-spacing: -0.03em;
                                        color: #fff;
                                        background: #333;
                                        border-radius: 55px;
                                        text-align: center;
                                        -webkit-transition: box-shadow 0.3s ease-out, background 0.3s ease-out;
                                        -moz-transition: box-shadow 0.3s ease-out, background 0.3s ease-out;
                                        -o-transition: box-shadow 0.3s ease-out, background 0.3s ease-out;
                                        transition: box-shadow 0.3s ease-out, background 0.3s ease-out;
                                    }
                                }
                                /* ======================================================
   .price-wrap
=========================================================*/
                                .price-wrap {
                                    position: relative;
                                }
                                .price-wrap h3 {
                                    border: 1px solid #e1e1e1;
                                    background: #f8f8f8;
                                    font-size: 19px;
                                    font-weight: 500;
                                    letter-spacing: -0.03em;
                                    padding: 17px 35px;
                                    line-height: 1em;
                                    color: #111;
                                }
                                .price-wrap h3 span {
                                    display: inline-block;
                                    vertical-align: top;
                                    margin-left: 15px;
                                    font-size: 14px;
                                    color: #666;
                                    font-weight: 400;
                                    line-height: 1.3em;
                                    padding-top: 2px;
                                    word-break: keep-all;
                                }
                                .price-wrap .gap50 {
                                    height: 50px;
                                }
                                .price-wrap .lower {
                                    margin-top: 30px;
                                    text-align: center;
                                    font-size: 0;
                                    padding: 0 15px;
                                }
                                .price-wrap .lower .ex {
                                    color: #333333;
                                    font-size: 19px;
                                    font-weight: 400;
                                    letter-spacing: -0.03em;
                                    line-height: 1.3em;
                                    padding: 45px 0;
                                    word-break: keep-all;
                                }
                                .price-wrap .lower .save-btn {
                                    margin: 0 5px;
                                    display: inline-block;
                                    vertical-align: top;
                                    width: 200px;
                                    line-height: 40px;
                                    font-size: 15px;
                                    font-weight: 500;
                                    letter-spacing: -0.03em;
                                    color: #fff;
                                    background: #fcb800;
                                    border-radius: 45px;
                                    text-align: center;
                                }
                                .price-wrap .lower .refresh-btn {
                                    margin: 0 5px;
                                    display: inline-block;
                                    vertical-align: top;
                                    width: 200px;
                                    line-height: 40px;
                                    font-size: 15px;
                                    font-weight: 500;
                                    letter-spacing: -0.03em;
                                    color: #fff;
                                    background: #333;
                                    border-radius: 45px;
                                    text-align: center;
                                }
                                @media only screen and (max-width: 999px) {
                                    .price-wrap h3 {
                                        font-size: 17px;
                                        padding: 15px 25px;
                                    }
                                    .price-wrap h3 span {
                                        display: block;
                                        margin-top: 5px;
                                        margin-left: 0;
                                        font-size: 13px;
                                    }
                                    .price-wrap .lower .ex {
                                        font-size: 17px;
                                        padding: 40px 0;
                                    }
                                    .price-wrap .lower .save-btn {
                                        width: 170px;
                                    }
                                    .price-wrap .lower .refresh-btn {
                                        width: 170px;
                                    }
                                }
                                @media only screen and (max-width: 680px) {
                                    .price-wrap {
                                        width: calc(100% + 30px);
                                        margin-left: -15px;
                                    }
                                    .price-wrap h3 {
                                        font-size: 16px;
                                        padding: 15px 15px;
                                        box-sizing: border-box;
                                        border-left: 0;
                                        border-right: 0;
                                    }
                                    .price-wrap .gap50 {
                                        height: 30px;
                                    }
                                    .price-wrap .lower .ex {
                                        font-size: 15px;
                                        padding: 35px 0;
                                    }
                                    .price-wrap .lower .save-btn {
                                        width: 140px;
                                        line-height: 35px;
                                    }
                                    .price-wrap .lower .refresh-btn {
                                        width: 140px;
                                        line-height: 35px;
                                    }
                                }
                                @media only screen and (max-width: 480px) {
                                    .price-wrap h3 {
                                        font-size: 15px;
                                        padding: 12px 15px;
                                    }
                                    .price-wrap .lower .ex {
                                        font-size: 14px;
                                        padding: 25px 0;
                                    }
                                    .price-wrap .lower .save-btn {
                                        width: 110px;
                                        font-size: 14px;
                                    }
                                    .price-wrap .lower .refresh-btn {
                                        width: 110px;
                                        font-size: 14px;
                                    }
                                }
                                .price-wrap .cont {
                                    padding: 0 40px;
                                    padding-top: 30px;
                                }
                                .price-wrap .set-list {
                                    position: relative;
                                }
                                .price-wrap .set-list:after {
                                    display: block;
                                    content: "";
                                    clear: both;
                                }
                                .price-wrap .set-list .item.fl {
                                    width: 300px;
                                }
                                .price-wrap .set-list .item.fr {
                                    width: 300px;
                                }
                                .price-wrap .set-list .item.fl ul li a {
                                    max-width: 100%;
                                }
                                .price-wrap .set-list .item ul {
                                    margin-top: 15px;
                                    border: 1px solid #c9c9c9;
                                    height: 425px;
                                    box-sizing: border-box;
                                    padding: 15px 20px;
                                    border-radius: 10px;
                                    overflow-y: auto;
                                }
                                .price-wrap .set-list .item ul li {}
                                .price-wrap .set-list .item ul li:nth-child(n + 2) {
                                    margin-top: 10px;
                                }
                                .price-wrap .set-list .item ul li a {
                                    display: inline-block;
                                    vertical-align: top;
                                    line-height: 24px;
                                    color: #555;
                                    font-size: 15px;
                                    letter-spacing: -0.03em;
                                    max-width: 75%;
                                    white-space: nowrap;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                }
                                .price-wrap .set-list .item ul li a:hover,
                                .price-wrap .set-list .item ul li.active a {
                                    color: #111;
                                    font-weight: 700;
                                    text-decoration: underline;
                                }
                                .price-wrap .set-list .item ul li .delete {
                                    width: 24px;
                                    height: 24px;
                                    display: inline-block;
                                    vertical-align: top;
                                    background: url(/assets/images/price-delete.png) no-repeat center center;
                                    margin-left: 1px;
                                    border: none;
                                }
                                .price-wrap .set-list .vsel-btn {
                                    z-index: 912;
                                    position: absolute;
                                    width: 92px;
                                    height: 38px;
                                    line-height: 38px;
                                    border-radius: 4px;
                                    background: #f7ca17;
                                    text-align: center;
                                    left: 50%;
                                    top: 50%;
                                    -webkit-transform: translate(-50%, -50%);
                                    -moz-transform: translate(-50%, -50%);
                                    -ms-transform: translate(-50%, -50%);
                                    -o-transform: translate(-50%, -50%);
                                    transform: translate(-50%, -50%);
                                }
                                .price-wrap .set-list .vsel-btn span {
                                    font-size: 17px;
                                    font-weight: 500;
                                    letter-spacing: -0.03em;
                                    color: #fff;
                                    padding-right: 15px;
                                    background: url(/assets/images/price-sel.png) no-repeat right 60%;
                                    display: inline-block;
                                    vertical-align: top;
                                }
                                .price-wrap .set-list .vsel-btn:hover {
                                    background: #4d4d4d;
                                }
                                .price-wrap .set-list .up-btn {
                                    margin-left: 10px;
                                    width: 22px;
                                    height: 22px;
                                    display: inline-block;
                                    vertical-align: top;
                                    background: url(/assets/images/price-up.png) no-repeat center center;
                                    background-size: 100% auto;
                                }
                                .price-wrap .set-list .down-btn {
                                    width: 22px;
                                    height: 22px;
                                    margin-left: 6px;
                                    display: inline-block;
                                    vertical-align: top;
                                    background: url(/assets/images/price-down.png) no-repeat center center;
                                    background-size: 100% auto;
                                }
                                .price-wrap .item {
                                    position: relative;
                                    font-size: 0;
                                }
                                .price-wrap .item h4 {
                                    display: inline-block;
                                    vertical-align: top;
                                    font-size: 18px;
                                    color: #333;
                                    letter-spacing: -0.04em;
                                    line-height: 22px;
                                    padding: 0 10px;
                                }
                                .price-wrap .item.unit {
                                    margin-top: 65px;
                                }
                                .price-wrap .item.unit ul {
                                    margin-top: 15px;
                                    padding: 0 10px;
                                }
                                .price-wrap .item.unit li {}
                                .price-wrap .item.unit li:nth-child(n + 2) {
                                    margin-top: 10px;
                                }
                                .price-wrap .item.unit .chk-radio input[type="radio"]+label:before {
                                    border-color: #fcb800;
                                }
                                .price-wrap .item.unit .chk-radio input[type="radio"]:checked+label:before {
                                    border-color: #fcb800;
                                }
                                .price-wrap .item.unit .chk-radio input[type="radio"]:checked+label:after {
                                    background-color: #fcb800;
                                }
                                @media only screen and (max-width: 999px) {
                                    .price-wrap .cont {
                                        padding: 0 20px;
                                        padding-top: 20px;
                                    }
                                    .price-wrap .set-list .item.fl {
                                        width: 39.5%;
                                    }
                                    .price-wrap .set-list .item.fr {
                                        width: 39.5%;
                                    }
                                    .price-wrap .set-list .item ul {
                                        margin-top: 10px;
                                        border-radius: 5px;
                                        padding: 10px 15px;
                                        height: 400px;
                                    }
                                    .price-wrap .set-list .item ul li a {
                                        font-size: 14px;
                                    }
                                    .price-wrap .set-list .item ul li:nth-child(n + 2) {
                                        margin-top: 7px;
                                    }
                                    .price-wrap .set-list .vsel-btn {
                                        width: 80px;
                                        height: 35px;
                                        line-height: 35px;
                                    }
                                    .price-wrap .set-list .vsel-btn span {
                                        font-size: 15px;
                                    }
                                    .price-wrap .set-list .up-btn {
                                        margin-left: 10px;
                                    }
                                    .price-wrap .set-list .down-btn {
                                        margin-left: 4px;
                                    }
                                    .price-wrap .item h4 {
                                        font-size: 16px;
                                        padding: 0;
                                    }
                                    .price-wrap .item.unit {
                                        margin-top: 50px;
                                    }
                                    .price-wrap .item.unit ul {
                                        padding: 0;
                                        margin-top: 10px;
                                    }
                                }
                                @media only screen and (max-width: 680px) {
                                    .price-wrap .cont {
                                        padding: 20px 15px 0 15px;
                                    }
                                    .price-wrap .item.unit {
                                        margin-top: 35px;
                                    }
                                    .price-wrap .item h4 {
                                        font-size: 15px;
                                    }
                                    .price-wrap .set-list .vsel-btn {
                                        width: 70px;
                                        height: 32px;
                                        line-height: 32px;
                                    }
                                    .price-wrap .set-list .vsel-btn span {
                                        font-size: 14px;
                                    }
                                    .price-wrap .set-list .up-btn {
                                        width: 16px;
                                        margin-left: 5px;
                                    }
                                    .price-wrap .set-list .down-btn {
                                        margin-left: 3px;
                                        width: 16px;
                                    }
                                    .price-wrap .set-list .item ul {
                                        border-radius: 5px;
                                        padding: 5px 10px;
                                        height: 345px;
                                    }
                                    .price-wrap .set-list .item ul li a {
                                        font-size: 13px;
                                    }
                                    .price-wrap .set-list .item ul li:nth-child(n + 2) {
                                        margin-top: 4px;
                                    }
                                }
                                @media only screen and (max-width: 480px) {
                                    .price-wrap .item h4 {
                                        font-size: 14px;
                                    }
                                    .price-wrap .set-list .vsel-btn {
                                        width: 54px;
                                        height: 28px;
                                        line-height: 28px;
                                    }
                                    .price-wrap .set-list .vsel-btn span {
                                        font-size: 13px;
                                    }
                                    .price-wrap .set-list .item ul {
                                        height: 300px;
                                    }
                                    .price-wrap .set-list .item ul li a {
                                        font-size: 12px;
                                    }
                                    .price-wrap .set-list .item ul li:nth-child(n + 2) {
                                        margin-top: 1px;
                                    }
                                    .poll-wrap .cont li .OpinionB {
                                        margin-left: 30px;
                                    }
                                }
                                /* =====================================
   .poll-wrap
===================================== */
                                .poll-wrap {}
                                .poll-wrap .cont {
                                    position: relative;
                                    border: 1px solid #ccc;
                                    border-radius: 15px;
                                    padding: 112px 79px 180px;
                                }
                                .poll-wrap .cont h3 {
                                    font-size: 30px;
                                    font-weight: 700;
                                    color: #333;
                                    line-height: 1.2em;
                                    letter-spacing: -0.03em;
                                    text-align: center;
                                }
                                .poll-wrap .cont ul {
                                    background: url(/assets/images/forum-vs02.png) no-repeat center center;
                                    background-size: auto;
                                    margin-top: 40px;
                                }
                                .poll-wrap .cont ul:after {
                                    display: block;
                                    content: "";
                                    clear: both;
                                }
                                .poll-wrap .cont li {
                                    float: left;
                                    width: 50%;
                                    height: 438px;
                                    text-align: center;
                                    position: relative;
                                }
                                .poll-wrap .cont li .bar {
                                    position: absolute;
                                    left: 0;
                                    bottom: 0;
                                    width: 75px;
                                    height: 100%;
                                    background: -webkit-gradient( linear, left top, left bottom, color-stop(0, #f6f7f8), color-stop(1, #b2b2b2));
                                    background: -moz-linear-gradient(top, #f6f7f8 0%, #b2b2b2 100%);
                                    background: -webkit-linear-gradient(top, #f6f7f8 0%, #b2b2b2 100%);
                                    background: -o-linear-gradient(top, #f6f7f8 0%, #b2b2b2 100%);
                                    background: -ms-linear-gradient(top, #f6f7f8 0%, #b2b2b2 100%);
                                    background: linear-gradient(top, #f6f7f8 0%, #b2b2b2 100%);
                                    filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#f6f7f8', endColorstr='#b2b2b2', gradientType=0);
                                }
                                .poll-wrap .cont li .percent {
                                    z-index: 5;
                                    position: absolute;
                                    left: 0;
                                    bottom: 15px;
                                    width: 100%;
                                    text-align: center;
                                    font-size: 25px;
                                    font-weight: 700;
                                    color: #fff;
                                    line-height: 1em;
                                }
                                .poll-wrap .cont li .nums {
                                    z-index: 5;
                                    width: 300px;
                                    font-size: 35px;
                                    color: #2b94cc;
                                    font-weight: 700;
                                    letter-spacing: -0.02em;
                                    line-height: 1.2em;
                                    position: absolute;
                                    left: 0;
                                    top: 10px;
                                    text-align: left;
                                    box-sizing: border-box;
                                    padding-left: 40px;
                                }
                                .poll-wrap .cont li .popo {
                                    z-index: 5;
                                    width: 300px;
                                    position: absolute;
                                    left: 0;
                                    top: 210px;
                                    text-align: center;
                                    box-sizing: border-box;
                                    padding-left: 40px;
                                }
                                .poll-wrap .cont li .nums span {
                                    font-size: 20px;
                                    margin-left: 4px;
                                }
                                .poll-wrap .cont li .vbar {
                                    position: absolute;
                                    left: 0;
                                    bottom: 0;
                                    width: 100%;
                                    height: 0;
                                    -webkit-transition: height 0.3s ease-out;
                                    -moz-transition: height 0.3s ease-out;
                                    -o-transition: height 0.3s ease-out;
                                    transition: height 0.3s ease-out;
                                    background: -webkit-gradient( linear, left top, left bottom, color-stop(0, #40a7de), color-stop(1, #2666a2));
                                    background: -moz-linear-gradient(top, #40a7de 0%, #2666a2 100%);
                                    background: -webkit-linear-gradient(top, #40a7de 0%, #2666a2 100%);
                                    background: -o-linear-gradient(top, #40a7de 0%, #2666a2 100%);
                                    background: -ms-linear-gradient(top, #40a7de 0%, #2666a2 100%);
                                    background: linear-gradient(top, #40a7de 0%, #2666a2 100%);
                                    filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#40a7de', endColorstr='#2666a2', gradientType=0);
                                }
                                .poll-wrap .cont li a {
                                    position: absolute;
                                    left: 50%;
                                    bottom: -35%;
                                    width: 150px;
                                    margin-left: -75px;
                                    font-size: 20px;
                                    font-weight: 700;
                                    color: #333;
                                    letter-spacing: -0.03em;
                                    text-align: center;
                                    line-height: 26px;
                                }
                                .poll-wrap .cont li .OpinionB {
                                    margin-bottom: 8px;
                                }
                                .btnvote {
                                    margin-left: 10px;
                                    width: 95px;
                                    height: 43px;
                                    font-family: "Noto Sans KR", sans-serif;
                                    font-size: 15px;
                                    text-transform: uppercase;
                                    /* letter-spacing: 2.5px; */
                                    font-weight: 500;
                                    color: #fff;
                                    background-color: #333;
                                    border: none;
                                    /* border-radius: 45px; */
                                    box-shadow: 0px 8px 15px rgb(0 0 0 / 10%);
                                    transition: all 0.3s ease 0s;
                                    cursor: pointer;
                                    outline: none;
                                }
                                .btnvote:hover {
                                    background-color: #fff;
                                    box-shadow: 0px 15px 20px rgba(39, 39, 39, 0.274);
                                    color: #333;
                                }
                                .poll-wrap .cont li a.active {
                                    color: #2667a2;
                                }
                                .poll-wrap .cont li:nth-child(2) .bar {
                                    right: 0;
                                    left: auto;
                                }
                                .poll-wrap .cont li:nth-child(2) .popo {
                                    text-align: center;
                                    padding-left: 0;
                                    padding-right: 50px;
                                    right: 0;
                                    left: auto;
                                }
                                .poll-wrap .cont li:nth-child(2) .nums {
                                    text-align: right;
                                    padding-left: 0;
                                    padding-right: 40px;
                                    right: 0;
                                    left: auto;
                                    color: #e92955;
                                }
                                .poll-wrap .cont li:nth-child(2) .vbar {
                                    transition-delay: 0.5s;
                                    background: -webkit-gradient( linear, left top, left bottom, color-stop(0, #f05c86), color-stop(1, #e8284e));
                                    background: -moz-linear-gradient(top, #f05c86 0%, #e8284e 100%);
                                    background: -webkit-linear-gradient(top, #f05c86 0%, #e8284e 100%);
                                    background: -o-linear-gradient(top, #f05c86 0%, #e8284e 100%);
                                    background: -ms-linear-gradient(top, #f05c86 0%, #e8284e 100%);
                                    background: linear-gradient(top, #f05c86 0%, #e8284e 100%);
                                    filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#f05c86', endColorstr='#e8284e', gradientType=0);
                                }
                                .poll-wrap .cont li:nth-child(2) a.active {
                                    color: #e82850;
                                }
                                @media only screen and (max-width: 999px) {
                                    /* .poll-wrap .cont {
        padding: 50px 70px 70px 70px;
    } */
                                    .poll-wrap .cont h3 {
                                        font-size: 27px;
                                    }
                                    .poll-wrap .cont li {
                                        height: 400px;
                                    }
                                    .poll-wrap .cont li .bar {
                                        width: 70px;
                                    }
                                    .poll-wrap .cont li .nums {
                                        font-size: 28px;
                                        padding: 0;
                                    }
                                    .poll-wrap .cont li .nums span {
                                        font-size: 18px;
                                    }
                                    .poll-wrap .cont li .percent {
                                        font-size: 21px;
                                    }
                                    .poll-wrap .cont {
                                        position: relative;
                                        border: 1px solid #ccc;
                                        border-radius: 15px;
                                        padding: 112px 79px 215px;
                                    }
                                    .poll-wrap .cont li a {
                                        font-size: 20px;
                                        position: absolute;
                                        left: 50%;
                                        bottom: -47%;
                                        font-size: 22px;
                                    }
                                    .poll-wrap .cont li:nth-child(2) .nums {
                                        padding: 0;
                                    }
                                }
                                @media only screen and (max-width: 680px) {
                                    .poll-wrap .cont {
                                        padding: 40px 50px 165px 50px;
                                    }
                                    .poll-wrap .cont h3 {
                                        font-size: 23px;
                                    }
                                    .poll-wrap .cont ul {
                                        margin-top: 20px;
                                        background-image: url(/assets/images/forum-vs02.png);
                                        background-position: center;
                                        background-size: 30% auto;
                                    }
                                    .poll-wrap .cont li {
                                        height: 350px;
                                    }
                                    .poll-wrap .cont li .bar {
                                        width: 55px;
                                    }
                                    .poll-wrap .cont li .nums {
                                        font-size: 22px;
                                    }
                                    .poll-wrap .cont li .popo {
                                        z-index: 5;
                                        width: 200px;
                                        position: absolute;
                                        left: 0;
                                        top: 210px;
                                        text-align: center;
                                        box-sizing: border-box;
                                        padding-left: 40px;
                                    }
                                    .poll-wrap .cont li .tx {
                                        position: absolute;
                                        left: 50%;
                                        bottom: -17%;
                                        width: 150px;
                                        margin-left: -75px;
                                        font-size: 18px;
                                        font-weight: 700;
                                        color: #333;
                                        letter-spacing: -0.03em;
                                        text-align: center;
                                        line-height: 26px;
                                    }
                                    .poll-wrap .cont li .popo img {
                                        width: 60%;
                                        height: 100%;
                                    }
                                    .poll-wrap .cont li .nums span {
                                        font-size: 20px;
                                        margin-left: 4px;
                                    }
                                    .poll-wrap .cont li .nums span {
                                        font-size: 16px;
                                    }
                                    .poll-wrap .cont li .percent {
                                        font-size: 18px;
                                    }
                                    .poll-wrap .cont li a {
                                        font-size: 15px;
                                        line-height: 18px;
                                        bottom: -51px;
                                    }
                                }
                                @media only screen and (max-width: 480px) {
                                    .poll-wrap .cont {
                                        padding: 30px 30px 115px 30px;
                                    }
                                    .poll-wrap .cont h3 {
                                        font-size: 19px;
                                    }
                                    .poll-wrap .cont li {
                                        height: 300px;
                                    }
                                    .poll-wrap .cont li .bar {
                                        width: 35px;
                                    }
                                    .poll-wrap .cont li .nums {
                                        font-size: 18px;
                                    }
                                    .poll-wrap .cont li .popo {
                                        z-index: 5;
                                        width: 200px;
                                        position: absolute;
                                        left: 0;
                                        top: 200px;
                                        text-align: left;
                                        box-sizing: border-box;
                                        padding-left: 35px;
                                    }
                                    .poll-wrap .cont li .popo img {
                                        /* width: 50%;
        height: 100%; */
                                    }
                                    .poll-wrap .cont li:nth-child(2) .popo {
                                        text-align: right;
                                        padding-left: 10px;
                                        padding-right: 54px;
                                        right: -14px;
                                        left: auto;
                                    }
                                    /* .poll-wrap .cont li a {
        position: absolute;
        left: 50%;
        bottom: -20%;
        width: 150px;
        margin-left: -75px;
        font-size: 20px;
        font-weight: 700;
        color: #333;
        letter-spacing: -0.03em;
        text-align: center;
    } */
                                    .poll-wrap .cont li .nums span {
                                        font-size: 14px;
                                    }
                                    .poll-wrap .cont li .percent {
                                        font-size: 14px;
                                    }
                                    .poll-wrap .cont li a {
                                        font-size: 13px;
                                        line-height: 17px;
                                    }
                                    /* .poll-wrap .cont li .tx {
        position: absolute;
        left: 50%;
        bottom: -17%;
        width: 150px;
        margin-left: -75px;
        font-size: 18px;
        font-weight: 700;
        color: #333;
        letter-spacing: -0.03em;
        text-align: center;
        line-height: 26px;
    } */
                                    .poll-wrap .cont li p {
                                        width: 60%;
                                        left: 20px;
                                        padding-right: 30px;
                                        position: sticky;
                                    }
                                    .btnvote {
                                        margin-left: 10px;
                                        width: 65px;
                                        height: 34px;
                                        font-family: "Noto Sans KR", sans-serif;
                                        font-size: 13px;
                                        text-transform: uppercase;
                                        /* letter-spacing: 2.5px; */
                                        font-weight: 500;
                                        color: #fff;
                                        background-color: #333;
                                        border: none;
                                        /* border-radius: 45px; */
                                        box-shadow: 0px 8px 15px rgb(0 0 0 / 10%);
                                        transition: all 0.3s ease 0s;
                                        cursor: pointer;
                                        outline: none;
                                    }
                                    .btnvote:hover {
                                        background-color: #fff;
                                        box-shadow: 0px 15px 20px rgba(39, 39, 39, 0.274);
                                        color: #333;
                                    }
                                }
                                .poll-wrap .result {
                                    position: relative;
                                    margin-top: 40px;
                                    display: block;
                                }
                                .poll-wrap .result .btxt {
                                    line-height: 30px;
                                    font-size: 20px;
                                    font-weight: 500;
                                    letter-spacing: -0.03em;
                                    color: #333;
                                }
                                .poll-wrap .result .btxt span {
                                    font-weight: 100;
                                }
                                .poll-wrap .result .cp {
                                    line-height: 30px;
                                    font-size: 20px;
                                    font-weight: 400;
                                    letter-spacing: -0.03em;
                                    color: #333;
                                    display: inline-block;
                                    vertical-align: top;
                                    margin-right: 15px;
                                }
                                .poll-wrap .result .cp span {
                                    font-weight: 500;
                                    font-size: 30px;
                                }
                                .poll-wrap .result .abr {
                                    position: absolute;
                                    right: 0;
                                    top: 0;
                                    font-size: 0;
                                }
                                .poll-wrap .result .abr a {
                                    width: 110px;
                                    height: 30px;
                                    display: inline-block;
                                    vertical-align: top;
                                    line-height: 30px;
                                    border-radius: 30px;
                                    color: #fff;
                                    background: #000;
                                    font-size: 14px;
                                    font-weight: 500;
                                    letter-spacing: -0.03em;
                                    text-align: center;
                                }
                                .poll-wrap .result .abr a:nth-child(n + 2) {
                                    margin-left: 5px;
                                }
                                .poll-wrap .result .abr a:nth-child(3) {
                                    background: #555;
                                }
                                .poll-wrap .btns {
                                    margin-top: 40px;
                                }
                                .poll-wrap .btns .enter {
                                    display: block;
                                    line-height: 55px;
                                    font-size: 21px;
                                    text-align: center;
                                    font-weight: 500;
                                    color: #fff;
                                    background: #000;
                                    border-radius: 55px;
                                    letter-spacing: -0.03em;
                                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
                                    -webkit-box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
                                    -moz-box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
                                }
                                @media only screen and (max-width: 999px) {
                                    .poll-wrap .result .btxt {
                                        font-size: 18px;
                                    }
                                    .poll-wrap .result .cp {
                                        font-size: 18px;
                                        margin-right: 10px;
                                    }
                                    .poll-wrap .result .cp span {
                                        font-size: 25px;
                                    }
                                    .poll-wrap .result .abr a {
                                        width: 100px;
                                        height: 30px;
                                    }
                                    .poll-wrap .btns .enter {
                                        line-height: 50px;
                                        font-size: 19px;
                                    }
                                    .search-wrap.list .list.community .my-info .pimg {
                                        position: relative;
                                        right: 0;
                                        top: 5px;
                                    }
                                }
                                @media only screen and (max-width: 680px) {
                                    .poll-wrap .result {
                                        margin-top: 25px;
                                    }
                                    .poll-wrap .result .btxt {
                                        font-size: 16px;
                                    }
                                    .poll-wrap .result .cp {
                                        font-size: 16px;
                                        margin-right: 10px;
                                    }
                                    .poll-wrap .result .cp span {
                                        font-size: 20px;
                                    }
                                    .poll-wrap .result .abr a {
                                        width: 90px;
                                        height: 30px;
                                    }
                                    .poll-wrap .btns {
                                        margin-top: 25px;
                                    }
                                    .poll-wrap .btns .enter {
                                        line-height: 50px;
                                        font-size: 17px;
                                    }
                                }
                                @media only screen and (max-width: 480px) {
                                    .poll-wrap .result .btxt {
                                        font-size: 15px;
                                    }
                                    .poll-wrap .result .cp {
                                        font-size: 15px;
                                        margin-right: 5px;
                                    }
                                    .poll-wrap .result .cp span {
                                        font-size: 18px;
                                    }
                                    .poll-wrap .result .abr a {
                                        width: 80px;
                                        font-size: 13px;
                                    }
                                    .poll-wrap .btns .enter {
                                        line-height: 45px;
                                        font-size: 17px;
                                    }
                                }
                                /* =====================================
   .layer-wrap.userInfo
===================================== */
                                .layer-wrap.userInfo {
                                    position: absolute;
                                    display: none;
                                    margin-left: 20px;
                                    margin-top: 15px;
                                    left: 30px;
                                    top: 25px;
                                    width: 120px;
                                    background: #fff;
                                    box-sizing: border-box;
                                    border: 1px solid #ddd;
                                    padding: 16px 22px;
                                    box-shadow: 1px 1px 3px #999;
                                }
                                .layer-wrap.userInfo p {
                                    color: #838383;
                                    font-size: 15px;
                                    font-weight: 500;
                                    letter-spacing: -0.03em;
                                    text-align: center;
                                }
                                .layer-wrap.userInfo p span {
                                    color: #333;
                                    display: block;
                                }
                                .member-wrap.charge .entry li .explan {
                                    display: block;
                                    font-size: 13px;
                                }
                                @media only screen and (max-width: 999px) {
                                    .layer-wrap.userInfo {
                                        margin-left: 10px;
                                        top: 15px;
                                    }
                                    .layer-wrap.userInfo p {
                                        font-size: 14px;
                                    }
                                }
                                @media only screen and (max-width: 680px) {}
                                @media only screen and (max-width: 480px) {
                                    .layer-wrap.userInfo {
                                        width: 100px;
                                        padding: 10px;
                                    }
                                    .layer-wrap.userInfo p {
                                        font-size: 13px;
                                    }
                                }
                                /* 2021 06 08 구진모 추가 */
                                #captcha {
                                    float: left;
                                    padding-right: 5%;
                                }
                                #captcha_key {
                                    width: 30%;
                                    min-height: 40px;
                                    float: inherit;
                                }
                                .title-box .field .chk-input {
                                    width: 100%;
                                }
                                .popup_menuu {
                                    cursor: pointer;
                                }
                                .popupLayer {
                                    position: fixed;
                                    background-color: #ffffff;
                                    border: solid 2px #fccb17;
                                    width: auto;
                                    height: auto;
                                    padding: 3px;
                                }
                                .popupLayer div {
                                    position: fixed;
                                    top: 5px;
                                    right: 5px;
                                }
                                .title-box .field .chk-input {
                                    width: 100%;
                                }
                                .popup_menuu2 {
                                    cursor: pointer;
                                }
                                .popupLayer2 {
                                    position: fixed;
                                    background-color: #ffffff;
                                    border: solid 2px #fccb17;
                                    width: auto;
                                    height: auto;
                                    padding: 3px;
                                }
                                .popupLayer2 div {
                                    position: fixed;
                                    top: 5px;
                                    right: 5px;
                                }
                            }
                            /* Tooltip container */

.tooltip {
    position: relative;
    display: inline-block;
    /* If you want dots under the hoverable text */
}


/* Tooltip text */

.tooltip .tooltiptext {
    visibility: hidden;
    width: 100px;
    background-color: rgb(255, 255, 255);
    border: solid 1px #fccb17;
    color: black;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;
    /* Position the tooltip text */
    position: absolute;
    z-index: 1;
    bottom: -245%;
    left: 80%;
    margin-left: -60px;
    /* Fade in tooltip */
    opacity: 0;
    transition: opacity 0.3s;
    height: 60px;
    line-height: 20px;
}


/* Tooltip arrow */

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: -16%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: transparent transparent #fccb17 transparent;
    border-collapse: solid 2px #fccb17;
    height:0px;
}


/* Show the tooltip text when you mouse over the tooltip container */

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}

@media only screen and (max-width: 1000px) {
    .tooltip .tooltiptext {
        visibility: hidden;
        width: 100px;
        background-color: rgb(255, 255, 255);
        border: solid 1px #fccb17;
        color: black;
        text-align: center;
        padding: 5px 0;
        border-radius: 6px;
        /* Position the tooltip text */
        position: absolute;
        z-index: 1;
        bottom: -300% !important;
        left: 80%;
        margin-left: -60px;
        /* Fade in tooltip */
        opacity: 0;
        transition: opacity 0.3s;
    }
}
</style>