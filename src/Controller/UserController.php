<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted("ROLE_USER")]
class UserController extends AbstractController
{   
    public $genders = [
        'man' => 'Homme',
        'woman' => 'Femme',
        'other' => 'Autre',
        'null' => 'Ne pas renseigner'
    ];

    public $preferences = [
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
        $this->managerRegistry = $managerRegistry;
    }

    #[Route('/user/account', name: 'user_account')]
    public function details(): Response
    {
        $user = $this->getUser();

        if(empty($user->getPreferences())){
            $preferences = 'Aucune sélectionnée';
        } else{
            $preferences = $user->getPreferences();
        }
        
        if(count($user->getRoles()) == 1){
            $role = 'Membre';
        } else{
            $role = 'Admin';
        }

        $datetime1 = new \DateTime('now');
        $age = $datetime1->diff($user->getBirthday(), true)->y;

        $favposts = $user->getFavposts();
        $abonnes = $user->getAbonnes();
        $abonnements = $user->getAbonnements();

        $numberOfAbonnes = $abonnes->count();
        $numberOfAbonnements = $abonnements->count();
        $numberFavposts = $favposts->count();

        return $this->render('user/account.html.twig', [
            'user'                => $user,
            'preferences'         => $preferences,
            'role'                => $role,
            'age'                 => $age,
            'favposts'            => $favposts,
            'abonnements'         => $abonnements,
            'abonnes'             => $abonnes,
            'numberOfAbonnes'     => $numberOfAbonnes,
            'numberOfAbonnements' => $numberOfAbonnements,
            'numberFavposts'      => $numberFavposts
        ]);
    }

    #[Route('/user/edit', name: 'user_edit')]
    public function edit(): Response
    {   
        $errors = [];
        $user = $this->getUser();

        if(!empty($_POST)){
            
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    $safe[$key] = array_map('trim', array_map('strip_tags', $value));
                } else {
                    $safe[$key] = trim(strip_tags($value));
                }
            }

            if(strlen($safe['firstname']) < 1 || strlen($safe['firstname']) > 40){
                $errors[] = 'Votre prénom doit contenir entre 1 et 40 caractères';
            }

            if(strlen($safe['lastname']) < 1 || strlen($safe['lastname']) > 60){
                $errors[] = 'Votre nom doit contenir entre 1 et 60 caractères';
            }

            if(strlen($safe['username']) < 1 || strlen($safe['username']) > 60){
                $errors[] = 'Votre pseudo doit contenir entre 2 et 20 caractères';
            }

            if (!isset($safe['gender'])) {
                $errors[] = 'Veuillez sélectionner un genre';
            } elseif (!in_array($safe['gender'], $this->genders)) {
                $errors[] = 'Le genre sélectionné n\'existe pas';
            }

            if(!filter_var($safe['email'], FILTER_VALIDATE_EMAIL)){
                $errors[] = 'Cette adresse mail est invalide';
            } elseif(strlen($safe['email']) > 40){
                $errors[] = 'Votre adresse mail doit contenir 40 caractères maximum';
            }

            if(!empty($safe['birthday'])){
                $birthday = explode('-', $safe['birthday']);
                if(!checkdate($birthday[1], $birthday[2], $birthday[0])){
                    $errors[] = 'La date de naissance est invalide';
                }
            } else {
                $errors[] = 'Votre date de naissance est obligatoire';
            }
            
            if(!empty($_FILES['image']['tmp_name'])){
                $to = $_SERVER['DOCUMENT_ROOT'].'/uploads/profilePicture/';
                $tmp_name = $_FILES["image"]["tmp_name"];
                $name = basename($_FILES["image"]["name"]);
                move_uploaded_file($tmp_name, "$to/$name"); 
            }else{
                $name = $user->getProfilePicture();
            }
            
            if(isset($safe['submit']) && count($errors) === 0){
                $em = $this->managerRegistry->getManager();

                $user->setFirstname($safe['firstname']);
                $user->setLastname($safe['lastname']);
                $user->setUsername($safe['username']);
                $user->setGender($safe['gender']);
                $user->setEmail($safe['email']);
                $user->setBirthday(new \DateTime($safe['birthday']));
                $user->setProfilePicture($name);
            
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Vos informations ont bien été modifiées');
            }
            elseif(isset($safe['submit']) && count($errors) != 0){
                $this->addFlash('errors', implode('<br>', $errors));
            }
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'genders' => $this->genders,
            'preferences' => $this->preferences
        ]);
    }

    #[Route('/user/list', name: 'user_list')]
    public function list(): Response
    {
        $em = $this->managerRegistry->getManager();

        $users = $em->getRepository(User::class)->search($_GET['search']);

        return $this->render('user/list.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/user/profile/{id}', name: 'user_profile')]
    public function profile(int $id): Response
    {
        $em = $this->managerRegistry->getManager();
        $user = $em->getRepository(User::class)->find($id);
        $comments = $em->getRepository(Comments::class)->findAll();
        $reviews = $user->getReviews();
        

        $datetime1 = new \DateTime('now');
        $age = $datetime1->diff($user->getBirthday(), true)->y;
        $register = $datetime1->diff($user->getRegisterAt(), true)->d;

        $currentUser = $this->getUser();

        if(!empty($_POST['submit'])){
            if($_POST['submit'] == 'follow'){
                $currentUser->addAbonnement($user);
                $em->persist($currentUser);
                $em->flush();

            } elseif($_POST['submit'] == 'unfollow'){
                $currentUser->removeAbonnement($user);
                $em->persist($currentUser);
                $em->flush();
            }
        }
        $favposts = $user->getFavposts();
        $abonnes = $user->getAbonnes();
        $abonnements = $user->getAbonnements();

        $numberOfAbonnes = $abonnes->count();
        $numberOfAbonnements = $abonnements->count();
        $numberFavposts = $favposts->count();

        return $this->render('user/profile.html.twig', [
            'user'                => $user,
            'reviews'             => $reviews,
            'register'            => $register,
            'age'                 => $age,
            'favposts'            => $favposts,
            'abonnements'         => $abonnements,
            'abonnes'             => $abonnes,
            'currentUser'         => $currentUser,
            'numberOfAbonnes'     => $numberOfAbonnes,
            'numberOfAbonnements' => $numberOfAbonnements,
            'numberFavposts'      => $numberFavposts,
            'comments'            => $comments,
            'currentDate'         => new \DateTime('now')
        ]);
    }

    
}
