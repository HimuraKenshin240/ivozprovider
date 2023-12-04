<?php

namespace Ivoz\Kam\Domain\Model\TrunksDomainAttr;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;

/**
* TrunksDomainAttrDtoAbstract
* @codeCoverageIgnore
*/
abstract class TrunksDomainAttrDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var string|null
     */
    private $did = null;

    /**
     * @var string|null
     */
    private $name = null;

    /**
     * @var int|null
     */
    private $type = null;

    /**
     * @var string|null
     */
    private $value = null;

    /**
     * @var \DateTimeInterface|string|null
     */
    private $lastModified = '1900-01-01 00:00:01';

    /**
     * @var int|null
     */
    private $id = null;

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
            'did' => 'did',
            'name' => 'name',
            'type' => 'type',
            'value' => 'value',
            'lastModified' => 'lastModified',
            'id' => 'id'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'did' => $this->getDid(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'value' => $this->getValue(),
            'lastModified' => $this->getLastModified(),
            'id' => $this->getId()
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

    public function setDid(string $did): static
    {
        $this->did = $did;

        return $this;
    }

    public function getDid(): ?string
    {
        return $this->did;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setLastModified(\DateTimeInterface|string $lastModified): static
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    public function getLastModified(): \DateTimeInterface|string|null
    {
        return $this->lastModified;
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
}
