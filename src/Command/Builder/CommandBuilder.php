<?php

namespace Deployer\Command\Builder;

class CommandBuilder implements Build
{
    protected $useSudo = false;

    /**
     * @inheritdoc
     */
    public function useSudo($flag)
    {
        $this->useSudo = $flag;
    }

    /**
     * @inheritdoc
     */
    public function build($program, $command, $args = [])
    {
        return $this->escape($this->_build($program, $command, $args));
    }

    protected function _build($program, $command, $args = [])
    {
        $this->_validateParams($program, $command, $args);

        (strtolower(trim($program)) == 'shell') ? $program = '': null ;

        return $this->useSudo ? self::SUDO_USER . " " : "" .
            $command . " " . $program  . " " . $this->resolveArguments($args);
    }

    protected function _validateParams($program, $command, $args = [])
    {
        if (
            !$this->_programmExists($program) ||
            !$this->_argumentsValid($args)
        ) {
            throw new InvalidInputException("Invalid input got when trying to build command");
        }
    }

    /**
     * @param array $args
     * @return true
     */
    protected function _argumentsValid($args = [])
    {
        return is_array($args);
    }

    /**
     * @param $program
     * @return bool
     */
    protected function _programmExists($program)
    {
        $_result = (strtolower(trim($program)) == 'shell') ? true : shell_exec("which $program");

        return (empty($_result) ? false : true);
    }

    /**
     * code -> value
     * @param array $arguments
     * @return string
     */
    protected function resolveArguments(array $arguments)
    {
        $argumentsRequest = '';
        foreach ($arguments as $argument) {
            if (!isset($argument["code"]))
                throw new \InvalidArgumentException("Argument code should specified");

            $argumentsRequest .= escapeshellarg($argument['code']) . " " .
                isset($argument['value']) ? $argument['value'] :  '';
        }

        return $argumentsRequest;
    }

    /**
     * @param $request
     * @return string
     */
    protected function escape($request)
    {
        return escapeshellcmd(str_replace(['\\', '%'], ['\\\\', '%%'], $request));
    }

}