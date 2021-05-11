
<script>
    $(document).ready(function(){
        console.log("@@@")
alert('hi1');
        window.opener.location.href="http://www.naver.com";
    });

    $(window).load(function(){
        window.self.close();
alert('hi2');
    }); 

</script>