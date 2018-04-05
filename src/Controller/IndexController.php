<?php
/**
 * Created by PhpStorm.
 * User: Floryne TOURRET
 * Date: 19/03/2018
 * Time: 12:24
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        $joueursco=$this->getDoctrine()->getRepository(User::class)->findBy(['actif' => 1]);
        return $this->render('Admin/index.html.twig', ['joueursco'=>$joueursco]);

    }

    /**
     * @Route("/user", name="user")
     */
    public function user()
    {
        return $this->render('User/index.html.twig');
    }

    /**
     * @Route("/user_fail", name="user_fail")
     */
    public function user_fail()
    {
        return $this->render('User/fail.html.twig');
    }

    /**
     * @Route("/connecte", name="connecte")
     */
    public function connecte()
    {
        return $this->redirectToRoute('actif');
    }

    /**
     * @Route("/connecte_admin", name="connecte_admin")
     */
    public function connecte_admin()
    {
        return $this->redirectToRoute('actif_admin');
    }

    /**
     * @Route("/user/profil", name="profil")
     */
    public function profil()
    {
        return $this->render('User/profil.html.twig');
    }

    /**
     * @Route("/admin/profil_admin", name="profil_admin")
     */
    public function profil_admin()
    {
        $joueursco=$this->getDoctrine()->getRepository(User::class)->findBy(['actif' => 1]);
        return $this->render('Admin/profil.html.twig', ['joueursco'=>$joueursco]);
    }


}