# Camelot

Camelot is a content management system (CMS) written using CakePHP 3.
It exists to showcase some of the techniques used to build modern websites in frameworks such as CakepHP.

The set of default articles in the CMS are used to document some of the features as they get added to Camelot.
The code includes more commenting than would usually be expected in such an application, with the hopt that it can be used as an educational tool to those new to web development.

## Requirements

The Camelot application uses CakePHP 3.6 framework, and it has the same [hardware and software requirements](https://book.cakephp.org/3.0/en/installation.html).

Reading and familiarising yourself with the [CakePHP installation instruction](https://book.cakephp.org/3.0/en/installation.html#requirements) is highly recommended.

As with most CMS applications, you need to have a database server to conenct to.
You can use any database server supported by CakePHP.
However, Camelot provides some convenience tools to [backup and restore](#data-backup-and-restore) the database, which require a MySQL database.
This is particularly applicable to [backing up articles](#database-backup-(articles)).


## Recommended Installation Procedure

After this application is obtained from the git repository, please follow these steps before performing any other works:

1. Run `composer install` (to install PHP libraries that Camelot depends on)
2. Perform a [Database Reset](#database-initialization-and-reset) (to create relevant tables in your database)
3. (Optional) Toggle [Demonstration mode](#demonstration-mode) (so that you can log in as an administrator)
4. Run [Built-in Server](#built-in-sever) if it is under development 


## Starting Camelot Using the Built-in Sever 

> **Note:** For development purpose only.
> For production, you would use a production web server such as Apache2 or Nginx.

To load the built-in web server, type this command from your terminal from the same directory as this git repository:

```
bin/cake server
```

Follow the prompt to access the site, typically by opening a browser and navigating to `http://localhost:8765/`.


## Demonstration Mode

> **WARNING**: This mode must be switched **OFF** for production, to prevent data breach.

Camelot has a "Demonstration Mode" which enables a few tools that may help while developing or testing the application.
Among them, it will:

 * Allow anyone visitor to login to the backend area as an admin, by pre-populating the login form with a username and password.
 * Add a footer to the bottom of each page to help understand what went into producing that page, including links to:
   * The `Controller` used to handle the request.
   * The `action` within that controller which processed the request.
   * The `view` template (`.ctp` file) which was used to produce the content specific to that page.
   * The `layout` (`.ctp` file) used to produce the outer content of all pages (e.g. headers, footers, etc).

To toggle demonstration mode, run this command from your terminal and follow the prompts:

```
bin/cake toggle_demo_mode
```


## Data Backup and Restore

Camelot has a built-in mechanism to backup and restore data via the shell (command prompt).


### Database initialization and reset

> **WARNING**: You will **lose all content** currently in Camelot (e.g. articles, products, categories, etc). Please use with care.

The reset feature regenerates the prescribed database for Camelot.

Possible use cases:

 * When Camelot is deployed to a new site.
 * After testing, to restore the database content to something more meaningful.

> **Requirements:** A database must exist, and its connection settings must be applied in the `Datasources` section of `config/app.php`.

Run this command:

```
bin/cake reset_database
```

To gain admin access, please follow the [Demonstration Mode](#demonstration-mode) documentation.


### Database backup-Articles Only

> **Requirement:** This backup requires the use of `mysqldump` application, which is usually installed when you install MySQL.
>
> **Limitation 1:** Currently Camelot has Article backup feature only. Full site backup is under development.
>
> **Limitation 2:** Some web servers do not provide the PATH reference to mysqldump. For WAMP servers, a PATH must be manually added. The new PATH should look like `C:\wamp64\bin\mysql\mysq(Version No.)\bin`

The backup command backs up Articles repository into SQL schema file, found in `config/schema/articles.sql`.
We intentionally separate the content (`articles.sql`) from the structure of the database (`database.sql`), to allow the site to be deployed without any test data if required.

To perform a backup, run this command:

```
bin/cake dump_articles
```


## New Features

New features should be forward to [Peter Serwylo](mailto:peter.serwylo@monash.edu).


## Licenses

Camelot makes use of many different open source libraries, listed below: 

* Public template - [Clean Blog](https://startbootstrap.com/template-overviews/clean-blog/) template licensed under the MIT license.
* Admin template - [Module Admin](https://modularcode.io/modular-admin-html) template licensed under the MIT license.
* Admin dashboard plotting library - [c3](http://c3js.org/) licensed under the MIT license.
* Misc libraries
  * [Chosen](https://github.com/harvesthq/chosen) used under the MIT license.
  * [TinyMCE Community Version](https://www.tinymce.com/) used under the LGPLv2 license.
  * [HTMLPurifier](http://htmlpurifier.org/) used under the LGPLv2 license.
* Images
  * Home screen image of Milky Way by [Alan Labisch](https://unsplash.com/photos/6eaUN_0dHQU?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText) on Unsplash
  * [Excalibur icon](https://www.flaticon.com/free-icon/excalibur_302083) - designed by Smashicons from Flaticon
