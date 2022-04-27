<?php

namespace App\Controller;

use App\Entity\Biblioteca;
use App\Form\BibliotecaType;
use App\Repository\BibliotecaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/biblioteca")
 */
class BibliotecaController extends AbstractController
{
    /**
     * @Route("/", name="app_biblioteca_index", methods={"GET"})
     */
    public function index(BibliotecaRepository $bibliotecaRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('biblioteca/index.html.twig', [
            'bibliotecas' => $bibliotecaRepository->findAll(),
        ]);

    }


    public function updateAction(Request $request)
    {

    }

    /**
     * @Route("/new", name="app_biblioteca_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BibliotecaRepository $bibliotecaRepository): Response
    {
        $biblioteca = new Biblioteca();
        $form = $this->createForm(BibliotecaType::class, $biblioteca);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bibliotecaRepository->add($biblioteca);
            return $this->redirectToRoute('app_biblioteca_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('biblioteca/new.html.twig', [
            'biblioteca' => $biblioteca,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_biblioteca_show", methods={"GET"})
     */
    public function show(Biblioteca $biblioteca): Response
    {
        return $this->render('biblioteca/show.html.twig', [
            'biblioteca' => $biblioteca,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_biblioteca_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Biblioteca $biblioteca, BibliotecaRepository $bibliotecaRepository): Response
    {
        $form = $this->createForm(BibliotecaType::class, $biblioteca);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bibliotecaRepository->add($biblioteca);
            return $this->redirectToRoute('app_biblioteca_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('biblioteca/edit.html.twig', [
            'biblioteca' => $biblioteca,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_biblioteca_delete", methods={"POST"})
     */
    public function delete(Request $request, Biblioteca $biblioteca, BibliotecaRepository $bibliotecaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $biblioteca->getId(), $request->request->get('_token'))) {
            $bibliotecaRepository->remove($biblioteca);
        }

        return $this->redirectToRoute('app_biblioteca_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/libros", methods={"GET"}, options={"expose"=true}, name="app_biblioteca_libros")
     */
    public function listalibros($id)
    {
        $em = $this->getDoctrine()->getManager();
        $biblioteca = $em->getRepository(Biblioteca::class)->find($id);
        return $this->render('biblioteca/libros.html.twig', ['biblioteca' => $biblioteca]);
    }

    /**
     * @Route("/biblioteca_index", methods={"GET"}, options={"expose"=true}, name="biblioteca_index")
     * @param Request $request
     */
    public function indexBiblioteca(Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $bibliotecas = $em->getRepository(Biblioteca::class)->findAll();

            $serializer = SerializerBuilder::create()->build();

            return Response::create($serializer->serialize($bibliotecas, 'json'));
        }

        return new Response();
    }

    /**
     * @Route("/libros_index", methods={"GET"}, options={"expose"=true}, name="libros_index")
     * @param Request $request
     */
    public function indexLibros(Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $libro = $em->getRepository(Libro::class)->findAll();

            $serializer = SerializerBuilder::create()->build();

            return Response::create($serializer->serialize($libro, 'json'));
        }

        return new Response();
    }
}