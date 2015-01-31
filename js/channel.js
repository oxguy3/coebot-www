downloadCoebotData();
var channelCoebotData = getCoebotDataChannel(channel);
var isHighlightsLoaded = false;

var hlstreamTable = false;

var hashPostfix = "";

function enableSidebar() {

	$('#navSidebar a.js-sidebar-link').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
        //var hashExtension = HASH_DELIMITER + window.location.hash.substr(1).split(HASH_DELIMITER).splice(0,1).join(HASH_DELIMITER);
        window.location.hash = "#" + $(this).attr("href").substr(5) + hashPostfix;// + hashExtension;
        hashPostfix = "";

        $('#channelSidebarCollapse').collapse('hide');
	});

	$('#navSidebar a.js-sidebar-link').on('shown.bs.tab', function (e) {
		var tab = e.target;

        //TODO functionify tab updates!
        var tabIconHtml = $(tab).children('.sidebar-icon').html();
        var tabTitleHtml = $(tab).children('.sidebar-title').html();

        $(".js-channel-tab-icon").html(tabIconHtml);
        $(".js-channel-tab-title").html(tabTitleHtml);
	});

    $('#navSidebar a.js-sidebar-link[href="#tab_highlights"]').on('show.bs.tab', function (e) {
        if (!isHighlightsLoaded) {
            loadChannelHighlights();
        }
    })
}

function tabContentLoaded() {
    if (window.location.hash != "") {
        var explodedHash = window.location.hash.substr(1).split(HASH_DELIMITER);
        var jumpToTab = explodedHash.splice(0,1);
        if (explodedHash.length >= 1) {
            hashPostfix = HASH_DELIMITER + explodedHash.join(HASH_DELIMITER);
        }

        $('#navSidebar a[href="#tab_' + jumpToTab + '"]').click();
    }

    $('#hlStreamModal').on('hidden.bs.modal', function (e) {
        window.location.hash = window.location.hash.split(HASH_DELIMITER)[0];
    });
}

// channel config data
var channelData = false;
var channelTwitchData = false;
var twitchEmotes = false;
var channelStreamData = false;
var highlightsStats = false;
var currentHlstream = false;

function downloadChannelData() {
	$.ajax({
		async: false, // it's my json and i want it NOW!
		dataType: "json",
		url: "/configs/" + channel + ".json",
		success: function(json) {
            console.log("Loaded channel data");
			channelData = json;
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert("Failed to load channel data!");
			window.location = "/";
		}
	});
}

downloadChannelData();

function displayChannelTitle() {
	var titleHtml = ((channelCoebotData.displayName&&channelCoebotData.displayName=="") ? channel : channelCoebotData.displayName);
    var tabIconHtml = $('#navSidebar a:first-child .sidebar-icon').html();
    var tabTitleHtml = $('#navSidebar a:first-child .sidebar-title').html();
    $(".js-channel-title").html(titleHtml);
    $(".js-channel-tab-icon").html(tabIconHtml);
    $(".js-channel-tab-title").html(tabTitleHtml);
}

function displayChannelOverview() {
    var html = "";
    html += '<p>';
    html += '<a class="btn btn-primary" href="http://www.twitch.tv/';
    html += channel + '" target="_blank"><i class="fa fa-twitch"></i> Twitch</a>';

    if (channelCoebotData.youtube && channelCoebotData.youtube != "") {
        html += ' <a class="btn btn-default" href="http://www.youtube.com/user/';
        html += channelCoebotData.youtube + '" target="_blank"><i class="fa fa-youtube-play"></i> YouTube</a>';
    }

    if (channelCoebotData.twitter && channelCoebotData.twitter != "") {
        html += ' <a class="btn btn-default" href="http://twitter.com/';
        html += channelCoebotData.twitter + '" target="_blank"><i class="fa fa-twitter"></i> Twitter</a>';
    }

    if (channelData.steamID && channelData.steamID != "") {
        html += ' <a class="btn btn-default" href="http://steamcommunity.com/profiles/';
        html += channelData.steamID + '" target="_blank"><i class="fa fa-steam"></i> Steam</a>';
    }

    if (channelData.lastfm && channelData.lastfm != "") {
        html += ' <a class="btn btn-default" href="http://www.last.fm/user/';
        html += channelData.lastfm + '" target="_blank"><i class="fa fa-lastfm"></i> last.fm</a>';
    }

    if (channelData.extraLifeID) {
        html += ' <a class="btn btn-default" href="http://www.extra-life.org/index.cfm?fuseaction=donorDrive.participant&participantID=';
        html += channelData.extraLifeID + '" target="_blank">Extra Life</a>';
    }

    html += '</p>';

    $(".js-channel-overview").html(html);
}

