<?php
/**
 * Created by PhpStorm.
 * User: Floryne TOURRET
 * Date: 26/03/2018
 * Time: 11:49
 */

namespace App\Controller;


use App\Entity\Parties;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ActionsController
 * @package App\Controller
 * @Route("user/partie")
 */
class ActionsController extends Controller
{
    /**
     * @Route("/action1", name="action1")
     */
    public function action1(Request $request)
    {
        //partie en cours
        $partieId = $request->request->get('id');

        // utilisateur connecté
        $user=$this->getUser();
        if($user) {
            $id = $user->getId();
        } else {
            $id = "Pas d'Id";
        }


        $entityManager = $this->getDoctrine()->getManager();
        $partie = $entityManager->getRepository(Parties::class)->find($partieId);

        $joueur1 = $partie->getJoueur1()->getId();
        $joueur2 = $partie->getJoueur2()->getId();

        $actionsj1 = $partie->getActionJ1();
        $actionsj2 = $partie->getActionJ2();

        $rang1 = 0;
        foreach ($actionsj1 as $actions){
            if ($rang1 ==0){
                $actionsj1[$rang1]=1;
            }
            else{
                $actionsj1[$rang1]=$actions;
            }
            $rang1++;
        }

        $rang2 = 0;
        foreach ($actionsj2 as $actions){
            if ($rang2 ==0){
                $actionsj2[$rang2]=1;
            }
            else{
                $actionsj2[$rang2]=$actions;
            }
            $rang2++;
        }

        $tour = $partie->getPartieTour();
        $tour ++;

        $actionsj1=json_encode($actionsj1);
        $actionsj2=json_encode($actionsj2);

        if (!$partie) {
            throw $this->createNotFoundException(
                'No parties found for id '.$id
            );
        }

        if ($id == $joueur1){
            $partie->setActionJ1($actionsj1);
            $partie->setPartieTour($tour);
        }
        elseif ($id==$joueur2){
            $partie->setActionJ2($actionsj2);
            $partie->setPartieTour($tour);
        }

        $entityManager->flush();

        return $this->redirectToRoute('afficher_partie', ['id' => $partieId]);
    }

    /**
     * @Route("/action2", name="action2")
     */
    public function action2(Request $request)
    {
        //partie en cours
        $partieId = $request->request->get('id');

        // utilisateur connecté
        $user=$this->getUser();
        if($user) {
            $id = $user->getId();
        } else {
            $id = "Pas d'Id";
        }


        $entityManager = $this->getDoctrine()->getManager();
        $partie = $entityManager->getRepository(Parties::class)->find($partieId);

        $joueur1 = $partie->getJoueur1()->getId();
        $joueur2 = $partie->getJoueur2()->getId();

        $actionsj1 = $partie->getActionJ1();
        $actionsj2 = $partie->getActionJ2();

        $rang1 = 0;
        foreach ($actionsj1 as $actions){
            if ($rang1 ==1){
                $actionsj1[$rang1]=1;
            }
            else{
                $actionsj1[$rang1]=$actions;
            }
            $rang1++;
        }

        $rang2 = 0;
        foreach ($actionsj2 as $actions){
            if ($rang2 ==1){
                $actionsj2[$rang2]=1;
            }
            else{
                $actionsj2[$rang2]=$actions;
            }
            $rang2++;
        }

        $tour = $partie->getPartieTour();
        $tour ++;

        $actionsj1=json_encode($actionsj1);
        $actionsj2=json_encode($actionsj2);

        if (!$partie) {
            throw $this->createNotFoundException(
                'No parties found for id '.$id
            );
        }

        if ($id == $joueur1){
            $partie->setActionJ1($actionsj1);
            $partie->setPartieTour($tour);
        }
        elseif ($id==$joueur2){
            $partie->setActionJ2($actionsj2);
            $partie->setPartieTour($tour);
        }

        $entityManager->flush();

        return $this->redirectToRoute('afficher_partie', ['id' => $partieId]);
    }

    /**
     * @Route("/action3", name="action3")
     */
    public function action3(Request $request)
    {
        //partie en cours
        $partieId = $request->request->get('id');

        // utilisateur connecté
        $user=$this->getUser();
        if($user) {
            $id = $user->getId();
        } else {
            $id = "Pas d'Id";
        }


        $entityManager = $this->getDoctrine()->getManager();
        $partie = $entityManager->getRepository(Parties::class)->find($partieId);

        $joueur1 = $partie->getJoueur1()->getId();
        $joueur2 = $partie->getJoueur2()->getId();

        $actionsj1 = $partie->getActionJ1();
        $actionsj2 = $partie->getActionJ2();

        $rang1 = 0;
        foreach ($actionsj1 as $actions){
            if ($rang1 ==2){
                $actionsj1[$rang1]=1;
            }
            else{
                $actionsj1[$rang1]=$actions;
            }
            $rang1++;
        }

        $rang2 = 0;
        foreach ($actionsj2 as $actions){
            if ($rang2 ==2){
                $actionsj2[$rang2]=1;
            }
            else{
                $actionsj2[$rang2]=$actions;
            }
            $rang2++;
        }

        $tour = $partie->getPartieTour();
        $tour ++;

        $actionsj1=json_encode($actionsj1);
        $actionsj2=json_encode($actionsj2);

        if (!$partie) {
            throw $this->createNotFoundException(
                'No parties found for id '.$id
            );
        }

        if ($id == $joueur1){
            $partie->setActionJ1($actionsj1);
            $partie->setPartieTour($tour);
        }
        elseif ($id==$joueur2){
            $partie->setActionJ2($actionsj2);
            $partie->setPartieTour($tour);
        }

        $entityManager->flush();

        return $this->redirectToRoute('afficher_partie', ['id' => $partieId]);
    }

    /**
     * @Route("/action4", name="action4")
     */
    public function action4(Request $request)
    {
        //partie en cours
        $partieId = $request->request->get('id');

        // utilisateur connecté
        $user=$this->getUser();
        if($user) {
            $id = $user->getId();
        } else {
            $id = "Pas d'Id";
        }


        $entityManager = $this->getDoctrine()->getManager();
        $partie = $entityManager->getRepository(Parties::class)->find($partieId);

        $joueur1 = $partie->getJoueur1()->getId();
        $joueur2 = $partie->getJoueur2()->getId();

        $actionsj1 = $partie->getActionJ1();
        $actionsj2 = $partie->getActionJ2();

        $rang1 = 0;
        foreach ($actionsj1 as $actions){
            if ($rang1 ==3){
                $actionsj1[$rang1]=1;
            }
            else{
                $actionsj1[$rang1]=$actions;
            }
            $rang1++;
        }

        $rang2 = 0;
        foreach ($actionsj2 as $actions){
            if ($rang2 ==3){
                $actionsj2[$rang2]=1;
            }
            else{
                $actionsj2[$rang2]=$actions;
            }
            $rang2++;
        }

        $tour = $partie->getPartieTour();
        $tour ++;

        $actionsj1=json_encode($actionsj1);
        $actionsj2=json_encode($actionsj2);

        if (!$partie) {
            throw $this->createNotFoundException(
                'No parties found for id '.$id
            );
        }

        if ($id == $joueur1){
            $partie->setActionJ1($actionsj1);
            $partie->setPartieTour($tour);
        }
        elseif ($id==$joueur2){
            $partie->setActionJ2($actionsj2);
            $partie->setPartieTour($tour);
        }

        $entityManager->flush();

        return $this->redirectToRoute('afficher_partie', ['id' => $partieId]);
    }

}