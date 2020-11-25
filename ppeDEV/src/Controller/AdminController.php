<?php 

namespace App\Controller;

use App\Entity\Staff;
use App\Form\StaffFromType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{



    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('pages/homepage.html.twig');
    }


    /**
     * @Route("/admin/createStaffMember", name="admin")
     * @param Request $request
     * @return Response
     */
    public function createNewStaffMember(Request $request):Response 
    {
        $user = new Staff;
        $form =  $this->createForm(StaffFromType::class, $user);
        $form->handleRequest($request);
        
        //if($form->isSubmitted()&& $form->isValid()){
        //    $em = $this->getDoctrine()->getManager();
        //    $em->persist($user);
        //    $em->flush();
        //    return $this->redirectToRoute('homepage'); 
        //}
        
        
        return $this->render('admin/newStaffMember.html.twig', [
            "form" => $form->createView()
        ]);
    }
}