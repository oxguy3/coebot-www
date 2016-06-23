# coebot-www
A web interface for [CoeBot](https://bitbucket.org/tucker_gardner/coebot), a Twitch.tv chat moderation bot.

## Installation
This site is still very early in development so I'm not gonna bother writing detailed install instructions that might change dramatically later, but it's mostly just a standard AMP (Apache/MySQL/PHP) application. Put the files on an Apache server with PHP and enable .htaccess files or copy the contents of the .htaccess file to your Apache config file. The database structure can be rebuilt using the file dbstructure.sql (which I will do my best to keep up to date).

You might notice that one particular file is missing. To keep secret data safe, I put confidential details in a file called safeconfig.php that isn't posted to GitHub. Here's what that file looks like so that you can recreate it:

```php
<?php

define(SITE_DOMAIN, "coebot.tv"); // change to your domain name
define(SITE_ENV, "PROD"); // set to "PROD" or "TEST" depending on if the site is live or not

// mysql details for new site
define(DB_SERV, "<ip/hostname of mysql server>");
define(DB_USER, "<mysql username>");
define(DB_PASS, "<mysql password>");
define(DB_NAME, "<mysql database name>");
define(DB_PREF, "<prefix to prepend to all table names>");

// mysql details for highlights site
define(DB_HIGHLIGHTS_SERV, "<ip/hostname of mysql server>");
define(DB_HIGHLIGHTS_USER, "<mysql username>");
define(DB_HIGHLIGHTS_PASS, "<mysql password>");
define(DB_HIGHLIGHTS_DATA, "<mysql database name>");

// twitch api keys
define(TWITCH_CLIENT_SECRET, "<twitch api client secret>");
define(TWITCH_CLIENT_ID, "<twitch api client id>");
define(TWITCH_REDIRECT_URI, "http://coebot.tv/twitchconnect.php"); // change "coebot.tv" to your domain name
define(TWITCH_REQUIRED_SCOPES, "user_read"); // shouldn't need to change this

// twitch usernames (all lowercase) of anyone who should have admin powers on the website
$GLOBAL_ADMINS = array('itsoxguy3', 'endsgamer');

?>
```

The site is in pretty rapid development right now and this version of the file is going to become outdated (in fact, it already is); please contact me if you need help with this.

## Private API
This site uses a private API to communicate with CoeBot. This API is still in planning and is rapidly evolving (do not assume currently existing endpoints will exist indefinitely), but the specification so far is available [here](https://docs.google.com/document/d/1tQNETtRvTuSdGKEep57yuO_8J_YfjS5J3--Q6vH0Rcc/edit?usp=sharing). The source code of api.php is considered more canonical than this document for the time being however.

## License
CoeBot.tv: A website for CoeBot, the Twitch chat moderation bot

Copyright (C) 2014-2015 Hayden Schiff*

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

The full text of the license can be found in the file LICENSE,
or at [http://www.gnu.org/licenses/gpl-2.0.html](http://www.gnu.org/licenses/gpl-2.0.html).

*The original code for the "highlight that" functionality is Copyright (C) 2014 Stijn Van Baekel (stinusmeret)
