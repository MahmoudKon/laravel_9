$(function () {
    let list_notifications  = $('.dropdown-notification').find('.media-list');
    let count_notifications = $('.unread-notifications-count b');

    $('body').on('click', '.read-unread-notifications', function(e) {
        e.preventDefault();
        e.stopPropagation();
        let btn = $(this);
        $.ajax({
            url: btn.attr('href'),
            type: "POST",
            success: function(data, textStatus, jqXHR) {
                if (data.count == 0) {
                    list_notifications.fadeOut(300, function () { $(this).empty() })
                    .fadeIn(300, function() {
                        list_notifications.append(notFound("no notifications"));
                    });
                } else {
                    btn.fadeOut(300, function () { btn.remove() });
                }

                count_notifications.text(data.count);
            }
        });
    });

    function notFound(message)
    {
        return `<div class="media"><p class="notification-text text-capitalize text-muted">${message}</p></div>`;
    }
});