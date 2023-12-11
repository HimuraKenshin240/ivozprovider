<?php

namespace Ivoz\Cgr\Domain\Model\TpRate;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\DestinationRate\DestinationRateDto;

/**
* TpRateDtoAbstract
* @codeCoverageIgnore
*/
abstract class TpRateDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var string|null
     */
    private $tpid = 'ivozprovider';

    /**
     * @var string|null
     */
    private $tag = null;

    /**
     * @var float|null
     */
    private $connectFee = null;

    /**
     * @var float|null
     */
    private $rateCost = null;

    /**
     * @var string|null
     */
    private $rateUnit = '60s';

    /**
     * @var string|null
     */
    private $rateIncrement = null;

    /**
     * @var string|null
     */
    private $groupIntervalStart = '0s';

    /**
     * @var \DateTimeInterface|string|null
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var DestinationRateDto | null
     */
    private $destinationRate = null;

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
            'tpid' => 'tpid',
            'tag' => 'tag',
            'connectFee' => 'connectFee',
            'rateCost' => 'rateCost',
            'rateUnit' => 'rateUnit',
            'rateIncrement' => 'rateIncrement',
            'groupIntervalStart' => 'groupIntervalStart',
            'createdAt' => 'createdAt',
            'id' => 'id',
            'destinationRateId' => 'destinationRate'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'tpid' => $this->getTpid(),
            'tag' => $this->getTag(),
            'connectFee' => $this->getConnectFee(),
            'rateCost' => $this->getRateCost(),
            'rateUnit' => $this->getRateUnit(),
            'rateIncrement' => $this->getRateIncrement(),
            'groupIntervalStart' => $this->getGroupIntervalStart(),
            'createdAt' => $this->getCreatedAt(),
            'id' => $this->getId(),
            'destinationRate' => $this->getDestinationRate()
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

    public function setTpid(string $tpid): static
    {
        $this->tpid = $tpid;

        return $this;
    }

    public function getTpid(): ?string
    {
        return $this->tpid;
    }

    public function setTag(?string $tag): static
    {
        $this->tag = $tag;

        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
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

    public function setRateCost(float $rateCost): static
    {
        $this->rateCost = $rateCost;

        return $this;
    }

    public function getRateCost(): ?float
    {
        return $this->rateCost;
    }

    public function setRateUnit(string $rateUnit): static
    {
        $this->rateUnit = $rateUnit;

        return $this;
    }

    public function getRateUnit(): ?string
    {
        return $this->rateUnit;
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

    public function setCreatedAt(\DateTimeInterface|string $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface|string|null
    {
        return $this->createdAt;
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

    public function setDestinationRate(?DestinationRateDto $destinationRate): static
    {
        $this->destinationRate = $destinationRate;

        return $this;
    }

    public function getDestinationRate(): ?DestinationRateDto
    {
        return $this->destinationRate;
    }

    public function setDestinationRateId(?int $id): static
    {
        $value = !is_null($id)
            ? new DestinationRateDto($id)
            : null;

        return $this->setDestinationRate($value);
    }

    public function getDestinationRateId(): ?int
    {
        if ($dto = $this->getDestinationRate()) {
            return $dto->getId();
        }

        return null;
    }
}
