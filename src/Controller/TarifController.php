<?php

namespace App\Controller;

use App\Entity\Tarif;
use App\Form\TarifType;
use App\Repository\TarifRepository;
use App\Repository\EntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tarif")
 */
class TarifController extends Controller {

    /**
     * @Route("/", name="tarif_index", methods="GET")
     */
    public function index(Request $request, TarifRepository $tarifRepository, EntrepriseRepository $entrepriseRepository): Response
    {
        $id = $request->get('id');

        return $this->render('tarif/index.html.twig', [
        'tarifs' => $tarifRepository->findAll(),
        'idEntreprise' => $id,
        'entreprises' => $entrepriseRepository->findBy(['id' => $id])
        ]);
        }

        /**
         * @Route("/new", name="tarif_new", methods="GET|POST")
         */
        public function new(Request $request, EntrepriseRepository $entrepriseRepository): Response
        {
        $id = $request->get('idEntreprise');
        $tarif = new Tarif();
        $idtarif = $tarif->getId();
        $idEntreprise = $entrepriseRepository->findOneBy(['id' => $id]);
        $tarif->addFkEntrepriseTarif($idEntreprise);
        $form = $this->createForm(TarifType::class, $tarif, ['id' => $id]);
        $form->handleRequest($request);
       

       

        if ($form->isSubmitted() && $form->isValid()) {

        $em = $this->getDoctrine()->getManager();
        $em->persist($tarif);
        $em->flush();

        return $this->redirectToRoute('tarif_index',[
                    'id' => $id,        
        ]);
        }

        return $this->render('tarif/new.html.twig', [
                    'tarif' => $tarif,
                    'entreprises' => $entrepriseRepository->findBy(['id' => $id]),
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tarif_show", methods="GET")
     */
    public function show(Tarif $tarif): Response
    {
        return $this->render('tarif/show.html.twig', ['tarif' => $tarif]);
    }

    /**
     * @Route("/{id}/edit", name="tarif_edit", methods="GET|POST")
     */
    public function edit(Request $request, Tarif $tarif, EntrepriseRepository $entrepriseRepository): Response
    {
        $id = $request->get('idEntreprise');
        //$idEntreprise = $entrepriseRepository->findOneBy(['id' => $id]);
        //$tarif->addFkEntrepriseTarif($idEntreprise);
        //dump($tarif);
        //exit();
        $form = $this->createForm(TarifType::class, $tarif, ['id' => $id]);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid())
        {
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tarif_index', ['id' => $id]);
        }

        return $this->render('tarif/edit.html.twig', [
                    'tarif' => $tarif,
                    'entreprises' => $entrepriseRepository->findBy(['id' => $id]),
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tarif_delete", methods="DELETE")
     */
    public function delete(Request $request, Tarif $tarif): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tarif->getId(), $request->request->get('_token')))
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tarif);
            $em->flush();
        }

        return $this->redirectToRoute('tarif_index');
    }

}
