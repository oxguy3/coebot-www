downloadCoebotData();

var channelsStr = false;

function displayListChannels() {
    //$('.js-islive').popover('hide');
    var container = $('.js-list-channels');
    var list = "";
    for (var i = 0; i < coebotData.channels.length; i++) {
        var chan = coebotData.channels[i];
        if (chan.isActive) {
            var li = '';
            li += '<a href="' + getUrlToChannel(chan.channel);
            li += '" class="list-group-item js-islive" data-placement="bottom" data-channel="';
            li += chan.channel + '">';
            
            //li += '<span class="islive-indicator"><i class="js-islive-icon fa fa-fw"></i></span>';
            li += chan.displayName;
            
            li += '</a>';
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


    var listContainer = $('.js-whoslive-list');
    var list = "";

    var carouselContainer = $('.js-whoslive-carousel');
    var carousel = "";

    var currLiveIndex = 0;

    for (var i = 0; i < coebotData.channels.length; i++) {
        var chan = coebotData.channels[i];

        var stream = findChannelInStreams(allStreamData, chan.channel);
        var liveStatus = getLiveStatus(stream);

        if (chan.isActive && liveStatus == isLiveOn) {
            var li = '';
            li += '<a href="#carousel-whoslive" data-slide-to="' + (currLiveIndex++);
            li += '" class="list-group-item">';
            
            li += chan.displayName;
            
            li += '</a>';
            list += li;


            var ci = '';
            ci += '<div class="item' + (carousel=="" ? ' active' : '') + '">';
            ci += '<a href="' + getUrlToChannel(chan.channel) + '">';

            var streamImageUrl = stream.preview.template;
            streamImageUrl = streamImageUrl.replace(/\{width\}/gi, "848");
            streamImageUrl = streamImageUrl.replace(/\{height\}/gi, "477");
            ci += '<img src="' + streamImageUrl + '" class="img-responsive"></a>';

            ci += '<div class="carousel-caption">';
            ci += '<h3 class="carousel-item-title">';
            ci += '<a href="' + getUrlToChannel(chan.channel) +'">' + chan.displayName + '</a> ';
            ci += '<a href="http://www.twitch.tv/' + chan.channel +'" target="_blank"><i class="fa fa-twitch"></i></a>';
            ci += '</h3>';
            ci += '<p>' + stream.channel.status + '</p>';
            ci += '</div>';

            ci += '</div>';

            carousel += ci;

            // <div class="carousel-caption">
            //   <h3>Coestar</h3>
            //   <p><a href="http://twitch.tv/coestar">Space Enginerds #StreamADay (Day 378)</a></p>
            // </div>

        }
    }
    var parent = $('.js-whoslive-containers');
    if (list == "") {
        parent.css("display", "none");
    } else {
        parent.css("display", "block");
    }
    listContainer.html(list);
    carouselContainer.html(carousel);

    //updateIsLive(json.streams);
    //moveLiveToTop();
}

// function moveLiveToTop() {
//     sortUnorderedList('.js-list-channels');
//     var container = $('.js-list-channels');
//     var liveChannelLis = container.children('.islive-live');
//     container.prepend(liveChannelLis);
// }

$(document).ready(function() {

    channelsStr = stringifyChannels();
    checkIfLiveAll();
    setInterval(checkIfLiveAll, 30000);
});