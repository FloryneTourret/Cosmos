<?php
namespace App\Controller;
use App\Entity\User;
use App\Entity\Objets;
use App\Entity\Objectifs;
use App\Entity\Parties;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/**
 * Class PartieController
 * @package App\Controller
 * @Route("user/partie")
 */
class PartieController extends Controller
{

    /**
     * @Route("/tutoriel", name="tutoriel")
     */
    public function tutoriel()
    {
        return $this->render('Partie/tutoriel.html.twig');
    }


    /**
     * @Route("/tutoriel_fini", name="tutoriel_fini")
     */
    public function tutoriel_fini()
    {

        $user = $this->getUser();
        if($user) {
            $id = $user->getId();
        } else {
            $id = "Pas d'Id";
        }

        $entityManager = $this->getDoctrine()->getManager();
        $joueur = $entityManager->getRepository(User::class)->find($id);

        if (!joueur) {
            throw $this->createNotFoundException(
                'No username found for id '.$id
            );
        }

        $joueur->setTutoriel(1);
        $entityManager->flush();

        return $this->redirectToRoute('choix_partie');
    }


    /**
     * @Route("/nouvelle", name="nouvelle_partie")
     */
    public function nouvellePartie()
    {
        //Récupère tous les joueurs
        //$joueurs = $this->getDoctrine()->getRepository(User::class)->findAll();
        //Récupère les joueurs actifs
        $joueurs=  $this->getDoctrine()->getRepository(User::class)->findBy(['actif' => 1]);
        return $this->render('Partie/nouvelle.html.twig', ['joueurs' => $joueurs]);
    }
    /**
     * @Route("/creer", name="creer_partie")
     */
    public function creerPartie(Request $request)
    {
        $user = $this->getUser();
        if($user) {
            $id = $user->getId();
        } else {
            $id = "Pas d'Id";
        }
        $idAdversaire = $request->request->get('adversaire');
        $joueur = $this->getDoctrine()->getRepository(User::class)->find($id);
        $adversaire = $this->getDoctrine()->getRepository(User::class)->find($idAdversaire);
        //récupérer les objectifs depuis la base de données
        $objectifs = $this->getDoctrine()->getRepository(Objectifs::class)->findAll();
        $tObjectifs = array();
        //récupérer les Objets depuis la base de données
        $Objets = $this->getDoctrine()->getRepository(Objets::class)->findAll();
        $tObjets = array();
        //Affecter des valeurs pour les différentes propriétés de partie
        foreach ($objectifs as $objectifs) {
            $tObjectifs[] = $objectifs->getId();
        }
        //Affecter des valeurs pour les différentes propriétés de partie
        //mélanger les Objets
        foreach ($Objets as $carte) {
            $tObjets[] = $carte->getId();
        }
        shuffle($tObjets); //mélange le tableau contenant les id
        //retrait de la première carte
        $carte_jetee = array_pop($tObjets);
        //Distribution des Objets aux joueurs,
        $main_j1 = array();
        for ($i = 0; $i < 7; $i++) {
            $tMainJ1[] = array_pop($tObjets);
        }
        $main_j2 = array();
        for ($i = 0; $i < 6; $i++) {
            $tMainJ2[] = array_pop($tObjets);
        }
        //La création de la pioche
        $partie_pioche = $tObjets; //sauvegarde des dernières Objets dans la pioche
        //Initialiser actions à 0
        $actions=array(0,0,0,0);
        //Initialiser objectifs à 0
        $objectifs=array(0,0,0,0,0,0,0);

        $nom_partie= $request->request->get('nom_partie');

        //créer un objet de type Partie
        $partie = new Parties();
        $partie->setPartieNom($nom_partie);
        $partie->setPartieDate(new \DateTime("now"));
        $partie->setPartieTour(1);
        $partie->setPartieManche(1);
        $partie->setJoueur1($joueur);
        $partie->setJoueur2($adversaire);
        $partie->setCarteJetee($carte_jetee);
        $partie->setCarteSecreteJ1(json_encode(null));
        $partie->setCarteSecreteJ2(json_encode(null));
        $partie->setCarteDissimuleeJ1(json_encode(null));
        $partie->setCarteDissimuleeJ2(json_encode(null));
        $partie->setCarteCadeauJ1(json_encode(null));
        $partie->setCarteCadeauJ2(json_encode(null));
        $partie->setCarteConcurrenceJ1(json_encode(null));
        $partie->setCarteConcurrenceJ2(json_encode(null));
        $partie->setMainJ1(json_encode($tMainJ1));
        $partie->setMainJ2(json_encode($tMainJ2));
        $partie->setActionJ1(json_encode($actions));
        $partie->setActionJ2(json_encode($actions));
        $partie->setTerrainJ1(json_encode($objectifs));
        $partie->setTerrainJ2(json_encode($objectifs));
        $partie->setJetons(json_encode($objectifs));
        $partie->setScoreJ1(0);
        $partie->setScoreJ2(0);
        $partie->setPartiePioche($partie_pioche);
        $partie->setPartieObjectifs(json_encode($tObjectifs));
        //Récupérer le manager de doctrine
        $em = $this->getDoctrine()->getManager();
        //Sauvegarde mon objet Partie dans la base de données
        $em->persist($partie);
        $em->flush();
        return $this->redirectToRoute('afficher_partie', ['id' => $partie->getId()]);
    }
    /**
     * @Route("/afficher/{id}", name="afficher_partie")
     */
    public function afficherPartie(Parties $partie)
    {
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

    /**
     * @Route("/continuer", name="continuer_partie")
     */
    public function continuerPartie()
    {
        $user = $this->getUser();
        if($user) {
            $id = $user->getId();
        } else {
            $id = "Pas d'Id";
        }
        //Récupère les parties avec le joueur dedans
        $parties=  $this->getDoctrine()->getRepository(Parties::class)->findPartiesJoueur($id);
        return $this->render('Partie/continuer.html.twig', ['parties' => $parties]);
    }

    /**
     * @Route("/lancer", name="lancer_partie")
     */
    public function lancerPartie(Request $request)
    {
        $partie_recup = $request->request->get('id');
        $partie = $this->getDoctrine()->getRepository(Parties::class)->find($partie_recup);
        return $this->redirectToRoute('afficher_partie', ['id' => $partie->getId()]);
    }

    /**
     * @Route("/nouvelle_manche", name="nouvelle_manche")
     */
    public function nouvelle_manche(Request $request)
    {
        $partie_recup = $request->request->get('id');

        $entityManager = $this->getDoctrine()->getManager();
        $partie = $entityManager->getRepository(Parties::class)->find($partie_recup);

        //manche suivante
        $manche_ancienne=$partie->getPartieManche();
        $manche = $manche_ancienne +1;

       //actions à 0
        $actions=[0,0,0,0];


        //récupérer les Objets depuis la base de données
        $Objets = $this->getDoctrine()->getRepository(Objets::class)->findAll();
        $tObjets = array();

        //Affecter des valeurs pour les différentes propriétés de partie
        //mélanger les Objets
        foreach ($Objets as $carte) {
            $tObjets[] = $carte->getId();
        }

        shuffle($tObjets); //mélange le tableau contenant les id
        //retrait de la première carte
        $carte_jetee = array_pop($tObjets);
        //Distribution des Objets aux joueurs,
        $main_j1 = array();
        for ($i = 0; $i < 7; $i++) {
            $tMainJ1[] = array_pop($tObjets);
        }
        $main_j2 = array();
        for ($i = 0; $i < 6; $i++) {
            $tMainJ2[] = array_pop($tObjets);
        }

        //La création de la pioche
        $partie_pioche = $tObjets; //sauvegarde des dernières Objets dans la pioche

        //terrain remis à 0
        $objectifs=array(0,0,0,0,0,0,0);

        $partie->setPartieTour(1);
        $partie->setPartieManche($manche);
        $partie->setCarteJetee($carte_jetee);
        $partie->setMainJ1(json_encode($tMainJ1));
        $partie->setMainJ2(json_encode($tMainJ2));
        $partie->setActionJ1(json_encode($actions));
        $partie->setActionJ2(json_encode($actions));
        $partie->setScoreJ1(0);
        $partie->setScoreJ2(0);
        $partie->setPartiePioche($partie_pioche);
        $partie->setCarteSecreteJ1(json_encode(null));
        $partie->setCarteSecreteJ2(json_encode(null));
        $partie->setCarteDissimuleeJ1(json_encode(null));
        $partie->setCarteDissimuleeJ2(json_encode(null));
        $partie->setTerrainJ1(json_encode($objectifs));
        $partie->setTerrainJ2(json_encode($objectifs));


        //Sauvegarde mon objet Partie dans la base de données
        $entityManager->persist($partie);

        $entityManager->flush();

        return $this->redirectToRoute('afficher_partie', ['id' => $partie->getId()]);
    }

    /**
     * @Route("/retour", name="retour")
     */
    public function retour(Request $request)
    {
        $partie_recup = $request->request->get('id');
        $partie = $this->getDoctrine()->getRepository(Parties::class)->find($partie_recup);
        return $this->redirectToRoute('afficher_partie', ['id' => $partie->getId()]);
    }

    /**
     * @Route("/choix_partie", name="choix_partie")
     */
    public function choix_partie()
    {
        return $this->render('Partie/choix.html.twig');
    }

}