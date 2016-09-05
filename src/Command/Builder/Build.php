<?php

namespace Deployer\Command\Builder;

interface Build {

    const SUDO_USER = 'sudo';

    /**
     * @param string $program
     * @param string $command
     * @param array $args
     * @return string
     * @throws InvalidInputException | \InvalidArgumentException
     */
    public function build($program, $command, $args = []);

    /**
     * @param bool $flag
     * @return void
     */
    public function useSudo($flag);
}