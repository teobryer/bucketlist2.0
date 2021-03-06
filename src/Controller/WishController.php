<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/delete_wish/{id}", name="delete_wish")
     */
    public function enlever(Wish $wish, EntityManagerInterface $em): Response
    {
       // $em = $this->getDoctrine()->getManager();
        $em->remove($wish);
        $em->flush();
        return $this->redirectToRoute('wish');
    }



     /**
     * @Route("/add_wish/", name="add_wish")
     */
    public function ajouter(Request $request): Response
    {
        $wish = new Wish();
        // associe obj personne au Form.
        $formWish = $this->createForm(WishType::class,$wish);
        // hydraté $personne en fct du formulaire
        $formWish->handleRequest($request);
        // si le form est validé.
        if ($formWish->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($wish);
            $wish->setDateCreated(new \DateTime());
            $wish->setIsPublished(true);
            $em->flush();
            // je redirig\
            return $this->redirectToRoute('wish');
        }
        return $this->render('wish/add_wish.html.twig',
            ['formWish'=> $formWish->createView()]);
    }



     /**
     * @Route("/modifier_wish/{id}", name="modifier_wish")
     */
    public function modifier(Wish $wish ,Request $request): Response
    {
      //  $wish = new Wish();
        // associe obj personne au Form.
        $formWish = $this->createForm(WishType::class,$wish);
        // hydraté $personne en fct du formulaire
        $formWish->handleRequest($request);
        // si le form est validé.
        if ($formWish->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
           
            $wish->setDateCreated(new \DateTime());
            $wish->setIsPublished(true);
            $em->flush();
            // je redirig\
            return $this->redirectToRoute('wish');
        }
        return $this->render('wish/modifier_wish.html.twig',
            ['formWish'=> $formWish->createView()]);
    }
       
}
