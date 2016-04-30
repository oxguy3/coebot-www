<?php

require_once("common.php");

function printAccessLabel($level) {
	$name = "???";
  if ($level == 0) {
      $name = "Everyone";
  }
  if ($level == 1) {
      $name = "Regulars";
  }
  if ($level == 2) {
      $name = "Mods";
  }
  if ($level == 3) {
      $name = "Owners";
  }
  if ($level == 99) {
      $name = "Admins";
  }

  echo '<span class="label label-default access-level access-level-' . $level . '">' . $name . '</span>';
}

$DEFAULT_COMMAND_PREFIX = "!";


$prefix = isset($_GET['prefix']) ? $_GET['prefix'] : $DEFAULT_COMMAND_PREFIX;

if ($prefix == "plus") {
	$prefix = "+";
}
if ($prefix == "hash") {
	$prefix = "#";
}
if ($prefix == "amp") {
	$prefix = "&";
}
if ($prefix == "qmark") {
	$prefix = "?";
}

if (strlen($prefix) != 1) {
	$prefix = $DEFAULT_COMMAND_PREFIX;
}

$extraHead = "<style>.command:before { content:\"$prefix\"; }</style>";


printHead("Commands", array("/css/commands.css"), array("/js/commands.js"), $extraHead);
printNav('commands');

