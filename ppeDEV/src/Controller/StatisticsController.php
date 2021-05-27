<?php

namespace App\Controller;

use App\Entity\Stay;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends AbstractController
{
    /**
     * @Route("/admin/statistics", name="statistics")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        /** @var Stay[] $donnees */
        $donnees = $this->getDoctrine()->getRepository(Stay::class)->findAverageTimeAllBed();

        $lits = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1), //récupère le numéro de la page en cours et si on en a pas on récupère 1
            6//nombre d'élements par page
        );

        return $this->render('statistics/index.html.twig', [
            "lits" => $lits
        ]);
    }
}
