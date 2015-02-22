downloadCoebotData();

var channelsStr = false;

var isFirstUpdate = true;


function createWhosliveCarousel() {
    $("#carousel-whoslive").html($("#carousel-whoslive").html()); // remove all js listeners and such
    $("#carousel-whoslive").carousel();

    $('#carousel-whoslive').on('slide.bs.carousel', function (e) {
        var transitionOptions = {
            duration: 400,
            easing: "linear"
        };

        var targetIndex = $(e.relatedTarget).attr("data-slide-index");/*$('#carousel-whoslive').find(".item.active")*/

        $('.js-whoslive-list .list-group-item.active').removeClass("active", transitionOptions);
        $('.js-whoslive-list .list-group-item[data-slide-to=' + targetIndex + ']').addClass("active", transitionOptions);
    });
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

    var totalViewers = 0;

    for (var i = 0; i < coebotData.channels.length; i++) {
        var chan = coebotData.channels[i];

        var stream = findChannelInStreams(allStreamData, chan.channel);
        var liveStatus = getLiveStatus(stream);

        if (chan.isActive && liveStatus == isLiveOn) {
            var li = '';
            li += '<a href="#carousel-whoslive" data-slide-to="' + currLiveIndex;
            li += '" class="list-group-item' + (list=="" ? ' active' : '') + '">';
            
            li += chan.displayName;
            
            li += '</a>';
            list += li;


            var ci = '';
            ci += '<div class="item' + (carousel=="" ? ' active' : '');
            ci += '" data-slide-channel="' + chan.channel + '" data-slide-index="' + currLiveIndex + '">';
            ci += '<a href="' + getUrlToChannel(chan.channel) + '">';

            var previewAspectRatio = 16/9;
            var previewTemplate = stream.preview.template + '?' + ((new Date).getTime());
            var preview1080p = getPreviewAtSize(previewTemplate, previewAspectRatio, 1080);
            var preview720p = getPreviewAtSize(previewTemplate, previewAspectRatio, 720);
            var preview480p = getPreviewAtSize(previewTemplate, previewAspectRatio, 480);
            var preview360p = stream.preview.large; // getPreviewAtSize(previewTemplate, previewAspectRatio, 360);
            var preview180p = stream.preview.medium; // getPreviewAtSize(previewTemplate, previewAspectRatio, 180);
            
            ci += '<img src="' + preview720p + '" srcset="' ;
            ci += preview180p + ' 320w, ' + preview360p + ' 640w, ' + preview480p + ' 854w, ';
            ci += preview720p + ' 1280w, ' + preview1080p + ' 1920w';
            ci += '" sizes="(min-width: 1200px) 848px, (min-width: 992px) 617px, (min-width: 768px) 720px, 100vw" class="img-responsive img-rounded"></a>';

            ci += '<div class="carousel-caption">';
            ci += '<h3 class="carousel-item-title">';
            ci += '<a href="' + getUrlToChannel(chan.channel) +'">' + chan.displayName + '</a> ';
            ci += '<a href="http://www.twitch.tv/' + chan.channel +'" target="_blank"><i class="icon-twitch"></i></a>';
            ci += '</h3>';
            ci += '<p>' + stream.channel.status + '</p>';
            ci += '</div>';

            ci += '</div>';

            carousel += ci;

            if (typeof stream.viewers !== 'undefined') {
                totalViewers += stream.viewers;
            }

            currLiveIndex++;

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

    $('.js-totalChannels').html(Humanize.intComma(currLiveIndex));
    $('.js-totalViewers').html(Humanize.intComma(totalViewers));
}

// given a twitch preview image template url, gives you a url for a specified resolution
function getPreviewAtSize(template, aspectRatio, resolution) {
    var width = Math.ceil(aspectRatio * resolution);
    return template.replace(/\{width\}/gi, width).replace(/\{height\}/gi, resolution);
}

$(document).ready(function() {

    createWhosliveCarousel();
    channelsStr = stringifyChannels();
    checkIfLiveAll();
    //setInterval(preserveStateAndCheckAll, 5000);

});