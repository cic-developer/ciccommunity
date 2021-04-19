$(function() {
	// vnews-slide
	$('.vnews-slide').owlCarousel({
		items: 4,      
		autoHeight:false,
		loop: true,   
		margin: 15,   
		mouseDrag: true, 
		touchDrag: true,
		nav:false,     
		autoplay: false,  
		dots:true,      
		autoplayTimeout: 3500,  
		autoplayHoverPause: false, 
		autoWidth:false, 
		responsiveRefreshRate: 5,
		responsive:{ 
			0:{
				items:1,
				margin: 20,   
			},
			480:{
				items:2,
				margin: 20,   
			},
			780:{
				items:3,
				margin: 20,  
			},
			999:{
				items:4,
				margin: 20,  
			},
		}
	 });

	 $('.board-wrap').find('.list.notice').find('tbody > tr.notice').each(function(){
		var firstTH = $(this).find('td:first-child > span').outerWidth();
		$(this).find('td:nth-child(2)').css({'padding-left':firstTH + 20})
	 });
});
function sizeControlSub(width) {
	width = parseInt(width);
	var bodyHeight = document.documentElement.clientHeight; 
	var bodyWidth = document.documentElement.clientWidth; 
	var chkHeader = $('#header-wrap').outerHeight();
	var chkFooter = $('#footer').outerHeight();
	var docW = window.innerWidth;
	
	 

}
function myWidth(obj){
  var isWidth = obj.naturalWidth;
  $('.natural-img').css({'max-width': isWidth});
}


출처: https://sometimes-n.tistory.com/21 [종종 올리는 블로그]
jQuery(function($){
	sizeControlSub($(this).width());
	$(window).resize(function() {
		if(this.resizeTO) {
			clearTimeout(this.resizeTO);
		}
		this.resizeTO = setTimeout(function() {
			$(this).trigger('resizeEnd');
		}, 10);
	});
});	
$(window).on('resizeEnd', function() {
	sizeControlSub($(this).width());
});
$(window).load( function() { 
	sizeControlSub($(this).width());
});