?>
<div class="container">
  <div class="row">

    <div class="col-sm-9 col-lg-10">
      <h1>Commands</h1>

      <div class="alert alert-info" role="alert">
        <strong>Under revision!</strong> I have been starting to add permission levels next to all the commands on this page, but for the time being, only some of them have permission levels noted. Apologies for the mess; I hope to have this task finished soon.
      </div>

      <h2 id="general" class="commands-nav-heading">General</h2>

      <dl>
			  <dt><kbd class="command">join</kbd></dt>
			  <dd>Tells CoeBot to begin monitoring your channel. Must be executed from the bot's channel. <?php printAccessLabel(0); ?></dd>

			  <dt><kbd class="command">part</kbd></dt>
			  <dd>Tells CoeBot to stop monitoring your channel. <?php printAccessLabel(3); ?></dd>

			  <dt><kbd class="command">topic</kbd></dt>
			  <dd>Displays the topic. If no topic is provided, the channel title will be displayed. <?php printAccessLabel(0); ?></dd>

			  <dt><kbd class="command">topic [new topic]</kbd></dt>
			  <dd>Changes the topic. <?php printAccessLabel(2); ?></dd>

			  <dt><kbd class="command">viewers</kbd></dt>
			  <dd>Displays the current number of stream viewers <?php printAccessLabel(0); ?>.</dd>

			  <dt><kbd class="command">chatters</kbd></dt>
			  <dd>Displays the number of people connected to chat. <?php printAccessLabel(0); ?></dd>

			  <dt><kbd class="command">uptime</kbd></dt>
			  <dd>Displays the time that the stream started at, and the amount of time since then.</dd>

			  <dt><kbd class="command">music</kbd></dt>
			  <dd>Displays the track currently playing on the streamer's Last.fm account. (See <kbd class="command">set lastfm</kbd> to configure Last.fm integration.)</dd>

			  <dt><kbd class="command">lastfm</kbd></dt>
			  <dd>Links to the lastfm profile</dd>

			  <dt><kbd class="command">songlink</kbd></dt>
			  <dd>Links to the currently playing song on lastfm</dd>

			  <dt><kbd class="command">bothelp</kbd></dt>
			  <dd>Displays the link to bot help documentation (this page). <?php printAccessLabel(0); ?></dd>

			  <dt><kbd class="command">commercial</kbd></dt>
			  <dd>Runs a 30 second commercial. You must use <kbd class="command">followme</kbd> to get <?php echo $SITE_TITLE; ?> to follow your account and add the bot as a channel editor. <?php printAccessLabel(2); ?></dd>

			  <dt><kbd class="command">cancel</kbd></dt>
			  <dd>Cancels the running of a commercial if one was queued up. <?php printAccessLabel(2); ?></dd>

			  <dt><kbd class="command">game</kbd></dt>
			  <dd>Displays the current Twitch game. <?php printAccessLabel(0); ?></dd>

			  <dt><kbd class="command">game [new game]</kbd></dt>
			  <dd>Sets the current Twitch game (bot must be channel editor).<?php printAccessLabel(2); ?></dd>

			  <dt><kbd class="command">status</kbd></dt>
			  <dd>Displays the current Twitch status. <?php printAccessLabel(0); ?></dd>

			  <dt><kbd class="command">status [new status] </kbd></dt>
			  <dd>Sets the current Twitch status (bot must be channel editor). <?php printAccessLabel(2); ?></dd>

			  <dt><kbd class="command">statusgame &lt;new game&gt;</kbd></dt>
			  <dd>Sets the stream title and pulls the current game from Steam. If not a Steam game, sets the game to "Not Playing"</dd>

			  <dt><kbd class="command">steamgame</kbd> <?php printAccessLabel(0); ?></dt>
			  <dd>Updates the game to the steam game currently being played. If steam game is unavailable, sets the game to "Not Playing"</dd>

			  <dt><kbd class="command">xboxgame</kbd></dt>
			  <dd>Updates the game to the last played game on Xbox Live</dd>

			  <dt><kbd class="command">followme</kbd></dt>
			  <dd> Request the bot to follow your Twitch account. Can only be done in your own channel. <?php printAccessLabel(3); ?></dd>

			  <dt><kbd class="command">viewerstats</kbd></dt>
			  <dd>Returns the max concurrent viewers of all time  for this channel and also the average maximum viewer count per stream. Averages may not be accurate until a few streams are is one stream behind.</dd>

			  <dt><kbd class="command">resetmaxviewers &lt;int&gt;</kbd></dt>
			  <dd>Resets the max viewer count for <kbd class="command">viewerstats</kbd> to the new int passed in. Useful for correcting false numbers from viewbots.</dd>

			  <dt><kbd class="command">punishstats</kbd></dt>
			  <dd>Returns the number of times a punishment (e.g. purge, ban, timeout) has been applied and how long since a punishment has happened</dd>

			  <dt><kbd class="command">whatshouldiplay</kbd></dt>
			  <dd>Chooses a random game from the Steam games associated with your profile. (Requires Steam ID to be set, see <kbd class="command">set steam</kbd>) <?php printAccessLabel(3); ?></dd>

			  <dt><kbd class="command">google &lt;query...&gt;</kbd></dt>
			  <dd>Links to a google search for a particular topic <?php printAccessLabel(1); ?></dd>

			  <dt><kbd class="command">wiki &lt;query...&gt;</kbd></dt>
			  <dd>Gives the snippet associated with that Wikipedia article, might return nothing based on the style of the WikiText <?php printAccessLabel(1); ?></dd>

			  <dt><kbd class="command">islive [channel]</kbd></dt>
			  <dd>Tells whether or not a particular channel is live. <?php printAccessLabel(2); ?></dd>

			  <dt><kbd class="command">ishere &lt;username&gt;</kbd></dt>
			  <dd>Tells whether or not a particular user is present in chat. <?php printAccessLabel(2); ?></dd>

		  </dl>


		  <h2 id="custom" class="commands-nav-heading">Custom commands</h2>


		  <h3 id="triggers" class="commands-nav-heading">Triggers</h3>

		  <dl>

		    <dt><kbd class="command">command add &lt;name&gt; &lt;text&gt;</kbd></dt>
		    <dd>Creates a command (<kbd class="command">name</kbd>) <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">command delete &lt;name&gt;</kbd></dt>
		    <dd>Removes command "name" <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">command restrict &lt;name&gt; &lt;everyone|regulars|mods|owner&gt;</kbd></dt>
		    <dd>Restricts commands to different access levels <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">commands</kbd></dt>
		    <dd>Links to the list of custom commands for a channel <?php printAccessLabel(1); ?></dd>

		  </dl>


		  <h3 id="repeat" class="commands-nav-heading">Repeats</h3>

		  <p>The repeat command will repeat a custom trigger every X amount of seconds passed. Message difference allows you to prevent spamming an inactive channel. It requires Y amount of messages have passed in the channel since the last iteration of the message. The default is 1 so at least one message will need to have been sent in the channel in order for the repeat to trigger.</p>

		  <dl>

		    <dt><kbd class="command">repeat add &lt;name&gt; &lt;delay in seconds&gt; [message difference]</kbd></dt>
		    <dd>Sets a command to repeat. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">repeat delete &lt;name&gt;</kbd></dt>
		    <dd>Stops repetition and discards repetition info. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">repeat on|off &lt;name&gt; </kbd></dt>
		    <dd>Enables/disables repetition of a command, but keeps info. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">repeat list</kbd></dt>
		    <dd>Lists commands that will be repeated. <?php printAccessLabel(2); ?></dd>

		  </dl>


		  <h3 id="scheduled" class="commands-nav-heading">Schedule</h3>

		  <p>Schedule is similar to repeat but is designed to repeat at specific times such as 5pm, hourly (on the hour), semihourly (on 0:30), etc. pattern accepts: hourly, semihourly, and crontab syntax**. Replace spaces in crontab syntax with _ (underscore)</p>

		  <dl>

		    <dt><kbd class="command">schedule add &lt;name&gt; &lt;pattern&gt; [message difference]</kbd></dt>
		    <dd>Schedules a command. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">schedule delete &lt;name&gt;</kbd></dt>
		    <dd>Removes a scheduled command and discards scheduling info. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">schedule on|off &lt;name&gt;</kbd></dt>
		    <dd>Enables/disabled a scheduled command, but keeps info. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">schedule list</kbd></dt>
		    <dd>Lists scheduled commands. <?php printAccessLabel(2); ?></dd>
		  </dl>

		  <h4>Examples</h4>
		  <ul>
		    <li><kbd class="command">schedule add youtube hourly 0 </kbd> This will repeat the <kbd class="command">youtube</kbd> command every hour on the hour.</li>
		    <li><kbd class="command">schedule add ip *_*_*_*_* 0 </kbd> This will repeat the <kbd class="command">ip</kbd> command every minute.</li>
		    <li><kbd class="command">schedule add texture *_5_*_*_* 0 </kbd> This will repeat the <kbd class="command">texture</kbd> at 5am every day.</li>
		  </ul>


		  <h3 id="autoreplies" class="commands-nav-heading">Auto-replies</h3>

		  <p>Autoreplies are like custom triggers but do not require a command to be typed. The bot will check all messages for the specified pattern and reply with the response if found. Responses have a 30 second cooldown</p>
		  <dl>

		    <dt><kbd class="command">autoreply add &lt;pattern&gt; &lt;response&gt;</kbd></dt>
		    <dd>Adds an autoreply triggered by *pattern* with the desired response. Use * to denote wildcards and _ to denote spaces in the pattern. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">autoreply remove &lt;number&gt;</kbd></dt>
		    <dd>Removes the autoreply with that index number. Do <kbd class="command">autoreply list</kbd> for those values. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">autoreply editresponse &lt;index&gt; &lt;response&gt;</kbd></dt>
		    <dd>Edits the response for a pre-existing autoreply. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">autoreply list</kbd></dt>
		    <dd>Lists current autoreplies. <?php printAccessLabel(2); ?></dd>
		  </dl>

			<h4>Example</h4>
		  <p>
		  	<kbd class="command">autoreply add *what*texture* The broadcaster is using Sphax.</kbd> will respond with: The broadcaster is using Sphax. if a message similar to: "What texture pack is this?" is typed.
		  </p>




		  <h2 id="fun" class="commands-nav-heading">Fun</h2>

		  <dl>

		    <dt><kbd class="command">throw &lt;object...&gt;</kbd></dt>
		    <dd>Throws object. <?php printAccessLabel(1); ?></dd>

		    <dt><kbd class="command">winner</kbd></dt>
		    <dd>Chooses a random viewer. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">random coin</kbd></dt>
		    <dd>Gives the result of a <?php printAccessLabel(1); ?></dd>

		    <dt><kbd class="command">random &lt;integer&gt;</kbd></dt>
		    <dd>Picks a random number between 0 and a given integer. <?php printAccessLabel(1); ?></dd>

		    <dt><kbd class="command">random regular</kbd></dt>
		    <dd>Picks a random online regular. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">hug &lt;object...&gt;</kbd></dt>
		    <dd>Hugs object</dd>

		    <dt><kbd class="command">conch &lt;question...&gt;</kbd></dt>
		    <dd>Magic 8 Ball functionality <?php printAccessLabel(1); ?></dd>

