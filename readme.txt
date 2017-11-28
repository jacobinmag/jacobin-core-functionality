=== Jacobin Core Functionality ===
Contributors: misfist
Tags: custom post type, custom taxonomy, rest api
Requires at least: 4.7
Tested up to: 4.9.0
Version: 0.4.7
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

### 0.4.7 November 22, 2017
* #389 Added footnotes field to posts @link https://github.com/positiondev/jacobin/issues/389
* #390 Added second feature image to issues @link https://github.com/positiondev/jacobin/issues/390
* #392 Fixed issue resulting in error in version 3 @link https://github.com/positiondev/jacobin/issues/392
  * Added condition to get the version
* #394 Modified `acf` response for related issue to return `volume_number` @link https://github.com/positiondev/jacobin/issues/394

### 0.4.6 October 16, 2017
* #353 Added back featured media to listed works @link https://github.com/positiondev/jacobin/issues/343#issuecomment-337048244

### 0.4.5 October 16, 2017
* #353 Formatted section title values using `the_title` filter @link https://github.com/positiondev/jacobin/issues/353

### 0.4.4 October 14, 2017
* #361 Commented out listicle section type @link https://github.com/positiondev/jacobin/issues/361

### 0.4.3 October 11, 2017
* #361 Added back listicle section type @link https://github.com/positiondev/jacobin/issues/361
* #354 Added featured image to sections (removed from section items) @link https://github.com/positiondev/jacobin/issues/354

### 0.4.2 October 6, 2017
* #354 Added featured image to content sections @link https://github.com/positiondev/jacobin/issues/354
* #343 Added publication URL to Listed Works @link https://github.com/positiondev/jacobin/issues/343

= 0.4.1 October 1, 2017 =
* #336 Allowed editor role to view list of users (cap = `list_users`) so that they can manage guest authors @link https://github.com/positiondev/jacobin/issues/346

= 0.4.0 October 1, 2017 =
* #342 Changed content section structure @link https://github.com/positiondev/jacobin/issues/342
* #343 Changed "Annotated Booklist" @link https://github.com/positiondev/jacobin/issues/343

= 0.3.22 September 30, 2017 =
* #345 Added post memo field @link https://github.com/positiondev/jacobin/issues/345
* #333 Changed Status label to singular form. @link https://github.com/positiondev/jacobin/issues/332#issuecomment-332030317
* #344 Added republication publisher field and adapted checkbox @link https://github.com/positiondev/jacobin/issues/344

= 0.3.21 September 28, 2017 =
* #329 Added `volume_number` field to issue and added to response @link https://github.com/positiondev/jacobin/issues/329
* #331 Added boolean `toc` field to post. Response is at `acf` -> `toc` @link https://github.com/positiondev/jacobin/issues/331

= 0.3.19 September 25, 2017 =
* #332 Added new status taxonomy for internal use.
* #334 Added Autop for antescript and postscript. wysiwyg fields are now treated like `the_content`.

= 0.3.18 Septembere 21, 2017 =
* #326 Modified featured content (``/wp-json/jacobin/featured-content/{slug}/``) rendered title to use default filters
* #326 Added `meta_content` text filters and applied to subhead fields.

= 0.3.17 September 12, 2017 =
* Removed Interviewer field group

= 0.3.16 September 11, 2017 =
* #281 Changed tag taxonomy custom field type to multi-select.
  * @link https://github.com/positiondev/jacobin/issues/281#issuecomment-318088381

= 0.3.15 September 11, 2017 =
* Added feature support usually added via a theme for when no theme is used.
  * @link https://github.com/positiondev/jacobin/issues/320

= 0.3.14.1 July 24, 2017 =
*  #307 - @link https://github.com/positiondev/jacobin/issues/307
  * Changed Home Content row colors
  * Changed "Home Content 1 Text", "Home Content 2 Text" and "Home Content 3 Text" labels to "Home Title 1", "Home Title 2" and "Home Title 3"
  * Removed Home Content 2 Tag and Home Content 3 Tag
  * Rename the tag field to `home_content_tag` and its label "Featured Tag"; note: property is now `home_content_tag`
  * Created "Featured Category" select field
  * Created "Featured Series" select field
  * Moved route to `section-topics`

= 0.3.14 July 20, 2017 =
*  #307 - @link https://github.com/positiondev/jacobin/issues/307
  * Added new route at `/wp-json/jacobin/featured-content/section-titles`

= 0.3.13 July 17, 2017 =
*  #307 - @link https://github.com/positiondev/jacobin/issues/307
  * Increased home features to max 40
  * Reduced editors picks to max 4
  * Added text fields: `home_content_1`, `home_content_2`, `home_content_3`
  * Added tag fields: `home_content_1_tag`, `home_content_2_tag`, `home_content_3_tag`

