<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* Copyright (C) NAVER <http://www.navercorp.com> */

/**
 *xpressengine 소스 참고
 */

class Checkplus extends CI_Controller
{

	private $CI;

	function __construct()
	{
		$this->CI = & get_instance();
	}

	public function main($route, $success, $fail)
	{
		//**************************************************************************************************************
		//NICE평가정보 Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
		
		//서비스명 :  체크플러스 - 안심본인인증 서비스
		//페이지명 :  체크플러스 - 메인 호출 페이지
		
		//보안을 위해 제공해드리는 샘플페이지는 서비스 적용 후 서버에서 삭제해 주시기 바랍니다.
		//방화벽 정보 : IP 121.131.196.215 , Port 80, 443     
		//**************************************************************************************************************
		
		// session_start();
		
		$sitecode = "BU370";			// NICE로부터 부여받은 사이트 코드
		$sitepasswd = "nHmB3aEoHAiK";			// NICE로부터 부여받은 사이트 패스워드
		
		// Linux = /절대경로/ , Window = D:\\절대경로\\ , D:\절대경로\
		$cb_encode_path = "/opt/bitnami/apache/ciccommunity/CPClient_64bit";
		/*
		┌ cb_encode_path 변수에 대한 설명  ──────────────────────────────────
			모듈 경로설정은, '/절대경로/모듈명' 으로 정의해 주셔야 합니다.
			
			+ FTP 로 모듈 업로드시 전송형태를 'binary' 로 지정해 주시고, 권한은 755 로 설정해 주세요.
			
			+ 절대경로 확인방법
			1. Telnet 또는 SSH 접속 후, cd 명령어를 이용하여 모듈이 존재하는 곳까지 이동합니다.
			2. pwd 명령어을 이용하면 절대경로를 확인하실 수 있습니다.
			3. 확인된 절대경로에 '/모듈명'을 추가로 정의해 주세요.
		└────────────────────────────────────────────────────────────────────
		*/
		
		$authtype = "M";      		// 없으면 기본 선택화면, X: 공인인증서, M: 핸드폰, C: 카드 (1가지만 사용 가능)
			
		$popgubun 	= "N";		//Y : 취소버튼 있음 / N : 취소버튼 없음
		$customize 	= "";		//없으면 기본 웹페이지 / Mobile : 모바일페이지 (default값은 빈값, 환경에 맞는 화면 제공)
		
		$gender = "";      		// 없으면 기본 선택화면, 0: 여자, 1: 남자
		
		$reqseq = "REQ_0123456789";     // 요청 번호, 이는 성공/실패후에 같은 값으로 되돌려주게 되므로
										// 업체에서 적절하게 변경하여 쓰거나, 아래와 같이 생성한다.
										
		// 실행방법은 싱글쿼터(`) 외에도, 'exec(), system(), shell_exec()' 등등 귀사 정책에 맞게 처리하시기 바랍니다.
		$reqseq = `$cb_encode_path SEQ $sitecode`;
		
		// CheckPlus(본인인증) 처리 후, 결과 데이타를 리턴 받기위해 다음예제와 같이 http부터 입력합니다.
		// 리턴url은 인증 전 인증페이지를 호출하기 전 url과 동일해야 합니다. ex) 인증 전 url : http://www.~ 리턴 url : http://www.~
		// $returnurl = "";	// 성공시 이동될 URL
		$returnurl = base_url($route."/".$success);	// 성공시 이동될 URL
		$errorurl = base_url($route."/".$fail);		// 실패시 이동될 URL
		
		// reqseq값은 성공페이지로 갈 경우 검증을 위하여 세션에 담아둔다.
		
		// $_SESSION["REQ_SEQ"] = $reqseq;
		$this->CI->session->set_userdata('REQ_SEQ', $reqseq);

		// 입력될 plain 데이타를 만든다.
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
			$returnMsg = "암/복호화 시스템 오류입니다.";
			$enc_data = "";
		}
		else if( $enc_data== -2 )
		{
			$returnMsg = "암호화 처리 오류입니다.";
			$enc_data = "";
		}
		else if( $enc_data== -3 )
		{
			$returnMsg = "암호화 데이터 오류 입니다.";
			$enc_data = "";
		}
		else if( $enc_data== -9 )
		{
			$returnMsg = "입력값 오류 입니다.";
			$enc_data = "";
		}

		

