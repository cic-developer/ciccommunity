<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<div id="container-wrap">
    <div id="contents" class="div-cont no-padt">
        <!-- page start // -->
        <div class="member-wrap mypage">
        <?php
        echo show_alert_message($this->session->flashdata('message'), '<script>alert("', '");</script>');
        ?>
            <div class="myinfo">
                <div class="fl">
                    <div class="photo" title="프로필 이미지">
                    <img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', $member), 140, 140); ?>" alt="">
                    <!-- <img src="<?php //echo base_url('assets/images/popotest.png')?>" alt=""> -->
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
                            <p class="recomm">추천인 코드</p> 
                            <input id="respon_wallet" type="text" readonly="" value="<?= element('mem_userid', $member) ?>">
                            <button type="button" class="copyButton" onclick="copyToClipboard('<?= base_url('r/'.element('mem_userid', $member)) ?>')">링크 복사</button>
                            </li>
                            <!-- <li>
                                <p class="point"><?php //echo number_format($member['mem_point']) ?></p>   
                            </li> -->
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
                            <p class="btxt">내 활동 <span>내역보기</span></p>
                            <!-- <p class="stxt">내가 행사 한 <span>VP, <br>댓글</span> 보기</p> -->
                            <p class="stxt"><span>CIC COMMUNITY</span>에서 활동한<br/>모든 기록 확인</p>
                            <a href="<?php echo base_url('mypage/post')?>"><span>바로가기</span></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- page end // -->
    </div>
</div>
<script>
    function copyToClipboard(val) {
        const t = document.createElement("textarea");
        document.body.appendChild(t);
        t.value = val;
        t.select();
        document.execCommand('copy');
        document.body.removeChild(t);
        alert('복사되었습니다.')
    }
</script>