<!-- 		    <dt><kbd class="command">define &lt;word/phrase...&gt;</kbd></dt>
		    <dd>Searches Merriam-Webster for definitions (Not a great API, but free and works, mostly)</dd> -->

		    <dt><kbd class="command">urban &lt;word/phrase...&gt;</kbd></dt>
		    <dd>Searches Urban Dictionary for definitions. Limited to 140 character response. <?php printAccessLabel(1); ?></dd>

		    <dt><kbd class="command">me &lt;phrase...&gt;</kbd></dt>
		    <dd>Sends a status message (i.e. "/me...") as CoeBot <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">race </kbd></dt>
		    <dd>Gives a link to the speedrunning race the streamer is currently participating in <?php printAccessLabel(0); ?></dd>

		  </dl>


		  <h3 id="quotes" class="commands-nav-heading">Quotes</h3>
		  <dl>
		    <dt><kbd class="command">quote add &lt;"quote..."&gt;</kbd></dt>
		    <dd>Adds a new quote. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">quote delete|remove &lt;int index of quote&gt;</kbd></dt>
		    <dd>Deletes the quote at the specified index. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">quote getindex &lt;exact quote...&gt;</kbd></dt>
		    <dd>Gives the index of the quote passed in. <?php printAccessLabel(1); ?></dd>

		    <dt><kbd class="command">quote get &lt;int index of quote&gt;</kbd></dt>
		    <dd>Returns the quote of the requested index. <?php printAccessLabel(1); ?></dd>

		    <dt><kbd class="command">quote random</kbd></dt>
		    <dd>Returns a random quote from the quote database. <?php printAccessLabel(1); ?></dd>

		    <dt><kbd class="command">quote search &lt;phrase to search...&gt;</kbd></dt>
		    <dd>Searches the quote database and returns indicies of matching quotes. <?php printAccessLabel(2); ?></dd>    

		  </dl>


		  <h3 id="polls" class="commands-nav-heading">Polls</h3>

		  <dl>

		    <dt><kbd class="command">poll create &lt;option 1&gt; &lt;option 2&gt;... [option n]</kbd></dt>
		    <dd>Creates a new poll with the specified options. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">poll start|stop</kbd></dt>
		    <dd>Starts or stops the poll. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">poll results</kbd></dt>
		    <dd>Displays the poll's results. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">vote &lt;option&gt;</kbd></dt>
		    <dd>Votes for &lt;option&gt; in the poll.</dd>

 		    <dt><kbd class="command">strawpoll &lt;question&gt;; &lt;first choice&gt;, &lt;second choice&gt;, &lt;nth choice&gt;</kbd></dt>
		    <dd>Posts a strawpoll with the given question and choices.</dd>    

		    <dt><kbd class="command">strawpoll results</kbd></dt>
		    <dd>Retrieves the results of the last strawpoll.</dd>
		  </dl>


		  <h3 id="giveaways" class="commands-nav-heading">Giveaways</h3>

		  <dl>

		    <dt><kbd class="command">giveaway create &lt;max-number&gt; [duration]</kbd></dt>
		    <dd>Creates a number-selection based giveaway with numbers from 1 - max. Duration is an optional value in seconds after which the giveaway will stop. Specifying a duration will auto-start the giveaway and stop will not need to be executed. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">giveaway start|stop</kbd></dt>
		    <dd>Starts or stops the giveaway. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">giveaway results</kbd></dt>
		    <dd>Displays winner(s). <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">ga</kbd></dt>
		    <dd>Alias for <kbd class="command">giveaway</kbd>. <?php printAccessLabel(2); ?></dd>

		  </dl>


		  <h3 id="raffles" class="commands-nav-heading">Raffles</h3>

		  <dl>

		    <dt><kbd class="command">raffle</kbd></dt>
		    <dd>Enters the raffle. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">raffle enable|disable</kbd></dt>
		    <dd>Enables entries in the raffle. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">raffle reset</kbd></dt>
		    <dd>Clears entries. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">raffle count</kbd></dt>
		    <dd>Displays number of entries. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">raffle winner</kbd></dt>
		    <dd>Picks a winner. <?php printAccessLabel(2); ?></dd>

		  </dl>


		  <h3 id="highlights" class="commands-nav-heading">Highlights</h3>

		  <dl>

		    <dt><kbd class="command">ht</kbd></dt>
		    <dd>Short for "highlight that!". Marks a highlight in the stream. <?php printAccessLabel(0); ?></dd>

		    <dt><kbd class="command">highlights</kbd></dt>
		    <dd>Provides a link to the list of highlights for this channel. <?php printAccessLabel(0); ?></dd>

		  </dl>


		  <h3 id="boirebirth" class="commands-nav-heading">Binding of Isaac: Rebirth</h3>

		  <p>
		  	Using a special companion program, CoeBot can keep track of information about a streamer's BOI:R game.
		  </p>
		  <dl>

		    <dt><kbd class="command">boi wiki &lt;query&gt;</kbd></dt>
		    <dd>Searches the Binding of Isaac wiki for a particular query. <?php printAccessLabel(1); ?></dd>

		    <dt><kbd class="command">boi floor</kbd></dt>
		    <dd>Shows what floor the streamer is currently on. <?php printAccessLabel(1); ?></dd>

		    <dt><kbd class="command">boi seed</kbd></dt>
		    <dd>Gives the seed for the streamer's build. <?php printAccessLabel(1); ?></dd>

		    <dt><kbd class="command">boi items</kbd></dt>
		    <dd>Lists all the items the streamer has. <?php printAccessLabel(1); ?></dd>

		    <dt><kbd class="command">boi transformations</kbd></dt>
		    <dd>Shows the streamer's progress towards each of the transformations. <?php printAccessLabel(1); ?></dd>

		  </dl>




		  <h2 id="moderation" class="commands-nav-heading">Moderation</h2>


		  <h3 id="modshortcuts" class="commands-nav-heading">Shortcuts</h3>

		  <dl>
		    <dt><kbd>+m</kbd></dt>
		    <dd>Turns slow mode on. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd>-m</kbd></dt>
		    <dd>Turns slow mode off. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd>+s</kbd></dt>
		    <dd>Turns subscribers only mode on. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd>-s</kbd></dt>
		    <dd>Turns subscribers only mode off. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd>+b &lt;user&gt;</kbd></dt>
		    <dd>Bans a user. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd>-b &lt;user&gt;</kbd></dt>
		    <dd>Unbans a user. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd>+t &lt;user&gt;</kbd></dt>
		    <dd>Times out a user. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd>-t &lt;user&gt;</kbd></dt>
		    <dd>Pardons a user's timeout. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd>+p &lt;user&gt;</kbd></dt>
		    <dd>Purges a user's chat history. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">permit &lt;user&gt;</kbd></dt>
		    <dd>Permits a user to post one link. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">clear</kbd></dt>
		    <dd>Clears chat. <?php printAccessLabel(2); ?></dd>

		  </dl>


		  <h3 id="ignores" class="commands-nav-heading">Ignores</h3>

		  <p>CoeBot can be set to ignore users whom moderators do not want to have access to CoeBot.</p>

		  <dl>
		  	
		    <dt><kbd class="command">ignore add|delete &lt;channel name&gt;</kbd></dt>
		    <dd>Adds or removes a user on the ignore list. <?php printAccessLabel(2); ?></dd>

		    <dt><kbd class="command">ignore list</kbd></dt>
		    <dd>Lists all of the users on the ignore list. <?php printAccessLabel(2); ?></dd>

		  </dl>


		  <h3 id="raids" class="commands-nav-heading">Raids</h3>

		  <p>A way to easily send followers to another channel when the user is done streaming.</p>

		  <dl>

		    <dt><kbd class="command">raid &lt;channel name&gt;</kbd></dt>
		    <dd>Tells the viewers to go raid the provided channel name (provides a link). <?php printAccessLabel(3); ?></dd>

		    <dt><kbd class="command">raid list</kbd></dt>
		    <dd>Lists all of the channels on the raid whitelist. <?php printAccessLabel(3); ?></dd>

		    <dt><kbd class="command">raid whitelist add|delete &lt;channel name&gt;</kbd></dt>
		    <dd>Adds or removes a channel from the raid whitelist. <?php printAccessLabel(3); ?></dd>

		    <dt><kbd class="command">raid random</kbd></dt>
		    <dd>Tells the viewers to raid a random channel from the whitelist that is currently streaming. <?php printAccessLabel(3); ?></dd>

		    <dt><kbd class="command">raid samegame</kbd></dt>
		    <dd>Chooses a random streamer that is currently playing the same game as the current streamer. <?php printAccessLabel(3); ?></dd>

		    <dt><kbd class="command">host random</kbd></dt>
		    <dd>Sets this channel to host a random channel from the raid whitelist. <?php printAccessLabel(3); ?></dd>

		    <dt><kbd class="command">host samegame</kbd></dt>
		    <dd>Sets this channel to host another channel that is playing the same game. <?php printAccessLabel(3); ?></dd>

		    <dt><kbd class="command">host &lt;channel name&gt;</kbd></dt>
		    <dd>Sets this channel to host a particular other channel. <?php printAccessLabel(3); ?></dd>

		    <dt><kbd class="command">unhost</kbd></dt>
		    <dd>Sets this channel to stop hosting anyone. <?php printAccessLabel(3); ?></dd>
		  </dl>


		  <h3 id="settings" class="commands-nav-heading">Settings</h3>

		  <p>Syntax: <kbd class="command" class="commands-nav-heading">set &lt;option&gt;[parameters]</kbd></p>

		  <h4>Options</h4>

		  <dl>

		    <dt><kbd>topic on|off</kbd></dt>
		    <dd>Enables the <kbd class="command">topic</kbd> command.</dd>

		    <dt><kbd>throw on|off</kbd></dt>
		    <dd>Enables the <kbd class="command">throw</kbd> command</dd>

		    <dt><kbd>lastfm &lt;username|off&gt;</kbd></dt>
		    <dd>Sets username to use with the music related commands.</dd>

		    <dt><kbd>steam &lt;ID&gt;</kbd></dt>
		    <dd>Sets your Steam ID. Must be in SteamID64 format and profile must be public.</dd>

		    <dt><kbd>mode &lt;(0/owner)|(1/mod)|(2/everyone)|(-1/admin)&gt;</kbd></dt>
		    <dd>Sets the minimum access to use any bot commands.</dd>

		    <dt><kbd>commerciallength &lt;30|60|90|120|150|180&gt;</kbd></dt>
		    <dd>Length of commercials to run.</dd>

		    <dt><kbd>prefix &lt;character&gt;</kbd></dt>
		    <dd>Sets the command prefix. Default is "!"</dd>

		    <dt><kbd>bullet &lt;string&gt;</kbd></dt>
		    <dd>Sets the response bullet. Default is "#!"</dd>

		    <dt><kbd>subscriberregulars on|off</kbd></dt>
		    <dd>Treat subscribers as regulars for everything.</dd>

		    <dt><kbd>subsregsminuslinks on|off</kbd></dt>
		    <dd>Treats subscribers as regulars, but they can't post links or use <kbd class="command">urban</kbd>.</dd>

		    <dt><kbd>subscriberalerts on|off</kbd></dt>
		    <dd>Toggle chat alert when a new user subscribes.</dd>

		    <dt><kbd>subscriberalerts message &lt;message&gt;</kbd></dt>
		    <dd>Message to be displayed when a new user subscribers. Use <kbd>(_1_)</kbd> to insert the new subscriber's name.</dd>

		    <dt><kbd>cooldown &lt;seconds&gt;</kbd></dt>
		    <dd>Sets the cooldown for custom commands. Default is 5 seconds.</dd>

		    <dt><kbd>updatedelay &lt;seconds&gt;</kbd></dt>
		    <dd>The delay between your last scrobble and <?php echo $SITE_TITLE; ?> updating the song information in chat. Default is 120 seconds to account for last.fm's preemptive scrobbling and twitch's delay.</dd>

		    <dt><kbd>gamertag &lt;gamertag&gt; </kbd></dt>
		    <dd>Sets your gamertag for Xbox Live.</dd>

		    <dt><kbd>urban &lt;on|off&gt;</kbd></dt>
		    <dd>Enables or disables the use of <kbd class="command">urban</kbd></dd>

		  </dl>


		  <h3 id="userlevels" class="commands-nav-heading">User levels</h3>

		  <p>Consists of Owners, Mods, and Regulars. Owner have permission to you all channel bot commands. Mods have permission to use moderation related commands. Regulars are immune to the link filter. Mods are optional if you only wish to use Twitch mod status.</p>

		  <dl>

		    <dt><kbd class="command">owner|mod|regular list</kbd></dt>
		    <dd>Lists users in that group.</dd>

		    <dt><kbd class="command">owner|mod|regular add|remove &lt;name&gt;</kbd></dt>
		    <dd>Adds or removes a user from that group.</dd>
		  </dl>




		  <h2 id="filters" class="commands-nav-heading">Filters</h2>

		  <dl>

		    <dt><kbd class="command">filter on|off</kbd></dt>
		    <dd>Enables or disables all filters.</dd>

		    <dt><kbd class="command">filter status</kbd></dt>
		    <dd>Displays status of all filter options.</dd>

		    <dt><kbd class="command">filter me on|off</kbd></dt>
		    <dd>Toggle the action (AKA, /me) filter.</dd>

		    <dt><kbd class="command">filter enablewarnings on|off</kbd></dt>
		    <dd>Permits a user to post one link.</dd>

		    <dt><kbd class="command">filter displaywarnings on|off</kbd></dt>
		    <dd>Toggle a message warning and announcing filter timeouts.</dd>

		    <dt><kbd class="command">filter timeoutduration &lt;seconds&gt;</kbd></dt>
		    <dd>Sets default timeout duration for filter timeouts.</dd>

		    <dt><kbd class="command">filter messagelength &lt;number of characters&gt;</kbd></dt>
		    <dd>Sets the maximum allowable character length for a message.</dd>

		  </dl>


		  <h3 id="links" class="commands-nav-heading">Links</h3>

		  <dl>

		    <dt><kbd class="command">filter links on|off</kbd></dt>
		    <dd>Toggles link filtering on or off.</dd>

		    <dt><kbd class="command">filter pd add|delete &lt;domain&gt;</kbd></dt>
		    <dd>Configures permitted domains.</dd>

		    <dt><kbd class="command">filter pd list</kbd></dt>
		    <dd>Lists domains that are allowed to bypass link filter.</dd>
		  </dl>


		  <h3 id="caps" class="commands-nav-heading">Capitals</h3>

		  <dl>

		    <dt><kbd class="command">filter caps on|off</kbd></dt>
		    <dd>Toggle caps filtering on and off.</dd>

		    <dt><kbd class="command">filter caps status</kbd></dt>
		    <dd>Displays the current values.</dd>
		  </dl>

		  <p>Filtered messages must match all three of the below settings:</p>

		  <dl>

		    <dt><kbd class="command">filter caps percent &lt;int(0-100)&gt;</kbd></dt>
		    <dd>&gt;= this percentage of caps per line.</dd>

		    <dt><kbd class="command">filter caps mincaps &lt;int&gt;</kbd></dt>
		    <dd>&gt;= this number of caps per line.</dd>

		    <dt><kbd class="command">filter caps minchars &lt;int&gt;</kbd></dt>
		    <dd>total characters per line must be &gt;= this number.</dd>
		  </dl>


		  <h3 id="banphrases" class="commands-nav-heading">Banned phrases</h3>

		  <dl>
		    <dt><kbd class="command">filter banphrase on|off</kbd></dt>
		    <dd>Turns the banned phrases filter on or off.</dd>

		    <dt><kbd class="command">filter banphrase list</kbd></dt>
		    <dd>Lists filtered phrases.</dd>

		    <dt><kbd class="command">filter banphrase add &lt;phrase&gt;</kbd></dt>
		    <dd>Adds string to filter - Accepts direct regular expressions (Prefix with REGEX:).</dd>

		    <dt><kbd class="command">filter banphrase delete &lt;phrase&gt;</kbd></dt>
		    <dd>Removes string from filter.</dd>

		  </dl>


		  <h3 id="symbols" class="commands-nav-heading">Symbols</h3>

		  <p>Covers ASCII symbols, unicode classes for box drawings, block elements and geometric shapes also select other spammed characters.</p>

		  <dl>

		    <dt><kbd class="command">filter symbols on|off</kbd></dt>
		    <dd>Toggle symbols filtering on and off.</dd>

		    <dt><kbd class="command">filter symbols status</kbd></dt>
		    <dd>Displays the current values.</dd>
		  </dl>

		  <p>Filtered messages must match both of the below settings:</p>

		  <dl>
		    <dt><kbd class="command">filter symbols percent &lt;int(0-100)&gt;</kbd></dt>
		    <dd>&gt;= this percentage of symbols per line.</dd>

		    <dt><kbd class="command">filter symbols min &lt;int&gt;</kbd></dt>
		    <dd>&gt;= this number of symbols per line.</dd>

		  </dl>


		  <h3 id="emotes" class="commands-nav-heading">Emotes</h3>

		  <p>Limits Twitch global emotes.</p>

		  <dl>

		    <dt><kbd class="command">filter emotes on|off</kbd></dt>
		    <dd>Toggle emote spam filtering on and off.</dd>

		    <dt><kbd class="command">filter emotes max &lt;int&gt;</kbd></dt>
		    <dd>Max number of emotes allowed.</dd>

		    <dt><kbd class="command">filter emotes single on|off</kbd></dt>
		    <dd>Toggles filter for single emote messages.</dd>

		  </dl>




		  <h2 id="miscellaneous" class="commands-nav-heading">Miscellaneous</h2>


		  <h3 id="stringreplacement" class="commands-nav-heading">String replacement</h3>

		  <p>Adding dynamic data to bot message is also supported via string substitutions. Almost any response from the bot will accept a replacement. The following substitutions are available:</p>
		  <dl>

		    <dt><kbd>(_GAME_)</kbd></dt>
		    <dd>Twitch Game.</dd>

		    <dt><kbd>(_STATUS_)</kbd></dt>
		    <dd>Channel Status.</dd>

		    <dt><kbd>(_VIEWERS_)</kbd></dt>
		    <dd>Viewer Count.</dd>

		    <dt><kbd>(_STEAM_GAME_)</kbd></dt>
		    <dd>Steam Game (Steam account must be configured).</dd>

		    <dt><kbd>(_STEAM_SERVER_)</kbd></dt>
		    <dd>Server the user is currently playing on with a compatible SteamWorks game. (Steam account must be configured).</dd>

		    <dt><kbd>(_STEAM_STORE_)</kbd></dt>
		    <dd>Links to the Steam store for the game the user is currently playing. (Steam account must be configured). If the game is not on steam it will post a link from a google search.</dd>

		    <dt><kbd>(_SONG_)</kbd></dt>
		    <dd>Last scrobbled Last.fm track name and artist. (Last.fm account must be configured).</dd>

		    <dt><kbd>(_SONG_URL_)</kbd></dt>
		    <dd>Links to the Last.fm page for the current song.</dd>

		    <dt><kbd>(_LAST_SONG_)</kbd></dt>
		    <dd>Pulls the previous scrobbled Last.fm track name and artist.</dd>    

		    <dt><kbd>(_BOT_HELP_)</kbd></dt>
		    <dd>Bot's help message. See bothelpMessage in global.properties.</dd>

		    <dt><kbd>(_USER_)</kbd></dt>
		    <dd>Nickname of the user requesting a command or triggering an autoreply.</dd>

		    <dt><kbd>(_QUOTE_)</kbd></dt>
		    <dd>A random quote from the quote database.</dd>

		    <dt><kbd>(_COMMERCIAL_)</kbd></dt>
		    <dd>Runs a commercial (mostly used for scheduling/repeating) -replaces the entire message that contains <kbd>(_COMMERCIAL_)</kbd> with "Running a commercial, thank you for supporting this channel."</dd>

		    <dt><kbd>(_PARAMETER_)</kbd></dt>
		    <dd>This is replaced by the parameter after the command is called. Multiple parameters can be used in one command, and when calling it separate the individual parameters with ';'.</dd>

		    <dt><kbd>(_PARAMETER_CAPS_)</kbd></dt>
		    <dd>Does the same thing as <kbd>(_PARAMETER_)</kbd>, but converts the input to all capital letters.</dd>

		    <dt><kbd>(_NUMCHANNELS_)</kbd></dt>
		    <dd>Returns the number of channels that <?php echo $SITE_TITLE; ?> is currently active in.</dd>

		    <dt><kbd>(_XBOX_GAME_)</kbd></dt>
		    <dd>The last played game on Xbox Live</dd>

		    <dt><kbd>(_XBOX_PROGRESS_)</kbd></dt>
		    <dd>The achievement progress for the last played game on Xbox Live.</dd>

		    <dt><kbd>(_XBOX_GAMERSCORE_)</kbd></dt>
		    <dd>The users's gamerscore from Xbox Live</dd>

		    <dt><kbd>(_ONLINE_CHECK_)</kbd></dt>
		    <dd>Adding this to any command will prevent the command from running if the streamer isn't live.</dd>

		    <dt><kbd>(_SUBMODE_ON_)</kbd></dt>
        	    <dd>Puts the chat into subscribers-only mode.</dd>

        	    <dt><kbd>(_SUBMODE_OFF_)</kbd></dt>
        	    <dd>Takes the chat out of subscribers-only mode.</dd>

        	    <dt><kbd>(_GAME_IS_&lt;GAME&gt;_)</kbd></dt>
        	    <dd>Only runs the command when the Twitch game title is set to &lt;GAME&gt;. Use hyphens in place of spaces. e.g. <kbd>(_GAME_IS_Rocket-League_)</kbd></dd>

        	    <dt><kbd>(_GAME_IS_NOT_&lt;GAME&gt;_)</kbd></dt>
        	    <dd>Only runs the command when the Twitch game title is not set to &lt;GAME&gt;. Use hyphens in place of spaces. e.g. <kbd>(_GAME_IS_NOT_League-of-Legends_)</kbd></dd>

		    <dt><kbd>(_HOST_&lt;CHANNEL&gt;_)</kbd></dt>
        	    <dd>Host the channel given by &lt;CHANNEL&gt;</dd>        

        	    <dt><kbd>(_UNHOST_)</kbd></dt>
        	    <dd>Exits host mode.</dd>

        	    <dt><kbd>(_RANDOM_&lt;MIN&gt;_&lt;MAX&gt;_)</kbd></dt>
        	    <dd>Returns a random number between &lt;MIN&gt; and &lt;MAX&gt; with up to one decimal place</dd>     

        	    <dt><kbd>(_RANDOM_INT_&lt;MIN&gt;_&lt;MAX&gt;_)</kbd></dt>
        	    <dd>Returns a random integer (whole number) between &lt;MIN&gt; and &lt;MAX&gt;</dd>     

		    <dt><kbd>(_&lt;COMMANDNAME&gt;_COUNT_)</kbd></dt>
		    <dd>Returns the number of times the &lt;command&gt; has been called.</dd>

		    <dt><kbd>(_PURGE_)</kbd></dt>
		    <dd>This purges the user passed in, similar to <kbd>(_PARAMETER_)</kbd>. Commands containing this are automatically restricted to moderator+. For autoreplies, the user that triggers the autoreply is the one affected.</dd>

		    <dt><kbd>(_TIMEOUT_)</kbd></dt>
		    <dd>This times out the user passed in, similar to <kbd>(_PARAMETER_)</kbd>. Commands containing this are automatically restricted to moderator+. For autoreplies, the user that triggers the autoreply is the one affected.</dd>

		    <dt><kbd>(_BAN_)</kbd></dt>
		    <dd>This bans the user passed in, similar to <kbd>(_PARAMETER_)</kbd>. Commands containing this are automatically restricted to moderator+. For autoreplies, the user that triggers the autoreply is the one affected.</dd>

		  </dl>

		  <h4>Examples</h4>
		  <ul>
			  <li><kbd class="command">command add shame (_PARAMETER_) has been a naughty chat participant.</kbd><br>Calling the command: <kbd class="command">shame &lt;user&gt;</kbd><br> Output: &lt;user&gt; has been a naughty chat participant.</li>

			  <li><kbd class="command">command add multistream http://twitch.tv/(_PARAMETER_)/(_PARAMETER_)</kbd><br>Calling the command: <kbd class="command">multistream endsgamer; coebot</kbd><br> Output: http://twitch.tv/endsgamer/coebot</li>
			</ul>

		  <h3 id="admin" class="commands-nav-heading">Administration</h3>

		  <p>These commands are only available to administrators of a bot instance. Admin usernames are defined in global.properties. Twitch Admins and Staff also have access.</p>
		  <dl>

		    <dt><kbd class="command">admin join &lt;#channelname&gt;</kbd></dt>
		    <dd>Joins channelname. (Note: Forces mode -1). <?php printAccessLabel(99); ?></dd>

		    <dt><kbd class="command">admin part &lt;#channelname&gt;</kbd></dt>
		    <dd>Leaves channelname. <?php printAccessLabel(99); ?></dd>

		    <dt><kbd class="command">admin &lt;#channelname&gt; &lt;command...&gt;</kbd></dt>
		    <dd>Executes a command as though it were run on channelname. This can modify the configuration of the other channel, so use it with care. <?php printAccessLabel(99); ?></dd>

		    <dt><kbd class="command">verboselogging &lt;true|false&gt;</kbd></dt>
		    <dd>Enables/disables very detailed logging for the bot. <?php printAccessLabel(99); ?></dd>

		    <dt><kbd class="command">imp &lt;channelname&gt; &lt;command...&gt;</kbd></dt>
		    <dd>Executes a given command as though it were sent by channelname. <?php printAccessLabel(99); ?></dd>

		    <dt><kbd class="command">sendupdate</kbd></dt>
		    <dd>Forces the channel's config file to be uploaded to the website. <?php printAccessLabel(99); ?></dd>

		  </dl>


    </div>


    <div class="col-sm-3 col-lg-2">
			<div class="nav-commands-scroll" id="navCommandsScroll" data-spy="affix"><!--  data-offset-top="60" data-offset-bottom="200" -->
				<ul class="nav nav-commands">
				  <li class="active">
				  	<a href="#general"><i class="icon-fw icon-info-circled"></i>&nbsp; General</a>
				  </li>
				  <li>
				  	<a href="#custom"><i class="icon-fw icon-brush"></i>&nbsp; Custom commands</a>
				  	<ul class="nav">
				  		<li><a href="#triggers">Triggers</a></li>
				  		<li><a href="#repeat">Repeats</a></li>
				  		<li><a href="#scheduled">Schedule</a></li>
				  		<li><a href="#autoreplies">Auto-replies</a></li>
				  	</ul>
				  </li>
				  <li>
				  	<a href="#fun"><i class="icon-fw icon-smile"></i>&nbsp; Fun</a>
				  	<ul class="nav">
				  		<li><a href="#quotes">Quotes</a></li>
				  		<li><a href="#polls">Polls</a></li>
				  		<li><a href="#giveaways">Giveaways</a></li>
				  		<li><a href="#raffles">Raffles</a></li>
				  		<li><a href="#highlights">Highlights</a></li>
				  		<li><a href="#boirebirth">Binding of Isaac: Rebirth</a></li>
				  	</ul>
				  </li>
				  <li>
				  	<a href="#moderation"><i class="icon-fw icon-hammer"></i>&nbsp; Moderation</a>
				  	<ul class="nav">
				  		<li><a href="#modshortcuts">Shortcuts</a></li>
				  		<li><a href="#ignores">Ignores</a></li>
				  		<li><a href="#raids">Raids</a></li>
				  		<li><a href="#settings">Settings</a></li>
				  		<li><a href="#userlevels">User levels</a></li>
				  	</ul>
				  </li>
				  <li>
				  	<a href="#filters"><i class="icon-fw icon-filter"></i>&nbsp; Filters</a>
				  	<ul class="nav">
				  		<li><a href="#links">Links</a></li>
				  		<li><a href="#caps">Capitals</a></li>
				  		<li><a href="#banphrases">Banned phrases</a></li>
				  		<li><a href="#symbols">Symbols</a></li>
				  		<li><a href="#emotes">Emotes</a></li>
				  	</ul>
				  </li>
				  <li>
				  	<a href="#miscellaneous"><i class="icon-fw icon-puzzle"></i>&nbsp; Miscellaneous</a>
				  	<ul class="nav">
				  		<li><a href="#stringreplacement">String replacement</a></li>
				  		<li><a href="#admin">Administration</a></li>
				  	</ul>
				  </li>
				</ul>
			</div>
    </div>
  </div>
</div>
<?php
printFooter();
printFoot();
?>
