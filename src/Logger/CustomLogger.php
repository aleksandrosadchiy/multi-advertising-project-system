<?php

namespace Deployer\Logger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class CustomLogger extends \Monolog\Logger
{

    const LOG_FILE = 'custom.log';

    /** @var array  */
    protected $handlers = array();

    /**
     * CustomLogger constructor.
     * @param string $name
     * @param array $handlers
     * @param array $processors
     */
    public function __construct($name, $handlers = array(), $processors = array())
    {
        /** @var array handlers */
        $this->handlers = array(
            new StreamHandler(PROJECT_DIR.'logs/'.self::LOG_FILE, self::DEBUG),
            new FirePHPHandler(), new FirePHPHandler()
        );


        parent::__construct($name, $this->handlers, $processors);
    }
}