<?php
/**
 * Created by PhpStorm.
 * User: Floryne TOURRET
 * Date: 23/03/2018
 * Time: 11:41
 */

namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClassementController
 * @package App\Controller
 * @Route("user")
 */
class ClassementController extends Controller
{
    /**
     * @Route("/classement", name="classement")
     */
    public function classement(){

        $user = $this->getUser();
        if($user) {
            $id = $user->getId();
        } else {
            $id = "Pas d'Id";
        }

        //Récupère le joueur
        $joueur= $this->getDoctrine()->getRepository(User::class)->find( $id);

        $joueurs= $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('User/classement.html.twig', ['moi' => $joueur, 'autres'=>$joueurs]);
    }
}