<?php

namespace spec\ViewOne;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EnvironmentSpec extends ObjectBehavior
{

    public function it_should_set_WP_CLI_CONFIG_PATH_to_wp_cli_production_yml_if_there_is_production_as_argument()
    {

        $env = "production";
        $cwd = getcwd();

        $config = $cwd . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'wp-cli.' . $env . '.yml';

        if(!file_exists(dirname($config))){
            mkdir(dirname($config), 0777, true);
            touch($config);
        }

        $this->run($env);
        $this->shouldHaveEnv($cwd . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "wp-cli." . $env . ".yml");

        unlink($config);
        rmdir(dirname($config));
    }

    public function it_should_throw_exception_if_there_is_no_such_a_file()
    {

        $cwd = getcwd();
        $env = "testing";

        $this->shouldThrow(new \Exception('File ' . $cwd . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "wp-cli." . $env . ".yml" . ' doesn\'t exists.'))->duringRun($env);
    }

    public function it_should_throw_exception_if_argument_is_not_string_or_null()
    {

        $cwd = getcwd();
        $obj = new \stdClass();

        $this->shouldThrow(new \Exception('$environment should be string or null insted of ' . gettype($obj) . '.'))->duringRun($obj);
    }

    public function it_should_not_break_if_there_is_no_environment_argument()
    {

        $this->shouldNotThrow('\Exception')->duringRun(null);
    }

    public function getMatchers()
    {
        return array(
            'haveEnv' => function($subject, $env) {
                return getenv('WP_CLI_CONFIG_PATH') === $env;
            },
        );
    }
}
