# To-do list
Since the site is still super early in development, it seems silly to use GitHub issues to track things that need to be fixed because, well, there are a lot of them, and I generally know about most of them. That said, if anyone spots a bug that isn't here, please submit a GitHub issue rather than making a pull request to edit this file. This is just like, my personal bug list I guess.


## Bugs
* Scrollspy on commands.php doesn't update until user starts scrolling.
* The refresh icon doesn't show up on chanlist.php while the Twitch stream status is loading.
* Sometimes the Twitch API likes to just, not include all the details about someone's stream. On index.php, this isn't handled very gracefully; the user ends up seeing "undefined" as the stream status. Make failures less ugly.
* Link buttons on channel.php#overview don't have any vertical padding, and thus look really dumb if they have to break onto two lines.
* If you access a specific hlstream on channel.php directly via URL, the page won't dim behind the hlstream modal.
* If an hlstream on channel.php has enough highlights that the user has to scroll, the dimming behind the modal won't extend below the screen.
* If the sidebar on channel.php is narrow enough, the tooltip for the Bitbucket link will get cut off by the edge.
* Emotes are pretty freaking broken, and rely on a deprecated API that doesn't really do much good. Should pull emotes from CoeBot's list of available emotes rather than from channel-specific lists of emotes.
* Synchronous HTTP requests are bad practice and now considered deprecated, should change everything that requires them to work differently.


## Minor improvements
* Channel name in title of channel.php is always lowercase.
* On channel.php, if filters are on but no filters are enabled, you end up with a dumb looking "Filter rules" title with nothing below it.
* Commands on channel.php#scheduled don't have the nice `<kbd>` formatting.
* DataTables is gross. Switch to HubSpot's [Sortable](http://github.hubspot.com/sortable/docs/welcome/).
* Someone just needs to go through commands.php and fix all the typos and inconsistent formatting.
* Automatically converting URLs to links in triggers/quotes/etc on channel.php would parallel the way those things actually appear in Twitch chat, and would thus greatly improve consistency and UX.

### The stupid "who's live" carousel
* Click names on the "who's live" list in index.php fast enough, and it'll glitch out and sort of have two channels selected at once.
* The "who's live" carousel doesn't have a height set, so it is very short for a brief moment before the first image loads in.
* If the "who's live" list in index.php gets long enough to need a scrollbar, that scrollbar is buttugly. Need to add in nanoScoller or something similar.
* The "who's live" carousel in index.php doesn't show the game currently being played or the number of viewers watching.
* The "who's live" carousel in index.php never updates after page load.
* If only one person is streaming, the "who's live" carousel on index.php probably shouldn't have left/right arrow keys? Or maybe just leave 'em be, I dunno.
* The "who's live" carousel can get pretty overcrowded with text on small displays; maybe have the text appear below the image on XS viewport?
* If no one is live, the "who's live" carousel in index.php just hides itself. That's confusing to the user, should instead display some sort of "no one's live right now" message.


## Major improvements
* If commands.php offered some indication that you could change what command prefix to display, that'd be pretty nifty.
* A nice airy parallax-esque homepage would really make CoeBot stand out.
* BOIR build info page isn't finished.
* Channels aren't loaded from database, and CoeBot doesn't have a way to automatically update channel data.
* Need to have channels tied to the bot instance that controls them.
* Need to put more info into channel.php#chatrules; it's really half-baked at present.
* SuperMCGamer's "Highlight That!" button still uses the old highlights site. Button needs to be ported over so that the old site can be taken down.
* It'd be pretty sweet if chanlist.php were a sortable table instead of just a relatively static list.
* Highlights player is not responsive, and there are few options for people without Flash. Need to add HTML5 player support and links to timestamps on Twitch for each highlight.

## New features
* Need a login system.
* Eventually want subscriber alert/follower alert/on-stream chat available for use with OBS.
* Need ability to reconfigure CoeBot from the website.