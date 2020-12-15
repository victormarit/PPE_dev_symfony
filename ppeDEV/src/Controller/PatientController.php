<?php 

namespace App\Controller;

use App\Entity\AddStay;
use App\Entity\Bed;
use App\Entity\Manage;
use App\Entity\Patient;
use App\Entity\Service;
use App\Entity\Staff;
use App\Entity\Stay;
use App\Form\PatientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use DateTime;

class PatientController extends AbstractController
{

    /**
     * @Route("/user/homepagePatient", name="homepagePatient")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        if(isset($_GET['search'])){
            $donnees  = $this->getDoctrine()->getRepository(Patient::class)->findPatients($_GET['search']);
        }
        else {
            $donnees  = $this->getDoctrine()->getRepository(Patient::class)->findBy([], ['id'=>'desc']);
        }

        $patients = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1), //récupère le numéro de la page en cours et si on en a pas on récupère 1
            6//nombre d'élements par page 
        );
        return $this->render('user/patient/homepage.html.twig', [
            'patients' => $patients
        ]);
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
            //Vérifie le numéro de sécu pour être sur qu'il est bien unique. 
            $test = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(['socialSecurityNumber' => $user->getSocialSecurityNumber()]);
            if($test === null)
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->loggerPatient($user, 'creation');
                return $this->redirectToRoute('homepagePatient'); 
            }
            else
            {
                return $this->render('user/patient/addPatient.html.twig', [
                    "form" => $form->createView(),
                    'error' => True
                ]);
            } 
        }
        return $this->render('user/patient/addPatient.html.twig', [
            "form" => $form->createView()
        ]);
    }

    private function loggerPatient($patient, $action)
    {
        $manage = new Manage();
        $manage->setIdPatient($patient);
        date_default_timezone_set('Europe/Paris');
        $currentDate =  DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
        $manage->setModification($currentDate);
        $manage->setIdStaff($this->getUser());
        $manage->setAction($action);
        $em = $this->getDoctrine()->getManager();
        $em->persist($manage);
        $em->flush();
    }

    /**
     * @Route("/user/modifierPatient/{id}", name="updatePatient")
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
            $this->loggerPatient($user, 'modification');
            return $this->redirectToRoute('homepagePatient'); 
        }
        
        return $this->render('user/patient/addPatient.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/user/supprimerPatient/{id}", name="delPatient")
     * @return Response
     * @param Request $request
     */
    public function delPatient($id, PaginatorInterface $paginator, Request $request):Response 
    {

        $user = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(['id' => $id]);
        $stays = $user->getStays();
        if(count($stays)==0){
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
               
            return $this->redirectToRoute('homepagePatient'); 
        }
        else{
            $donnees  = $this->getDoctrine()->getRepository(Patient::class)->findBy([], ['id'=>'desc']);
            $patients = $paginator->paginate(
                $donnees,
                $request->query->getInt('page', 1), //récupère le numéro de la page en cours et si on en a pas on récupère 1
                9//nombre d'élements par page 
            );
            return $this->render('user/patient/homepage.html.twig', [
                'patients' => $patients,
                'erreur' => true
            ]);
        }

    }

    /**
     * @Route("/user/séjoursPatient/{id}/{lastname}/{firstname}", name="staysPatient")
     * @param Request $request
     * @return Response
     */
    public function staysPatient(Request $request, $id, PaginatorInterface $paginator, $lastname, $firstname):Response 
    {
        $data = $this->getDoctrine()->getRepository(Stay::class)->FindPatientStays($id); //On peut passer par une requête SQL pour améliorer le système
        
        $stays = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), //récupère le numéro de la page en cours et si on en a pas on récupère 1
            10//nombre d'élements par page 
        );
        return $this->render('user/patient/historyStay.html.twig',[
            "stays" => $stays,
            "lastname" => $lastname,
            "firstname" => $firstname
        ]); 
    }

    /**
     * @Route("/user/nouveauSéjour/{id}/{lastname}/{firstname}", name="newStay")
     */
    public function newStay($id, $firstname, $lastname):Response 
    {
        $data = $this->getDoctrine()->getRepository(Service::class)->findAll();
        return $this->render('user/stay/showStay.html.twig', [
            'services' => $data,
            'idPatient' => $id,
            "firstname" => $firstname, 
            "lastname" => $lastname
        ]); 
    }

    /**
     * @Route("/user/addStay/{id}/{lastname}/{firstname}", name="addStayPatient")
     */
    public function addStayPatient( $id, $firstname, $lastname): Response
    {
        if(isset($_POST['date1']) && isset($_POST['date2']) && isset($_POST['service'])){
            if($_POST['date1']<$_POST['date2']){
                date_default_timezone_set('Europe/Paris');
                $beds = $this->getDoctrine()->getRepository(Bed::class)->findBedsAndRooms($_POST['service'], $_POST['date1'], $_POST['date2']);
                if(count($beds)>0){
                    $currentDate = date("Y-m-d H:i:s");
                    $entry =  new DateTime($_POST['date1']);
                    $leave =  new DateTime($_POST['date2']);
                    $this->getDoctrine()->getRepository(Stay::class)->AddStayPatient($beds[0]['bed'], $id , $_POST['date1'], $_POST['date2'], $currentDate);
                    $stay=$this->getDoctrine()->getRepository(Stay::class)->findOneBy(['entryDate' => $entry, 'leaveDate' => $leave ]);
                    $staffId=$this->getUser()->getId();
                    $this->getDoctrine()->getRepository(AddStay::class)->addLogerStay($stay->getId(), $staffId, $currentDate, 'creation');

                
                    return $this->redirectToRoute('staysPatient', ["id" => $id, "firstname" => $firstname,"lastname" => $lastname ]);
                }
                else{
                    //A améliorer 
                    $date = $this->getDoctrine()->getRepository(Stay::class)->nextAvailability($_POST['service']);                    
                    $data = $this->getDoctrine()->getRepository(Service::class)->findAll();
                    if(count($date)>0){
                        return $this->render('user/stay/showStay.html.twig', [
                            'services' => $data,
                            'idPatient' => $id,
                            "firstname" => $firstname, 
                            "lastname" => $lastname,
                            "pb2" => $date[0]["leave"],
                            "entryDate" => $_POST["date1"],
                            "leaveDate" => $_POST["date2"],
                            "serviceId" => $_POST['service']
                        ]);
                    }
                    else{
                        return $this->render('user/stay/showStay.html.twig', [
                            'services' => $data,
                            'idPatient' => $id,
                            "firstname" => $firstname, 
                            "lastname" => $lastname,
                            "pb3" => 0,
                            "entryDate" => $_POST["date1"],
                            "leaveDate" => $_POST["date2"],
                            "serviceId" => $_POST['service']
                        ]);
                    }
                    
                }
            }
            else{
                $data = $this->getDoctrine()->getRepository(Service::class)->findAll();
                return $this->render('user/stay/showStay.html.twig', [
                    'services' => $data,
                    'idPatient' => $id,
                    "firstname" => $firstname, 
                    "lastname" => $lastname,
                    "pb" => 0,
                    "entryDate" => $_POST["date1"],
                    "leaveDate" => $_POST["date2"],
                    "serviceId" => $_POST['service']
                ]);  
            }            
        }
        $data = $this->getDoctrine()->getRepository(Service::class)->findAll();
        return $this->render('user/stay/showStay.html.twig', [
            'services' => $data,
            'idPatient' => $id,
            "firstname" => $firstname, 
            "lastname" => $lastname,
            "fail" => true
        ]);  
    }
}