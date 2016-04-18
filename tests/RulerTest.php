<?php

namespace Test;

use Doctrine\Common\Collections\ExpressionBuilder;
use Ruler\Ruler;
use Symfony\Component\ExpressionLanguage\Expression;

class RulerTest extends \PHPUnit_Framework_TestCase
{
    public function testBasicArrayRules()
    {
        $ruler = new Ruler();

        $expr = new ExpressionBuilder();

        $ruler->add($expr->eq('someField', 123), 'abc');

        $context = ['someField' => 123];

        $this->assertSame('abc', $ruler->process($context));
    }

    public function testNestedArrayRules()
    {
        $ruler = new Ruler();

        $expr = new ExpressionBuilder();

        $ruler->add($expr->eq('[someField][other]', 'testing'), 'abc');

        $context = ['someField' => ['other' => 'testing']];

        $this->assertSame('abc', $ruler->process($context));
    }

    public function testOrArrayRules()
    {
        $ruler = new Ruler();

        $expr = new ExpressionBuilder();

        $ruler->add($expr->orX($expr->eq('someField', 'abc'), $expr->eq('someField', 'def')), 'ghi');

        $context = ['someField' => 'def'];

        $this->assertSame('ghi', $ruler->process($context));
    }

    public function testExpressionStringRules()
    {
        $ruler = new Ruler();

        $ruler->add('someField["other"] == "one"', 'two');

        $context = ['someField' => ['other' => 'one']];

        $this->assertSame('two', $ruler->process($context));
    }

    public function testExpressionRules()
    {
        $ruler = new Ruler();

        $ruler->add(new Expression('someField.other == "six"'), 'seven');

        $context = ['someField' => (object) ['other' => 'six']];

        $this->assertSame('seven', $ruler->process($context));
    }

    public function testNoRules()
    {
        if (method_exists($this, 'expectException')) {
            $this->expectException('Ruler\Exception\InvalidRuleException');
            $this->expectExceptionMessage('No rules matched');
        } else {
            $this->setExpectedException('Ruler\Exception\InvalidRuleException', 'No rules matched');
        }

        $ruler = new Ruler();

        $ruler->add('someField == "abc"', 'nothing');

        $context = ['someField' => 'def'];

        $ruler->process($context);
    }

    public function testMultipleRules()
    {
        $ruler = new Ruler();

        $ruler->add('someField == "123"', 'abc');
        $ruler->add('someField == "456"', 'DEF');

        $context = ['someField' => 456];

        $this->assertSame('DEF', $ruler->process($context));
    }

    public function testCallback()
    {
        $ruler = new Ruler();

        $ruler->add('someField == "abc"', function () {
            return 123;
        });

        $context = ['someField' => 'abc'];

        $this->assertSame(123, $ruler->process($context));
    }
}