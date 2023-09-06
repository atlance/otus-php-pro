<?php

declare(strict_types=1);

namespace App\Domain\Event\UseCase\Bank\Statement\Generated\Subscriber\Notify;

use App\Domain\Event\UseCase\Bank\Statement\Generated;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

final class EmailNotificator implements Contract\NotificatorInterface
{
    private const SUBJECT = 'Банковская выписка.';

    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly string $fromAppEmail
    ) {
    }

    public function notify(Generated $event): void
    {
        $message = (new TemplatedEmail())
            ->from($this->fromAppEmail)
            ->to($event->email->getValue())
            ->subject(self::SUBJECT)
            ->htmlTemplate('@src/bank/generate/statement/template.html.twig')
            ->context([
                'id' => $event->id,
                'startAt' => $event->startAt->format('Y-m-d'),
                'endAt' => $event->endAt->format('Y-m-d'),
            ])
        ;

        $this->mailer->send($message);
    }
}
