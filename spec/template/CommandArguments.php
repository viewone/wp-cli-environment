<?php

class Environment_Command extends WP_CLI_Command
{

    /**
     * Execute WP-CLI against configuration for a given environment
     *
     * <core>
     *
     * <download>
     *
     *
     * @when before_wp_load
     */
    public function __invoke($args, $assoc_args)
    {
        global $argv;

        try {
            \ViewOne\WPCLIEnvironment\Environment::run($argv[1]);
        } catch (Exception $e) {
            \WP_CLI::error( $e->getMessage() );
        }

        $command = \ViewOne\WPCLIEnvironment\Command::getCommand($args, $assoc_args);

        WP_CLI::launch($command);
    }
}
