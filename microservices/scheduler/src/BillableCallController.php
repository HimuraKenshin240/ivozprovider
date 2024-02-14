<?php

use Symfony\Component\HttpFoundation\Response;
use Ivoz\Provider\Application\Service\BillableCall\MigrateFromUnparsedTrunksCdr as BillableCallFromTrunksCdr;
use Ivoz\Core\Domain\Service\DomainEventPublisher;
use Ivoz\Core\Domain\RequestId;
use Ivoz\Core\Domain\RegisterCommandTrait;
use Psr\Log\LoggerInterface;

class BillableCallController
{
    use RegisterCommandTrait;

    public function __construct(
        private BillableCallFromTrunksCdr $billableCallFromTrunksCdr,
        private LoggerInterface $logger,
        DomainEventPublisher $eventPublisher,
        RequestId $requestId
    ) {
        $this->eventPublisher = $eventPublisher;
        $this->requestId = $requestId;
    }

    public function indexAction(): Response
    {
        try {
            $this->registerCommand('Scheduler', 'billableCall');
            $this->billableCallFromTrunksCdr->execute();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return new Response(
                $e->getMessage() . "\n",
                500
            );
        }

        return new Response("BillableCall migration done!\n", 200);
    }
}
