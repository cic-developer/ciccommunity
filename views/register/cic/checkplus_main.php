<?php
    //**************************************************************************************************************
    //NICE������ Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
    
    //���񽺸� :  üũ�÷��� - �Ƚɺ������� ����
    //�������� :  üũ�÷��� - ���� ȣ�� ������
    
    //������ ���� �����ص帮�� ������������ ���� ���� �� �������� ������ �ֽñ� �ٶ��ϴ�.
    //��ȭ�� ���� : IP 121.131.196.215 , Port 80, 443     
    //**************************************************************************************************************
    
    session_start();
    
    $sitecode = "BU370";			// NICE�κ��� �ο����� ����Ʈ �ڵ�
    $sitepasswd = "nHmB3aEoHAiK";			// NICE�κ��� �ο����� ����Ʈ �н�����
    
    // Linux = /������/ , Window = D:\\������\\ , D:\������\
    $cb_encode_path = "/home/bitnami/dev_ciccommunity/CPClient_64bit";
	/*
	�� cb_encode_path ������ ���� ����  ��������������������������������������������������������������������
		��� ��μ�����, '/������/����' ���� ������ �ּž� �մϴ�.
		
		+ FTP �� ��� ���ε�� �������¸� 'binary' �� ������ �ֽð�, ������ 755 �� ������ �ּ���.
		
		+ ������ Ȯ�ι��
		  1. Telnet �Ǵ� SSH ���� ��, cd ���ɾ �̿��Ͽ� ����� �����ϴ� ������ �̵��մϴ�.
		  2. pwd ���ɾ��� �̿��ϸ� �����θ� Ȯ���Ͻ� �� �ֽ��ϴ�.
		  3. Ȯ�ε� �����ο� '/����'�� �߰��� ������ �ּ���.
	������������������������������������������������������������������������������������������������������������������������������������������
	*/
    
    $authtype = "";      		// ������ �⺻ ����ȭ��, X: ����������, M: �ڵ���, C: ī�� (1������ ��� ����)
    	
    $popgubun 	= "N";		//Y : ��ҹ�ư ���� / N : ��ҹ�ư ����
    $customize 	= "";		//������ �⺻ �������� / Mobile : ����������� (default���� ��, ȯ�濡 �´� ȭ�� ����)
    
    $gender = "";      		// ������ �⺻ ����ȭ��, 0: ����, 1: ����
	
    $reqseq = "REQ_0123456789";     // ��û ��ȣ, �̴� ����/�����Ŀ� ���� ������ �ǵ����ְ� �ǹǷ�
                                    // ��ü���� �����ϰ� �����Ͽ� ���ų�, �Ʒ��� ���� �����Ѵ�.
									
    // �������� �̱�����(`) �ܿ���, 'exec(), system(), shell_exec()' ��� �ͻ� ��å�� �°� ó���Ͻñ� �ٶ��ϴ�.
    $reqseq = `$cb_encode_path SEQ $sitecode`;
    
    // CheckPlus(��������) ó�� ��, ��� ����Ÿ�� ���� �ޱ����� ���������� ���� http���� �Է��մϴ�.
    // ����url�� ���� �� ������������ ȣ���ϱ� �� url�� �����ؾ� �մϴ�. ex) ���� �� url : http://www.~ ���� url : http://www.~
    $returnurl = "https://dev.ciccommunity.com/checkplus_success";	// ������ �̵��� URL
    $errorurl = "https://dev.ciccommunity.com/checkplus_fail";		// ���н� �̵��� URL
	
    // reqseq���� ������������ �� ��� ������ ���Ͽ� ���ǿ� ��Ƶд�.
    
    $_SESSION["REQ_SEQ"] = $reqseq;

    // �Էµ� plain ����Ÿ�� �����.
    $plaindata = "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
				 "8:SITECODE" . strlen($sitecode) . ":" . $sitecode .
				 "9:AUTH_TYPE" . strlen($authtype) . ":". $authtype .
				 "7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
				 "7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
				 "11:POPUP_GUBUN" . strlen($popgubun) . ":" . $popgubun .
				 "9:CUSTOMIZE" . strlen($customize) . ":" . $customize .
				 "6:GENDER" . strlen($gender) . ":" . $gender ;
    
    $enc_data = `$cb_encode_path ENC $sitecode $sitepasswd $plaindata`;

    $returnMsg = "";

    if( $enc_data == -1 )
    {
        $returnMsg = "암호화 시스템 오류.";
        $enc_data = "";
    }
    else if( $enc_data== -2 )
    {
        $returnMsg = "암호화 처리 오류 .";
        $enc_data = "";
    }
    else if( $enc_data== -3 )
    {
        $returnMsg = "암호화 데이터 오류 .";
        $enc_data = "";
    }
    else if( $enc_data== -9 )
    {
        $returnMsg = "입력 정보 오류 .";
        $enc_data = "";
    }
?>


<html>
<head>
	<title>NICE인증 - CheckPlus테스트</title>
	
	<script language='javascript'>
	window.name ="Parent_window";
	
	function fnPopup(){
		window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
		document.form_chk.target = "popupChk";
		document.form_chk.submit();
	}
	</script>
</head>
<body>
	<?= $returnMsg ?><br><br>
	enc_data: [<?= $enc_data ?>]<br><br>

	<!-- �������� ���� �˾��� ȣ���ϱ� ���ؼ��� ������ ���� form�� �ʿ��մϴ�. -->
	<form name="form_chk" method="post">
		<input type="hidden" name="m" value="checkplusService">				<!-- �ʼ� ����Ÿ��, �����Ͻø� �ȵ˴ϴ�. -->
		<input type="hidden" name="EncodeData" value="<?= $enc_data ?>">		<!-- ������ ��ü������ ��ȣȭ �� ����Ÿ�Դϴ�. -->
	    
		<a href="javascript:fnPopup();"> CheckPlus 테스트 Click</a>
	</form>
</body>
</html>