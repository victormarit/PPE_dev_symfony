<?php 
namespace App\Controller;

use App\Entity\Bed;
use App\Entity\HospitalRoom;
use App\Entity\Service;
use App\Form\ServiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class HospitalController extends AbstractController
{
    /**
     * @Route("/admin/GestionHopital", name="homepageHospital")
     */
    public function homepageHospital(Request $request, PaginatorInterface $paginator)
    {
        $data = $this->getDoctrine()->getRepository(Service::class)->FindServices();
        $services = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), //récupère le numéro de la page en cours et si on en a pas on récupère 1
            20//nombre d'élements par page 
        );
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

    /**
     * @Route("/user/gestionService?id={id}&name={name}", name="manageService")
     * @param Request $request
     * @return Response
     */
    public function manageService($id, $name,  Request $request, PaginatorInterface $paginator):Response 
    {
        $data = $this->getDoctrine()->getRepository(HospitalRoom::class)->FindRooms($id);
        $rooms = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), //récupère le numéro de la page en cours et si on en a pas on récupère 1
            20//nombre d'élements par page 
        );
        return $this->render('admin/hospital/service.html.twig', [
            'rooms' => $rooms,
            'service' => $name,
            'id' => $id
        ]);
    }

    /**
     * @Route("/user/ajouterLit?id={id}&name={name}&room={room}", name="addBed")
     * @param Request $request
     * @return Response
     */
    public function addBed($id, $name, $room):Response 
    {
        $hospitalRoom = $this->getDoctrine()->getRepository(HospitalRoom::class)->findOneBy(['id' => $room]);
        $beds = $this->getDoctrine()->getRepository(Bed::class)->findBy(['idHospitalRoom' => $room]);
        $nb = count($beds)+1;
        
        
        
        $bed = new Bed();
        $bed->setNumber($nb);
        $bed->setIdHospitalRoom($hospitalRoom);
        
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($bed);
        $em->flush();
        
        return $this->redirectToRoute('manageService', ["id" => $id, "name" => $name]); 
    }

}