function displayChannelCommands() {
	var tbody = $('.js-commands-tbody');
	var rows = "";
    var shouldSortTable = true;
	for (var i = 0; i < channelData.commands.length; i++) {
		var cmd = channelData.commands[i];
		var row = '<tr class="row-command row-command-access-' + cmd.restriction +'">';
		row += '<td><kbd class="command">' + cmd.key + '</kbd></td>';
        row += '<td class="row-command-col-access" data-order="' + cmd.restriction + '">' + prettifyAccessLevel(cmd.restriction) + '</td>';
        row += '<td>' + prettifyStringVariables(cmd.value) + '</td>';
		row += '<td>' + Humanize.intComma(cmd.count) + '</td>';
		row += '</tr>';
		rows += row;
	}
    if (rows == "") {
        rows = '<tr><td colspan="4" class="text-center">' + EMPTY_TABLE_PLACEHOLDER + '</td></tr>';
        shouldSortTable = false;
    }
	tbody.html(rows);

    if (shouldSortTable) {
        $('.js-commands-table').dataTable({
            "paging": false,
            "info": false
        });
    }
}

function displayChannelQuotes() {
	var tbody = $('.js-quotes-tbody');
	var rows = "";
    var shouldSortTable = true;
	for (var i = 0; i < channelData.quotes.length; i++) {
		var quote = channelData.quotes[i];
		var row = '<tr>';
		row += '<td>' + (i+1) + '</td>';
		row += '<td>' + quote + '</td>';
		row += '</tr>';
		rows += row;
	}
    if (rows == "") {
        rows = '<tr><td colspan="2" class="text-center">' + EMPTY_TABLE_PLACEHOLDER + '</td></tr>';
        shouldSortTable = false;
    }

	tbody.html(rows);


    if (shouldSortTable) {
        $('.js-quotes-table').dataTable({
            "paging": false,
            "info": false
        });
    }
}

function displayChannelAutoreplies() {
    var tbody = $('.js-autoreplies-tbody');
    var rows = "";
    var shouldSortTable = true;
    for (var i = 0; i < channelData.autoReplies.length; i++) {
        var reply = channelData.autoReplies[i];
        var row = '<tr>';
        row += '<td>' + (i+1) + '</td>';
        row += '<td title="RegEx: ' + cleanHtmlAttr(reply.trigger) + '">' + prettifyRegex(reply.trigger) + '</td>';
        row += '<td>' + prettifyStringVariables(reply.response) + '</td>';
        row += '</tr>';
        rows += row;
    }
    if (rows == "") {
        rows = '<tr><td colspan="3" class="text-center">' + EMPTY_TABLE_PLACEHOLDER + '</td></tr>';
        shouldSortTable = false;
    }

    tbody.html(rows);

    if (shouldSortTable) {
        $('.js-autoreplies-table').dataTable({
            "paging": false,
            "info": false,
            "searching": false
        });
    }
}

