<?php
/**
 * Created by PhpStorm.
 * User: Floryne TOURRET
 * Date: 19/03/2018
 * Time: 12:24
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        $joueursco=$this->getDoctrine()->getRepository(User::class)->findBy(['actif' => 1]);
        return $this->render('Admin/index.html.twig', ['joueursco'=>$joueursco]);

    }

    /**
     * @Route("/user", name="user")
     */
    public function user()
    {
        return $this->render('User/index.html.twig');
    }

    /**
     * @Route("/user_fail", name="user_fail")
     */
    public function user_fail()
    {
        return $this->render('User/fail.html.twig');
    }

    /**
     * @Route("/connecte", name="connecte")
     */
    public function connecte()
    {
        return $this->redirectToRoute('actif');
    }

    /**
     * @Route("/connecte_admin", name="connecte_admin")
     */
    public function connecte_admin()
    {
        return $this->redirectToRoute('actif_admin');
    }

    /**
     * @Route("/user/profil", name="profil")
     */
    public function profil()
    {
        return $this->render('User/profil.html.twig');
    }

    /**
     * @Route("/admin/profil_admin", name="profil_admin")
     */
    public function profil_admin()
    {
        $joueursco=$this->getDoctrine()->getRepository(User::class)->findBy(['actif' => 1]);
        return $this->render('Admin/profil.html.twig', ['joueursco'=>$joueursco]);
    }

    /**
     * @Route("/mdp_oublie", name="mdp_oublie")
     */
    public function mdp_oublie(){

        return $this->render('Security/oubli_mdp.html.twig');

    }
    /**
     * @Route("/mdp_oublie_fail", name="mdp_oublie_fail")
     */
    public function mdp_oublie_fail(){

        return $this->render('Security/mdp_oublie_fail.html.twig');

    }
    /**
     * @Route("/mdp_oublie_success", name="mdp_oublie_success")
     */
    public function mdp_oublie_succes(){

        return $this->render('Security/mdp_oublie_success.html.twig');

    }

    /**
     * @Route("/reset_mdp", name="reset_mdp")
     */
    public function reset_mdp(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer){
        $email = $request->request->get('email');

        $joueurs=$this->getDoctrine()->getRepository(User::class)->findOneBy(['email'=>$email]);


        if ($joueurs == null) {

            return $this->redirectToRoute('mdp_oubile_fail');

        }
        else{

            $user = $joueurs;
            if ($user) {
                $id = $user->getId();
            } else {
                $id = "Pas d'Id";
            }

            $mdp = $this->Genere_Password(10);;

            $new_password = $passwordEncoder->encodePassword($user, $mdp);

            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->find($id);

            if (!$user) {
                throw $this->createNotFoundException(
                    'No username found for id ' . $id
                );
            }


            $user->setPassword($new_password);
            $entityManager->flush();

            $body="Bonjour, ton mot de passe a été réinitialisé. <br>Connecte toi avec le mot de passe : <b>".$mdp."</b><br>N'oublie pas de le changer et amuse toi bien !";

            $message = (new \Swift_Message('Cosmos - Mot de passe'))
                ->setFrom('cosmos@floryne.net')
                ->setTo($email)
                ->setBody($body,'text/html');

            $mailer->send($message);

            return $this->redirectToRoute('mdp_oublie_success');
        }
    }

    function Genere_Password($length)
    {
        // Initialisation des caractères utilisables
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;

    }


}