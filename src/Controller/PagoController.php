<?php

namespace App\Controller;

use App\Entity\Pago;
use App\Form\PagoType;
use App\Repository\PagoRepository;
use App\Service\DeudaService;
use App\Repository\UserRepository;
use App\Repository\CompraRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pago')]
class PagoController extends AbstractController
{
    #[Route('/', name: 'app_pago_index', methods: ['GET'])]
    public function index(PagoRepository $pagoRepository): Response
    {
        return $this->render('pago/index.html.twig', [
            'pagos' => $pagoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pago_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        DeudaService $deudaService,
        UserRepository $userRepository,
        CompraRepository $compraRepository
    ): Response {
        $pago = new Pago();

        $form = $this->createForm(PagoType::class, $pago, [
            'usuarioActual' => $this->getUser(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pago->setPagador($this->getUser());

            $em->persist($pago);
            $em->flush();

            $usuarios = $userRepository->findAll();
            $compras = $compraRepository->findAll();

            $deudas = $deudaService->calcularDeudasEntreTodos($usuarios, $compras);

            $pagadorId = $pago->getPagador()->getId();
            $receptorId = $pago->getReceptor()->getId();
            $saldoRestante = $deudas[$pagadorId][$receptorId] ?? 0;

            return $this->render('pago/confirmacion.html.twig', [
                'pago' => $pago,
                'saldoRestante' => $saldoRestante,
            ]);
        }

        return $this->render('pago/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_pago_show', methods: ['GET'])]
    public function show(Pago $pago): Response
    {
        return $this->render('pago/show.html.twig', [
            'pago' => $pago,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pago_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pago $pago, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PagoType::class, $pago, [
            'usuarioActual' => $this->getUser(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // No reasignamos pagador en edición
            $em->flush();

            return $this->redirectToRoute('app_pago_index');
        }

        return $this->render('pago/edit.html.twig', [
            'form' => $form->createView(),
            'pago' => $pago,
        ]);
    }

    #[Route('/{id}', name: 'app_pago_delete', methods: ['POST'])]
    public function delete(Request $request, Pago $pago, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pago->getId(), $request->request->get('_token'))) {
            $em->remove($pago);
            $em->flush();
        }

        return $this->redirectToRoute('app_pago_index');
    }
}
