(function ($) {
    $.hostroot = function (url, reset) {
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

    let raw_request = false, _file = null, formData, upload_file = false;

    function formCollector(_form, target, action) {
        raw_request = true;
        formData = new FormData();
        formData.append('title', _form.find('#title').val());
        if (target == 'resource') {
            if (!upload_file) {
                _form.find('.file-error').html('No file selected for upload');
                return false;
            }

            formData.append('image', _file);
      
            processData(_form, 'slideshow/new', 'edit', 'slideshow');
        } else if (target == 'update_resource') {

        }
    }

    function processData(_this, url, action, callback) {
        let _btn = _this.find('button.btn'),
            form, processData = true, contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
        if (raw_request) {
            processData = false;
            contentType = false;
            form = formData;
        } else {
            form = _this.serialize();
        }
        $.ajax({
            url: $.hostroot(url),
            method: 'post',
            dataType: 'json',
            processData: processData,
            contentType: contentType,
            data: form,
            beforeSend: function () {
                _btn.attr('disabled', true).addClass('disabled')
            },
            success: function (r) {
                if (r.success) {
                    _this[0].reset();
                    if (action == 'edit') {
                        window.location.href = $.hostroot('admin/' + callback, 'reset');
                    } else if (action == 'delete') {
                        deleteHandle(callback);
                    }
                    upload_file = false;
                } else {

                }
                _btn.attr('disabled', false).removeClass('disabled')
            },
            error: function () {
                _btn.attr('disabled', false).removeClass('disabled')
            }
        });
    }

    function deleteHandle(row) {
        $('._confirm').modal('hide');
        let parent = row.parent().children().length,
            multi_layer = function(row, parent, _main_){
               
                if(parent == 1){                    
                    row.parent().parent().parent().remove();
                }
                if(_main_ == 1){
                    $('.__empty_content').removeClass('hide');
                }
            };

        setTimeout(function () {
            row.fadeOut(200, function () {
                let _main_ = $('.box-body','body').find('.resource-row').length;
                if(_main_ != 0){
                    multi_layer($(this), parent, _main_);
                }else{
                    if (parent == 1) {
                        $('.__body_content', '.box-body').addClass('hide');
                        $('.__empty_content').removeClass('hide');
                    }
                }
                // $(this).remove()
            })
        }, 800);

    }

    function resource_file(data) {
        let _parent = data._parent,
            _for = data._for,
            _error = data._error,
            fileSupport = function (file_type) {
                let types = ['image/png', 'image/jpeg'],
                    supported = false;
                for (var i = 0; i < types.length; i++) {
                    if (types[i] == file_type) {
                        supported = true;
                        break;
                    }
                }
                return supported;
            };

        _file = data._file;

        _error.html('')

        if (_for == 'image') {
            $('#attachment').val('');
            let fileReader = new FileReader();
            fileReader.readAsDataURL(_file);

            if (fileSupport(_file['type'])) {
                _parent.addClass('ready').find('.custom-file-text').html(_file['name']);
            } else {
                _error.html('Image type not supported, only JPG/JPEG, PNG images are supported');
                return false;
            }

            fileReader.onload = function (e) {
                rended_data = e.target.result;
                upload_file = true;
                _parent.attr('title', 'Change selected image').find('.custom-file-img img').attr('src', rended_data);
            }
        }
    }

    $(function () {

        $('#newResource-form').submit(function (e) {
            e.preventDefault();
            formCollector($(this), 'resource', 'new');
        });

        $('._delete').click(function (e) {
            e.preventDefault();
            let _this = $(this),
                _modal = $('._confirm'),
                _data = JSON.parse(_this.attr('data-target'));
            _modal.find('#target_item').val(_data.item);
            _modal.find('#target_row').val(_data.row);
            _modal.find('.__confirm-item-title').text(_data.title);
            _modal.find('.__confirm-item-target').text(_data.target);
            _modal.find('form').attr('action', _data.action);
            _modal.modal('show');
        });

        $('#_confirm-form').submit(function (e) {
            e.preventDefault();
            const _this = $(this),
                target = $('.' + $(this).find('#target_row').val(), '.box-body');
            processData(_this, _this.attr('action'), 'delete', target);
        });

        $('._select_file').change(function () {
            let _this = $(this),
                _parent = _this.offsetParent();
            resource_file({
                _parent: _parent,
                _for: _parent.attr('for'),
                _file: _this[0].files[0],
                _error: _parent.siblings('.file-error')
            });
        });

    });
})(jQuery);
