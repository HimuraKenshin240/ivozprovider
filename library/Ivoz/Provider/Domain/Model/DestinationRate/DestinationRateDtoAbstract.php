<?php

namespace Ivoz\Provider\Domain\Model\DestinationRate;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\DestinationRateGroup\DestinationRateGroupDto;
use Ivoz\Provider\Domain\Model\Destination\DestinationDto;
use Ivoz\Cgr\Domain\Model\TpRate\TpRateDto;
use Ivoz\Cgr\Domain\Model\TpDestinationRate\TpDestinationRateDto;

/**
* DestinationRateDtoAbstract
* @codeCoverageIgnore
*/
abstract class DestinationRateDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var float|null
     */
    private $cost = null;

    /**
     * @var float|null
     */
    private $connectFee = null;

    /**
     * @var string|null
     */
    private $rateIncrement = null;

    /**
     * @var string|null
     */
    private $groupIntervalStart = '0s';

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var DestinationRateGroupDto | null
     */
    private $destinationRateGroup = null;

    /**
     * @var DestinationDto | null
     */
    private $destination = null;

    /**
     * @var TpRateDto | null
     */
    private $tpRate = null;

    /**
     * @var TpDestinationRateDto | null
     */
    private $tpDestinationRate = null;

    public function __construct(?int $id = null)
    {
        $this->setId($id);
    }

    /**
    * @inheritdoc
    */
    public static function getPropertyMap(string $context = '', string $role = null): array
    {
        if ($context === self::CONTEXT_COLLECTION) {
            return ['id' => 'id'];
        }

        return [
            'cost' => 'cost',
            'connectFee' => 'connectFee',
            'rateIncrement' => 'rateIncrement',
            'groupIntervalStart' => 'groupIntervalStart',
            'id' => 'id',
            'destinationRateGroupId' => 'destinationRateGroup',
            'destinationId' => 'destination',
            'tpRateId' => 'tpRate',
            'tpDestinationRateId' => 'tpDestinationRate'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'cost' => $this->getCost(),
            'connectFee' => $this->getConnectFee(),
            'rateIncrement' => $this->getRateIncrement(),
            'groupIntervalStart' => $this->getGroupIntervalStart(),
            'id' => $this->getId(),
            'destinationRateGroup' => $this->getDestinationRateGroup(),
            'destination' => $this->getDestination(),
            'tpRate' => $this->getTpRate(),
            'tpDestinationRate' => $this->getTpDestinationRate()
        ];

        if (!$hideSensitiveData) {
            return $response;
        }

        foreach ($this->sensitiveFields as $sensitiveField) {
            if (!array_key_exists($sensitiveField, $response)) {
                throw new \Exception($sensitiveField . ' field was not found');
            }
            $response[$sensitiveField] = '*****';
        }

        return $response;
    }

    public function setCost(float $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setConnectFee(float $connectFee): static
    {
        $this->connectFee = $connectFee;

        return $this;
    }

    public function getConnectFee(): ?float
    {
        return $this->connectFee;
    }

    public function setRateIncrement(string $rateIncrement): static
    {
        $this->rateIncrement = $rateIncrement;

        return $this;
    }

    public function getRateIncrement(): ?string
    {
        return $this->rateIncrement;
    }

    public function setGroupIntervalStart(string $groupIntervalStart): static
    {
        $this->groupIntervalStart = $groupIntervalStart;

        return $this;
    }

    public function getGroupIntervalStart(): ?string
    {
        return $this->groupIntervalStart;
    }

    /**
     * @param int|null $id
     */
    public function setId($id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setDestinationRateGroup(?DestinationRateGroupDto $destinationRateGroup): static
    {
        $this->destinationRateGroup = $destinationRateGroup;

        return $this;
    }

    public function getDestinationRateGroup(): ?DestinationRateGroupDto
    {
        return $this->destinationRateGroup;
    }

    public function setDestinationRateGroupId(?int $id): static
    {
        $value = !is_null($id)
            ? new DestinationRateGroupDto($id)
            : null;

        return $this->setDestinationRateGroup($value);
    }

    public function getDestinationRateGroupId(): ?int
    {
        if ($dto = $this->getDestinationRateGroup()) {
            return $dto->getId();
        }

        return null;
    }

    public function setDestination(?DestinationDto $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDestination(): ?DestinationDto
    {
        return $this->destination;
    }

    public function setDestinationId(?int $id): static
    {
        $value = !is_null($id)
            ? new DestinationDto($id)
            : null;

        return $this->setDestination($value);
    }

    public function getDestinationId(): ?int
    {
        if ($dto = $this->getDestination()) {
            return $dto->getId();
        }

        return null;
    }

    public function setTpRate(?TpRateDto $tpRate): static
    {
        $this->tpRate = $tpRate;

        return $this;
    }

    public function getTpRate(): ?TpRateDto
    {
        return $this->tpRate;
    }

    public function setTpRateId(?int $id): static
    {
        $value = !is_null($id)
            ? new TpRateDto($id)
            : null;

        return $this->setTpRate($value);
    }

    public function getTpRateId(): ?int
    {
        if ($dto = $this->getTpRate()) {
            return $dto->getId();
        }

        return null;
    }

    public function setTpDestinationRate(?TpDestinationRateDto $tpDestinationRate): static
    {
        $this->tpDestinationRate = $tpDestinationRate;

        return $this;
    }

    public function getTpDestinationRate(): ?TpDestinationRateDto
    {
        return $this->tpDestinationRate;
    }

    public function setTpDestinationRateId(?int $id): static
    {
        $value = !is_null($id)
            ? new TpDestinationRateDto($id)
            : null;

        return $this->setTpDestinationRate($value);
    }

    public function getTpDestinationRateId(): ?int
    {
        if ($dto = $this->getTpDestinationRate()) {
            return $dto->getId();
        }

        return null;
    }
}
