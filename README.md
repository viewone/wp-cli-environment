#WP-CLI-Environment


![image](http://img.shields.io/travis/viewone/wp-cli-environment.svg)

WP-CLI-Environment is wp-cli package which add support to have multiple environments `wp-cli.yml` files.

WP-CLI allow you to have two wp-cli.yml files. One global `wp-cli.yml` and one for local development `wp-cli.local.yml`. This package give you possibility to have additional files and firendly cli tool for using them.

##Installation

To install package please make sure you have setup package index with composer:  
https://github.com/wp-cli/wp-cli/wiki/Community-Packages#setting-up-the-package-index

When you are done you can install package:
```
cd ~/.wp-cli
php composer.phar require viewone/wp-cli-environment=dev-master
```

##Getting Started
Create directory `config` and put inside file `wp-cli.production.yml`. Content of `wp-cli.production.yml` is standard `wp-cli.yml` file and it can looks like.

```
path: ../
url: http://example.org/
core config:
  dbname: your_production_dbname
  dbuser: your_production_dbuser
  dbpass: your_production_dbpassword
  skip-check: true
disabled_commands:
  - db drop
  - plugin install
```

Exec command:

```
wp production core download
```

WP-CLI will download WordPress using settings in `wp-cli.production.yml` file. Not so impressive. WP-CLI-Environment is design to work with multiple `wp-cli.yml` files so now create `wp-cli.developemnt.yml` file in `config` directory with content.

```
path: ../
url: http://example.dev.org/
core config:
  dbname: your_dev_dbname
  dbuser: your_dev_dbuser
  dbpass: your_dev_dbpassword
  skip-check: true
```

Exec command:

```
wp production core config
```
As you see wp-cli created wp-config.php with settings from `wp-cli.production.yml`. Delete wp-config.php and exec command:

```
wp development core config
```
Now hovewever wp-cli created wp-config.php with settings from `wp-cli.development.yml`

##Usage

WP-CLI-Environment support 5 environments: `local`, `development`, `testing`, `staging`, `production`. For each environment you can create `wp-cli.environment.yml` file e.g.: `wp-cli.testing.yml` or `wp-cli.staging.yml`. All environments files must be in config directory.

When you want to refer to particular file when executing wp-cli command simply type environment as first argument e.g: `wp testing core download` or `wp staging core config`.

If there is no `wp-cli.environemnt.yml` file. You will se an error about this.

##The order of precedence

WP-CLI-Environment use `WP_CLI_CONFIG_PATH` environment variable to require specific config file. It means that wp-cli-environemnt has very low priority. If you will have wp-cli.yml or wp-cli.local.yml files in your wordpress root directory, settings from this files will overwrite settings from wp-cli.environment.yml.
