<?php

namespace DeployerTest\Builder;


use Deployer\Command\Builder\CommandBuilder;

class CommandBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var  CommandBuilder */
    private $commandBuilder;

    public function setUp()
    {
        $this->commandBuilder = new CommandBuilder();
    }

    /**
     * @expectedException \Deployer\Command\Builder\InvalidInputException
     * @expectedExceptionMessage Invalid input got when trying to build command
     */
    public function testBuildWithInvalidParams()
    {
        $command = "shell";
        $arguments = "arguments and facts:)";

        $this->commandBuilder->build('git', $command, $arguments);
    }

    public function testBuildWithShellGitClone()
    {
        $expectedCommand = "shell git clone ...";

        $this->assertEquals(
            $expectedCommand,
            $this->commandBuilder->build("git clone", "shell", [["code" => "repo", "value" => "..."]])
        );
    }
}