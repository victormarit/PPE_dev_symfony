<?php 
namespace App\Controller;

use App\Entity\Bed;
use App\Entity\HospitalRoom;
use App\Entity\Service;
use App\Form\HospitalRoomType;
use App\Form\ServiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
        if(isset($_GET['service'])){
            $data = $this->getDoctrine()->getRepository(Service::class)->FindServicesQuery($_GET['service']);
        }
        else {
            $data = $this->getDoctrine()->getRepository(Service::class)->FindServices();
        }
        
        $services = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), //récupère le numéro de la page en cours et si on en a pas on récupère 1
            10//nombre d'élements par page 
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
        
        return $this->render('admin/hospital/service/addService.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/modifierServiceHotpial/{id}", name="updateService")
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
        
        return $this->render('admin/hospital/service/addService.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/supprimerService/{id}", name="delService")
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
     * @Route("/admin/gestionService/{id}/{name}", name="manageService")
     * @param Request $request
     * @return Response
     */
    public function manageService($id, $name,  Request $request, PaginatorInterface $paginator):Response 
    {
        $data = $this->getDoctrine()->getRepository(HospitalRoom::class)->FindRooms($id);
        $rooms = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), //récupère le numéro de la page en cours et si on en a pas on récupère 1
            10//nombre d'élements par page 
        );
        return $this->render('admin/hospital/service/showService.html.twig', [
            'rooms' => $rooms,
            'service' => $name,
            'id' => $id
        ]);
    }

    /**
     * @Route("/admin/ajouterLit/{id}/{name}/{room}", name="addBed")
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
    
    /**
     * @Route("/admin/retirerLit/{id}/{name}/{room}", name="removeBed")
     * @param Request $request
     * @return Response
     */
    public function removeBed($id, $name, $room):Response 
    {
        $hospitalRoom = $this->getDoctrine()->getRepository(HospitalRoom::class)->findOneBy(['id' => $room]);
        $beds = $this->getDoctrine()->getRepository(Bed::class)->findBy(['idHospitalRoom' => $hospitalRoom]);
        $nb = count($beds);
        if ($nb > 1){
            $bed = $this->getDoctrine()->getRepository(Bed::class)->findOneBy(['number' => $nb]);
            $em = $this->getDoctrine()->getManager();
            $em->remove($bed);
            $em->flush();            
        }
        elseif($nb==1){
            return $this->redirectToRoute('delRoom', ["id" => $id, "name" => $name, "room" => $room]);
        }       
        return $this->redirectToRoute('manageService', ["id" => $id, "name" => $name]); 
    }

    /**
     * @Route("/admin/ajouterChambre/{id}/{name}", name="addRoom")
     * @param Request $request
     * @return Response
     */
    public function addRoom(Request $request,$id, $name):Response 
    {
        $service = $this->getDoctrine()->getRepository(Service::class)->findOneBy(['id' => $id]);
        $room = new HospitalRoom;
        $room->setIdService($service);
        $form =  $this->createForm(HospitalRoomType::class, $room);
        $form->handleRequest($request);
        
        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($room);
            $em->flush();

            $bed = new Bed;
            $bed->setIdHospitalRoom($room);
            $bed->setNumber(1);
            
            $em->persist($bed);
            $em->flush();

            return $this->redirectToRoute('manageService', ["id" => $id, "name" => $name]); 
        }
        
        return $this->render('admin/hospital/room/addRoom.html.twig', [
            "form" => $form->createView(),
        ]); 
    }

    /**
     * @Route("/admin/supprimerChambre/{id}/{name}/{room}", name="delRoom")
     * @return Response
     */
    public function delRoom($id, $name, $room): Response 
    {
        $hospitalRoom = $this->getDoctrine()->getRepository(HospitalRoom::class)->findOneBy(['id' => $room]);
        $beds = $this->getDoctrine()->getRepository(Bed::class)->findBy(['idHospitalRoom' => $hospitalRoom]);
        
        for($i =0 ; $i < count($beds) ; $i++){
            $em = $this->getDoctrine()->getManager();
            $em->remove($beds[$i]);
            $em->flush();
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($hospitalRoom);
        $em->flush();
        
        return $this->redirectToRoute('manageService', ["id" => $id, "name" => $name]); 
    }

    /**
     * @Route("/admin/modifierChambre/{id}/{name}/{room}", name="updateRoom")
     * @param Request $request
     * @return Response
     */
    public function updateRoom(Request $request,$id, $name, $room):Response 
    {
        $room = $this->getDoctrine()->getRepository(HospitalRoom::class)->findOneBy(['id' => $room]);
        $form =  $this->createForm(HospitalRoomType::class, $room);
        $form->handleRequest($request);
        
        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($room);
            $em->flush();

            return $this->redirectToRoute('manageService', ["id" => $id, "name" => $name]); 
        }
        
        return $this->render('admin/hospital/room/addRoom.html.twig', [
            "form" => $form->createView(),
        ]); 
    }


}