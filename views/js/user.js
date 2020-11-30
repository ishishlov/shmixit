(function($) {
    $(function() {
        user.init();
    });
    let user = (function() {

        let _module;
        let $_mainContainer;

        const MIN_LENGTH_NAME = 3;
        const MAX_LENGTH_NAME = 20;
        const AJAX_URL_SAVE_NAME = 'user/addUser';
        const AJAX_URL_LOGIN = 'user/logIn';
        const AJAX_URL_LOGOUT = 'user/logOut';

        return {
            init: function() {
                _module = this;
                $_mainContainer = $('.user-navbar');

                $_mainContainer.on('click', '#saveUser', function (e) {
                    $('#user-name-error').empty();

                    let name = $('#user-name').val();
                    let error = _module.validateName(name);
                    if (error) {
                        $('#user-name-error').append(error);
                        return;
                    }
                    showButtonLoader($(e.target));

                    _module.saveName(name);
                });

                $_mainContainer.keypress(function(e) {
                    if(e.which === 13) {
                        e.preventDefault();
                        $('#saveUser').click();
                    }
                });

                $_mainContainer.on('change', '#login', function (e) {
                    let userId = $(e.target).val();
                    let ajaxParams = {userId: userId};
                    let callback = function () {
                        location.reload();
                    };

                    ajaxSend(AJAX_URL_LOGIN, ajaxParams, callback);
                });

                $_mainContainer.on('click', '#logout', function (e) {
                    e.preventDefault();
                    let ajaxParams = {};
                    let callback = function () {
                        location.reload();
                    };
                    showButtonLoader($(e.target));
                    ajaxSend(AJAX_URL_LOGOUT, ajaxParams, callback);
                });

            },

            validateName: function (name) {
                if (!name) {
                    return 'Введите имя';
                }

                if (name.length < MIN_LENGTH_NAME || name.length > MAX_LENGTH_NAME) {
                    return 'Имя должно содержать от ' + MIN_LENGTH_NAME + ' до ' + MAX_LENGTH_NAME + ' символов';
                }

                return '';
            },

            saveName: function (name) {
                let ajaxParams = {name: name};
                let callback = function (response) {
                    if (response.error) {
                        $('#user-name-error').append(response.error);
                        hideButtonLoader($('#saveUser'), 'Сохранить');
                    } else {
                        location.reload();
                    }
                };
                ajaxSend(AJAX_URL_SAVE_NAME, ajaxParams, callback);
            }
        };
    })(jQuery);
})(jQuery);
