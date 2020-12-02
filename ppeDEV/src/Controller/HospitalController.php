<?php 
namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HospitalController extends AbstractController
{
    /**
     * @Route("/admin/GestionHopital", name="homepageHospital")
     */
    public function homepageHospital()
    {
        $services  = $this->getDoctrine()->getRepository(Service::class)->findBy([], ['id'=>'desc']);
        return $this->render('admin/hospital/homepageHospital.html.twig', [
            'services' => $services
        ]);
    }

    /**
     * @Route("/admin/creerServiceHotpial", name="addService")
     * @param Request $request
     * @return Response
     */
    public function addService(Request $request):Response 
    {
        $service = new Service;
        $form =  $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        
        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();
            return $this->redirectToRoute('homepageHospital'); 
        }
        
        return $this->render('admin/hospital/addService.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/modifierServiceHotpial?id={id}", name="updateService")
     * @param Request $request
     * @return Response
     */
    public function updateService(Request $request, $id):Response 
    {
        $service = $this->getDoctrine()->getRepository(Service::class)->findOneBy(['id' => $id]);;
        $form =  $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        
        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();
            return $this->redirectToRoute('homepageHospital'); 
        }
        
        return $this->render('admin/hospital/addService.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/user/supprimerService?id={id}", name="delService")
     * @param Request $request
     * @return Response
     */
    public function delService($id):Response 
    {
        $service = $this->getDoctrine()->getRepository(Service::class)->findOneBy(['id' => $id]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($service);
        $em->flush();
           
        return $this->redirectToRoute('homepageHospital'); 
    }


}