=== Plugin Name ===
Contributors: kolnik
Donate link: http://zanematthew.com/donate/
Tags: widget, article type, post, custom post type, custom taxonomies, short code, organization
Requires at least: 3.0
Tested up to: 3.0
Stable tag: 0.0.1

Registers custom post type "article", with category, tag, short-code and widget support

== Description ==
This plugin does the "grunt" work for registering a custom post type called "article" with categories and
tas associated with it, along with widget support and short-code features.

This plugin is aimed the user that wants to better orgainze their content, but not do all the server side code.
I've done that for, all that is left is some light "theming". There are sample styles to get your started.

Widget with the following:
(Requirments: your theme must support Widgets! For this feature to work)
* Custom title
* Specicy number of articles to display
* Choose category to display 
* Choose tag to display
* Choose Image to display
* Show post on
* Show post in
* Show excerpt (based on your settings defined in functions.php)

Short-code "most recent articles box" with the following:
* Specify count
* Specify category
* Custom title

Short-code "meta box" and "meta list" with the following:
* unique class name for styling

== Installation ==
Plugin:
1. Upload the folder `article-type` to the `/wp-content/plugins/` directory or 
"install" it via the 'Plugins' menu in WordPress
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Save permalinks

== Frequently Asked Questions ==
= Permalinks do not work? =
Goto the permalinks section of your site and click 'Save Changes'
** YOU MUST SAVE OUT PERMALINKS WHEN YOU ENABLE THIS PLUGIN **

= Why is my widget theme "broken"? =
Widget themes are based on your current 'image' in the widget. If you recenlty changed the widget 
you may have togo "save" the widget again for the setting to take effect.

If you drastically want something different feel free to contact me for contract work.

= Why are my Articles NOT showing up in the archive page? =
This is something which will not be supported as archive pages are designed to ONLY show post data, hence
your archive page does NOT show POST + PAGES, just post. If your interested in having a custom archive page 
on a per custom post type basis, please contact me for contract work.

= How can I get to a "view all articles page"? =
See above, this would be a custom archive page, please contact me.
