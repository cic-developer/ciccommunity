<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<div id="container-wrap">
    <div id="contents" class="div-cont no-padt">
        <!-- page start // -->
        <div class="member-wrap mypage">
            <div class="myinfo">
                <div class="fl">
                    <div class="photo" title="프로필 이미지"><img src="<?php echo base_url('assets/images/mypage-photo.png')?>" alt="">
                </div>
                    <div class="my">
                        <p class="btxt" alt="name" title = "이름"> <?=$member['mem_username']?> </p>
                        <p class="stxt" title = "text">(<?=$member['mem_nickname']?>)</p>
                        <a href="<?php echo base_url('/membermodify/modify')?>" class="modify-btn"><span>수정</span></a>
                    </div>

                    <div class="state">
                        <ul>
                            <li>
                                <p> <?= $member['mem_email'] ?> </p>
                            </li>
                            <li>
                                <p> <?= $member['mem_phone'] ?></p>
                            </li>
                            <li>
                                <p class="point"><?= number_format($member['mem_point']) ?></p>   
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="fr">
                    <ul>
                        <li>
                            <p> <?= number_format($member['mem_cp'],2) ?></p>
                        </li>
                        <li>
                            <p> <?= number_format($member['mem_vp']) ?></p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mycic">
                <h3>MY CIC</h3>
                <ul>
                    <li>
                        <div class="txt">
                            <p class="btxt">출석체크 <span>하기</span></p>
                            <p class="stxt">소중한 내 VP! <br>출석체크 하고 <span>VP 보상</span> 받자 </p>
                            <a href="/attendance"><span>바로가기</span></a>
                        </div>
                    </li>
                    <li>
                        <div class="txt">
                            <p class="btxt">CP <span>충전하기</span></p>
                            <p class="stxt">디지털 자산으로 <span>충전</span>! <br>건전한 커뮤니티 이용하기 </p>
                            <a href="<?php echo base_url('mypage/charge')?>"><span>바로가기</span></a>
                        </div>
                    </li>
                    <li>
                        <div class="txt">
                            <p class="btxt">CP <span>출금하기</span></p>
                            <p class="stxt">PER 교환하기!</p>
                            <a href="<?php echo base_url('mypage/withdraw')?>"><span>바로가기</span></a>
                        </div>
                    </li>
                    <li>
                        <div class="txt">
                            <p class="btxt">기록 <span>모아보기</span></p>
                            <p class="stxt">내가 행사 한 <span>VP, <br>댓글</span> 보기</p>
                            <a href="<?php echo base_url('mypage/post')?>"><span>바로가기</span></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- page end // -->
    </div>
</div>