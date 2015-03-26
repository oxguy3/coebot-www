/* Cookies.js https://github.com/ScottHamper/Cookies */
(function(g,f){"use strict";var h=function(e){if("object"!==typeof e.document)throw Error("Cookies.js requires a `window` with a `document` object");var b=function(a,d,c){return 1===arguments.length?b.get(a):b.set(a,d,c)};b._document=e.document;b._cacheKeyPrefix="cookey.";b._maxExpireDate=new Date("Fri, 31 Dec 9999 23:59:59 UTC");b.defaults={path:"/",secure:!1};b.get=function(a){b._cachedDocumentCookie!==b._document.cookie&&b._renewCache();return b._cache[b._cacheKeyPrefix+a]};b.set=function(a,d,c){c=b._getExtendedOptions(c); c.expires=b._getExpiresDate(d===f?-1:c.expires);b._document.cookie=b._generateCookieString(a,d,c);return b};b.expire=function(a,d){return b.set(a,f,d)};b._getExtendedOptions=function(a){return{path:a&&a.path||b.defaults.path,domain:a&&a.domain||b.defaults.domain,expires:a&&a.expires||b.defaults.expires,secure:a&&a.secure!==f?a.secure:b.defaults.secure}};b._isValidDate=function(a){return"[object Date]"===Object.prototype.toString.call(a)&&!isNaN(a.getTime())};b._getExpiresDate=function(a,d){d=d||new Date; "number"===typeof a?a=Infinity===a?b._maxExpireDate:new Date(d.getTime()+1E3*a):"string"===typeof a&&(a=new Date(a));if(a&&!b._isValidDate(a))throw Error("`expires` parameter cannot be converted to a valid Date instance");return a};b._generateCookieString=function(a,b,c){a=a.replace(/[^#$&+\^`|]/g,encodeURIComponent);a=a.replace(/\(/g,"%28").replace(/\)/g,"%29");b=(b+"").replace(/[^!#$&-+\--:<-\[\]-~]/g,encodeURIComponent);c=c||{};a=a+"="+b+(c.path?";path="+c.path:"");a+=c.domain?";domain="+c.domain: "";a+=c.expires?";expires="+c.expires.toUTCString():"";return a+=c.secure?";secure":""};b._getCacheFromString=function(a){var d={};a=a?a.split("; "):[];for(var c=0;c<a.length;c++){var e=b._getKeyValuePairFromCookieString(a[c]);d[b._cacheKeyPrefix+e.key]===f&&(d[b._cacheKeyPrefix+e.key]=e.value)}return d};b._getKeyValuePairFromCookieString=function(a){var b=a.indexOf("="),b=0>b?a.length:b;return{key:decodeURIComponent(a.substr(0,b)),value:decodeURIComponent(a.substr(b+1))}};b._renewCache=function(){b._cache= b._getCacheFromString(b._document.cookie);b._cachedDocumentCookie=b._document.cookie};b._areEnabled=function(){var a="1"===b.set("cookies.js",1).get("cookies.js");b.expire("cookies.js");return a};b.enabled=b._areEnabled();return b},e="object"===typeof g.document?h(g):h;"function"===typeof define&&define.amd?define(function(){return e}):"object"===typeof exports?("object"===typeof module&&"object"===typeof module.exports&&(exports=module.exports=e),exports.Cookies=e):g.Cookies=e})("undefined"===typeof window? this:window);


var cookieList = [
  {
    name: "birthdayMode",
    description: "Birthday mode (warning: rapidly flashing lights and colors!)",
    type: 'boolean'
  },
  {
    name: "showWhalePenis",
    description: "Show whale penis statistics",
    type: 'boolean'
  },
  {
    name: "cookiemanShortcut",
    description: "Show shortcut to Cookie Manager",
    type: 'boolean'
  },
  {
    name: "experimentalFeatures",
    description: "Enable experimental features",
    type: 'boolean'
  }
];


$(document).ready(function() {

  if (!Cookies.enabled) {
    alert("Umm, you need cookies enabled to use the cookie manager.");

  } else {

    var parentDiv = $("#cookieOptions");

    for (var i = 0; i < cookieList.length; i++) {

      var option = cookieList[i];
      var optHtml = "";

      if (option.type == 'boolean') {
        optHtml = '<div class="checkbox"><label><input type="checkbox" id="' + option.name + '"> ' + option.description + '</label></div>';
      }

      parentDiv.append(optHtml);

      if (option.type == 'boolean') {
        var savedVal = Cookies.get(option.name) == "true";
        $("#" + option.name).prop("checked", savedVal);
      }

    }

    $("#statusMessage").html("Cookies loaded!");


    $('#cookieSubmit').click(function() {

      for (var i = 0; i < cookieList.length; i++) {
        var option = cookieList[i];

        var newVal;

        if (option.type == 'boolean') {
          newVal = $("#"+option.name).prop("checked");
        }

        Cookies.set(option.name, newVal, {expires: Infinity});

      }

      $("#statusMessage").html("Updated! Reloading page...");
      location.reload();
    });

  }

});


