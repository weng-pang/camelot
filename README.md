# Camelot

This is a demonstration application to showcase some of the capabilities from CakePHP.


## Requirements

The Camelot application uses CakePHP 3.6 framework, and it has the same [hardware and software requirements](https://book.cakephp.org/3.0/en/installation.html).

Reading the [installation instruction](https://book.cakephp.org/3.0/en/installation.html#requirements) is highly recommended.

You can use any database server supported by CakePHP.
However, Camelot provides some convenience tools to [backup and restore](#data-backup-and-restore) the database, which require a MySQL database.
This is particularly applicable to [backing up articles](#database-backup-(articles)).


## Recommended Installation Procedure

After this application is obtained from the git repository, please follow these steps before performing any other works:

1. Run `composer install`
2. Perform [Database Reset](#database-initialization-and-reset)
3. Toggle [Demonstration mode](#demonstration-mode)
4. Run [Built-in Server](#built-in-sever) if it is under development 


## Built-in Sever 

Note: For development purpose only

To load the built-in web server, type this command from your terminal from the same directory as this git repository:

```
bin/cake server
```

Follow the prompt to access the site, typically by opening a browser and navigating to `http://localhost:8765/`.


## Demonstration Mode

**WARNING**:This mode must be switched **OFF** for production, to prevent data breach.

Camelot has a "Demonstration Mode" to allow anyone visitor to login to the backend area as an admin.

Possible use case: To let the site owner gaining access back after losing the password.

To toggle demonstration mode, run this command from your terminal:

```
bin/cake toggle_demo_mode
```

Then follow the prompts.


## Data Backup and Restore

Camelot has a built-in mechanism to backup and restore data via the shell (command prompt).


### Database initialization and reset

**WARNING**: Any current entries (everything) to Camelot will be overwritten completely. Please use with care.

The reset feature regenerates the prescribed database for Camelot.

Possible use cases:

 * When Camelot is deployed to a new site.
 * After testing, to restore the database content to something more meaningful.

Requirement: A database exists, and its connection settings are applied in `config/App.php`

Run this command:

```
bin/cake reset_database
```

To gain admin access, please follow the [Demonstration Mode](#demonstration-mode) documentation.


### Database backup-Articles Only

Requirement: This backup requires the use of mysqldump application. See Note 2 for details

The backup command backs up Articles repository into SQL schema file.

The backup SQL schema file can be found in ``config/schema/``

To perform backup, run this command:

```
bin/cake dump_articles
```

Note: 

1. Currently Camelot has Article backup feature only. Full site backup is under development.
2. Some web servers do not provide the PATH reference to mysqldump. For WAMP servers, a PATH must be manually added. The new PATH should look like `C:\wamp64\bin\mysql\mysq(Version No.)\bin`


## New Features

New features should be forward to [Peter Serwylo](mailto:peter.serwylo@monash.edu).


## Licenses

* Public template - [Clean Blog](https://startbootstrap.com/template-overviews/clean-blog/) template licensed under the MIT license.
* Admin template - [Module Admin](https://modularcode.io/modular-admin-html) template licensed under the MIT license.
* Admin dashboard plotting library - [c3](http://c3js.org/) licensed under the MIT license.
* Misc libraries
** [Chosen](https://github.com/harvesthq/chosen) used under the MIT license.
** [TinyMCE Community Version](https://www.tinymce.com/) used under the LGPLv2 license.
** [HTMLPurifier](http://htmlpurifier.org/) used under the LGPLv2 license.
* Images
** Home screen image of Milky Way by [Alan Labisch](https://unsplash.com/photos/6eaUN_0dHQU?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText) on Unsplash
** [Excalibur icon](https://www.flaticon.com/free-icon/excalibur_302083) - designed by Smashicons from Flaticon
