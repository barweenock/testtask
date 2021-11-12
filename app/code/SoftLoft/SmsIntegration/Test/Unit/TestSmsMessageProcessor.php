<?php

namespace SoftLoft\SmsIntegration\Test\Unit;

class TestSmsMessageProcessor extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \SoftLoft\SmsIntegration\Model\MessageProcessor\SmsMessageProcessor
     */
    protected $sampleClass;

    public function setUp():void
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->sampleClass = $objectManager->getObject('SoftLoft\SmsIntegration\Model\MessageProcessor\SmsMessageProcessor');
    }

    public function testNotEmptyProcess()
    {
        $this->assertNotEmpty($this->sampleClass->process());
    }
}
