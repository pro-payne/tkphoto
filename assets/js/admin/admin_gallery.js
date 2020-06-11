(function ($) {
    let store = [], maxFiles = 5, sizeCount = 0, limit = 11534336 //11MB,
        readyImg = function (data) {
            return '<div class="custom-file-img"><span data-id="' + data.id + '" class="__remove_image" title="Remove file">&times;</span>' +
                '<img class="' + data.id + '" height="40" width="40" src="../../assets/img/placeholder.png" alt=""></div>';
        },
        loadImg = function (id, _file) {
            let fileReader = new FileReader();
            fileReader.readAsDataURL(_file);

            fileReader.onload = function (e) {
                rended_data = e.target.result;
                $('.' + id, '.custom-file').attr('src', rended_data);
            }
        },
        fileChecker = function (data, file) {
            let _save = false;
            $.each(data, function (i, r) {
                if (file['name'] == r.file['name'] && file['size'] == r.file['size'] && file['type'] == r.file['type']) {
                    _save = true
                }                
            });
            if (_save) {
                console.log('Duplicate files')
            }else{                
                if(file['size'] > limit){
                    console.log('Exceeds file limit of 8MB')
                    _save = true;
                }else{
                    sizeCount += file['size'];
                }
            }

            return _save;
        };

    $.generateId = function (len) {
        var arr = new Uint8Array((len || 20) / 2)
        window.crypto.getRandomValues(arr)
        return Array.from(arr, dec2hex).join('')
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
    }
    function dec2hex(dec) {
        return ('0' + dec.toString(16)).substr(-2)
    }

    function sizeConvetor(){
        let _color = '#5cb85c';
        if(sizeCount > limit){
            _color = '#e35959';
            $('#submit-form').attr('disabled', true).addClass('disabled')
        }else{
            $('#submit-form').attr('disabled', false).removeClass('disabled')
        }
        let formatFileSize = function(bytes,decimalPoint) {
            if(bytes == 0) return '0 Bytes';
            var k = 1000,
                dm = decimalPoint || 2,
                sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
                i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
         },
         formatedSize = formatFileSize(sizeCount)

        $('#_sizeCount')
        .css({
            'color': _color
        })
        .html(formatedSize + ' / ' + formatFileSize(limit));
    }

    function restrictCount(_this) {
        let files = _this[0].files, edited = false;
        for (let i = 0; i < files.length; i++) {
            if (maxFiles != 0) {
                if (!fileChecker(store, files[i])) {
                    maxFiles -= 1;
                    edited = true;
                    let id = $.generateId();
                    store.push({
                        id: id,
                        file: files[i]
                    });
                    render(_this, id, files[i]);
                }
            }
        }
        sizeConvetor();
        if (edited && maxFiles == 0) {
            $('#add-more').attr('for', '').addClass('disabled')
        }

    }

    function render(_this, id, to_render) {
        let parent = _this.parent(),
            ready_accepted = parent.find('.file-ready');
        parent.attr({
            'for': '',
            'title': ''
        }).addClass('ready');
        ready_accepted.append(readyImg({
            id: id
        }));
        loadImg(id, to_render);
    }

    $('#image').change(function () {
        let _this = $(this);
        $('.file-error', '.gallery-select').html('')
        restrictCount(_this);
    });

    $('body').on('click', '.__remove_image', function () {
        let _this = $(this),
            _id = _this.attr('data-id'),
            _parent = _this.parent(),
            _target = null,
            _size = 0;

        $.each(store, function (i, s) {
            if (_id == s.id) {
                _target = i;
                _size = s.file.size;
            }
        });
        if (_target != null) {
            store.splice(_target, 1)
            maxFiles++;
            sizeCount -= _size;
            _parent.fadeOut(200, function () {
                $(this).remove()
            })
        }
        sizeConvetor();
        if (store.length == 0) {
            formPauseReset('holdAddMore');
        }

        if (store.length < 5) {
            $('#add-more').attr('for', 'image').removeClass('disabled')
        }
    });

    function formPauseReset(reset) {
        let _form = $('#uploadForm'), _add = $('#add-more');

        if (reset == 'holdAddMore' || reset == 'success') {
            let _main_parent = $('label.custom-file', '.gallery-select');
            _main_parent.removeClass('ready').attr({
                'title': 'Select image(s)'
            });
            if (reset == 'success') {
                _main_parent.find('.file-ready').html('')
            }
            setTimeout(function () {
                _main_parent.attr('for', 'image')
            }, 800)
        }

        if (reset == 'pause') {
            _add.attr('for', '').addClass('disabled');
            _form.find('.file-ready .__remove_image').each(function () {
                $(this).fadeOut();
            });
        }

        if (reset == 'error') {
            _add.attr('for', 'image').removeClass('disabled');
            _form.find('.file-ready .__remove_image').each(function () {
                $(this).fadeIn();
            });
        }

        if (reset == 'success') {
            _form[0].reset();
            store = [];
            maxFiles = 5;
            _add.attr('for', 'image').removeClass('disabled')
        }

    }

    $('.accordion').click(function () {
        let _this = $(this),
            _parent = _this.parent();
            if(_parent.hasClass('active')){
                _parent.removeClass('active')
            }else{
                _parent.addClass('active')
            }
    });

    $('#uploadForm').submit(function (e) {
        e.preventDefault();

        if (store.length == 0) {
            $('.file-error', '.gallery-select').html('Select at least 1 picture');
            return false;
        }
        let formData = new FormData(),
            _this = $(this),
            _btn = _this.find('button');
        formData.append('category', $.trim(_this.find('#category').val()))
        formData.append('title', $.trim(_this.find('#caption').val()))
        formData.append('date_taken', $.trim(_this.find('#date_taken').val()))

        let ajax = function () {
            $.ajax({
                url: $.host('gallery/upload'),
                data: formData,
                method: 'post',
                dataType: 'json',
                processData: false,
                contentType: false,
                error: function () {
                    _btn.attr('disabled', false).removeClass('disabled')
                    formPauseReset('error');
                },
                beforeSend: function () {
                    _btn.attr('disabled', true).addClass('disabled')
                    formPauseReset('pause');
                },
                success: function (r) {
                    if (r.success) {
                        formPauseReset('success');
                        $('#_sizeCount').html('')
                        sizeCount = 0;
                    } else {
                        // console.log(r);
                        formPauseReset('error');
                    }
                    _btn.attr('disabled', false).removeClass('disabled')
                }
            });
            return false;

        },
            length = store.length, count = 0;

        $.each(store, function (i, d) {
            formData.append('file_' + i, d.file);
            count++;
            if (length == count) {
                ajax()
            }
        });


    });
})(jQuery);