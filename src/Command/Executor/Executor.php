<?php

namespace Deployer\ComandExecutor;

use Deployer\Connection\Remote\Timeout\Exception;

class Executor implements \Deployer\ComandExecutor\ExecuteInterface {

    /**
     * @inheritdoc
     * @param string $comand
     */
    public function execute($comand)
    {
        $result = shell_exec($comand); 
        
        if (!$result)
            throw new \Exception("Cannot resolve the command result");
        if(!shell_exec($comand)){
           throw new \Deployer\ComandExecutor\ExecuteException('Error during command execution');
        } else {
            shell_exec($comand);
            return 'Command Was Succeseffuly Executed';
        }
    }

}