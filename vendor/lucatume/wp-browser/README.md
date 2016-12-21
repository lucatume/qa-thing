wp-browser
==========

A WordPress specific set of extensions for Codeception.

The package includes a class extending Codeception PhpBrowser module that adds WordPress related assertions for `cest` and `cept` tests, an extension of Codeception own Db module meant to allow for more comfortable WordPress specific database handling and testing and a class taking care of installing and loading a WordPress installation relying on [WordPress automated testing suite](http://make.wordpress.org/core/handbook/automated-testing/).
While working on the module I've added some methods to the `Codeception\Module\Db` class to implement CRUDness into it; see below the `ExtendedDb` class.

![Travis CI master branch build status](https://travis-ci.org/lucatume/wp-browser.svg?branch=master)

[Example usage](https://github.com/lucatume/idlikethis).

## Installation
To install simply require the package in the `composer.json` file like

```json
  "require-dev":
    {
      "lucatume/wp-browser": "~1.18"
    }
```
    
and then use `composer update` to fetch the package.  
After that  follow the configuration instructions below.

## Modules
While the package name is the same as the first module added to it ("WPBrowser") the package will add more than one module to [Codeception](http://codeception.com/ "Codeception - BDD-style PHP testing.") to ease WordPress testing.  
Not every module will make sense or work in any suite or type of test case but here's an high level view:

* WPBrowser - a PHP based, JavaScript-less and headless browser for **acceptance testing not requiring JavaScript support**
* WPWebDriver - a Guzzle based, JavaScript capable web driver; to be used in conjunction with [a Selenium server](http://www.seleniumhq.org/download/), [PhantomJS](http://phantomjs.org/) or any real web browser for **acceptance testing requiring JavaScript support**
* WPDb - an extension of the default codeception [Db module](http://codeception.com/docs/modules/Db) that will interact with a WordPress database to be used in **functional** and acceptance testing
* WPLoader - loads and configures a blank WordPress installation to use as a base to set up fixtures and access WordPress defined functions and classes in **integration** tests; a wrapping of the WordPress [PhpUnit](https://phpunit.de/ "PHPUnit – The PHP Testing Framework") based [test suite provided in the WordPress repository](https://make.wordpress.org/core/handbook/testing/automated-testing/phpunit/).
* WPBootstrapper - bootstraps an existing WordPress installation in the same variable scope of the calling function to have access to its methods.
* WPQueries - allows for assertments to be made on WordPress database access in **integration** tests.
* WordPress - to be used in **functional** tests it will load WordPress code in the same variable scope as the tests but will make GET, POST, PUT and DELETE requests to the WordPress installation index without requiring a web server.
* WPCLI - allows accessing the [wp-cli](http://wp-cli.org/) tool in *acceptance* and *functional* testst.

### WPBrowser configuration
WPBrowser extends `PHPBrowser` module hence any parameter required and available to that module is required and available in `WPBrowser` as well.  
In the suite `.yml` configuration file add the module among the loaded ones

```yml
  modules:
      enabled:
          - WPBrowser
      config:
          WPBrowser:
              url: 'http://example.local'
              adminUsername: 'root'
              adminPassword: 'root'
              adminPath: '/wp-core/wp-admin'
```

and configure `PHPBrowser` parameters and the additional ones available to the `WPBrowser` module:  

* `adminUsername` - the site administrator username (required)
* `adminPassword` - the site administrator login name (required)
* `adminPath` - the path, relative to the WordPress installation folder, to the admin area

### WPWebDriver configuration
WPWebDriver extends `WebDriver` module hence any parameter required and available to that module is required and available in `WPWebDriver` as well.
In the suite `.yml` configuration file add the module among the loaded ones

```yml
  modules:
      enabled:
          - WPWebDriver
      config:
          WPWebDriver:
              url: 'http://example.local'
              browser: phantomjs
              port: 4444
              window_size: '1024x768'
              adminUsername: 'root'
              adminPassword: 'root'
              adminPath: '/wp-core/wp-admin'
```

and configure `WPWebDriver` parameters and the additional ones available to the `WPWebDriver` module:

* `adminUsername` - the site administrator username (required)
* `adminPassword` - the site administrator login name (required)
* `adminPath` - the path, relative to the WordPress installation folder, to the admin area

### WPDb configuration
The module extends the `Db` module hence any parameter required and available by the `Db module` is required and available in the `WPDb` module as well.  
In the suite `.yml` configuration file add the module among the loaded ones

```yml
  modules:
      enabled:
          - WPDb
      config:
          WPDb:
              dsn: 'mysql:host=localhost;dbname=testdb'
              user: 'root'
              password: ''
              dump: 'tests/_data/dump.sql'
              populate: true
              cleanup: true
              reconnect: true
              url: 'http://example.local'
              urlReplacement: true
              tablePrefix: 'wp_'
```

and configure `Db` parameters and the additional ones available to the `WPDb` module:  
    
* `url` - the site home url (required)
* `urlReplacement` - the module will try to replace the WordPress URL hard-coded in the dump file with the one specified by the `url` parameter by default; set this to `false` to prevent this behaviour
* `tablePrefix` - allows specifying the table prefix used in the installation, defaults to `wp_` (optional)

#### Dump file domain replacement
The SQL dump file will be loaded by the module during initialization **before** each test following the same limitations about size imposed by [Codeception Db module](http://codeception.com/docs/09-Data#db).  
The problem with WordPress database dumps is that the website URL address is harcoded in the database itself making dump sharing a serch and replace pain.  
The module will try to replace the domain written in the loaded SQL dump file on the fly to match the one specified in the `url` config parameter to allow dumps to work locally with no issues.

### WPLoader configuration
The module wraps the configuration, installation and loading of a working headless WordPress site for testing purposes.
An adaptation of [WordPress automated testing suite](http://make.wordpress.org/core/handbook/automated-testing/) the module exposes the suite hard-coded value as configuration parameters.  
Since this module takes charge of setting up and cleaning the database used for the tests point it to a database that does not contain sensible data!  
Also note that this module cannot be used together with WPDb or DB modules with the `cleanup` settings set to `true`.  
In the suite `.yml` configuration file add the module among the loaded ones

```yml
  modules:
      enabled:
          - WPLoader
      config:
          WPLoader:
              multisite: false
              wpRootFolder: "/Users/User/www/wordpress"
              dbName: "wpress-tests"
              dbHost: "localhost"
              dbUser: "root"
              dbPassword: "root"
              isolatedInstall: true
              wpDebug: true
              dbCharset: "utf8"
              dbCollate: ""
              tablePrefix: "wptests_"
              domain: "example.org"
              adminEmail: "admin@example.com"
              title: "Test Blog"
              phpBinary: "php"
              language: ""
              configFile: ""
              theme: my-theme
              plugins: ['hello.php', 'my-plugin/my-plugin.php']
              activatePlugins: ['hello.php', 'my-plugin/my-plugin.php']
              booststrapActions: ['my-first-action', 'my-second-action']
              theme: 'my-theme'
```

and configure it using the required parameters:

 * `multisite` - if set to `true` the WordPress installation will be a multisite one, the WP_TESTS_MULTISITE global value.
 * `wpRootFolder` - the absolute path to the root folder of the WordPress installation to use for testing, the `ABSPATH` global value.
 * `dbNAme` - the name of the database to use for the tests, will be trashed during tests so take care, will be the `DB_NAME` global.
 * `dbHost` - the host the database can be found at, will be the `DB_HOST` global.
 * `dbUser` - the database privileged user, should `GRANT ALL` on the database, will be the `DB_USER` global.
 * `dbPassword` - the password for the user, will be the `DB_PASSWORD` global.

 Optional parameters are available to the module to reproduce the original testing suite possibilities as closely as possible:

* `isolatedInstall` - bool, def. `true`, whether the WordPress installation should happen in a separate process from the tests or not.
* `wpDebug` - bool, def. `true`, the `WP_DEBUG` global value.
* `multisite` - bool, def. `false`, if set to `true` will create a multisite instllation, the `WP_TESTS_MULTISITE` global value.
* `dbCharset` - string, def. `utf8`, the DB_CHARSET global value.
* `dbCollate` - string, def. ``, the DB_COLLATE global value.
* `tablePrefix` - string, def. `wptests_`, the `WP_TESTS_TABLE_PREFIX` value.
* `domain` - string, def. `example.org`, the root URL of the site, the `WP_TESTS_DOMAIN` global value.
* `adminEmail` - string, def. `admin@example.org`, the admin email, the `WP_TEST_EMAIL` global value.
* `title` - string, def. `Test Blog`, the blog title, the `WP_TESTS_TITLE` global value.
* `phpBinary` - string, def. `php`, the php bin command, the `WP_PHP_BINARY` global value.
* `language` - string, def. ` `, the installation language, the `WPLANG` global value.
* `configFile` - string or array, def. ` `, the path, or an array of paths, to custom config file(s) relative to the `wpRootFolder` folder, no leading slash needed; this is the place where custom `wp_tests_options` could be set.
* `pluginsFolder` - string, def. ` `, the relative path to the plugins folder from the `wpRootFolder` if different from the `wp-content/plugins` default one
* `plugins` - array, def. `['hello.php', 'my-plugin/my-plugin.php']`, a list of plugins that should be loaded before any test case runs and after mu-plugins have been loaded; these should be defined in the `folder/plugin-file.php` format.
* `activatePlugins` - array, def. `['hello.php', 'my-plugin/my-plugin.php']`, a list of plugins that will be activated before any test case runs and after WordPress is fully loaded and set up; these should be defined in the `folder/plugin-file.php` format; when the `multisite` option is set to `true` the plugins will be **network activated** during the installation.
* `bootstrapActions` - array, def. `['my-first-action', 'my-second-action']`, a list of actions or **static functions** that should be called after before any test case runs, after plugins have been loaded and activated; static functions should be defined in the YAML array format:

    ```yaml
    bootstrapActions:
        - action_one
        - action_two
        - [MyClass, myStaticMethod]
    ```

* `theme` - string|array, def. ``, the theme that should be activated for the tests; if a string is passed then both `template` and `stylesheet` options will be set to the passed value; if an array is passed then the `template` and `stylesheet` will be set in that order:

    ```yaml
    theme: my-theme
    ```

    The theme will be set to `my-theme`.

    ```yaml
    theme: [ parent, child ]
    ```

    The `template` will be set to `parent`, the `stylesheet` will be set to `child`.

**A word of caution**: right now the only way to write tests able to take advantage of the suite is to use the `WP_UnitTestCase` test case class; while the module will load fine and will raise no problems `WP_UnitTestCase` will take care of handling the database as intended and using another test case class will almost certainly result in an error if the test case defines more than one test method.

### WPBootstrapper configuration
The module will bootstrap a WordPress installation loading its `wp-load.php` file.   
The configuration will require one parameter only :

 * `wpRootFolder` - the absolute path to the root folder of the WordPress installation to use for testing, the `ABSPATH` global value.

### WPQueries configuration
This module requires no configuration.

### WordPress module configuration
The module is meant to be used in **functional** tests and requires the `WPDb` module to work.  
See `WPDb` module configuration section for more information abou the required module.  

```yaml
modules:
    enabled:
        - WPDb:
            dsn: 'mysql:host=localhost;dbname=wp'
            user: 'root'
            password: 'root'
            dump: 'tests/_data/dump.sql'
            reconnect: false
            url: 'http://wp.dev'
            tablePrefix: 'wp_'
        WordPress:
            depends: WPDb
            wpRootFolder: /var/www/wp
            adminUsername: admin
            adminPassword: password
            adminPath: /some-path/to/wp-admin
```

* `wpRootFolder` - the absolute path to the root folder of the WordPress installation to use for testing, the `ABSPATH` global value (required)
* `adminUsername` - the site administrator username (required)
* `adminPassword` - the site administrator login name (required)
* `adminPath` - the path, relative to the WordPress installation folder, to the admin area

### WordPress module configuration
This module is meant to be used in *functional* and *acceptance* tests to tap into the [wp-cli](http://wp-cli.org/) tool during tests.  
An embedded wp-cli installation will be used skipping a missing or already defined one, **a working local installation of wp-cli is not required for this module**.  
Calls to wp-cli are **synchronous** and **isolated**: wp-cli will run in a separate PHP process and will not share the environment with the test code.  
The example configuration below shows the module used in an acceptance test conjunction with the WPBrowser module.

```yaml
modules:
    enabled:
        WPBrowser:
            url: 'http://wp.dev'
        WPCLI:
            path: /Users/Luca/Sites/wp
            throw: true
```

* `path` - string, required; the absolute path to the WordPress installation under test; if a [`config.yml` file] is found here it will be ignored by the module.
* `throw` - bool, optional, defaults to `true`; whether errors returned from wp-cli execution should cause an exception or not; defaults to 
* `ssh` - string, optional; an SSH access string, see [wp-cli global parameters](http://wp-cli.org/config/#global-parameters).
* `http` - string, optional; an SSH access string, see [wp-cli global parameters](http://wp-cli.org/config/#global-parameters).
* `url` - string, optional; an SSH access string, see [wp-cli global parameters](http://wp-cli.org/config/#global-parameters).
* `user` - string, optional; an SSH access string, see [wp-cli global parameters](http://wp-cli.org/config/#global-parameters).
* `skip-plugins` - string, optional; an SSH access string, see [wp-cli global parameters](http://wp-cli.org/config/#global-parameters).
* `skip-themes` - string, optional; an SSH access string, see [wp-cli global parameters](http://wp-cli.org/config/#global-parameters).
* `skip-packages` - string, optional; an SSH access string, see [wp-cli global parameters](http://wp-cli.org/config/#global-parameters).
* `require` - string, optional; an SSH access string, see [wp-cli global parameters](http://wp-cli.org/config/#global-parameters).

The module defines two methods wrapping calls to the wp-cli tool:

* `cli(string $userCommand)` - executes `$userCommand` and returns **the command exit status**; `0` (shell equivalent of OK) will be cast to `true`.
    ```php
    $deleted = $I->cli('user delete user001');
    ```
    Test wp-cli exit stati as many commands raising warnings will return a `0` status, e.g:
    ```php
    $activated = $I->cli('plugin activate existing-plugin');
    $activated = $I->cli('plugin activate non-existing-plugin');
    ```
    The `$activated` var will have a value of `true` in both cases as the exit status, even if the `non-existing-plugin` does not exist, will be `0`.
    
* `cliToArray(string $userCommand)` - executes `$userCommand` and returns the command output cast to array; the command will try to guess if the output should be split by newlines or spaces.
    ```php
    $inactiveThemes = $I->cliToArray('theme list --status=active --field=name');
    ```
    Should the default guessing prove wrong the optional `$splitCallback` argument can be used; the callback function will be passed 3 arguments:
    
    ```php
    function splitCallback(string $output, string $userCommand, WPCLI $wpcli)
    ```
   
   and is expected to return an array output.
 
##### Option overrides
Any option specified in the module configuration will be overridden (save for the `require` one that will be merged) by options and arguments specified inline in a command.  

```php
// Even if the config YAML file for the module defines the 'url' var the one specified inline will be used.
$I->cli('wp post create --post_title=Foo --post_content=Foo --post_excerpt=Foo --url=http://subdomain.wordpress.dev');
```
   
#### Configuration files
Global and local [configuration files](http://wp-cli.org/config/#config-file) will be ignored; any additional parameter should be specified inline.  
This prevents tests from running commands that would impact the WordPress installation in a way that would not be reversible (e.g. create or modify the `.htaccess` file); as a general guideline the wrapper is meant to be used to perform database reversible operations.

### The `wpcept` command
The package will create a link to the `bin/wpcept` script file; that's an extension of Codeception own `codecept` CLI application to allow for a WordPress specific setup.

#### bootstrap
The CLI application adds the `bootstrap` command argument to allow for a quick WordPress testing environment setup replacing the default bootstrap configuration created by Codeception.

```sh
wpcept bootstrap
```

The command will generate the "Unit", "Integration", "Functional" and "Acceptance" suites following the same pattern used by Codeception but with WordPress specific modules:

* Unit with `Asserts` and helper modules
* Integration with `WPLoader` and helper modules
* Functional with `Filesystem`, `WPDb`, `WordPress` and helper modules
* Acceptance with `WPBrowser`, `WPDb` and helper modules

Please note that default Codeception suite bootstrapping is available using the `codecept bootstrap` command; use the `--interactive` option to scaffold the test suites configuration using a guided process.

```sh
wpcept bootstrap --interactive
```

#### bootstrap:pyramid
The `bootstrap:pyramid` command argument allows for a quick WordPress testing environment setup following the [test pyramid](http://martinfowler.com/bliki/TestPyramid.html) suite organization.  
The command

```sh
wpcept bootstrap:pyramid
```

will generate the "UI", "Service", "Wpunit" and "Unit" suites and will take care of setting up default modules and their settings for each like:

* Unit with `Asserts` and `UnitHelper` modules
* Integration with `WPLoader` and helper modules
* Functional with `Filesystem`, `WPDb`, `WordPress` and helper modules
* Acceptance with `WPBrowser`, `WPDb` and helper modules

Please note that default Codeception suite bootstrapping is available using the `codecept bootstrap` command; use the `--interactive` option to scaffold the test suites configuration using a guided process.

```sh
wpcept bootstrap --interactive
```

#### generate:wpunit
Generates a test case extending the `\Codeception\TestCase\WPTestCase` class using the

```sh
  wpcept generate:wpunit suite SomeClass
```

The command will generate a skeleton test case like


```php
<?php

class SomeClassTest extends \Codeception\TestCase\WPTestCase
{
    public function setUp()
    {
      parent::setUp();
    }

    public function tearDown()
    {
      parent::tearDown();
    }

    // tests
    public function testMe()
    {
    }

}
```

#### generate:wprest
Generates a test case extending the `\Codeception\TestCase\WPRestApiTestCase` class using the

```sh
  wpcept generate:wprest suite SomeClass
```

The command will generate a skeleton test case like


```php
<?php

class SomeClassTest extends \Codeception\TestCase\WPRestApiTestCase
{
    public function setUp()
    {
      parent::setUp();
    }

    public function tearDown()
    {
      parent::tearDown();
    }

    // tests
    public function testMe()
    {
    }

}
```

#### generate:wpajax
Generates a test case extending the `\Codeception\TestCase\WPAjaxTestCase` class using the

```sh
  wpcept generate:wpajax suite SomeClass
```

The command will generate a skeleton test case like


```php
<?php

class SomeClassTest extends \Codeception\TestCase\WPAjaxTestCase
{
    public function setUp()
    {
      parent::setUp();
    }

    public function tearDown()
    {
      parent::tearDown();
    }

    // tests
    public function testMe()
    {
    }

}
```

#### generate:wpxmlrpc
Generates a test case extending the `\Codeception\TestCase\WPXMLRPCTestCase` class using the

```sh
  wpcept generate:wpxmlrpc suite SomeClass
```

The command will generate a skeleton test case like


```php
<?php

class SomeClassTest extends \Codeception\TestCase\WPXMLRPCTestCase
{
    public function setUp()
    {
      parent::setUp();
    }

    public function tearDown()
    {
      parent::tearDown();
    }

    // tests
    public function testMe()
    {
    }

}
```

#### generate:wpcanonical
Generates a test case extending the `\Codeception\TestCase\WPCanonicalTestCase` class using the

```sh
  wpcept generate:wpcanonical suite SomeClass
```

The command will generate a skeleton test case like


```php
<?php

class SomeClassTest extends \Codeception\TestCase\WPCanonicalTestCase
{
    public function setUp()
    {
      parent::setUp();
    }

    public function tearDown()
    {
      parent::tearDown();
    }

    // tests
    public function testMe()
    {
    }

}
```

Any other `codecept` option remains intact and available. 

#### generate:phpunitBootstrap
This command will generate the files required to run functional tests defined in test case classes extending the `WP_UnitTestCase` class.  
The method will read the `codeception.yml` file to point PHPUnit `phpunit.xml` file to the tests folder and set up a `phpunit-bootstrap.php` file in the tests folder.  
The command has the following arguments

`suites` - a comma separated list of suites the tests should run, def. `functional`
`suffix` - the suffix of test classes PHPUnit should run, def. `Test`
`vendor` - the path, relative to the project root folder, to the vendor folder, def. `vendor`

Each call to the command will re-generate the `phpunit.xml` and `tests/phpunit-bootstrap.php` files, changes made to the `phpunit` element attributes in the `phpunit.xml` file will be preserved across regenerations.

### Management commands
The package comes with some commands meant to make the management and sharing of a shared repository easier.
Some are wrappers around external commands (like `search-replace` and `setup`) or native to the WPBrowser package.  
All the commands share the `--save-config` option: when used in flag mode any **option** value specified in the command (so **no arguments**) will be saved in a `commands-config.yml` file in the root folder.  
As an example running:

```bash
wpcept db:snapshot issue3344 wp-tests --local-url=http://wp-tests.dev --dist-url=http://acme.tests.dev --host=192.54.0.1 --user=db --pass=db --save-config
```

will generate a  `command-config.yml` file like this:

```yaml
# tad\Codeception\Command configuration file.
# Each section should be the name of a supported command
# This file was auto-generated by the use of the `--save-config` option on one or more commands.
# But you can modify it by hand with some care.
db:snapshot:
    local-url: http://wp-tests.dev
    dist-url: http://acme.tests.dev
    host: 192.54.0.1
    user: db
    pass: db
```

that will allow to shorten the next invocation of the command considerably on the next run:

```bash
wpcept db:snapshot issue44566 wp-tests 
```

Multiple commands can and will write their own configuration in the `command-config.yml` file.  
It is possible to override saved configuration values specifying the option in the command:

```bash
wpcept db:snapshot issue22444 wp-tests --user=root --host=localhost
```

#### search-replace
This is merely a shimming of the `search-replace` command defined in [the `lucatume/codeception-setup-local` package](https://github.com/lucatume/codeception-setup-local "lucatume/codeception-setup-local · GitHub"); see package documentation for more information.

#### setup
This is merely a shimming of the `setup` command defined in [the `lucatume/codeception-setup-local` package](https://github.com/lucatume/codeception-setup-local "lucatume/codeception-setup-local · GitHub"); see package documentation for more information.

#### db:snapshot
The command allows developers to take a snapshot of a database state to be used to share database-based fixtures in a team.  
The command takes the following arguments and options:

* `snapshot` - the first argument is the name of the snapshot to be taken; e.g. `issue4455` or `ticket-ab-f00-34`; required
* `name` - the second argument is the name of the database that should be exported; e.g. `wp` or `test-db`; required
* `--host` - this options allows defining the database host; defaults to `localhost`; optional
* `--user` - this options allows defining the database user; defaults to `root`; optional
* `--pass` - this options allows defining the database password; defaults to `root`; optional
* `--dump-file` - this options allows defining the destination file for the database dump (an absolute path); defaults to `<snapshot>.sql` in Codeception data folder; optional
* `--dist-dump-file` - this options allows defining the destination file for the distribution database dump (an absolute path); defaults to `<snapshot>.dist.sql` in Codeception data folder; optional
* `--skip-tables` - this options allows defining any table that shuould not be dumped (a comma separated list); e.g. `wp_posts,wp_users`; defaults to none; optional
* `--local-url` - this options allows defining the local setup url that is hardcoded in the local version of the database by WordPress; e.g. `http://wp.dev`; defaults to `http://local.dev`; optional but probably needed
* `--dist-url` - this options allows defining the distribution setup url that will be hardcoded in the distribution version of the database dump; e.g. `http://wptest.dev`; defaults to `http://dist.dev`; optional but probably needed

A typical flow using the command would be:

* a developer sets up a local version of a starting database state for a test or a series of tests
* the developer creates a local (to be used in local tests) and distribution (to be shared with other team members) dump of his/her local database using:

  ```bash
  wpcept db:snapshot issue3344 wp-tests --local-url=http://wp-tests.dev --dist-url=http://acme.tests.dev
  ```
* any other developer on the team can use the `search-replace` command to localize the distribution version of the database dump to suite his/her setup:
  
  ```bash
  wpcept search-replace http://acme.tests.dev http://local.dev ./tests/_data/issue3344.dist.sql ./tests/_data/issue3344.sql
  ```

### ExtendedDb configuration
The module has the same configuration as the `Db` one and hence will not require any additional parameter beside those required/available to the `Db` module.
In the suite `.yml` configuration file add the module among the loaded ones

```yml
  modules:
      enabled:
          - ExtendedDb
      config:
          ExtendedDb:
              dsn: 'mysql:host=localhost;dbname=testdb'
              user: 'root'
              password: ''
              dump: 'tests/_data/dump.sql'
              populate: true
              cleanup: true
```

and configure `Db` parameters as usual.

## Methods

### WPBrowser module
The module adds methods that can be used in `.cest` and `.cept` methods using the same `$I->doSomething` syntax used in PhpBrowser.  
Included methods are:

```php
  // login as administrator using username and password
  public function loginAsAdmin();

  // login as user
  public function loginAs($username, $password);

  // go the plugins page
  public function amOnPluginsPage();

  // activate a plugin from the plugin page
  public function activatePlugin($pluginSlug);

  // deactivate a plugin from the plugin page
  public function deactivatePlugin($pluginSlug);

  // check that a plugin is installed and deactivated from the plugin page
  public function seePluginDeactivated($pluginSlug);

  // check that a plugin is installed and activated from the plugin page
  public function seePluginActivated($pluginSlug);

  // check that a plugin is installed from the plugin page
  public function seePluginInstalled($pluginSlug);

  // check that a plugin is not installed from the plugin page
  public function doNotSeePluginInstalled($pluginSlug);

  // check for an error admin notice
  public function seeErrorMessage($classes = '');

  // check for an updated admin notice
  public function seeMessage($classes = '');

  // check that the current page is a wp_die generated one
  public function seeWpDiePage();

  // grab all cookies whose name matches a pattern
  public function grabCookiesWithPattern($pattern);

  // grab WordPress test cookie
  public function grabWordPressTestCookie($pattern = null);

  // grab WordPress login cookie
  public function grabWordPressLoginCookie($pattern = null);

  // grab WordPrss auth cookie
  public function grabWordPressAuthCookie($pattern = null);
```

Methods like `seePlugin...` require the use of the `amOnPluginsPage` method before their invocation to navigate PhpBrowser to the right folder.

### WPDb module
The module extends `Codeception\Module\Db` and will hence act as a drop-in replacement for it. It adds an optional `tablePrefix` configuration parameter, defaulting to `wp`, and will require the same parameters as the original module.  
The verbs used by the `Db` module are honored so `dontHave` removes an entry, `have` adds an entry, `dontSee` checks an entry is not in the database, `see` checks an entry is in the database, `grab` gets a value from the database or the module.  
When dealing with multisite installations then the `useBlog` and `useMainBlog` methods can be used to perform any following database operation on the specified site tables if applicable; some tables are unique in a WordPress installation (e.g. `users`) and the command will not mess with it.  
The module is meant to be a WordPress specific extension of the `Db` module and will hence decline the `have` and `see` methods for each WordPress table; here's a current list of all the defined methods:

* dontHaveBlogInDatabase
* dontHaveCommentInDatabase
* dontHaveCommentMetaInDatabase
* dontHaveLinkInDatabase
* dontHaveOptionInDatabase
* dontHavePostInDatabase
* dontHavePostMetaInDatabase
* dontHaveSiteOptionInDatabase
* dontHaveSiteTransientInDatabase
* dontHaveTermInDatabase
* dontHaveTermMetaInDatabase
* dontHaveTermRelationshipInDatabase
* dontHaveTermTaxonomyInDatabase
* dontHaveTransientInDatabase
* dontHaveUserInDatabase
* dontHaveUserMetaInDatabase
* dontSeeBlogInDatabase
* dontSeeCommentInDatabase
* dontSeeCommentMetaInDatabase
* dontSeeLinkInDatabase
* dontSeeOptionInDatabase
* dontSeePageInDatabase
* dontSeePostInDatabase
* dontSeePostMetaInDatabase
* dontSeeTermInDatabase
* dontSeeTermMetaInDatabase
* dontSeeTermTaxonomyInDatabase
* dontSeeUserInDatabase
* dontSeeUserMetaInDatabase
* getSiteDomain
* grabAllFromDatabase
* grabBlogsTableName
* grabBlogVersionsTableName
* grabCommentmetaTableName
* grabCommentsTableName
* grabLatestEntryByFromDatabase
* grabLinksTableName
* grabOptionFromDatabase
* grabPostMetaTableName
* grabPostsTableName
* grabPrefixedTableNameFor
* grabRegistrationLogTableName
* grabSignupsTableName
* grabSiteMetaTableName
* grabSiteOptionFromDatabase
* grabSiteTableName
* grabSiteTransientFromDatabase
* grabSiteUrl
* grabTermIdFromDatabase
* grabTermMetaTableName
* grabTermRelationshipsTableName
* grabTermsTableName
* grabTermTaxonomyIdFromDatabase
* grabTermTaxonomyTableName
* grabUserIdFromDatabase
* grabUserMetaFromDatabase
* grabUsermetaTableName
* haveBlogInDatabase
* haveCommentInDatabase
* haveCommentMetaInDatabase
* haveLinkInDatabase
* haveManyBlogsInDatabase
* haveManyCommentsInDatabase
* haveManyLinksInDatabase
* haveManyPostsInDatabase
* haveManyTermsInDatabase
* haveManyUsersInDatabase
* haveMultisiteInDatabase
* haveOptionInDatabase
* havePageInDatabase
* havePostInDatabase
* havePostmetaInDatabase
* haveSiteOptionInDatabase
* haveSiteTransientInDatabase
* haveTermInDatabase
* haveTermMetaInDatabase
* haveTermRelationshipInDatabase
* haveTransientInDatabase
* haveUserCapabilitiesInDatabase
* haveUserInDatabase
* haveUserLevelsInDatabase
* haveUserMetaInDatabase
* seeBlogInDatabase
* seeCommentInDatabase
* seeCommentMetaInDatabase
* seeLinkInDatabase
* seeOptionInDatabase
* seePageInDatabase
* seePostInDatabase
* seePostMetaInDatabase
* seePostWithTermInDatabase
* seeSiteOptionInDatabase
* seeSiteSiteTransientInDatabase
* seeTableInDatabase
* seeTermInDatabase
* seeTermMetaInDatabase
* seeTermTaxonomyInDatabase
* seeUserInDatabase
* seeUserMetaInDatabase
* useBlog
* useMainBlog
* useTheme
* haveMenuInDatabase
* haveMenuItemInDatabase
* seeTermRelationshipInDatabase

See source code for more detail.

#### Handlebar templates while having many
When using one of the `haveMany` methods (`haveManyBlogsInDatabase`, `haveManyCommentsInDatabase`, `haveManyLinksInDatabase`, `haveManyPostsInDatabase`, `haveManyTermsInDatabase`, `haveManyUsersInDatabase`) it's possible to tap into [Handlebars PHP](https://github.com/XaminProject/handlebars.php "XaminProject/handlebars.php · GitHub") templating capabilities to set up complex testing data.  
When specifying a string value overriding the default ones the simplest replacement is the one where the `{{n}}` placeholder is replaced with the index of the object instance in the series:
```php
$I->haveManyPostsInDatabase(3, ['post_title' => 'Post {{n}} title']);
```

will insert 3 posts in the database titled "Post 0 title", "Post 1 title" and "Post 2 title".  
The string value will be used as a template and the `n` parameter will always be passed to the template; should additional template data be needed then each `haveMany` method allows for an additional `template_data` entry in the `overrides` array.

```php
$overrides = [
	'post_title' => 'Post {{n}} title {{some_string}}', 
	'template_data' => ['some_string' => 'foo']
	];
$I->haveManyPostsInDatabase(3, $overrides);
```

will insert 3 posts in the database titled "Post 0 title foo", "Post 1 title foo" and "Post 2 title foo".
To extend the flexibility template data allows for functions and closures to be specified: each will be called passing the index as an argument.

```php
$numeral = function($n){
	$numerals = ['First', 'Second', 'Third'];
	return $numerals[$n];
	};
$overrides = [
	'post_title' => '{{numeral}} post title',
	'template_data' => ['numeral' => $numeral]
	];
$I->haveManyPostsInDatabase(3, $overrides);
```

will insert 3 posts in the database titled "First post title", "Second post title" and "Third post title".
All of default [Handlebars PHP](https://github.com/XaminProject/handlebars.php "XaminProject/handlebars.php · GitHub") helpers are available to use in templates; the code below is an example:

```php
$numeral = function($n){
	$numerals = ['First', 'Second', 'Third'];
	return $numerals[$n];
	};
$overrides = [
	'post_title' => '{{#if n}}{{numeral}} post title{{/if}}{{#unless n}}I have index 0{{/unless}}',
	'template_data' => ['numeral' => $numeral]
	];
$I->haveManyPostsInDatabase(3, $overrides);
```
will insert 3 posts in the database titled "I have index 0", "Second post title" and "Third post title".

### ExtendedDb module
The module is an extension of the `Codeception\Module\Db` class implementing some methods to allow for more CRUD complete operations on the database with the methods

```php
  public function dontHaveInDatabase($table, array $criteria);

  public function haveOrUpdateInDatabase($table, array $data)
```

### WPBootstrapper
The module adds some *sugar* methods, beside allowing for the call of any WordPress defined function or class method, to speed up teh writing of test methods:

* `setPermalinkStructureAndFlush($permalinkStructure = '/%postname%/', $hardFlush = true)` - sets the permalink structure to the specified value and flushes the rewrite rules.
* `loadWpComponent($component)` - includes the file(s) required to access some functions and classes WordPress would not load by default in a bootstrap; currently supported
  * `plugins` - includes the `wp-admin/includes/plugin.php` file to access functions like `activate_plugin` and `deactivate_plugins`.

### WPQueries
The module assertion methods can be accessed including it in the suite configuration file.  
When writing tests the module can be accessed using the `getModule` method.  
In any test case class extending the base `Codeception\TestCase\Test` class the module can be accessed like this:

```php
class QueriesTest extends Codeception\TestCase\Test{

  public function test_insertion_queries(){
    wp_insert_post(['post_type' => 'page', 'post_title' => 'Some title']);

    $queries = $this->getModule('WPQueries');
    $queries->assertQueries();
  }

}
```

In `cept` or `cest` format tests the module can be accessed in a similar way:

```php
$I = new FunctionalTester($scenario);
$I->amOnPage('/');
$I->click('Create random post');

$queries = $I->getModule('WPQueries');

$queries->assertQueries();
```

The module defines the following assertion methods, see code doc blocks documentation for the details:

* assertQueries
* assertNotQueries
* assertCountQueries 
* assertQueriesByStatement
* assertQueriesByMethod
* assertNotQueriesByStatement
* assertQueriesCountByStatement
* assertNotQueriesByMethod
* assertQueriesCountByMethod
* assertQueriesByFunction
* assertNotQueriesByFunction
* assertQueriesCountByFunction
* assertQueriesByStatementAndMethod
* assertNotQueriesByStatementAndMethod
* assertQueriesCountByStatementAndMethod
* assertQueriesByStatementAndFunction
* assertNotQueriesByStatementAndFunction
* assertQueriesCountByStatementAndFunction
* assertQueriesByAction
* assertNotQueriesByAction
* assertQueriesCountByAction
* assertQueriesByStatementAndAction
* assertNotQueriesByStatementAndAction
* assertQueriesCountByStatementAndAction
* assertQueriesByFilter
* assertNotQueriesByFilter
* assertQueriesCountByFilter
* assertQueriesByStatementAndFilter
* assertNotQueriesByStatementAndFilter
* assertQueriesCountByStatementAndFilter

**Note**: when used in a `WPTestCase` exending class the assertion methods will exclude queries made during `WPTestCase::setUp`, `WPTestCase::tearDown` and factory methods!  
This means that the `test_queries` test method below will fail as no queries have been made by methods or that are not part of `setUp`, `tearDown` or factories:

```php
class QueriesTest extends Codeception\TestCase\WPTestCase {
  public fuction test_queries(){
    
    $this->factory()->posts->create();

    // this will fail!
    $this->assertQueries();
  }
}
```

## Extensions
The package contains an additional extension to facilitate testers' life.

### Symlinker
The `tad\WPBrowser\Extension\Symlinker` extension provides an automation to have the Codeception root directory symbolically linked in a WordPress local installation.  
Since version `3.9` WordPress supports this feature (with some [precautions](https://make.wordpress.org/core/2014/04/14/symlinked-plugins-in-wordpress-3-9/https://make.wordpress.org/core/2014/04/14/symlinked-plugins-in-wordpress-3-9/)) and the extension takes charge of:

* symbolically linking a plugin or theme folder in the specified destination before any suite boots up
* unlinking that symbolic link after all of the suites did run

It's the equivalent of doing something like this from the command line (on a Mac):

```bash
ln -s /my/central/plugin/folder/my-plugin /my/local/wordpress/installation/wp-content/plugins/my-plugin
/my/central/plugin/folder/my-plugin/vendor/bin/codecept run
rm -rf /my/local/wordpress/installation/wp-content/plugins/my-plugin

```

The extension needs small configuration in the `codeception.yml` file:

```yaml
extensions:
    enabled:
        - tad\WPBrowser\Extension\Symlinker
    config:
        tad\WPBrowser\Extension\Symlinker:
            mode: plugin
            destination: /my/local/wordpress/installation/wp-content/plugins
            rootFolder: /some/plugin/folder
```

The arguments are:

* `mode` - can be `plugin` or `theme` and indicates whether the current Codeception root folder being symlinked is a plugin or a theme one
* `destination` - the absolute path to the WordPress local installation plugins or themes folder; to take the neverending variety of possible setups into account the extension will make no checks on the nature of the destination: could be any folder.
* `rootFolder` - optional absolute path to the WordPress plugin or theme to be symlinked root folder; will default to the Codeception root folder

### Copier
The `tad\WPBrowser\Extension\Copier` extension provides an automation to have specificic files and folders copied to specified destination files and folders before the suites run.
While WordPress handles symbolic linking pretty well there are some cases, like themes and drop-ins, where there is a need for "real" files to be put in place.
The extension follows the standard Codeception extension activation and has one configuration parameter only:

```yaml
extensions:
    enabled:
        - tad\WPBrowser\Extension\Copier
    config:
        tad\WPBrowser\Extension\Copier:
            files:
                tests/_data/required-drop-in.php: /var/www/wordpress/wp-content/drop-in.php
                tests/_data/themes/dummy: /var/www/wordpress/wp-content/themes/dummy
                /Users/Me/Repos/required-plugin: /var/www/wordpress/wp-content/plugins/required-plugin.php
                /Users/Me/Repos/mu-plugin.php: ../../../../wp-content/mu-plugins/mu-plugin.php
```

The extension will handle absolute and relative paths for sources and destinations and will resolve relative paths from the project root folder.
When copying directories the extension will only create the destination folder and not the folder tree required; in the example configuration above the last entry specifies that a `mu-plugin.php` file should be copied to the `mu-plugins` folder: that `mu-plugins` folder must be there already.

#### Environments support
Being able to symlink a plugin or theme folder into a WordPress installation for testing purposes could make sense when trying to test, as an example, a plugin in a single site and in multi site environment.  
Codeception [supports environments](http://codeception.com/docs/07-AdvancedUsage#Environmentshttp://codeception.com/docs/07-AdvancedUsage#Environments) and the extension does as well specifyin a destination for each.  
As an example the `acceptance.suite.yml` file might be configured to support `single` and `multisite` environments:

```yaml
env:
    single:
        modules:
            config:
                WPBrowser:
                    url: 'http://wp.dev'
                WPDb:
                    dsn: 'mysql:host=127.0.0.1;dbname=wp'
    multisite:
        modules:
            config:
                WPBrowser:
                    url: 'http://mu.dev'
                WPDb:
                    dsn: 'mysql:host=127.0.0.1;dbname=mu'
```
In the `codeception.yml` file specifying a `destination` for each supported environment will tell the extension to symbolically link the plugin or theme file to different locations according to the current environment:
```yaml
extensions:
    enabled:
        - tad\WPBrowser\Extension\Symlinker
    config:
        tad\WPBrowser\Extension\Symlinker:
            mode: plugin
            destination:
                single: /var/www/wp/wp-content/plugins
                multisite: /var/www/mu/wp-content/plugins
```
If no destination is specified for the current environment the extension will fallback to the first specified one.  
A `default` destination can be specified to override this behaviour.
```yaml
extensions:
    enabled:
        - tad\WPBrowser\Extension\Symlinker
    config:
        tad\WPBrowser\Extension\Symlinker:
            mode: plugin
            destination:
                default: /var/www/default/wp-content/plugins
                single: /var/www/wp/wp-content/plugins
                multisite: /var/www/mu/wp-content/plugins
```
When running a suite specifying more than one environment like
```bash
codecept run acceptance --env foo,baz,multisite
```
Then the extension will use the first matched one, in the case above the `multisite` destination will be used.
