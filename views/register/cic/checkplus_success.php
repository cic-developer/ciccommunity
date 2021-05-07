<?php
    //**************************************************************************************************************
    //NICE������ Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
    
    //���񽺸� :  üũ�÷��� - �Ƚɺ������� ����
    //�������� :  üũ�÷��� - ��� ������
    
    //������ ���� �����ص帮�� ������������ ���� ���� �� �������� ������ �ֽñ� �ٶ��ϴ�. 
    //���� �� ������� null�� ������ �κ��� ��������ڿ��� ���� �ٶ��ϴ�.
    //**************************************************************************************************************
    
    session_start();
	
    /*****************************
	  //����ġ���� ��� �ε尡 ���� �ʾ������ �������� ����� �ε��մϴ�.
	  if(!extension_loaded('CPClient')) {
	  	dl('CPClient.' . PHP_SHLIB_SUFFIX);
	  }
	  $module = 'CPClient';
    *****************************/
	
    $sitecode = "";				// NICE�κ��� �ο����� ����Ʈ �ڵ�
    $sitepasswd = "";				// NICE�κ��� �ο����� ����Ʈ �н�����
    
    
    $enc_data = $_REQUEST["EncodeData"];	// ��ȣȭ�� ��� ����Ÿ

		//////////////////////////////////////////////// ���ڿ� ����///////////////////////////////////////////////
    if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {echo "�Է� �� Ȯ���� �ʿ��մϴ� : ".$match[0]; exit;} // ���ڿ� ���� �߰�. 
    if(base64_encode(base64_decode($enc_data))!=$enc_data) {echo "�Է� �� Ȯ���� �ʿ��մϴ�"; exit;}
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		
    if ($enc_data != "") {

	//if (extension_loaded($module)) {// �������� ��� �ε� �������
		$plaindata = get_decode_data($sitecode, $sitepasswd, $enc_data);// ��ȣȭ�� ��� �������� ��ȣȭ
	//} else {
		//$plaindata = "Module get_response_data is not compiled into PHP";
	//}
        
        echo "[plaindata]  " . $plaindata . "<br>";

        if ($plaindata == -1){
            $returnMsg  = "��/��ȣȭ �ý��� ����";
        }else if ($plaindata == -4){
            $returnMsg  = "��ȣȭ ó�� ����";
        }else if ($plaindata == -5){
            $returnMsg  = "HASH�� ����ġ - ��ȣȭ �����ʹ� ���ϵ�";
        }else if ($plaindata == -6){
            $returnMsg  = "��ȣȭ ������ ����";
        }else if ($plaindata == -9){
            $returnMsg  = "�Է°� ����";
        }else if ($plaindata == -12){
            $returnMsg  = "����Ʈ ��й�ȣ ����";
        }else{
            // ��ȣȭ�� �������� ��� �����͸� �Ľ��մϴ�.
              
            $requestnumber = GetValue($plaindata , "REQ_SEQ");
            $responsenumber = GetValue($plaindata , "RES_SEQ");
            $authtype = GetValue($plaindata , "AUTH_TYPE");
            $name = GetValue($plaindata , "NAME");
            //$name = GetValue($plaindata , "UTF8_NAME"); //charset utf8 ���� �ּ� ���� �� ���
            $birthdate = GetValue($plaindata , "BIRTHDATE");
            $gender = GetValue($plaindata , "GENDER");
            $nationalinfo = GetValue($plaindata , "NATIONALINFO");	//��/�ܱ�������(����� �Ŵ��� ����)
            $dupinfo = GetValue($plaindata , "DI");
            $conninfo = GetValue($plaindata , "CI");
	    $mobileno = GetValue($plaindata , "MOBILE_NO");
            $mobileco = GetValue($plaindata , "MOBILE_CO");

            if(strcmp($_SESSION["REQ_SEQ"], $requestnumber) != 0)
            {
            	echo "���ǰ��� �ٸ��ϴ�. �ùٸ� ��η� �����Ͻñ� �ٶ��ϴ�.<br>";
                $requestnumber = "";
                $responsenumber = "";
                $authtype = "";
                $name = "";
            	$birthdate = "";
            	$gender = "";
            	$nationalinfo = "";
            	$dupinfo = "";
            	$conninfo = "";
            	$mobileno = "";
            	$mobileco = "";
            }
        }
    }
?>

<?
    function GetValue($str , $name) //�ش� �Լ����� ���� �߻� �� $len => (int)$len �� ���� �� ����Ͻñ� �ٶ��ϴ�.
    {
        $pos1 = 0;  //length�� ���� ��ġ
        $pos2 = 0;  //:�� ��ġ

        while( $pos1 <= strlen($str) )
        {
            $pos2 = strpos( $str , ":" , $pos1);
            $len = substr($str , $pos1 , $pos2 - $pos1);
            $key = substr($str , $pos2 + 1 , $len);
            $pos1 = $pos2 + $len + 1;
            if( $key == $name )
            {
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $value = substr($str , $pos2 + 1 , $len);
                return $value;
            }
            else
            {
                // �ٸ��� ��ŵ�Ѵ�.
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $pos1 = $pos2 + $len + 1;
            }            
        }
    }
?>

<html>
<head>
    <title>NICE������ - CheckPlus �������� �׽�Ʈ</title>
</head>
<body>
    <center>
    <p><p><p><p>
    ���������� �Ϸ� �Ǿ����ϴ�.<br>
    <table border=1>

        <tr>
            <td>��û ��ȣ</td>
            <td><?= $requestnumber ?></td>
        </tr>            
        <tr>
            <td>���������� ��ȣ</td>
            <td><?= $responsenumber ?></td>
        </tr>            
        <tr>
            <td>��������</td>
            <td><?= $authtype ?></td>
        </tr>
        <tr>
            <td>����</td>
            <td><?= $name ?></td>
        </tr>
        <tr>
            <td>�������(YYYYMMDD)</td>
            <td><?= $birthdate ?></td>
        </tr>
        <tr>
            <td>����</td>
            <td><?= $gender ?></td>
        </tr>
        <tr>
            <td>��/�ܱ�������</td>
            <td><?= $nationalinfo ?></td>
        </tr>
        <tr>
            <td>DI(64 byte)</td>
            <td><?= $dupinfo ?></td>
        </tr>
        <tr>
            <td>CI(88 byte)</td>
            <td><?= $conninfo ?></td>
        </tr>
        <tr>
	    <td>�޴�����ȣ</td>
            <td><?= $mobileno ?></td>
        </tr>
		<tr>
			<td>��Ż�</td>
			<td><?= $mobileco ?></td>
        </tr>
		<tr>
			<td colspan="2">���� �� ������� ���� ������ ���� ���� ���Ϲ����� �� �ֽ��ϴ�. <br>
			�Ϻ� ������� null�� ���ϵǴ� ��� ��������� �Ǵ� ���μ�(02-2122-4615)�� ���ǹٶ��ϴ�.</td>
		</tr>
    </table>
    </center>
</body>
</html>