		return $enc_data;
	}

	public function success($EncodeData)
	{
		//EncodeData 없이 접근할 경우 차단
		if(!$EncodeData){
			exit('비정상적인 접근입니다.(1)');
		}
		//**************************************************************************************************************
		//NICE평가정보 Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
		
		//서비스명 :  체크플러스 - 안심본인인증 서비스
		//페이지명 :  체크플러스 - 결과 페이지
		
		//보안을 위해 제공해드리는 샘플페이지는 서비스 적용 후 서버에서 삭제해 주시기 바랍니다.
		//인증 후 결과값이 null로 나오는 부분은 관리담당자에게 문의 바랍니다.	
		//**************************************************************************************************************
		
		// session_start();
		
		$sitecode = "BU370";				// NICE로부터 부여받은 사이트 코드
		$sitepasswd = "nHmB3aEoHAiK";				// NICE로부터 부여받은 사이트 패스워드
		
		// Linux = /절대경로/ , Window = D:\\절대경로\\ , D:\절대경로\
		$cb_encode_path = "/opt/bitnami/apache/ciccommunity/CPClient_64bit";
			
		$enc_data = $EncodeData;		// 암호화된 결과 데이타

			//////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
		if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {echo "입력 값 확인이 필요합니다 : ".$match[0]; exit;} // 문자열 점검 추가. 
		if(base64_encode(base64_decode($enc_data))!=$enc_data) {echo "입력 값 확인이 필요합니다"; exit;}

			///////////////////////////////////////////////////////////////////////////////////////////////////////////
			

		$plaindata = `$cb_encode_path DEC $sitecode $sitepasswd $enc_data`;		// 암호화된 결과 데이터의 복호화
		// echo "[plaindata]  " . $plaindata . "<br>";
		// log_message('error', );

		if ($plaindata == -1){
			$returnMsg  = "암/복호화 시스템 오류";
		}else if ($plaindata == -4){
			$returnMsg  = "복호화 처리 오류";
		}else if ($plaindata == -5){
			$returnMsg  = "HASH값 불일치 - 복호화 데이터는 리턴됨";
		}else if ($plaindata == -6){
			$returnMsg  = "복호화 데이터 오류";
		}else if ($plaindata == -9){
			$returnMsg  = "입력값 오류";
		}else if ($plaindata == -12){
			$returnMsg  = "사이트 비밀번호 오류";
		}else{
			// 복호화가 정상적일 경우 데이터를 파싱합니다.
			$ciphertime = `$cb_encode_path CTS $sitecode $sitepasswd $enc_data`;	// 암호화된 결과 데이터 검증 (복호화한 시간획득)
		
			$requestnumber = $this->GetValue($plaindata , "REQ_SEQ");
			$responsenumber = $this->GetValue($plaindata , "RES_SEQ");
			$authtype = $this->GetValue($plaindata , "AUTH_TYPE");
			// $name =$this-> GetValue($plaindata , "NAME");
			$name = $this->GetValue($plaindata , "UTF8_NAME"); //charset utf8 사용시 주석 해제 후 사용
			$birthdate = $this->GetValue($plaindata , "BIRTHDATE");
			$gender = $this->GetValue($plaindata , "GENDER");
			$nationalinfo = $this->GetValue($plaindata , "NATIONALINFO");	//내/외국인정보(사용자 매뉴얼 참조)
			$dupinfo = $this->GetValue($plaindata , "DI");
			$conninfo = $this->GetValue($plaindata , "CI");
			$mobileno = $this->GetValue($plaindata , "MOBILE_NO");
			$mobileco = $this->GetValue($plaindata , "MOBILE_CO");

			if(strcmp($this->CI->session->userdata('REQ_SEQ'), $requestnumber) != 0)
			{
				echo "세션값이 다릅니다. 올바른 경로로 접근하시기 바랍니다.<br>";
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

		//오류사항이 있을경우 오류리턴
		if($returnMsg){
			exit("오류 :: ".$returnMsg);
		}

		$dec_data = array(
			'ciphertime' => $ciphertime,
			'requestnumber' => $requestnumber,
			'responsenumber' => $responsenumber,
			'authtype' => $authtype,
			'name' => $name,
			'birthdate' => $birthdate,
			'gender' => $gender,
			'nationalinfo' => $nationalinfo,
			'dupinfo' => $dupinfo,
			'conninfo' => $conninfo,
			'mobileno' => $mobileno,
			'mobileco' => $mobileco,
			
		);

		$this->CI->session->set_userdata('dec_data', $dec_data);
	}

	function fail($EncodeData) 
    {
        //**************************************************************************************************************
		//NICE평가정보 Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
		
		//서비스명 :  체크플러스 - 안심본인인증 서비스
		//페이지명 :  체크플러스 - 결과 페이지
		
		//보안을 위해 제공해드리는 샘플페이지는 서비스 적용 후 서버에서 삭제해 주시기 바랍니다. 
		//**************************************************************************************************************

		$sitecode = "BU370";					// NICE로부터 부여받은 사이트 코드
		$sitepasswd = "nHmB3aEoHAiK";				// NICE로부터 부여받은 사이트 패스워드
		
		// Linux = /절대경로/ , Window = D:\\절대경로\\ , D:\절대경로\
		$cb_encode_path = "/opt/bitnami/apache/ciccommunity/CPClient_64bit";
			
		$enc_data = $EncodeData;		// 암호화된 결과 데이타

			//////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
		if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {echo "입력 값 확인이 필요합니다 : ".$match[0]; exit;} // 문자열 점검 추가. 
		if(base64_encode(base64_decode($enc_data))!=$enc_data) {echo "입력 값 확인이 필요합니다"; exit;}

			///////////////////////////////////////////////////////////////////////////////////////////////////////////
			
		if ($enc_data != "") {

			$plaindata = `$cb_encode_path DEC $sitecode $sitepasswd $enc_data`;		// 암호화된 결과 데이터의 복호화
			echo "[plaindata] " . $plaindata . "<br>";

			if ($plaindata == -1){
				$returnMsg  = "암/복호화 시스템 오류";
			}else if ($plaindata == -4){
				$returnMsg  = "복호화 처리 오류";
			}else if ($plaindata == -5){
				$returnMsg  = "HASH값 불일치 - 복호화 데이터는 리턴됨";
			}else if ($plaindata == -6){
				$returnMsg  = "복호화 데이터 오류";
			}else if ($plaindata == -9){
				$returnMsg  = "입력값 오류";
			}else if ($plaindata == -12){
				$returnMsg  = "사이트 비밀번호 오류";
			}else{
				// 복호화가 정상적일 경우 데이터를 파싱합니다.
				$ciphertime = `$cb_encode_path CTS $sitecode $sitepasswd $enc_data`;	// 암호화된 결과 데이터 검증 (복호화한 시간획득)
				
				$requestnumber = GetValue($plaindata , "REQ_SEQ");
				$errcode = GetValue($plaindata , "ERR_CODE");
				$authtype = GetValue($plaindata , "AUTH_TYPE");
			}
			if($returnMsg){
				$this->CI->session->set_userdata('returnMsg', $returnMsg);
			} else{
				$this->CI->session->set_userdata('requestnumber', $requestnumber);
				$this->CI->session->set_userdata('errcode', $errcode);
				$this->CI->session->set_userdata('authtype', $authtype);
			}
		}
    }

	//********************************************************************************************
    //해당 함수에서 에러 발생 시 $len => (int)$len 로 수정 후 사용하시기 바랍니다. (하기소스 참고)
    //********************************************************************************************
    function GetValue($str , $name)
    {
        
        $pos1 = 0;  //length의 시작 위치
        $pos2 = 0;  //:의 위치

        while( $pos1 <= strlen($str) )
        {
            $pos2 = strpos( $str , ":" , $pos1);
            $len = substr($str , $pos1 , $pos2 - $pos1);
            $key = substr($str , $pos2 + 1 , (int)$len);
            $pos1 = $pos2 + (int)$len + 1;
            if( $key == $name )
            {
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $value = substr($str , $pos2 + 1 , (int)$len);
                return $value;
            }
            else
            {
                // 다르면 스킵한다.
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $pos1 = $pos2 + (int)$len + 1;
            }            
        }
    }
}
