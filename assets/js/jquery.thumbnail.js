var thumbnailMaxWidth = 0;
var thumbnailMaxHeight = 0;

$.thumbnail = function(data){
		
		thumbnailMaxWidth = data.thumbW;
		thumbnailMaxHeight = data.thumbH;
		var thumbnailSrc = $(data.element);
		thumbnailSrc.each(function(index, i){
			var _this = $(this), 
				src = _this.data('src');

			var originalImage = new Image();
				originalImage.src = src;
				originalImage.addEventListener("load", function (e) {
				    var thumbnailImage = $.createThumbnail({image: e.target, screen: data.screen, w: data.thumbW, h: data.thumbH});
				    _this.append(thumbnailImage);
				});
		});
		
}
	

$.createThumbnail = function (data) {
    var canvas, ctx, thumbnail, thumbnailScale, thumbnailWidth, thumbnailHeight;
    var thumbnailMaxWidth = data.w, thumbnailMaxHeight = data.h;
    var image = data.image;

    // create an off-screen canvas
    canvas = document.createElement('canvas');
    ctx = canvas.getContext('2d');

    //Calculate the size of the thumbnail, to best fit within max/width (cropspadding)
    thumbnailScale = (image.width / image.height) > (thumbnailMaxWidth / thumbnailMaxHeight) ?
        thumbnailMaxWidth / image.width :
        thumbnailMaxHeight / image.height;
    thumbnailWidth = image.width * thumbnailScale;
    thumbnailHeight = image.height * thumbnailScale;

    // set its dimension to target size
    canvas.width = thumbnailWidth;
    canvas.height = thumbnailHeight;

    // draw source image into the off-screen canvas:
    ctx.drawImage(image, 0, 0, thumbnailWidth, thumbnailHeight);

    // encode image to data-uri with base64 version of compressed image
    var src = canvas.toDataURL('image/jpeg', 100);
    
    if(data.screen == 'landing'){
    	thumbnail = new Image();
    	thumbnail.src = src;
	    return thumbnail;
    }else{
    	return src;
    }
    
};
	