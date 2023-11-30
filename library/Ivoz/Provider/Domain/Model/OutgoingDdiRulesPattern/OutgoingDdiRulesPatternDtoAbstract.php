<?php

namespace Ivoz\Provider\Domain\Model\OutgoingDdiRulesPattern;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\OutgoingDdiRule\OutgoingDdiRuleDto;
use Ivoz\Provider\Domain\Model\MatchList\MatchListDto;
use Ivoz\Provider\Domain\Model\Ddi\DdiDto;

/**
* OutgoingDdiRulesPatternDtoAbstract
* @codeCoverageIgnore
*/
abstract class OutgoingDdiRulesPatternDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var string|null
     */
    private $type = null;

    /**
     * @var string|null
     */
    private $prefix = null;

    /**
     * @var string|null
     */
    private $action = null;

    /**
     * @var int|null
     */
    private $priority = 1;

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var OutgoingDdiRuleDto | null
     */
    private $outgoingDdiRule = null;

    /**
     * @var MatchListDto | null
     */
    private $matchList = null;

    /**
     * @var DdiDto | null
     */
    private $forcedDdi = null;

    /**
     * @param string|int|null $id
     */
    public function __construct($id = null)
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
            'type' => 'type',
            'prefix' => 'prefix',
            'action' => 'action',
            'priority' => 'priority',
            'id' => 'id',
            'outgoingDdiRuleId' => 'outgoingDdiRule',
            'matchListId' => 'matchList',
            'forcedDdiId' => 'forcedDdi'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'type' => $this->getType(),
            'prefix' => $this->getPrefix(),
            'action' => $this->getAction(),
            'priority' => $this->getPriority(),
            'id' => $this->getId(),
            'outgoingDdiRule' => $this->getOutgoingDdiRule(),
            'matchList' => $this->getMatchList(),
            'forcedDdi' => $this->getForcedDdi()
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

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setPrefix(?string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    public function setAction(string $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setId($id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setOutgoingDdiRule(?OutgoingDdiRuleDto $outgoingDdiRule): static
    {
        $this->outgoingDdiRule = $outgoingDdiRule;

        return $this;
    }

    public function getOutgoingDdiRule(): ?OutgoingDdiRuleDto
    {
        return $this->outgoingDdiRule;
    }

    public function setOutgoingDdiRuleId($id): static
    {
        $value = !is_null($id)
            ? new OutgoingDdiRuleDto($id)
            : null;

        return $this->setOutgoingDdiRule($value);
    }

    public function getOutgoingDdiRuleId(): ?int
    {
        if ($dto = $this->getOutgoingDdiRule()) {
            return $dto->getId();
        }

        return null;
    }

    public function setMatchList(?MatchListDto $matchList): static
    {
        $this->matchList = $matchList;

        return $this;
    }

    public function getMatchList(): ?MatchListDto
    {
        return $this->matchList;
    }

    public function setMatchListId($id): static
    {
        $value = !is_null($id)
            ? new MatchListDto($id)
            : null;

        return $this->setMatchList($value);
    }

    public function getMatchListId(): ?int
    {
        if ($dto = $this->getMatchList()) {
            return $dto->getId();
        }

        return null;
    }

    public function setForcedDdi(?DdiDto $forcedDdi): static
    {
        $this->forcedDdi = $forcedDdi;

        return $this;
    }

    public function getForcedDdi(): ?DdiDto
    {
        return $this->forcedDdi;
    }

    public function setForcedDdiId($id): static
    {
        $value = !is_null($id)
            ? new DdiDto($id)
            : null;

        return $this->setForcedDdi($value);
    }

    public function getForcedDdiId(): ?int
    {
        if ($dto = $this->getForcedDdi()) {
            return $dto->getId();
        }

        return null;
    }
}
