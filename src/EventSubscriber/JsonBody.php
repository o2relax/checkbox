<?php


namespace App\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class JsonBody implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'convertJsonStringToArray',
        ];
    }

    public function convertJsonStringToArray(ControllerEvent $event): void
    {
        if ($event->getRequest()->getContentTypeFormat() !== 'json' || !$event->getRequest()->getContent()) {
            return;
        }

        $data = json_decode((string)$event->getRequest()->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $event->getRequest()->request->replace(is_array($data) ? $data : []);
    }
}
