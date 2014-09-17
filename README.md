3_126
=====
Image booru web server stuff

Dependencies
------------
* PHP 5
* MariaDB / MySQL
* ImageMagick

Installation
------------
* Edit `includes/settings.php`, changing anything you need to.
* Add users and the databases/tables, like so (replacing db_username/password with your own):  

```sql
CREATE DATABASE booru;

USE booru;

CREATE TABLE user_db (ID INT(32) NOT NULL AUTO_INCREMENT, USERNAME VARCHAR(64) DEFAULT "user-sqlfail", PASSWORD VARCHAR(1024) DEFAULT "pass-sqlfail", DATEADD INT(128) DEFAULT 0, MAXRATING INT(1) DEFAULT 1, LASTACTIVE INT(128) DEFAULT 0, TIMEZONE VARCHAR(256) DEFAULT "America/Chicago", PRIMARY KEY (ID));

CREATE TABLE image_db (ID INT(32) NOT NULL AUTO_INCREMENT, FILE VARCHAR(4) DEFAULT "jpg", DATEADD INT(128) DEFAULT 0, UPLOADER VARCHAR(64) DEFAULT "unknown", RATING INT(1) DEFAULT 1, VIEWS INT(32) DEFAULT 0, TAGS TEXT DEFAULT NULL, SOURCE VARCHAR(4096) DEFAULT NULL, FAVORITES TEXT DEFAULT NULL, PRIMARY KEY(ID));

CREATE USER 'db_username'@'localhost' IDENTIFIED BY 'db_password';

GRANT ALL ON booru.* TO 'db_username'@'localhost';
```

* Set up ImageMagick to work with PHP according to your OS/distro of choice. This is used to generate thumbnails.

Notes
-----
* HTTPS/SSL is recommended for the login and registration page for security reasons. Only the hash of the password (plus the salt) is stored in the user database via SHA512 encryption.

**Issues can be tracked here on GitHub, or on my [Gitlab repository](http://gitlab.theblackparrot.us/theblackparrot/3_126).**