downloadCoebotData();

var channelsStr = false;

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

            var previewLg = stream.preview.template;
            previewLg = previewLg.replace(/\{width\}/gi, "848");
            previewLg = previewLg.replace(/\{height\}/gi, "477");
            //617 347
            ci += '<img src="' + previewLg + '" srcset="' 
            ci += stream.preview.medium + ' 180w, ' + stream.preview.large + ' 360w, ' + previewLg + ' 848w'
            ci += /*'" sizes="(min-width: 1200px) 75vw, (min-width: 992px) 66vw, 100vw"'*/ ' class="img-responsive"></a>';

            ci += '<div class="carousel-caption">';
            ci += '<h3 class="carousel-item-title">';
            ci += '<a href="' + getUrlToChannel(chan.channel) +'">' + chan.displayName + '</a> ';
            ci += '<a href="http://www.twitch.tv/' + chan.channel +'" target="_blank"><i class="fa fa-twitch"></i></a>';
            ci += '</h3>';
            ci += '<p>' + stream.channel.status + '</p>';
            ci += '</div>';

            ci += '</div>';

            carousel += ci;

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
}

$(document).ready(function() {

    channelsStr = stringifyChannels();
    checkIfLiveAll();
    setInterval(checkIfLiveAll, 30000);
});

$('#carousel-whoslive').on('slide.bs.carousel', function () {
  // do something…
})