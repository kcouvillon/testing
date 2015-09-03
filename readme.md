# WorldStrides theme

## WordPress setup

Details of the production setup.

### Plugins

* [WP-Help](https://wordpress.org/plugins/wp-help/)
* [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/)
* [Safe Redirect Manager](https://wordpress.org/plugins/safe-redirect-manager/)

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
packages.

* Grunt
* Sass

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

### Assets

All of the front-end stuff is located in the assets folder.

* SASS - Susy, Bourbon?

### General

* partials
* templates
* classes
* helpers
* metaboxes - CMB2, add-ons (post search in particular)