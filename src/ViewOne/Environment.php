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
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link      https://github.com/viewone
 */

namespace ViewOne;

class Environment
{

    /**
     * Avaiable environments
     *
     * @var array
     */
    private $environments = array( 'local', 'development', 'testing', 'staging', 'production' );

    /**
     * Config file
     *
     * @var string
     */
    private $config = null;

    /**
     * Environment
     *
     * Potential values are 'local', 'development', 'testing', 'staging', 'production' or null.
     *
     * @var string
     */
    private $environment = null;

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
    public function run($environment)
    {
        if (!is_string($environment) && !is_null($environment)) {
            throw new \Exception('$environment should be string or null insted of ' . gettype($environment) . '.');
        }

        $this->resolveEnvironment($environment);
        $this->resolveConfig();

        if ($this->config) {
            putenv("WP_CLI_CONFIG_PATH=" . $this->config);
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

    private function resolveEnvironment($environment)
    {
        global $argv;

        if (array_search($environment, $this->environments)) {
            unset($argv[1]);
            $this->environment = $environment;
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

    private function resolveConfig()
    {
        if ($this->environment) {

            $configFile = 'wp-cli.' . $this->environment . '.yml';
            $configPath = getcwd() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $configFile;

            if (file_exists($configPath)) {
                $this->config = $configPath;
            } else {
                throw new \Exception('File ' . $configPath . ' doesn\'t exists.');
            }
        }
    }
}
