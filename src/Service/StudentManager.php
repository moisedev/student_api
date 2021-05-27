<?php
/**
 * Created by PhpStorm.
 * User: Moïse
 * Date: 18/05/2021
 * Time: 14:54
 */
namespace App\Service;

use App\Repository\StudentRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class StudentManager
{
    private $container;
    private $studentRepository;
    private $client;

    /**
     * StudentManager constructor.
     * @param ContainerInterface $container
     * @param StudentRepository $studentRepository
     * @param HttpClientInterface $client
     */
    public function __construct(ContainerInterface $container, StudentRepository $studentRepository, HttpClientInterface $client)
    {
        $this->container         = $container;
        $this->studentRepository = $studentRepository;
        $this->client            = $client;
    }

    /**
     *  fetch all data students from api
     * @return array|mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function fetchStudentFromApi()
    {
        $apiUrl   = $this->container->getParameter('api_url');
        $response = $this->client->request('GET', $apiUrl);

        $results = [];
        if ($response->getStatusCode() == 200) {
            $results = json_decode($response->getContent());
            $this->studentRepository->insertAllStudents($results);
        }
        return $results;
    }
}