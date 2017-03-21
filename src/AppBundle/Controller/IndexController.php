<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Entity\Proyecto;
use AppBundle\Form\ImageType;
use AppBundle\Form\ProyectoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
    /**
     * @Route("/", name="app_index_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repo=$m->getRepository('AppBundle:Proyecto');
        $proyectos = $repo->findAll();

        return $this->render(':index:index.html.twig',
            [
                'proyectos'=> $proyectos,
            ]
        );
    }

    /**
     * @Route("/upload", name="app_index_upload")
     */
    public function uploadAction(Request $request)
    {
        $p = new Image();
        $form = $this->createForm(ImageType::class, $p);

        if ($request->getMethod() == Request::METHOD_POST) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $m = $this->getDoctrine()->getManager();
                $m->persist($p);
                $m->flush();

                return $this->redirectToRoute('app_index_index');
            }
        }

        return $this->render(':index:upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nuevoProyecto", name="app_index_nuevoProyecto")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function nuevoProyectoAction()
    {
        $p= new Proyecto();
        $form = $this->createForm(ProyectoType::class, $p);

        return $this->render(':index:form.html.twig',
            [
                'form' =>   $form->createView(),
                'action'=>  $this->generateUrl('app_index_donuevoProyecto')
            ]
        );
    }

    /**
     * @Route("/donuevoProyecto", name="app_index_donuevoProyecto")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function donuevoProyectoAction(Request $request)
    {
        $p=new Proyecto();
        //add creator

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        // set creator in our object
        //is granted
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $p->setCreador($user);

        //create Form
        $form=$this->createForm(ProyectoType::class,$p);
        $form->handleRequest($request);
        if($form->isValid()) {
            $m = $this->getDoctrine()->getManager();
            $m->persist($p);
            $m->flush();

            $this->addFlash('messages', 'Proyect added');
            return $this->redirectToRoute('app_index_index');
        }
        $this->addFlash('messages','Review your form data');

        return $this->render(':index:form.html.twig',
            [
                'form'  =>  $form->createView(),
                'action'=>  $this->generateUrl('app_index_donuevoProyecto')
            ]
        );
    }
    /**
     * @Route("/remove/{id}", name="app_index_remove")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeAction($id)
    {
        $m= $this->getDoctrine()->getManager();
        $repo= $m->getRepository('AppBundle:Proyecto');
        $proyecto = $repo->find($id);
        $m->remove($proyecto);
        $m->flush();

        return $this->redirectToRoute('app_index_index');
    }

    /**
     * @Route("/update/{id}", name="app_index_update")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction($id)
    {
        $m=$this->getDoctrine()->getManager();
        $repo=$m->getRepository('AppBundle:Proyecto');
        $proyecto=$repo->find($id);
        $form=$this->createForm(ProyectoType::class,$proyecto);
        return $this->render(':index:form.html.twig',
            [
                'form'=>$form->createView(),
                'action'=>$this->generateUrl('app_index_doUpdate',['id'=>$id])
            ]
        );
    }

    /**
     * @Route("/doUpdate/{id}", name="app_index_doUpdate")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function doUpdateAction($id,Request $request)
    {
        $m= $this->getDoctrine()->getManager();
        $repo= $m->getRepository('AppBundle:Proyecto');
        $p1= $repo->find($id);
        $form=$this->createForm(ProyectoType::class,$p1);

        //El producto es actualizado con los estos datos
        $form->handleRequest($request);
        $p1->setUpdatedAt();

        if($form->isValid()){
            $m->flush();
            $this->addFlash('messages','Proyecto Updated');

            return $this->redirectToRoute('app_index_index');
        }

        $this->addFlash('message' , 'Review your form');
        return $this->render(':index:form.html.twig',
            [
                'form'=> $form->createView(),
                'action'=> $this->generateUrl('app_index_doUpdate',['id'=>$id]),
            ]

        );

    }

    /**
     * @Route("/{slug}.html", name="app_index_show")
     */
    public function showAction($slug)
    {
        $m = $this->getDoctrine()->getManager();
        $repository= $m->getRepository('AppBundle:Proyecto');
        $proyecto=$repository->find($slug);
        return $this->render(':proyecto:proyecto.html.twig', [
            'proyecto'   => $proyecto,
        ]);
    }

    /**
     * @Route("/usuario/{slug}.html", name="app_usuario_show")
     *
     */
    public function showUserAction($slug)
    {
        $m = $this ->getDoctrine()->getManager();
        $repository= $m->getRepository('UserBundle:User');
        $usuario=$repository->find($slug);
        return $this->render('usuario/usuario.html.twig',[
            'usuario' => $usuario,
        ]);
    }


}
