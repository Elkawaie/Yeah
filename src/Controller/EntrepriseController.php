<?php

namespace App\Controller;


use App\Entity\Entreprise;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use App\Repository\ClientsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/entreprise")
 */
class EntrepriseController extends Controller
{
    /**
     * @Route("/", name="entreprise_index", methods="GET")
     */
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        return $this->render('entreprise/index.html.twig', ['entreprises' => $entrepriseRepository->findAll()]);
    }
    
    /**
     * @Route("/dashboard", name="index", methods="GET")
     */
    public function dashboard(Request $request, EntrepriseRepository $entrepriseRepository, ClientsRepository $clientRepository, UserInterface $user): Response
    {
      
       //$entreprise->getId();

       $idEntreprise = $request->get('id');
       
        
        return $this->render('entreprise/dashboard.html.twig', [
            'entreprises' => $entrepriseRepository->findAll(),
            'clients' => $clientRepository->findByEntreprise($idEntreprise)
                ]);
    }

    /**
     * @Route("/new", name="entreprise_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $entreprise = new Entreprise();
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();

            return $this->redirectToRoute('entreprise_index');
        }

        return $this->render('entreprise/new.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entreprise_show", methods="GET")
     */
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('entreprise/show.html.twig', ['entreprise' => $entreprise]);
    }

    /**
     * @Route("/{id}/edit", name="entreprise_edit", methods="GET|POST")
     */
    public function edit(Request $request, Entreprise $entreprise): Response
    {
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entreprise_edit', ['id' => $entreprise->getId()]);
        }

        return $this->render('entreprise/edit.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entreprise_delete", methods="DELETE")
     */
    public function delete(Request $request, Entreprise $entreprise): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entreprise->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entreprise);
            $em->flush();
        }

        return $this->redirectToRoute('entreprise_index');
    }
}
