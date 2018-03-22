<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartiesRepository")
 */
class Parties
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $partie_nom;

    /**
     * @ORM\Column(type="datetime", name="commence_le")
     */
    private $partie_date;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $partie_tour;

    /**
     * @ORM\Column(type="integer")
     */
    private $partie_manche;

    /**
     * @var
     * @ORM\Column(type="text")
     */
    private $partie_pioche;

    /**
     * @var
     * @ORM\Column(type="text")
     */
    private $partie_objectifs;


    /**
     * @var Joueur
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $joueur1;

    /**
     * @var Joueur
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $joueur2;


    /**
     * @var
     * @ORM\Column(type="text")
     */
    private $main_j1;

    /**
     * @var
     * @ORM\Column(type="text")
     */
    private $main_j2;

    /**
     * @var
     * @ORM\Column(type="text")
     */
    private $action_j1;

    /**
     * @var
     * @ORM\Column(type="text")
     */
    private $action_j2;

    /**
     * @var
     * @ORM\Column(type="integer")
     */
    private $carte_jetee;


    /**
     * @var
     * @ORM\Column(type="text")
     */
    private $terrain_j1;

    /**
     * @var
     * @ORM\Column(type="text")
     */
    private $terrain_j2;

    /**
     * @ORM\Column(type="integer")
     */
    private $score_j1;

    /**
     * @ORM\Column(type="integer")
     */
    private $score_j2;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPartieNom()
    {
        return $this->partie_nom;
    }

    /**
     * @param mixed $partie_nom
     */
    public function setPartieNom($partie_nom)
    {
        $this->partie_nom = $partie_nom;
    }

    /**
     * @return mixed
     */
    public function getPartieDate()
    {
        return $this->partie_date;
    }

    /**
     * @param mixed $partie_date
     */
    public function setPartieDate($partie_date)
    {
        $this->partie_date = $partie_date;
    }

    /**
     * @return mixed
     */
    public function getPartieTour()
    {
        return $this->partie_tour;
    }

    /**
     * @param mixed $partie_tour
     */
    public function setPartieTour($partie_tour)
    {
        $this->partie_tour = $partie_tour;
    }

    /**
     * @return mixed
     */
    public function getPartieManche()
    {
        return $this->partie_manche;
    }

    /**
     * @param mixed $partie_manche
     */
    public function setPartieManche($partie_manche)
    {
        $this->partie_manche = $partie_manche;
    }

    /**
     * @return mixed
     */
    public function getPartiePioche()
    {
        return json_decode($this->partie_pioche);
    }

    /**
     * @param mixed $partie_pioche
     */
    public function setPartiePioche($partie_pioche)
    {
        $this->partie_pioche = $partie_pioche;
    }

    /**
     * @return mixed
     */
    public function getPartieObjectifs()
    {
        return $this->partie_objectifs;
    }

    /**
     * @param mixed $partie_objectifs
     */
    public function setPartieObjectifs($partie_objectifs)
    {
        $this->partie_objectifs = $partie_objectifs;
    }

    /**
     * @return Joueur
     */
    public function getJoueur1()
    {
        return $this->joueur1;
    }

    /**
     * @param Joueur $joueur1
     */
    public function setJoueur1($joueur1)
    {
        $this->joueur1 = $joueur1;
    }

    /**
     * @return Joueur
     */
    public function getJoueur2()
    {
        return $this->joueur2;
    }

    /**
     * @param Joueur $joueur2
     */
    public function setJoueur2($joueur2)
    {
        $this->joueur2 = $joueur2;
    }

    /**
     * @return mixed
     */
    public function getMainJ1()
    {

        return json_decode($this->main_j1);
    }

    /**
     * @param mixed $main_j1
     */
    public function setMainJ1($main_j1)
    {
        $this->main_j1 = $main_j1;
    }

    /**
     * @return mixed
     */
    public function getMainJ2()
    {
        return json_decode($this->main_j2);
    }

    /**
     * @param mixed $main_j2
     */
    public function setMainJ2($main_j2)
    {
        $this->main_j2 = $main_j2;
    }

    /**
     * @return mixed
     */
    public function getActionJ1()
    {
        return json_decode($this->action_j1);
    }

    /**
     * @param mixed $action_j1
     */
    public function setActionJ1($action_j1)
    {
        $this->action_j1 = $action_j1;
    }

    /**
     * @return mixed
     */
    public function getActionJ2()
    {
        return json_decode( $this->action_j2);
    }

    /**
     * @param mixed $action_j2
     */
    public function setActionJ2($action_j2)
    {
        $this->action_j2 = $action_j2;
    }

    /**
     * @return mixed
     */
    public function getCarteJetee()
    {
        return $this->carte_jetee;
    }

    /**
     * @param mixed $carte_jetee
     */
    public function setCarteJetee($carte_jetee)
    {
        $this->carte_jetee = $carte_jetee;
    }

    /**
     * @return mixed
     */
    public function getTerrainJ1()
    {
        return json_decode($this->terrain_j1);
    }

    /**
     * @param mixed $terrain_j1
     */
    public function setTerrainJ1($terrain_j1)
    {
        $this->terrain_j1 = $terrain_j1;
    }

    /**
     * @return mixed
     */
    public function getTerrainJ2()
    {
        return json_decode($this->terrain_j2);
    }

    /**
     * @param mixed $terrain_j2
     */
    public function setTerrainJ2($terrain_j2)
    {
        $this->terrain_j2 = $terrain_j2;
    }

    /**
     * @return mixed
     */
    public function getScoreJ1()
    {
        return $this->score_j1;
    }

    /**
     * @param mixed $score_j1
     */
    public function setScoreJ1($score_j1)
    {
        $this->score_j1 = $score_j1;
    }

    /**
     * @return mixed
     */
    public function getScoreJ2()
    {
        return $this->score_j2;
    }

    /**
     * @param mixed $score_j2
     */
    public function setScoreJ2($score_j2)
    {
        $this->score_j2 = $score_j2;
    }



}
