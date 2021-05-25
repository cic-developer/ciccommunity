<div id="container-wrap">
    <div id="contents" class="div-cont">
        <!-- page start // -->
        <div class="member-wrap charge">
            <h3>충전하기</h3>
            <div class="entry">
                <ul>
                    <li>
                    <!-- 
                        충전하기 클릭시 카이카스라는 확장 프로그램이 실행되게끔 해놓으려고 합니다. 
                        이때 확인 누르면 나오는 결과값을 가지고 충전여부를 판단, 데이터베이스에 넣으시면 됩니다.
                    -->
                        <p class="btxt">충전액</p>
                        <div class="field draw">
                            <p class="chk-input w210">
                                <input type="text" placeholder="금액을 입력해주세요." value="">
                            </p>
                            <p class="ctxt">CP</p>
                            <a href="#n" class="draw-btn"><span>충전하기</span></a>
                        </div>
                        <!-- 아래 100CP는, 메인페이지 거래소 가격 해서 1PER 당 n CP(CP는 100원) 비율로 나타냈으면 합니다. -->
                        <div class="explan">1 PER 당 &rarr;<p style="display:inline;"> 100 CP 입니다.</p></div>
                    </li>
                </ul>
            </div>
            <div class="gap50"></div>
            <h3 class="no-mgt">충전요청현황</h3>
            <div class="list">
                <table>
                    <colgroup>
                        <col width="25%">
                        <col width="25%">
                        <col width="25%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>충전 신청일</th>
                            <th>사용 PER</th>
                            <th>충전한 CP 금액</th>
                            <th>상태</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2021. 03. 21</td>
                            <td>20 PER</td>
                            <td>200,000 CP</td>
                            <td>
                                <p class="cblue">완료</p>
                            </td>
                        </tr>
                        <tr>
                            <td>2021. 03. 21</td>
                            <td>20 PER</td>
                            <td>200,000 CP</td>
                            <td>
                                <p class="cred">취소</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- 페이지네이션 가능하면 부탁드립니다. -->
            </div>
        </div>
        <!-- page end // -->
    </div>
</div>

<script>
    $(document).on('ready', function(){
        if(window.klaytn === undefined) {
            alert('Klaytn Kaikas가 설치되지 않았습니다.\nKlaytn Kaikas을 설치하여 주세요');
            location.href="https://m.blog.naver.com/PostView.naver?blogId=djg162&logNo=222063902504&proxyReferer=https:%2F%2Fwww.google.com%2F";
        }
    });
</script>