var EMPTY_TABLE_PLACEHOLDER = 'There\'s nothing here... <i class="fa fa-frown-o"></i>';

function prettifyStringVariables(str) {
    var pattern = /\(_(\w+)_\)/g;
    var replacement = '<span class="label label-default">$1</span>';
    str = str.replace(pattern, replacement);
    return str;
}

function prettifyRegex(pattern) {
    pattern = pattern.replace(/\.\*/g, '*');
    pattern = pattern.replace(/(\\Q|\\E)/g, "");
    return pattern;
}

// channels.json json file
var coebotData = false;

function downloadCoebotData() {
    $.ajax({
        async: false, // it's my json and i want it NOW!
        dataType: "json",
        url: "/channels.json",
        success: function(json) {
            console.log("Loaded Coebot data");
            coebotData = json;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Failed to load Coebot data!");
        }
    });
}

function getCoebotDataChannel(chan) {
    for (var i = 0; i < coebotData.channels.length; i++) {
        if (coebotData.channels[i].channel == chan) {
            return coebotData.channels[i];
        }
    }
    return null;
}

function getUrlToChannel(chan) {
    return "/channel/" + chan + "/";
}


/**
 * states of liveness
 * 0 = error
 * 1 = offline
 * 2 = live
 * 3 = loading
 */

var isLiveErr = 0;
var isLiveOff = 1;
var isLiveOn = 2;
var isLiveLoad = 3;

var isLiveClasses = [
    "fa-exclamation-triangle text-warning",
    "fa-toggle-off text-muted",
    "fa-toggle-on text-primary",
    "fa-refresh fa-spintext-muted"
];
var isLiveClassesAll = isLiveClasses.join(" ");

var isLiveTitles = [
    "Couldn't access Twitch",
    "Offline",
    "Live",
    "Loading..."
];

// checks if the stream is live
function checkIfLive(channels, callback) {
    var heading = $('.js-islive');
    var icon = heading.children(".js-islive-icon");
    icon.removeClass(isLiveClassesAll);
    icon.addClass(isLiveClasses[isLiveLoad]);
    queryTwitchStreams(channels, callback);

}

function queryTwitchStreams(channels, callback) {
    $.ajax({
        dataType: "jsonp",
        data: {
            channel: channels
        },
        jsonp: "callback",
        url: "https://api.twitch.tv/kraken/streams",
        success: function(json) {
            console.log("Loaded Twitch streams: " + channels);
            callback(json);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("Failed to load Twitch streams: " + channels);
            callback(false);
        }
    });

}

function getLiveStatus(stream) {
    var liveStatus = isLiveErr;
    if (typeof stream !== 'boolean') {
        liveStatus = (stream != null) ? isLiveOn : isLiveOff;
    }
    return liveStatus;
}

// updates the indicator that shows if the channel is currently streaming
function updateIsLive(streams) {

    $('.js-islive').each(function(index){
        var current = $(this);

        var currChannel = current.attr("data-channel");
        if (typeof currChannel === 'undefined' && typeof channel !== 'undefined') {
            currChannel = channel;
        }

        var stream = findChannelInStreams(streams, currChannel);
        var liveStatus = getLiveStatus(stream);

        var icon = current.find(".js-islive-icon");

        // style the indicator with the right colors and icon
        icon.removeClass(isLiveClassesAll);
        icon.addClass(isLiveClasses[liveStatus]);

        // get the hover text. if we're live, it's fancier
        var popover = isLiveTitles[liveStatus];
        if (liveStatus == isLiveOn) {
            popover = '<div class="islive-popover">';
            popover += '<img src="'+stream.preview.medium+'<" class="img-responsive" height="180" width="320">';
            popover += '<i class="fa fa-gamepad"></i> ' + stream.channel.game + '<br>';
            popover += '<i class="fa fa-eye"></i> ' + Humanize.intComma(stream.viewers) + '';
            popover += '</div>';

            current.attr("data-title", stream.channel.status);
            current.addClass("islive-live");
        } else {
            current.removeAttr("data-title");
            current.removeClass("islive-live");
        }

        current.attr("data-content", popover);

        current.popover({
            html: true,
            container: 'body',
            trigger: 'hover'
        });
    });
}

function findChannelInStreams(streams, channel) {
    for (var i = 0; i < streams.length; i++) {
         if (streams[i].channel.name == channel) {
            return streams[i];
         }
    }
    return null;
}


function sortUnorderedList(selector) {
    var mylist = $(selector);
    var listitems = mylist.children('li').get();
    listitems.sort(function(a, b) {
       var compA = $(a).text().toUpperCase();
       var compB = $(b).text().toUpperCase();
       return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
    })
    $.each(listitems, function(idx, itm) { mylist.append(itm); })
}