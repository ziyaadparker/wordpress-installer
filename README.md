# WordPress Installer

An automation tool, built for MAMP, WAMP and XAMP.

#### What's the difference?

What was normally a mundane task which consisted of the following:

  - Downloading WordPress
  - Creating a database
  - Linking WordPress to the Database
  - Only then, running the actual installation

You now do this from once screen, and you're redirected to the actual installation. From one page, you can:

  - Either download the latest or nightly build of WordPress
  - Connect to or create a new database
  - And, you're redirected to the installation... simple!

# Getting Started

PHP verion 5.4 or greater is required, other than that it's pretty simple.

#### Installation

  - Download WordPress Installer
  - Put the folder within your root directory of your local server:
    - ```mamp\htdocs\```
    - ```wamp\www\```
    - ```xamp\htdocs\```
  - Simply browse to the folder, something like:
    - ```http://localhost/wordpress-installer```
    - ```http://localhost:8080/wordpress-installer```
    - ```http://localhost:8888/wordpress-installer```

# Usage

You should be fine just filling out the form, however just in case you need an indepth explanation, here it is:

  - **Installation type:**
  
  *You can either choose latest build which is the latest stable version, or the nightly build which is the latest beta build. This goes without saying, you need to be connected to the internet.*

  - **Create folder:**
  
  *This folder will be created within your local server's root directory. So you can browse to it, the same way you browse to WordPress Installer, except with the folder name replacing "wordpress-installer".*

  - **Create database:**
  
  *This database will be created within phpMyAdmin with your local server set credentials.*

  - **Database server:**

  *More often than not, this can stay "localhost".*

  - **Database user:**
  
  *As said above, this will be your local server set user name, in most cases it's something like "root".*

  - **Database password:**
  
  *The same applies here, in most cases it's something like "root" or "" (blank).*

  - **Table prefix:**
  
  *This will prefix each table in the database, by default WordPress' table prefix is "wp_".*

# Development

Want to contribute? Awesome! You can fork the repo and simply submit pull requests, I will then credit you within the version as well as your work within the changelog.

#### Got an idea, or a fix?

You can contact me with any ideas or suggestions you have here. Also, like any other repo, you can report issues as you get them. Be nice!

# Licensing

This is a personal project, which is licensed under the [GNU v2] license. Feel free to use it however you like, and you don't need to credit me if you don't want to! But you can say thanks by buying me [Nespresso Capsules] :)

[GNU v2]:http://www.gnu.org/licenses/gpl-2.0.html
[Nespresso Capsules]:http://yusrimathews.co.za/donate/?project=wordpress-installer
