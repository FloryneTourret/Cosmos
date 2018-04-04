<?php
/**
 * Created by PhpStorm.
 * User: Floryne TOURRET
 * Date: 26/03/2018
 * Time: 11:49
 */

namespace App\Controller;


use App\Entity\Parties;
use App\Entity\User;
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
        $paires = json_decode($request->request->get('paires'));

        $longeur=count($paires);

        if($longeur==4){

            $paire1[0] = $paires[0];
            $paire1[1] = $paires[1];
            $paire2[0] = $paires[2];
            $paire2[1] = $paires[3];

            $carte1=$paire1[0];
            $carte2=$paire1[1];
            $carte3=$paire2[0];
            $carte4=$paire2[1];


            if( $carte1!=$carte2 && $carte1!=$carte3 && $carte1!=$carte4 && $carte2!=$carte3 && $carte2!=$carte4 && $carte3!=$carte4){

                $carteId=array();
                $carteId[0]=$carte1;
                $carteId[1]=$carte2;
                $carteId[2]=$carte3;
                $carteId[3]=$carte4;

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
            $terrainj1=$partie->getTerrainJ1();
            $terrainj2=$partie->getTerrainJ2();

            if ($id == $joueur2) {

                $cadeaux=$partie->getCarteCadeauJ1();

                if($cadeaux[0]!=$carteId){
                    $cadeau1=$cadeaux[0];
                    if($cadeaux[1]!=$carteId){
                        $cadeau2=$cadeaux[1];
                    }
                    else{
                        $cadeau2=$cadeaux[2];
                    }
                }else{
                    $cadeau1=$cadeaux[1];
                    $cadeau2=$cadeaux[1];
                }


                //objectif 1
                if ($cadeau1 == 1) {
                    $resultat=$terrainj1[0];
                    $terrainj1[0] = $resultat+1;
                }elseif ($cadeau1 == 2) {
                    $resultat=$terrainj1[0];
                    $terrainj1[0] = $resultat+1;
                }
                //objectif2
                elseif ($cadeau1 == 3) {
                    $resultat=$terrainj1[1];
                    $terrainj1[1] = $resultat+1;
                }elseif ($cadeau1 == 4) {
                    $resultat=$terrainj1[1];
                    $terrainj1[1] = $resultat+1;
                }
                //objectif3
                elseif ($cadeau1 == 5) {
                    $resultat=$terrainj1[2];
                    $terrainj1[2] = $resultat+1;
                }elseif ($cadeau1 == 6) {
                    $resultat=$terrainj1[2];
                    $terrainj1[2] = $resultat+1;
                }
                //objectif4
                elseif ($cadeau1 == 7) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }elseif ($cadeau1 == 8) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }elseif ($cadeau1 == 9) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }
                //objectif5
                elseif ($cadeau1 == 10) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }elseif ($cadeau1 == 11) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }elseif ($cadeau1 == 12) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }
                //objectif6
                elseif ($cadeau1 == 13) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau1 == 14 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau1 == 15 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau1 == 16 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }
                //objectif7
                elseif ($cadeau1 == 17) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau1 == 18) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau1 == 19) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau1 == 20  ) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau1 == 21 ) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }


                //objectif 1
                if ($cadeau2 == 1) {
                    $resultat=$terrainj1[0];
                    $terrainj1[0] = $resultat+1;
                }elseif ($cadeau2 == 2) {
                    $resultat=$terrainj1[0];
                    $terrainj2[0] = $resultat+1;
                }
                //objectif2
                elseif ($cadeau2 == 3) {
                    $resultat=$terrainj1[1];
                    $terrainj1[1] = $resultat+1;
                }elseif ($cadeau2 == 4) {
                    $resultat=$terrainj1[1];
                    $terrainj1[1] = $resultat+1;
                }
                //objectif3
                elseif ($cadeau2 == 5) {
                    $resultat=$terrainj1[2];
                    $terrainj1[2] = $resultat+1;
                }elseif ($cadeau2 == 6) {
                    $resultat=$terrainj1[2];
                    $terrainj1[2] = $resultat+1;
                }
                //objectif4
                elseif ($cadeau2 == 7) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }elseif ($cadeau2 == 8) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }elseif ($cadeau2 == 9) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }
                //objectif5
                elseif ($cadeau2 == 10) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }elseif ($cadeau2 == 11) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }elseif ($cadeau2 == 12) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }
                //objectif6
                elseif ($cadeau2 == 13) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau2 == 14 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau2 == 15 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau2 == 16 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }
                //objectif7
                elseif ($cadeau2 == 17) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau2 == 18) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau2 == 19) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau2 == 20  ) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau2 == 21 ) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }

                //objectif 1
                if ($carteId == 1) {
                    $resultat=$terrainj2[0];
                    $terrainj2[0] = $resultat+1;
                }elseif ($carteId == 2) {
                    $resultat=$terrainj2[0];
                    $terrainj2[0] = $resultat+1;
                }
                //objectif2
                elseif ($carteId == 3) {
                    $resultat=$terrainj2[1];
                    $terrainj2[1] = $resultat+1;
                }elseif ($carteId == 4) {
                    $resultat=$terrainj2[1];
                    $terrainj2[1] = $resultat+1;
                }
                //objectif3
                elseif ($carteId == 5) {
                    $resultat=$terrainj2[2];
                    $terrainj2[2] = $resultat+1;
                }elseif ($carteId == 6) {
                    $resultat=$terrainj2[2];
                    $terrainj2[2] = $resultat+1;
                }
                //objectif4
                elseif ($carteId == 7) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }elseif ($carteId == 8) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }elseif ($carteId == 9) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }
                //objectif5
                elseif ($carteId == 10) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }elseif ($carteId == 11) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }elseif ($carteId == 12) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }
                //objectif6
                elseif ($carteId == 13) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($carteId == 14 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($carteId == 15 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($carteId == 16 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }
                //objectif7
                elseif ($carteId == 17) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($carteId == 18) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($carteId == 19) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($carteId == 20  ) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($carteId == 21 ) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }

            } elseif ($id == $joueur1) {
                $cadeaux=$partie->getCarteCadeauJ2();

                if($cadeaux[0]!=$carteId){
                    $cadeau1=$cadeaux[0];
                    if($cadeaux[1]!=$carteId){
                        $cadeau2=$cadeaux[1];
                    }
                    else{
                        $cadeau2=$cadeaux[2];
                    }
                }else{
                    $cadeau1=$cadeaux[1];
                    $cadeau2=$cadeaux[1];
                }


                //objectif 1
                if ($cadeau1 == 1) {
                    $resultat=$terrainj1[0];
                    $terrainj2[0] = $resultat+1;
                }elseif ($cadeau1 == 2) {
                    $resultat=$terrainj2[0];
                    $terrainj2[0] = $resultat+1;
                }
                //objectif2
                elseif ($cadeau1 == 3) {
                    $resultat=$terrainj2[1];
                    $terrainj2[1] = $resultat+1;
                }elseif ($cadeau1 == 4) {
                    $resultat=$terrainj2[1];
                    $terrainj2[1] = $resultat+1;
                }
                //objectif3
                elseif ($cadeau1 == 5) {
                    $resultat=$terrainj2[2];
                    $terrainj2[2] = $resultat+1;
                }elseif ($cadeau1 == 6) {
                    $resultat=$terrainj2[2];
                    $terrainj2[2] = $resultat+1;
                }
                //objectif4
                elseif ($cadeau1 == 7) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }elseif ($cadeau1 == 8) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }elseif ($cadeau1 == 9) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }
                //objectif5
                elseif ($cadeau1 == 10) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }elseif ($cadeau1 == 11) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }elseif ($cadeau1 == 12) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }
                //objectif6
                elseif ($cadeau1 == 13) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau1 == 14 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau1 == 15 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau1 == 16 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }
                //objectif7
                elseif ($cadeau1 == 17) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau1 == 18) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau1 == 19) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau1 == 20  ) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau1 == 21 ) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }


                //objectif 1
                if ($cadeau2 == 1) {
                    $resultat=$terrainj2[0];
                    $terrainj2[0] = $resultat+1;
                }elseif ($cadeau2 == 2) {
                    $resultat=$terrainj2[0];
                    $terrainj2[0] = $resultat+1;
                }
                //objectif2
                elseif ($cadeau2 == 3) {
                    $resultat=$terrainj2[1];
                    $terrainj2[1] = $resultat+1;
                }elseif ($cadeau2 == 4) {
                    $resultat=$terrainj2[1];
                    $terrainj2[1] = $resultat+1;
                }
                //objectif3
                elseif ($cadeau2 == 5) {
                    $resultat=$terrainj2[2];
                    $terrainj2[2] = $resultat+1;
                }elseif ($cadeau2 == 6) {
                    $resultat=$terrainj2[2];
                    $terrainj2[2] = $resultat+1;
                }
                //objectif4
                elseif ($cadeau2 == 7) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }elseif ($cadeau2 == 8) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }elseif ($cadeau2 == 9) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }
                //objectif5
                elseif ($cadeau2 == 10) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }elseif ($cadeau2 == 11) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }elseif ($cadeau2 == 12) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }
                //objectif6
                elseif ($cadeau2 == 13) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau2 == 14 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau2 == 15 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau2 == 16 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }
                //objectif7
                elseif ($cadeau2 == 17) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau2 == 18) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau2 == 19) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau2 == 20  ) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau2 == 21 ) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }

                //objectif 1
                if ($carteId == 1) {
                    $resultat=$terrainj1[0];
                    $terrainj1[0] = $resultat+1;
                }elseif ($carteId == 2) {
                    $resultat=$terrainj1[0];
                    $terrainj1[0] = $resultat+1;
                }
                //objectif2
                elseif ($carteId == 3) {
                    $resultat=$terrainj1[1];
                    $terrainj1[1] = $resultat+1;
                }elseif ($carteId == 4) {
                    $resultat=$terrainj1[1];
                    $terrainj1[1] = $resultat+1;
                }
                //objectif3
                elseif ($carteId == 5) {
                    $resultat=$terrainj1[2];
                    $terrainj1[2] = $resultat+1;
                }elseif ($carteId == 6) {
                    $resultat=$terrainj1[2];
                    $terrainj1[2] = $resultat+1;
                }
                //objectif4
                elseif ($carteId == 7) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }elseif ($carteId == 8) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }elseif ($carteId == 9) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }
                //objectif5
                elseif ($carteId == 10) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }elseif ($carteId == 11) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }elseif ($carteId == 12) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }
                //objectif6
                elseif ($carteId == 13) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($carteId == 14 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($carteId == 15 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($carteId == 16 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }
                //objectif7
                elseif ($carteId == 17) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($carteId == 18) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($carteId == 19) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($carteId == 20  ) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($carteId == 21 ) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }
            }

            if (!$partie) {
                throw $this->createNotFoundException(
                    'No parties found for id ' . $id
                );
            }

            if ($id == $joueur1) {
                $partie->setCarteCadeauJ2(json_encode(null));
                $partie->setTerrainJ1(json_encode($terrainj1));
                $partie->setTerrainJ2(json_encode($terrainj2));
            } elseif ($id == $joueur2) {
                $partie->setCarteCadeauJ1(json_encode(null));
                $partie->setTerrainJ1(json_encode($terrainj1));
                $partie->setTerrainJ2(json_encode($terrainj2));
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
            return $this->render('Partie/afficher.html.twig', ['partie' => $partie, 'Objets' =>$tObjets, 'objectifs' =>$tObjectifs]);
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
        $carteId = $request->request->get('paire');


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

            $terrainj1=$partie->getTerrainJ1();
            $terrainj2=$partie->getTerrainJ2();

            if ($id == $joueur2) {

                $cadeaux=$partie->getCarteConcurrenceJ1();

                if($carteId==1){

                    $cadeau1=$cadeaux[2];
                    $cadeau2=$cadeaux[3];
                    $cadeau3=$cadeaux[0];
                    $cadeau4=$cadeaux[1];

                }else{

                    $cadeau1=$cadeaux[0];
                    $cadeau2=$cadeaux[1];
                    $cadeau3=$cadeaux[2];
                    $cadeau4=$cadeaux[3];

                }

                //objectif 1
                if ($cadeau1 == 1) {
                    $resultat=$terrainj1[0];
                    $terrainj1[0] = $resultat+1;
                }elseif ($cadeau1 == 2) {
                    $resultat=$terrainj1[0];
                    $terrainj1[0] = $resultat+1;
                }
                //objectif2
                elseif ($cadeau1 == 3) {
                    $resultat=$terrainj1[1];
                    $terrainj1[1] = $resultat+1;
                }elseif ($cadeau1 == 4) {
                    $resultat=$terrainj1[1];
                    $terrainj1[1] = $resultat+1;
                }
                //objectif3
                elseif ($cadeau1 == 5) {
                    $resultat=$terrainj1[2];
                    $terrainj1[2] = $resultat+1;
                }elseif ($cadeau1 == 6) {
                    $resultat=$terrainj1[2];
                    $terrainj1[2] = $resultat+1;
                }
                //objectif4
                elseif ($cadeau1 == 7) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }elseif ($cadeau1 == 8) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }elseif ($cadeau1 == 9) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }
                //objectif5
                elseif ($cadeau1 == 10) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }elseif ($cadeau1 == 11) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }elseif ($cadeau1 == 12) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }
                //objectif6
                elseif ($cadeau1 == 13) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau1 == 14 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau1 == 15 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau1 == 16 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }
                //objectif7
                elseif ($cadeau1 == 17) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau1 == 18) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau1 == 19) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau1 == 20  ) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau1 == 21 ) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }


                //objectif 1
                if ($cadeau2 == 1) {
                    $resultat=$terrainj1[0];
                    $terrainj1[0] = $resultat+1;
                }elseif ($cadeau2 == 2) {
                    $resultat=$terrainj1[0];
                    $terrainj2[0] = $resultat+1;
                }
                //objectif2
                elseif ($cadeau2 == 3) {
                    $resultat=$terrainj1[1];
                    $terrainj1[1] = $resultat+1;
                }elseif ($cadeau2 == 4) {
                    $resultat=$terrainj1[1];
                    $terrainj1[1] = $resultat+1;
                }
                //objectif3
                elseif ($cadeau2 == 5) {
                    $resultat=$terrainj1[2];
                    $terrainj1[2] = $resultat+1;
                }elseif ($cadeau2 == 6) {
                    $resultat=$terrainj1[2];
                    $terrainj1[2] = $resultat+1;
                }
                //objectif4
                elseif ($cadeau2 == 7) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }elseif ($cadeau2 == 8) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }elseif ($cadeau2 == 9) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }
                //objectif5
                elseif ($cadeau2 == 10) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }elseif ($cadeau2 == 11) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }elseif ($cadeau2 == 12) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }
                //objectif6
                elseif ($cadeau2 == 13) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau2 == 14 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau2 == 15 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau2 == 16 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }
                //objectif7
                elseif ($cadeau2 == 17) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau2 == 18) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau2 == 19) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau2 == 20  ) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau2 == 21 ) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }

                //objectif 1
                if ($cadeau3 == 1) {
                    $resultat=$terrainj2[0];
                    $terrainj2[0] = $resultat+1;
                }elseif ($cadeau3 == 2) {
                    $resultat=$terrainj2[0];
                    $terrainj2[0] = $resultat+1;
                }
                //objectif2
                elseif ($cadeau3 == 3) {
                    $resultat=$terrainj2[1];
                    $terrainj2[1] = $resultat+1;
                }elseif ($cadeau3 == 4) {
                    $resultat=$terrainj2[1];
                    $terrainj2[1] = $resultat+1;
                }
                //objectif3
                elseif ($cadeau3 == 5) {
                    $resultat=$terrainj2[2];
                    $terrainj2[2] = $resultat+1;
                }elseif ($cadeau3 == 6) {
                    $resultat=$terrainj2[2];
                    $terrainj2[2] = $resultat+1;
                }
                //objectif4
                elseif ($cadeau3 == 7) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }elseif ($cadeau3 == 8) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }elseif ($cadeau3 == 9) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }
                //objectif5
                elseif ($cadeau3 == 10) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }elseif ($cadeau3 == 11) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }elseif ($cadeau3 == 12) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }
                //objectif6
                elseif ($cadeau3 == 13) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau3 == 14 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau3 == 15 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau3 == 16 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }
                //objectif7
                elseif ($cadeau3 == 17) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau3 == 18) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau3 == 19) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau3 == 20  ) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau3 == 21 ) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }


                //objectif 1
                if ($cadeau4 == 1) {
                    $resultat=$terrainj2[0];
                    $terrainj2[0] = $resultat+1;
                }elseif ($cadeau4 == 2) {
                    $resultat=$terrainj2[0];
                    $terrainj2[0] = $resultat+1;
                }
                //objectif2
                elseif ($cadeau4 == 3) {
                    $resultat=$terrainj2[1];
                    $terrainj2[1] = $resultat+1;
                }elseif ($cadeau4 == 4) {
                    $resultat=$terrainj2[1];
                    $terrainj2[1] = $resultat+1;
                }
                //objectif3
                elseif ($cadeau4 == 5) {
                    $resultat=$terrainj2[2];
                    $terrainj2[2] = $resultat+1;
                }elseif ($cadeau4 == 6) {
                    $resultat=$terrainj2[2];
                    $terrainj2[2] = $resultat+1;
                }
                //objectif4
                elseif ($cadeau4 == 7) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }elseif ($cadeau4 == 8) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }elseif ($cadeau4 == 9) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }
                //objectif5
                elseif ($cadeau4 == 10) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }elseif ($cadeau4 == 11) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }elseif ($cadeau4 == 12) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }
                //objectif6
                elseif ($cadeau4 == 13) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau4 == 14 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau4 == 15 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau4 == 16 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }
                //objectif7
                elseif ($cadeau4 == 17) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau4 == 18) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau4 == 19) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau4 == 20  ) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau4 == 21 ) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }


            } elseif ($id == $joueur1) {
                $cadeaux=$partie->getCarteConcurrenceJ2();

                if($carteId==2){

                    $cadeau1=$cadeaux[2];
                    $cadeau2=$cadeaux[3];
                    $cadeau3=$cadeaux[0];
                    $cadeau4=$cadeaux[1];

                }else{

                    $cadeau1=$cadeaux[0];
                    $cadeau2=$cadeaux[1];
                    $cadeau3=$cadeaux[2];
                    $cadeau4=$cadeaux[3];

                }

                //objectif 1
                if ($cadeau1 == 1) {
                    $resultat=$terrainj1[0];
                    $terrainj1[0] = $resultat+1;
                }elseif ($cadeau1 == 2) {
                    $resultat=$terrainj1[0];
                    $terrainj1[0] = $resultat+1;
                }
                //objectif2
                elseif ($cadeau1 == 3) {
                    $resultat=$terrainj1[1];
                    $terrainj1[1] = $resultat+1;
                }elseif ($cadeau1 == 4) {
                    $resultat=$terrainj1[1];
                    $terrainj1[1] = $resultat+1;
                }
                //objectif3
                elseif ($cadeau1 == 5) {
                    $resultat=$terrainj1[2];
                    $terrainj1[2] = $resultat+1;
                }elseif ($cadeau1 == 6) {
                    $resultat=$terrainj1[2];
                    $terrainj1[2] = $resultat+1;
                }
                //objectif4
                elseif ($cadeau1 == 7) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }elseif ($cadeau1 == 8) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }elseif ($cadeau1 == 9) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }
                //objectif5
                elseif ($cadeau1 == 10) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }elseif ($cadeau1 == 11) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }elseif ($cadeau1 == 12) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }
                //objectif6
                elseif ($cadeau1 == 13) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau1 == 14 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau1 == 15 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau1 == 16 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }
                //objectif7
                elseif ($cadeau1 == 17) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau1 == 18) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau1 == 19) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau1 == 20  ) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau1 == 21 ) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }


                //objectif 1
                if ($cadeau2 == 1) {
                    $resultat=$terrainj1[0];
                    $terrainj1[0] = $resultat+1;
                }elseif ($cadeau2 == 2) {
                    $resultat=$terrainj1[0];
                    $terrainj1[0] = $resultat+1;
                }
                //objectif2
                elseif ($cadeau2 == 3) {
                    $resultat=$terrainj1[1];
                    $terrainj1[1] = $resultat+1;
                }elseif ($cadeau2 == 4) {
                    $resultat=$terrainj1[1];
                    $terrainj1[1] = $resultat+1;
                }
                //objectif3
                elseif ($cadeau2 == 5) {
                    $resultat=$terrainj1[2];
                    $terrainj1[2] = $resultat+1;
                }elseif ($cadeau2 == 6) {
                    $resultat=$terrainj1[2];
                    $terrainj1[2] = $resultat+1;
                }
                //objectif4
                elseif ($cadeau2 == 7) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }elseif ($cadeau2 == 8) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }elseif ($cadeau2 == 9) {
                    $resultat=$terrainj1[3];
                    $terrainj1[3] = $resultat+1;
                }
                //objectif5
                elseif ($cadeau2 == 10) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }elseif ($cadeau2 == 11) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }elseif ($cadeau2 == 12) {
                    $resultat=$terrainj1[4];
                    $terrainj1[4] = $resultat+1;
                }
                //objectif6
                elseif ($cadeau2 == 13) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau2 == 14 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau2 == 15 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }elseif ($cadeau2 == 16 ) {
                    $resultat=$terrainj1[5];
                    $terrainj1[5] = $resultat+1;
                }
                //objectif7
                elseif ($cadeau2 == 17) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau2 == 18) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau2 == 19) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau2 == 20  ) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }elseif ($cadeau2 == 21 ) {
                    $resultat=$terrainj1[6];
                    $terrainj1[6] = $resultat+1;
                }

                //objectif 1
                if ($cadeau3 == 1) {
                    $resultat=$terrainj2[0];
                    $terrainj2[0] = $resultat+1;
                }elseif ($cadeau3 == 2) {
                    $resultat=$terrainj2[0];
                    $terrainj2[0] = $resultat+1;
                }
                //objectif2
                elseif ($cadeau3 == 3) {
                    $resultat=$terrainj2[1];
                    $terrainj2[1] = $resultat+1;
                }elseif ($cadeau3 == 4) {
                    $resultat=$terrainj2[1];
                    $terrainj2[1] = $resultat+1;
                }
                //objectif3
                elseif ($cadeau3 == 5) {
                    $resultat=$terrainj2[2];
                    $terrainj2[2] = $resultat+1;
                }elseif ($cadeau3 == 6) {
                    $resultat=$terrainj2[2];
                    $terrainj2[2] = $resultat+1;
                }
                //objectif4
                elseif ($cadeau3 == 7) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }elseif ($cadeau3 == 8) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }elseif ($cadeau3 == 9) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }
                //objectif5
                elseif ($cadeau3 == 10) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }elseif ($cadeau3 == 11) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }elseif ($cadeau3 == 12) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }
                //objectif6
                elseif ($cadeau3 == 13) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau3 == 14 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau3 == 15 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau3 == 16 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }
                //objectif7
                elseif ($cadeau3 == 17) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau3 == 18) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau3 == 19) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau3 == 20  ) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau3 == 21 ) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }


                //objectif 1
                if ($cadeau4 == 1) {
                    $resultat=$terrainj2[0];
                    $terrainj2[0] = $resultat+1;
                }elseif ($cadeau4 == 2) {
                    $resultat=$terrainj2[0];
                    $terrainj2[0] = $resultat+1;
                }
                //objectif2
                elseif ($cadeau4 == 3) {
                    $resultat=$terrainj2[1];
                    $terrainj2[1] = $resultat+1;
                }elseif ($cadeau4 == 4) {
                    $resultat=$terrainj2[1];
                    $terrainj2[1] = $resultat+1;
                }
                //objectif3
                elseif ($cadeau4 == 5) {
                    $resultat=$terrainj2[2];
                    $terrainj2[2] = $resultat+1;
                }elseif ($cadeau4 == 6) {
                    $resultat=$terrainj2[2];
                    $terrainj2[2] = $resultat+1;
                }
                //objectif4
                elseif ($cadeau4 == 7) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }elseif ($cadeau4 == 8) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }elseif ($cadeau4 == 9) {
                    $resultat=$terrainj2[3];
                    $terrainj2[3] = $resultat+1;
                }
                //objectif5
                elseif ($cadeau4 == 10) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }elseif ($cadeau4 == 11) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }elseif ($cadeau4 == 12) {
                    $resultat=$terrainj2[4];
                    $terrainj2[4] = $resultat+1;
                }
                //objectif6
                elseif ($cadeau4 == 13) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau4 == 14 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau4 == 15 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }elseif ($cadeau4 == 16 ) {
                    $resultat=$terrainj2[5];
                    $terrainj2[5] = $resultat+1;
                }
                //objectif7
                elseif ($cadeau4 == 17) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau4 == 18) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau4 == 19) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau4 == 20  ) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }elseif ($cadeau4 == 21 ) {
                    $resultat=$terrainj2[6];
                    $terrainj2[6] = $resultat+1;
                }
            }

            if (!$partie) {
                throw $this->createNotFoundException(
                    'No parties found for id ' . $id
                );
            }

            if ($id == $joueur1) {
                $partie->setCarteConcurrenceJ2(json_encode(null));
                $partie->setTerrainJ1(json_encode($terrainj1));
                $partie->setTerrainJ2(json_encode($terrainj2));
            } elseif ($id == $joueur2) {
                $partie->setCarteConcurrenceJ1(json_encode(null));
                $partie->setTerrainJ1(json_encode($terrainj1));
                $partie->setTerrainJ2(json_encode($terrainj2));
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
            return $this->render('Partie/afficher.html.twig', ['partie' => $partie, 'Objets' =>$tObjets, 'objectifs' =>$tObjectifs]);
        }
    }


    /**
     * @Route("/calcul", name="calcul")
     */
    public function calcul(Request $request)
    {
        $partieId = $request->query->get('id');


        $entityManager = $this->getDoctrine()->getManager();
        $partie = $entityManager->getRepository(Parties::class)->find($partieId);

        $cartej1=$partie->getCarteSecreteJ1();
        $cartej2=$partie->getCarteSecreteJ2();


        $terrainj1=$partie->getTerrainJ1();
        $terrainj2=$partie->getTerrainJ2();

        $jetons=$partie->getJetons();


        //objectif 1
        if ($cartej1 == 1) {
            $resultat=$terrainj1[0];
            $terrainj1[0] = $resultat+1;
        }elseif ($cartej1 == 2) {
            $resultat=$terrainj1[0];
            $terrainj1[0] = $resultat+1;
        }
        //objectif2
        elseif ($cartej1 == 3) {
            $resultat=$terrainj1[1];
            $terrainj1[1] = $resultat+1;
        }elseif ($cartej1 == 4) {
            $resultat=$terrainj1[1];
            $terrainj1[1] = $resultat+1;
        }
        //objectif3
        elseif ($cartej1 == 5) {
            $resultat=$terrainj1[2];
            $terrainj1[2] = $resultat+1;
        }elseif ($cartej1 == 6) {
            $resultat=$terrainj1[2];
            $terrainj1[2] = $resultat+1;
        }
        //objectif4
        elseif ($cartej1 == 7) {
            $resultat=$terrainj1[3];
            $terrainj1[3] = $resultat+1;
        }elseif ($cartej1 == 8) {
            $resultat=$terrainj1[3];
            $terrainj1[3] = $resultat+1;
        }elseif ($cartej1 == 9) {
            $resultat=$terrainj1[3];
            $terrainj1[3] = $resultat+1;
        }
        //objectif5
        elseif ($cartej1 == 10) {
            $resultat=$terrainj1[4];
            $terrainj1[4] = $resultat+1;
        }elseif ($cartej1 == 11) {
            $resultat=$terrainj1[4];
            $terrainj1[4] = $resultat+1;
        }elseif ($cartej1 == 12) {
            $resultat=$terrainj1[4];
            $terrainj1[4] = $resultat+1;
        }
        //objectif6
        elseif ($cartej1 == 13) {
            $resultat=$terrainj1[5];
            $terrainj1[5] = $resultat+1;
        }elseif ($cartej1 == 14 ) {
            $resultat=$terrainj1[5];
            $terrainj1[5] = $resultat+1;
        }elseif ($cartej1 == 15 ) {
            $resultat=$terrainj1[5];
            $terrainj1[5] = $resultat+1;
        }elseif ($cartej1 == 16 ) {
            $resultat=$terrainj1[5];
            $terrainj1[5] = $resultat+1;
        }
        //objectif7
        elseif ($cartej1 == 17) {
            $resultat=$terrainj1[6];
            $terrainj1[6] = $resultat+1;
        }elseif ($cartej1 == 18) {
            $resultat=$terrainj1[6];
            $terrainj1[6] = $resultat+1;
        }elseif ($cartej1 == 19) {
            $resultat=$terrainj1[6];
            $terrainj1[6] = $resultat+1;
        }elseif ($cartej1 == 20  ) {
            $resultat=$terrainj1[6];
            $terrainj1[6] = $resultat+1;
        }elseif ($cartej1 == 21 ) {
            $resultat=$terrainj1[6];
            $terrainj1[6] = $resultat+1;
        }


        //objectif 1
        if ($cartej2 == 1) {
            $resultat=$terrainj2[0];
            $terrainj2[0] = $resultat+1;
        }elseif ($cartej2 == 2) {
            $resultat=$terrainj2[0];
            $terrainj2[0] = $resultat+1;
        }
        //objectif2
        elseif ($cartej2 == 3) {
            $resultat=$terrainj2[1];
            $terrainj2[1] = $resultat+1;
        }elseif ($cartej2 == 4) {
            $resultat=$terrainj2[1];
            $terrainj2[1] = $resultat+1;
        }
        //objectif3
        elseif ($cartej2 == 5) {
            $resultat=$terrainj2[2];
            $terrainj2[2] = $resultat+1;
        }elseif ($cartej2 == 6) {
            $resultat=$terrainj2[2];
            $terrainj2[2] = $resultat+1;
        }
        //objectif4
        elseif ($cartej2 == 7) {
            $resultat=$terrainj2[3];
            $terrainj2[3] = $resultat+1;
        }elseif ($cartej2 == 8) {
            $resultat=$terrainj2[3];
            $terrainj2[3] = $resultat+1;
        }elseif ($cartej2 == 9) {
            $resultat=$terrainj2[3];
            $terrainj2[3] = $resultat+1;
        }
        //objectif5
        elseif ($cartej2 == 10) {
            $resultat=$terrainj2[4];
            $terrainj2[4] = $resultat+1;
        }elseif ($cartej2 == 11) {
            $resultat=$terrainj2[4];
            $terrainj2[4] = $resultat+1;
        }elseif ($cartej2 == 12) {
            $resultat=$terrainj2[4];
            $terrainj2[4] = $resultat+1;
        }
        //objectif6
        elseif ($cartej2 == 13) {
            $resultat=$terrainj2[5];
            $terrainj2[5] = $resultat+1;
        }elseif ($cartej2 == 14 ) {
            $resultat=$terrainj2[5];
            $terrainj2[5] = $resultat+1;
        }elseif ($cartej2 == 15 ) {
            $resultat=$terrainj2[5];
            $terrainj2[5] = $resultat+1;
        }elseif ($cartej2 == 16 ) {
            $resultat=$terrainj2[5];
            $terrainj2[5] = $resultat+1;
        }
        //objectif7
        elseif ($cartej2 == 17) {
            $resultat=$terrainj2[6];
            $terrainj2[6] = $resultat+1;
        }elseif ($cartej2 == 18) {
            $resultat=$terrainj2[6];
            $terrainj2[6] = $resultat+1;
        }elseif ($cartej2 == 19) {
            $resultat=$terrainj2[6];
            $terrainj2[6] = $resultat+1;
        }elseif ($cartej2 == 20  ) {
            $resultat=$terrainj2[6];
            $terrainj2[6] = $resultat+1;
        }elseif ($cartej2 == 21 ) {
            $resultat=$terrainj2[6];
            $terrainj2[6] = $resultat+1;
        }


        $scorej1=0;
        $scorej2=0;


        $objectifsj1=0;
        $objectifsj2=0;

        if($jetons[0]==0){

        }elseif($jetons[0]==1){
            $objectifsj1++;
        }
        elseif($jetons[0]==2){
            $objectifsj2++;
        }

        if($jetons[1]==0){

        }elseif($jetons[1]==1){
            $objectifsj1++;
        }
        elseif($jetons[1]==2){
            $objectifsj2++;
        }

        if($jetons[2]==0){

        }elseif($jetons[2]==1){
            $objectifsj1++;
        }
        elseif($jetons[2]==2){
            $objectifsj2++;
        }

        if($jetons[3]==0){

        }elseif($jetons[3]==1){
            $objectifsj1++;
        }
        elseif($jetons[3]==2){
            $objectifsj2++;
        }

        if($jetons[4]==0){

        }elseif($jetons[4]==1){
            $objectifsj1++;
        }
        elseif($jetons[4]==2){
            $objectifsj2++;
        }

        if($jetons[5]==0){

        }elseif($jetons[5]==1){
            $objectifsj1++;
        }
        elseif($jetons[5]==2){
            $objectifsj2++;
        }

        if($jetons[6]==0){

        }elseif($jetons[6]==1){
            $objectifsj1++;
        }
        elseif($jetons[6]==2){
            $objectifsj2++;
        }


        //objectif1
        if ($terrainj1[0] == $terrainj2[0]){

        }elseif ($terrainj1[0] > $terrainj2[0]){
            $jetons[0]=1;
            $scorej1=$scorej1+2;
            $objectifsj1++;
        }elseif ($terrainj1[0] < $terrainj2[0]){
            $jetons[0]=2;
            $scorej2=$scorej2+2;
            $objectifsj2++;
        }
        //objectif2
        if ($terrainj1[1] == $terrainj2[1]){

        }elseif ($terrainj1[1] > $terrainj2[1]){
            $jetons[1]=1;
            $scorej1=$scorej1+2;
            $objectifsj1++;
        }elseif ($terrainj1[1] < $terrainj2[1]){
            $jetons[1]=2;
            $scorej2=$scorej2+2;
            $objectifsj2++;
        }
        //objectif3
        if ($terrainj1[2] == $terrainj2[2]){

        }elseif ($terrainj1[2] > $terrainj2[2]){
            $jetons[2]=1;
            $scorej1=$scorej1+2;
            $objectifsj1++;
        }elseif ($terrainj1[2] < $terrainj2[2]){
            $jetons[2]=2;
            $scorej2=$scorej2+2;
            $objectifsj2++;
        }
        //objectif4
        if ($terrainj1[3] == $terrainj2[3]){

        }elseif ($terrainj1[3] > $terrainj2[3]){
            $jetons[3]=1;
            $scorej1=$scorej1+3;
            $objectifsj1++;
        }elseif ($terrainj1[3] < $terrainj2[3]){
            $jetons[3]=2;
            $scorej2=$scorej2+3;
            $objectifsj2++;
        }
        //objectif5
        if ($terrainj1[4] == $terrainj2[4]){

        }elseif ($terrainj1[4] > $terrainj2[4]){
            $jetons[4]=1;
            $scorej1=$scorej1+3;
            $objectifsj1++;
        }elseif ($terrainj1[4] < $terrainj2[4]){
            $jetons[4]=2;
            $scorej2=$scorej2+3;
            $objectifsj2++;
        }
        //objectif6
        if ($terrainj1[5] == $terrainj2[5]){

        }elseif ($terrainj1[5] > $terrainj2[5]){
            $jetons[5]=1;
            $scorej1=$scorej1+4;
            $objectifsj1++;
        }elseif ($terrainj1[5] < $terrainj2[5]){
            $jetons[5]=2;
            $scorej2=$scorej2+4;
            $objectifsj2++;
        }
        //objectif7
        if ($terrainj1[6] == $terrainj2[6]){

        }elseif ($terrainj1[6] > $terrainj2[6]){
            $jetons[6]=1;
            $scorej1=$scorej1+5;
            $objectifsj1++;
        }elseif ($terrainj1[6] < $terrainj2[6]){
            $jetons[6]=2;
            $scorej2=$scorej2+5;
            $objectifsj2++;
        }

        $partie->setTerrainJ1(json_encode($terrainj1));
        $partie->setTerrainJ2(json_encode($terrainj2));
        $partie->setTerrainJ1(json_encode($terrainj1));
        $partie->setTerrainJ2(json_encode($terrainj2));
        $partie->setScoreJ1($scorej1);
        $partie->setScoreJ2($scorej2);
        $partie->setJetons(json_encode($jetons));

        $entityManager->flush();


        $idJ1 = $partie->getJoueur1()->getId();
        $idJ2 = $partie->getJoueur2()->getId();

        $joueur1 = $entityManager->getRepository(User::class)->find($idJ1);
        $joueur2 = $entityManager->getRepository(User::class)->find($idJ2);

        if($scorej1>=11){

            $victoiresj1=$joueur1->getPartiesVictoires();
            $victoiresj1++;
            $joueur1->setPartiesVictoires($victoiresj1);

            $defaitesj2=$joueur2->getPartiesDefaites();
            $defaitesj2++;
            $joueur2->setPartiesDefaites($defaitesj2);

            $entityManager->flush();

        }elseif ($scorej2>=11){

            $victoiresj2=$joueur2->getPartiesVictoires();
            $victoiresj2++;
            $joueur2->setPartiesVictoires($victoiresj2);

            $defaitesj1=$joueur1->getPartiesDefaites();
            $defaitesj1++;
            $joueur1->setPartiesDefaites($defaitesj1);

            $entityManager->flush();

        }elseif ($objectifsj1>=4){

            $victoiresj1=$joueur1->getPartiesVictoires();
            $victoiresj1++;
            $joueur1->setPartiesVictoires($victoiresj1);

            $defaitesj2=$joueur2->getPartiesDefaites();
            $defaitesj2++;
            $joueur2->setPartiesDefaites($defaitesj2);

            $entityManager->flush();


        }elseif ($objectifsj2>=4){

            $victoiresj2=$joueur2->getPartiesVictoires();
            $victoiresj2++;
            $joueur2->setPartiesVictoires($victoiresj2);

            $defaitesj1=$joueur1->getPartiesDefaites();
            $defaitesj1++;
            $joueur1->setPartiesDefaites($defaitesj1);

            $entityManager->flush();

        }


        return $this->redirectToRoute('afficher_partie', ['id' => $partieId]);
    }

    /**
     * @Route("/plateau/{partie}", name="plateau")
     */
    public function plateau(Parties $partie){

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
        return $this->render('Partie/plateau.html.twig', ['partie' => $partie, 'Objets' =>$tObjets, 'objectifs' =>$tObjectifs]);
    }

}