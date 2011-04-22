=== Plugin Name ===
Contributors: Lasonde.fr
Donate link: http://www.lasonde.fr/plugin-sondages-lasonde-fr-pour-wordpress/
Tags: Lasonde, lasonde.fr,polls, do a poll, create polls, surveys, blogs, polls, survey, sondage, sondages, crŽer un sondage, faire un sondage, administration sondage, sondages gratuits, free polls
Requires at least: 2.8
Tested up to: 3.1.1
Stable tag: 1.4

To read this page in French you can Go to [Lasonde.fr / wordpress plugin (FR)] (http://www.lasonde.fr/plugin-sondages-lasonde-fr-pour-wordpress/ "Install Polls Lasonde on wordpress (FR)")

Lasonde.fr can add polls on wordpress sites ...
MultiLang 
Free and Easy to integrate.

== Description ==
Lasonde to create polls.

= Langs: =
- English (en_GB, en_US)
- French (fr_FR)

= Features: =
- Replies (radio or checkbox for multiple votes) (unlimited)
- Start Date of survey (Date And Time)
- End date of survey (Date And Time)
- Blocking by IP / cookie votes with choice of the restriction duration (prevents a person vote 2 times.)
- CSS => Choosing the style of the survey, create your style, fully customizable with CSS or use the styles offered by Lasonde.fr
- Private or public (pubic = Lasonde.fr seen by visitors)
- Effects of the results bars (slide, EaseIn EaseOut etc...)
- Charts configurable with Google Chart API
- Tracking results in real time via the administration of Lasonde.fr
- Export results as XML and CSV
- Export and share polls through a javascript code to paste onto your site or automatically via plugin (Or on Socials network)
- Show or hide the results.


= You can add polls with the plugin: =
- Using the button in the editor Polls Lasonde articles or pages (WYSIWYG)
- Using Widgets Polls-Lasonde in your sidebars,
- Adding a tag `[Lasonde sd_id =" XXX "]` in articles and pages
- By calling the `<?php LSD_print_script_tag (" XXX "); ?>` In templates and plugins
* Where XXX is the id of the poll (The id is recovered from the site Lasonde.)

= You can create polls from the plugin: =
Using the IFrame Lasonde.fr directly in the plugin.

== Installation ==
1. Unzip and upload `sondages-lasonde` in directory `/wp-content/plugins/`
2. Activate the plugin via the Plugins menu in WordPress
3. Tag, function php `LSD_print_script_tag()` and `button (WYSIWYG)` are enabled.
If you encounter problems with installing thank you to contact the administrator.


== Frequently Asked Questions ==
= How do I create a poll? =
To create a poll must have an account lasonde.fr
and go on [this page](http://www.lasonde.fr/gestion/creer-un-sondage/ "Go to create surveys")
Or you can use the Iframe system directly in your plugin Lasonde.fr


== Screenshots ==
1. Add surveys popup in an article / page
2. Screeshot Page Setup
3. Screeshot creating a widget


== Changelog ==
= 1.4 =
Add Iframe in Admin to manage survey
Minify some js
Add support JS to add videos, iframe, and object in surveys.
= 1.3 =
Add `curl` and replace `file_get_contents` for api
Add timeOut for curl and file get contents.
If curl is not working the plugin will try `file_get_contents`

== Upgrade Instructions ==
= 1.3 =
Extract plugin content into your `/wp-content/plugins` dir, activate the plugin. You can upgrade from admin.

Go to [Lasonde.fr / wordpress plugin] (http://www.lasonde.fr/plugin-sondages-lasonde-fr-pour-wordpress/ "Install Polls Lasonde on wordpress")






