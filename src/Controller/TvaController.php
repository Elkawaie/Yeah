<?php

namespace App\Controller;

use App\Entity\Tva;
use App\Form\TvaType;
use App\Repository\TvaRepository;
use App\Repository\EntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tva")
 */
class TvaController extends Controller {

    /**
     * @Route("/", name="tva_index", methods="GET")
     */
    public function index(Request $request, TvaRepository $tvaRepository, EntrepriseRepository $entrepriseRepository): Response
    {
        $id = $request->get('id');
        return $this->render('tva/index.html.twig', ['tvas' => $tvaRepository->findAll(),
        'entreprises' => $entrepriseRepository->findBy(['id' => $id]),
        ]);
        }

        /**
         * @Route("/new", name="tva_new", methods="GET|POST")
         */
        public function new(Request $request, EntrepriseRepository $entrepriseRepository): Response
        {
        $id = $request->get('id');
        dump($id);
        $tva = new Tva();
        $form = $this->createForm(TvaType::class, $tva);
        $form->handleRequest($request);
        $id = $request->get('id');
        if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($tva);
        $em->flush();

        return $this->redirectToRoute('tva_index', ['id' => $id]);
        }

        return $this->render('tva/new.html.twig', [
                    'tva' => $tva,
                    'entreprises' => $entrepriseRepository->findBy(['id' => $id]),
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tva_show", methods="GET")
     */
    public function show(Tva $tva): Response
    {
        return $this->render('tva/show.html.twig', ['tva' => $tva]);
    }

    /**
     * @Route("/{id}/edit", name="tva_edit", methods="GET|POST")
     */
    public function edit(Request $request, Tva $tva, EntrepriseRepository $entrepriseRepository): Response
    {
        $form = $this->createForm(TvaType::class, $tva);
        $form->handleRequest($request);
        $id = $request->get('idEntreprise');
        dump($id);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tva_edit', ['id' => $tva->getId()]);
        }

        return $this->render('tva/edit.html.twig', [
                    'tva' => $tva,
                    'entreprises' => $entrepriseRepository->findBy(['id' => $id]),
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tva_delete", methods="DELETE")
     */
    public function delete(Request $request, Tva $tva): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tva->getId(), $request->request->get('_token')))
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tva);
            $em->flush();
        }

        return $this->redirectToRoute('tva_index');
    }

}
