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
     * @Route("/selectionAction1", name="selection_action1")
     */
    public function selectionAction1(Request $request)
    {
        $partieId = $request->request->get('id');

        $entityManager = $this->getDoctrine()->getManager();
        $partie = $entityManager->getRepository(Parties::class)->find($partieId);

        $Objets = $this->getDoctrine()->getRepository("App:Objets")->findAll();
        $objectifs = $this->getDoctrine()->getRepository("App:Objectifs")->findAll();
        $tObjets = array();
        foreach ($Objets as $carte) {
            $tObjets[$carte->getId()] = $carte;
        }
        $tObjectifs = array();
        foreach ($objectifs as $objectifs) {
            $tObjectifs[$objectifs->getId()] = $objectifs;
        }
        return $this->render('Partie/action1.html.twig', ['partie' => $partie, 'Objets' =>$tObjets, 'objectifs' =>$tObjectifs]);
    }

    /**
     * @Route("/action1", name="action1")
     */
    public function action1(Request $request)
    {
        //partie en cours
        $partieId = $request->request->get('id');

        //carte séléctionnée
        $carteId = $request->request->get('id_carte');

        $longeur = count($carteId);
        if ($longeur == 1) {


            // utilisateur connecté
            $user = $this->getUser();
            if ($user) {
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
            foreach ($actionsj1 as $actions) {
                if ($rang1 == 0) {
                    $actionsj1[$rang1] = 1;
                } else {
                    $actionsj1[$rang1] = $actions;
                }
                $rang1++;
            }

            $rang2 = 0;
            foreach ($actionsj2 as $actions) {
                if ($rang2 == 0) {
                    $actionsj2[$rang2] = 1;
                } else {
                    $actionsj2[$rang2] = $actions;
                }
                $rang2++;
            }

            $tour = $partie->getPartieTour();
            $tour++;

            $pioche = $partie->getPartiePioche();
            $carte_pioche = array_pop($pioche);


            $actionsj1 = json_encode($actionsj1);
            $actionsj2 = json_encode($actionsj2);
            $cartesecrete = json_encode($carteId);

            $main_joueur1 = $partie->getMainJ1();
            $tmain_joueur1 = array();

            $main_joueur2 = $partie->getMainJ2();
            $tmain_joueur2 = array();


            if ($id == $joueur1) {
                if ($carte_pioche != null) {
                    $tmain_joueur2[] = $carte_pioche;
                }
            }

            if ($id == $joueur2) {
                if ($carte_pioche != null) {
                    $tmain_joueur1[] = $carte_pioche;
                }
            }

            foreach ($main_joueur1 as $carte) {
                if ($carte != $carteId) {
                    $tmain_joueur1[] = $carte;
                }
            }

            foreach ($main_joueur2 as $carte) {
                if ($carte != $carteId) {
                    $tmain_joueur2[] = $carte;
                }
            }


            $mainj1 = json_encode($tmain_joueur1);
            $mainj2 = json_encode($tmain_joueur2);


            if (!$partie) {
                throw $this->createNotFoundException(
                    'No parties found for id ' . $id
                );
            }

            if ($id == $joueur1) {
                $partie->setActionJ1($actionsj1);
                $partie->setMainJ1($mainj1);
                $partie->setMainJ2($mainj2);
                $partie->setCarteSecreteJ1($cartesecrete);
                $partie->setPartieTour($tour);
                $partie->setPartiePioche($pioche);
            } elseif ($id == $joueur2) {
                $partie->setActionJ2($actionsj2);
                $partie->setMainJ1($mainj1);
                $partie->setMainJ2($mainj2);
                $partie->setCarteSecreteJ2($cartesecrete);
                $partie->setPartieTour($tour);
                $partie->setPartiePioche($pioche);
            }

            $entityManager->flush();

            if($tour!=9){
                return $this->redirectToRoute('afficher_partie', ['id' => $partieId]);
            }
            else{

                $Objets = $this->getDoctrine()->getRepository("App:Objets")->findAll();
                $objectifs = $this->getDoctrine()->getRepository("App:Objectifs")->findAll();
                $tObjets = array();
                foreach ($Objets as $carte) {
                    $tObjets[$carte->getId()] = $carte;
                }
                $tObjectifs = array();
                foreach ($objectifs as $objectifs) {
                    $tObjectifs[$objectifs->getId()] = $objectifs;
                }

                return $this->redirectToRoute('calcul', ['id' => $partieId]);
            }
        }else{

            $partieId = $request->request->get('id');

            $entityManager = $this->getDoctrine()->getManager();
            $partie = $entityManager->getRepository(Parties::class)->find($partieId);

            $Objets = $this->getDoctrine()->getRepository("App:Objets")->findAll();
            $objectifs = $this->getDoctrine()->getRepository("App:Objectifs")->findAll();
            $tObjets = array();
            foreach ($Objets as $carte) {
                $tObjets[$carte->getId()] = $carte;
            }
            $tObjectifs = array();
            foreach ($objectifs as $objectifs) {
                $tObjectifs[$objectifs->getId()] = $objectifs;
            }
            return $this->render('Partie/action1_fail.html.twig', ['partie' => $partie, 'Objets' =>$tObjets, 'objectifs' =>$tObjectifs]);
        }
    }


    /**
     * @Route("/selectionAction2", name="selection_action2")
     */
    public function selectionAction2(Request $request)
    {
        $partieId = $request->request->get('id');

        $entityManager = $this->getDoctrine()->getManager();
        $partie = $entityManager->getRepository(Parties::class)->find($partieId);

        $Objets = $this->getDoctrine()->getRepository("App:Objets")->findAll();
        $objectifs = $this->getDoctrine()->getRepository("App:Objectifs")->findAll();
        $tObjets = array();
        foreach ($Objets as $carte) {
            $tObjets[$carte->getId()] = $carte;
        }
        $tObjectifs = array();
        foreach ($objectifs as $objectifs) {
            $tObjectifs[$objectifs->getId()] = $objectifs;
        }
        return $this->render('Partie/action2.html.twig', ['partie' => $partie, 'Objets' =>$tObjets, 'objectifs' =>$tObjectifs]);
    }



    /**
     * @Route("/action2", name="action2")
     */
    public function action2(Request $request)
    {

        //partie en cours
        $partieId = $request->request->get('id');

        //carte séléctionnée
        $carteId = $request->request->get('id_carte');

        $longeur=count($carteId);
        if($longeur==2){

            $id = 0;
            foreach ($carteId as $carte) {
                if ($id == 0) {
                    $carte1 = $carte;
                } elseif ($id == 1) {
                    $carte2 = $carte;
                }
                $id++;

            }


            // utilisateur connecté
            $user = $this->getUser();
            if ($user) {
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
            foreach ($actionsj1 as $actions) {
                if ($rang1 == 1) {
                    $actionsj1[$rang1] = 1;
                } else {
                    $actionsj1[$rang1] = $actions;
                }
                $rang1++;
            }

            $rang2 = 0;
            foreach ($actionsj2 as $actions) {
                if ($rang2 == 1) {
                    $actionsj2[$rang2] = 1;
                } else {
                    $actionsj2[$rang2] = $actions;
                }
                $rang2++;
            }

            $tour = $partie->getPartieTour();
            $tour++;

            $pioche = $partie->getPartiePioche();
            $carte_pioche = array_pop($pioche);


            $actionsj1 = json_encode($actionsj1);
            $actionsj2 = json_encode($actionsj2);

            $main_joueur1 = $partie->getMainJ1();
            $tmain_joueur1 = array();

            $main_joueur2 = $partie->getMainJ2();
            $tmain_joueur2 = array();


            if ($id == $joueur1) {
                if ($carte_pioche != null) {
                    $tmain_joueur2[] = $carte_pioche;
                }
            }

            if ($id == $joueur2) {
                if ($carte_pioche != null) {
                    $tmain_joueur1[] = $carte_pioche;
                }
            }

            foreach ($main_joueur1 as $carte) {
                if ($carte != $carte1 && $carte != $carte2) {
                    $tmain_joueur1[] = $carte;
                }
            }

            foreach ($main_joueur2 as $carte) {
                if ($carte != $carte1 && $carte != $carte2) {
                    $tmain_joueur2[] = $carte;
                }
            }


            $mainj1 = json_encode($tmain_joueur1);
            $mainj2 = json_encode($tmain_joueur2);


            if (!$partie) {
                throw $this->createNotFoundException(
                    'No parties found for id ' . $id
                );
            }

            if ($id == $joueur1) {
                $partie->setActionJ1($actionsj1);
                $partie->setMainJ1($mainj1);
                $partie->setMainJ2($mainj2);
                $partie->setCarteDissimuleeJ1(json_encode($carteId));
                $partie->setPartieTour($tour);
                $partie->setPartiePioche($pioche);
            } elseif ($id == $joueur2) {
                $partie->setActionJ2($actionsj2);
                $partie->setMainJ1($mainj1);
                $partie->setMainJ2($mainj2);
                $partie->setCarteDissimuleeJ2(json_encode($carteId));
                $partie->setPartieTour($tour);
                $partie->setPartiePioche($pioche);
            }

            $entityManager->flush();
            if($tour!=9){
                return $this->redirectToRoute('afficher_partie', ['id' => $partieId]);
            }
            else{

                $Objets = $this->getDoctrine()->getRepository("App:Objets")->findAll();
                $objectifs = $this->getDoctrine()->getRepository("App:Objectifs")->findAll();
                $tObjets = array();
                foreach ($Objets as $carte) {
                    $tObjets[$carte->getId()] = $carte;
                }
                $tObjectifs = array();
                foreach ($objectifs as $objectifs) {
                    $tObjectifs[$objectifs->getId()] = $objectifs;
                }

                return $this->redirectToRoute('calcul', ['id' => $partieId]);
            }
        }

        else{

            $partieId = $request->request->get('id');

            $entityManager = $this->getDoctrine()->getManager();
            $partie = $entityManager->getRepository(Parties::class)->find($partieId);

            $Objets = $this->getDoctrine()->getRepository("App:Objets")->findAll();
            $objectifs = $this->getDoctrine()->getRepository("App:Objectifs")->findAll();
            $tObjets = array();
            foreach ($Objets as $carte) {
                $tObjets[$carte->getId()] = $carte;
            }
            $tObjectifs = array();
            foreach ($objectifs as $objectifs) {
                $tObjectifs[$objectifs->getId()] = $objectifs;
            }
            return $this->render('Partie/action2_fail.html.twig', ['partie' => $partie, 'Objets' =>$tObjets, 'objectifs' =>$tObjectifs]);
        }
    }



    /**
     * @Route("/selectionAction3", name="selection_action3")
     */
    public function selectionAction3(Request $request)
    {
        $partieId = $request->request->get('id');

        $entityManager = $this->getDoctrine()->getManager();
        $partie = $entityManager->getRepository(Parties::class)->find($partieId);

        $Objets = $this->getDoctrine()->getRepository("App:Objets")->findAll();
        $objectifs = $this->getDoctrine()->getRepository("App:Objectifs")->findAll();
        $tObjets = array();
        foreach ($Objets as $carte) {
            $tObjets[$carte->getId()] = $carte;
        }
        $tObjectifs = array();
        foreach ($objectifs as $objectifs) {
            $tObjectifs[$objectifs->getId()] = $objectifs;
        }
        return $this->render('Partie/action3.html.twig', ['partie' => $partie, 'Objets' =>$tObjets, 'objectifs' =>$tObjectifs]);
    }



    /**
     * @Route("/action3", name="action3")
     */
    public function action3(Request $request)
    {

        //partie en cours
        $partieId = $request->request->get('id');

        //carte séléctionnée
        $carteId = $request->request->get('id_carte');

        $longeur=count($carteId);
        if($longeur==3){

            $id = 0;
            foreach ($carteId as $carte) {
                if ($id == 0) {
                    $carte1 = $carte;
                } elseif ($id == 1) {
                    $carte2 = $carte;
                } elseif ($id == 2) {
                    $carte3 = $carte;
                }
                $id++;

            }


            // utilisateur connecté
            $user = $this->getUser();
            if ($user) {
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
            foreach ($actionsj1 as $actions) {
                if ($rang1 == 2) {
                    $actionsj1[$rang1] = 1;
                } else {
                    $actionsj1[$rang1] = $actions;
                }
                $rang1++;
            }

            $rang2 = 0;
            foreach ($actionsj2 as $actions) {
                if ($rang2 == 2) {
                    $actionsj2[$rang2] = 1;
                } else {
                    $actionsj2[$rang2] = $actions;
                }
                $rang2++;
            }

            $tour = $partie->getPartieTour();
            $tour++;

            $pioche = $partie->getPartiePioche();
            $carte_pioche = array_pop($pioche);


            $actionsj1 = json_encode($actionsj1);
            $actionsj2 = json_encode($actionsj2);

            $main_joueur1 = $partie->getMainJ1();
            $tmain_joueur1 = array();

            $main_joueur2 = $partie->getMainJ2();
            $tmain_joueur2 = array();


            if ($id == $joueur1) {
                if ($carte_pioche != null) {
                    $tmain_joueur2[] = $carte_pioche;
                }
            }

            if ($id == $joueur2) {
                if ($carte_pioche != null) {
                    $tmain_joueur1[] = $carte_pioche;
                }
            }

            foreach ($main_joueur1 as $carte) {
                if ($carte != $carte1 && $carte != $carte2 && $carte != $carte3) {
                    $tmain_joueur1[] = $carte;
                }
            }

            foreach ($main_joueur2 as $carte) {
                if ($carte != $carte1 && $carte != $carte2 && $carte != $carte3) {
                    $tmain_joueur2[] = $carte;
                }
            }


            $mainj1 = json_encode($tmain_joueur1);
            $mainj2 = json_encode($tmain_joueur2);


            if (!$partie) {
                throw $this->createNotFoundException(
                    'No parties found for id ' . $id
                );
            }

            if ($id == $joueur1) {
                $partie->setActionJ1($actionsj1);
                $partie->setMainJ1($mainj1);
                $partie->setMainJ2($mainj2);
                $partie->setCarteCadeauJ1(json_encode($carteId));
                $partie->setPartieTour($tour);
                $partie->setPartiePioche($pioche);
            } elseif ($id == $joueur2) {
                $partie->setActionJ2($actionsj2);
                $partie->setMainJ1($mainj1);
                $partie->setMainJ2($mainj2);
                $partie->setCarteCadeauJ2(json_encode($carteId));
                $partie->setPartieTour($tour);
                $partie->setPartiePioche($pioche);
            }

            $entityManager->flush();

            return $this->redirectToRoute('afficher_partie', ['id' => $partieId]);
        }

        else{

            $partieId = $request->request->get('id');

            $entityManager = $this->getDoctrine()->getManager();
            $partie = $entityManager->getRepository(Parties::class)->find($partieId);

            $Objets = $this->getDoctrine()->getRepository("App:Objets")->findAll();
            $objectifs = $this->getDoctrine()->getRepository("App:Objectifs")->findAll();
            $tObjets = array();
            foreach ($Objets as $carte) {
                $tObjets[$carte->getId()] = $carte;
            }
            $tObjectifs = array();
            foreach ($objectifs as $objectifs) {
                $tObjectifs[$objectifs->getId()] = $objectifs;
            }
            return $this->render('Partie/action3_fail.html.twig', ['partie' => $partie, 'Objets' =>$tObjets, 'objectifs' =>$tObjectifs]);
        }
    }



    /**
     * @Route("/selectionAction4", name="selection_action4")
     */
    public function selectionAction4(Request $request)
    {
        $partieId = $request->request->get('id');

        $entityManager = $this->getDoctrine()->getManager();
        $partie = $entityManager->getRepository(Parties::class)->find($partieId);

        $Objets = $this->getDoctrine()->getRepository("App:Objets")->findAll();
        $objectifs = $this->getDoctrine()->getRepository("App:Objectifs")->findAll();
        $tObjets = array();
        foreach ($Objets as $carte) {
            $tObjets[$carte->getId()] = $carte;
        }
        $tObjectifs = array();
        foreach ($objectifs as $objectifs) {
            $tObjectifs[$objectifs->getId()] = $objectifs;
        }
        return $this->render('Partie/action4.html.twig', ['partie' => $partie, 'Objets' =>$tObjets, 'objectifs' =>$tObjectifs]);
    }



    /**
     * @Route("/action4", name="action4")
     */
    public function action4(Request $request)
    {
        //partie en cours
        $partieId = $request->request->get('id');

        //carte séléctionnée
        $carteId = $request->request->get('id_carte');

        $longeur=count($carteId);
        if($longeur==4){

            $id = 0;
            foreach ($carteId as $carte) {
                if ($id == 0) {
                    $carte1 = $carte;
                } elseif ($id == 1) {
                    $carte2 = $carte;
                } elseif ($id == 2) {
                    $carte3 = $carte;
                }elseif ($id == 3) {
                    $carte4 = $carte;
                }
                $id++;

            }


            // utilisateur connecté
            $user = $this->getUser();
            if ($user) {
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
            foreach ($actionsj1 as $actions) {
                if ($rang1 == 3) {
                    $actionsj1[$rang1] = 1;
                } else {
                    $actionsj1[$rang1] = $actions;
                }
                $rang1++;
            }

            $rang2 = 0;
            foreach ($actionsj2 as $actions) {
                if ($rang2 == 3) {
                    $actionsj2[$rang2] = 1;
                } else {
                    $actionsj2[$rang2] = $actions;
                }
                $rang2++;
            }

            $tour = $partie->getPartieTour();
            $tour++;

            $pioche = $partie->getPartiePioche();
            $carte_pioche = array_pop($pioche);


            $actionsj1 = json_encode($actionsj1);
            $actionsj2 = json_encode($actionsj2);

            $main_joueur1 = $partie->getMainJ1();
            $tmain_joueur1 = array();

            $main_joueur2 = $partie->getMainJ2();
            $tmain_joueur2 = array();


            if ($id == $joueur1) {
                if ($carte_pioche != null) {
                    $tmain_joueur2[] = $carte_pioche;
                }
            }

            if ($id == $joueur2) {
                if ($carte_pioche != null) {
                    $tmain_joueur1[] = $carte_pioche;
                }
            }

            foreach ($main_joueur1 as $carte) {
                if ($carte != $carte1 && $carte != $carte2 && $carte != $carte3 && $carte != $carte4) {
                    $tmain_joueur1[] = $carte;
                }
            }

            foreach ($main_joueur2 as $carte) {
                if ($carte != $carte1 && $carte != $carte2 && $carte != $carte3 && $carte != $carte4) {
                    $tmain_joueur2[] = $carte;
                }
            }


            $mainj1 = json_encode($tmain_joueur1);
            $mainj2 = json_encode($tmain_joueur2);


            if (!$partie) {
                throw $this->createNotFoundException(
                    'No parties found for id ' . $id
                );
            }

            if ($id == $joueur1) {
                $partie->setActionJ1($actionsj1);
                $partie->setMainJ1($mainj1);
                $partie->setMainJ2($mainj2);
                $partie->setCarteConcurrenceJ1(json_encode($carteId));
                $partie->setPartieTour($tour);
                $partie->setPartiePioche($pioche);
            } elseif ($id == $joueur2) {
                $partie->setActionJ2($actionsj2);
                $partie->setMainJ1($mainj1);
                $partie->setMainJ2($mainj2);
                $partie->setCarteConcurrenceJ2(json_encode($carteId));
                $partie->setPartieTour($tour);
                $partie->setPartiePioche($pioche);
            }

            $entityManager->flush();

            return $this->redirectToRoute('afficher_partie', ['id' => $partieId]);
        }
        else{

            $partieId = $request->request->get('id');

            $entityManager = $this->getDoctrine()->getManager();
            $partie = $entityManager->getRepository(Parties::class)->find($partieId);

            $Objets = $this->getDoctrine()->getRepository("App:Objets")->findAll();
            $objectifs = $this->getDoctrine()->getRepository("App:Objectifs")->findAll();
            $tObjets = array();
            foreach ($Objets as $carte) {
                $tObjets[$carte->getId()] = $carte;
            }
            $tObjectifs = array();
            foreach ($objectifs as $objectifs) {
                $tObjectifs[$objectifs->getId()] = $objectifs;
            }
            return $this->render('Partie/action4_fail.html.twig', ['partie' => $partie, 'Objets' =>$tObjets, 'objectifs' =>$tObjectifs]);
        }
    }

    /**
     * @Route("/choix_cadeau", name="choix_cadeau")
     */
    public function choix_cadeau(Request $request)
    {
        //partie en cours
        $partieId = $request->request->get('id');

        //carte séléctionnée
        $carteId = $request->request->get('id_carte');

        $longeur = count($carteId);
        if ($longeur == 1) {


            // utilisateur connecté
            $user = $this->getUser();
            if ($user) {
                $id = $user->getId();
            } else {
                $id = "Pas d'Id";
            }

            $entityManager = $this->getDoctrine()->getManager();
            $partie = $entityManager->getRepository(Parties::class)->find($partieId);

            $joueur1 = $partie->getJoueur1()->getId();
            $joueur2 = $partie->getJoueur2()->getId();

            $tour=$partie->getPartieTour();


            if (!$partie) {
                throw $this->createNotFoundException(
                    'No parties found for id ' . $id
                );
            }

            if ($id == $joueur1) {
                $partie->setCarteCadeauJ2(json_encode(null));
            } elseif ($id == $joueur2) {
                $partie->setCarteCadeauJ1(json_encode(null));
            }

            $entityManager->flush();

            if($tour!=9){
                return $this->redirectToRoute('afficher_partie', ['id' => $partieId]);
            }
            else{

                $Objets = $this->getDoctrine()->getRepository("App:Objets")->findAll();
                $objectifs = $this->getDoctrine()->getRepository("App:Objectifs")->findAll();
                $tObjets = array();
                foreach ($Objets as $carte) {
                    $tObjets[$carte->getId()] = $carte;
                }
                $tObjectifs = array();
                foreach ($objectifs as $objectifs) {
                    $tObjectifs[$objectifs->getId()] = $objectifs;
                }

                return $this->redirectToRoute('calcul', ['id' => $partieId]);
            }
        }
        else{

            $partieId = $request->request->get('id');

            $entityManager = $this->getDoctrine()->getManager();
            $partie = $entityManager->getRepository(Parties::class)->find($partieId);

            $Objets = $this->getDoctrine()->getRepository("App:Objets")->findAll();
            $objectifs = $this->getDoctrine()->getRepository("App:Objectifs")->findAll();
            $tObjets = array();
            foreach ($Objets as $carte) {
                $tObjets[$carte->getId()] = $carte;
            }
            $tObjectifs = array();
            foreach ($objectifs as $objectifs) {
                $tObjectifs[$objectifs->getId()] = $objectifs;
            }
            return $this->render('Partie/afficher_partie.html.twig', ['partie' => $partie, 'Objets' =>$tObjets, 'objectifs' =>$tObjectifs]);
        }
    }

    /**
     * @Route("/choix_concurrence", name="choix_concurrence")
     */
    public function choix_concurrence(Request $request)
    {
        //partie en cours
        $partieId = $request->request->get('id');

        //carte séléctionnée
        $carteId = $request->request->get('id_carte');

        $longeur = count($carteId);
        if ($longeur == 1) {


            // utilisateur connecté
            $user = $this->getUser();
            if ($user) {
                $id = $user->getId();
            } else {
                $id = "Pas d'Id";
            }

            $entityManager = $this->getDoctrine()->getManager();
            $partie = $entityManager->getRepository(Parties::class)->find($partieId);

            $joueur1 = $partie->getJoueur1()->getId();
            $joueur2 = $partie->getJoueur2()->getId();
            $tour=$partie->getPartieTour();

            if (!$partie) {
                throw $this->createNotFoundException(
                    'No parties found for id ' . $id
                );
            }

            if ($id == $joueur1) {
                $partie->setCarteConcurrenceJ2(json_encode(null));
            } elseif ($id == $joueur2) {
                $partie->setCarteConcurrenceJ1(json_encode(null));
            }

            $entityManager->flush();

            if($tour!=9){
                return $this->redirectToRoute('afficher_partie', ['id' => $partieId]);
            }
            else{

                $Objets = $this->getDoctrine()->getRepository("App:Objets")->findAll();
                $objectifs = $this->getDoctrine()->getRepository("App:Objectifs")->findAll();
                $tObjets = array();
                foreach ($Objets as $carte) {
                    $tObjets[$carte->getId()] = $carte;
                }
                $tObjectifs = array();
                foreach ($objectifs as $objectifs) {
                    $tObjectifs[$objectifs->getId()] = $objectifs;
                }

                return $this->redirectToRoute('calcul', ['id' => $partieId]);
            }
        }
        else{

            $partieId = $request->request->get('id');

            $entityManager = $this->getDoctrine()->getManager();
            $partie = $entityManager->getRepository(Parties::class)->find($partieId);

            $Objets = $this->getDoctrine()->getRepository("App:Objets")->findAll();
            $objectifs = $this->getDoctrine()->getRepository("App:Objectifs")->findAll();
            $tObjets = array();
            foreach ($Objets as $carte) {
                $tObjets[$carte->getId()] = $carte;
            }
            $tObjectifs = array();
            foreach ($objectifs as $objectifs) {
                $tObjectifs[$objectifs->getId()] = $objectifs;
            }
            return $this->render('Partie/afficher_partie.html.twig', ['partie' => $partie, 'Objets' =>$tObjets, 'objectifs' =>$tObjectifs]);
        }
    }


    /**
     * @Route("/calcul/{id", name="calcul")
     */
    public function calcul(Request $request)
    {
        $partieId = $request->query->get('id');

        $entityManager = $this->getDoctrine()->getManager();
        $partie = $entityManager->getRepository(Parties::class)->find($partieId);

        $Objets = $this->getDoctrine()->getRepository("App:Objets")->findAll();
        $objectifs = $this->getDoctrine()->getRepository("App:Objectifs")->findAll();
        $tObjets = array();
        foreach ($Objets as $carte) {
            $tObjets[$carte->getId()] = $carte;
        }
        $tObjectifs = array();
        foreach ($objectifs as $objectifs) {
            $tObjectifs[$objectifs->getId()] = $objectifs;
        }
        return $this->render('Partie/afficher_score.html.twig', ['partie' => $partie, 'Objets' =>$tObjets, 'objectifs' =>$tObjectifs]);
    }
}