= 0.3.12 July 11, 2017 =
* #305 - @link https://github.com/positiondev/jacobin/issues/305 , #296 - @link https://github.com/positiondev/jacobin/issues/296
  * Filtered default WP media markup
* #304 - https://github.com/positiondev/jacobin/issues/304
  * Enabled multiple translators

= 0.3.11 June 9, 2017 =
* #291 - @link https://github.com/positiondev/jacobin/issues/291
   * Removed escaping for `title` property on `featured-content`

= 0.3.10 June 8, 2017 =
* #281  - @link https://github.com/positiondev/jacobin/issues/281
   * Organized post edit fields into tab groups
* Fixed PHP warnings

  ```
  Trying to get property of non-object
  Line: 263
  File: /home/jacobin/webapps/editor_dev/wp-content/plugins/jacobin-core-functionality/includes/class-jacobin-core-register-fields.php

  Uninitialized string offset: 0
  Line: 263
  File: /home/jacobin/webapps/editor_dev/wp-content/plugins/jacobin-core-functionality/includes/class-jacobin-core-register-fields.php

  Trying to get property of non-object
  Line: 212
  File: /home/jacobin/webapps/editor_dev/wp-content/plugins/jacobin-core-functionality/includes/helpers.php

  Undefined offset: 0
  Line: 212
  File: /home/jacobin/webapps/editor_dev/wp-content/plugins/jacobin-core-functionality/includes/helpers.php
  ```

= 0.3.9 June 8, 2017 =
*  #291 - @link https://github.com/positiondev/jacobin/issues/291
   * Removed escaping for `title` property on `related-articles` and `featured-content`

= 0.3.8 May 19, 2017 =
* #273 - https://github.com/positiondev/jacobin/issues/273
   * Modified `acf` response for related issues to return `issue_number` and `issue_season`

= 0.3.7 May 16, 2017 =
* #203 Changed `antescript` and `postscript` fields to wysiwyg
* Removed unused walker class
* Removed `jacobin_copy_custom_fields` from `init` action

= 0.3.6 April 27, 2017 =
* #203 Added `antescript` and `postscript` fields to post

= 0.3.5 April 24, 2017 =
* #198 Added `nickname` field to `guest-author`

= 0.3.4 March 28, 2017 =
* Changed `url_source` to `source_url` in `featured_image` field

= 0.3.3 March 28, 2017 =
* #183 Added featured image to response for all public post types for which `show_in_rest` is true

= 0.3.2 March 27, 2017 =
* #182 Limited related posts fields to `publish` status

= 0.3.1 March 20, 2017 =
* Removed featured content fields and modified row colors

= 0.3.0 March 20, 2017 =
* Modify featured content UI and response

= 0.2.9 March 16, 2017 =
* Registered featured image (`featured_image`) for each public post type

= 0.2.8 March 15, 2017 =
* #178 Added `issue_season` field to issue post type and registered in REST API
* #165 Replicated `better_featured_image` response for all endpoints
* #177 Added slug to author response - comes from `cap-user_login` field in `guest-author` post
* #163 Added `subhead` and `authors` for the featured articles in `department` and `issue` responses
* Changed `custom_fields` property to default `acf`
* Limited related post lists to post = `publish`

= 0.2.7.2 March 8, 2017 =
* Enabled `guest-authors` to be retrieve using `id` ( `?id={id}` ) and `term_id` ( `?term_id={term_id}` )

= 0.2.7.1 March 4, 2017 =
* Enabled guest-authors to be retrieve using slug at `/wp-json/jacobin/` using `?slug={slug}`

= 0.2.7 March 3, 2017 =
* Modified Featured Content to split Home into sections
  * `/wp-json/jacobin/featured-content?slug=home-feature`
  * `/wp-json/jacobin/featured-content/home-feature`

  ```
  "enum": [
    "home-feature",
    "home-1",
    "home-2",
    "home-3",
    "home-4",
    "home-5",
    "editors-picks"
  ],
  ```
* Added 2 additional featured content fields: `home_4` and `home_5`
* Added `excerpt` to Featured Content response
* Modified post admin screen
  * Moved Excerpt into Article Details section
  * Moved Authors below Publish section in right column

= 0.2.6.1 March 2, 2017 =
* #171 added `term_id` and `author_posts` link to endpoint `/wp-json/wp/v2/guest-author`
* Added `featured_article` field to `issue` and `department`

