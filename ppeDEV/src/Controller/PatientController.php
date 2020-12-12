<?php 

namespace App\Controller;

use App\Entity\Bed;
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
            9//nombre d'élements par page 
        );
        return $this->render('pages/homepage.html.twig', [
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
                return $this->redirectToRoute('homepagePatient'); 
            }
            else
            {
                return $this->render('pages/addPatient.html.twig', [
                    "form" => $form->createView(),
                    'error' => True
                ]);
            } 
        }
        return $this->render('pages/addPatient.html.twig', [
            "form" => $form->createView()
        ]);
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
            return $this->redirectToRoute('homepagePatient'); 
        }
        
        return $this->render('pages/addPatient.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/user/supprimerPatient/{id}", name="delPatient")
     * @return Response
     */
    public function delPatient($id):Response 
    {
        $user = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(['id' => $id]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
           
        return $this->redirectToRoute('homepagePatient'); 
    }

    /**
     * @Route("/user/séjoursPatient/{id}/{lastname}/{firstname}", name="staysPatient")
     * @param Request $request
     * @return Response
     */
    public function staysPatient(Request $request, $id, PaginatorInterface $paginator, $lastname, $firstname):Response 
    {
        $data = $this->getDoctrine()->getRepository(Stay::class)->FindUserStays($id); //On peut passer par une requête SQL pour améliorer le système
        
        $stays = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), //récupère le numéro de la page en cours et si on en a pas on récupère 1
            10//nombre d'élements par page 
        );
        return $this->render('pages/historyStay.html.twig',[
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
        return $this->render('pages/patientStay.html.twig', [
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
                $currentDate = date("Y-m-d h:i:sa");
                $beds = $this->getDoctrine()->getRepository(Bed::class)->findBedsAndRooms($_POST['service'], $_POST['date1'], $_POST['date2']);
                if(count($beds)>0){
                    $this->getDoctrine()->getRepository(Stay::class)->AddStayPatient($beds[0]['bed'], $id , $_POST['date1'], $_POST['date2'], $currentDate);
                
                    return $this->redirectToRoute('staysPatient', ["id" => $id, "firstname" => $firstname,"lastname" => $lastname ]);
                }
            }
            else{
                $data = $this->getDoctrine()->getRepository(Service::class)->findAll();
                return $this->render('pages/patientStay.html.twig', [
                    'services' => $data,
                    'idPatient' => $id,
                    "firstname" => $firstname, 
                    "lastname" => $lastname,
                    "pb" => true
                ]);  
            }            
        }
        $data = $this->getDoctrine()->getRepository(Service::class)->findAll();
        return $this->render('pages/patientStay.html.twig', [
            'services' => $data,
            'idPatient' => $id,
            "firstname" => $firstname, 
            "lastname" => $lastname,
            "fail" => true
        ]);  
    }
}