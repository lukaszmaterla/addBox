<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Offer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class OfferController extends Controller
{
//    /**
//     * Lists all offer entities.
//     *
//     * @Route("/", name="offer_index")
//     * @Method("GET")
//     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $offers = $em->getRepository('AppBundle:Offer')->findAll();

        return $this->render('offer/index.html.twig', array(
            'offers' => $offers,
        ));
    }

    /**
     * Creates a new offer entity.
     *
     * @Route("offer/new", name="offer_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();

        $offer = new Offer();
        $form = $this->createForm('AppBundle\Form\OfferType', $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $offer->setUser($user);
            $offer->setExpiredAt(new \DateTime());
            $em->persist($offer);
            $em->flush();

            return $this->redirectToRoute('offer_show', array('id' => $offer->getId(), 'user' => $user));
        }

        return $this->render('offer/new.html.twig', array(
            'offer' => $offer,
            'form' => $form->createView(),
            'user' => $user

        ));
    }

    /**
     * Finds and displays a offer entity.
     *
     * @Route("offer/{id}", name="offer_show")
     * @Method({"GET","POST"})
     *
     */
    public function showAction(Request $request, Offer $offer)
    {
        $user = $this->getUser();
        $comment = new Comment();
        $formComment = $this->createForm('AppBundle\Form\CommentType', $comment);
        $formComment->handleRequest($request);
        $offerUser = $offer->getUser();
        if ($formComment->isSubmitted() && $formComment->isValid()) {

            $this->sendEmailtoOfferOwner($offerUser->getEmail(),$offer, $comment );

            $em = $this->getDoctrine()->getManager();
            $comment->setOffer($offer);
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('offer_show', array('id' => $offer->getId()));
        }


        return $this->render('offer/show.html.twig', array(
            'offer' => $offer,
            'user' => $user,
            'formComment'=>$formComment->createView()
        ));
    }

    /**
     * Displays a form to edit an existing offer entity.
     *
     * @Route("offer/{id}/edit", name="offer_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(Request $request, Offer $offer)
    {
        $user = $this->getUser();
        $deleteForm = $this->createDeleteForm($offer);
        $editForm = $this->createForm('AppBundle\Form\OfferType', $offer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('offer_edit', array('id' => $offer->getId()));
        }

        return $this->render('offer/edit.html.twig', array(
            'offer' => $offer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $user
        ));
    }

    /**
     * Deletes a offer entity.
     *
     * @Route("offer/{id}", name="offer_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Request $request, Offer $offer)
    {
        $user = $this->getUser();
        $form = $this->createDeleteForm($offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($offer);
            $em->flush();
        }

        return $this->redirectToRoute('app_useroffer_showbyuser', ['user' => $user]);
    }

    /**
     * Creates a form to delete a offer entity.
     *
     * @param Offer $offer The offer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Offer $offer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('offer_delete', array('id' => $offer->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    private function sendEmailtoOfferOwner($userEmail, Offer $offer, Comment $comment){

        $mail = \Swift_Message::newInstance()
            ->setSubject('New comment to your offer '.$offer->getTitle())
            ->setFrom('symfony.examplemailer@gmail.com')
            ->setTo($userEmail)
            ->setBody($this->renderView(':email:new_comment_email.html.twig',['offer'=>$offer, 'comment'=>$comment])
                ,'text/html');
        $this->get('mailer')->send($mail);

    }
}
