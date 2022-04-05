<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Serializer;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as BaseSerializer;
use Symfony\Component\Serializer\SerializerInterface;

final class Serializer implements SerializerInterface
{
    private SerializerInterface $serializer;

    public function __construct()
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);

        $encoder = [new JsonEncoder()];
        $extractor = new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()]);
        $normalizer = [
            new ArrayDenormalizer(),
            new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter, null, $extractor),
        ];

        $this->serializer = new BaseSerializer($normalizer, $encoder);
    }

    public function serialize(
        $data,
        string $format,
        array $context = []
    ): string
    {
        return $this->serializer->serialize($data, $format, $context);
    }

    public function deserialize(
        $data,
        string $type,
        string $format,
        array $context = []
    )
    {
        return $this->serializer->deserialize($data, $type, $format, $context);
    }
}
