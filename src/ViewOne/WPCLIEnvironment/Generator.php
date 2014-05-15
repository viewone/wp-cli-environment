<?php

/**
 * Generator class
 *
 * PHP version 5.3
 *
 * This file is part of WP CLI Environment.
 *
 * Generator class is responsible for generate command class. Because wp-cli
 * validate all args and params we can't use one Command class to handle
 * all possible arguments and parameters passed after wp [environment].
 *
 * To provide such a funcionality Generator will dynamicly create Command
 * class based on $argv.
 *
 * @category  WPCLI
 * @package   WPCLIEnviromment
 * @author    Piotr Kierzniewski <p.kierzniewski@viewone.pl>
 * @copyright 2014 ViewOne Sp. z o.o.
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      https://github.com/viewone
 */

namespace ViewOne\WPCLIEnvironment;

class Generator
{
    /**
     * Get wp-cli global path
     *
     * Method is using code from wp-cli
     *
     * @return string $dir
     */

    public static function getCachePath()
    {
        $home = getenv('HOME');

        if ( !$home ) {
            $home = getenv('HOMEDRIVE') . '/' . getenv('HOMEPATH');
        }

        $dir = getenv('WP_CLI_CACHE_DIR') ? : "$home/.wp-cli/cache";

        return $dir;
    }

    /**
     * Generate command class based on $args, $assocParams and $params
     * and put content in Command.php file in global cache wp-cli path.
     *
     * @return void
     */

    public static function generateCommandClass()
    {
        $args  = \ViewOne\WPCLIEnvironment\Command::getArguments();
        $assocParams = \ViewOne\WPCLIEnvironment\Command::getAssocParameters();
        $params = \ViewOne\WPCLIEnvironment\Command::getParameters();

        $moutstache = new \Mustache_Engine;

        $dir = self::getCachePath();

        if (!file_exists($dir . '/wp-cli-environment')) {
            mkdir($dir . '/wp-cli-environment', 0777, true);
        }

        $template = file_get_contents(__DIR__ . '/../../../template/command.mustache');
        $variables = array('args' => $args, 'assoc_params' => $assocParams, 'params' => $params);

        $class = $moutstache->render($template, $variables);

        file_put_contents($dir . '/wp-cli-environment/Command.php', $class);
    }
}
