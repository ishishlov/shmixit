(function($) {
    $(function() {
        index.init();
    });
    let index = (function() {

        let _module;
        let $_mainContainer;

        const MAX_LENGTH_NAME = 20;

        return {
            init: function() {
                _module = this;
                $_mainContainer = $('#main-content');

                $_mainContainer.on('click', '#saveRoom', function () {
                    $('#room-name-error').empty();

                    let nameRoom = $('#room-name').val();
                    let error = _module.validateName(nameRoom);
                    if (error) {
                        $('#room-name-error').append(error);
                        return;
                    }

                    $('#mdb-preloader').delay(1000).fadeOut(300);
                });

                $_mainContainer.keypress(function(e) {
                    if(e.which === 13) {
                        e.preventDefault();
                        $('#saveRoom').click();
                    }
                });
            },

            validateName: function (name) {
                if (name.length > MAX_LENGTH_NAME) {
                    return 'Название должно содержать не более ' + MAX_LENGTH_NAME + ' символов';
                }

                return '';
            }
        };
    })(jQuery);
})(jQuery);
