<?php

namespace SoftLoft\SmsIntegration\Test\Unit;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use SoftLoft\SmsIntegration\Model\MessageProcessor\SmsMessageProcessor;

class TestSmsMessageProcessor extends TestCase
{
    /**
     * @var SmsMessageProcessor
     */
    protected $sampleClass;

    public function setUp():void
    {
        $objectManager = new ObjectManager($this);
        $this->sampleClass = $objectManager->getObject('SoftLoft\SmsIntegration\Model\MessageProcessor\SmsMessageProcessor');
    }

    public function testNotEmptyProcess()
    {
        $this->assertNotEmpty($this->sampleClass->process());
    }
}
