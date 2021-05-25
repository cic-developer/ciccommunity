<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- <meta name="viewport" content="width=1180"> -->
<title><?php echo html_escape(element('page_title', $layout)); ?></title>
<?php if (element('meta_description', $layout)) { ?><meta name="description" content="<?php echo html_escape(element('meta_description', $layout)); ?>"><?php } ?>
<?php if (element('meta_keywords', $layout)) { ?><meta name="keywords" content="<?php echo html_escape(element('meta_keywords', $layout)); ?>"><?php } ?>
<?php if (element('meta_author', $layout)) { ?><meta name="author" content="<?php echo html_escape(element('meta_author', $layout)); ?>"><?php } ?>
<?php if (element('favicon', $layout)) { ?><link rel="shortcut icon" type="image/x-icon" href="<?php echo element('favicon', $layout); ?>" /><?php } ?>
<?php if (element('canonical', $view)) { ?><link rel="canonical" href="<?php echo element('canonical', $view); ?>" /><?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0 ,maximum-scale=1.0, minimum-scale=1.0,user-scalable=no,target-densitydpi=medium-dpi">
<!------------------------------------------ 퍼블리싱 영역 files --------------------------------------------------->
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/styleDefault.css" />
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/layout.css" />
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/content.css" />

<?php echo $this->managelayout->display_css(); ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery/jquery-1.11.3.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery/jquery.easing.1.3.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery/datepicker.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery/datepicker.kor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/topmenu.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/common.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/layout.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/sub.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery/slick.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery/owl.carousel.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery/popup.js'); ?>"></script>

<link rel="stylesheet" href="<?php echo base_url('assets/js/css/animate.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/js/css/owl.carousel.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/js/css/slick-theme.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/js/css/slick.css'); ?>">

<!------------------------------------------------------------------------------------------------------------------>

<script type="text/javascript">
// 자바스크립트에서 사용하는 전역변수 선언
var cb_url = "<?php echo trim(site_url(), '/'); ?>";
var cb_cookie_domain = "<?php echo config_item('cookie_domain'); ?>";
var cb_charset = "<?php echo config_item('charset'); ?>";
var cb_time_ymd = "<?php echo cdate('Y-m-d'); ?>";
var cb_time_ymdhis = "<?php echo cdate('Y-m-d H:i:s'); ?>";
var layout_skin_path = "<?php echo element('layout_skin_path', $layout); ?>";
var view_skin_path = "<?php echo element('view_skin_path', $layout); ?>";
var is_member = "<?php echo $this->member->is_member() ? '1' : ''; ?>";
var is_admin = "<?php echo $this->member->is_admin(); ?>";
var cb_admin_url = <?php echo $this->member->is_admin() === 'super' ? 'cb_url + "/' . config_item('uri_segment_admin') . '"' : '""'; ?>;
var cb_board = "<?php echo isset($view) ? element('board_key', $view) : ''; ?>";
var cb_board_url = <?php echo ( isset($view) && element('board_key', $view)) ? 'cb_url + "/' . config_item('uri_segment_board') . '/' . element('board_key', $view) . '"' : '""'; ?>;
var cb_device_type = "<?php echo $this->cbconfig->get_device_type() === 'mobile' ? 'mobile' : 'desktop' ?>";
var cb_csrf_hash = "<?php echo $this->security->get_csrf_hash(); ?>";
var cookie_prefix = "<?php echo config_item('cookie_prefix'); ?>";

// 지갑 입출금을 위한 변수 선언 지우면 안됩니다.//

</script>

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.extension.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/sideview.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/js.cookie.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/caver.js'); ?>"></script>
<?php echo $this->managelayout->display_js(); ?>

</head>
<body <?php echo isset($view) ? element('body_script', $view) : ''; ?>>
    <div id="doc" class="sub">
        <header id="header-wrap">
        <div id="header">
			
			<div class="gnb desktop search">	
				<ul class="member">
                    <?php if($this->member->is_member()){ ?>
                        <li><a href="<?php echo base_url('/mypage')?>" class="mypage-btn"><span>MY PAGE</span></a></li>
                        <li><a href="<?php echo site_url('login/logout?url=' . urlencode(current_full_url())); ?>"
                            class="login-btn"><span>LOGOUT</span></a></li>
                    <?php }else{ ?>
                        <li><a href="<?php echo base_url('/register')?>" class="mypage-btn"><span>SIGN UP</span></a></li>
                        <li><a href="<?php echo site_url('login?url=' . urlencode(current_full_url())); ?>"
                            class="login-btn"><span>LOGIN</span></a></li>
                    <?php }?>
				</ul>
				<!-- <ul class="language">
					<li class="active"><a href="#n"><span>KOR</span></a></li>
					<li><a href="#n"><span>ENG</span></a></li>
				</ul>
				<a href="#n" class="plus"><span class="blind">+</span></a> -->
			</div>
			<div class="inner">
				<h1 id="logo"><a href="/"><span class="blind">cic+community</span></a></h1>
				<a href="#n" class="bt-mnall"><span class="blind">메뉴</span></a>
				<a href="#n" class="bt-mnclose"><span class="blind">메뉴닫기</span></a>
				<a href="#n" class="bt-search"><span class="blind">검색</span></a>
				<div class="top-search">
					<?php 
						$attributes = array('class' => 'search_box', 'name' => 'searchForm', 'id' => 'searchForm', 'method' => 'get');
						echo form_open(base_url('/search'), $attributes);
					?>
					<div class="ov">
						<p class="chk-input"><input type="text" placeholder="" autocomplete="off" name="skeyword"></p>
						<button class="enter"><span class="blind">검색</span></button>
						<!-- <a href="#n" class="close search-close"><span class="blind">검색</span></a> -->
					</div>
					<?php echo form_close();?>
				</div>
				<!-- s: mainNavi-wrap -->
				<div id="mainNavi-wrap" style="height: 66px;"><div class="ovbar" style="width: 0px; left: 0px;"></div>
					<div id="mainNavi">
						<div class="tm-top">
							<h2><span class="blind">cic+community</span></h2>
						</div>
						<div class="gnb mobile">	
							<ul class="member">
								<li><a href="#n" class="mypage-btn"><span>MY PAGE</span></a></li>
								<li><a href="#n" class="login-btn"><span>LOGIN</span></a></li>
							</ul>
						</div>
						<ul class="topmenu" id="topmenu">
							<li class="mn_l1 has-sub is-cloose" style="width: auto;">
								<a href="<?php echo base_url('/board/freetalk')?>" class="mn_a1"><span>자유게시판</span></a>
								<div class="depth2-wrap" style="display: block; visibility: visible; height: 45px; opacity: 1; overflow: hidden;">
								</div>
							</li>
							<li class="mn_l1 has-sub is-cloose" style="width: auto;">
								<a href="<?php echo base_url('/board/cicwriter')?>" class="mn_a1"><span>WRITER</span></a>
								<div class="depth2-wrap" style="display: block; visibility: visible; height: 0px; opacity: 1; overflow: hidden;">
								</div>
							</li>
							<li class="mn_l1 has-sub is-cloose" style="width: auto;">
								<a href="#n" class="mn_a1"><span>코인헬퍼</span></a>
								<div class="depth2-wrap" style="display: block; visibility: visible; height: 0px; opacity: 1; overflow: hidden;">
								</div>
							</li>
							<li class="mn_l1 has-sub is-cloose" style="width: auto;">
								<a href="<?php echo base_url('/board/forum')?>" class="mn_a1"><span>포럼</span></a>
								<div class="depth2-wrap" style="display: block; visibility: visible; height: 0px; opacity: 1; overflow: hidden;">
									<ul class="depth2">
                                        <li class="mn_l2"><a href="<?php echo base_url('/board/forum')?>" class="mn_a2"><span>CIC 포럼</span></a></li>
                                        <li class="mn_l2"><a href="<?php echo base_url('/board/userforum')?>" class="mn_a2"><span>도전! CIC포럼</span></a></li>
									</ul>
								</div>
							</li>
							<li class="mn_l1 is-cloose" style="width: auto;">
								<a href="<?php echo base_url('board/notice')?>" class="mn_a1"><span>공지사항</span></a>
							</li>
							<li class="mn_l1 is-cloose" style="width: auto;">
								<a href="<?php echo base_url('/news')?>" class="mn_a1"><span>뉴스</span></a>

							</li>
						</ul>
						<div class="gnb mobile">	
							<ul class="language">
								<li><a href="#n"><span>KOR</span></a></li>
								<li><a href="#n"><span>ENG</span></a></li>
							</ul>
						</div>
					</div>
				</div>
				<span class="mn-bar" style="height: 0px; display: none;">&nbsp;</span>
				<!-- e: mainNavi-wrap -->
			</div>
		 </div>
	</header>
            <!-- 본문 시작 -->
            <?php if (isset($yield))echo $yield; ?>
            <!-- 본문 끝 -->
        <footer id="footer-wrap">
            <div id="footer" class="div-cont">
                <div class="f-logo">
                    <h2><span class="blind">cic+community</span></h2>
                    <a href="http://cic community.co.kr" target="_blank" title="새창열림">http://cic community.co.kr</a>
                </div>
                <div class="f-sns">
                    <ul>
                        <li><a href="#n"><span class="blind">....</span></a></li>
                        <li><a href="#n"><span class="blind">유투브</span></a></li>
                        <li><a href="#n"><span class="blind">블로그</span></a></li>
                    </ul>
                </div>
                <div class="f-info">
                    <div class="in-link">
                        <ul>
                            <li><a href="#n"><span>이용약관</span></a></li>
                            <li><a href="#n"><span>개인정보처리방침</span></a></li>
                            <li><a href="#n"><span>백서</span></a></li>
                            <li><a href="#n"><span>문의하기</span></a></li>
                        </ul>
                    </div>
                    <p class="in-copy">Copyright © cic Community. All rights reserved.</p>
                </div>
                <div class="f-down">
                    <p>PER Wallet DOWNLOAD</p>
                    <ul>
                        <li><a href="#n"><span class="blind">Google Play 다운로드</span></a></li>
                        <li><a href="#n"><span class="blind">App Store 다운로드</span></a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</body>