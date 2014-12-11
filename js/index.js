downloadCoebotData();

var channelsStr = false;

function displayListChannels() {
    $('.js-islive').popover('hide');
    var container = $('.js-list-channels');
    var list = "";
    for (var i = 0; i < coebotData.channels.length; i++) {
        var chan = coebotData.channels[i];
        if (chan.isActive) {
            var li = '';
            li += '<a href="' + getUrlToChannel(chan.channel);
            li += '" class="list-group-item js-islive" data-placement="bottom" data-channel="';
            li += chan.channel + '">';
            li += '<span class="islive-indicator"><i class="js-islive-icon fa fa-fw"></i></span>';
            li += chan.displayName + '</a>';
            list += li;
        }
    }
    if (list == "") {
        list = '<h3>' + EMPTY_TABLE_PLACEHOLDER + '</h3>';
    }
    container.html(list);

    // var liveChannelLis = container.children('.islive-live');
    // container.prepend(liveChannelLis);
}

function stringifyChannels() {
    var str = '';
    for (var i = 0; i < coebotData.channels.length; i++) {
        str += coebotData.channels[i].channel + ',';
    }
    return str;
}

function checkIfLiveAll() {
    checkIfLive(channelsStr, handleAllIsLive);
}

function handleAllIsLive(json) {
    if (!json) {
        alert("Failed to load Twitch stream data!");
        allStreamData = false;
    } else {
        allStreamData = json.streams;
    }
    updateIsLive(json.streams);
    moveLiveToTop();
}

function moveLiveToTop() {
    sortUnorderedList('.js-list-channels');
    var container = $('.js-list-channels');
    var liveChannelLis = container.children('.islive-live');
    container.prepend(liveChannelLis);
}

$(document).ready(function() {

    channelsStr = stringifyChannels();
    checkIfLiveAll();
    setInterval(checkIfLiveAll, 30000);
});