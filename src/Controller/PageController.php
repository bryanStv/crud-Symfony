<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Libro;
use Doctrine\Persistence\ManagerRegistry;

class PageController extends AbstractController
{

    #[Route('/insertar/{titulo}/{autor}/{precio}',name: 'insertar')]
    public function insertar(string $titulo,string $autor,int $precio,ManagerRegistry $doctrine){
        $entityManager = $doctrine->getManager();
        $libro = new Libro();
        $libro->setTitulo($titulo);
        $libro->setAutor($autor);
        $libro->setPrecio($precio);
        $entityManager->persist($libro);
        try{
            $entityManager->flush();
            return new Response("Contacto insertado");
        }catch (\Exception $e){
            return new Response("Error al insertar");
        }
    }

    #[Route('/mostrar/{id}',name: 'mostrar')]
    public function mostrar(int $id,ManagerRegistry $doctrine){
        $repositorio = $doctrine->getRepository(Libro::class);

        $libro = $repositorio->find($id);

        return $this->render('mostrar/mostrar.html.twig', [
            'libro' => $libro
        ]);
    }

    #[Route('/mostrarTodos/',name: 'mostrarTodos')]
    public function mostrarTodos(ManagerRegistry $doctrine){
        $repositorio = $doctrine->getRepository(Libro::class);
        $libros = $repositorio->findAll();
        return $this->render('mostrar/mostrarTodos.html.twig', [
            'libros' => $libros
        ]);
    }

    #[Route('/actualizar/{id}/{titulo}/',name: 'actualizar')]
    public function actualizar(int $id,string $titulo,Libro $libro,ManagerRegistry $doctrine){
        $entityManager = $doctrine->getManager();
        $libro->setTitulo($titulo);
    }

    #[Route('/page', name: 'app_page')]
    public function index(): Response
    {
        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
}
