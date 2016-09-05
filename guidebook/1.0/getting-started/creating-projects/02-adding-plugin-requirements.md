---
layout: guidebook
title: Adding Plugin Requirements
permalink: /guidebook/1.0/getting-started/creating-projects/adding-plugin-requirements/
covered_tags: plugins
menu_group: creating-projects
---

If you are familiar with Composer you may already know that [Packagist.org](https://packagist.org/) is the official supplier of PHP packages. While many common PHP libraries will be available through this repository, it does not have the mandate of being a supplier of Wordpress plugins.

There is a open source service that allows free and open Wordpress plugins to be loaded as Composer dependencies called [WPackagist.org](https://wpackagist.org/). It mirrors the list of plugins found on Wordpress.org while ensuring the each codebases contain a valid `composer.json` file.


### Configuring for Wordpress Plugins

Plugins cannot be installed in the `vendor` directory because Wordpress will not be able to load them naturally. Therefore, there needs to be a way of specifying the package's type to trigger a different Composer installer. You do so by

Wordpress plugins are expected to define their type as `wordpress-plugin` within their `composer.json` file.

{% include terminal_start.html %}
{% highlight json linenos %}
{
    "name": "my_company/advanced-custom-fields-pro-manual-fork",
    "description": "A manual fork of ACF pro, ready to use within Composer",
    "type": "wordpress-plugin",
    "require": {}
}
{% endhighlight %}
{% include terminal_end.html %}

## Querying the correct repository

Because the plugins are stored in a second repository, Composer will not look for Wordpress plugins automatically. You need to supply the additional repository in your project's `composer.json`.

Confirm WPackagist is defined as an available repository by finding the following entry in Composer's configuration file:

{% include terminal_start.html %}
{% highlight json linenos %}
{
    "repositories": [{
        "type": "composer",
        "url": "https://wpackagist.org"
    }]
}
{% endhighlight %}
{% include terminal_end.html %}

## Adding plugins

After searching for the plugin's unique key on [WPackagist.org](https://wpackagist.org/) or using Composers search tools you may add the dependency to your project.

{% include terminal_start.html %}
{% highlight bash %}
$ composer require wpackagist-plugin/intuitive-custom-post-order
{% endhighlight %}
{% include terminal_end.html %}

The previous command will add a new entry in the `require` block of your project's configuration file.

{% include terminal_start.html %}
{% highlight json linenos %}
{
   "require": {
        "php": ">=5.4",
        "johnpbloch/wordpress": "4.4.2",
        "francoisfaubert/strata": "dev-master",
        "wpackagist-plugin/intuitive-custom-post-order": "^3.0.6",
        "wpackagist-plugin/akismet": "^3.1.1",
        "wpackagist-plugin/disable-comments": "^1.3.1",
        "wpackagist-plugin/simple-page-ordering": "^2.2.4",
        "wpackagist-plugin/share-this": "7.1"
    }
}
{% endhighlight %}
{% include terminal_end.html %}

Once the requirements are updated to reflect the application's needs they will be kept up to date each time you build the application. This means you should not update plugins through the Wordpress admin.

{% include terminal_start.html %}
{% highlight bash %}
$ composer update
{% endhighlight %}
{% include terminal_end.html %}