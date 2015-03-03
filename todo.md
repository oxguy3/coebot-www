# To-do list
Since the site is still super early in development, it seems silly to use GitHub issues to track things that need to be fixed because, well, there are a lot of them, and I generally know about most of them. That said, if anyone spots a bug that isn't here, please submit a GitHub issue rather than making a pull request to edit this file. This is just like, my personal bug list I guess.


## Bugs
* Scrollspy on commands.php doesn't update until user starts scrolling.
* You can still access channel.php#boir via URL even when it's not supposed to be visible for a particular channel.
* If someone tries to access channel.php with a channel name that exists, but they don't put the channel in all lowercase in the URL, they will get a messy error and end up redirected to the site's home page.
* The refresh icon doesn't show up on chanlist.php while the Twitch stream status is loading.
* Sometimes the Twitch API likes to just, not include all the details about someone's stream. On index.php, this isn't handled very gracefully; the user ends up seeing "undefined" as the stream status. Make failures less ugly.
* If you access a specific hlstream on channel.php directly via URL, the page won't dim behind the hlstream modal.
* If an hlstream on channel.php has enough highlights that the user has to scroll, the dimming behind the modal won't extend below the screen.
* ~~Emotes are pretty freaking broken~~ Emotes are less broken than they used to be, but they still rely on a deprecated API that doesn't really do much good. Should pull emotes from CoeBot's list of available emotes rather than from channel-specific lists of emotes.
* Synchronous HTTP requests are bad practice and now considered deprecated, should change everything that requires them to work differently.
* The sidebar on commands.php extends way outside of the container for some reason.
* STORING ACCESS TOKENS IN THE DATABASE IS BAD AND I SHOULD FEEL BAD.
* ~~Link buttons on channel.php#overview don't have any vertical padding, and thus look really dumb if they have to break onto two lines.~~
* ~~If the sidebar on channel.php is narrow enough, the tooltip for the Bitbucket link will get cut off by the edge.~~ didn't fix but isn't relevant anymore becaused the sidebar is fixed width


## Minor improvements
* On channel.php, if filters are on but no filters are enabled, you end up with a dumb looking "Filter rules" title with nothing below it.
* Someone just needs to go through commands.php and fix all the typos and inconsistent formatting.
* Automatically converting URLs to links in triggers/quotes/etc on channel.php would parallel the way those things actually appear in Twitch chat, and would thus greatly improve consistency and UX. (edit: OOPS, only did this on the commands tab. also, needs nice hover formatting and needs to handle in-url PARAMETERS better)
* When you log in/out, the site should probably send you back to the page that you logged in from.
* When you log in, the site shouldn't leave you on twitchconnect.php -- no visible ".php" extensions ever!!
* The Help page is woefully lacking in content.
* It should be possible to link to specific questions in the FAQ on help.php by changing the hash on the URL.
* The Commands page is the middle of a revision that I never finished...
* Clicking the 'is live' indicator on chanlist.php/channel.php should force it to refresh.
* The "you have been logged out" alert has butt-ugly margins.
* The signed in indicator should have the dropdown separate from the channel link probably.
* The sign in button looks silly being so far right on channel.php. Maybe put a max width on all the containers of like 1600px?
* On channel.php, "Highlights" is a rather misleading title for the "highlight that" tab; maybe should be changed to "past broadcasts" or something?
* Eliminate glyphicons from site entirely.
* Concatenate JS files.
* ~~Add proper error pages for 404, 403, etc.~~
* ~~Channel name in title of channel.php is always lowercase.~~
* ~~Commands on channel.php#scheduled don't have the nice `<kbd>` formatting.~~
* ~~DataTables is gross. Switch to HubSpot's [Sortable](http://github.hubspot.com/sortable/docs/welcome/).~~ ehhhh, maybe not


### The stupid "who's live" carousel
* Click names on the "who's live" list in index.php fast enough, and it'll glitch out and sort of have two channels selected at once.
* The "who's live" carousel in index.php doesn't show the game currently being played or the number of viewers watching.
* The "who's live" carousel in index.php never updates after page load.
* If only one person is streaming, the "who's live" carousel on index.php probably shouldn't have left/right arrow keys? Or maybe just leave 'em be, I dunno.
* If no one is live, the "who's live" carousel in index.php just hides itself. That's confusing to the user, should instead display some sort of "no one's live right now" message.
* The text overlayed on the "who's live" carousel is often hard to read, needs a better background to give it proper contrast.
* Maybe it'd be cool if the "who's live" list was in a random order instead of alphabetical so that everyone gets a bit of promotion. Or maybe just have the carousel start at a random point in the alphabetical list.
* As the selected channel in the who's live list changes, the list should scroll so the active channel is visible.
* ~~The "who's live" carousel can get pretty overcrowded with text on small displays; maybe have the text appear below the image on XS viewport?~~ nah, just got rid of the text altogether
* ~~If the "who's live" list in index.php gets long enough to need a scrollbar, that scrollbar is buttugly. Need to add in nanoScoller or something similar.~~
* ~~The "who's live" carousel doesn't have a height set, so it is very short for a brief moment before the first image loads in.~~


## Major improvements
* If commands.php offered some indication that you could change what command prefix to display, that'd be pretty nifty.
* A nice airy parallax-esque homepage would really make CoeBot stand out.
* Need to have channels tied to the bot instance that controls them.
* Need to put more info into channel.php#chatrules; it's really half-baked at present.
* ~~SuperMCGamer's "Highlight That!" button still uses the old highlights site. Button needs to be ported over so that the old site can be taken down.~~ is he still using it???
* Highlights player is not responsive, and there are few options for people without Flash. Need to add HTML5 player support and links to timestamps on Twitch for each highlight.
* chanlist.php should be a neato sortable table instead of just a static list (and a static list with alphabetization bugs at that).
* Need a proper tutorial on how to join CoeBot; index.php just tells you to tweet @endsgamer, and the FAQ for joining isn't much better.
* Channel owners should be able to hide/show any sidebar tab they please on channel.php.
* Suggestions for common uses of CoeBot features when a channel owner is signed in seems like a solid idea (i.e. hug/throw commands, "hey chat" autoreplies.
* ~~BOIR build info page isn't finished.~~
* ~~Channels aren't loaded from database, and CoeBot doesn't have a way to automatically update channel data.~~

## New features
* Use HTTPS (and use it EVERYWHERE).
* Eventually want subscriber alert/follower alert/on-stream chat available for use with OBS.
* Need ability to reconfigure CoeBot from the website.
* Add more bot instances.
* Add support for users to run their own bot instances.
* Ability to import settings from Nightbot/moobot? Or would that be too much work? (also, would this be considered overly hostile towards those bots?)
* ~~Need a login system.~~
