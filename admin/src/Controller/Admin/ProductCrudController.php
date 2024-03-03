<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            'name',
            'description',
            ImageField::new('image')
                ->setBasePath('/uploads/images/products')
                ->setUploadDir('public/uploads/images/products'),
            AssociationField::new('offers')
                ->setFormTypeOptions(['by_reference' => false])
        ];
    }

    public function configureActions(Actions $actions): Actions
{
    
    
    return $actions
        // ...
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
    ;
}
    
}
