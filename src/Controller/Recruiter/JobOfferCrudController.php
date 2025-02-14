<?php

namespace App\Controller\Recruiter;

use App\Entity\JobOffer;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use App\Entity\Recruiter;
use App\Entity\User;


class JobOfferCrudController extends AbstractCrudController
{

    private EntityRepository $entityRepository;


    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public static function getEntityFqcn(): string
    {
        return JobOffer::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextareaField::new('description'),
            AssociationField::new('category'),
            // TextField::new('contactName'),
            // TextField::new('companyName'),
            // EmailField::new('contactEmail'),
            // TextField::new('contactPhone'),
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        /** @var User $user */
        $user = $this->getUser();
        $recruiter = $user->getRecruiter();

        $response = $this->entityRepository->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->andWhere('entity.recruiter = :recruiter')->setParameter('recruiter', $recruiter);

        return $response;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    { 
        /** @var User */
        $user = $this->getUser();

        /** @var Recruiter */
        $recruiter = $user->getRecruiter();

        $entityInstance->setContactEmail($user->getEmail());
        $entityInstance->setRecruiter($recruiter);
        $entityInstance->setCompanyName($recruiter->getCompanyName());
        $entityInstance->setContactName($recruiter->getContactName());
        $entityInstance->setContactPhone($recruiter->getPhone());

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