= 0.2.6 March 1, 2017 =
* #173 Modified related_articles and issue_articles to return up to 20 items
* #171 Register `guest-term` in REST API and added `term_id` to author data
  `/wp-json/wp/v2/posts?authors=426`

= 0.2.5 February 28, 2017 =
* Converted `interviewer` field to multi-select
* Added `jacobin_get_guest_author_meta_for_field()` helper for getting guest author information based on field name
* Added route for guest-authors accessed at `jacobin/guest-author/(?P<id>\d+)` where `(?P<id>\d+)` is `id`
* Added `_collection` link field that links to listing of posts for author

= 0.2.4 February 22, 2017 =
* Added back `interviewer` field

= 0.2.3.2 February 20, 2017 =
* Fixed issue `parent_slug` always returning false in post response

= 0.2.3.1 February 19, 2017 =
* Added `parent_slug` to `department` response
* Fixed PHP Notice errors

  ```
  Undefined variable: taxonomy
  Line: 394
  ```

  ```
  Undefined variable: taxonomy
  Line: 392
  ```

  ```Undefined property: WP_Error::$slug
  Line: 395
  ```

= 0.2.3 February 19, 2017 =
* #169 Updated related post fields

= 0.2.2.2 February 18, 2017 =
*  Limit hierarchical `department` taxonomy list to 2 levels deep using CSS

= 0.2.2.1 February 8, 2017 =
* Corrected undefined variable errors in helpers.php

= 0.2.2 February 8, 2017 =
* Limit hierarchical `department` taxonomy list to 2 levels deep
  * Created custom `Jacobin_Core_Taxonomy_Walker` class
  * Filtered `wp_terms_checklist_args` to use custom walker for `department`

= 0.2.1.2 February 7, 2017 =
* #162
  * Added helper function `jacobin_get_post_terms` to add `parent_slug` to term object
  * Added term `parent_slug` to department response

= 0.2.1.1 February 7, 2017 =
* #162
  * Added `date` to modified response
  * Changed `post_title` to `title` to make consistent with other endpoints
  * Changed `post_name` to `slug` to make consistent with other endpoints
  * Changed `ID` to `id` to make consistent with other endpoints

```
"id",
"date",
"title"['rendered'],
"slug",
"subhead",
"authors",
"departments",
"featured_image"
```

= 0.2.1 February 6, 2017 =
* #162 Modified response for featured content endpoints.

```
"ID",
"post_title",
"post_name",
"subhead",
"authors",
"post_date",
"departments",
"featured_image"
```

= 0.2.0 February 3, 2017 =
* Registered custom fields.

= 0.1.16 January 13, 2017 =
* #150 - Added Home Page Content
   * Allows up to 10 posts
   * Accessed at `wp-json/jacobin/featured-content/home-content`

= 0.1.15 January 9, 2017 =
* Fixed error - `Fatal error: Can't use function return value in write context in /home/jacobin/webapps/editor_dev/wp-content/plugins/jacobin-core-functionality/includes/class-jacobin-core-register-fields.php on line 367`

= 0.1.14 December 8, 2016 =
* Add Editor's Pick feature `wp-json/jacobin/featured-content/editors-pick`
   * Includes `featured_image` and `authors` with meta
* #124 - Returned Departments taxonomy as array of objects
* Added Department `featured_image` and `featured_article` with meta
* Changed `null` responses to `false`

= 0.1.13.1 November 21, 2016 =
* #108 - Added `date` property to `related_articles` field

= 0.1.13 November 19, 2016 =
* #108 - Registered `related_articles` field - to each post entry, added departments, and featured_image

```
featured_image": {
  "id": 92,
  "title": {
      "rendered": "Slave Market"
  },
  "alt_text": "Photo of slave market it Atlanta",
  "description": "George N. Barnard/ Wikimedia Commons",
  "caption": "",
  "link": "http://jacobin.dev/wp-content/uploads/2016/06/slave-market.png",
  "media_details": {
      "width": 549,
      "height": 300,
      "file": "2016/06/slave-market.png",
      "sizes": {
        "thumbnail": {
          "file": "slave-market-150x150.png",
          "width": 150,
          "height": 150,
          "mime-type": "image/png"
      },
      "medium": {
          "file": "slave-market-300x164.png",
          "width": 300,
          "height": 164,
          "mime-type": "image/png"
        }
      },
      "image_meta":
        {
          "aperture": "0",
          "credit": "",
          "camera": "",
          "caption": "",
          "created_timestamp": "0",
          "copyright": "",
          "focal_length": "0",
          "iso": "0",
          "shutter_speed": "0",
          "title": "",
          "orientation": "0",
          "keywords": [ ]
        }
    }
},
"departments": [
    {
      "term_id": 3,
      "name": "Culture",
      "slug": "culture",
      "term_group": 0,
      "term_taxonomy_id": 3,
      "taxonomy": "department",
      "description": "Once all three plugins are installed and activated, browse to the Categories section of the WordPress backend. You’ll see new fields where you can assign an icon, color, and image. Icons use the Dashicon set that ships with WordPress.",
      "parent": 0,
      "count": 5,
      "filter": "raw"
    }
]
```

