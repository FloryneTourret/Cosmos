<?php
/**
 * Created by PhpStorm.
 * User: Floryne TOURRET
 * Date: 21/03/2018
 * Time: 18:11
 */

namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
 * Class UpdateController
 * @package App\Controller
 * @Route("user/update")
 */
class UpdateController extends Controller
{
    /**
     * @Route("/update_username", name="update_username")
     */
    public function new_username(){
        //$new_username = $request->request->get('username');
        $user = $this->getUser();
        if($user) {
            $id = $user->getId();
        } else {
            $id = "Pas d'Id";
        }
        $new_username='Floryne';

        $entityManager = $this->getDoctrine()->getManager();
        $username = $entityManager->getRepository(User::class)->find($id);

        if (!$username) {
            throw $this->createNotFoundException(
                'No username found for id '.$id
            );
        }

        $username->setUsername($new_username);
        $entityManager->persist($username);
        $entityManager->flush();

        return $this->redirectToRoute('user');
    }

    /**
     * @Route("/update_email", name="update_email")
     */
    public function new_email(){
        //$new_email = $request->request->get('email');
        $user = $this->getUser();
        if($user) {
            $id = $user->getId();
        } else {
            $id = "Pas d'Id";
        }

        $new_email='floryne.tourret@etudiant.univ-reims.fr';

        $entityManager = $this->getDoctrine()->getManager();
        $email = $entityManager->getRepository(User::class)->find($id);

        if (!email) {
            throw $this->createNotFoundException(
                'No username found for id '.$id
            );
        }

        $email->setEmail($new_email);
        $entityManager->persist($email);
        $entityManager->flush();

        return $this->redirectToRoute('user');
    }

    /**
     * @Route("/update_password", name="update_password")
     */
    public function new_mdp(UserPasswordEncoderInterface $passwordEncoder){
        //$new_password = $request->request->get('password');
        $user = $this->getUser();
        if($user) {
            $id = $user->getId();
        } else {
            $id = "Pas d'Id";
        }

        $password_send='PASSWORD';
        $new_password=$passwordEncoder->encodePassword($id ,$password_send);

        $entityManager = $this->getDoctrine()->getManager();
        $password = $entityManager->getRepository(User::class)->find($id);

        if (!$password) {
            throw $this->createNotFoundException(
                'No username found for id '.$id
            );
        }

        $password->setPassword($new_password);
        $entityManager->persist($password);
        $entityManager->flush();

        return $this->redirectToRoute('user');
    }

    /**
     * @Route("/actif", name="actif")
     */
    public function actif(){
        $user = $this->getUser();
        if($user) {
            $id = $user->getId();
        } else {
            $id = "Pas d'Id";
        }

        $passage_actif=1;

        $entityManager = $this->getDoctrine()->getManager();
        $actif = $entityManager->getRepository(User::class)->find($id);

        if (!$actif) {
            throw $this->createNotFoundException(
                'No username found for id '.$id
            );
        }

        $actif->setActif($passage_actif);
        $entityManager->flush();

        return $this->redirectToRoute('user');
    }

    /**
     * @Route("/inactif", name="inactif")
     */
    public function inactif(){

        $user = $this->getUser();
        if($user) {
            $id = $user->getId();
        } else {
            $id = "Pas d'Id";
        }
        $passage_inactif=0;

        $entityManager = $this->getDoctrine()->getManager();
        $inactif = $entityManager->getRepository(User::class)->find($id);

        if (!$inactif) {
            throw $this->createNotFoundException(
                'No username found for id '.$id
            );
        }

        $inactif->setActif($passage_inactif);
        $entityManager->flush();

        return $this->redirectToRoute('user');
    }

}