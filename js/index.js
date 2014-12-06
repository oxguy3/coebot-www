downloadCoebotData();

function displayListChannels() {
    var container = $('.js-list-channels');
    var list = "";
    for (var i = 0; i < coebotData.channels.length; i++) {
        var chan = coebotData.channels[i];
        if (chan.isActive) {
            var li = '<a href="' + getUrlToChannel(chan.channel);
            li += '" class="list-group-item text-center">' + chan.displayName + '</a>';
            list += li;
        }
    }
    if (list == "") {
        list = '<h3>' + EMPTY_TABLE_PLACEHOLDER + '</h3>';
    }
    container.html(list);
}