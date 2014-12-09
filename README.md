# coebot-www
A web interface for [Coebot](https://bitbucket.org/tucker_gardner/coebot), a Twitch.tv chat moderation bot.

## Installation
This site is still very early in development so I'm not gonna bother writing detailed install instructions that might change dramatically later, but it's mostly just a standard AMP (Apache/MySQL/PHP) application. Put the files on an Apache server with PHP and enable .htaccess files or copy the contents of the .htaccess file to your Apache config file.

## Private API
This site uses a private API to communicate with Coebot. This API is still in planning, but the specification so far is available [here](https://docs.google.com/document/d/1tQNETtRvTuSdGKEep57yuO_8J_YfjS5J3--Q6vH0Rcc/edit?usp=sharing).

## License
For the time being, this project is licensed under the [GNU General Public License v3](http://www.gnu.org/licenses/gpl-3.0.txt). However, I'm only using the GPLv3 to satisfy the license of prettycron.js. Ultimately, I plan to replace prettycron.js with my own code (or another similar tool) so that I can release this project under the MIT License. This isn't exactly a top priority, however, so it might stay GPLv3 for a little while.

As a consequence of being between licenses, I probably won't be able to accept contributions from other people. Potential features and suggestions are very welcome, but unfortunately I can't accept pull requests very easily.
