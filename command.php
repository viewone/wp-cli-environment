<?php

if ( !defined( 'WP_CLI' ) ) return;

class Environment_Command extends WP_CLI_Command {

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
    public function __invoke( $args, $assoc_args ) {

        global $argv;

        array_walk($argv, function ($arg, $key) use (&$assoc_args)
        {
            if(preg_match('/^--([a-z]+)\=([a-zA-Z0-9]+)/', $arg, $match) == 1){
              $assoc_args[$match[1]] = $match[2];
            }
        });

        // Get your configuration values and merge with $assoc_args
        $command = "wp " . implode( " ", $args );
        foreach( $assoc_args as $key => $value ) {
            $command .= " --{$key}={$value}";
        }

        WP_CLI::launch( $command );
    }
}

WP_CLI::add_command( 'local', 'Environment_Command' );
WP_CLI::add_command( 'development', 'Environment_Command' );
WP_CLI::add_command( 'production', 'Environment_Command' );
WP_CLI::add_command( 'staging', 'Environment_Command' );
WP_CLI::add_command( 'testing', 'Environment_Command' );
