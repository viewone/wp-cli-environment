<?php

if ( !defined( 'WP_CLI' ) ) return;

require_once 'src/ViewOne/Environment.php';
require_once 'src/ViewOne/Environment/Command.php';

class Environment_Command extends WP_CLI_Command
{

    /**
     * Execute WP-CLI against configuration for a given environment
     *
     * <environment>
     * : Environment to run the command against
     *
     * <arg>
     * : WP-CLI command, plus any positional arguments.
     *
     * [--assoc-args=<value>]
     * : Any configuration or associative arguments
     *
     * @when before_wp_load
     */
    public function __invoke($args, $assoc_args)
    {
        global $argv;

        try {
            $environment = new \ViewOne\Environment();
            $environment->run($argv[1]);
        } catch (Exception $e) {
            \WP_CLI::error( $e->getMessage() );
        }

        $command = \ViewOne\Environment\Command::getCommand($args, $assoc_args);

        WP_CLI::launch($command);
    }
}

WP_CLI::add_command( 'local', 'Environment_Command' );
WP_CLI::add_command( 'development', 'Environment_Command' );
WP_CLI::add_command( 'production', 'Environment_Command' );
WP_CLI::add_command( 'staging', 'Environment_Command' );
WP_CLI::add_command( 'testing', 'Environment_Command' );
