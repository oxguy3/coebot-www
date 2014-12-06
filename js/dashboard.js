function enableSidebar() {

	$('#navSidebar a').click(function (e) {
		console.log("enabling sidebar");
		e.preventDefault();
		$(this).tab('show');
	});

	$('#navSidebar a').on('shown.bs.tab', function (e) {
		var tab = e.target;

		var tabName = $(tab).html();
		if (tabName == "Overview") tabName = "";

		$(".js-channel-title small").html(tabName);
	})
}

// channel config data
var channelData = false;

function downloadChannelData() {
	$.ajax({
		async: false, // it's my json and i want it NOW!
		dataType: "json",
		url: "/configs/" + channel + ".json",
		success: function(json) {
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
	var channelTitle = channel;
	$(".js-channel-title").html(channel+" <small></small>");
}

function displayChannelOverview() {
	var html = ""
	html += '<p>';
	html += '<a class="btn btn-primary" href="http://www.twitch.tv/' 
	html += channel + '" target="_blank"><i class="fa fa-twitch"></i> Twitch</a> ';

	if (channelData.steamID && channelData.steamID != "") {
		html += '<a class="btn btn-default" href="http://steamcommunity.com/profiles/' 
		html += channelData.steamID + '" target="_blank"><i class="fa fa-steam"></i> Steam</a> ';
	}

	if (channelData.lastfm && channelData.lastfm != "") {
		html += '<a class="btn btn-default" href="http://www.last.fm/user/' 
		html += channelData.lastfm + '" target="_blank"><i class="fa fa-lastfm"></i> last.fm</a> ';
	}
	html += '</p>';

	if (channelData.maxViewers) {
		html += '<p>Max viewers: ' + channelData.maxViewers;
		html += ' viewers, <span class="js-livestamp-maxviewers"></span></p>';
		// html += 'on ' + channelData;
	}

	$(".js-channel-overview").html(html);

	if (channelData.maxViewers) {
		var tsSpan = $('.js-livestamp-maxviewers');
		var date = new Date(channelData.maxviewerDate);
		tsSpan.livestamp(date);
		tsSpan.attr("title", moment(date).format('LLLL'));
	}
}

function displayChannelCommands() {
	var tbody = $('.js-commands-tbody');
	var rows = "";
	for (var i = 0; i < channelData.commands.length; i++) {
		var cmd = channelData.commands[i];
		var row = '<tr>';
		row += '<td>' + cmd.key + '</td>';
		row += '<td>' + cmd.value + '</td>';
		row += '</tr>';
		rows += row;
	}
	tbody.html(rows);
}

function displayChannelQuotes() {
	var tbody = $('.js-quotes-tbody');
	var rows = "";
	for (var i = 0; i < channelData.quotes.length; i++) {
		var quote = channelData.quotes[i];
		var row = '<tr>';
		row += '<td>' + i + '</td>';
		row += '<td>"' + quote + '"</td>';
		row += '</tr>';
		rows += row;
	}
	tbody.html(rows);
}

function displayChannelAutoreplies() {
	var tbody = $('.js-autoreplies-tbody');
	var rows = "";
	for (var i = 0; i < channelData.autoReplies.length; i++) {
		var reply = channelData.autoReplies[i];
		var row = '<tr>';
		row += '<td>' + reply.trigger + '</td>';
		row += '<td>' + reply.response + '</td>';
		row += '</tr>';
		rows += row;
	}
	tbody.html(rows);
}