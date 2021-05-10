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
                    <p class="chk-input"><input type="text" placeholder="검색어를 입력해주세요" autocomplete="off" name="skeyword" /></p>
                    <button class="enter"><span class="blind">검색</span></button>
                    <?php echo form_close(); ?>
                </div>
                <div class="vis">
                    <a href="#n" class="prev"><span class="blind">이전</span></a>
                    <div class="visual-slide">
                        <div class="item">
                            <a href="#n"><img src="<?php echo base_url('assets/images/visual-img01.jpg') ?>"
                                    alt="" /></a>
                        </div>
                        <div class="item">
                            <a href="#n"><img src="<?php echo base_url('assets/images/visual-img02.jpg') ?>"
                                    alt="" /></a>
                        </div>
                        <div class="item">
                            <a href="#n"><img src="<?php echo base_url('assets/images/visual-img03.jpg') ?>"
                                    alt="" /></a>
                        </div>
                        <div class="item">
                            <a href="#n"><img src="<?php echo base_url('assets/images/visual-img04.jpg') ?>"
                                    alt="" /></a>
                        </div>
                    </div>
                    <a href="#n" class="next"><span class="blind">다음</span></a>
                </div>
            </div>
        </div>
        <!-- e : msec-visual -->
        <!-- s : msec-cont -->
        <div class="msec-cont">
            <!-- s : msec-01 -->
            <div class="msec-01">
                <div class="tab">
                    <ul>
                        <li class="active"><a href="#n"><span>BTC </span></a></li>
                        <li><a href="#n"><span>ETH</span></a></li>
                        <li><a href="#n"><span>LTC</span></a></li>
                        <li><a href="#n"><span>ETC</span></a></li>
                        <li><a href="#n"><span>XLM</span></a></li>
                        <li><a href="#n"><span>klay</span></a></li>
                        <li class="cyellow"><a href="#n"><span>PER</span></a></li>
                    </ul>
                    <a href="<?php echo base_url('/Coin')?>" class="more"><span>더 많은 코인 보기</span></a>
                </div>
                <div class="list">
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
                                <th>거래금액</th>
                                <th>시세(KRW)</th>
                                <th>점유율</th>
                                <th>변동률(24h)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="vlogo">
                                        <p class="img"><img
                                                src="<?php echo base_url('assets/images/coin-logo01.png') ?>" alt="" />
                                        </p>
                                        <p class="txt">빗썸</p>
                                    </div>
                                </td>
                                <td>2,520,261,975</td>
                                <td>3,254.66</td>
                                <td>59,025.200</td>
                                <td>
                                    <p class="percent up"><span>0.06 %</span></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="vlogo">
                                        <p class="img"><img
                                                src="<?php echo base_url('assets/images/coin-logo02.png') ?>" alt="" />
                                        </p>
                                        <p class="txt">업비트 </p>
                                    </div>
                                </td>
                                <td>2,520,261,975</td>
                                <td>3,254.66</td>
                                <td>59,025.200</td>
                                <td>
                                    <p class="percent down"><span>0.06 %</span></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="vlogo">
                                        <p class="img"><img
                                                src="<?php echo base_url('assets/images/coin-logo03.png') ?>" alt="" />
                                        </p>
                                        <p class="txt">핫빗 </p>
                                    </div>
                                </td>
                                <td>2,520,261,975</td>
                                <td>3,254.66</td>
                                <td>59,025.200</td>
                                <td>
                                    <p class="percent down"><span>0.06 %</span></p>
                                </td>
                            </tr>
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
                        <div class="list">
                            <ul>
                            
                            </ul>
                        </div>
                    </div>
                    <div class="fr tab-ov">
                        <h3>실시간 인기</h3>
                        <div class="ov">
                            <div class="tab">
                                <ul>
                                    <li class="active"><a href="#n" data-tabs="#rtab01"><span>1~10위</span></a></li>
                                    <li><a href="#n" data-tabs="#rtab02"><span>11~20위</span></a></li>
                                </ul>
                            </div>
                            <div class="list tab-con" id="rtab01">
                                <ul>
                                    <li><a href="#n"><span>1</span>비트코인</a></li>
                                    <li><a href="#n"><span>2</span>코박</a></li>
                                    <li><a href="#n"><span>3</span>코인원</a></li>
                                    <li><a href="#n"><span>4</span>이더리움</a></li>
                                    <li><a href="#n"><span>5</span>로제떡볶이</a></li>
                                    <li><a href="#n"><span>6</span>지드래곤</a></li>
                                    <li><a href="#n"><span>7</span>YG</a></li>
                                    <li><a href="#n"><span>8</span>불구속심사</a></li>
                                    <li><a href="#n"><span>9</span>클레이튼</a></li>
                                    <li><a href="#n"><span>10</span>CIC</a></li>
                                </ul>
                            </div>
                            <div class="list tab-con hide" id="rtab02">
                                <ul>
                                    <li><a href="#n"><span>11</span>비트코인</a></li>
                                    <li><a href="#n"><span>12</span>코박</a></li>
                                    <li><a href="#n"><span>13</span>코인원</a></li>
                                    <li><a href="#n"><span>14</span>이더리움</a></li>
                                    <li><a href="#n"><span>15</span>로제떡볶이</a></li>
                                    <li><a href="#n"><span>16</span>지드래곤</a></li>
                                    <li><a href="#n"><span>17</span>YG</a></li>
                                    <li><a href="#n"><span>18</span>불구속심사</a></li>
                                    <li><a href="#n"><span>19</span>클레이튼</a></li>
                                    <li><a href="#n"><span>20</span>CIC</a></li>
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
                        <div class="item">
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
                        </div>
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
                            <a href="#n">
                                <p class="desktop"><img src="<?php echo base_url('assets/images/use-img01.png') ?>"
                                        alt="" /></p>
                                <p class="mobile"><img src="<?php echo base_url('assets/images/use-img01m.jpg') ?>"
                                        alt="" /></p>
                            </a>
                        </li>
                        <li>
                            <a href="#n">
                                <p class="desktop"><img src="<?php echo base_url('assets/images/use-img02.png') ?>"
                                        alt="" /></p>
                                <p class="mobile"><img src="<?php echo base_url('assets/images/use-img02m.jpg') ?>"
                                        alt="" /></p>
                            </a>
                        </li>
                        <li>
                            <a href="#n">
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
</script>