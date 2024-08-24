(function($){
    $.currentItem = function() {
            var pos, id_slide;
			pos = $(window).scrollTop();
				$(".slide-menu").each(function() {
					id_slide = $(this).attr("id");
					if($(this).offset().top <= pos + 100 && $("#desktop-menu li a[href$='#"+id_slide+"']").length > 0) {
						$("#desktop-menu li.active").removeClass("active");
						$("#desktop-menu li a[href$='#"+id_slide+"']").parent().addClass("active");	
					}
			});
    };
}(jQuery));