<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObjectifsRepository")
 */
class Objectifs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $objectif_img;

    /**
     * @ORM\Column(type="integer", length=1)
     */
    private $objectif_points;

    /**
     * @ORM\Column(type="integer", length=1)
     */
    private $objectif_ordre;

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
    public function getObjectifImg()
    {
        return $this->objectif_img;
    }

    /**
     * @param mixed $objectif_img
     */
    public function setObjectifImg($objectif_img)
    {
        $this->objectif_img = $objectif_img;
    }

    /**
     * @return mixed
     */
    public function getObjectifPoints()
    {
        return $this->objectif_points;
    }

    /**
     * @param mixed $objectif_points
     */
    public function setObjectifPoints($objectif_points)
    {
        $this->objectif_points = $objectif_points;
    }

    /**
     * @return mixed
     */
    public function getObjectifOrdre()
    {
        return $this->objectif_ordre;
    }

    /**
     * @param mixed $objectif_ordre
     */
    public function setObjectifOrdre($objectif_ordre)
    {
        $this->objectif_ordre = $objectif_ordre;
    }


}
