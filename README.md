# Camelot
This is a demonstration application to unveil some of the capabilities from CakePHP.

### Hardware Requirement
The Camelot application uses CakePHP framework, and it has the same [hardware requirement](https://book.cakephp.org/3.0/en/installation.html).

Reading the [installation instruction](https://book.cakephp.org/3.0/en/installation.html#requirements) is highly recommended.

To use [Backup and Recovery](#data-backup-and-restore), the MySQL database engine is recommended. This is particularly applicable to [Database Backup](#database-backup-(articles)).
## Recommended Installation Procedures
After this application is obtained from the git repository, please follow these steps before performing any other works:

1. Run `composer install`
2. Perform [Database Reset](#database-reset)
3. Toggle [Demonstration mode](#demonstration-mode)
4. Run [Built-in Server](#built-in-sever) if it is under development 

## Built-in Sever 
Note: For development purpose only

To load the built-in web server, type this command:
````
bin/cake server
````
Follow the prompt to access the site.

## Demonstration Mode
The Demonstration Mode allows anyone to login to the backend area as an admin.

Possible use case: To let the site owner gaining access back after losing the password.

**WARNING**:This mode must be switched **OFF** for production, to prevent data breach.

To toggle demonstration mode, type in this command:
```
bin/cake toggle_demonstration_mode
```
Then follow the prompts.

## Data Backup and Restore
Camelot has a built-in mechanism to backup and restore data via the shell (command prompt).
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


### Database reset
The reset feature regenerates the prescribed database for Camelot.

Possible use case: Camelot is deployed to a new site.

Requirement: A new database is created and connection settings are applied in `config/App.php`

**WARNING**: Any current entries (Everything) to Camelot will be overwritten completely. Please use with care.

Run this command:
```
bin/cake reset_database
```

To gain admin access, please follow the [Demonstration Mode](#demonstration-mode).

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