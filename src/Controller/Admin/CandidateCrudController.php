<?php

namespace App\Controller\Admin;

use App\Entity\Candidate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CandidateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Candidate::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstName')->setRequired(true),
            TextField::new('lastName')->setRequired(true),
            TextField::new('gender')->setRequired(true),
            TextField::new('country')->setRequired(true),
            TextField::new('address')->setRequired(true),
            TextField::new('nationality')->setRequired(true),
            DateField::new('birthdate')->setRequired(true),
            TextField::new('profilePicture')->setRequired(true),
            TextField::new('passportFile')->setRequired(true),
            TextField::new('cvFile')->setRequired(true),
            TextField::new('description')->setRequired(true),
            AssociationField::new('experience')->autocomplete()
        ];
    }
    
}
