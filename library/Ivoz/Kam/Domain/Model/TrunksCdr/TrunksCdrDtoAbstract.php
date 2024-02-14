<?php

namespace Ivoz\Kam\Domain\Model\TrunksCdr;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\Brand\BrandDto;
use Ivoz\Provider\Domain\Model\Company\CompanyDto;
use Ivoz\Provider\Domain\Model\Carrier\CarrierDto;
use Ivoz\Provider\Domain\Model\RetailAccount\RetailAccountDto;
use Ivoz\Provider\Domain\Model\ResidentialDevice\ResidentialDeviceDto;
use Ivoz\Provider\Domain\Model\User\UserDto;
use Ivoz\Provider\Domain\Model\Friend\FriendDto;
use Ivoz\Provider\Domain\Model\Fax\FaxDto;
use Ivoz\Provider\Domain\Model\Ddi\DdiDto;
use Ivoz\Provider\Domain\Model\DdiProvider\DdiProviderDto;

/**
* TrunksCdrDtoAbstract
* @codeCoverageIgnore
*/
abstract class TrunksCdrDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var \DateTimeInterface|string|null
     */
    private $startTime = '2000-01-01 00:00:00';

    /**
     * @var \DateTimeInterface|string|null
     */
    private $endTime = '2000-01-01 00:00:00';

    /**
     * @var float|null
     */
    private $duration = 0;

    /**
     * @var string|null
     */
    private $caller = null;

    /**
     * @var string|null
     */
    private $callee = null;

    /**
     * @var string|null
     */
    private $callid = null;

    /**
     * @var string|null
     */
    private $callidHash = null;

    /**
     * @var string|null
     */
    private $xcallid = null;

    /**
     * @var string|null
     */
    private $diversion = null;

    /**
     * @var bool|null
     */
    private $bounced = null;

    /**
     * @var bool|null
     */
    private $parsed = false;

    /**
     * @var \DateTimeInterface|string|null
     */
    private $parserScheduledAt = 'CURRENT_TIMESTAMP';

    /**
     * @var string|null
     */
    private $direction = null;

    /**
     * @var string|null
     */
    private $cgrid = null;

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var BrandDto | null
     */
    private $brand = null;

    /**
     * @var CompanyDto | null
     */
    private $company = null;

    /**
     * @var CarrierDto | null
     */
    private $carrier = null;

    /**
     * @var RetailAccountDto | null
     */
    private $retailAccount = null;

    /**
     * @var ResidentialDeviceDto | null
     */
    private $residentialDevice = null;

    /**
     * @var UserDto | null
     */
    private $user = null;

    /**
     * @var FriendDto | null
     */
    private $friend = null;

    /**
     * @var FaxDto | null
     */
    private $fax = null;

    /**
     * @var DdiDto | null
     */
    private $ddi = null;

    /**
     * @var DdiProviderDto | null
     */
    private $ddiProvider = null;

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
            'startTime' => 'startTime',
            'endTime' => 'endTime',
            'duration' => 'duration',
            'caller' => 'caller',
            'callee' => 'callee',
            'callid' => 'callid',
            'callidHash' => 'callidHash',
            'xcallid' => 'xcallid',
            'diversion' => 'diversion',
            'bounced' => 'bounced',
            'parsed' => 'parsed',
            'parserScheduledAt' => 'parserScheduledAt',
            'direction' => 'direction',
            'cgrid' => 'cgrid',
            'id' => 'id',
            'brandId' => 'brand',
            'companyId' => 'company',
            'carrierId' => 'carrier',
            'retailAccountId' => 'retailAccount',
            'residentialDeviceId' => 'residentialDevice',
            'userId' => 'user',
            'friendId' => 'friend',
            'faxId' => 'fax',
            'ddiId' => 'ddi',
            'ddiProviderId' => 'ddiProvider'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'startTime' => $this->getStartTime(),
            'endTime' => $this->getEndTime(),
            'duration' => $this->getDuration(),
            'caller' => $this->getCaller(),
            'callee' => $this->getCallee(),
            'callid' => $this->getCallid(),
            'callidHash' => $this->getCallidHash(),
            'xcallid' => $this->getXcallid(),
            'diversion' => $this->getDiversion(),
            'bounced' => $this->getBounced(),
            'parsed' => $this->getParsed(),
            'parserScheduledAt' => $this->getParserScheduledAt(),
            'direction' => $this->getDirection(),
            'cgrid' => $this->getCgrid(),
            'id' => $this->getId(),
            'brand' => $this->getBrand(),
            'company' => $this->getCompany(),
            'carrier' => $this->getCarrier(),
            'retailAccount' => $this->getRetailAccount(),
            'residentialDevice' => $this->getResidentialDevice(),
            'user' => $this->getUser(),
            'friend' => $this->getFriend(),
            'fax' => $this->getFax(),
            'ddi' => $this->getDdi(),
            'ddiProvider' => $this->getDdiProvider()
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

    public function setStartTime(\DateTimeInterface|string $startTime): static
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getStartTime(): \DateTimeInterface|string|null
    {
        return $this->startTime;
    }

    public function setEndTime(\DateTimeInterface|string $endTime): static
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getEndTime(): \DateTimeInterface|string|null
    {
        return $this->endTime;
    }

    public function setDuration(float $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDuration(): ?float
    {
        return $this->duration;
    }

    public function setCaller(?string $caller): static
    {
        $this->caller = $caller;

        return $this;
    }

    public function getCaller(): ?string
    {
        return $this->caller;
    }

    public function setCallee(?string $callee): static
    {
        $this->callee = $callee;

        return $this;
    }

    public function getCallee(): ?string
    {
        return $this->callee;
    }

    public function setCallid(?string $callid): static
    {
        $this->callid = $callid;

        return $this;
    }

    public function getCallid(): ?string
    {
        return $this->callid;
    }

    public function setCallidHash(?string $callidHash): static
    {
        $this->callidHash = $callidHash;

        return $this;
    }

    public function getCallidHash(): ?string
    {
        return $this->callidHash;
    }

    public function setXcallid(?string $xcallid): static
    {
        $this->xcallid = $xcallid;

        return $this;
    }

    public function getXcallid(): ?string
    {
        return $this->xcallid;
    }

    public function setDiversion(?string $diversion): static
    {
        $this->diversion = $diversion;

        return $this;
    }

    public function getDiversion(): ?string
    {
        return $this->diversion;
    }

    public function setBounced(?bool $bounced): static
    {
        $this->bounced = $bounced;

        return $this;
    }

    public function getBounced(): ?bool
    {
        return $this->bounced;
    }

    public function setParsed(?bool $parsed): static
    {
        $this->parsed = $parsed;

        return $this;
    }

    public function getParsed(): ?bool
    {
        return $this->parsed;
    }

    public function setParserScheduledAt(\DateTimeInterface|string $parserScheduledAt): static
    {
        $this->parserScheduledAt = $parserScheduledAt;

        return $this;
    }

    public function getParserScheduledAt(): \DateTimeInterface|string|null
    {
        return $this->parserScheduledAt;
    }

    public function setDirection(?string $direction): static
    {
        $this->direction = $direction;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setCgrid(?string $cgrid): static
    {
        $this->cgrid = $cgrid;

        return $this;
    }

    public function getCgrid(): ?string
    {
        return $this->cgrid;
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

    public function setBrand(?BrandDto $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getBrand(): ?BrandDto
    {
        return $this->brand;
    }

    public function setBrandId(?int $id): static
    {
        $value = !is_null($id)
            ? new BrandDto($id)
            : null;

        return $this->setBrand($value);
    }

    public function getBrandId(): ?int
    {
        if ($dto = $this->getBrand()) {
            return $dto->getId();
        }

        return null;
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

    public function setCarrier(?CarrierDto $carrier): static
    {
        $this->carrier = $carrier;

        return $this;
    }

    public function getCarrier(): ?CarrierDto
    {
        return $this->carrier;
    }

    public function setCarrierId(?int $id): static
    {
        $value = !is_null($id)
            ? new CarrierDto($id)
            : null;

        return $this->setCarrier($value);
    }

    public function getCarrierId(): ?int
    {
        if ($dto = $this->getCarrier()) {
            return $dto->getId();
        }

        return null;
    }

    public function setRetailAccount(?RetailAccountDto $retailAccount): static
    {
        $this->retailAccount = $retailAccount;

        return $this;
    }

    public function getRetailAccount(): ?RetailAccountDto
    {
        return $this->retailAccount;
    }

    public function setRetailAccountId(?int $id): static
    {
        $value = !is_null($id)
            ? new RetailAccountDto($id)
            : null;

        return $this->setRetailAccount($value);
    }

    public function getRetailAccountId(): ?int
    {
        if ($dto = $this->getRetailAccount()) {
            return $dto->getId();
        }

        return null;
    }

    public function setResidentialDevice(?ResidentialDeviceDto $residentialDevice): static
    {
        $this->residentialDevice = $residentialDevice;

        return $this;
    }

    public function getResidentialDevice(): ?ResidentialDeviceDto
    {
        return $this->residentialDevice;
    }

    public function setResidentialDeviceId(?int $id): static
    {
        $value = !is_null($id)
            ? new ResidentialDeviceDto($id)
            : null;

        return $this->setResidentialDevice($value);
    }

    public function getResidentialDeviceId(): ?int
    {
        if ($dto = $this->getResidentialDevice()) {
            return $dto->getId();
        }

        return null;
    }

    public function setUser(?UserDto $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): ?UserDto
    {
        return $this->user;
    }

    public function setUserId(?int $id): static
    {
        $value = !is_null($id)
            ? new UserDto($id)
            : null;

        return $this->setUser($value);
    }

    public function getUserId(): ?int
    {
        if ($dto = $this->getUser()) {
            return $dto->getId();
        }

        return null;
    }

    public function setFriend(?FriendDto $friend): static
    {
        $this->friend = $friend;

        return $this;
    }

    public function getFriend(): ?FriendDto
    {
        return $this->friend;
    }

    public function setFriendId(?int $id): static
    {
        $value = !is_null($id)
            ? new FriendDto($id)
            : null;

        return $this->setFriend($value);
    }

    public function getFriendId(): ?int
    {
        if ($dto = $this->getFriend()) {
            return $dto->getId();
        }

        return null;
    }

    public function setFax(?FaxDto $fax): static
    {
        $this->fax = $fax;

        return $this;
    }

    public function getFax(): ?FaxDto
    {
        return $this->fax;
    }

    public function setFaxId(?int $id): static
    {
        $value = !is_null($id)
            ? new FaxDto($id)
            : null;

        return $this->setFax($value);
    }

    public function getFaxId(): ?int
    {
        if ($dto = $this->getFax()) {
            return $dto->getId();
        }

        return null;
    }

    public function setDdi(?DdiDto $ddi): static
    {
        $this->ddi = $ddi;

        return $this;
    }

    public function getDdi(): ?DdiDto
    {
        return $this->ddi;
    }

    public function setDdiId(?int $id): static
    {
        $value = !is_null($id)
            ? new DdiDto($id)
            : null;

        return $this->setDdi($value);
    }

    public function getDdiId(): ?int
    {
        if ($dto = $this->getDdi()) {
            return $dto->getId();
        }

        return null;
    }

    public function setDdiProvider(?DdiProviderDto $ddiProvider): static
    {
        $this->ddiProvider = $ddiProvider;

        return $this;
    }

    public function getDdiProvider(): ?DdiProviderDto
    {
        return $this->ddiProvider;
    }

    public function setDdiProviderId(?int $id): static
    {
        $value = !is_null($id)
            ? new DdiProviderDto($id)
            : null;

        return $this->setDdiProvider($value);
    }

    public function getDdiProviderId(): ?int
    {
        if ($dto = $this->getDdiProvider()) {
            return $dto->getId();
        }

        return null;
    }
}
