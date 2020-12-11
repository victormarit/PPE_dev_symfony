<?php 
namespace App\Controller;

use App\Entity\Staff;
use App\Form\StaffType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class StaffController extends AbstractController
{
    /**
     * @Route("/admin/GestionPersonnel", name="homepageStaff")
     * @param Request $request
     * @return Response
     */
    public function homepageStaff(Request $request, PaginatorInterface $paginator)
    {
        $donnees  = $this->getDoctrine()->getRepository(Staff::class)->findBy([], ['id'=>'desc']);
        $staff = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1), //récupère le numéro de la page en cours et si on en a pas on récupère 1
            9//nombre d'élements par page 
        );
        return $this->render('admin/homepageAdmin.html.twig', [
            'staffs' => $staff
        ]);
    }

    /**
     * @Route("/admin/createStaffMember", name="createNewStaffMember")
     * @param Request $request
     * @return Response
     */
    public function createNewStaffMember(Request $request, UserPasswordEncoderInterface $passwordEncoder):Response 
    {
        $staff = new Staff;
        $form =  $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);
        
        if($form->isSubmitted()&& $form->isValid()){
            $staff->setPassword(
                $passwordEncoder->encodePassword(
                    $staff,
                    $form->get('password')->getData()
                )
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($staff);
            $em->flush();
            return $this->redirectToRoute('homepagePatient'); 
        }
        
        return $this->render('admin/newStaffMember.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/user/supprimerStaffMember/{id}", name="delStaff")
     * @param Request $request
     * @return Response
     */
    public function delStaff($id):Response 
    {
        $staff = $this->getDoctrine()->getRepository(Staff::class)->findOneBy(['id' => $id]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($staff);
        $em->flush();
           
        return $this->redirectToRoute('homepagePatient'); 
    }

    /**
     * @Route("/admin/modifierStaffMember/{id}", name="updateStaff")
     * @param Request $request
     * @return Response
     */
    public function updateStaff(Request $request, $id):Response 
    {
        $staff = $this->getDoctrine()->getRepository(Staff::class)->findOneBy(['id' => $id]);
        $form =  $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);
        
        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($staff);
            $em->flush();
            return $this->redirectToRoute('homepagePatient'); 
        }
        
        return $this->render('admin/newStaffMember.html.twig', [
            "form" => $form->createView()
        ]);
    }
}