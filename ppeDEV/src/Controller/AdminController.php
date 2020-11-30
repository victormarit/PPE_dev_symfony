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
     * @Route("/admin/createStaffMember", name="createNewStaffMember")
     * @param Request $request
     * @return Response
     */
    public function createNewStaffMember(Request $request):Response 
    {
        $staff = new Staff;
        $form =  $this->createForm(StaffFromType::class, $staff);
        $form->handleRequest($request);
        
        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($staff);
            $em->flush();
            return $this->redirectToRoute('homepage'); 
        }
        
        return $this->render('admin/newStaffMember.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/modifierStaff&id={id}, name="updateStaff")
     * @param Request $request
     * @return Response
     */
    public function updateStaff (Request $request, $id):Response 
    {
        $staff = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(['id' => $id]);
        $form =  $this->createForm(StaffFromType::class, $staff);
        $form->handleRequest($request);
        
        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($staff);
            $em->flush();
            return $this->redirectToRoute('homepage'); 
        }
        
        return $this->render('admin/newStaffMember.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/user/supprimerStaffMember?id={id}", name="delStaff")
     * @param Request $request
     * @return Response
     */
    public function delStaff(Request $request, $id):Response 
    {
        $staff = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(['id' => $id]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($staff);
        $em->flush();
           
        return $this->redirectToRoute('homepage'); 
    }
}