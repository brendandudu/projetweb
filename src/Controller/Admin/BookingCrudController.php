<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BookingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Booking::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('week')
            ->add('bookingState')
            ;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('lodging')->setLabel('Lodging'),
            AssociationField::new('User')->autocomplete(),
            DateField::new('bookedAt')->onlyOnIndex(),
            IntegerField::new('totalPricing')->setLabel('Price'),
            IntegerField::new('totalOccupiers')->setTextAlign('center')->setLabel('Occupiers'),
            IntegerField::new('note')->onlyOnIndex(),
            AssociationField::new('week')->setLabel('Week'),
            AssociationField::new('bookingState')->setLabel('State')->setTextAlign('center')
        ];
    }

}
