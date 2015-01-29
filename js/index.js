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

            var previewAspectRatio = 16/9;
            var previewTemplate = stream.preview.template;
            var preview1080p = getPreviewAtSize(previewTemplate, previewAspectRatio, 1080);
            var preview720p = getPreviewAtSize(previewTemplate, previewAspectRatio, 720);
            var preview480p = getPreviewAtSize(previewTemplate, previewAspectRatio, 480);
            var preview360p = stream.preview.large; // getPreviewAtSize(previewTemplate, previewAspectRatio, 360);
            var preview180p = stream.preview.medium; // getPreviewAtSize(previewTemplate, previewAspectRatio, 180);
            
            ci += '<img src="' + preview720p + '" srcset="' ;
            ci += preview180p + ' 320w, ' + preview360p + ' 640w, ' + preview480p + ' 854w, ';
            ci += preview720p + ' 1280w, ' + preview1080p + ' 1920w';
            ci += '" sizes="(min-width: 1200px) 848px, (min-width: 992px) 617px, (min-width: 768px) 405px, 100vw" class="img-responsive"></a>';

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

// given a twitch preview image template url, gives you a url for a specified resolution
function getPreviewAtSize(template, aspectRatio, resolution) {
    var width = Math.ceil(aspectRatio * resolution);
    return template.replace(/\{width\}/gi, width).replace(/\{height\}/gi, resolution);
}

$(document).ready(function() {

    channelsStr = stringifyChannels();
    checkIfLiveAll();
    setInterval(checkIfLiveAll, 30000);
});

$('#carousel-whoslive').on('slide.bs.carousel', function () {
  // do something…
})