<?php

// src/Controller/TakeTodoList.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ToDoList;

class TakeTodoList extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $toDoList = $this->getDoctrine()
            ->getRepository(ToDoList::class)
            ->findBy([], ['devName' => 'ASC']);

        return $this->render('base.html.twig', [
            'to_do_list' => $toDoList,
        ]);
    }
}
