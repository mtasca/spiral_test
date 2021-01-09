<?php


namespace mtasca\Qudio\Console\Command;


use mtasca\Qudio\Console\Application;

abstract class BaseCommand
{
    const COMMAND_SUCCESS = 0;
    const COMMAND_FAIL = 1;

    /**
     * @var Application
     */
    private $app;

    private $command_name;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function setCommandName(string $command_name)
    {
        $this->command_name = $command_name;
    }

    public function getCommandName() : string
    {
        return $this->command_name;
    }

    public abstract function run(array $parameters) : int;
}