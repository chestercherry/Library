<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ApiCrudService
{
    /**
     * @var EntityDenormalizer
     */
    private $serializer;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var string
     */
    private $entityClass;

    /**
     * @var string
     */
    private $type;

    public function __construct(EntityManager $entityManager, $entityClass, $type)
    {
        $this->serializer = new EntityDenormalizer();
        $this->entityManager = $entityManager;
        $this->entityClass = $entityClass;
        $this->type = $type;
    }

    public function create(Request $request): Response
    {
        $entity = $this->serializer->deserialize($request->getContent(), $this->entityClass, $this->type);
        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return new JsonResponse("Unprocessable Entity", 422);
        }
        return new JsonResponse($this->serializer->serialize($entity, $this->type));
    }

    public function read(Request $request, $id): Response
    {
        $object = $this->entityManager->getRepository($this->entityClass)->find($id);
        return new JsonResponse($this->serializer->serialize($object, $this->type));
    }

    public function readAll(Request $request): Response
    {
        $objects = $this->entityManager->getRepository($this->entityClass)->findAll();
        return new JsonResponse($this->serializer->serialize($objects, $this->type));
    }

    public function update(Request $request, $id): Response
    {
        $object = $this->entityManager->getRepository($this->entityClass)->find($id);
        $this->serializer->deserialize($request->getContent(), $this->entityClass, $this->type, [AbstractNormalizer::OBJECT_TO_POPULATE => $object]);
        return new JsonResponse($this->serializer->serialize($object, $this->type));

    }

    public function delete(Request $request, $id): Response
    {
        $object = $this->entityManager->getRepository($this->entityClass)->find($id);

        try {
            $this->entityManager->remove($object);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return new JsonResponse("Unprocessable Entity", 422);
        }
        return new JsonResponse($this->serializer->serialize($object, $this->type));
    }
}