function displayChannelScheduled() {
    var tbody = $('.js-scheduled-tbody');
    var rows = "";
    var shouldSortTable = true;
    for (var i = 0; i < channelData.scheduledCommands.length; i++) {
        var cmd = channelData.scheduledCommands[i];
        if (cmd.active) {
            var row = '<tr>';
            row += '<td>' + channelData.commandPrefix + cmd.name + '</td>';
            row += '<td><span title="Cron command: ' + cmd.pattern + '">'
            row += prettyCron.toString(cmd.pattern) + '</td>';
            row += '</tr>';
            rows += row;
        }
    }
    for (var i = 0; i < channelData.repeatedCommands.length; i++) {
        var cmd = channelData.repeatedCommands[i];
        if (cmd.active) {
            var row = '<tr>';
            row += '<td>' + channelData.commandPrefix + cmd.name + '</td>';
            row += '<td><span title="Every ' + cmd.delay + ' seconds">Every '
            row += moment().subtract(cmd.delay, 'seconds').fromNow(true) + '</span></td>';
            row += '</tr>';
            rows += row;
        }
    }
    if (rows == "") {
        rows = '<tr><td colspan="2" class="text-center">' + EMPTY_TABLE_PLACEHOLDER + '</td></tr>';
        shouldSortTable = false;
    }
    
    tbody.html(rows);

    if (shouldSortTable) {
        $('.js-scheduled-table').dataTable({
            "paging": false,
            "info": false,
            "searching": false
        });
    }
}

function displayChannelRegulars() {
    var tbody = $('.js-regulars-tbody');
    var rows = "";
    var shouldSortTable = true;
    for (var i = 0; i < channelData.regulars.length; i++) {
        var reg = channelData.regulars[i];
        var row = '<tr>';
        row += '<td class="text-capitalize">' + reg + '</td>';
        row += '</tr>';
        rows += row;
    }
    if (rows == "") {
        rows = '<tr><td colspan="1" class="text-center">' + EMPTY_TABLE_PLACEHOLDER + '</td></tr>';
        shouldSortTable = false;
    }

    tbody.html(rows);

    if (shouldSortTable) {
        $('.js-regulars-table').dataTable();
    }


    var subsinfoText = 'On this channel, ';
    if (channelData.subcriberRegulars) {
        subsinfoText += 'subscribers are automatically given all the same privileges as regulars.';
    } else if (channelData.subsRegsMinusLinks) {
        subsinfoText += 'subscribers are automatically given the same privileges as regulars, except they cannot post links or use the <kbd class="command">urban</kbd> command.';
    } else {
        subsinfoText += 'subscribers do not automatically receive the same privileges as regulars.';
    }

    $('.js-regulars-subsinfo').html(subsinfoText);
}

function displayChannelChatrules() {
    // var html = ""
    // html += '<h3>Banned phrases</h3>'

    if (channelCoebotData.shouldShowOffensiveWords && channelData.filterOffensive) {
    
        var tbody = $('.js-chatrules_offensive-tbody');
        var rows = "";
        var shouldSortTable = true;
        for (var i = 0; i < channelData.offensiveWords.length; i++) {
            var word = channelData.offensiveWords[i];
            var row = '<tr>';
            row += '<td title="RegEx: ' + cleanHtmlAttr(word) + '">' + prettifyRegex(word) + '</td>';
            row += '</tr>';
            rows += row;
        }
        if (rows == "") {
            rows = '<tr><td colspan="1" class="text-center">' + EMPTY_TABLE_PLACEHOLDER + '</td></tr>';
            shouldSortTable = false;
        }
    
        tbody.html(rows);
    
        if (shouldSortTable) {
            $('.js-chatrules_offensive-table').dataTable({
                "paging": false,
                "info": false,
                "searching": false
            });
        }
    } else {
        $('.js-chatrules_offensive').addClass("hidden");
    }

    // console.log(channelData.useFilters);

    if (channelData.useFilters) {

        var miscHtml = '';
        miscHtml += '<h3>Filter rules</h3>';

        if (channelData.filterCaps) {
            miscHtml += '<p>Messages with excessive capital letters will be censored if the message contains at least ' + channelData.filterCapsMinCapitals + ' capital letters and consists more than ' + channelData.filterCapsPercent + '% of capital letters.</p>';
        }
        if (channelData.filterLinks) {
            miscHtml += '<p>All URLs linked to by non-regulars ';
            if (channelData.subscriberRegulars) {
                miscHtml += '(excluding subscribers) ';
            } else {
                miscHtml += '(including subscribers) ';
            }
            miscHtml += ' will be censored.';
            if (channelData.permittedDomains && channelData.permittedDomains.length != 0) {
                miscHtml += ' However, the following domains are exempt from censoring: ';
                miscHtml += Humanize.oxford(channelData.permittedDomains);
            }
            miscHtml += '</p>';
        }
        // if (channelData.filterSymbols) {
        //     miscHtml += '<p>All caps will be filtered if a message contains more than ' + channelData.filterCapsPercent + '% uppercase letters.</p>'
        // }

        $(".js-chatrules_misc").html(miscHtml);
    }


    // $(".js-chatrules-div").html(html);
}


