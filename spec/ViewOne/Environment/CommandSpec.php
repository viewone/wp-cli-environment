<?php

namespace spec\ViewOne\Environment;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandSpec extends ObjectBehavior
{

    public function it_should_return_proper_command()
    {
        global $argv;

        $args = array('local', 'core', 'download');

        $argv = $args;

        $this->getCommand('local')->shouldReturn('wp core download');
    }

    public function it_should_return_proper_command_with_parameters()
    {
        global $argv;

        global $argv;

        $args = array('local', 'core', 'download', '--path=wordpress', '--url=http://example.org', '--force');

        $argv = $args;

        $this->getCommand('local')->shouldReturn('wp core download --path=wordpress --url=http://example.org --force');
    }
}
