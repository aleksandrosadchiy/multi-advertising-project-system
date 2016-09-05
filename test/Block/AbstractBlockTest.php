<?php

namespace DeployerTest\Block;

use Deployer\Block\AbstractBlock;

class AbstractBlockTest extends \PHPUnit_Framework_TestCase
{
    /** @var  AbstractBlock */
    private $abstractBlock;

    private $templates;

    public function setUp()
    {
        $this->templates = [
            'a.html' => "1",
            'b.html' => "2"
        ];
        //Hack. Need to use virtual file system
        foreach($this->templates as $template => $content) {
            file_put_contents($template, $content);
        }

        $this->abstractBlock = $this->getMockForAbstractClass(AbstractBlock::class);
        $this->abstractBlock->setTemplates(array_keys($this->templates));
        $rAbstractBlock = new \ReflectionClass(AbstractBlock::class);
        $dirName = $rAbstractBlock->getProperty('templatesDir');
        $dirName->setAccessible(true);
        $dirName->setValue($this->abstractBlock, __DIR__);
    }

    public function testToHtml()
    {
        $html = $this->abstractBlock->toHtml();
        $this->assertEquals("12", $html);
    }

    public function tearDown()
    {
        foreach (array_keys($this->templates) as $template) {
            unlink($template);
        }
        parent::tearDown();
    }
}