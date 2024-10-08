<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditorialFormType;
use App\Form\LibroFormType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Libro;
use App\Entity\Editorial;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class PageController extends AbstractController
{

/*    #[Route('/addForm/',name:'addForm')]
    public function addForm(ManagerRegistry $doctrine){
        return $this->render('insertar/insertar.html.twig', []);
    }*/

    #[Route('/insertarEditorial/',name:'insertarEditorial')]
    public function insertarEditorial(ManagerRegistry $doctrine,Request $request){
        $editorial = new Editorial();
        $form = $this->createForm(EditorialFormType::class, $editorial);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $libro = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($editorial);
            $entityManager->flush();
            return $this->redirectToRoute('mostrarTodos', []);
        }
        return $this->render('insertar/insertarEditorial.html.twig', array(
            'form' => $form->createView()
        ));
    }

    #[Route('/panelUsuarios/{id}',name:'panelUsuarios')]
    public function panelUsers(ManagerRegistry $doctrine,Request $request,int $id){
        $repositorio = $doctrine->getRepository(User::class);

        $usuario = $repositorio->find($id);

        return $this->render('mostrar/panelUsuarios.html.twig', [
            'usuario' => $usuario
        ]);
    }

    #[Route('/darPermisos/{id}',name:'darPermisos')]
    public function darPermisos(int $id,ManagerRegistry $doctrine,Request $request){
        $repositorio = $doctrine->getRepository(User::class);

        $usuario = $repositorio->find($id);

        $usuario.setRoles("ROLE_ADMIN");
        $entityManager = $doctrine->getManager();
        $entityManager->persist($usuario);
        $entityManager->flush();
    }

    /*public function insertarEditorial(string $name,ManagerRegistry $doctrine){
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
    }*/

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
    #[Route('/insertar',name: 'insertar')]
    public function insertar(ManagerRegistry $doctrine,Request $request):Response
    {
        $libro = new Libro();
        $form = $this->createForm(LibroFormType::class, $libro);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $libro = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($libro);
            $entityManager->flush();
            return $this->redirectToRoute('mostrarTodos', []);
        }
        return $this->render('insertar/insertar.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /*#[Route('/insertar/{titulo}/{autor}/{precio}',name: 'insertar')]
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
    }*/

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

    #[Route('/mostrarLibros/',name: 'mostrarLibros')]
    public function mostrarLibros(ManagerRegistry $doctrine){
        $repositorio = $doctrine->getRepository(Libro::class);
        $libros = $repositorio->findAll();
        $repositorio = $doctrine->getRepository(User::class);
        $users = $repositorio->findAll();

        return $this->render('login/mostrarLibros.html.twig', [
            'libros' => $libros,
            'users' => $users
        ]);
    }

    #[Route('/allUsers',name: 'allUsers')]
    public function allUsers(ManagerRegistry $doctrine){
        $repositorio = $doctrine->getRepository(User::class);
        $users = $repositorio->findAll();

        return $this->render('login/mostrarUsuarios.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/actualizar/{id}',name: 'actualizar')]
    public function actualizar(int $id,ManagerRegistry $doctrine,Request $request) :Response{
        $entityManager = $doctrine->getManager();
        $libro = $entityManager->getRepository(Libro::class)->find($id);
        $form = $this->createForm(LibroFormType::class, $libro);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $libro = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($libro);
            $entityManager->flush();
            return $this->redirectToRoute('mostrarTodos', []);
        }
        return $this->render('insertar/insertar.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /*#[Route('/actualizar/{id}/{titulo}/{autor}',name: 'actualizar')]
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
    }*/

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
