<?php
namespace mtasca\Qudio\Console;

use mtasca\Qudio\Application\Exception\CommandNotFoundException;
use mtasca\Qudio\Console\Command\SpiralCreatorCommand;

class Application
{
    private $commands;

    public function __construct()
    {
        $this->setCommands();
    }

    public function runCommand(string $name, array $parameters = [])
    {
        if(empty($name)) {
            $this->printError("command name is required");
            exit(1);
        }
        try {
            $command = $this->getCommand($name);
            printf("\nRunning Command: %s\n", $command->getCommandName());
        } catch (CommandNotFoundException $e) {
            $this->printError(sprintf("command '%s' not found", $name));
            exit(1);
        }

        try {
            $command->run($parameters);
        } catch (\DomainException $e) {
            printf("\nUsage: %s\n", $command->usage());
            $this->printError($e->getMessage());
        }

        exit(0);
    }

    private function getCommand($name)
    {
        if(isset($this->commands[$name])) {
            return $this->commands[$name];
        }

        throw new CommandNotFoundException("command not found");
    }

    private function setCommands()
    {
        $this->commands[SpiralCreatorCommand::COMMAND_NAME] = new SpiralCreatorCommand($this);
    }

    private function printError($error)
    {
        printf("\nERROR: %s\n", $error);
    }

}