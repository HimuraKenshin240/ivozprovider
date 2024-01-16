<?php

namespace Ivoz\Provider\Application\Service\BillableCall;

use Ivoz\Core\Domain\Model\Commandlog\Commandlog;
use Ivoz\Core\Domain\Service\EntityTools;
use Ivoz\Kam\Domain\Model\TrunksCdr\TrunksCdrRepository;
use Ivoz\Provider\Domain\Service\BillableCall\MigrateFromTrunksCdr;
use Psr\Log\LoggerInterface;

class MigrateFromUnparsedTrunksCdr
{
    public const BATCH_SIZE = 100;

    public function __construct(
        private TrunksCdrRepository $trunksCdrRepository,
        private EntityTools $entityTools,
        private MigrateFromTrunksCdr $migrateFromTrunksCdr,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @return void
     */
    public function execute()
    {
        $trunksGenerator = $this->trunksCdrRepository->getUnparsedCallsGeneratorWithoutOffset(
            self::BATCH_SIZE
        );

        $cdrCount = 0;
        foreach ($trunksGenerator as $trunks) {
            if (empty($trunks)) {
                break;
            }

            foreach ($trunks as $trunkCdr) {
                $this->migrateFromTrunksCdr->execute(
                    $trunkCdr,
                    false
                );
            }

            try {
                $this->entityTools->dispatchQueuedOperations();
                $this->entityTools->clearExcept(
                    Commandlog::class
                );

                $cdrCount += count($trunks);
            } catch (\Exception $e) {
                $this->logger->error('BillableCall migration service error:: ' . $e->getMessage());
                // Keep going
            }
        }

        $this->logger->info('BillableCall migration service has migrated ' . $cdrCount . ' successfully');
    }
}
