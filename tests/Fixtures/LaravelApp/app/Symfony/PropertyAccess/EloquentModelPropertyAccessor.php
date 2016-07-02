<?php

namespace App\Symfony\PropertyAccess;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\PropertyAccess\Exception;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
final class EloquentModelPropertyAccessor implements PropertyAccessorInterface
{
    private $fallback;

    public function __construct(PropertyAccessorInterface $fallback)
    {
        $this->fallback = $fallback;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue(&$objectOrArray, $propertyPath, $value)
    {
        $this->fallback->setValue($objectOrArray, $propertyPath, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getValue($objectOrArray, $propertyPath)
    {
        if (! (is_object($objectOrArray) && $objectOrArray instanceof Model)) {
            return $this->fallback->getValue($objectOrArray, $propertyPath);
        }
        /* @var Model $objectOrArray */
        
        return $objectOrArray->getAttribute($propertyPath);
    }

    /**
     * {@inheritdoc}
     */
    public function isWritable($objectOrArray, $propertyPath)
    {
        return $this->fallback->isWritable($objectOrArray, $propertyPath);
    }

    /**
     * {@inheritdoc}
     */
    public function isReadable($objectOrArray, $propertyPath)
    {
        return $this->fallback->isReadable($objectOrArray, $propertyPath);
    }
    
    public function __clone()
    {
        $this->fallback = clone $this->fallback;
    }
}
