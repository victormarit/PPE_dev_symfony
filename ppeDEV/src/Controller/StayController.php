<?php 

namespace App\Controller;

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
}