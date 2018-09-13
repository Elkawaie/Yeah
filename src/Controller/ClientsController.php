<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientsType;
use App\Repository\ClientsRepository;
use App\Repository\EntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/clients")
 */
class ClientsController extends Controller
{
    /**
     * @Route("/", name="clients_index", methods="GET")
     */
    public function index(ClientsRepository $clientsRepository): Response
    {
        return $this->render('clients/index.html.twig', ['clients' => $clientsRepository->findAll()]);
    }

    /**
     * @Route("/new", name="clients_new", methods="GET|POST")
     */
    public function new(Request $request, EntrepriseRepository $entrepriseRepository): Response
    {
        $id = $request->get('id');
        $client = new Clients();
        $form = $this->createForm(ClientsType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('evenements_index', ['id' => $id]);
        }

        return $this->render('clients/new.html.twig', [
            'entreprises' => $entrepriseRepository->findBy(['id' => $id]),
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="clients_show", methods="GET")
     */
    public function show(Clients $client): Response
    {
        return $this->render('clients/show.html.twig', ['client' => $client]);
    }

    /**
     * @Route("/{id}/edit", name="clients_edit", methods="GET|POST")
     */
    public function edit(Request $request, Clients $client): Response
    {
        $form = $this->createForm(ClientsType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenements_index', ['id' => $client = $request->get('idEntreprise')]);
        }

        return $this->render('clients/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="clients_delete", methods="DELETE")
     */
    public function delete(Request $request, Clients $client): Response
    {
        $id = $request->get('idEntreprise');
        
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($client);
            $em->flush();
        }

    return $this->redirectToRoute('evenements_index', ['id' => $id]);
    }
}
