<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\Offer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Message controller.
 *
 * @Route("profile/message")
 * @Security("has_role('ROLE_USER')")
 */
class MessageController extends Controller
{
    /**
     * Lists all message entities.
     *
     * @Route("/", name="message_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        //$userId =  $this->getUser()->getId();
        $user = $this->getUser();
        $messagesSend = $this->getDoctrine()->getRepository('AppBundle:Message')->findyAllSendMessageByLoggedUser($user);
        $messagesReceiver = $this->getDoctrine()->getRepository('AppBundle:Message')->findAllReceiveredMessageByLoggedUser($user);
        return $this->render('message/index.html.twig', array(
            'messagesSend' => $messagesSend,
            'messagesReceiver' => $messagesReceiver,
            'user'=>$user
        ));
    }

    /**
     * Creates a new message entity.
     *
     * @Route("/new/{id}", name="message_new")
     * @Method({"GET", "POST"})
     */
    public function newAction($id,  Request $request)
    {
        $receiverId = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        $user = $this->getUser();
        $message = new Message();
        $form = $this->createForm('AppBundle\Form\MessageType', $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $message->setCreatedAt(new \DateTime());
            $message->setStatus('0');
            $message->setSender($user);
            $message->setReceiver($receiverId);
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('message_index');
        }

        return $this->render('message/new.html.twig', array(
            'message' => $message,
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * Finds and displays a message entity.
     *
     * @Route("/{id}", name="message_show")
     * @Method("GET")
     */
    public function showAction(Message $message)
    {
        $user = $this->getUser();
        $deleteForm = $this->createDeleteForm($message);
        if($message->getStatus() == '0'){
            $em = $this->getDoctrine()->getManager();
            $message->setStatus('1');
            $em->persist($message);
            $em->flush();
        }
        return $this->render('message/show.html.twig', array(
            'message' => $message,
            'delete_form' => $deleteForm->createView(),
            'user' => $user
        ));
    }

    /**
     * Displays a form to edit an existing message entity.
     *
     * @Route("/{id}/edit", name="message_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Message $message)
    {
        $user = $this->getUser();
        $deleteForm = $this->createDeleteForm($message);
        $editForm = $this->createForm('AppBundle\Form\MessageType', $message);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('message_edit', array('id' => $message->getId()));
        }

        return $this->render('message/edit.html.twig', array(
            'message' => $message,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $user
        ));
    }

    /**
     * Deletes a message entity.
     *
     * @Route("/{id}", name="message_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Message $message)
    {
        $user = $this->getUser();
        $form = $this->createDeleteForm($message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($message);
            $em->flush();
        }

        return $this->redirectToRoute('message_index');
    }

    /**
     * Creates a form to delete a message entity.
     *
     * @param Message $message The message entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Message $message)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('message_delete', array('id' => $message->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
