<?php 

namespace App\Controller;

use App\Entity\Bed;
use App\Entity\Patient;
use App\Entity\Service;
use App\Entity\Staff;
use App\Entity\Stay;
use App\Form\StayType;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StayController extends AbstractController
{
    /**
     * @Route("/user/séjour", name="homepageStay")
     * @param Request $request
     * @return Response
     */
    public function homepageStay(Request $request, PaginatorInterface $paginator)
    {
        if(isset($_GET['search'])){
            $donnees  = $this->getDoctrine()->getRepository(Stay::class)->findStays($_GET['search']);
        }
        else {
            $donnees  = $this->getDoctrine()->getRepository(Stay::class)->findAllStays();
        }
        $stays = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1), //récupère le numéro de la page en cours et si on en a pas on récupère 1
            10//nombre d'élements par page
        );
        return $this->render('pages/homepageStay.html.twig', [
            'stays' => $stays
        ]);
    }

    /**
     * @Route("/user/creationSejour", name="addStay")
     * @param Request $request
     * @return Response
     */
    public function addStay(Request $request):Response
    {
        $stay = new Stay;
        $form =  $this->createForm(StayType::class, $stay);
        $form->handleRequest($request);
        
        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($stay);
            $em->flush();
            return $this->redirectToRoute('homepageStay'); 
        }
        
        return $this->render('pages/addStay.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/user/supprimerSéjour/{id}", name="delStay")
     */
    public function delStay($id):Response 
    {
        $stay = $this->getDoctrine()->getRepository(Stay::class)->findOneBy(['id' => $id]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($stay);
        $em->flush();
           
        return $this->redirectToRoute('homepageStay'); 
    }

    /**
     * @Route("/user/modifierSéjour/{id}/{serviceId}", name="updateStay")
     */
    public function updateStay($id, $serviceId):Response 
    {
        $stay = $this->getDoctrine()->getRepository(Stay::class)->findOneBy(['id' => $id]);
        $patientId = $stay->getIdPatient(); 
        $patient = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(['id' => $patientId->getId()]);;
        $data = $this->getDoctrine()->getRepository(Service::class)->findAll();
        return $this->render('pages/stay/updateStay.html.twig', [
            'services' => $data,
            'idPatient' => $patient->getId(),
            "firstname" => $patient->getFirstName(), 
            "lastname" => $patient->getLastName(),
            "entryDate" => $stay->getEntryDate(),
            "leaveDate" => $stay->getLeaveDate(),
            "idStay" => $stay->getId(),
            'serviceId' => $serviceId
        ]); 
    }

    /**
     * @Route("/user/erreurModifierSéjour/{id}/{serviceId}/{erreur}", name="failUpdateStay")
     */
    public function failUpdateStay($id, $serviceId, $erreur):Response 
    {
        $stay = $this->getDoctrine()->getRepository(Stay::class)->findOneBy(['id' => $id]);
        $patientId = $stay->getIdPatient(); 
        $patient = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(['id' => $patientId->getId()]);;
        $data = $this->getDoctrine()->getRepository(Service::class)->findAll();
        if($erreur==1){
            return $this->render('pages/stay/updateStay.html.twig', [
                'services' => $data,
                'idPatient' => $patient->getId(),
                "firstname" => $patient->getFirstName(), 
                "lastname" => $patient->getLastName(),
                "entryDate" => $stay->getEntryDate(),
                "leaveDate" => $stay->getLeaveDate(),
                'serviceId' => $serviceId,
                "idStay" => $stay->getId(),
                "fail" => true
            ]); 
        }
        else{
            return $this->render('pages/stay/updateStay.html.twig', [
                'services' => $data,
                'idPatient' => $patient->getId(),
                "firstname" => $patient->getFirstName(), 
                "lastname" => $patient->getLastName(),
                "entryDate" => $stay->getEntryDate(),
                "leaveDate" => $stay->getLeaveDate(),
                'serviceId' => $serviceId,
                "idStay" => $stay->getId(),
                "pb" => true
            ]);
        }
        
    }

    /**
     * @Route("/user/applicationModifierSéjour/{id}/{lastname}/{firstname}}/{serviceId}/{idStay}", name="applyUpdateStay")
     */
    public function applyUpdateStay( $id, $firstname, $lastname, $serviceId, $idStay) 
    {
        if(isset($_POST['date1']) && isset($_POST['date2']) && isset($_POST['service'])){
            if($_POST['date1']<$_POST['date2']){
                date_default_timezone_set('Europe/Paris');
                $beds = $this->getDoctrine()->getRepository(Bed::class)->findBedsAndRooms($_POST['service'], $_POST['date1'], $_POST['date2']);
                if(count($beds)>0){
                    $this->getDoctrine()->getRepository(Stay::class)->updateStayPatient($idStay, $_POST['date1'], $_POST['date2'],$beds[0]['bed']);
                
                    return $this->redirectToRoute('staysPatient', ["id" => $id, "firstname" => $firstname,"lastname" => $lastname ]);
                }
                else{ 
                    $date = $this->getDoctrine()->getRepository(Stay::class)->nextAvailability($_POST['service']);                    
                    $stay = $this->getDoctrine()->getRepository(Stay::class)->findOneBy(['id' => $idStay]);
                    $patientId = $stay->getIdPatient(); 
                    $patient = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(['id' => $patientId->getId()]);;
                    $data = $this->getDoctrine()->getRepository(Service::class)->findAll();
                    return $this->render('pages/stay/updateStay.html.twig', [
                        'services' => $data,
                        'idPatient' => $patient->getId(),
                        "firstname" => $patient->getFirstName(), 
                        "lastname" => $patient->getLastName(),
                        "entryDate" => $stay->getEntryDate(),
                        "leaveDate" => $stay->getLeaveDate(),
                        'serviceId' => $serviceId,
                        "idStay" => $stay->getId(),
                        "pb2" => $date[0]["leave"]
                    ]); 
                }
            }
            else{
                return $this->redirectToRoute("failUpdateStay", ["id" => $idStay, "serviceId" => $serviceId, "erreur" => 2 ]);  
            }            
        }
        return $this->redirectToRoute("failUpdateStay", ["id" => $idStay, "serviceId" => $serviceId, "erreur" => 1 ]);
    }

}