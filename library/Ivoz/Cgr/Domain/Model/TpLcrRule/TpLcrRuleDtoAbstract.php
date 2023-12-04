<?php

namespace Ivoz\Cgr\Domain\Model\TpLcrRule;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\OutgoingRouting\OutgoingRoutingDto;

/**
* TpLcrRuleDtoAbstract
* @codeCoverageIgnore
*/
abstract class TpLcrRuleDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var string|null
     */
    private $tpid = 'ivozprovider';

    /**
     * @var string|null
     */
    private $direction = '*out';

    /**
     * @var string|null
     */
    private $tenant = null;

    /**
     * @var string|null
     */
    private $category = null;

    /**
     * @var string|null
     */
    private $account = '*any';

    /**
     * @var string|null
     */
    private $subject = '*any';

    /**
     * @var string|null
     */
    private $destinationTag = '*any';

    /**
     * @var string|null
     */
    private $rpCategory = null;

    /**
     * @var string|null
     */
    private $strategy = '*lowest_cost';

    /**
     * @var string|null
     */
    private $strategyParams = '';

    /**
     * @var \DateTimeInterface|string|null
     */
    private $activationTime = 'CURRENT_TIMESTAMP';

    /**
     * @var float|null
     */
    private $weight = 10;

    /**
     * @var \DateTimeInterface|string|null
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var OutgoingRoutingDto | null
     */
    private $outgoingRouting = null;

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
            'direction' => 'direction',
            'tenant' => 'tenant',
            'category' => 'category',
            'account' => 'account',
            'subject' => 'subject',
            'destinationTag' => 'destinationTag',
            'rpCategory' => 'rpCategory',
            'strategy' => 'strategy',
            'strategyParams' => 'strategyParams',
            'activationTime' => 'activationTime',
            'weight' => 'weight',
            'createdAt' => 'createdAt',
            'id' => 'id',
            'outgoingRoutingId' => 'outgoingRouting'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'tpid' => $this->getTpid(),
            'direction' => $this->getDirection(),
            'tenant' => $this->getTenant(),
            'category' => $this->getCategory(),
            'account' => $this->getAccount(),
            'subject' => $this->getSubject(),
            'destinationTag' => $this->getDestinationTag(),
            'rpCategory' => $this->getRpCategory(),
            'strategy' => $this->getStrategy(),
            'strategyParams' => $this->getStrategyParams(),
            'activationTime' => $this->getActivationTime(),
            'weight' => $this->getWeight(),
            'createdAt' => $this->getCreatedAt(),
            'id' => $this->getId(),
            'outgoingRouting' => $this->getOutgoingRouting()
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

    public function setDirection(string $direction): static
    {
        $this->direction = $direction;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setTenant(string $tenant): static
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function getTenant(): ?string
    {
        return $this->tenant;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setAccount(string $account): static
    {
        $this->account = $account;

        return $this;
    }

    public function getAccount(): ?string
    {
        return $this->account;
    }

    public function setSubject(?string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setDestinationTag(?string $destinationTag): static
    {
        $this->destinationTag = $destinationTag;

        return $this;
    }

    public function getDestinationTag(): ?string
    {
        return $this->destinationTag;
    }

    public function setRpCategory(string $rpCategory): static
    {
        $this->rpCategory = $rpCategory;

        return $this;
    }

    public function getRpCategory(): ?string
    {
        return $this->rpCategory;
    }

    public function setStrategy(string $strategy): static
    {
        $this->strategy = $strategy;

        return $this;
    }

    public function getStrategy(): ?string
    {
        return $this->strategy;
    }

    public function setStrategyParams(?string $strategyParams): static
    {
        $this->strategyParams = $strategyParams;

        return $this;
    }

    public function getStrategyParams(): ?string
    {
        return $this->strategyParams;
    }

    public function setActivationTime(\DateTimeInterface|string $activationTime): static
    {
        $this->activationTime = $activationTime;

        return $this;
    }

    public function getActivationTime(): \DateTimeInterface|string|null
    {
        return $this->activationTime;
    }

    public function setWeight(float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
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

    public function setOutgoingRouting(?OutgoingRoutingDto $outgoingRouting): static
    {
        $this->outgoingRouting = $outgoingRouting;

        return $this;
    }

    public function getOutgoingRouting(): ?OutgoingRoutingDto
    {
        return $this->outgoingRouting;
    }

    public function setOutgoingRoutingId(?int $id): static
    {
        $value = !is_null($id)
            ? new OutgoingRoutingDto($id)
            : null;

        return $this->setOutgoingRouting($value);
    }

    public function getOutgoingRoutingId(): ?int
    {
        if ($dto = $this->getOutgoingRouting()) {
            return $dto->getId();
        }

        return null;
    }
}
