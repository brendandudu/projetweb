<?php

namespace App\Controller\Admin;

use App\Entity\Lodging;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class LodgingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lodging::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('lodgingType')
            ;
    }


    public function configureFields(string $pageName): iterable
    {
        $imageFile = TextareaField::new('pictureFile')->setFormType(VichImageType::class);
        $image = ImageField::new('picture')->setBasePath('/assets/img/lodging')->setLabel('Image');

        $fields= [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description'),
            TextField::new('currentCondition')->setTextAlign('center'),
            IntegerField::new('space')->setTextAlign('center'),
            BooleanField::new('internetAvailable')->setLabel('Internet'),
            MoneyField::new('weeklyPricing')->setCurrency('EUR')->setLabel('Price'),
            IntegerField::new('capacity')->setTextAlign('center'),
            AssociationField::new('lodgingType')->setLabel('Type'),
        ];

        if($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL)
            $fields[] = $image;
        else
            $fields[] = $imageFile;

        return $fields;
    }

}
