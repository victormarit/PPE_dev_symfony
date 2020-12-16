<?php

namespace App\Controller;

use App\Entity\AddStay;
use App\Entity\LogUser;
use App\Entity\Manage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class logController extends AbstractController
{
    /**
     * @Route("/admin/historiqueConnexion", name="logConnection")
     * @param Request $request
     * @return Response
     */
    public function logConnection(Request $request, PaginatorInterface $paginator):Response 
    {        
        if(isset($_GET['search'])){
            $data = $this->getDoctrine()->getRepository(LogUser::class)->FindUserLogQuery($_GET['search']);
        }
        else {
            $data = $this->getDoctrine()->getRepository(LogUser::class)->FindUserLog();
        }

        $logs = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), //récupère le numéro de la page en cours et si on en a pas on récupère 1
            10//nombre d'élements par page 
        );
        return $this->render('admin/log/userLog.html.twig', [
            'logs' => $logs
        ]);
    }

    /**
     * @Route("/admin/historiqueGestionPatient", name="logManagePatient")
     * @param Request $request
     * @return Response
     */
    public function logManagePatient(Request $request, PaginatorInterface $paginator):Response 
    {        
        if(isset($_GET['search'])){
            $data = $this->getDoctrine()->getRepository(Manage::class)->FindPatientLogQuery($_GET['search']);
        }
        else {
            $data = $this->getDoctrine()->getRepository(Manage::class)->FindPatientLog();
        }

        $logs = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), //récupère le numéro de la page en cours et si on en a pas on récupère 1
            10//nombre d'élements par page 
        );
        dump($logs);
        return $this->render('admin/log/patientLog.html.twig', [
            'logs' => $logs
        ]);
    }


    /**
     * @Route("/admin/historiqueGestionSéjour", name="logManageStay")
     * @param Request $request
     * @return Response
     */
    public function logManageStay(Request $request, PaginatorInterface $paginator):Response 
    {        
        if(isset($_GET['search'])){
            $data = $this->getDoctrine()->getRepository(AddStay::class)->FindStayLogQuery($_GET['search']);
        }
        else {
            $data = $this->getDoctrine()->getRepository(AddStay::class)->FindStayLog();
        }

        $logs = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), //récupère le numéro de la page en cours et si on en a pas on récupère 1
            10//nombre d'élements par page 
        );
        dump($logs);
        return $this->render('admin/log/logAddStay.html.twig', [
            'logs' => $logs
        ]);
    }
}
