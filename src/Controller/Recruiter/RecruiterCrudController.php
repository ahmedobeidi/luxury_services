<?php

namespace App\Controller\Recruiter;

use App\Entity\Recruiter;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class RecruiterCrudController extends AbstractCrudController
{
    private EntityRepository $entityRepository;


    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Recruiter::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('companyName'),
            TextField::new('contactName'),
            TextField::new('phone'),
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance === null ) {
            $entityInstance = new Recruiter();
        }
        // dd($this->getUser());
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        // dd($response);
        $response = $this->entityRepository->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->andWhere('entity.user = :user')->setParameter('user', $this->getUser());


        return $response;
    }

    public function configureActions(Actions $actions): Actions
    {
        /** @var User */
        $user = $this->getUser();
        $existingClient = $user->getRecruiter();

        if ($existingClient) {
            return $actions
                ->disable(Action::NEW);
        }

        return $actions;
    }

    
}
