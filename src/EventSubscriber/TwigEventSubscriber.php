<?php

namespace App\EventSubscriber;

use App\Repository\AnneeRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
   private $twig;
    private $anneeRepository;

    public function __construct(Environment $twig, AnneeRepository $anneeRepository) {
        $this->twig = $twig;
        $this->anneeRepository = $anneeRepository;
    }

    public function onControllerEvent(ControllerEvent $event) {
        $this->twig->addGlobal('annees', $this->anneeRepository->findAll()); 
    }
    public static function getSubscribedEvents(): array
    {
        return [
            ControllerEvent::class => 'onControllerEvent',
        ];
    }
}
