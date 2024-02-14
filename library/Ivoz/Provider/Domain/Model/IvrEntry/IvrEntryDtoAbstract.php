<?php

namespace Ivoz\Provider\Domain\Model\IvrEntry;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\Ivr\IvrDto;
use Ivoz\Provider\Domain\Model\Locution\LocutionDto;
use Ivoz\Provider\Domain\Model\Extension\ExtensionDto;
use Ivoz\Provider\Domain\Model\Voicemail\VoicemailDto;
use Ivoz\Provider\Domain\Model\ConditionalRoute\ConditionalRouteDto;
use Ivoz\Provider\Domain\Model\Country\CountryDto;

/**
* IvrEntryDtoAbstract
* @codeCoverageIgnore
*/
abstract class IvrEntryDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var string|null
     */
    private $entry = null;

    /**
     * @var string|null
     */
    private $displayName = null;

    /**
     * @var string|null
     */
    private $routeType = null;

    /**
     * @var string|null
     */
    private $numberValue = null;

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var IvrDto | null
     */
    private $ivr = null;

    /**
     * @var LocutionDto | null
     */
    private $welcomeLocution = null;

    /**
     * @var ExtensionDto | null
     */
    private $extension = null;

    /**
     * @var VoicemailDto | null
     */
    private $voicemail = null;

    /**
     * @var ConditionalRouteDto | null
     */
    private $conditionalRoute = null;

    /**
     * @var CountryDto | null
     */
    private $numberCountry = null;

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
            'entry' => 'entry',
            'displayName' => 'displayName',
            'routeType' => 'routeType',
            'numberValue' => 'numberValue',
            'id' => 'id',
            'ivrId' => 'ivr',
            'welcomeLocutionId' => 'welcomeLocution',
            'extensionId' => 'extension',
            'voicemailId' => 'voicemail',
            'conditionalRouteId' => 'conditionalRoute',
            'numberCountryId' => 'numberCountry'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'entry' => $this->getEntry(),
            'displayName' => $this->getDisplayName(),
            'routeType' => $this->getRouteType(),
            'numberValue' => $this->getNumberValue(),
            'id' => $this->getId(),
            'ivr' => $this->getIvr(),
            'welcomeLocution' => $this->getWelcomeLocution(),
            'extension' => $this->getExtension(),
            'voicemail' => $this->getVoicemail(),
            'conditionalRoute' => $this->getConditionalRoute(),
            'numberCountry' => $this->getNumberCountry()
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

    public function setEntry(string $entry): static
    {
        $this->entry = $entry;

        return $this;
    }

    public function getEntry(): ?string
    {
        return $this->entry;
    }

    public function setDisplayName(?string $displayName): static
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setRouteType(string $routeType): static
    {
        $this->routeType = $routeType;

        return $this;
    }

    public function getRouteType(): ?string
    {
        return $this->routeType;
    }

    public function setNumberValue(?string $numberValue): static
    {
        $this->numberValue = $numberValue;

        return $this;
    }

    public function getNumberValue(): ?string
    {
        return $this->numberValue;
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

    public function setIvr(?IvrDto $ivr): static
    {
        $this->ivr = $ivr;

        return $this;
    }

    public function getIvr(): ?IvrDto
    {
        return $this->ivr;
    }

    public function setIvrId(?int $id): static
    {
        $value = !is_null($id)
            ? new IvrDto($id)
            : null;

        return $this->setIvr($value);
    }

    public function getIvrId(): ?int
    {
        if ($dto = $this->getIvr()) {
            return $dto->getId();
        }

        return null;
    }

    public function setWelcomeLocution(?LocutionDto $welcomeLocution): static
    {
        $this->welcomeLocution = $welcomeLocution;

        return $this;
    }

    public function getWelcomeLocution(): ?LocutionDto
    {
        return $this->welcomeLocution;
    }

    public function setWelcomeLocutionId(?int $id): static
    {
        $value = !is_null($id)
            ? new LocutionDto($id)
            : null;

        return $this->setWelcomeLocution($value);
    }

    public function getWelcomeLocutionId(): ?int
    {
        if ($dto = $this->getWelcomeLocution()) {
            return $dto->getId();
        }

        return null;
    }

    public function setExtension(?ExtensionDto $extension): static
    {
        $this->extension = $extension;

        return $this;
    }

    public function getExtension(): ?ExtensionDto
    {
        return $this->extension;
    }

    public function setExtensionId(?int $id): static
    {
        $value = !is_null($id)
            ? new ExtensionDto($id)
            : null;

        return $this->setExtension($value);
    }

    public function getExtensionId(): ?int
    {
        if ($dto = $this->getExtension()) {
            return $dto->getId();
        }

        return null;
    }

    public function setVoicemail(?VoicemailDto $voicemail): static
    {
        $this->voicemail = $voicemail;

        return $this;
    }

    public function getVoicemail(): ?VoicemailDto
    {
        return $this->voicemail;
    }

    public function setVoicemailId(?int $id): static
    {
        $value = !is_null($id)
            ? new VoicemailDto($id)
            : null;

        return $this->setVoicemail($value);
    }

    public function getVoicemailId(): ?int
    {
        if ($dto = $this->getVoicemail()) {
            return $dto->getId();
        }

        return null;
    }

    public function setConditionalRoute(?ConditionalRouteDto $conditionalRoute): static
    {
        $this->conditionalRoute = $conditionalRoute;

        return $this;
    }

    public function getConditionalRoute(): ?ConditionalRouteDto
    {
        return $this->conditionalRoute;
    }

    public function setConditionalRouteId(?int $id): static
    {
        $value = !is_null($id)
            ? new ConditionalRouteDto($id)
            : null;

        return $this->setConditionalRoute($value);
    }

    public function getConditionalRouteId(): ?int
    {
        if ($dto = $this->getConditionalRoute()) {
            return $dto->getId();
        }

        return null;
    }

    public function setNumberCountry(?CountryDto $numberCountry): static
    {
        $this->numberCountry = $numberCountry;

        return $this;
    }

    public function getNumberCountry(): ?CountryDto
    {
        return $this->numberCountry;
    }

    public function setNumberCountryId(?int $id): static
    {
        $value = !is_null($id)
            ? new CountryDto($id)
            : null;

        return $this->setNumberCountry($value);
    }

    public function getNumberCountryId(): ?int
    {
        if ($dto = $this->getNumberCountry()) {
            return $dto->getId();
        }

        return null;
    }
}
