(function($) {
    $(function() {
        room.init();
    });
    let room = (function() {

        let _module;
        let $_mainContainer;
        let $_roomTable;
        let roomId = 0;
        let userIdsList = '';

        const MAX_LENGTH_ROOM_NAME = 20;
        const AJAX_URL_CREATE_ROOM = '/room/create';
        const AJAX_URL_UPDATE_ROOM = '/room/update';
        const AJAX_URL_LEAVE_ROOM = '/room/leave';
        const AJAX_URL_CONNECTING_PLAYERS = '/room/connecting?id=';
        const AJAX_URL_START_GAME = '/room/gameStart';
        const AJAX_URL_PLAY_GAME = '/game/play?id=';
        const TIME_UPDATE_IN_SEC = 10;
        const MIN_PLAYERS_FOR_START_GAME = 3;

        return {
            init: function() {
                _module = this;
                _module.setRoomData();
                $_mainContainer = $('#main-content');
                $_roomTable = $('#roomTable');

                let error = $('#page-error-text').data('show-error');
                if (error) {
                    showError();
                }

                if (roomId) {
                    _module.startUpdatingRoom();
                    _module.availableStartGame();
                }

                $_mainContainer.on('click', '#saveRoom', function (e) {
                    $('#room-name-error').empty();

                    let name = $('#room-name').val();
                    let error = _module.validateName(name);
                    if (error) {
                        console.log('error');
                        $('#room-name-error').append(error);
                        return;
                    }
                    showButtonLoader($(e.target));

                    _module.createRoom(name);
                });

                $_roomTable.on('click', '#leaveRoom', function (e) {
                    let userId = $(e.target).data('user-id');
                    showButtonLoader($(e.target));

                    _module.leaveRoom(userId);
                });

                $_mainContainer.keypress(function(e) {
                    if(e.which === 13) {
                        e.preventDefault();
                        $('#saveRoom').click();
                    }
                });

                $('#startGame').on('click', function (e) {
                    showButtonLoader($(e.target));
                    _module.startGame();
                });
            },

            setRoomData: function () {
                const roomData = $('#roomData');
                roomId = roomData.data('room-id');
                userIdsList = roomData.data('user-ids-list');
            },

            startUpdatingRoom: function () {
                const ajaxParams = {room_id: roomId};
                const callback = function(response) {
                    if (response.error) {
                        console.log(response.error);
                        return;
                    }

                    if (response.start_game) {
                        window.location.href = AJAX_URL_START_GAME;
                        return;
                    }

                    if (response.user_ids_list !== userIdsList) {
                        let lostAndNewUserIds = _module.getLostAndNewUserIds(response.user_ids_list);
                        userIdsList = response.user_ids_list;

                        if (lostAndNewUserIds.lostIds.length) {
                            _module.deleteExitedUsers(lostAndNewUserIds.lostIds);
                            _module.recalculateIndex();
                        }

                        if (lostAndNewUserIds.newIds.length) {
                            _module.renderConnectedUsers(lostAndNewUserIds.newIds, response.users);
                        }

                        _module.availableStartGame();
                    }
                };

                setInterval(function() {
                        ajaxSend(AJAX_URL_UPDATE_ROOM, ajaxParams, callback);
                    },
                    TIME_UPDATE_IN_SEC * 1000
                );
            },

            getLostAndNewUserIds: function (newUserIdsList) {
                let oldUserIds = userIdsList.split(',');
                let newUserIds = newUserIdsList.split(',');

                return {
                    lostIds: _module.getIdsDiff(oldUserIds, newUserIds),
                    newIds: _module.getIdsDiff(newUserIds, oldUserIds)
                };
            },

            getIdsDiff: function (mainIdsList, newIdsList) {
                let ids = [];
                $(mainIdsList).each(function(index, id) {
                    if ($.inArray(id, newIdsList) === -1) {
                        ids.push(id);
                    }
                });

                return ids;
            },

            deleteExitedUsers: function (userIds) {
                $(userIds).each(function(index, id) {
                    $('#user-table-row-' + id).hide(500); //animation
                });

                setTimeout(() => {
                    $(userIds).each(function(index, id) {
                        $('#user-table-row-' + id).remove();
                    });
                }, 600);
            },

            renderConnectedUsers: function (newUserIds, users) {
                const userIds = userIdsList.split(',');
                let i = userIds.length - newUserIds.length;
                $(newUserIds).each(function(index, id) {
                    i++;
                    _module.renderUserInTable(i, users[id]);
                });
            },

            recalculateIndex: function () {
                const userIds = userIdsList.split(',');
                let newIndex = 1;
                $(userIds).each(function(index, id) {
                    $('#index-user-id-' + id).text(newIndex);
                    newIndex++;
                });
            },

            renderUserInTable: function (index, user) {
                let row = (
                    '<tr id="user-table-row-' + user.id + '" style="display: none;">' +
                        '<td id="index-user-id-' + user.id + '">' + index + '</td>' +
                        '<td>' +
                            '<img src="' + user.avatar + '">' +
                            user.name +
                        '</td>' +
                        '<td>' +
                        '</td>' +
                    '</tr>'
                );
                $('.user-table-body').append(row);
                $('#user-table-row-' + user.id).show(800);

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
                        hideButtonLoader($('#saveRoom'), 'Сохранить');
                    } else {
                        window.location.href = AJAX_URL_CONNECTING_PLAYERS + response.room_id;
                    }
                };
                ajaxSend(AJAX_URL_CREATE_ROOM, ajaxParams, callback);
            },

            leaveRoom: function (userId) {
                let ajaxParams = {
                    user_id: userId,
                    room_id: roomId
                };
                let callback = function (response) {
                    if (response.error) {
                        console.log(response.error);
                    }

                    if (response.need_redirect) {
                        window.location.href = '/';
                        return;
                    }

                    hideButtonLoader($('#leaveRoom'), 'Выйти');
                };
                ajaxSend(AJAX_URL_LEAVE_ROOM, ajaxParams, callback);
            },

            availableStartGame: function () {
                let startGameButton = $('#startGame');
                let countPlayers = userIdsList.split(',').length;

                if (countPlayers >= MIN_PLAYERS_FOR_START_GAME) {
                    startGameButton.attr('disabled', false);
                } else {
                    startGameButton.attr('disabled', true);
                }
            },

            startGame: function () {
                let ajaxParams = {room_id: roomId};
                let callback = function (response) {
                    if (response.error) {
                        console.log(response.error);
                        showError(response.error);
                        hideButtonLoader($('#startGame'), 'Старт игры');
                    } else {
                        console.log('redirect to ' + AJAX_URL_PLAY_GAME + response.game_id);
                        // window.location.href = AJAX_URL_PLAY_GAME + response.game_id;
                    }
                };
                ajaxSend(AJAX_URL_START_GAME, ajaxParams, callback);
            }
        };
    })(jQuery);
})(jQuery);
