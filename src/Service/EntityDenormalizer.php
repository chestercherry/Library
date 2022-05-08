<?php

namespace App\Service;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EntityDenormalizer
{

    private Serializer $serializer;

    public function __construct()
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(), new GetSetMethodNormalizer(), new ArrayDenormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function serialize($object, $type = 'json', $context = []): string
    {
        return $this->serializer->serialize($object, $type, $context);
    }

    public function deserialize($data, $entityClass, $type = 'json', $context = [])
    {
        return $this->serializer->deserialize($data, $entityClass, $type, $context);
    }
}