function loadChannelHighlights() {

    var explodedHash = window.location.hash.substr(0).split(HASH_DELIMITER);

    if (explodedHash.length >= 2) {
        loadHlstream(parseInt(explodedHash[1]));
    }

    $.ajax({
        dataType: "jsonp",
        jsonp: false,
        jsonpCallback: "loadChannelHighlightsCallback",
        url: "/oldhl/api/stats/" + channel + "&callback=loadChannelHighlightsCallback",
        success: function(json) {
            console.log("Loaded highlights stats");
            highlightsStats = json;
            isHighlightsLoaded = true;
            showChannelHighlights();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Failed to load highlights!");
        }
    });
}

function showChannelHighlights() {

    var tbody = $('.js-highlights-tbody');
    var rows = "";
    var shouldSortTable = true;
    for (var i = 0; i < highlightsStats.streams.length; i++) {
        var strm = highlightsStats.streams[i];
        var row = '<tr>';

        row += '<td><span class="fake-link js-highlight-btn" data-hlid="' + strm.id + '">' + strm.title + '</span></td>';

        var startMoment = moment.unix(strm.start);
        var cleanStart = cleanHtmlAttr(startMoment.format('LLLL'));
        row += '<td title="' + cleanStart + '" data-order="' + strm.start + '">' + startMoment.calendar() + '</td>';

        var durationMoment = moment.duration(strm.duration, 'seconds');
        var cleanDuration = cleanHtmlAttr(stringifyDuration(durationMoment));
        row += '<td title="' + cleanDuration + '" data-order="' + strm.duration + '">' + durationMoment.humanize() + '</td>';
        row += '<td data-order="' + strm.hlcount + '">' + Humanize.intComma(strm.hlcount) + '</td>';
        row += '</tr>';


        rows += row;
    }
    if (rows == "") {
        rows = '<tr><td colspan="4" class="text-center">' + EMPTY_TABLE_PLACEHOLDER + '</td></tr>';
        shouldSortTable = false;
    }

    tbody.html(rows);

    if (shouldSortTable) {
        $('.js-highlights-table').dataTable({
            "paging": false,
            "info": false,
            "order": [[ 1, "desc" ]]
        });
    }

    $('.js-highlights-loading').addClass('hidden');
    $('.js-highlights-table').removeClass('hidden');

    $('.js-highlight-btn').click(function() {
        var hlid = $(this).attr('data-hlid');
        loadHlstream(hlid);
    });

}


function loadHlstream(id) {

    $('.js-hlstream-loaded, .js-hlstream-loaded-inline').css('display', 'none');
    $('.js-hlstream-loading').css('display', 'block');
    $('.js-hlstream-loading-inline').css('display', 'inline');

    $('#hlStreamModal').modal('show');

    window.location.hash += HASH_DELIMITER + id;

    $.ajax({
        dataType: "jsonp",
        jsonp: false,
        jsonpCallback: "loadHlstreamCallback",
        url: "/oldhl/api/hl/" + channel + "/" + id + "/&callback=loadHlstreamCallback",
        success: function(json) {
            console.log("Loaded hlstream #" + id);
            currentHlstream = json;
            showHlstream();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Failed to load highlight!");
        }
    });
}

