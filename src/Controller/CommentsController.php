<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Reviews;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted("ROLE_USER")]
class CommentsController extends AbstractController
{

    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry; 
    }

    #[Route('/add-comments/{id}', name: 'comments_add')]
    public function add(int $id): Response
    {

        $em = $this->managerRegistry->getManager();

        $review = $em->getRepository(Reviews::class)->find($id);
        
        $post = $review->getPost();

        $errors = [];

        if(!empty($_POST)){
            $safe = array_map('trim', array_map('strip_tags', $_POST));

            if(strlen($safe['content']) < 10 || strlen($safe['content']) > 2000){
                $errors[] = 'Votre commentaire doit comporter entre 10 et 2000 caractères';
            }

            if(count($errors) === 0){
                $em = $this->managerRegistry->getManager();

                $comment = new Comments();
                $comment->setContent($safe['content']);
                $comment->setPublishedAt(new DateTime('now'));
                $comment->setReview($review);
                $comment->setPost($post);
                $comment->setUser($this->getUser());

                $em->persist($comment);
                $em->flush();

                $this->addFlash('success', 'Votre commentaire a bien été enregistrée');
            }
            else {
                $this->addFlash('errors', implode('<br>', $errors));
            }          
        }
        return $this->redirectToRoute('post_view', ['id' => $post->getId()]);
    }

    #[Route('/add-comments-news/{id}', name: 'comments_add_news')]
    public function addnews(int $id): Response
    {

        $em = $this->managerRegistry->getManager();

        $review = $em->getRepository(Reviews::class)->find($id);
        
        $post = $review->getPost();

        $errors = [];

        if(!empty($_POST)){
            $safe = array_map('trim', array_map('strip_tags', $_POST));

            if(strlen($safe['content']) < 2 || strlen($safe['content']) > 2000){
                $errors[] = 'Votre commentaire doit comporter entre 2 et 2000 caractères';
            }

            if(count($errors) === 0){
                $em = $this->managerRegistry->getManager();

                $comment = new Comments();
                $comment->setContent($safe['content']);
                $comment->setPublishedAt(new DateTime('now'));
                $comment->setReview($review);
                $comment->setPost($post);
                $comment->setUser($this->getUser());

                $em->persist($comment);
                $em->flush();

                $this->addFlash('success', 'Votre commentaire a bien été enregistrée');
            }
            else {
                $this->addFlash('errors', implode('<br>', $errors));
            }          
        }
        return $this->redirectToRoute('news');
    }
    #[Route('/add-comments-profile/{id}', name: 'comments_add_profile')]
    public function addprofile(int $id): Response
    {

        $em = $this->managerRegistry->getManager();

        $review = $em->getRepository(Reviews::class)->find($id);
        
        $post = $review->getPost();

        $user = $review->getUser();

        $errors = [];

        if(!empty($_POST)){
            $safe = array_map('trim', array_map('strip_tags', $_POST));

            if(strlen($safe['content']) < 10 || strlen($safe['content']) > 2000){
                $errors[] = 'Votre commentaire doit comporter entre 10 et 2000 caractères';
            }

            if(count($errors) === 0){
                $em = $this->managerRegistry->getManager();

                $comment = new Comments();
                $comment->setContent($safe['content']);
                $comment->setPublishedAt(new DateTime('now'));
                $comment->setReview($review);
                $comment->setPost($post);
                $comment->setUser($this->getUser());

                $em->persist($comment);
                $em->flush();

                $this->addFlash('success', 'Votre commentaire a bien été enregistrée');
            }
            else {
                $this->addFlash('errors', implode('<br>', $errors));
            }          
        }
        return $this->redirectToRoute('user_profile', ['id' => $user->getId()]);
    }
}