var EMPTY_TABLE_PLACEHOLDER = 'There\'s nothing here... <i class="fa fa-frown-o"></i>';

function prettifyStringVariables(str) {
    var pattern = /\(_(\w+)_\)/g;
    var replacement = '<span class="label label-info">$1</span>';
    str = str.replace(pattern, replacement);
    return str;
}

function prettifyRegex(pattern) {
    pattern = pattern.replace(/\.\*/g, '<span class="text-info">*</span>');
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
    return "/channel/" + chan;
}