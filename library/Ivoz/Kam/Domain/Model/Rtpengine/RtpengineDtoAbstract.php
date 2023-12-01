<?php

namespace Ivoz\Kam\Domain\Model\Rtpengine;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\MediaRelaySet\MediaRelaySetDto;

/**
* RtpengineDtoAbstract
* @codeCoverageIgnore
*/
abstract class RtpengineDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var int|null
     */
    private $setid = 0;

    /**
     * @var string|null
     */
    private $url = null;

    /**
     * @var int|null
     */
    private $weight = 1;

    /**
     * @var bool|null
     */
    private $disabled = false;

    /**
     * @var \DateTimeInterface|string|null
     */
    private $stamp = '2000-01-01 00:00:00';

    /**
     * @var string|null
     */
    private $description = null;

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var MediaRelaySetDto | null
     */
    private $mediaRelaySet = null;

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
            'setid' => 'setid',
            'url' => 'url',
            'weight' => 'weight',
            'disabled' => 'disabled',
            'stamp' => 'stamp',
            'description' => 'description',
            'id' => 'id',
            'mediaRelaySetId' => 'mediaRelaySet'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'setid' => $this->getSetid(),
            'url' => $this->getUrl(),
            'weight' => $this->getWeight(),
            'disabled' => $this->getDisabled(),
            'stamp' => $this->getStamp(),
            'description' => $this->getDescription(),
            'id' => $this->getId(),
            'mediaRelaySet' => $this->getMediaRelaySet()
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

    public function setSetid(int $setid): static
    {
        $this->setid = $setid;

        return $this;
    }

    public function getSetid(): ?int
    {
        return $this->setid;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setWeight(int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setDisabled(bool $disabled): static
    {
        $this->disabled = $disabled;

        return $this;
    }

    public function getDisabled(): ?bool
    {
        return $this->disabled;
    }

    public function setStamp(\DateTimeInterface|string $stamp): static
    {
        $this->stamp = $stamp;

        return $this;
    }

    public function getStamp(): \DateTimeInterface|string|null
    {
        return $this->stamp;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
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

    public function setMediaRelaySet(?MediaRelaySetDto $mediaRelaySet): static
    {
        $this->mediaRelaySet = $mediaRelaySet;

        return $this;
    }

    public function getMediaRelaySet(): ?MediaRelaySetDto
    {
        return $this->mediaRelaySet;
    }

    public function setMediaRelaySetId($id): static
    {
        $value = !is_null($id)
            ? new MediaRelaySetDto($id)
            : null;

        return $this->setMediaRelaySet($value);
    }

    public function getMediaRelaySetId(): ?int
    {
        if ($dto = $this->getMediaRelaySet()) {
            return $dto->getId();
        }

        return null;
    }
}
