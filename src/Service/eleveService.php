<?php

namespace App\Service;

use App\Repository\ElevesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class eleveService
{
    public function __construct(private RequestStack $requestStack, private ElevesRepository $elevesRepos, private PaginatorInterface $paginator){}

    public function getEleves()
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 15); // Récupère la limite depuis l'URL, sinon 15
        $eleveQuery = $this->elevesRepos->findAll();
        return $this->paginator->paginate($eleveQuery, $page, $limit);
    }
}