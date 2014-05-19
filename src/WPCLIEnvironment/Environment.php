<?php

/**
 * Environment class
 *
 * PHP version 5.3
 *
 * This file is part of WP CLI Environment.
 *
 * @category  WPCLI
 * @package   WPCLIEnviromment
 * @author    Piotr Kierzniewski <p.kierzniewski@viewone.pl>
 * @copyright 2014 ViewOne Sp. z o.o.
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      https://github.com/viewone
 */

namespace WPCLIEnvironment;

class Environment
{

    /**
     * Avaiable environments
     *
     * @var array
     */
    public static $environments = array( 'local', 'development', 'testing', 'staging', 'production' );

    /**
     * Config file
     *
     * @var string
     */
    public static $config = null;

    /**
     * Environment
     *
     * Potential values are 'local', 'development', 'testing', 'staging', 'production' or null.
     *
     * @var string
     */
    public static $environment = null;

    /**
     * Set WP_CLI_CONFIG_PATH based on second argument passed to wp
     *
     * This method use WP_CLI_CONFIG_PATH environment vairable
     * to pass config file.
     *
     * For example, if we execute this command:
     * <samp>
     * wp production core download
     * </samp>
     *
     * WP CLI will use config file wp-cli.production.yml
     *
     * Avaiable environments are: local, development, testing,
     * staging, production.
     *
     * @param string|null $environment Possible enviroemnt
     *
     * @return void
     */
    public static function run($environment)
    {
        if (!is_string($environment) && !is_null($environment)) {
            throw new \Exception('$environment should be string or null insted of ' . gettype($environment) . '.');
        }

        self::resolveEnvironment($environment);
        self::resolveConfig();

        if (self::$config) {
            putenv("WP_CLI_CONFIG_PATH=" . self::$config);
        }
    }

    /**
     * Resolve environment based on first argument passed to wp-cli
     *
     * This method use global $argv variable to read first argument
     * passed to wp-cli. If argument match one of the avaiable environments,
     * method will set environment to it and remove this argument from $argv.
     *
     * For example, if we execute this command:
     * <samp>
     * wp production core download
     * </samp>
     *
     * Method will set environment to production
     *
     * Avaiable environments are: local, development, testing,
     * staging, production.
     *
     * @param string $environment Possible enviroemnt
     *
     * @return void
     */

    private static function resolveEnvironment($environment)
    {
        global $argv;

        if (array_search($environment, self::$environments) !== false) {
            unset($argv[1]);
            self::$environment = $environment;
        }
    }

    /**
     * Resolve config path based on environment
     *
     * Use $environment to resolve config path. If such a file doesn't exists
     * method will throw an exception: File $configPath doesn't exists.
     *
     * @throws Exception File $configPath doesn't exists.
     *
     * @return void
     */

    private static function resolveConfig()
    {
        if (self::$environment) {

            $configFile = 'wp-cli.' . self::$environment . '.yml';
            $configPath = getcwd() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $configFile;

            if (file_exists($configPath)) {
                self::$config = $configPath;
            } else {
                throw new \Exception('File ' . $configPath . ' doesn\'t exists.');
            }
        }
    }
}
