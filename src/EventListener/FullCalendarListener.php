<?php

namespace App\EventListener;

use App\Entity\Evenements;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class FullCalendarListener
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $router)
    {
        $this->em = $em;
        $this->router = $router;
    }

    public function loadEvents(CalendarEvent $calendar)
    {
        $startDate = $calendar->getStart();
        $endDate = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change b.beginAt by your start date in your custom entity
        $evenementss = $this->em->getRepository(Evenements::class)
            ->createQueryBuilder('b')
            ->andWhere('b.start_date BETWEEN :startDate and :endDate')
            ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()->getResult();

        foreach($evenementss as $evenements) {

            // this create the events with your own entity (here evenements entity) to populate calendar
            $evenementsEvent = new Event(
                $evenements->getTitre(),
                $evenements->getStartDate(),
                $evenements->getEndDate() // If the end date is null or not defined, it creates a all day event
            );

            /*
             * Optional calendar event settings
             *
             * For more information see : Toiba\FullCalendarBundle\Entity\Event
             * and : https://fullcalendar.io/docs/event-object
             */
            // $evenementsEvent->setUrl('http://www.google.com');
            // $evenementsEvent->setBackgroundColor($evenements->getColor());
            // $evenementsEvent->setCustomField('borderColor', $evenements->getColor());

            $evenementsEvent->setUrl(
                $this->router->generate('evenements_show', array(
                    'id' => $evenements->getId(),
                ))
            );

            // finally, add the evenements to the CalendarEvent for displaying on the calendar
            $calendar->addEvent($evenementsEvent);
        }
    }
}