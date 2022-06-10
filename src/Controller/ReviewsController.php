<?php

namespace App\Controller;

use App\Entity\Reviews;
use App\Entity\Post;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[IsGranted("ROLE_USER")]
class ReviewsController extends AbstractController
{

    private $managerRegistry; // Stockera l'accès a la base de données

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry; // Applique l'accès a la base de données
    }

    #[Route('/reviews/{id}', name: 'reviews')]
    public function view(int $id): Response
    {
        $em = $this->managerRegistry->getManager();

        $reviews = $em->getRepository(Reviews::class)->find($id);

        $comments = $reviews->getComments();
        

        if(empty($reviews)){
            throw new NotFoundHttpException('Critique introuvable');
        }

        return $this->render('reviews/view.html.twig', [
            'reviews' => $reviews,
            'comments' => $comments,
        ]);
    }

    #[Route('/add-reviews/{id}', name: 'reviews_add')]
    public function add(int $id): Response
    {
        

        $em = $this->managerRegistry->getManager();

        $post = $em->getRepository(Post::class)->find($id);

        $errors = [];

        if(!empty($_POST)){
            $safe = array_map('trim', array_map('strip_tags', $_POST));

            if(strlen($safe['title']) < 10 || strlen($safe['title']) > 600){
                $errors[] = 'Votre titre doit comporter entre 10 et 2000 caractères';
            }

            if(strlen($safe['content']) < 10 || strlen($safe['content']) > 2000){
                $errors[] = 'Votre critique doit comporter entre 10 et 2000 caractères';
            }

            if(isset($safe['note'])){
                if($safe['note'] < 0 || $safe['note'] > 5){
                    $errors[] ='Votre note n\'existe pas';
                }
            } else{
                $errors[] ='Veuillez entrer une note';
            }

            if(count($errors) === 0){
                $em = $this->managerRegistry->getManager();

                $review = new Reviews();
                $review->setTitle($safe['title']);
                $review->setContent($safe['content']);
                $review->setNote($safe['note']);
                $review->setPublishedAt(new DateTime('now'));
                $review->setUser($this->getUser());
                $review->setPost($post);

                $em->persist($review);
                $em->flush();

                $this->addFlash('success', 'Votre critique a bien été enregistrée');
            }
            else {
                $this->addFlash('errors', implode('<br>', $errors));
            }          
        }
        return $this->redirectToRoute('post_view', ['id' => $post->getId()]);
    }
}
