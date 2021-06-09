<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<div id="container-wrap">
    <div id="top-vis">
        <div class="txt">
            <h2>Forum</h2>
            <p>이슈에 관련해서 투표를 진행하거나 PER 생태계에 대한 의사결정을 하며 의견을 교환할 수 있는 공간입니다. <br />포인트로 투표에 참여할 수 있으며 ‘운영정책’에 따라 지급 포인트를
                지출하거나 받게 됩니다. </p>
        </div>
        <div class="img forum"><img src="<?php echo base_url('assets/images/top-vis05.jpg')?>" alt="" /></div>
    </div>
    <div id="contents" class="div-cont">
        <!-- page start / -->

        <?php
		echo show_alert_message($this->session->flashdata('message'), '<script>alert("', '");</script>');
		// $attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		// echo form_open(current_full_url(), $attributes);
		?>
        <div class="board-wrap list">
            <div class="forums">
                <h3>진행중인 <span>BEST</span> 포럼</h3>
                <div class="cont">
                    <a href="#n" class="prev"><span class="blind">이전</span></a>
                    <div class="forum-slide">
                        
                        <?php
                        if (element('list',element('banner', $view))) {
                            foreach (element('list',element('banner', $view)) as $banner) {
                        ?>
                            <div class="item">
                            <div class="img"><img src="<?php echo element('frm_image', $banner) ? base_url('uploads/forum_banner/'.element('frm_image', $banner)) : base_url('uploads/forum_banner/2021/06/forum-img01.jpg') ?>" alt="" />
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

                        <!-- 포럼 기본 이미지 입니다. 승인대기포럼 승인시 설정된 포럼 이미지가 없을 경우 해당 기본 이미지가 보여집니다 -->
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
                                        <p class="btxt">빈 게시물 입니다 :)</p>
                                    </div>
                                    <p class="stxt">총 0 CP</p>
                                    <a href="#n"><span>참여불가!</span></a>
                                </div>
                            </div>
                        <?php }?>

                    </div>
                    <a href="#n" class="next"><span class="blind">다음</span></a>
                </div>
            </div>
            <div class="gap50"></div>
            <div class="ftab">
                <ul>
                    <li><a href="<?php echo base_url('board/forum?type=1')?>"><span>진행중 포럼</span></a></li>
                    <li class="active"><a href="<?php echo base_url('board/userforum')?>"><span>승인대기 포럼</span></a></li>
                    <li><a href="<?php echo base_url('board/forum?type=2')?>"><span>마감된 포럼</span></a></li>
                </ul>
            </div>
            <div class="gap20"></div>
            <div class="forum-filter">
                <div class="sel-box c03">
                <a href="#n" class="sel-btn"><span>
                    <?php if(element('sorted', $view) == 'post_id') { ?>
                        최신순
                    <?php } else if(element('sorted', $view) == 'post_like') { ?>
                        인기순
                    <?php } else {?>
                        최신순
                    <?php } ?>
                    </span></a>
                    <ul>
                        <li class="<?php echo element('sorted', $view) == 'post_id' ? 'active' : '' ?>"><a href="<?php echo element('post_id', element('sort', $view)); ?>"><span>최신 순</span></a></li>
                        <li class="<?php echo element('sorted', $view) == 'post_like' ? 'active' : '' ?>"><a href="<?php echo element('post_like', element('sort', $view)); ?>"><span>인기 순</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="list forum">
                <table>
                    <colgroup>
                        <col width="170" />
                        <col width="*" />
                        <col width="100" />
                        <col width="170" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th>제안자</th>
                            <th>제목</th>
                            <th>등록일</th>
                            <th><span class="cyellow">좋아요</span></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (element('list', element('data', element('list', $view)))) {
                        foreach (element('list', element('data', element('list', $view))) as $result) {
                    ?>
                        <tr>
                            <td>
                                <div class="my-info">
                                    <p class="pimg"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', $result), 30, 30); ?>"
                                            alt="<?php echo element('mlc_title', $result); ?>"></p>
                                    <p class="rtxt"><?php echo html_escape(element('post_nickname', $result)); ?></p>
                                </div>
                            </td>
                            <td class="l">
                                <a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('title', $result)); ?>"><?php echo html_escape(element('title', $result)); ?>
                                    <!-- <span class="reply">(<?php echo element('post_comment_count', $result); ?>)</span> -->
                                </a>
                            </td>
                            <td><?php echo element('display_datetime', $result); ?></td>
                            <td>
                                <p class="cyellow"><?php echo number_format(element('post_like', $result)); ?></p>
                            </td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php if(!element('is_admin', $view) && element('isMember', $view)) {?>
            <div class="lower r">
                <div class="ov">
                    <?php if (element('isDeposit', $view)) { ?>
                    <a href="#n" class="by-btn" id="deposit_subtract_confirm" data-deposit-url="<?php echo site_url(element('deposit_url', $view)); ?>" style="display:inline-block;"><span>예치금 빼기</span></a>
                    <a href="#n" class="by-btn" id="deposit_insert" style="display:none;"><span>예치금 넣기</span></a>
                    <?php }else { ?>
                    <a href="#n" class="by-btn" id="deposit_subtract_confirm" data-deposit-url="<?php echo site_url(element('deposit_url', $view)); ?>" style="display:none;"><span>예치금 빼기</span></a>
                    <a href="#n" class="by-btn" id="deposit_insert" style="display:inline-block;"><span>예치금 넣기</span></a>
                    <?php } ?>

                    <?php if (element('write_url', element('list', $view))) { ?>
                        <a href="<?php echo element('write_url', element('list', $view)); ?>" class="by-btn">글쓰기</a>
                    <?php } ?>
                    <!-- 글쓰기시 관리자가 설정한 포인트보다 적으면... alert하면 어떨까 -->
                    
                    <p class="ex-cp">보유 예치금 : <?php echo number_format(element('mem_deposit', $view)); ?> CP</p>
                </div>
            </div>
            <?php } ?>
            <!-- s: paging-wrap -->
            <div class="paging-wrap">
                <?php echo element('paging', element('list', $view)); ?>
            </div>
            <!-- e: paging-wrap -->
            <!-- s: board-filter -->
            <div class="board-filter sel">
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

            <!-- modal -->
            <div id="myModal_deposit" class="modal">
				<div class="modal-content">
					<!-- <ul class="entry modify-box"> -->
                        <table>
                            <colgroup>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>필요 예치금</th>
                                    <td><?php echo number_format(element('deposit_meta', $view), 2); ?></td>
                                </tr>
                                <tr>
                                    <th>보유 CP</th>
                                    <td><?php echo number_format(element('mem_cp', $view), 2); ?></td>
                                </tr>
                                <tr>
                                    <th>예상 잔여 CP</th>
                                    <td><?php echo number_format(element('change_cp', $view), 2); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="javascript:void(0);" id="deposit_insert_confirm"  data-type="phone" class="modify-btn" data-deposit-url="<?php echo site_url(element('deposit_url', $view)); ?>">
                            <span>확인</span>
                        </a>
					<!-- </ul> -->
				</div>
			</div>
            
        </div>
        <!-- page end / -->
    </div>
</div>

<style>

	/* The Modal (background) */
	.modal {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 1; /* Sit on top */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content/Box */
	.modal-content {
		background-color: #fefefe;
		margin: 15% auto; /* 15% from the top and centered */
		padding: 20px;
		border: 1px solid #888;
		width: 20%; /* Could be more or less, depending on screen size */                          
	}

	/* The Close Button */
	.close {
		color: #aaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}
	.close:hover,
	.close:focus {
		color: black;
		text-decoration: none;
		cursor: pointer;
	}

	.modal-btn {
		line-height: 35px;
		border-radius: 35px;
		font-size: 14px;
		color: #fff;
		background: #111;
		font-weight: 500;
		display: inline-block;
		vertical-align: top;
		margin-left: 15px;
		min-width: 120px;
		text-align: center;
		box-sizing: border-box;
	}
</style>

<script>

    // Get the modal
    var modal = document.getElementById('myModal_deposit');

    // Get the button that opens the modal
    var btn = document.getElementById("deposit_insert");

    // When the user clicks on the button, open the modal 
	btn.onclick = function() {
		modal.style.display = "block";
	}

    // When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}

    $(document).on('click', '#deposit_insert_confirm', function() {
    
        var isConfirm = confirm('선택한 요청을 정말 승인 하시겠습니까?');
        
        if(isConfirm){
        
            $.ajax({
                url: cb_url + '/deposit/insert',
                type: 'POST',
                data: {
                    csrf_test_name : cb_csrf_hash
                },
                dataType: 'json',
                async: false,
                cache: false,
                success: function(data) {
                    state = data.state;
                    message = data.message;
                    
                    
                    if(state == 1){
                        // 성공 메세지 출력
                        alert(message); 
                        location.reload(true);
                    }
                    if(state == 0){
                        // 실패 메세지 출력
                        alert(message);
                    }
                },
                error: function(){
                    alert('에러가 발생했습니다.');
                }
            });
        }
    })

    $(document).on('click', '#deposit_subtract_confirm', function() {
        
        var isConfirm = confirm('예치한 금액을 반환하시겠습니까?');
        
        if(isConfirm){
        
            $.ajax({
                url: cb_url + '/deposit/subtract',
                type: 'POST',
                data: {
                    csrf_test_name : cb_csrf_hash
                },
                dataType: 'json',
                async: false,
                cache: false,
                success: function(data) {
                    state = data.state;
                    message = data.message;
                    
                    
                    if(state == 1){
                        // 성공 메세지 출력
                        alert(message); 
                        location.reload(true);
                    }
                    if(state == 0){
                        // 실패 메세지 출력
                        alert(message);
                    }
                },
                error: function(){
                    alert('에러가 발생했습니다.');
                }
            });
        }
    })

</script>