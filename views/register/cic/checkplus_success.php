
<html>
    <head>
        <title>CIC - NICE 휴대폰 인증</title>
        <!-- <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/earlyaccess/nanumgothic.css" /> -->
        <!-- <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" /> -->
        <link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css" />
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    </head>
    <body>

    <form name="form_chk" method="post">
        <input type="hidden" name="m" value="checkplusService">				<!-- 필수 데이타로, 누락하시면 안됩니다. -->
        <input type="hidden" name="EncodeData" value="<?php echo html_escape(element('main', $view)); ?>">		<!-- 위에서 업체정보를 암호화 한 데이타입니다. -->
    </form>
        <script>
            $(document).ready(function(){
                // window.opener.location.href="register/form";
                window.opener.location.href="https://www.naver.com/";
            });

            function fnPopup(){
                window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
                document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
                document.form_chk.target = "popupChk";
                document.form_chk.submit();
            }

        </script>
    </body>
</html>
