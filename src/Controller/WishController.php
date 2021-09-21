<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wish-list", name="wish")
     */
    public function afficherLaListe(WishRepository $rep): Response
    {
        $mywishes = $rep->findBy(  array('isPublished'=> true),  array('dateCreated' => 'DESC'));
     
        return $this->render('wish/index.html.twig', [
            'list_wishes' => $mywishes,
        ]);
    }


    /**
     * @Route("/wish/{id}", name="wishitem")
     */
    public function afficherWish(Wish $mywish, WishRepository $rep): Response
    {
       
        return $this->render('wish/mywish.html.twig', [
            'mywish' => $mywish,
        ]);
    }
       
}
