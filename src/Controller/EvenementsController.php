<?php

namespace App\Controller;

use App\Entity\Evenements;
use App\Form\EvenementsType;
use App\Form\EvenementsAType;
use App\Form\EvenementsBType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\TarifRepository;
use App\Repository\EvenementsRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\ClientsRepository;
use App\Repository\TvaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evenements")
 */
class EvenementsController extends Controller {

    /**
     * @Route("/new", name="evenements_new", methods="GET|POST")
     */
    public function add(Request $request, TarifRepository $tarif, EntrepriseRepository $entreprise, ClientsRepository $client, EvenementsRepository $evenements): Response
    {
        $evenement = new Evenements();
        if ($request->get('type') == true)
        {
            // je récupére les paramétres de l'url
            $idEntreprise = $request->get('id');
            $IdTarif = $request->get('tarif');
            $idClient = $request->get('idClient');

            echo "mon Form de type A";
            // ici je crée des objet en fonction de chaque entité grace a leur repository
            $clientId = $client->findOneBy(['id' => $idClient]);
            $entrepriseId = $entreprise->findOneBy(['id' => $idEntreprise]);
            $tarifId = $tarif->findOneBy(array('id' => $IdTarif));

            // ici j'hydrate les clef etrangére de mon objet evenement 
            $evenement->setfkTarif($tarifId);
            $evenement->setfkEntreprise($entrepriseId);
            $evenement->setfkClient($clientId);

            $form = $this->createForm(EvenementsAType::class, $evenement, [
                'idTarif' => $tarifId->getId(),
                'idEntreprise' => $idEntreprise,
                'idClient' => $idClient,
            ]);
        }
        else
        {
            $idEntreprise = $request->get('id');
            $IdTarif = $request->get('tarif');
            $idClient = $request->get('idClient');

            $clientId = $client->findOneBy(['id' => $idClient]);
            $entrepriseId = $entreprise->findOneBy(['id' => $idEntreprise]);
            $tarifId = $tarif->findOneBy(array('id' => $IdTarif));

            $evenement->setQuantite('1');
            $evenement->setfkTarif($tarifId);
            $evenement->setfkEntreprise($entrepriseId);
            $evenement->setfkClient($clientId);
            echo "mon Form de type B";
            $form = $this->createForm(EvenementsBType::class, $evenement, [
                'idTarif' => $tarifId->getId(),
                'idEntreprise' => $idEntreprise,
                'idClient' => $idClient,
            ]);
        }

        //$form = $this->createForm(EvenementsType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if ($request->get('type') == true)
            {
                $fkTarif = $evenement->getfkTarif();
                $valeur = $fkTarif->getValeur();
                $quantite = $evenement->getQuantite();
                $total = $valeur * $quantite;
                $evenement->setTotal($total);
                $em = $this->getDoctrine()->getManager();
                $em->persist($evenement);
                $em->flush();

                return $this->redirectToRoute('index');
            }
            else
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($evenement);
                $em->flush();

                return $this->redirectToRoute('index');
            }
        }

        return $this->render('evenements/new.html.twig', [
                    'evenement' => $evenement,
                    'entreprises' => $entreprise->findBy(['id' => $idEntreprise]),
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/mentionLegales", name="mention_legales")
     */
    public function mentionLegale()
            {
                 return $this->render('mentionsLegales.html.twig');
            }
    
    /**
     * @Route("/finance/{id}", name="evenements_finance")
     */
    public function finance(Request $request, EntrepriseRepository $entrepriseRepository, EvenementsRepository $evenementRepository, ClientsRepository $clientRepository )
    {
        
        $idEntreprise = $request->get('id');
        $idClient = $clientRepository;

        return $this->render('evenements/finance.html.twig', [
                    'evenements' => $evenementRepository->findByMonth($idEntreprise),
                    'entreprises' => $entrepriseRepository->findBy(['id' => $idEntreprise]),
                    'tarif' => $evenementRepository->findTotalByMonth($idEntreprise),
                    'idEntreprise'=> $idEntreprise,
                    'idClient' => $idClient,
        ]);
    }

    /**
     * @Route("/pdf/{id}", name ="pdf_generator")
     */
    public function pdf(Request $request, EntrepriseRepository $entrepriseRepository, EvenementsRepository $evenementRepository,
            ClientsRepository $clientRepository, TvaRepository $tvaRepository, TarifRepository $tarifRepository)
    {
        
        $idEntreprise = $request->get('id');
        $idClient = $request->get('idClient');
        $idEvenement = $request->get('idEvenement');
        $idTarif = $request->get('idTarif');
        $idTva = $request->get('idTva');
        
        $tarif = $tarifRepository->findOneBy(['id' => $idTarif]);
        $tva = $tvaRepository->findOneBy(['id' => $idTva]);
        $entreprise = $entrepriseRepository->findOneBy(['id' => $idEntreprise]);
        $client = $clientRepository->findOneBy(['id' => $idClient]);
        $evenement = $evenementRepository->findOneBy(['id' => $idEvenement]);
       
        $evenementTotal = $evenement->getTotal();
        $evenementTva = $tva->getTaux();
        $total = $evenementTotal / $evenementTva ;
        $newTotal = $evenementTotal + $total;
        
        $snappy = $this->get("knp_snappy.pdf");

        $html = $this->renderView("fichierPdf/pdf.html.twig", array(
            "title" => "Awesome PDF Title",
            "entreprise" => $entreprise,
            "client" => $client,
            "evenement" => $evenement,
            "tva" => $tva,
            "tarif" => $tarif,
            "newtotal" => $newTotal,
            
        ));

        $filename = "Facture_pdf";

        return new Response(
                $snappy->getOutputFromHtml($html),
                // ok status code
                200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;filename="' . $filename . '.pdf'
                )
        );
    }

    /**
     * @Route("/{id}", name="evenements_index", methods="GET")
     */
    public function index(EvenementsRepository $evenementsRepository, Request $request, EntrepriseRepository $entreprise, ClientsRepository $clientRepository): Response
    {

        $idEntreprise = $request->get('id');


        return $this->render('evenements/liste_client.html.twig', ['evenements' => $evenementsRepository->findBy(
                            array('fkEntreprise' => $idEntreprise)),
                    'entreprises' => $entreprise->findBy(['id' => $idEntreprise]),
                    'clients' => $clientRepository->findByEntreprise($idEntreprise)]);
    }

    /**
     * @Route("/planning/{id}", name="evenements_planning")
     */
    public function planning(EvenementsRepository $evenementsRepository, Request $request, EntrepriseRepository $entreprise): Response
    {
        $idEntreprise = $entreprise->find($request->get('id'));
        return $this->render('evenements/calendar.html.twig', ['evenements' => $evenementsRepository->findBy(
                            array('fkEntreprise' => $idEntreprise))]);
    }

    /**
     * @Route("/flow/event/{id}", name="evenements_flow", methods="GET")
     */
    public function choixTarif(TarifRepository $tarifRepository, EntrepriseRepository $entreprise, Request $request): Response
    {

        $idEntreprise = $request->get('id');
        //$entrepriseId = $tarifRepository->findByEntreprise($idEntreprise);

        $idClient = $request->get('idClient');
        return $this->render('tarif/choix_tarif.html.twig', [
                    'tarifs' => $tarifRepository->findAll(),
                    'idClient' => $idClient,
                    'idEntreprise' => $idEntreprise,
                    'entreprises' => $entreprise->findBy(['id' => $idEntreprise])
        ]);
    }

    /**
     * @Route("/{id}", name="evenements_show", methods="GET")
     */
    public function show(EvenementsRepository $evenementsRepository, EntrepriseRepository $entreprise): Response
    {
        $idEntreprise = $entreprise->find($request->get('id'));
        return $this->render('evenements/show.html.twig', ['evenement' => $evenementsRepository->findBy(
                            array('fkEntreprise' => $idEntreprise))]);
    }

    /**
     * @Route("/{id}/edit", name="evenements_edit", methods="GET|POST")
     */
    public function edit(Request $request, Evenements $evenement): Response
    {
        $form = $this->createForm(EvenementsType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenements_edit', ['id' => $evenement->getId()]);
        }

        return $this->render('evenements/edit.html.twig', [
                    'evenement' => $evenement,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenements_delete", methods="DELETE")
     */
    public function delete(Request $request, Evenements $evenement): Response
    {
        if ($this->isCsrfTokenValid('delete' . $evenement->getId(), $request->request->get('_token')))
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evenement);
            $em->flush();
        }

        return $this->redirectToRoute('evenements_index');
    }

}
