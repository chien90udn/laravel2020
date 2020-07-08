/**
* Author : Phú
* jQuery ptkAcumen 
*/
if (typeof Object.create !== "function") {
    Object.create = function (obj) {
        function F() {}
        F.prototype = obj;
        return new F();
    };
}
(function ($, window, document) {
	// tạo 1 object
	var Acumen = {
		init : function (options, elem) {
			var acum 				= this;
			acum.$elem 				= $(elem);
			acum.options 			= $.extend({}, $.fn.ptkAcumen.options, acum.$elem.data(), options);
			acum.userOptions 		= options;
			acum.addElementDefault();
		}, 
		addElementDefault : function(){
			var acum = this;
			acum.itemAll			= acum.$elem.find('.items');
			acum.widthRoot 		= acum.$elem.width(); // width bao ngoài cùng
			acum.totalItem			= acum.$elem.find('.items').length; // tổng items
			acum.widthBrowser		= $(document).width();
			
			acum.itemsNumber			= acum.options.items; 
			acum.itemsConverNumber 	= acum.options.itemsConver;
			
			if(acum.options.reponsive == true){
				if(acum.widthBrowser < 997 &&  acum.widthBrowser > 768){
					acum.itemsNumber			= acum.options.itemsDesktopSmall[0]; 
					acum.itemsConverNumber 	= acum.options.itemsDesktopSmall[1];
				}else if(acum.widthBrowser < 768 &&  acum.widthBrowser > 479){
					acum.itemsNumber			= acum.options.itemsTablet[0]; 
					acum.itemsConverNumber 	= acum.options.itemsTablet[1];
				}else if(acum.widthBrowser < 479){
					acum.itemsNumber			= acum.options.itemsMobile[0]; 
					acum.itemsConverNumber 	= acum.options.itemsMobile[1];
				}
			}
			
			acum.widthSpace		= ((acum.itemsNumber-1)*acum.options.margin_right)/acum.itemsNumber; // khoảng thừa do cho margin cuối
   		acum.widthItem			= acum.widthRoot/acum.itemsNumber-acum.widthSpace; // width cho từng items
			acum.widthWarp			= acum.totalItem*(acum.widthItem+acum.options.margin_right); // width bao toàn bộ các items
			acum.moveAll 			= acum.widthWarp - acum.itemsNumber*(acum.widthItem+acum.options.margin_right);// quãng đường cần di chuyển
			acum.moveOnClick 		= acum.itemsConverNumber*(acum.widthItem+acum.options.margin_right);// quảng đường di chuyển sau mỗi click
			
			acum.wrapAcumen();
		},
		wrapAcumen : function(){
			var acum = this;
			acum.$elem.wrapInner('<div class=\"ptkAcumen\" iPage="1"></div>');
			acum.divWarpItems  = acum.$elem.find('.ptkAcumen'); // elementptkAcumen
			if(acum.totalItem > acum.options.items){
				acum.$elem.append('<div class=\"btnNext\" title="Trước">Trước</div>');
				acum.$elem.append('<div class=\"btnPrev\" title="Sau">Sau</div>');
			}
			acum.btnNext	= acum.$elem.find('.btnNext');
			acum.btnPrev  	= acum.$elem.find('.btnPrev');
			
			acum.setStyle(); // set style mặc định
			acum.actionNext();
			acum.actionPrev();
			acum.fnActionEvent();
			if(acum.options.autoSlider === true){
				acum.autoSlider();
			}
		},
		actionNext : function(){
			var acum = this;
			$(acum.btnNext).on('click' , function(){
				acum.fnNext();
			});
		},
		actionPrev : function(){
			var acum = this;
			$(acum.btnPrev).on('click', function(){
				acum.fnPrev();
			});
		},
		fnNext : function(){
			var acum = this;
			acum.leftDivWarp 	= parseInt(acum.divWarpItems.css('left'), 10); //lấy postion left của div
			maxPositionLeft 	= acum.leftDivWarp-acum.moveOnClick; //số px cần di chuyển sau khi lấy đc left
			acum.iPage 			= acum.divWarpItems.attr('iPage');
			var timeDiv = setInterval(function(){
				//acum.leftDivWarp = acum.leftDivWarp-acum.widthSpace;
				acum.leftDivWarp = acum.leftDivWarp-(acum.widthItem/10);
				if(acum.leftDivWarp <= maxPositionLeft){
					clearInterval(timeDiv);
					acum.leftDivWarp = maxPositionLeft;
					acum.btnNext.addClass('endNext');
				}else{
					acum.btnNext.removeClass('endNext');
				}
				if(acum.leftDivWarp <= parseInt('-'+acum.moveAll)){
					clearInterval(timeDiv);
					acum.leftDivWarp = parseInt('-'+acum.moveAll);
					acum.btnNext.addClass('endNext');
				}else{
					acum.btnNext.removeClass('endNext');
					acum.divWarpItems.attr('iPage', parseInt(acum.iPage)+1);
				}
				acum.divWarpItems.css({
					left 			: acum.leftDivWarp+'px',
				});
			},acum.options.timeConver);
		},
		fnPrev : function(){
			var acum = this;
			acum.leftDivWarp 	= parseInt(acum.divWarpItems.css('left'), 10); //lấy postion left của div
			maxPositionLeft 	= acum.leftDivWarp+acum.moveOnClick; //số px cần di chuyển sau khi lấy đc left
			acum.iPage 			= acum.divWarpItems.attr('iPage');
			if(acum.leftDivWarp <= 0){
				var timeDiv = setInterval(function(){
					acum.leftDivWarp = acum.leftDivWarp+(acum.widthItem/10);
					if(acum.leftDivWarp >= maxPositionLeft){
						clearInterval(timeDiv);
						acum.leftDivWarp = maxPositionLeft;
						acum.btnPrev.addClass('endPrev');
					}else{
						acum.btnPrev.removeClass('endPrev');
					}
					if(acum.leftDivWarp >= 0){
						clearInterval(timeDiv);
						acum.leftDivWarp = 0;
						acum.btnPrev.addClass('endPrev');
					}else{
						acum.btnPrev.removeClass('endPrev');
						acum.divWarpItems.attr('iPage', parseInt(acum.iPage)-1);
					}
					acum.divWarpItems.css({
						left 			: acum.leftDivWarp+'px',
					});
				},acum.options.timeConver);
			}
			
		},
		fnActionEvent : function(){ // sự kiện vuốt màn hình
			var acum = this;
			acum.$elem.mousedown(function(e){
				e.preventDefault();
				down_x = e.pageX;
			});
			acum.$elem.mouseup(function(e){
				up_x = e.pageX;
				do_work();
			});
			acum.$elem.bind('touchstart', function(e){
				down_x = e.originalEvent.touches[0].pageX;
			});
			acum.$elem.bind('touchmove', function(e){
				e.preventDefault();
				up_x = e.originalEvent.touches[0].pageX;
			});
			acum.$elem.bind('touchend', function(e){
				do_work();
			});
			
			function do_work()
			{
				if ((down_x - up_x) > 10)
				{
				  acum.fnNext();
				}
				if ((up_x - down_x) > 10)
				{
				  acum.fnPrev();
				}
			}
		},
		autoSlider : function(){
			var acum = this;
			acum.totalIpage = acum.totalItem-acum.options.items-acum.options.itemsConver;
			//console.log(acum.totalIpage);
		},
		setStyle : function(){
			var acum = this;
			
			acum.divWarpItems.css({
				width 		: acum.widthWarp + 'px', 
				position 	: 'relative',
				left 			: '0px',
			});
			acum.itemAll.css({
				display 		: 'inline-block',
				width 		: acum.widthItem + 'px',
				marginRight : acum.options.margin_right + 'px',
				'float'		: 'left',
			});
		}
	};
	
	//Gọi đối tượng Acumen
	$.fn.ptkAcumen = function (options) {
		var acumen = Object.create(Acumen);
		acumen.init(options, this);
		$.data(this, "ptkAcumen", acumen);
	};
	
	// khởi tạo options default
	$.fn.ptkAcumen.options = {
		items 					: 4, // số items được hiển thị
		itemsConver 			: 3, // số items chuyển động sau mỗi lần click
		margin_right 			: 10, // khoảng cách giữa các items
		animateCss3				: false,
		reponsive				: false,
		itemsDesktopSmall 	: [4, 1], // width 997. 4 số item đc hiển thị, 1 số items đc chuyển sau mỗi click
		itemsTablet 			: [3, 1], // width 768. 3 số item đc hiển thị, 1 số items đc chuyển sau mỗi click
		itemsMobile 			: [2, 1], // width 479. 2 số item đc hiển thị, 1 số items đc chuyển sau mỗi click
		autoSlider				: false,
		timeConver				: 30,
	};
}(jQuery, window, document));