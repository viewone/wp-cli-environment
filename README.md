#WP-CLI-Environment


![image](http://img.shields.io/travis/viewone/wp-cli-environment.svg)

WP-CLI-Environment is wp-cli package which add support to have multiple environments `wp-cli.yml` files.

WP-CLI allow you to have two wp-cli.yml files. One global `wp-cli.yml` and one for local development `wp-cli.local.yml`. This package give you possibility to have additional files and firendly cli tool for using them.

##Getting started
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

