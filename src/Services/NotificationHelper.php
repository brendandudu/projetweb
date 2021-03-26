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
     * Envoie une notification et un sms à l'utilisateur après une réservation effectuée
     */
    public function sendNotification(UserInterface $user, Lodging $lodging, EntityManagerInterface $manager): void
    {
        $notification = new Notification();

        $description = 'Votre réservation de : ' . $lodging->getName() . 'est confirmée';

        $notification
            ->setUser($user)
            ->setDescription($description);

        $manager->persist($notification);
        $manager->flush();


    }
}