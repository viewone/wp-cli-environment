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

namespace ViewOne\Environment;

class Command
{
    /**
     * Build command striping evnironment variable
     *
     * Method is using global $argv because dashed params which I suppose should
     * be in $assocArgs aren't avaiable.
     *
     * @param array $args      Commands
     * @param array $assocArgs Parameters
     *
     * @return string $command
     */

    public static function getCommand($args, $assocArgs)
    {
        global $argv;

        $localAssocArgs = array();

        foreach ($argv as $arg) {
            if (preg_match('/^--([a-z]+)\=([a-zA-Z0-9\:\/\.]+)/', $arg, $match) == 1) {
                $localAssocArgs[$match[1]] = $match[2];
            }
        }

        $assocArgs = $localAssocArgs;

        $command = "wp " . implode(" ", $args);
        foreach ($assocArgs as $key => $value) {
            $command .= " --{$key}={$value}";
        }

        return $command;
    }
}