= 0.1.12.1 November, 2016 =
* Changed return of taxonomy terms to `orderby` => 'parent'

= 0.1.12 October 27, 2016 =
* Added general function to modify taxonomy response for all registered taxonomies returned by REST API. Format:

```
"{taxonomy}": [
  {
    "term_id": {int},
    "name": {string},
    "slug": {string},
    "term_group": {int},
    "term_taxonomy_id": {int},
    "taxonomy": {string},
    "description": {string},
    "parent": {int},
    "count": {int},
    "filter": {string}
  },
  {
    "term_id": {int},
    "name": {string},
    "slug": {string},
    "term_group": {int},
    "term_taxonomy_id": {int},
    "taxonomy": {string},
    "description": {string},
    "parent": {int},
    "count": {int},
    "filter": {string}
  }
]
```

= 0.1.11 October 20, 2016 =
* Removed unused REST API v1 methods
* Modified response to return details for `location` and `department` taxonomies. Format:

```
locations": [
  {
    "term_id": 35,
    "name": "Greece",
    "slug": "greece",
    "term_group": 0,
    "term_taxonomy_id": 35,
    "taxonomy": "location",
    "description": "",
    "parent": 33,
    "count": 5,
    "filter": "raw"
  },
  {
    "term_id": 34,
    "name": "Ireland",
    "slug": "ireland",
    "term_group": 0,
    "term_taxonomy_id": 34,
    "taxonomy": "location",
    "description": "",
    "parent": 33,
    "count": 2,
    "filter": "raw"
  }
]
```

```
"departments": [
  {
    "term_id": 41,
    "name": "Conservatism",
    "slug": "conservatism",
    "term_group": 0,
    "term_taxonomy_id": 41,
    "taxonomy": "department",
    "description": "",
    "parent": 39,
    "count": 1,
    "filter": "raw"
  },
  {
      "term_id": 40,
      "name": "Liberalism",
      "slug": "liberalism",
      "term_group": 0,
      "term_taxonomy_id": 40,
      "taxonomy": "department",
      "description": "",
      "parent": 39,
      "count": 1,
      "filter": "raw"
  }
]
```

= 0.1.10.1 September 28, 2016 =
* Modified `this->get_interviewer` to check return isn't empty before proceeding.

= 0.1.10 September 28, 2016 =
* Updated Interviewer question editor height to work with new interface.
* [#52] Modified interviewer return to handle multiple values. Interviewer is now returned as an array.

```json
"interviewer": [
    {
        "id": 35615,
        "login_name": "remeike-forbes",
        "name": "Remeike Forbes",
        "first_name": "Remeike",
        "last_name": "Forbes",
        "description": "Remeike Forbes is <em>Jacobin</em>'s creative director.",
        "website": "",
        "link": "http://jacobin.dev/author/remeike-forbes/"
    }
]
```

= 0.1.9 September 18, 2016 =
* Unhid Location and Department taxonomy metaboxes, which will now allow multiple selections.
* [#46] Modified instructional text displayed in Content Sections metabox.

= 0.1.8.1 September 16, 2016 =
* Escaped user website in REST response

= 0.1.8 September 16, 2016 =
* [#36] Added translator user field to articles using
* [#37] Changed interviewee and interviewer fields. Interviewee will used the authors field (which using co-authors plus).
* Modified cover artist to use guest-author
Note: Interviewer, cover artist and translators use a custom field pulling from the custom post type guest-author. REST API is returning in form of authors.

```json
"translator": {
    "id": {int},
    "login_name": {string},
    "name": {string},
    "first_name": {string},
    "last_name": {string},
    "description": {string},
    "website": {url},
    "link": {url}
}
```

```json
"interviewer": {
    "id": {int},
    "login_name": {string},
    "name": {string},
    "first_name": {string},
    "last_name": {string},
    "description": {string},
    "website": {url},
    "link": {url}
}
```

```json
"cover_artist": {
    "id": {int},
    "login_name": {string},
    "name": {string},
    "first_name": {string},
    "last_name": {string},
    "description": {string},
    "website": {url},
    "link": {url}
}
```

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
