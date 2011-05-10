# Langify

Langify is a module for kohanaphp v3.

It allows you to import kohana i18n files into a db, have your visitors translating it, and then export it back as i18n files.

##Requirements
* Kohana 3.1.x
* AUTH (Can easily be excluded and changed to a custom auth system if needed)
* ORM
* KOstache (http://github.com/zombor/KOstache)
* Assets (http://github.com/hinton/assets)

* Add the module to your bootstrap.php file
##Install
* Place the module into your module folder
* Import the database.sql file into your database.
##Get Started


* Make sure you got AUTH Module enabled, and a user with the role translate.
* Import a i18n file using the admin panel (translate/admin)
* Edit the language.
* Export your finnished translated strings into useable i18n files.