function showHlstream() {

    $('.js-hlstream-title').html(currentHlstream.title);

    $('.js-hlstream-twitchlink').attr("href", '//www.twitch.tv/' + channel + '/b/' + currentHlstream.id);


    var playerVars = "title=" + currentHlstream.title + "&amp;channel=" + channel 
    playerVars += "&amp;auto_play=false&amp;start_volume=100&amp;archive_id=" + currentHlstream.id;

    var playerHtml = "";
    playerHtml += "<object bgcolor='#313131' data='http://www.twitch.tv/widgets/archive_embed_player.swf' height='472' id='player' type='application/x-shockwave-flash' width='775'>";
    playerHtml += "<param name='movie' value='http://www.twitch.tv/widgets/archive_embed_player.swf' />";
    playerHtml += "<param name='allowScriptAccess' value='always' />";
    playerHtml += "<param name='allowNetworking' value='all' />";
    playerHtml += "<param name='allowFullScreen' value='true' />";
    playerHtml += "<param name='flashvars' value='" + playerVars + "' />";
    playerHtml += "</object>";

    var playerParent = $(".js-hlstream-player-parent");
    playerParent.empty();
    playerParent.html(playerHtml);


    var tableTemplate = '';
    tableTemplate += '<table class="table table-striped js-hlstream-table">';
    tableTemplate += '<thead>';
    tableTemplate += '<tr>';
    tableTemplate += '<th><i class="sorttable-icon"></i>Time</th>';
    tableTemplate += '<th><i class="sorttable-icon"></i>Hits</th>';
    tableTemplate += '</tr>';
    tableTemplate += '</thead>';
    tableTemplate += '<tbody class="js-hlstream-tbody"></tbody>';
    tableTemplate += '</table>';

    var tableParent = $('.js-hlstream-table-parent');
    tableParent.empty();
    tableParent.html(tableTemplate);

    var tbody = $('.js-hlstream-tbody');
    var rows = "";
    var shouldSortTable = true;
    for (var i = 0; i < currentHlstream.highlights.length; i++) {
        var hl = currentHlstream.highlights[i];
        var row = '<tr>';

        var durationMoment = moment.duration(hl.position, 'seconds');
        var cleanDuration = cleanHtmlAttr(stringifyDurationShort(durationMoment, true));
        row += '<td data-order="' + hl.position + '"><span onclick="jumpHlstreamTimestamp('
        row += hl.position + ')" class="fake-link">' + cleanDuration + '</span></td>';

        row += '<td data-order="' + hl.hits + '">' + Humanize.intComma(hl.hits) + '</td>';
        row += '</tr>';

        rows += row;
    }
    if (rows == "") {
        rows = '<tr><td colspan="2" class="text-center">' + EMPTY_TABLE_PLACEHOLDER + '</td></tr>';
        shouldSortTable = false;
    }

    tbody.html(rows);

    if (shouldSortTable) {
        hlstreamTable = $('.js-hlstream-table').dataTable({
            "paging": false,
            "info": false,
            "searching": false
        });
    }

    $('.js-hlstream-loading, .js-hlstream-loading-inline').css('display', 'none');
    $('.js-hlstream-loaded').css('display', 'block');
    $('.js-hlstream-loaded-inline').css('display', 'inline');

}

function jumpHlstreamTimestamp(timestamp) {
    player.videoSeek(timestamp);
}


// turns a Moment.js duration object into a totes professional string
function stringifyDuration(duration) {
    var str = "";

    if (duration.asDays() >= 1) {
        var days = Math.floor(duration.asDays());
        str += days + " day" + (days == 1 ?"":"s") + ", ";
        str += duration.hours() + " hour" + (duration.hours() == 1 ?"":"s") + ", ";

    } else if (duration.asHours() >= 1) {
        var hrs = Math.floor(duration.asHours());
        str += hrs + " hour" + (hrs == 1 ?"":"s") + ", ";
    }
    str += duration.minutes() + " minute" + (duration.minutes() == 1 ?"":"s") + ", ";
    str += duration.seconds() + " second" + (duration.seconds() == 1 ?"":"s");

    return str;
}


// turns a Moment.js duration object into a totes professional string, except shorter
function stringifyDurationShort(duration, shouldAddSpaces) {
    var str = "";

    var maybeASpace = shouldAddSpaces ? " " : "";

    if (duration.asHours() >= 1) {
        var hrs = Math.floor(duration.asHours());
        str += hrs + "h" + maybeASpace;
    }
    str += duration.minutes() + "m" + maybeASpace;
    str += duration.seconds() + "s";

    return str;
}


