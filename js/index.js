downloadCoebotData();

var channelsStr = false;

function displayListChannels() {
    var container = $('.js-list-channels');
    var list = "";
    for (var i = 0; i < coebotData.channels.length; i++) {
        var chan = coebotData.channels[i];
        if (chan.isActive) {
            var li = '';
            li += '<a href="' + getUrlToChannel(chan.channel);
            li += '" class="list-group-item">';
            li += '<span class="js-islive islive-indicator" data-placement="left" data-channel="';
            li += chan.channel + '"><i class="js-islive-icon fa fa-fw"></i></span>';
            li += chan.displayName + '</a>';
            list += li;
        }
    }
    if (list == "") {
        list = '<h3>' + EMPTY_TABLE_PLACEHOLDER + '</h3>';
    }
    container.html(list);
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
}

$(document).ready(function() {

    channelsStr = stringifyChannels();
    checkIfLiveAll();
    setInterval(checkIfLiveAll, 30000);
});
