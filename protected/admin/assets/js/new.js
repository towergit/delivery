function translite(str) {
    var arr = {'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ж': 'g', 'з': 'z', 'и': 'i', 'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'ы': 'i', 'э': 'e', 'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ж': 'G', 'З': 'Z', 'И': 'I', 'Й': 'Y', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O', 'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Ы': 'I', 'Э': 'E', 'ё': 'yo', 'х': 'h', 'ц': 'ts', 'ч': 'ch', 'ш': 'sh', 'щ': 'shch', 'ъ': '', 'ь': '', 'ю': 'yu', 'я': 'ya', 'Ё': 'YO', 'Х': 'H', 'Ц': 'TS', 'Ч': 'CH', 'Ш': 'SH', 'Щ': 'SHCH', 'Ъ': '', 'Ь': '',
        'Ю': 'YU', 'Я': 'YA'};
    var replacer = function (a) {
        return arr[a] || a
    };
    
   var unformat =  str.replace(/[А-яёЁ]/g, replacer).toLowerCase()
   return unformat.replace(/ /g, '_');
}

$(document).ready(function () {
    var body = $('body');

    // Скролинг
    $('.scrollbar-macosx').scrollbar();

    /**
     * Боковая панель
     */
    function sidebar() {
        var sidebar = $('.page-sidebar'),
                toggle = sidebar.find('.toggle-sidebar'),
                mainMenu = sidebar.find('.sidebar-menu'),
                visible = 'sidebar-visible',
                fixed = 'sidebar-fixed';

        // Cookie
        function cookie() {
            var cookie = $.cookie(fixed);

            if (cookie) {
                body.addClass(fixed);
                toggle.find('i').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
            }
        }

        // При наведении на боковую панель
        function hoverSidebar() {
            sidebar.hover(function () {
                if (!body.hasClass(fixed)) {
                    body.addClass(visible);
                    $(this).find('.controls').fadeIn(400);
                }
            }, function () {
                if (!body.hasClass(fixed))
                    $(this).find('.controls').fadeOut(400);

                body.removeClass(visible);
            });
        }

        // Переключение меню
        function toggleMenu() {
            toggle.on('click', function () {
                if (!body.hasClass(fixed)) {
                    $(this).children().removeClass('fa-circle-o').addClass('fa-dot-circle-o');
                    $.cookie(fixed, 1);
                    body.addClass(fixed);
                } else {
                    $(this).children().removeClass('fa-dot-circle-o').addClass('fa-circle-o');
                    $.removeCookie(fixed);
                    body.removeClass(fixed);
                }
            });
        }

        // Выпадающее меню
        function dropDownMenu() {
            mainMenu.find('a').on('click', function () {
                var ul = $(this).nextAll('ul');

                if (ul.hasClass('sub-menu')) {
                    if (!$(this).parents().hasClass('open')) {
                        $(this).parent().addClass('open');
                        ul.slideDown(400);
                    } else {
                        $(this).parents().removeClass('open');
                        ul.slideUp(400);
                    }
                }
            });
        }

        function activeItemMenu() {
            $('.menu-items li.active').parents('li').addClass('active');
        }

        cookie();
        hoverSidebar();
        toggleMenu();
        dropDownMenu();
        activeItemMenu();
    }

    /**
     * Чат
     */
    function chat() {
        var chat = $('.chat-wrapper'),
                chatHeight = chat.outerHeight();

        // Открытие чата
        function show() {
            $('.open-chat').on('click', function () {
                chat.addClass('open');
            });
        }

        // Закрытие чата
        function close() {
            chat.find('.close').click(function () {
                $(this).parent().removeClass('open');
            });
        }

        chat.find('.scrollbar-macosx').scrollbar();
        chat.find('.view-content').css('height', chatHeight - 120 + 'px');

        // Получение всех сообщений пользователя
        function getUserMessages() {
            chat.find('.view-users a').on('click', function () {
                chat.find('.content').addClass('push-parallax');
            });
        }

        // Поиск пользователей
        function searchUsers() {
            chat.find('#search-user').keyup(function () {
                var search = $(this).val();

                if (search.length > 0) {
                    alert(1);
                }
            });
        }

        // Отправка сообщения
        function sendMessage() {
            chat.find('#send-message').keyup(function (e) {
                if (e.keyCode == 13) {
                    alert();
                }
            });
        }

        // Получение всех пользователей
        function getUsers() {
            chat.find('.action').on('click', function () {
                chat.find('.content').removeClass('push-parallax');
            });
        }

        // Груповые сообщения
        function groupMessages() {
            chat.find('.chat .message').each(function () {
                if ($(this).hasClass('from-them')) {
                    $(this).prevUntil('.from-me').addClass('group-message');
                    $(this).nextUntil('.from-me').addClass('group-message');
                } else {
                    $(this).prevUntil('.from-them').addClass('group-message');
                    $(this).nextUntil('.from-them').addClass('group-message');
                }
            });

            chat.find('.chat .group-message.from-them:first, .chat .group-message.from-me:first').css({
                'margin-top': '8px',
                'border-radius': '12px 12px 0 0'
            });
            chat.find('.chat .group-message.from-them:last, .chat .group-message.from-me:last').css({
                'margin-bottom': '8px',
                'border-radius': '0 0 12px 12px'
            });
        }

        show();
        close();
        searchUsers();
        sendMessage();
        getUsers();
        getUserMessages();
        groupMessages();
    }

    /**
     * Глобальный поиск
     */
    function globalSearch() {
        var search = $('.global-search'),
                link = $('.search-link');

        // Открытие поиска
        function open() {
            link.on('click', function () {
                search.removeClass('close');
            });
        }

        // Закрытие чата
        function close() {
            search.find('a.close-search').on('click', function () {
                search.addClass('close');
            });
        }

        open();
        close();
    }

    /**
     * Уведомления
     */
    function notification() {
        var notification = $('.notification');

        // Закрытие по нажатию
        function clickClose() {
            notification.find('.close').on('click', function () {
                var message = $(this).parent();

                message.removeClass('zoomInUp').addClass('zoomOutRight');
                setTimeout(function () {
                    message.alert('close');
                }, 800);
            });
        }

        clickClose();
    }

    $('button[data-toggle="dropdown"]').on('click', function () {
        $(this).parent('.dropdown').addClass('open');
    });

    $('#ObjectHelp_title').on('change', function () {
        var alias = translite($(this).val());
        $('#ObjectHelp_alias').val(alias);
    });
    
    sidebar();
    chat();
    globalSearch();
    notification();
});