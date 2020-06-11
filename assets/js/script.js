$(document).ready(function(){	
	
	//Iframe transparent
	$("iframe").each(function(){
		var ifr_source = $(this).attr('src');
		var wmode = "wmode=transparent";
		if(ifr_source.indexOf('?') != -1) {
		var getQString = ifr_source.split('?');
		var oldString = getQString[1];
		var newString = getQString[0];
		$(this).attr('src',newString+'?'+wmode+'&'+oldString);
		}
		else $(this).attr('src',ifr_source+'?'+wmode);
	});	
	
	//Image hover
	$(".hover_img").on('mouseover',function(){
			var info=$(this).find("img");
			info.stop().animate({opacity:0.5},300);
			$(".preloader").css({'background':'none'});
		}
	);
	$(".hover_img").on('mouseout',function(){
			var info=$(this).find("img");
			info.stop().animate({opacity:1},300);
			$(".preloader").css({'background':'none'});
		}
	);

	$(window).scroll(function(){
		var _toTop = $(this).scrollTop(),
		_navBar = $('.navbar_');
		if(_toTop >= 540){
			_navBar.addClass('scrolling')
		}else{
			_navBar.removeClass('scrolling')
		}	
	})

	$.host = function (url, reset) {
        var location = window.location,
            host = location.host, origin;
        if (url == undefined) return location.origin;

        if (reset == undefined) {
            url = 'api/' + url;
        }
        if (host == 'localhost') {
            origin = location.origin + '/tkphoto/' + url;
        } else {
            origin = location.origin + '/' + url;
        }
        return origin;
    }

	$("#ajax-contact-form").submit(function(e) {
		e.preventDefault();
		let _this = $(this),
			str = $(this).serialize(),
			note = $('.note'),
			result = '';

		note.removeClass('error success');
		note.html('')	

		$.ajax({
			type: "POST",
			dataType: 'json',
			url: $.host("contact"),
			data: str,
			success: function(res) {
				// Message Sent - Show the 'Thank You' message and hide the form
				
				if(res.success) {
					result = '<div>Your message has been sent. Thank you!</div>';
					note.addClass('success')
					_this[0].reset();
					setTimeout(function(){
						note.removeClass('success').html('')
					}, 5000)
				} else {
					result += "<ul>";
					$.each(res.error, function(index, info){
						result += "<li>"+ info +"</li>";
					})
					result += "</ul>";
					note.addClass('error');
				}
				note.html(result);
			}
		});
		return false;
	});	
	
	
							
});	