# What is CMS-library? #

The imaginatively named CMS-library (cmslib for short) is a framework of PHP code that handles much of the [CMS](http://en.wikipedia.org/wiki/Web_content_management_system) [boilerplate](http://en.wikipedia.org/wiki/Boilerplate_code#Boilerplate_code) and makes it easier for programmers to create a Content Management System tailored to their purposes (or those of their employer). It allows them to put focus on the design of the website, rather than the mechanics of content management. Even so, CMS-library should give programmers much flexibility and power.

Planned features:

  * Total integration with your website; CMS-library does not dictate any layout or style
  * Time-specific content (think Christmas decoration)
    * Time-machine (fast-forward) for website administrators
  * User-specific content (think shopping carts)
  * Customizable status messages, informative error messages
  * Arbitrary nesting depth of website infrastructure

On the technical side:

  * [PHP 5](http://www.php.net/), [MySQL](http://www.mysql.com/)
  * PHP classes directly mapped to database tables, including [inheritance](http://en.wikipedia.org/wiki/Inheritance_(computer_science))
    * To create new types of entities, the programmer has but to create and register the class, and the database will automatically adapt
    * No CMS overhead in the database; every table is relevant to the data
  * [.htaccess](http://httpd.apache.org/docs/1.3/howto/htaccess.html) file to prettify URLs

# What is the status of CMS-library? #

At this moment the library is still in its very early stages. In short, it can display information from the database, but not edit it yet. There's just tons still to do.

Honestly, the whole project is on a back burner, while I work on [Mist](http://code.google.com/p/mist). But once in a while I will do some work on it. I must get a website eventually, and I would like to use CMS-library to create it.