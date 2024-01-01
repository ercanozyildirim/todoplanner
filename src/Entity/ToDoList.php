<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ToDoListRepository")
 */
class ToDoList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $taskName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $devName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $taskDuration;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $taskDifficulty;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $totalEffort;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTaskName()
    {
        return $this->taskName;
    }

    /**
     * @param mixed $taskName
     */
    public function setTaskName($taskName): void
    {
        $this->taskName = $taskName;
    }

    /**
     * @return mixed
     */
    public function getDevName()
    {
        return $this->devName;
    }

    /**
     * @param mixed $devName
     */
    public function setDevName($devName): void
    {
        $this->devName = $devName;
    }

    /**
     * @return mixed
     */
    public function getTaskDuration()
    {
        return $this->taskDuration;
    }

    /**
     * @param mixed $taskDuration
     */
    public function setTaskDuration($taskDuration): void
    {
        $this->taskDuration = $taskDuration;
    }

    /**
     * @return mixed
     */
    public function getTaskDifficulty()
    {
        return $this->taskDifficulty;
    }

    /**
     * @param mixed $taskDifficulty
     */
    public function setTaskDifficulty($taskDifficulty): void
    {
        $this->taskDifficulty = $taskDifficulty;
    }

    /**
     * @return mixed
     */
    public function getTotalEffort()
    {
        return $this->totalEffort;
    }

    /**
     * @param mixed $totalEffort
     */
    public function setTotalEffort($totalEffort): void
    {
        $this->totalEffort = $totalEffort;
    }

}
