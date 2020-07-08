$(window).on('load resize',function(event) {
	if($('.menu-l').outerHeight()>$('#slide').outerHeight())
	{
		$('#slide').css('margin-bottom', $('.menu-l').outerHeight()-$('#slide').outerHeight());	
	}
});
$(document).ready(function(e) {
    // Back top
	$('#back-top,.go-top').click(function(){
		$('html, body').animate({
			scrollTop:0	
		},800)	
	})

	// Menu mobile
	$('.i-menu').click(function(){
		$('#menus').slideToggle();	
	})

	$('.box-tab-tit div').click(function(event) {
		if(!$(this).hasClass('active'))
		{
			$(this).parent('.box-tab-tit').children('div').not($(this)).removeClass('active');
			$(this).addClass('active');
			var i=parseInt($(this).index())+1;
			$(this).parent('.box-tab-tit').next().find('.box-tab-con').hide();
			$(this).parent('.box-tab-tit').next().find('.box-tab-con:nth-child('+i+')').show();
		}
	});

	$('.giohang-cl').click(function(event) {
		$('#giohang').removeClass('active');
	});


});

$(window).on('scroll',function(){
	$pageY=$(window).scrollTop();
	if($pageY>300)
	{
		$('#back-top').fadeIn();
	}
	else
	{
		$('#back-top').fadeOut();
	}

	if($pageY>$('#banner').height())
	{
		$('#menu').addClass('fix');
		if($('.menu-l').hasClass('index'))
		{
			$('.menu-l.index > ul').removeClass('show');
		}
	}
	else
	{
		$('#menu').removeClass('fix');
		if($('.menu-l').hasClass('index'))
		{
			$('.menu-l.index > ul').addClass('show');
		}
	}
});
 $(".dropdown-toggle").each(function () {
	par = $(this).parents('.btn-group');
	dropl = par.find('ul');
	otop = $(this).offset().top + $(this).height() - $(window).scrollTop();
	ulh = dropl.height();
	obot = $(window).height() - $(this).height() - $(this).offset().top + $(window).scrollTop();

	if ((obot < ulh) && (otop > ulh)) {
		par.addClass('dropup');
	} else {
		par.removeClass('dropup');
	}

});