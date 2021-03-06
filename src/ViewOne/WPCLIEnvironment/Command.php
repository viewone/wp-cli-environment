<?php

/**
 * Command class
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

namespace ViewOne\WPCLIEnvironment;

class Command
{

    /**
     * Avaiable environments
     *
     * TO-DO: Find way to not repeat variables from Environment class.
     *
     * @var array
     */
    private static $environments = array( 'local', 'development', 'testing', 'staging', 'production' );

    /**
     * Build command
     *
     * Method is using global $argv
     *
     * @return string $command
     */

    public static function getCommand()
    {
        global $argv;

        $args        = self::getArguments();
        $assocParams = self::getAssocParameters();
        $params      = self::getParameters();

        $command = "wp " . implode(" ", $args);

        foreach ($assocParams as $param) {

            $command .= " --" . $param['param'] . "=" . $param['value'];
        }

        foreach ($params as $param) {

            $command .= " --" . $param['param'];
        }

        return $command;
    }

    /**
     * Get arguments from global $argv
     *
     * Method is using global $argv
     *
     * @return array $localArgs
     */

    public static function getArguments()
    {
        global $argv;

        $localArgs = array();

        foreach ($argv as $arg) {
            if (preg_match("/^(?!(--|\/)).+$/", $arg, $match) == 1) {

                if (array_search($match[0], self::$environments) === false) {

                    //Check if argument has spaces if so wrap argument with quotation marks
                    if (preg_match('/\s/', $match[0])) {
                        $localArgs[] = '"' . $match[0] . '"';
                    } else {
                        $localArgs[] = $match[0];
                    }
                }
            }
        }

        return $localArgs;
    }

    /**
     * Get associative parameters from global $argv
     *
     * Method is using global $argv
     *
     * @return array $assocParams
     */

    public static function getAssocParameters()
    {
        global $argv;

        $assocParams = array();

        foreach ($argv as $arg) {
            if (preg_match("/^--([a-zA-Z0-9-]+)\=([a-zA-Z0-9:'\/\.]+)$/", $arg, $match) == 1) {

                $assocParams[] = array(
                    'param' => $match[1],
                    'value' => $match[2],
                );
            }
        }

        return $assocParams;
    }

    /**
     * Get single parameters from global $argv
     *
     * Method is using global $argv
     *
     * @return array $params
     */

    public static function getParameters()
    {
        global $argv;

        $params = array();

        foreach ($argv as $arg) {
            if (preg_match("/^--([a-zA-Z0-9-]+)$/", $arg, $match) == 1) {

                $params[] = array(
                    'param' => $match[1],
                );
            }
        }

        return $params;
    }
}
