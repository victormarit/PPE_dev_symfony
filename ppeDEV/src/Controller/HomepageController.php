<?php 

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
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
    public function createNewStaffMember(Request $request):Response 
    {
        $user = new Patient;
        dump('10');
        $form =  $this->createForm(PatientType::class, $user);
        dump('20');
        $form->handleRequest($request);
        
        //if($form->isSubmitted()&& $form->isValid()){
        //    $em = $this->getDoctrine()->getManager();
        //    $em->persist($user);
        //    $em->flush();
        //    return $this->redirectToRoute('homepage'); 
        //}
        
        
        return $this->render('pages/addPatient.html.twig', [
            "form" => $form->createView()
        ]);
    }
}