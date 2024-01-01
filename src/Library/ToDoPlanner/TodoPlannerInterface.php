<?php

namespace App\Library\ToDoPlanner;

interface TodoPlannerInterface
{
    public function setMapping(array $mapping): void;
    public function getTasks(): void;
    public function saveTasks(): void;
    public function setServerUrl(string $serverUrl): void;
}
