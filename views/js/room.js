(function($) {
    $(function() {
        room.init();
    });
    let room = (function() {

        let _module;
        let $_mainContainer;

        const MAX_LENGTH_ROOM_NAME = 20;
        const AJAX_URL_CREATE_ROOM = 'room/create';
        const AJAX_URL_CONNECTING_PLAYERS = '/room/connecting?id=';

        return {
            init: function() {
                _module = this;
                $_mainContainer = $('#main-content');

                let error = $('#page-error').data('page-error');
                if (error) {
                    $('#pageErrorModal').modal('show');
                }

                $('body').on('click', '.closePageErrorModal', function (e) {
                    window.location.href = '/';
                });

                $_mainContainer.on('click', '#saveRoom', function (e) {
                    $('#room-name-error').empty();

                    let name = $('#room-name').val();
                    let error = _module.validateName(name);
                    if (error) {
                        console.log('error');
                        $('#room-name-error').append(error);
                        return;
                    }

                    $(e.target)
                        .attr('disabled', true)
                        .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Ждемс...');

                    _module.createRoom(name);
                });

                $_mainContainer.keypress(function(e) {
                    if(e.which === 13) {
                        e.preventDefault();
                        $('#saveRoom').click();
                    }
                });
            },

            validateName: function (name) {
                if (name && name.length > MAX_LENGTH_ROOM_NAME) {
                    return 'Имя должно содержать не более ' + MAX_LENGTH_ROOM_NAME + ' символов';
                }

                return '';
            },

            createRoom: function (name) {
                let ajaxParams = {name: name};
                let callback = function (response) {
                    if (response.error) {
                        $('#room-name-error').append(response.error);
                        $('#saveRoom')
                            .attr('disabled', false)
                            .html('Сохранить');
                    } else {
                        window.location.href = AJAX_URL_CONNECTING_PLAYERS + response.room_id;
                    }
                };
                _module.ajaxSend(AJAX_URL_CREATE_ROOM, ajaxParams, callback);
            },

            ajaxSend: function (url, ajaxParams, callback) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: ajaxParams,
                    dataType: 'json'
                }).done(function(response) {
                    callback(response);
                });
            }
        };
    })(jQuery);
})(jQuery);
