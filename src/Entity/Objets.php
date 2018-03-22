<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObjetsRepository")
 */
class Objets
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $objet_id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $carte_nom;

    /**
     * @ORM\Column(type="integer", length=1)
     */
    private $carte_points;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $carte_img;

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
    public function getObjetId()
    {
        return $this->objet_id;
    }

    /**
     * @param mixed $objet_id
     */
    public function setObjetId($objet_id)
    {
        $this->objet_id = $objet_id;
    }

    /**
     * @return mixed
     */
    public function getCarteNom()
    {
        return $this->carte_nom;
    }

    /**
     * @param mixed $carte_nom
     */
    public function setCarteNom($carte_nom)
    {
        $this->carte_nom = $carte_nom;
    }

    /**
     * @return mixed
     */
    public function getCartePoints()
    {
        return $this->carte_points;
    }

    /**
     * @param mixed $carte_points
     */
    public function setCartePoints($carte_points)
    {
        $this->carte_points = $carte_points;
    }

    /**
     * @return mixed
     */
    public function getCarteImg()
    {
        return $this->carte_img;
    }

    /**
     * @param mixed $carte_img
     */
    public function setCarteImg($carte_img)
    {
        $this->carte_img = $carte_img;
    }


}
