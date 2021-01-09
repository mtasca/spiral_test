<?php
namespace mtasca\Qudio\Console\Command;

use mtasca\Qudio\Application\Exception\InvalidArgumentException;
use mtasca\Qudio\Application\Service\SpiralService;
use mtasca\Qudio\Console\Application;

class SpiralCreatorCommand extends BaseCommand
{
    const COMMAND_NAME = 'spiral:creator';

    public function __construct(Application $app)
    {
        $this->setCommandName(self::COMMAND_NAME);
        parent::__construct($app);
    }

    public function run(array $parameters) : int
    {
        $arguments = $this->validateArguments($parameters);

        $spiral_service = new SpiralService($arguments['size']);

        $spiral_service->createSquareSpiral($arguments['verbose']);

        printf("\nSquare spiral created successfully. size:%d\n", $arguments['size']);
        $spiral_service->printSpiral();

        return self::COMMAND_SUCCESS;
    }

    private function validateArguments(array $arguments)
    {
        $args = [];
        //validate size
        if(!empty($arguments['size']) && $arguments['size'] > 0 && $arguments['size'] <= 100) {
             $args['size'] = (int) $arguments['size'];
        } else {
            throw new InvalidArgumentException('size must be an integer greater than 0 and lower or equals to 100');
        }

        $verbose = false;
        if(!empty($arguments['verbose'])) {
            $verbose = filter_var($arguments['verbose'],FILTER_VALIDATE_BOOLEAN);
        }
        $args['verbose'] = $verbose;

        return $args;
    }

    public function usage() : string
    {
        return sprintf("%s --size=[int]", $this->getCommandName());
    }
}