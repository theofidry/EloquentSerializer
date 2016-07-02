<?php

namespace App\Symfony\Serializer\Normalizer;

use App\Symfony\PropertyAccess\EloquentModelPropertyAccessor;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class EloquentModelNormalizer extends AbstractObjectNormalizer
{
    /**
     * @var PropertyAccessorInterface
     */
    protected $propertyAccessor;

    public function __construct(ClassMetadataFactoryInterface $classMetadataFactory = null, NameConverterInterface $nameConverter = null, PropertyAccessorInterface $propertyAccessor = null, PropertyTypeExtractorInterface $propertyTypeExtractor = null)
    {
        parent::__construct($classMetadataFactory, $nameConverter, $propertyTypeExtractor);

        $this->propertyAccessor = $propertyAccessor ?: new EloquentModelPropertyAccessor(PropertyAccess::createPropertyAccessor());
    }

    /**
     * {@inheritdoc}
     *
     * @param Model $object
     */
    protected function extractAttributes($object, $format = null, array $context = array())
    {
        $attributes = $object->getAttributes();
        $object->getHidden();

        foreach ($object->getHidden() as $hiddenAttribute) {
            unset($attributes[$hiddenAttribute]);
        }

        /* @var Model[] $relations */
        $relations = $object->getRelations();
        foreach ($relations as $relationName => $relation) {
            unset($attributes[$relation->getForeignKey()]);
            $attributes[$relationName] = true;
        }

        return array_keys($attributes);
    }

    /**
     * {@inheritdoc}
     */
    protected function getAttributeValue($object, $attribute, $format = null, array $context = array())
    {
        return $this->propertyAccessor->getValue($object, $attribute);
    }

    /**
     * {@inheritdoc}
     */
    protected function setAttributeValue($object, $attribute, $value, $format = null, array $context = array())
    {
        try {
            $this->propertyAccessor->setValue($object, $attribute, $value);
        } catch (NoSuchPropertyException $exception) {
            // Properties not found are ignored
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return is_object($data) && $data instanceof Model;
    }
}
