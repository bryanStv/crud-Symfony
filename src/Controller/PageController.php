<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Libro;
use App\Entity\Editorial;
use Doctrine\Persistence\ManagerRegistry;

class PageController extends AbstractController
{

/*    #[Route('/addForm/',name:'addForm')]
    public function addForm(ManagerRegistry $doctrine){
        return $this->render('insertar/insertar.html.twig', []);
    }*/

    #[Route('/insertarEditorial/{name}',name:'insertarEditorial')]
    public function insertarEditorial(string $name,ManagerRegistry $doctrine){
        $entityManager = $doctrine->getManager();
        try{
            $editorial = new Editorial();
            $editorial->setName($name);
            $entityManager->persist($editorial);
            $entityManager->flush();
            return new Response("Editorial insertada");
        }catch (\Exception $e){
            return new Response("Error al insertar");
        }
    }

    #[Route('/editorialLibro/{idEdit}/{idLibro}',name:'editorialLibro')]
    public function editorialLibro(string $idEdit,string $idLibro,ManagerRegistry $doctrine){
        $entityManager = $doctrine->getManager();
        try{
            $libro = $entityManager->getRepository(Libro::class)->find($idLibro);
            $editorial = $entityManager->getRepository(Editorial::class)->find($idEdit);
            $libro->setEditorial($editorial);
            $editorial -> addNombre($libro);
            $entityManager->persist($editorial);
            $entityManager->flush();
            return new Response("Editorial añadida a libro");
        }catch (\Exception $e){
            return new Response("Error al insertar");
        }
    }

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
            return new Response("Libro insertado");
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
        //$editorial = $repositorio->findAll();
        return $this->render('mostrar/mostrarTodos.html.twig', [
            'libros' => $libros
        ]);
    }

    #[Route('/actualizar/{id}/{titulo}/{autor}',name: 'actualizar')]
    public function actualizar(int $id,string $titulo,string $autor,Libro $libro,ManagerRegistry $doctrine){
        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Libro::class);
        $libro = $repositorio->find($id);

        if($libro){
            $libro->setTitulo($titulo);
            $libro->setAutor($autor);
            try{
                $entityManager->flush();
                return $this->render('mostrar/mostrar.html.twig', [
                    'libro' => $libro
                ]);

            }catch (\Exception $e){
                return new Response("Libro no actualizado de forma correcta");
            }
        }else{
            return new Response("Libro no encontrado");
        }
    }

    #[Route('/borrar/{id}',name: 'borrar')]
    public function borrar(int $id,ManagerRegistry $doctrine){
        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Libro::class);
        $libro = $repositorio->find($id);
        if($libro){
            try{
                $entityManager->remove($libro);
                $entityManager->flush();
                return new Response("Libro borrado");
            }catch (\Exception $e){
                return new Response("Libro no eliminado de forma correcta");
            }
        }else{
            return new Response("Libro no encontrado");
        }
    }

    #[Route('/page', name: 'app_page')]
    public function index(): Response
    {
        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
}
