<?php

namespace App\Services;

use App\Entity\Lodging;
use App\Entity\Notification;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Security\Core\User\UserInterface;

class NotificationHelper
{

    /**
     * Envoie une notification à l'utilisateur après une réservation effectuée
     */
    public function sendNotificationForBuyer(UserInterface $user, Lodging $lodging, EntityManagerInterface $manager): void
    {
        $notification = new Notification();

        $description = "Votre réservation de : " . $lodging->getName() ."est confirmée";

        $notification
            ->setUser($user)
            ->setDescription($description);

        $manager->persist($notification);
        $manager->flush();
    }

    /**
     * Envoie une notification au détenteur du logement après une réservation
     */
    public function sendNotificationForOwner(UserInterface $user, Lodging $lodging, EntityManagerInterface $manager): void
    {
        $notification = new Notification();

        $description = $user->getFirstName().''. $user->getLastName().' à réservé votre annonce : ' . $lodging->getName();

        $notification
            ->setUser($lodging->getOwner())
            ->setDescription($description);

        $manager->persist($notification);
        $manager->flush();
    }
}