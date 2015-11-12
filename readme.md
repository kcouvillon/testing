# WorldStrides theme

## WordPress setup

Details of the production setup.

### Plugins

* [WP-Help](https://wordpress.org/plugins/wp-help/) - used for documentation within the WordPress Dashboar
* [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/) - defacto standard for implementing SEO features in the
WordPress world.
* [Safe Redirect Manager](https://wordpress.org/plugins/safe-redirect-manager/) - provides a graphical interface for
adding redirects. Not as useful for old redirects, but should be useful moving forward.
* [Advanced Responsive Video Embedder](https://wordpress.org/plugins/advanced-responsive-video-embedder/) - a dropin at 
the initial launch period to get embedded videos working responsively with the theme.
* [Category Order and Taxonomy Terms Order](https://wordpress.org/plugins/taxonomy-terms-order/) - believe this was for
getting terms in the correct order for the explore tools filter area.
* [Co-Authors Plus](https://wordpress.org/plugins/co-authors-plus/) - adds the ability to have authors that don't
necessarily have an actual WordPress login
* [Duplicate Post](https://wordpress.org/plugins/duplicate-post/) - ability to duplicate a post
* [EditFlow](https://wordpress.org/plugins/edit-flow/) - introduces an editorial workflow to the site. Possible that 
this is no longer being used and could be removed.
* [EWWW Image Optimizer](https://wordpress.org/plugins/ewww-image-optimizer/) - used to squish images down, necessary 
given the imagery on the site. This was introduced because we didn't have a ton of access to the server at initial 
launch. This could potentially be replaced by server side configuration.
* [Manual Image Crop](https://wordpress.org/plugins/manual-image-crop/) - adds ability to provide a custom crop for a 
specific image size.
* [Responsive Select Menu](https://wordpress.org/plugins/responsive-select-menu/) - a front-end dropin to deal with 
constructing a menu for mobile. Functionality could probably be replicated within theme asset files.
* [WP DB Backup](https://wordpress.org/plugins/wp-db-backup/) - creates a nightly backup of the database. This should
be replaced with some sort of actual backup policy.
* [WP Retina 2x](https://wordpress.org/plugins/wp-retina-2x/) - Generates @2x sizes of images to provide imagery for 
retina screens. Native support is being introduced for this in WordPress 4.4, so it should probably be on the roadmap
to convert over down the road.

## Development

Recommendations for local development and the process in general.

### Recommended plugins for local development

* [Developer](https://wordpress.org/plugins/developer/)
* [Debug Bar](https://wordpress.org/plugins/debug-bar/)
* [Debug Bar Extender](https://wordpress.org/plugins/debug-bar-extender/)
* [WordPress Query Monitor](https://wordpress.org/plugins/query-monitor/)

### Version Control

We're using git for version control, with the repo hosted privately on Objective Subject's Github account.
The repository can be transfered over to the WorldStrides Github account at any point. 

In the development phases, we've largely just been working off the master branch, as we've generally been
working in places that don't conflict with each other. Once the site hits production, it would be a good 
idea to introduce a workflow model. [GitFlow](http://nvie.com/posts/a-successful-git-branching-model/) is a
popular one, which is supported by a number of git GUIs. It essentially involves having a master branch, 
a development branch, and various feature branches that get merged into development and eventually master.

Using git at the command-line level is a great way to familiarize yourself with how it works. GUIs can also 
be a great-help when you're trying to visualize branches, diffs and looking at blame. Atlassian makes a free
tool called [SourceTree](https://www.sourcetreeapp.com/), and there's a nice Mac only one called 
[Tower](http://www.git-tower.com/).

### Local Environment

Use a containerized environment for development. [VVV](https://github.com/Varying-Vagrant-Vagrants/VVV) 
and [Chassis](http://chassis.io/) are both solid vagrant options. VVV allows for easy use of xdebug. 
At some point, you could create a vagrant box that more closely mimics the production environment.

There are lot of options when it comes to development. We'd highly recommend using
[PhpStorm](https://www.jetbrains.com/phpstorm/) for the backend side of things. It has support for WordPress, allowing you to jump to functions
easily, autofill functions, etc. It also allows for refactoring to WordPress coding standards with a keystroke.

### Deployment

There are a lot of of deployment options out there. We currently only have the theme under version control, which we
deploy directly to Rackspace via Deploybot. 

Deploybot offers quite a bit of free functionality for one repo. For example,
it can deploy one branch to a development server and another to production. It's currently publishing the theme via 
ObjectiveSubject's version of the repo, which would need to change if the repo gets transferred. Also, the deploy
needs to get updated if the main server's IP address changes.

You can also prevent files from being deployed. So, things like SASS files, gruntfile and readme.md would never be
publicly accessible.

### Build tools

The primary build tool that we're using is [Grunt](gruntjs.com/), it will generate CSS from SASS files, concatenate and minify the results, as well as checking for
proper javascript syntax usage. The initial Grunt setup can seem daunting, but it mostly boils down to using NPM to install a bunch of
packages. Configure the various options in gruntfile.js

### WP-CLI

[WP-CLI](http://wp-cli.org) is an incredibly powerful command-line WordPress tool. It's installed by default in VVV.

### Local WordPress Development

Develop locally with [WP_DEBUG](http://codex.wordpress.org/WP_DEBUG) turned on. This should allow any PHP errors to surface.
There are some additional flags that can be set in wp-config, do things like outut errors to a log file, and use
unconcatenated versions of scripts to make it easier to debug.


#### WordPress Coding standards

https://codex.wordpress.org/WordPress_Coding_Standards
https://make.wordpress.org/core/handbook/coding-standards/php/
https://make.wordpress.org/core/handbook/coding-standards/html/
https://make.wordpress.org/core/handbook/coding-standards/css/
https://make.wordpress.org/core/handbook/coding-standards/javascript/

https://vip.wordpress.com/documentation/code-review-what-we-look-for/

## Theme structure

### General

* Partials - are fragments of pages, intended for reuse in multiple places
* Templates - specific page templates that can be applied via the template selector dropdown
* Includes - classes and libraries separated 

### Assets

All of the front-end stuff is located in the assets folder.

#### CSS/SASS

SCSS partials are compiled into a minified css file. At some point, it's probably worth auditing this for
duplication or unused css, to reduce the size of the generated files

The grid system used is [Susy](http://susy.oddbird.net/).

#### JavaScript

Currently, all scripts in the vendor and src folders are compiled into one minified JavaScript file. At some point
this could be re-engineered to only concatenate some of the files, and enqueue others solely as needed.

### CMB2

[CMB2](https://github.com/WebDevStudios/CMB2) is a system for adding metaboxes and custom fields to the WordPress backend. 
It's similar to ACF, but doesn't provide a graphical interface. It's quite extensible, and provides quite a number of
field options out of the box. It's also relatively easy to create your own fields, or drop in extensions.

It's worth checking periodically to see if there's an update to CMB2 and applying the new files.

There's probably a fair bit of optimization that could be done here, as some fields are essentially implemented 
multiple times but in different places, mostly because fields kept getting tacked into other areas where it wasn't 
originally intended, so the naming of things didn't make sense. It works, but some reworking may be needed for 
general maintenance purposes.

A few notes:
* Adding fields to taxonomies is sort of convoluted, there are some [extra classes](https://github.com/jtsternberg/Taxonomy_MetaData) 
to help achieve that. There is no native term meta, so it makes use of the options table (which gets loaded on every page). 
Term meta is on the WordPress roadmap for version 4.4/4.5, and would be worth changing over when the implementation gets settled.
* Adding fields to the "home" page (front-page.php) required a custom function that can be found in functions.php

#### Addons
These are additional fields beyond the CMB2 standards. Similarly, it's worth checking to see if there are updates to these.

* [Attached Posts](https://github.com/WebDevStudios/cmb2-attached-posts) - Allows you to attach other posts in a graphical
list. We use it for attaching blocks, resources, etc.
* [Post Search](https://github.com/WebDevStudios/CMB2-Post-Search-field) - Allows you to search for a specific post or post
to attach. There was a bug in the first release that prevented custom post types from being searched, so we modified it to
allow a range (`cmb2-post-search-field.php` line 301). It seems there's a recent update to the field that fixes this bug. It's
worth updating, but will require testing, because each usage might require explicitly saying which post types to allow. This
was one of the reasons we ended up being able to attach things in places they were never intended to be.
* [Maps](https://github.com/mustardBees/cmb_field_map) - Attach location data

### Misc

* Helper functions - there's a class that provides a number of utility helper functions. This can be quite useful
when a partial doesn't suit the implementation.

### Custom Post Types and Taxonomies

All post types are declared in `class-cpts.php` and taxonomies in `class-taxos.php`.

We made use of John Blackbourn's [Extended CPTs](https://github.com/johnbillion/extended-cpts) and 
[Extended Taxos](https://github.com/johnbillion/extended-taxos) libraries (John is a former release lead for WordPress). 
The libraries make for much simpler implementation of cpts and taxos, as well as adding in additional features. It also 
makes it fairly easy to create custom admin column layouts for the various cpts. Worth checking for updates here
occasionally.

Most of the post types and taxonomies are fairly straight-forward, with two exceptions:

* Filters - this taxonomy serves the explore tool, and allows for faster lookup than using post meta. Traditional term
archive pages shouldn't exist for these terms. The destination, interest and traveler post types serve as the filter
endpoint. On each of these endpoint pages, the associated filter must be explicitly specified. This also allowed for filter 
points to exist that don't necessarily have an endpoint.
* \_Collections - this is a 'shadow taxonomy', which serves a similar purpose to filters, in helping to create efficient 
queries for collections of itineraries. Where the shadow part comes in, is when a collection post is created, a term 
with the same name is created in this taxonomy (so it doesn't have to be explicitly specified). This logic can be 
found in `class-collections.php`. The one caveat is if a collection is renamed, and the slug changes. In this instance,
the \_collection slug may need to be manually renamed (see Collection notes in WP-Help).