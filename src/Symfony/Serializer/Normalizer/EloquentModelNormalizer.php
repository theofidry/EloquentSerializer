<?php

namespace Fidry\EloquentSerializer\Symfony\Serializer\Normalizer;

use Fidry\EloquentSerializer\Symfony\PropertyAccess\EloquentModelPropertyAccessor;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class EloquentModelNormalizer extends ObjectNormalizer
{
    /**
     * @var PropertyAccessorInterface
     */
    protected $propertyAccessor;

    public function __construct(
        ClassMetadataFactoryInterface $classMetadataFactory = null,
        NameConverterInterface $nameConverter = null,
        PropertyAccessorInterface $propertyAccessor = null,
        PropertyTypeExtractorInterface $propertyTypeExtractor = null
    ) {
        if (null === $propertyAccessor) {
            $propertyAccessor = new EloquentModelPropertyAccessor(PropertyAccess::createPropertyAccessor());
        }
        
        parent::__construct($classMetadataFactory, $nameConverter, $propertyAccessor, $propertyTypeExtractor);
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
     * @inheritdoc
     */
    public function supportsNormalization($data, $format = null)
    {
        return is_object($data) && $data instanceof Model;
    }
}
