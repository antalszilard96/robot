<?php

namespace App\Controller;

use App\Entity\Robot;
use App\Form\RobotType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RobotRepository;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        $data = $this->getDoctrine()->getRepository(Robot::class)->findAll();

        return $this->render('main/index.html.twig', [
            'robotList' => $data
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show($id){
        $robot = $this->getDoctrine()->getRepository(Robot::class)->find($id);

        return $this->render('main/show.html.twig', array('robot' => $robot));
    }

    /**
     * @Route("/create", name="create")
     */

    public function create(Request $request){
        $robot = new Robot();
        $form = $this->createForm(RobotType::class, $robot);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $robot->setcreated_at(new \DateTime());
            $em->persist($robot);
            $em->flush();

            $this->addFlash('notice','Created Succesfully!');

            return $this->redirectToRoute('main');
        }

        return $this->render('main/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $request, $id){
        $robot = $this->getDoctrine()->getRepository(Robot::class)->find($id);
        $form = $this->createForm(RobotType::class, $robot);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($robot);
            $em->flush();

            $this->addFlash('notice','Update Succesfully!');

            return $this->redirectToRoute('main');
        }

        return $this->render('main/update.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id){
        $robot = $this->getDoctrine()->getRepository(Robot::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($robot);
        $em->flush();

        $this->addFlash('notice','Delete Succesfully!');

        return $this->redirectToRoute('main');
        
    }
    /**
     * @Route("/compare-rows", name="compare_rows")
     */
    public function compareRows(RobotRepository $repository): Response
    {
        $row1 = $repository->find(1);
        $row2 = $repository->find(2);

        if (!$row1 || !$row2) {
            throw $this->createNotFoundException('Rows not found');
        }

        if ($row1->getStrenght() === $row2->getStrenght()) {
            $message = 'The two rows have the same property';
        } else {
            $message = 'The two rows have different properties';
        }

        return new Response($message);
    }

   
    
}
