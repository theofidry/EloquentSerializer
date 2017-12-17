<?php

/*
 * This file is part of the EloquentSerializer package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fidry\EloquentSerializer\PropertyAccess;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert as PHPUnit;
use Prophecy\Argument;
use ReflectionClass;
use stdClass;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class EloquentModelPropertyAccessorTest extends TestCase
{
    public function testIsAPropertyAccessor()
    {
        PHPUnit::assertTrue(is_a(EloquentModelPropertyAccessor::class, PropertyAccessorInterface::class, true));
    }

    public function testIsNotExtendable()
    {
        $classRefl = new ReflectionClass(EloquentModelPropertyAccessor::class);
        PHPUnit::assertTrue($classRefl->isFinal());
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage You should not clone a service.
     */
    public function testIsNotClonable()
    {
        clone new EloquentModelPropertyAccessor(new FakePropertyAccess());
    }

    public function testDecoratesAPropertyAccessor()
    {
        new EloquentModelPropertyAccessor(new FakePropertyAccess());

        try {
            new EloquentModelPropertyAccessor(new stdClass());
            $this->fail('Expected to fail.');
        } catch (\TypeError $e) {
            // Expected result
        }

        PHPUnit::assertTrue(true);
    }

    /**
     * @dataProvider provideNonModel
     */
    public function testUseDecoratedPropertyAccessorToGetTheValueOfANonModel()
    {
        $object = [];
        $path = 'foo';

        $decoratedAccessorProphecy = $this->prophesize(PropertyAccessorInterface::class);
        $decoratedAccessorProphecy->getValue($object, $path)->willReturn($expected = 'bar');
        /** @var PropertyAccessorInterface $decoratedAccessor */
        $decoratedAccessor = $decoratedAccessorProphecy->reveal();

        $accessor = new EloquentModelPropertyAccessor($decoratedAccessor);
        $actual = $accessor->getValue($object, $path);

        $this->assertSame($expected, $actual);

        $decoratedAccessorProphecy->getValue(Argument::cetera())->shouldHaveBeenCalledTimes(1);
    }

    public function testUseTheModelToGetTheValueOfAModelObject()
    {
        $object = new DummyModel();
        $path = 'foo';

        $accessor = new EloquentModelPropertyAccessor(new FakePropertyAccess());
        $actual = $accessor->getValue($object, $path);

        $expected = 'bar';

        $this->assertSame($expected, $actual);
    }

    public function testUseDecoratedPropertyAccessorToCheckIfAValueIsWriteable()
    {
        $object = [];
        $path = 'foo';

        $decoratedAccessorProphecy = $this->prophesize(PropertyAccessorInterface::class);
        $decoratedAccessorProphecy->isWritable($object, $path)->willReturn($expected = true);
        /** @var PropertyAccessorInterface $decoratedAccessor */
        $decoratedAccessor = $decoratedAccessorProphecy->reveal();

        $accessor = new EloquentModelPropertyAccessor($decoratedAccessor);
        $actual = $accessor->isWritable($object, $path);

        $this->assertSame($expected, $actual);

        $decoratedAccessorProphecy->isWritable(Argument::cetera())->shouldHaveBeenCalledTimes(1);
    }

    public function testUseDecoratedPropertyAccessorToCheckIfAValueIsReadable()
    {
        $object = [];
        $path = 'foo';

        $decoratedAccessorProphecy = $this->prophesize(PropertyAccessorInterface::class);
        $decoratedAccessorProphecy->isReadable($object, $path)->willReturn($expected = true);
        /** @var PropertyAccessorInterface $decoratedAccessor */
        $decoratedAccessor = $decoratedAccessorProphecy->reveal();

        $accessor = new EloquentModelPropertyAccessor($decoratedAccessor);
        $actual = $accessor->isReadable($object, $path);

        $this->assertSame($expected, $actual);

        $decoratedAccessorProphecy->isReadable(Argument::cetera())->shouldHaveBeenCalledTimes(1);
    }

    public function provideNonModel()
    {
        yield 'array' => [[]];
        yield 'stdClass' => [new stdClass()];
    }
}

class DummyModel extends EloquentModel
{
    /**
     * @inheritdoc
     */
    public function getAttribute($key)
    {
        return 'bar';
    }
}
