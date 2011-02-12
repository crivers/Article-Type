=== Article Type ===

Contributors: kolnik
Donate link: http://zanematthew.com/donate/
Tags: widget, article type, editorial, post, custom post type, custom taxonomies, short code, organization
Requires at least: 3.0
Tested up to: 3.0
Stable tag: 1.0.2

Registers custom post type "article", with category, tag, short-code and widget support

== Description ==

This plugin does the "grunt" work for registering a custom post type called "article" with categories,
tags, along with widget support and short-code features.

This plugin is at aimed the user that wants to better organize their content, but not do all the server side code.
I've done that for you, all that is left is some light "theming" via CSS. This plugin may seem redundant when compared to "posts", seeing 
as how it has almost all the features of a post, but I'm attempting to separate the "concept" of publishing "content" as a journal entry i.e. post
versus a periodical i.e. article, hope others find it useful.

Widget supports the following:
(Requirments: your theme must support Widgets! For this feature to work)
* Custom title
* Article count
* Choose category to display (choosing ALL may result in "post bleed" on archive pages, not recommmended)
* Choose tag to display
* Choose thumbnail to display 
* Show posted on
* Show posted in
* Show excerpt (based on your settings defined in functions.php)

Short-code "most recent articles box" with the following:
* Specify count
* Specify category
* Custom title

Short-code "meta box" and "meta list" with the following:
* unique class name for styling

== Installation ==

1. Upload the folder `article-type` to the `/wp-content/plugins/` directory or "install" it via the 'Plugins' menu in WordPress
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Re-save permalinks

== Frequently Asked Questions ==

= Permalinks do not work? =

Goto the permalinks section of your site and click 'Save Changes'
** YOU MUST SAVE OUT PERMALINKS WHEN YOU ENABLE THIS PLUGIN **

= Why is my widget theme "broken"? =

Widget themes are based on your current 'image' in the widget. If you recenlty changed the widget 
you may have togo "save" the widget again for the setting to take effect. If you drastically want something different feel free to contact me.

= Why are my Articles NOT showing up in the archive page? =

This is something which will not be supported as archive pages are designed to ONLY show post data, hence
your archive page does NOT show POST + PAGES, just post. If your interested in having a custom archive page 
on a per custom post type basis, please contact me for contract work.

= How can I get to a "view all articles page"? =

See above, this would be a custom archive page, please contact me.

= Does disabling this plugin delete my article post types from the database? =

No, your articles are still there. I've thought about adding a "uninstall feature", but haven't yet

== Screenshots ==

1. MRA widget
2. Short code in use, note the widget in the sidebar (Note I'm using 3.1RC)
3. Short code implied in the wisywig

== Changelog ==

= 1.0.2 = 
Still trying to get the readme.txt file correct, the file wasn't reading the screenshots.
