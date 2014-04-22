<?php

if ( !defined( 'WP_CLI' ) ) return;

global $argv;

$env = $argv[1];

$config = array();

$config_path = getenv( 'HOME' ) . '/.wp-cli/config.yml';

if ( is_readable( $config_path ) ){

    $configurator = \WP_CLI::get_configurator();

    $configurator->merge_yml( $config_path );
    list( $config, $extra_config ) = $configurator->to_array();
}

if ( 'auto' === $config['color'] ) {
  $colorize = !\cli\Shell::isPiped();
} else {
  $colorize = $config['color'];
}

if ( isset($config['quiet']) && $config['quiet'] )
    $logger = new \WP_CLI\Loggers\Quiet;
else
    $logger = new \WP_CLI\Loggers\Regular( $colorize );

\WP_CLI::set_logger( $logger );

try {
    $environment = new \ViewOne\Environment();
    $environment->run($env);
} catch (Exception $e) {
    \WP_CLI::error( $e->getMessage() );
}
