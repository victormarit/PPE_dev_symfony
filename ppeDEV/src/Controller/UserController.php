<?php 

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{


    /**
     * @Route("/user/homepage", name="homepage")
     */
    public function index()
    {
        return $this->render('pages/homepage.html.twig');
    }


    /**
     * @Route("/user/ajouterPatient", name="createPatient")
     * @param Request $request
     * @return Response
     */
    public function addPatient(Request $request):Response 
    {
        $user = new Patient;
        $form =  $this->createForm(PatientType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted()&& $form->isValid()){
            //Vérifier le numéro de sécu pour être sur qu'il est bien unique. 
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('homepage'); 
        }
        
        return $this->render('pages/addPatient.html.twig', [
            "form" => $form->createView()
        ]);
    }


    /**
     * @Route("/user/modifierPatient&?id={id}", name="updatePatient")
     * @param Request $request
     * @return Response
     */
    public function updatePatient(Request $request, $id):Response 
    {
        $user = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(['id' => $id]);
        $form =  $this->createForm(PatientType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('homepage'); 
        }
        
        return $this->render('pages/addPatient.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/user/supprimerPatient?id={id}", name="delPatient")
     * @param Request $request
     * @return Response
     */
    public function delPatient(Request $request, $id):Response 
    {
        $user = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(['id' => $id]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
           
        return $this->redirectToRoute('homepage'); 
    }
}