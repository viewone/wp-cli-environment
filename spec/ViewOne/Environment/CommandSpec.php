<?php

namespace spec\ViewOne\Environment;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandSpec extends ObjectBehavior
{

    public function it_should_return_proper_command()
    {
        global $argv;

        $args = array('core', 'download');

        $argv = array();

        $this->getCommand($args, null)->shouldReturn('wp core download');
    }

    public function it_should_return_proper_command_with_parameters()
    {
        global $argv;

        $args       = array('core', 'download');
        $argsAsscoc = array('--path=wordpress', '--url=http://example.org');

        $argv = array_merge($args, $argsAsscoc);

        $this->getCommand($args, null)->shouldReturn('wp core download --path=wordpress --url=http://example.org');
    }
}
