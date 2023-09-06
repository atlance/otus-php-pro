<?php

declare(strict_types=1);

namespace App\Domain\UseCase\Bank\Generate\Statement\Subscriber\Notify;

use App\Domain\UseCase\Bank\Generate\Statement\Event;
use App\Domain\UseCase\Bank\Generate\Statement\Subscriber\Notify\Contract\NotificatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

final class EmailNotificator implements NotificatorInterface
{
    private const SUBJECT = 'Банковская выписка.';

    public function __construct(private readonly MailerInterface $mailer, private readonly string $fromAppEmail)
    {
    }

    public function notify(Event\Created $event): void
    {
        $message = (new TemplatedEmail())
            ->from($this->fromAppEmail)
            ->to($event->email)
            ->subject(self::SUBJECT)
            ->htmlTemplate('@src/bank/generate/statement/template.html.twig')
            ->context([
                'id' => $event->id,
                'startDate' => $event->startDate,
                'endDate' => $event->endDate,
            ])
        ;

        $this->mailer->send($message);
    }
}
