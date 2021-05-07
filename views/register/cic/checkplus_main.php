<?php
    /**************************************************************************************************************
    NICE������ Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
    
    ���񽺸� :  üũ�÷��� - �Ƚɺ������� ����
    �������� :  üũ�÷��� - ���� ȣ�� ������
    ������ ���� �����ص帮�� ������������ ���� ���� �� �������� ������ �ֽñ� �ٶ��ϴ�. 
    
    [ PHP Ȯ���� ��ġ �ȳ� ]
		1.	Php.ini ������ ���� ���� �� Ȯ���� ���(extension_dir)�� ������ ��ġ�� ÷�ε� CPClient.so ������ �����մϴ�.
		2.	Php.ini ���Ͽ� ������ ���� ������ �߰� �մϴ�.
				extension=CPClient.so
		3.	����ġ �� ���� �մϴ�.
	
	CPClient.so ����� php���� 5.2.11�� �°� �������� �Ǿ��ֽ��ϴ�.
	���� ��� ������ �ȵǽø� �����α׸� ��� �������ڿ��� �������� �ٶ��ϴ�.
    **************************************************************************************************************/
    
    /*****************************
    //����ġ���� ��� �ε尡 ���� �ʾ������ �������� ����� �ε��մϴ�.
		if(!extension_loaded('CPClient')) {
			dl('CPClient.' . PHP_SHLIB_SUFFIX);
		}
		$module = 'CPClient';
    *****************************/
    
    session_start();
    
    $sitecode = "";			// NICE�κ��� �ο����� ����Ʈ �ڵ�
    $sitepasswd = "";			// NICE�κ��� �ο����� ����Ʈ �н�����
    $authtype = "";      		// ������ �⺻ ����ȭ��, X: ����������, M: �ڵ���, C: ī��
    $popgubun 	= "N";			// Y : ��ҹ�ư ���� / N : ��ҹ�ư ����
    $customize 	= "";			// ������ �⺻ �������� / Mobile : �����������
    $gender = "";      			// ������ �⺻ ����ȭ��, 0: ����, 1: ����
    $reqseq = "REQ_0123456789";     	// ��û ��ȣ, �̴� ����/�����Ŀ� ���� ������ �ǵ����ְ� �ǹǷ�, ���� ������ ����ϰų� ��ü���� �����ϰ� �����Ͽ� ���
					
		//if (extension_loaded($module)) {// �������� ��� �ε� �������
			$reqseq = get_cprequest_no($sitecode);
		//} else {
		//	$reqseq = "Module get_request_no is not compiled into PHP";
		//}
    
    
    // CheckPlus(��������) ó�� ��, ��� ����Ÿ�� ���� �ޱ����� ���������� ���� http���� �Է��մϴ�.
    // ����url�� ���� �� ������������ ȣ���ϱ� �� url�� �����ؾ� �մϴ�. ex) ���� �� url : http://www.~ ���� url : http://www.~
    $returnurl = "http://localhost:81/php/scheckplus/php/checkplus_success.php";	// ������ �̵��� URL
    $errorurl = "http://localhost:81/php/scheckplus/php/checkplus_fail.php";		// ���н� �̵��� URL
	
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
    
    
		//if (extension_loaded($module)) {// �������� ��� �ε� �������
			$enc_data = get_encode_data($sitecode, $sitepasswd, $plaindata);
		//} else {
		//	$enc_data = "Module get_request_data is not compiled into PHP";
		//}
    $returnMsg = "";

    if( $enc_data == -1 )
    {
        $returnMsg = "��/��ȣȭ �ý��� �����Դϴ�.";
        $enc_data = "";
    }
    else if( $enc_data== -2 )
    {
        $returnMsg = "��ȣȭ ó�� �����Դϴ�.";
        $enc_data = "";
    }
    else if( $enc_data== -3 )
    {
        $returnMsg = "��ȣȭ ������ ���� �Դϴ�.";
        $enc_data = "";
    }
    else if( $enc_data== -9 )
    {
        $returnMsg = "�Է°� ���� �Դϴ�.";
        $enc_data = "";
    }
?>


<html>
<head>
	<title>NICE������ - CheckPlus �Ƚɺ������� �׽�Ʈ</title>
	
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
	��ü���� ��ȣȭ ����Ÿ : [<?= $enc_data ?>]<br><br>

	<!-- �������� ���� �˾��� ȣ���ϱ� ���ؼ��� ������ ���� form�� �ʿ��մϴ�. -->
	<form name="form_chk" method="post">
		<input type="hidden" name="m" value="checkplusService">				<!-- �ʼ� ����Ÿ��, �����Ͻø� �ȵ˴ϴ�. -->
		<input type="hidden" name="EncodeData" value="<?= $enc_data ?>">		<!-- ������ ��ü������ ��ȣȭ �� ����Ÿ�Դϴ�. -->
	    
		<a href="javascript:fnPopup();"> CheckPlus �Ƚɺ������� Click</a>
	</form>
</body>
</html>