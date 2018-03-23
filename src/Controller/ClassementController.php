<?php
/**
 * Created by PhpStorm.
 * User: Floryne TOURRET
 * Date: 23/03/2018
 * Time: 11:41
 */

namespace App\Controller;


use App\Entity\Parties;
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

        //Récupère les parties avec le joueur dedans
        $parties=  $this->getDoctrine()->getRepository(Parties::class)->findPartiesJoueur( $id);

        return $this->render('user/classement.html.twig', ['parties' => $parties]);
    }
}