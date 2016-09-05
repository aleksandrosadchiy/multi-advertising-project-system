<?php

namespace Deployer\Block;

abstract class AbstractBlock
{
    /** @var  array */
    private $arguments = [];

    /** @var array  */
    private $templates = [];

    /** @var   */
    private $templatesDir = __DIR__;

    /**
     * @param $arguments
     */
    public function setArguments($arguments) {
        $this->arguments = $arguments;
    }

    public function setTemplatesDir($dir)
    {
        $this->templatesDir = $dir;
    }

    public function findTemplates($result)
    {
        if (isset($result["_templates"])) {
            $this->templates = explode("\n", $result["_templates"]);
        }
    }

    /**
     * @param $templates
     */
    public function setTemplates($templates)
    {
        $this->templates = $templates;
    }

    /**
     * @return string
     */
    public function toHtml()
    {
        ob_start();
        extract($this->arguments);

        foreach ($this->templates as $template) {
            $template = $this->templatesDir . DIRECTORY_SEPARATOR . trim($template);
            if (file_exists($template) && is_readable($template)) {
                include $template;
            }
        }

        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}