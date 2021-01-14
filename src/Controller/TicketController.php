<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Ticket;
use App\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    /**
     * @Route("/ticket", name="ticket")
     */
    public function index(): Response
    {
        return $this->render('ticket/index.html.twig', [
            'tickets' => $this->getDoctrine()->getRepository('App:Ticket')->findAll()
        ]);
    }

    /**
     * @Route("/ticket/new", name="ticket_new")
     */
    public function newAction(Request $request): Response{
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ticket = $form->getData();
            $ticket->setCreator($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
            $entityManager->flush();
            $this->addFlash('success', 'Nouveau Ticket créé !');
            return $this->redirectToRoute('ticket');
        }
        return $this->render('ticket/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/ticket/{id}/edit", name="ticket_edit")
     */
    public function editAction(Request $request, Ticket $ticket): Response{
        $form = $this->createForm(TicketType::class, $ticket);
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(array(
           'ticket' => $ticket
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
            $entityManager->flush();
            $this->addFlash('success', 'Ticket mis à jour !');
            return $this->redirectToRoute('ticket', array('id'=> $ticket->getId()));
        }
        return $this->render('ticket/edit.html.twig', [
            'form' => $form->createView(),
            'ticket' => $ticket,
            'comments' => $comments
        ]);
    }
}
