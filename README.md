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

### Setup

This instruction sets up a local instance of schach.in which can be accessed via `http://schach.in.local/`. We expect the schach.in source code to be located in `/var/www/schach.in`. If you want to change the location, you can simply create a symlink, e.g., via `ln -s /your/path /var/www/schach.in`. Only make sure it is accessible to the Apache web user, which is typically `www-data`.

1.  Create a MySQL database and user

1.  Clone repository and submodules

    ```sh
    git clone --recursive git@github.com:schach-in/schach.in.git /var/www/schach.in
    ```

1.  Create `pwd.json` with database credentials

    Create the file `/var/www/schach.in/pwd.json` with the following content:

    ```
    {
        "db_host": "localhost",
        "db_name": "...",
        "db_user": "...",
        "db_pwd": "..."
    }
    ```

1.  Create new Apache site

    Create the file `/etc/apache2/sites-available/schach.in.local.conf` with the following content:

    ```
    <VirtualHost 127.0.0.1:80>
        ServerName schach.in.local
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/schach.in/www

        ErrorLog ${APACHE_LOG_DIR}/schach.in.local_error.log
        CustomLog ${APACHE_LOG_DIR}/schach.in.local_access.log combined

        <Directory /var/www/schach.in/>
            AllowOverride All
        </Directory>
    </VirtualHost>
    ```

1.  Optionally create SSL certificate

    For instance using [mkcert](https://github.com/FiloSottile/mkcert). In this case, the port `80` in `/etc/apache2/sites-available/schach.in.local.conf` has to be changed to `443`.

1.  Enable new Apache site

    ```sh
    a2ensite schach.in.local.conf
    ```

## Support

* Gustaf Mossakowski <gustaf@koenige.org>
