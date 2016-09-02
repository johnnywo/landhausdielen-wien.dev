# Blog + RJ Gallery for OctoberCMS

## Introduction
This plugin associates a "RJ Gallery" to a Blog plugin post.

You will be able to work with the gallery from the **blogPost** component.



## Requirements
- [Blog](https://octobercms.com/plugin/rainlab-blog) (RainLab.Blog)
- [RJ Gallery](https://octobercms.com/plugin/raviraj-rjgallery) (Raviraj.Rjgallery)



## Installation
* Install dependencies:
  * `php artisan plugin:install RainLab.Blog`
  * `php artisan plugin:install Raviraj.Rjgallery`
* Install the plugin:
  * `php artisan plugin:install Martin.BlogGallery`



## Use
1. Create your gallery on RJ Gallery plugin
2. Create or edit a blog post
3. Goto "Manage" tab
4. Select a gallery



## Display gallery on post page
You can insert the **RJ Gallery** component inside your **blogPost** component html like this:
```
{% component 'gallery' gallery=post.rjgallery %}
```



## Access gallery object

* Get gallery info:
```
{{ post.rjgallery }}
```

* Get gallery images
```
{{ post.rjgallery.images }}
```
