<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Post;
use App\Entity\Reviews;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted("ROLE_USER")]
class PostController extends AbstractController
{

    private $managerRegistry; // Stockera l'accès a la base de données


    /******************************************
     * /!\ Mes catégories de film, 
     * si modification, la reporter sur la bdd
     ******************************************/
    public $categories = [
        'Thriller'          => 'Thriller',
        'Comédie'           => 'Comédie',
        'SF'                => 'SF',
        'Drame'             => 'Drame',
        'Animation'         => 'Animation',
        'Horreur'           => 'Horreur',
        'Romance'           => 'Romance',
        'Aventure'          => 'Aventure',
        'Action'            => 'Action',
        'Fantastique'       => 'Fantastique',
        'Documentaire'      => 'Documentaire',
    ];



    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry; // Applique l'accès a la base de données
    }

    #[Route('/list', name: 'posts')]
    public function list(): Response
    {
        $em = $this->managerRegistry->getManager();

        $posts = $em->getRepository(Post::class)->findBy([], ['published_at' => 'DESC']);

        return $this->render('post/list.html.twig', [
            'posts' => $posts,
            'categories' => $this->categories
        ]);
    }

    #[Route('/details-de-post/{id}', name: 'post_view')]
    public function view(int $id): Response
    {
        $em = $this->managerRegistry->getManager();

        $post = $em->getRepository(Post::class)->find($id);

        $reviews = $post->getReviews();

        $comments = $post->getComments();

        $favposts = $this->getUser()->getFavposts();
        
        $currentUser = $this->getUser();

        if (empty($post)) {
            throw new NotFoundHttpException('Film/série introuvable');
        }

        return $this->render('post/view.html.twig', [
            'post' => $post,
            'reviews' => $reviews,
            'comments' => $comments,
            'favposts' => $favposts,
            'currentUser' => $currentUser
        ]);
    }

    /**
     * Ajouter un post
     */

    #[Route('/ajouter-un-post', name: 'post_add')]
    #[IsGranted("ROLE_ADMIN")]
    public function add(): Response
    {
        $errors = [];

        if (!empty($_POST)) {


            // On nettoies les données en cas de champs à choix multiple (catégorie ici)
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    $safe[$key] = array_map('trim', array_map('strip_tags', $value));
                } else {
                    $safe[$key] = trim(strip_tags($value));
                }
            }
            

            if (strlen($safe['title']) < 1 || strlen($safe['title']) > 100) {
                $errors[] = 'Votre titre doit comporter entre 1 et 100 caractères';
            }
            if (strlen($safe['synopsis']) < 10 || strlen($safe['synopsis']) > 5000) {
                $errors[] = 'Votre synopsis doit comporter entre 10 et 5000 caractères';
            }

            if (strlen($safe['director']) < 5 || strlen($safe['director']) > 80) {
                $errors[] = 'Le nom de réalisateur doit comporter entre 5 et 80 caractères';
            }

            if (strlen($safe['actors']) < 5 || strlen($safe['actors']) > 100) {
                $errors[] = 'Les noms des acteurs doivent comporter entre 5 et 100 caractères';
            }

            if (!empty($safe['released_at'])) {
                $date_release = explode('-', $safe['released_at']);
                if (!checkdate($date_release[1], $date_release[2], $date_release[0])) {
                    $errors[] = 'La date de sortie est invalide';
                }
            } else {
                $errors[] = 'La date de sortie est obligatoire';
            }


            if (!empty($_FILES) && $_FILES['image']['error'] == 0) {

                $to = $_SERVER['DOCUMENT_ROOT'] . '/uploads/covers/';
                $tmp_name = $_FILES["image"]["tmp_name"];
                $name = basename($_FILES["image"]["name"]);
                move_uploaded_file($tmp_name, "$to/$name");
            }

            if (count($errors) === 0) {
                $em = $this->managerRegistry->getManager();

                $post = new Post();
                $post->setTitle($safe['title']);
                $post->setSynopsis($safe['synopsis']);
                $post->setUser($this->getUser());
                $post->setDirector($safe['director']);
                $post->setActors($safe['actors']);
                $post->setImage($name);
                $post->setVideo($safe['video']);
                $post->setCategories($safe['category']);
                $post->setReleasedAt(new \DateTime($safe['released_at']));
                $post->setPublishedAt(new \DateTime('now')); // Applique une datetime à l'instant T


                $em->persist($post);
                $em->flush();

                $this->addFlash('success', 'Votre post a bien été enregistrée');
            } else {
                $this->addFlash('errors', implode('<br>', $errors));
            }
        }

        return $this->render('post/add.html.twig', [
            'categories' => $this->categories
        ]);
    }

    /**
     * Modifier un post
     */
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/modifier-un-post/{id}', name: 'post_edit')]
    public function edit(int $id): Response
    {
        $errors = [];

        $em = $this->managerRegistry->getManager();

        $post = $em->getRepository(Post::class)->find($id); // Permet de récupérer le post donné en id        

        if (!empty($_POST)) {


            // On nettoies les données en cas de champs à choix multiple (catégorie ici)
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    $safe[$key] = array_map('trim', array_map('strip_tags', $value));
                } else {
                    $safe[$key] = trim(strip_tags($value));
                }
            }


            if (strlen($safe['title']) < 4 || strlen($safe['title']) > 100) {
                $errors[] = 'Votre titre doit comporter entre 4 et 100 caractères';
            }
            if (strlen($safe['synopsis']) < 10 || strlen($safe['synopsis']) > 5000) {
                $errors[] = 'Votre synopsis doit comporter entre 10 et 5000 caractères';
            }

            if (strlen($safe['director']) < 5 || strlen($safe['director']) > 80) {
                $errors[] = 'Le nom de réalisateur doit comporter entre 5 et 80 caractères';
            }

            if (strlen($safe['actors']) < 5 || strlen($safe['actors']) > 100) {
                $errors[] = 'Les noms des acteurs doivent comporter entre 5 et 100 caractères';
            }

            if (!empty($safe['released_at'])) {
                $date_release = explode('-', $safe['released_at']);
                if (!checkdate($date_release[1], $date_release[2], $date_release[0])) {
                    $errors[] = 'La date de sortie est invalide';
                }
            } else {
                $errors[] = 'La date de sortie est obligatoire';
            }

            if (!empty($_FILES['image']['tmp_name'])) {
                if ($_FILES['image']['error'] == 4) {
                    $errors[] = 'Ajouter une affiche du film (jpg, jpeg, png)';
                } else{
                    $to = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
                    $tmp_name = $_FILES["image"]["tmp_name"];
                    $name = basename($_FILES["image"]["name"]);
                    move_uploaded_file($tmp_name, "$to/$name");
                }
            }else{
                $name = $post->getImage();
            }


            if (!isset($safe['category'])) {
                $errors[] = 'Veuillez sélectionner une catégorie';
            } /*elseif (!in_array($safe[$key], array_keys($this->categories))) {
                $errors[] = 'Votre catégorie sélectionnée n\'existe pas';
            }*/


            if (count($errors) === 0) {
                $em = $this->managerRegistry->getManager();

                $post->setTitle($safe['title']);
                $post->setSynopsis($safe['synopsis']);
                $post->setUser($this->getUser());
                $post->setDirector($safe['director']);
                $post->setActors($safe['actors']);
                $post->setImage($name);
                $post->setVideo($safe['video']);
                $post->setCategories($safe['category']);
                $post->setReleasedAt(new \DateTime($safe['released_at']));
                $post->setPublishedAt(new \DateTime('now')); // Applique une datetime à l'instant T


                $em->persist($post);
                $em->flush();

                $this->addFlash('success', 'Votre post a bien été modifiée');
            } else {
                $this->addFlash('errors', implode('<br>', $errors));
            }
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'categories' => $this->categories
        ]);
    }


    /**
     * Supprimer un post
     */
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/supprimer-un-post/{id}', name: 'post_delete')]
    public function delete(int $id): Response
    {
        $em = $this->managerRegistry->getManager();

        $post = $this->managerRegistry->getRepository(Post::class)->find($id);

        if (!empty($_GET)) {
            if (isset($_GET['submit'])) {

                $em->remove($post);
                $em->flush();
                $this->addFlash('success', 'Le post a été supprimé');
                return $this->redirectToRoute('posts');
            }
        }
        return $this->render('post/delete.html.twig', [
            'post' => $post
        ]);
    }

    #[Route('/news', name: 'news')]
    public function news(): Response
    {
        $em = $this->managerRegistry->getManager();
        $posts = $em->getRepository(Post::class)->findBy([], ['published_at' => 'DESC']);
        $comments = $em->getRepository(Comments::class)->findAll();

        $currentUser = $this->getUser();

        $mesAbonnements = $currentUser->getAbonnements();

        foreach ($mesAbonnements as $abonnement) {
            $reviewsAbonnements[] = $abonnement->getReviews();
        }

        $favposts = $currentUser->getFavposts();
        foreach ($favposts as $favpost) {
            $favReviews[] = $favpost->getReviews();
        }

        // Tableau favReviews with date keys
        if (!empty($favReviews)) {
            foreach ($favReviews as $value) {
                foreach ($value as $val) {
                    $date = $val->getPublishedAt()->format('Y-m-d H:i:s');
                    $favReviewsDateKeys[strtotime($date)] = [
                        'type' => 'favReview',
                        'value' => $val
                    ];
                }
            }
        } else {
            $favReviewsDateKeys = [];
        }

        // Tableau reviews with date keys
        if (!empty($reviewsAbonnements)) {
            foreach ($reviewsAbonnements as $value) {
                foreach ($value as $val) {
                    $date = $val->getPublishedAt()->format('Y-m-d H:i:s');
                    $reviewsDateKeys[strtotime($date)] = [
                        'type' => 'review',
                        'value' => $val
                    ];
                }
            }
        } else {
            $reviewsDateKeys= [];
        }

        // Tableau posts with date keys
        foreach ($posts as $value) {
            $dates = $value->getPublishedAt()->format('Y-m-d H:i:s');
            $postDateKeys[strtotime($dates)] = [
                'type' => 'post',
                'value' => $value
            ];
        }

        $flux = $reviewsDateKeys + $postDateKeys + $favReviewsDateKeys;

        krsort($flux);

        return $this->render('post/news.html.twig', [
            'flux' => $flux,
            'comments' => $comments,
            'currentDate' => new \DateTime('now')
        ]);
    }
}
