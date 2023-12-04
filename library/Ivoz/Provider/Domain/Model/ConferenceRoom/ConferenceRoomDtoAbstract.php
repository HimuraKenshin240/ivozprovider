<?php

namespace Ivoz\Provider\Domain\Model\ConferenceRoom;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\Company\CompanyDto;

/**
* ConferenceRoomDtoAbstract
* @codeCoverageIgnore
*/
abstract class ConferenceRoomDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var string|null
     */
    private $name = null;

    /**
     * @var bool|null
     */
    private $pinProtected = false;

    /**
     * @var string|null
     */
    private $pinCode = null;

    /**
     * @var int|null
     */
    private $maxMembers = 0;

    /**
     * @var string|null
     */
    private $announceUserCount = 'first';

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var CompanyDto | null
     */
    private $company = null;

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
            'name' => 'name',
            'pinProtected' => 'pinProtected',
            'pinCode' => 'pinCode',
            'maxMembers' => 'maxMembers',
            'announceUserCount' => 'announceUserCount',
            'id' => 'id',
            'companyId' => 'company'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'name' => $this->getName(),
            'pinProtected' => $this->getPinProtected(),
            'pinCode' => $this->getPinCode(),
            'maxMembers' => $this->getMaxMembers(),
            'announceUserCount' => $this->getAnnounceUserCount(),
            'id' => $this->getId(),
            'company' => $this->getCompany()
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

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setPinProtected(bool $pinProtected): static
    {
        $this->pinProtected = $pinProtected;

        return $this;
    }

    public function getPinProtected(): ?bool
    {
        return $this->pinProtected;
    }

    public function setPinCode(?string $pinCode): static
    {
        $this->pinCode = $pinCode;

        return $this;
    }

    public function getPinCode(): ?string
    {
        return $this->pinCode;
    }

    public function setMaxMembers(int $maxMembers): static
    {
        $this->maxMembers = $maxMembers;

        return $this;
    }

    public function getMaxMembers(): ?int
    {
        return $this->maxMembers;
    }

    public function setAnnounceUserCount(string $announceUserCount): static
    {
        $this->announceUserCount = $announceUserCount;

        return $this;
    }

    public function getAnnounceUserCount(): ?string
    {
        return $this->announceUserCount;
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

    public function setCompany(?CompanyDto $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getCompany(): ?CompanyDto
    {
        return $this->company;
    }

    public function setCompanyId(?int $id): static
    {
        $value = !is_null($id)
            ? new CompanyDto($id)
            : null;

        return $this->setCompany($value);
    }

    public function getCompanyId(): ?int
    {
        if ($dto = $this->getCompany()) {
            return $dto->getId();
        }

        return null;
    }
}
