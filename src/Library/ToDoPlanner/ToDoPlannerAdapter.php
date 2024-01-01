<?php

namespace App\Library\ToDoPlanner;

use App\Entity\Developer;
use App\Entity\Task;
use App\Library\ToDoPlanner\Exceptions\EmptyMappingException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class ToDoPlannerAdapter implements TodoPlannerInterface
{
    protected $mapping = null;
    protected $serverUrl = '';
    protected $adapter = null;
    protected $headers = [];
    private $client;
    protected $requestMethod = 'GET';
    protected $tasks;
    protected $entityManager;

    public function __construct(string $serverUrl, ToDoPlannerMapping $mapping, EntityManagerInterface $entityManager)
    {
        $this->serverUrl = $serverUrl;
        $this->mapping = $mapping;
        $this->client = HttpClient::create();
        $this->entityManager = $entityManager;
    }

    public function setMapping(array $mapping): void
    {
        $this->mapping = $mapping;
    }

    public function getTasks(): void
    {
        if (empty($this->mapping)) {
            throw new EmptyMappingException('Mapping is empty');
        }

        if (!empty($this->headers)) {
            $this->client->setDefaultOptions([
                'headers' => $this->headers,
            ]);

            $this->requestMethod = 'POST';
        }

        $response = $this->client->request(
            $this->requestMethod,
            $this->serverUrl,
            $this->headers
        );

        $response = json_decode($response->getContent(),1);

        if (empty($response)) {
            throw new EmptyMappingException('Tasks is empty');
        }

        $this->tasks = $response;
    }

    public function saveTasks(): void
    {
        foreach ($this->tasks as $taskData) {
            $task = new Task();
            $task->setTaskName($taskData[$this->mapping->getTaskName()]);
            $task->setDuration($taskData[$this->mapping->getDuration()]);
            $task->setDifficulty($taskData[$this->mapping->getDifficulty()]);

            $this->entityManager->persist($task);
        }

        $this->entityManager->flush();
    }

    public function fetchTasks(): array
    {
        $taskRepository = $this->entityManager->getRepository(Task::class);
        return $taskRepository->findAll();
    }

    public function getDevs(): array
    {
        $taskRepository = $this->entityManager->getRepository(Developer::class);
        return $taskRepository->findAll();
    }

    public function setServerUrl(string $serverUrl): void
    {
        $this->serverUrl = $serverUrl;
    }

    public function get(string $adapter)
    {

        $this->adapter = $adapter;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }
}
