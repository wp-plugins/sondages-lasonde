=== Plugin Name ===
Contributors: Lasonde.fr
Donate link: http://www.lasonde.fr/plugin-sondages-lasonde-fr-pour-wordpress/
Tags: Lasonde, lasonde.fr,polls, do a poll, create polls, surveys, blogs, polls, survey, sondage, sondages, créer un sondage, faire un sondage, administration sondage, sondages gratuits, free polls
Requires at least: 2.8
Tested up to: 3.1
Stable tag: 1.2.4.1

Lasonde.fr can add polls on wordpress sites ...
MultiLang 
Free and Easy to integrate.

== Description ==

Lasonde allows to create polls.

= Langs: =

- English (en_GB, en_US)
- French (fr_FR)

= Features: =

- Replies (radio or checkbox for multiple votes) (unlimited)
- Date of Poll
- End date of survey
- Blocking by IP / cookie votes with choice of the length restriction (prevents a person vote 2 times.)
- CSS => Choosing the style of the survey, create your style, fully customizable with CSS or use the styles offered by Lasonde.fr
- Private or public (pubic = Lasonde.fr seen by visitors)
- Effects of the bars results (slide, rubber bands, etc. ...)
- Charts configurable with Google Chart API
- Export results as XML and CSV
- Tracking results in real time via the administration.
- Export and share polls through a javascript code to paste onto your site. (Or automatically via plugin)
- Show or hide the results.

= You can add polls with the plugin: =

- Using the button in the editor Polls Lasonde articles or pages (WYSIWYG)
- Using Widgets Polls-Lasonde in your sidebars,
- Adding a tag `[Lasonde sd_id =" XXX "] *` in articles and pages
- In by calling the `<?Php LSD_print_script_tag (" XXX "); ?>` * In templates and plugins
* Where XXX is the id of the poll (The id is recovered from the site Lasonde.)


== Installation ==

1. Unzip and upload `polls` Lasonde-in directory `/ wp-content/plugins /`
2. Activate the plugin via the Plugins menu in WordPress
3. Tag, function php LSD_print_script_tag `` and `button (WYSIWYG)` are enabled.
If you encounter problems with installing thank you to contact the administrator.


== Frequently Asked Questions ==
= How do I create a poll? =
To create a poll must have an account lasonde.fr
and go on http://www.lasonde.fr/gestion/creer-un-sondage/

= What does the plugin Lasonde? =
Lasonde.fr plugin allows you to add your wordpress blogs
polls lasonde.fr your account

= How to get a key Lasonde.fr =
1. You need a key to access your lasonde.fr polls since the plugin,
You must make your on [your dashboard Lasonde.fr] (http://www.lasonde.fr/gestion/tableau-de-bord/ Scoreboard Lasonde.fr ")
API key appears at the bottom of the page, copy the.
2. Go to options Polls Lasonde.fr your wordpress blog and then paste the key
in the field provided. Then Save.
3. The plugin automatically finds your surveys.

= The plugin does not work on my server =
If your webserver does not execute the php function file_get_contents `()` when the plugin does not work.
To enable this feature on your server, you must have a php version> 4.3 and verify that the variable
Allow_url_fopen = On `is` in your php.ini
It seems that 1and1 shared servers OVH or do not permit such use.

== Screenshots ==
1. Listing Added popup surveys in an article / page
2. Screeshot Page Setup
3. Screeshot creating a widget


== Changelog ==
= 1.2.4.1 =
English translation of the plugin (en_GB,en_US)
French translation of the plugin (fr_FR)


Upgrade Instructions == ==
= 1.2.4.1 =
English translation of the plugin (en_GB,en_US)
French translation of the plugin (fr_FR)


Go to [Lasonde.fr / wordpress plugin] (http://www.lasonde.fr/plugin-sondages-lasonde-fr-pour-wordpress/ "Install Polls Lasonde on wordpress)

== !!! ==
If your webserver does not execute the php function file_get_contents `()` when the plugin does not work.
To enable this feature on your server, you must have a php version> 4.3 and verify that the variable
Allow_url_fopen = On `is` in your php.ini
It seems that 1and1 shared servers OVH or do not permit such use.
