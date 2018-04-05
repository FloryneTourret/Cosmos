<?php
/**
 * Created by PhpStorm.
 * User: Floryne TOURRET
 * Date: 04/04/2018
 * Time: 22:32
 */

namespace App\Controller;


use App\Entity\Parties;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClassementController
 * @package App\Controller
 * @Route("admin")
 */
class AdminController extends Controller
{

    /**
     * @Route("/admin_classement", name="admin_classement")
     */
    public function admin_classement(){

        $user = $this->getUser();
        if($user) {
            $id = $user->getId();
        } else {
            $id = "Pas d'Id";
        }

        //Récupère le joueur
        $joueur= $this->getDoctrine()->getRepository(User::class)->find( $id);

        $joueurs= $this->getDoctrine()->getRepository(User::class)->findBy(array(), array('PartiesVictoires' => 'DESC', 'PartiesDefaites'=>'ASC'));

        return $this->render('Admin/classement.html.twig', ['moi' => $joueur, 'autres'=>$joueurs]);
    }

    /**
     * @Route("/admin_joueurs", name="admin_joueurs")
     */
    public function admin_joueurs(){

        $joueurs= $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('Admin/joueurs.html.twig', ['joueurs'=>$joueurs]);
    }

    /**
     * @Route("/admin_parties", name="admin_parties")
     */
    public function admin_parties(){


        $parties= $this->getDoctrine()->getRepository(Parties::class)->findAll();


        return $this->render('Admin/parties.html.twig', ['parties'=>$parties]);
    }


}