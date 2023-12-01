<?php

namespace Ivoz\Provider\Domain\Model\ExternalCallFilterBlackList;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\ExternalCallFilter\ExternalCallFilterDto;
use Ivoz\Provider\Domain\Model\MatchList\MatchListDto;

/**
* ExternalCallFilterBlackListDtoAbstract
* @codeCoverageIgnore
*/
abstract class ExternalCallFilterBlackListDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var ExternalCallFilterDto | null
     */
    private $filter = null;

    /**
     * @var MatchListDto | null
     */
    private $matchlist = null;

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
            'id' => 'id',
            'filterId' => 'filter',
            'matchlistId' => 'matchlist'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'id' => $this->getId(),
            'filter' => $this->getFilter(),
            'matchlist' => $this->getMatchlist()
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

    public function setId($id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setFilter(?ExternalCallFilterDto $filter): static
    {
        $this->filter = $filter;

        return $this;
    }

    public function getFilter(): ?ExternalCallFilterDto
    {
        return $this->filter;
    }

    public function setFilterId($id): static
    {
        $value = !is_null($id)
            ? new ExternalCallFilterDto($id)
            : null;

        return $this->setFilter($value);
    }

    public function getFilterId(): ?int
    {
        if ($dto = $this->getFilter()) {
            return $dto->getId();
        }

        return null;
    }

    public function setMatchlist(?MatchListDto $matchlist): static
    {
        $this->matchlist = $matchlist;

        return $this;
    }

    public function getMatchlist(): ?MatchListDto
    {
        return $this->matchlist;
    }

    public function setMatchlistId($id): static
    {
        $value = !is_null($id)
            ? new MatchListDto($id)
            : null;

        return $this->setMatchlist($value);
    }

    public function getMatchlistId(): ?int
    {
        if ($dto = $this->getMatchlist()) {
            return $dto->getId();
        }

        return null;
    }
}
