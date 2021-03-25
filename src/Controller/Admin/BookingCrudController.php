<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class BookingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Booking::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('bookingState');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('lodging')->setLabel('Lodging'),
            AssociationField::new('user')->autocomplete(),
            DateField::new('bookedAt')->onlyOnIndex(),
            IntegerField::new('totalPricing')->setLabel('Price'),
            IntegerField::new('totalOccupiers')->setTextAlign('center')->setLabel('Occupiers'),
            DateTimeField::new('beginsAt'),
            DateTimeField::new('endsAt'),
            DateField::new('bookedAt')->onlyOnIndex(),
            AssociationField::new('bookingState')->setLabel('State')->setTextAlign('center')
        ];
    }

}
