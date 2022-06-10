<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\Post;

class SearchController extends AbstractController
{   
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    #[Route('/search', name: 'search')]
    public function list(): Response
    {
        $em = $this->managerRegistry->getManager();
        
        $users = $em->getRepository(User::class)->search($_GET['search']);
        $posts = $em->getRepository(Post::class)->search($_GET['search']);
        
        $currentDate = new \DateTime();
        
        return $this->render('search/search.html.twig', [
            'users' => $users,
            'posts' => $posts,
            'search' => $_GET['search'],
            'currentDate' => $currentDate
        ]);
    }
}
