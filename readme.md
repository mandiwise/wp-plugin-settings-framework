# WordPress Plugin Setting Framework

## Description

I was on the hunt for the perfect, out-of-the-box WordPress settings framework that I could use to easily incorporate a custom options page into plugin projects on the fly.

After no small amount of searching, I decided I should probably just roll up my sleeves and build my own.

## FAQs

### What is this thing exactly?

This is a framework for creating an options page in your WordPress plugin, NOT for building your actual plugin. The `plugin-sample.php` file provides a quick demo on how to include the settings framework (along with your specific settings) into your plugin.

### What field types are available for the settings?

Right now you can create the following fields using this framework:

* checkboxes
* select drop-downs
* radio buttons
* textareas
* password inputs
* basic text inputs

...and more to come!

## How do I create the fields for my options page?

Simply follow the lead of the example settings arrays around line 140 of `admin.php`. (More explanatory documentation coming shortly!)

## Changelog

### 1.1
* Refactor plugin settings class.
* Expand localization.
* Add sample plugin uninstall file.

### 1.0
* Framework initial release.

## Credit Roll

In piecing together this framework, I leaned heavily on the good work of [Francis Yaconiello](http://www.yaconiello.com/blog/how-to-handle-wordpress-settings/) and [Alliso the Geek](http://alisothegeek.com/2011/01/wordpress-settings-api-tutorial-1/).

## Author Information

This framework was originally created by [Mandi Wise](http://mandiwise.com/). There's certainly room for improvement so drop me a line.

## License

Copyright (c) 2013, Mandi Wise

The code in this repository is licensed under the GPL v2 or later.

> This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

> This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

> You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
