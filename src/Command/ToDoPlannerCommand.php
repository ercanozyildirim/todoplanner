<?php

namespace App\Command;

use App\Entity\ToDoList;
use App\Library\ToDoPlanner\ToDoPlannerAdapter;
use App\Library\ToDoPlanner\ToDoPlannerMapping;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;

class ToDoPlannerCommand extends Command
{
    protected static $defaultName = 'ToDoPlanner';
    protected static $defaultDescription = 'Takes the task lists.';
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $providerList = [
            [
                'serverUrl' => 'https://run.mocky.io/v3/27b47d79-f382-4dee-b4fe-a0976ceda9cd',
                'mapping' => new ToDoPlannerMapping('id', 'sure', 'zorluk')
            ],
            [
                'serverUrl' => 'https://run.mocky.io/v3/7b0ff222-7a9c-4c54-9396-0df58e289143',
                'mapping' => new ToDoPlannerMapping('id', 'estimated_duration', 'value')
            ]
        ];

        foreach ($providerList as $provider) {
            $io->writeln('Processing ' . $provider['serverUrl']);

            $adapter = new ToDoPlannerAdapter($provider['serverUrl'], $provider['mapping'], $this->entityManager);
            $adapter->getTasks();
            $adapter->saveTasks();
        }

        $tasks = $adapter->fetchTasks();
        $developers = $adapter->getDevs();

        $this->assignTasks($tasks, $developers);

        return 0;
    }

    private function assignTasks($tasks, $developers)
    {
        $developerHours = array_fill_keys(array_map(function ($dev) {
            return $dev->getId();
        }, $developers), 45);

        foreach ($tasks as $task) {
            foreach ($developers as $developer) {
                if ($task->getDifficulty() <= $developer->getDifficulty() && $developerHours[$developer->getId()] >= $task->getDuration()) {
                    $developerHours[$developer->getId()] -= $task->getDuration();

                    $toDoEntry = new ToDoList();
                    $toDoEntry->setTaskName($task->getTaskName());
                    $toDoEntry->setDevName($developer->getDevName());
                    $toDoEntry->setTaskDifficulty($task->getDifficulty());
                    $toDoEntry->setTaskDuration($task->getDuration());
                    $toDoEntry->setTotalEffort($task->getDuration() * $task->getDifficulty());
                    $this->entityManager->persist($toDoEntry);

                    break;
                }
            }
        }

        $this->entityManager->flush();
    }

}
