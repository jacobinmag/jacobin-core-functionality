=== Jacobin Core Functionality ===
Contributors: misfist
Tags: custom post type, custom taxonomy, rest api
Requires at least: 4.5
Tested up to: 4.5.3
Version: 0.1.8.1
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

= 0.1.8.1 September 16, 2016 =
* Escaped user website in REST response

= 0.1.8 September 16, 2016 =
* [#36] Added translator user field to articles using
* [#37] Changed interviewee and interviewer fields. Interviewee will used the authors field (which using co-authors plus).
* Modified cover artist to use guest-author
Note: Interviewer, cover artist and translators use a custom field pulling from the custom post type guest-author. REST API is returning in form of authors.

= 0.1.7.2 September 16, 2016 =
* [#38] Decreased question field height for interview articles

= 0.1.7.1 September 11, 2016 =
* Optimized `get_issue_articles` function
* Updated `authors` response data to return data from Co-authors Plus for issues

= 0.1.7 September 11, 2016 =
* Registered `guest-author` cpt and `author` taxonomy with REST API
* Updated `authors` response data to return data from Co-authors Plus
   * Data returned as an array in the form
```json
authors": [
    {
        "id": {int},
        "name": {string},
        "first_name": {string},
        "last_name": {string},
        "description": {string},
        "link": {url}
    },
    {
        "id": {int},
        "name": {string},
        "first_name": {string},
        "last_name": {string},
        "description": {string},
        "link": {url}
    }
]
```
= 0.1.6 September 4, 2016 =
* Activated field settings that remove certain meta_boxes from posts and issues
* Moved `lang` dir to `languages`
* Added author support to custom post type library

= 0.1.5 July 28, 2016 =
* [Breaking Change] - Changed `rest_base` to use lowercase plural of custom post type (e.g. issues instead of issue) to be consistent with default post types.
* Added function to return appropriate date format for timeline
   * If `month` && `day`, but not `year` @return string 'F jS' (e.g. January 1st)
   * If `day`, but not `month` @return string 'l' (e.g. Saturday)
   * Otherwise, just build up to default 'F j, Y' (e.g. January 1, 2024)

= 0.1.4 July 28, 2016 =
* Added `chart` post type
* Created shortcode for embedding chart
* Registered `embed-chart` shortcode with Shortcode UI to create easy interface
* Added view for chart shortcode
* Renamed the chart custom field key to `custom_fields`
* Added admin style to fix display of ACF code field
* Modified output to remove extra spaces, line feeds and tabs from chart output
* Updated timeline markup to be more semantic

= 0.1.3 July 27, 2016 =
* Added `timeline` post type
* Created shortcode for embedding timeline
* Registered shortcode with Shortcode UI to create easy interface
* Added view for shortcode based on requested markup
* Renamed the timeline custom field key to `custom_fields`
* [bugfix] Fixed `Trying to get property of non-object in class-jacobin-core-register-fields.php`

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