function prettifyAccessLevel(access) {
    if (access == 0) {
        return "All";
    }
    if (access == 1) {
        if (channelData.subsRegsMinusLinks||channelData.subscriberRegulars) {
            return "Subs";
        } else {
            return "Regs";
        }
    }
    if (access == 2) {
        return "Mods";
    }
    if (access == 3) {
        return "Owners";
    }
}

function colorifyAccessLevel(access) {
    if (access == 0) {
        return "#bdc3c7";
    }
    if (access == 1) {
        return "#8e44ad";
    }
    if (access == 2) {
        return "#27ae60";
    }
    if (access == 3) {
        return "#c0392b";
    }
}

function injectEmoticons(html) {
    html = htmlDecode(html);
    for (var i = 0; i < twitchEmotes.length; i++) {
        var emote = twitchEmotes[i];
        if (emote.state == "active") {
            var pattern = new RegExp(emote.regex);
            html = html.replace(pattern, htmlifyEmote(emote), 'g');
        }
    }
    return html;
}

function htmlDecode(input) {
    return String(input)
        .replace(/&amp;/g, '&')
        .replace(/&quot;/g, '"')
        .replace(/&lt;/g, '<')
        .replace(/&gt;/g, '>');
}

// generates HTML for an emote
function htmlifyEmote(emote) {
    var html = '';
    html += '<img src="' + emote.url;
    html += '" height="' + emote.height;
    html += '" width="' + emote.width;
    html += '" title="' + emote.regex;
    html += '" class="twitch-emote">';
    return html;
}

// displays info about the Twitch channel on the overview page
function injectTwitchData() {
    var oldHtml = $('.js-channel-overview').html();
    var html = '';
    html += '<p>Views: ' + Humanize.intComma(channelTwitchData.views) + '</p>';
    html += '<p>Followers: ' + Humanize.intComma(channelTwitchData.followers) + '</p>';
    html += '<p>Joined Twitch on ' + moment(channelTwitchData.created_at).format('LL') + '</p>';
    html += oldHtml;
    
    $('.js-channel-overview').html(html);
}

$(document).ready(function() {

    // moment.locale('en-custom', {
    //     calendar : {
    //         lastDay : '[Yesterday at] LT',
    //         sameDay : '[Today at] LT',
    //         nextDay : '[Tomorrow at] LT',
    //         lastWeek : '[Last] dddd [at] LT',
    //         nextWeek : 'dddd [at] LT',
    //         sameElse : 'll [at] LT'
    //     }
    // });

    $.ajax({
        dataType: "jsonp",
        jsonp: "callback",
        url: "https://api.twitch.tv/kraken/channels/" + channel,
        success: function(json) {
            console.log("Loaded Twitch channel data");
            channelTwitchData = json;
            injectTwitchData();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Failed to load Twitch channel data!");
        }
    });

    $.ajax({
        cache: true,
        dataType: "jsonp",
        jsonp: "callback",
        url: "https://api.twitch.tv/kraken/chat/" + channel + "/emoticons",
        success: function(json) {
            console.log("Loaded Twitch emotes");
            twitchEmotes = json.emoticons;
            var commandsTbody = $('.js-commands-tbody');
            commandsTbody.html(injectEmoticons(commandsTbody.html()));
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Failed to load Twitch emotes!");
        }
    });

    checkIfLiveChannel();
    setInterval(checkIfLiveChannel, 30000);

    $(".command").prepend('<span class="command-prefix">' + channelData.commandPrefix + '</span>');

    var commandPrefixForUrl = channelData.commandPrefix == '+' ? 'plus' : channelData.commandPrefix;
    $(".js-link-commands").each(function() {
        var href = $(this).attr("href");
        $(this).attr("href", href + "/" + encodeURIComponent(commandPrefixForUrl));
    });
})


function checkIfLiveChannel() {
    checkIfLive(channel, handleChannelIsLive);
}

function handleChannelIsLive(json) {
    if (!json) {
        alert("Failed to load Twitch stream data!");
        channelStreamData = false;
    } else {
        channelStreamData = json.streams;
    }
    updateIsLive(json.streams);
}