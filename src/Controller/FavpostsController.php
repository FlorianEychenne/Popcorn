<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[IsGranted("ROLE_USER")]
class FavpostsController extends AbstractController
{

    private $managerRegistry; // Stockera l'accès a la base de données

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry; // Applique l'accès a la base de données
    }

    
    #[Route('/add_favposts/{id}', name: 'add_favposts')]
    public function add(int $id): Response
    {
        $em = $this->managerRegistry->getManager();

        $post = $em->getRepository(Post::class)->find($id);

        $post->addFavorite($this->getUser());
        
        $em->persist($post);
        $em->flush();
        
        $this->addFlash('success', 'Le post a bien été ajouté en favoris');
        
        return $this->redirectToRoute('post_view', [
            'id' => $post->getId(),
        ]);
    }

    #[Route('/remove_favpost/{id}', name: 'remove_favposts')]
    public function remove(int $id): Response
    {
        $em = $this->managerRegistry->getManager();
        // On récupère le post qu'on veut ajouter en favoris
        $post = $em->getRepository(Post::class)->find($id);

        $post->removeFavorite($this->getUser());

        $em->persist($post);
        $em->flush();

        $this->addFlash('success', 'Le post a bien été supprimé des favoris');

        return $this->redirectToRoute('post_view', ['id' => $post->getId()]);
    }
}
