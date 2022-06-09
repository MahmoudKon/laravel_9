var pusher = new Pusher('8a54692d8cd3a078d328', {
    cluster: 'eu',
    encrypted: true,
});

var channel = pusher.subscribe('status-liked');
channel.bind('App\\Events\\StatusLiked', function(data) {
    console.log(data.message);
    toast(data.message);
});
