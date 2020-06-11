(function ($) {
    let container = $('.photo-container'),
        _ghost = $('.gallery-ghost'),
        _viewType = 'gallery';

        if($('html').hasClass('__slideshow')){
            _viewType = 'slideshow';
        }

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
    },
        $.generateId = function (len) {
            var arr = new Uint8Array((len || 20) / 2)
            window.crypto.getRandomValues(arr)
            return Array.from(arr, dec2hex).join('')
        },
        $.collectSelected = function () {
            let _list = $('.photo-list li.active'),
                _data = [];
            if (_list.length == 0) return _data;

            _list.each(function () {
                let _token = $(this).attr('id');
                if (_token != '') {
                    _data.push({
                        token: _token
                    })
                }
            });
            return _data;
        },
        $.imageDelete = function () {
            let _this = $('._gallery_delete'),
                _modal = $('._confirm');

            if (!_this.parent().hasClass('active')) return false;

            let _selected = $.collectSelected(),
                _title = '';

            if (_selected.length == 0) {
                console.log('Please select files to delete');
                return false;
            }
            if (_selected == 1) {
                _title = "1 image";
            } else {
                _title = _selected.length + ' images';
            }
            _modal.find('.modal-body .confirm').html(
                "<div class='msg'>You're about to delete <span>" + _title + "</span>, continue anyway?</div>" +
                "<div class='loader' style='display:none'></div>"
            );
            _modal.css({
                'background-color': "rgba(0, 0, 0, 0.5)"
            });
            _modal.modal({
                show: true,
                backdrop: false
            })
        };
    function dec2hex(dec) {
        return ('0' + dec.toString(16)).substr(-2)
    }

    function clearSelection() {
        let _main = $('._cancel_select'),
            _parent = _main.parent(),
            _sections = $('.photo-section._target', '.photo-container');

        _sections.each(function () {
            let _this = $(this);
            _this.find('div.h3').removeClass('active');
            _this.find('.photo-list li').each(function () {
                $(this).removeClass('active')
            })
        });

        _parent.removeClass('active')
        _main.attr('title', '').siblings('._gallery_delete').attr('title', '')
    }

    function emptyGallery(action, extra) {
        let _emptyGal = $('#empty_gallery'),
            _text = _emptyGal.find('.empty-text'),
            _empty_gall = $('#_empty_gall'),
            _empty_error = $('#_empty_error');

        if (action == 'show') {
            _empty_error.hide();
            _empty_gall.show();
            _text.html('No images found');
            _emptyGal.show()
        } else if (action == 'error') {
            _empty_error.show();
            _empty_gall.hide();
            let msg = 'No internet connection';
            if(extra == 'parsererror'){
                msg = 'Unknown error has occured, please report this.';
            }
            _text.html(msg);
            _emptyGal.show()
        } else {
            _emptyGal.hide()
        }
    }

    function ghost(action) {
        if (action == 'show') {
            let html = '<li><div class="image"><img src="'+ $.host('assets/img/placeholder.png', 'reset') +'" alt=""></div></li>';
            for (let i = 0; i < 12; i++) {
                _ghost.find('.photo-list').append(html);
            }
            _ghost.fadeIn();
        } else {
            _ghost.hide();
            _ghost.find('.photo-list').html('');
        }
    }

    let inAdvance = 300;

    // Load thumbnail.js
    $.get('./assets/js/jquery.thumbnail.js');

    function lazyLoader(){
        let lazyImages = [].slice.call(document.querySelectorAll('.lazy-image.lazy'));
        
        setTimeout(function(){
            lazyImages.forEach(lazyImage => {
                if (lazyImage.offsetTop < window.innerHeight + window.pageYOffset + inAdvance) {
                    // lazyImage.src = lazyImage.dataset.src;

                    var originalImage = new Image();
                    originalImage.src = lazyImage.dataset.src;
                    originalImage.addEventListener("load", function (e) {
                        var data = {
                            w: 500,
                            h: 500,
                            image: e.target,
                            screen: 'gallery'
                        }

                        lazyImage.src = $.createThumbnail(data);
                        lazyImage.onload = () => {
                            lazyImage.classList.remove('lazy')
                            lazyImages = lazyImages.filter(function(image) {
                                          return image !== lazyImage;
                                        });
                            if (lazyImages.length === 0) {
                              document.removeEventListener("scroll", lazyLoader);
                              window.removeEventListener("resize", lazyLoader);
                              window.removeEventListener("orientationchange", lazyLoader);
                            }
                        }
                    });
                    
                }
            })
        }, 200)

    }

    window.addEventListener('scroll', lazyLoader)
    window.addEventListener('resize', lazyLoader)
    window.addEventListener('orientationchange', lazyLoader)

    function load() {
        const _category = $('#_gallery-category').val(),
            _year = $('#_gallery-year').val();
        let _data = {
                category: _category,
                year: _year
            };
        if(_viewType == 'slideshow') {
            _data = {};
        }
        let item_function = function (target, data) {
            let _item_temp = $('#item_temp').html(), _temp_data,
            count = 0;

            $.each(data, function (i, r) {
                _temp_data = {
                    url: r.url,
                    title: r.title,
                    date: r.date,
                    id: r.id,
                    descrip: r.descrip,
                    token: $.generateId()
                };
                target.append(Mustache.render(_item_temp, _temp_data));  
                count++;              
            });
        }

        $.ajax({
            url: $.host(_viewType),
            dataType: 'json',
            data: _data,
            error: function (i, e) {
                ghost('hide')
                emptyGallery('error', e)
            },
            success: function (r) {
                let _section_temp, _target = $('.photo-container', '.gallery-body');
                if (r.success) {
                    _section_temp = $('#section_temp').html();
                    let randId = '';
                    ghost('hide');
                    $.each(r.data, function (i, d) {
                        randId = $.generateId();
                        _temp_sec_data = {
                            'year': d.year,
                            'randId': randId
                        };
                        _target.append(Mustache.render(_section_temp, _temp_sec_data));
                        _target_item = $('.photo-list.' + randId);
                        item_function(_target_item, d.data);
                    });
                    lazyLoader();

                } else {
                    ghost('hide')
                    emptyGallery('show')
                }
            }
        });
    }

    function init() {
        // Call ghost layout
        emptyGallery('hide')
        ghost('show');
        // Load info
        load();
    }

    function changeHeader() {
        let _header = $('.gallery-body > h3', '.gallery-box'),
            _year = $('#_gallery-year'),
            _category = $('#_gallery-category'),
            _year_elem, _category_elem, _title = '', _all_year = 'Every year', _all_category = 'All pictures';

        _category_elem = _category.children('option[value="' + _category.val() + '"]').text();
        _year_elem = _year.children('option[value="' + _year.val() + '"]').text();

        if (_category_elem == _all_category) {
            if (_year_elem == _all_year) {
                _title = "Showing all photos";
            } else {
                _title = "All " + _year_elem + " photos";
            }
        } else {
            if (_year_elem == _all_year) {
                _title = "All photos of " + _category_elem;
            } else {
                _title = "Photos of " + _category_elem + " for " + _year_elem;
            }
        }

        _header.html(_title);
    }

    function headerBar(option) {
        let _box = $('#_gallery_stick'),
            _header = $('.header');
        if (option == 'show') {
            _header.hide();
            _box.addClass('stick')            
        } else {            
            _box.removeClass('stick')
            _header.show()
        }
    }

    $(window).scroll(function () {
        let _this = $(this),
            _scroll = _this.scrollTop();
        if (_scroll >= 88) {
            headerBar('show')
        } else {
            headerBar('hide')
        }
    });


    $(function () {
        init();

        $('.__gallery_filter').change(function () {
            container.find('.photo-section._target').remove();
            changeHeader();
            $('.gallery-box')
                .find('.gallery-header').removeClass('active')
                .find('._cancel_select').attr('title', '').siblings('._gallery_delete').attr('title', '');
            $('html, body').animate({ scrollTop: 88 }, 1500, 'linear');

            init();
        });

        $('body').on('click', '.photo-selector', function () {
            let _parent = $(this).parent(),
                _container = $(this).offsetParent().parent().parent().parent(),
                _header = _container.find('.h3'),
                _countChild = $(this).offsetParent().parent().children('li.active').length;

            if (_parent.hasClass('active')) {
                _parent.removeClass('active')
                if (_countChild == 1) {
                    _header.removeClass('active')
                }
            } else {
                _parent.addClass('active')
                _header.addClass('active')
            }
            global_check()
        });

        function global_check() {
            let _gallery_stick = $('.gallery-box .gallery-header'),
                _delete = _gallery_stick.find('._gallery_delete'),
                _cancel = _gallery_stick.find('._cancel_select'),
                _all_header = $('.photo-section._target .h3.active').length;
            if (_all_header == 0) {
                _gallery_stick.removeClass('active')
                _cancel.attr('title', '')
                _delete.attr('title', '')
            } else {
                _gallery_stick.addClass('active')
                _cancel.attr('title', 'Unselect all')
                _delete.attr('title', 'Delete Selected')
            }
        }

        $('body').on('click', '.section-check', function () {
            let _this = $(this),
                _parent = _this.offsetParent(),
                _photos = _parent.parent().find('.photo-list li'),
                _active = true;
            if (_parent.hasClass('active')) {
                _parent.removeClass('active')
                _active = false
            } else {
                _parent.addClass('active')
                _active = true
            }

            global_check()

            _photos.each(function () {
                let _this = $(this)
                if (_active) {
                    _this.addClass('active')
                } else {
                    _this.removeClass('active')
                }
            });
        });


        $('._cancel_select').click(function () {
            clearSelection();
        });

        $('._gallery_delete').click(function () {
            $.imageDelete();
        });

        function removeDeleted(data) {
            $.each(data, function (i, file) {
                let _this = $('#' + file.token),
                    _parent = _this.parent(),
                    _main = $('.photo-section._target', '.photo-container');

                // Check if all are selected
                let children = _parent.children().length,
                    selected_children = _parent.find('li.active').length;
                if(children == selected_children){
                    _parent.parent().parent().addClass('preparing-delete').fadeOut(300, function () {
                        $(this).remove()
                    })
                } else {
                    _this.fadeOut(300, function () {
                        $(this).remove();
                    });
                }
            });

            let deleted = $('.photo-section._target:not(.preparing-delete)', '.photo-container');      
            if(deleted.length === 0) {
                emptyGallery('show')
            }
        }

        $('._confirm').on('hidden.bs.modal', function () {
            $(this).find('button').attr('disabled', false).removeClass('disabled')
        })

        $('#_confirm-form').submit(function (e) {
            e.preventDefault();
            let _this = $(this),
                _btn = _this.find('button'),
                _modal = $('._confirm'),
                _selected = $.collectSelected();

            if (_selected.length == 0) {
                _modal.modal('hide');
                console.log('Please select files to delete');
                return false;
            }

            let _msg = _this.find('.confirm'),
                _count = _msg.find('span').text();

            $.ajax({
                url: $.host(_viewType +'/delete'),
                method: 'post',
                dataType: 'json',
                data: {
                    images: JSON.stringify(_selected)
                },
                error: function () {
                    _modal.modal('hide');
                    _btn.attr('disabled', false).removeClass('disabled')
                },
                beforeSend: function () {
                    _btn.attr('disabled', true).addClass('disabled')
                    _msg.find('.msg').html("Deleting " + _count + ", please wait...").siblings('.loader').show()
                },
                success: function (r) {
                    _modal.modal('hide');
                    if (r.success) {
                        setTimeout(function () {
                            removeDeleted(r.data);
                            clearSelection()
                        }, 800);
                        console.log(r.msg)
                    } else {
                        console.log(r.error)
                    }
                }
            });

        });

    });
})(jQuery);