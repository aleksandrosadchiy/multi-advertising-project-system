<?php

namespace Deployer\ComandExecutor;

interface ExecuteInterface {

    /**
     * @param string $comand
     * @return mixed
     */
    public function execute($comand);
}