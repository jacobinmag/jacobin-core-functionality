=== Jacobin Core Functionality ===
Contributors: misfist
Tags: custom post type, custom taxonomy, rest api
Requires at least: 4.5
Tested up to: 4.5.3
Stable tag: 0.1.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Contains the site's core functionality.

== Description ==

Contains the site's core functionality.

For backwards compatibility, if this section is missing, the full length of the short description will be used, and
Markdown parsed.


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `jacobin-core-functionality.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 0.1.3 July 27, 2016 =
* Added `timeline` post type
* Created shortcode for embedding timeline
* Registered shortcode with Shortcode UI to create easy interface
* Added view for shortcode based on requested markup
* Renamed the timeline custom field key to `custom_fields`

= 0.1.2 [WIP] =
* Register subhead field with REST API
* Added test options page
* Removed unneeded front-end CSS and JS
* Added custom post type class
* Added custom taxonomy class
* Added field settings class
* Added options controller class

= 0.1.1 =
* Removed standard WordPress metaboxes for custom taxonomies.

= 0.1.0 =
Initial.

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above.  This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation."  Arbitrary sections will be shown below the built-in sections outlined above.