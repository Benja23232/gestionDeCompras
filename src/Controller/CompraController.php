<?php

namespace App\Controller;

use App\Entity\Compra;
use App\Form\CompraType;
use App\Repository\CompraRepository;
use App\Service\DeudaService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/compra')]
final class CompraController extends AbstractController
{
    public function __construct(private DeudaService $deudaService) {}

    #[Route(name: 'app_compra_index', methods: ['GET'])]
    public function index(CompraRepository $compraRepository): Response
    {
        return $this->render('compra/index.html.twig', [
            'compras' => $compraRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_compra_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $compra = new Compra();
        $form = $this->createForm(CompraType::class, $compra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $compra->setComprador($this->getUser());

            foreach ($compra->getProductos() as $producto) {
                $producto->setCompra($compra);
            }

            $entityManager->persist($compra);
            $entityManager->flush();

            // ✅ Procesar deudas y compensaciones automáticas
            # $this->deudaService->procesarCompra($compra);

            return $this->redirectToRoute('app_compra_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('compra/new.html.twig', [
            'compra' => $compra,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_compra_show', methods: ['GET'])]
    public function show(Compra $compra): Response
    {
        return $this->render('compra/show.html.twig', [
            'compra' => $compra,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_compra_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Compra $compra, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompraType::class, $compra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($compra->getProductos() as $producto) {
                $producto->setCompra($compra);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_compra_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('compra/edit.html.twig', [
            'compra' => $compra,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_compra_delete', methods: ['POST'])]
    public function delete(Request $request, Compra $compra, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $compra->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($compra);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_compra_index', [], Response::HTTP_SEE_OTHER);
    }
}
