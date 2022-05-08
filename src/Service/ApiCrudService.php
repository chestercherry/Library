<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ApiCrudService
{
    /**
     * @var EntityDenormalizer
     */
    private EntityDenormalizer $serializer;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var string
     */
    private string $entityClass;

    /**
     * @var string
     */
    private string $type;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->serializer = new EntityDenormalizer();
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $entityClass
     */
    public function setEntityClass(string $entityClass): void
    {
        $this->entityClass = $entityClass;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @param Request $request
     * @return Response
     */
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

    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function read(Request $request, $id): Response
    {
        $object = $this->entityManager->getRepository($this->entityClass)->find($id);
        return new JsonResponse($this->serializer->serialize($object, $this->type));
    }

    /**
     * @return array
     */
    public function readAll(): array
    {
        return $this->entityManager->getRepository($this->entityClass)->findAll();
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id): Response
    {
        $object = $this->entityManager->getRepository($this->entityClass)->find($id);
        $this->serializer->deserialize($request->getContent(), $this->entityClass, $this->type, [AbstractNormalizer::OBJECT_TO_POPULATE => $object]);
        return new JsonResponse($this->serializer->serialize($object, $this->type));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function delete(Request $request, $id): Response
    {
        $object = $this->entityManager->getRepository($this->entityClass)->find($id);

        try {
            $this->entityManager->remove($object);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return new JsonResponse("Unprocessable Entity", 422);
        }

        return new JsonResponse("Success", 201);
    }
}