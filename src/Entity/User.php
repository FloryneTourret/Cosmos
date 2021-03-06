<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="email", message="Email déjà pris")
 * @UniqueEntity(fields="username", message="Username déjà pris")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, length=20)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, length=100)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $actif;

    /**
     * @ORM\Column(type="integer")
     */
    private $PartiesVictoires;

    /**
     * @ORM\Column(type="integer")
     */
    private $PartiesDefaites;

    /**
     * @ORM\Column(type="integer")
     */
    private $Tutoriel;

    /**
     * @var
     *
     * @ORM\Column(type="text")
     */
    private $roles = [];

    public function getId(): int
    {
        return $this->id;
    }



    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * @param mixed $actif
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
    }

    /**
     * @return mixed
     */
    public function getPartiesVictoires()
    {
        return $this->PartiesVictoires;
    }

    /**
     * @param mixed $PartiesVictoires
     */
    public function setPartiesVictoires($PartiesVictoires)
    {
        $this->PartiesVictoires = $PartiesVictoires;
    }

    /**
     * @return mixed
     */
    public function getPartiesDefaites()
    {
        return $this->PartiesDefaites;
    }

    /**
     * @param mixed $PartiesDefaites
     */
    public function setPartiesDefaites($PartiesDefaites)
    {
        $this->PartiesDefaites = $PartiesDefaites;
    }

    /**
     * @return mixed
     */
    public function getTutoriel()
    {
        return $this->Tutoriel;
    }

    /**
     * @param mixed $Tutoriel
     */
    public function setTutoriel($Tutoriel)
    {
        $this->Tutoriel = $Tutoriel;
    }



    /**
     * Retourne les rôles de l'user
     */
    public function getRoles(): array
    {
        $roles = json_decode($this->roles, true);

        // Afin d'être sûr qu'un user a toujours au moins 1 rôle
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = json_encode($roles);
    }

    /**
     * Retour le salt qui a servi à coder le mot de passe
     *
     * {@inheritdoc}
     */
    public function getSalt(): ?string
    {
        // See "Do you need to use a Salt?" at https://symfony.com/doc/current/cookbook/security/entity_provider.html
        // we're using bcrypt in security.yml to encode the password, so
        // the salt value is built-in and you don't have to generate one

        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        // Nous n'avons pas besoin de cette methode car nous n'utilions pas de plainPassword
        // Mais elle est obligatoire car comprise dans l'interface UserInterface
        // $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return serialize([$this->id, $this->username, $this->password]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        [$this->id, $this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }
}