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
use Symfony\Component\HttpFoundation\Request;

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

        $joueursco=$this->getDoctrine()->getRepository(User::class)->findBy(['actif' => 1]);

        return $this->render('Admin/classement.html.twig', ['moi' => $joueur, 'autres'=>$joueurs, 'joueursco'=>$joueursco]);
    }

    /**
     * @Route("/admin_joueurs", name="admin_joueurs")
     */
    public function admin_joueurs(){

        $joueursco=$this->getDoctrine()->getRepository(User::class)->findBy(['actif' => 1]);
        $joueurs= $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('Admin/joueurs.html.twig', ['joueurs'=>$joueurs, 'joueursco'=>$joueursco]);
    }

    /**
     * @Route("/admin_parties", name="admin_parties")
     */
    public function admin_parties(){

        $joueursco=$this->getDoctrine()->getRepository(User::class)->findBy(['actif' => 1]);
        $parties= $this->getDoctrine()->getRepository(Parties::class)->findAll();


        return $this->render('Admin/parties.html.twig', ['parties'=>$parties, 'joueursco'=>$joueursco]);

    }

    /**
     * @Route("/supprimer_partie", name="supprimer_partie")
     */
    public function supprimer_partie(Request $request){

        $id_partie= $request->request->get('partie');

        $partie= $this->getDoctrine()->getRepository(Parties::class)->find($id_partie);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($partie);
        $entityManager->flush();

        return $this->redirectToRoute('admin_parties');

    }

    /**
     * @Route("/supprimer_joueur", name="supprimer_joueur")
     */
    public function supprimer_joueur(Request $request){

        $id_joueur= $request->request->get('joueur');

        $joueur= $this->getDoctrine()->getRepository(User::class)->find($id_joueur);
        $partiesjoueurs=$this->getDoctrine()->getRepository(Parties::class)->findPartiesJoueur($id_joueur);
        foreach ($partiesjoueurs as $row){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($row);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($joueur);
        $entityManager->flush();

        return $this->redirectToRoute('admin_joueurs');

    }


}