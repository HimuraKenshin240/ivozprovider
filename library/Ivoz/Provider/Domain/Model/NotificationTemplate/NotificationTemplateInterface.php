<?php

namespace Ivoz\Provider\Domain\Model\NotificationTemplate;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;
use Ivoz\Provider\Domain\Model\Language\LanguageInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Brand\BrandInterface;
use Ivoz\Provider\Domain\Model\NotificationTemplateContent\NotificationTemplateContentInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;

/**
* NotificationTemplateInterface
*/
interface NotificationTemplateInterface extends LoggableEntityInterface
{
    public const TYPE_VOICEMAIL = 'voicemail';

    public const TYPE_FAX = 'fax';

    public const TYPE_LIMIT = 'limit';

    public const TYPE_LOWBALANCE = 'lowbalance';

    public const TYPE_INVOICE = 'invoice';

    public const TYPE_CALLCSV = 'callCsv';

    public const TYPE_MAXDAILYUSAGE = 'maxDailyUsage';

    public const TYPE_ACCESSCREDENTIALS = 'accessCredentials';

    /**
     * @codeCoverageIgnore
     * @return array<string, mixed>
     */
    public function getChangeSet(): array;

    /**
     * Get id
     * @codeCoverageIgnore
     * @return integer
     */
    public function getId(): ?int;

    /**
     * Get contents by language
     *
     * @param \Ivoz\Provider\Domain\Model\Language\LanguageInterface $language
     * @return \Ivoz\Provider\Domain\Model\NotificationTemplateContent\NotificationTemplateContentInterface | null
     */
    public function getContentsByLanguage(LanguageInterface $language);

    /**
     * @param int | null $id
     */
    public static function createDto($id = null): NotificationTemplateDto;

    /**
     * @internal use EntityTools instead
     * @param null|NotificationTemplateInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?NotificationTemplateDto;

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param NotificationTemplateDto $dto
     */
    public static function fromDto(DataTransferObjectInterface $dto, ForeignKeyTransformerInterface $fkTransformer): static;

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): NotificationTemplateDto;

    public function getName(): string;

    public function getType(): string;

    public function getBrand(): ?BrandInterface;

    public function addContent(NotificationTemplateContentInterface $content): NotificationTemplateInterface;

    public function removeContent(NotificationTemplateContentInterface $content): NotificationTemplateInterface;

    /**
     * @param Collection<array-key, NotificationTemplateContentInterface> $contents
     */
    public function replaceContents(Collection $contents): NotificationTemplateInterface;

    /**
     * @return array<array-key, NotificationTemplateContentInterface>
     */
    public function getContents(?Criteria $criteria = null): array;
}
