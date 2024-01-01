<?php

namespace App\Library\ToDoPlanner;

class ToDoPlannerMapping
{
    protected $taskName;
    protected $duration;
    protected $difficulty;

    public function __construct($taskName, $duration, $difficulty)
    {
        $this->taskName = $taskName;
        $this->duration = $duration;
        $this->difficulty = $difficulty;
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
    public function setTaskName($taskName): ToDoPlannerMapping
    {
        $this->taskName = $taskName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * @param mixed $difficulty
     */
    public function setDifficulty($difficulty): ToDoPlannerMapping
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration): ToDoPlannerMapping
    {
        $this->duration = $duration;

        return $this;
    }
}
