<?php

namespace spec\ViewOne\WPCLIEnvironment;

require_once __DIR__ . '/../../../vendor/autoload.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GeneratorSpec extends ObjectBehavior
{

    public function it_should_return_wp_cli_cache_dir()
    {
        $home = getenv('HOME');

        if ( !$home ) {
            $home = getenv('HOMEDRIVE') . '/' . getenv('HOMEPATH');
        }

        $dir = getenv('WP_CLI_CACHE_DIR') ? : "$home/.wp-cli/cache";

        $this->getCachePath()->shouldReturn($dir);
    }

    public function it_should_generate_proper_command_class_with_arguments()
    {

        global $argv;

        $args = array('local', 'core', 'download');

        $argv = $args;

        \ViewOne\WPCLIEnvironment\Generator::generateCommandClass();

        $test_class = file_get_contents(__DIR__ . '/../../template/CommandArguments.php');

        $this->shouldHaveGenerateFile($test_class);
    }

    public function it_should_generate_proper_command_class_with_arguments_and_parameters()
    {

        global $argv;

        $args = array('local', 'core', 'download', '--path=wordpress', '--force');

        $argv = $args;

        \ViewOne\WPCLIEnvironment\Generator::generateCommandClass();

        $test_class = file_get_contents(__DIR__ . '/../../template/CommandArgumentsParameters.php');

        $this->shouldHaveGenerateFile($test_class);
    }

    public function getMatchers()
    {
        return array(
            'haveGenerateFile' => function($subject, $file) {

                $dir = \ViewOne\WPCLIEnvironment\Generator::getCachePath();

                $generatedClass = file_get_contents($dir . '/wp-cli-environment/Command.php');
                return $generatedClass === $file;
            },
        );
    }
}
