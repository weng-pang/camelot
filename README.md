# Camelot

## Built-in Sever (For development purpose only)
To load the built-in web server, type this command:
````
bin/cake server
````
Follow the prompt to access the site.

## Demonstration Mode
The Demonstration Mode allows anyone to login to the backend area as an admin.<br />
Possible use case: To let the site owner gaining access back after losing the password.<br />
This mode must be switched off for production, to prevent data breach.

To toggle demonstration mode, type in this command:
````
bin/cake toggle_demonstration_mode
````
Then follow the prompts.

## Date Backup & Restore
Camelot has a built-in mechanism to backup and restore data via the command prompt.
### Database reset
The reset feature regenerates the prescribed database for Camelot.<br />
Possible use case: Camelot is deployed to a new site.<br />
Requirement: A new database is created and connection settings are applied in ``config/App.php``

Run this command:
````
bin/cake reset_database
````

To gain admin access, please follow the [Demonstration Mode](#demonstration-mode).

## New Features
New features should be forward to Peter S.

### Licenses

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