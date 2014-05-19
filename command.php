<?php

if ( !defined( 'WP_CLI' ) ) return;

require_once __DIR__ . '/src/WPCLIEnvironment/Environment.php';
require_once __DIR__ . '/src/WPCLIEnvironment/Command.php';
require_once __DIR__ . '/src/WPCLIEnvironment/Generator.php';

$dir = \WPCLIEnvironment\Generator::generateCommandClass();
$dir = \WPCLIEnvironment\Generator::getCachePath();

require_once $dir . '/wp-cli-environment/Command.php';

WP_CLI::add_command( 'local', 'Environment_Command' );
WP_CLI::add_command( 'development', 'Environment_Command' );
WP_CLI::add_command( 'production', 'Environment_Command' );
WP_CLI::add_command( 'staging', 'Environment_Command' );
WP_CLI::add_command( 'testing', 'Environment_Command' );
