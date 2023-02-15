# Website schach.in

[schach.in](https://schach.in/) is a website that displays chess clubs, clubs with chess sections,
schools with chess societies and kindergartens with chess training on a map of
Germany.

## Installation

### System Requirements

* PHP: 7.2, 8.0, or newer
  * Enable required Apache modules: `sudo a2enmod headers`
* MySQL: 5.7, 8.0, or newer

### Dependencies

The following dependencies are defined in the form of Git submodules. They are installed automatically by calling `git clone --recursive git@github.com:schach-in/schach.in.git`:

* CMS: Zugzwang Project, <https://www.zugzwang.org>
  * zzwrap (Core CMS Library), <https://github.com/koenige/zzwrap>
  * zzbrick (Templating System), <https://github.com/koenige/zzbrick>
* CMS Modules
  * default module, <https://github.com/koenige/modules-default>
  * clubs module, <https://github.com/schach-in/modules-clubs>
  * ratings module, <https://github.com/schach-in/modules-ratings>
  * contacts module, <https://github.com/koenige/modules-contacts>
  * feedback module, <https://github.com/koenige/modules-feedback>
  * zzform module, <https://github.com/koenige/zzform>
* CMS Themes
  * schachin Theme, <https://github.com/schach-in/themes-schachin>
* Markdown
  * PHP Markdown, <https://github.com/michelf/php-markdown>
  * Pagedown Markdown editor and converter, <https://github.com/StackExchange/pagedown>
* Leaflet (JavaScript Map Library)
  * Leaflet <https://github.com/Leaflet/Leaflet>
  * Leaflet.markercluster <https://github.com/Leaflet/Leaflet.markercluster>
  * Leaflet.Control.FullScreen <https://github.com/brunob/leaflet.fullscreen>
* vxJS JavaScript Library, <https://github.com/Vectrex/vxJS>

## Support

* Gustaf Mossakowski <gustaf@koenige.org>
