(function ($) {

    let _body = $('body'),
        _bodyClass = 'preview-open',
        details = $('.preview-right', '.preview'),
        imageView = $('.preview-left', '.preview'), 
        currentElement = '',
        view = {
            open: function (element) {
                element.addClass('open')
                setTimeout(function () {
                    _body.addClass(_bodyClass)
                    boxSizing();
                }, 150)
                loadImages(element)
            },
            close: function () {
                _body.removeClass(_bodyClass).addClass('preview-closing')
                setTimeout(function () {
                    _body.removeClass('preview-closing')
                    imageView.removeClass('bring-back').find('.preview-options').show();
                    details.removeClass('active').css({
                        right: '-360px'
                    })
                    imageView.css({
                        width: ''
                    })
                }, 120)
                setTimeout(function () {
                    $('.photo-section._target li').removeClass('open')
                }, 120)
                updateId(0, true);
            },
            next: function () {

                if (!$('.control-right').hasClass('active')) return false;

                let elem = $('#' + currentElement),
                    next = elem.next('.target');
                elem.addClass('hide').removeClass('active');
                next.removeClass('hide').addClass('active');
                currentElement = next.attr('id');
                updateId(currentElement);

                syncLoad(currentElement);
                if (next.next('.target').length == 0) {
                    $('.control-right').removeClass('active')
                } else {
                    $('.control-right').addClass('active')
                }

                if (next.prev('.target').length == 0) {
                    $('.control-left').removeClass('active')
                } else {
                    $('.control-left').addClass('active')
                }

            },
            prev: function () {

                if (!$('.control-left').hasClass('active')) return false;

                let elem = $('#' + currentElement),
                    prev = elem.prev('.target');
                elem.addClass('hide').removeClass('active');
                prev.removeClass('hide').addClass('active')
                currentElement = prev.attr('id')
                updateId(currentElement);

                syncLoad(currentElement);
                if (prev.prev('.target').length == 0) {
                    $('.control-left').removeClass('active')
                } else {
                    $('.control-left').addClass('active')
                }

                if (prev.next('.target').length == 0) {
                    $('.control-right').removeClass('active')
                } else {
                    $('.control-right').addClass('active')
                }
            },
            html: function (data) {
                return '<div id="' + data.id + '" class="preview-item target hide"><div class="item-container">' +
                    '<div class="preview-image">'+                    
                     '<div class="preview-contain" style="display: none;"><img data-src="' + data.url + '" alt=""></div>'+
                     '<div class="preview-loading"><img src="./assets/img/loading.gif" alt=""></div>'+
                    '</div>' +
                    '<div class="hide">' +
                    '<div class="preview-title">' + data.title + '</div>' +
                    '<div class="preview-descrip">' + data.descrip + '</div>' +
                    '</div></div></div>';
            }
        },
        updateId = function (id, reverse) {
            let active = $('.photo-list li.active'),
                deleteBtn = $('._gallery_delete').parent();
            active.removeClass('active');
            if (reverse == null) {
                let current_target = $('#' + id),
                    split = id.split('-'),
                    newid = split[1];
                $('#' + newid).addClass('active');

                details.find('._title > div').html(current_target.find('.preview-title').text());
                let _desc = current_target.find('.preview-descrip').text();
                if (_desc.length == 0) {
                    details.find('._description > label').hide()
                } else {
                    details.find('._description > label').show()
                }
                details.find('._description > div').html(current_target.find('.preview-descrip').text());

                deleteBtn.addClass('active')
            } else {
                deleteBtn.removeClass('active')
            }

        };

    function boxSizing(inputWidth, where) {
        /* Use the box width, then find width of one control and multiply by 2, 
        ** finally minus a certain amount of width, that way we find width of the image
        */
        let _box = 0;
        if (where != undefined && where == 'box') {
            _box = window.innerWidth - details.width() - 4;
            imageView.css({
                width: _box + 'px'
            })
        } else {
            _box = inputWidth || window.innerWidth;
        }

        let controlsWidth = document.getElementById('_prev').clientWidth,
            leftPush = controlsWidth - 128,
            imageWidth = _box - (leftPush * 2);
        // console.log(_box, controlsWidth)
        if (leftPush < 0) {
            leftPush = 4;
            imageWidth = '100%';
        } else {
            imageWidth = imageWidth + 'px';
        }
        $('.item-container').css({
            left: leftPush + 'px',
            width: imageWidth
        })
    }

    $(window).resize(function () {
        let where = 'window';
        if ($('body').hasClass(_bodyClass) && details.hasClass('active')) {
            where = 'box';
        }
        boxSizing(0, where)
    })

    function splitScreen(option) {
        let _screen = window.innerWidth,
            _leftScreen = imageView,
            _rightScreen = details,
            _rightWidth = 360,
            left = _screen - _rightWidth - 4,
            right = '0',
            setLeft = '100%';

        if (option == 'show') {
            setLeft = left + 'px';
            _rightScreen.addClass('active')
            _leftScreen.addClass('bring-back')
        } else {
            right = '-' + _rightWidth + 'px';
            _rightScreen.removeClass('active')
            _leftScreen.removeClass('bring-back')
        }

        let options = _leftScreen.find('.preview-options');
        if(option == 'show' && left <= 266){
            options.hide()
        }else{
            options.show()
        }

        setTimeout(function () {            
            _leftScreen.animate({
                width: setLeft
            }, 'linear')
        }, 100);
        setTimeout(function () {
            _rightScreen.animate({
                right: right
            }, 'linear');
        }, 1)

        setTimeout(function () {
            if (option == 'show') {
                boxSizing(left)
            } else {
                boxSizing()
            }
        }, 450)

    }

    function syncLoad(id){        

        let elem = $('#' + id + " .preview-contain", ".preview-list"),
        url = elem.find('img').attr('data-src');

        let originalImage = new Image();        

        let fileReader = new FileReader();

        originalImage.addEventListener("load", function (e) {   
        	let image = this.src;         
            elem.find('img').fadeOut(400, function(){
                elem.find('img').attr('src', image).show();
                elem.addClass('loaded').fadeIn()                
            })            
        });
        originalImage.src = url;
    }

    function loadImages(target) {
        let currentId = '__preview-' + target.attr('id'),
            allImages = $('.photo-section._target li'),
            container = $('.preview-list');

        // Append all loaded images to preview
        container.find('.preview-item.target').remove()
        allImages.each(function () {
            let _this = $(this), 
                id = "__preview-" + _this.attr('id'),
                url = _this.find('.image img').attr('data-src');

            container.append(view.html({
                url: url,
                id: id,
                title: _this.find('._image-title').val(),
                descrip: _this.find('._image-descrip').text()
            }))
            
        })

        // Show current selected
        container.find('.preview-item.loading').addClass('hide')
        current_target = container.find('#' + currentId);
        current_target.removeClass('hide').addClass('active');
        details.find('._title > div').html(current_target.find('.preview-title').text());
        details.find('._description > div').html(current_target.find('.preview-descrip').text());

        currentElement = currentId;

        updateId(currentId);

        syncLoad(currentId);

        let _thisElement = $('#' + currentId),
            prev = _thisElement.prev('.target'),
            next = _thisElement.next('.target');

        // Prev
        if (prev.length == 0) {
            $('.control-left').removeClass('active')
        } else {
            $('.control-left').addClass('active')
        }

        // Next
        if (next.length == 0) {
            $('.control-right').removeClass('active')
        } else {
            $('.control-right').addClass('active')
        }
    }

    function doSwitch(){
        let _screen = window.innerWidth,
            control = true;
        if(_screen <= 685){
            if(imageView.hasClass('bring-back')){
                control = false;
            }            
        }
        return control;
    }


    $(function () {
        _body.on('click', '.photo-list .image-view', function () {
            view.open($(this).parent());
        });

        _body.on('click', '.preview-close', function () {
            view.close();
        })

        $(window).keyup(function (e) {
            if (e.keyCode == 27) view.close()

            let control = doSwitch();

            if (control && e.keyCode == 39){
                view.next()
            }

            if (control && e.keyCode == 37){
                view.prev()
            }
        })

        $('.control-left, .control-btn.left').click(function () {
            if(doSwitch()) view.prev()
        })

        $('.control-right, .control-btn.right').click(function () {
            if(doSwitch()) view.next()
        })

        $('#_info_view').click(function () {
            splitScreen('show');
        })

        $('#_info_close').click(function () {
            splitScreen('hide');
        })
    });


})(jQuery);