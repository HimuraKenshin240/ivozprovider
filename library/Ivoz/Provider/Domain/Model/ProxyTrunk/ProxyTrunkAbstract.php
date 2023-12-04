<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\ProxyTrunk;

use Assert\Assertion;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;

/**
* ProxyTrunkAbstract
* @codeCoverageIgnore
*/
abstract class ProxyTrunkAbstract
{
    use ChangelogTrait;

    /**
     * @var ?string
     */
    protected $name = null;

    /**
     * @var string
     */
    protected $ip;

    /**
     * Constructor
     */
    protected function __construct(
        string $ip
    ) {
        $this->setIp($ip);
    }

    abstract public function getId(): null|string|int;

    public function __toString(): string
    {
        return sprintf(
            "%s#%s",
            "ProxyTrunk",
            (string) $this->getId()
        );
    }

    /**
     * @throws \Exception
     */
    protected function sanitizeValues(): void
    {
    }

    /**
     * @param int | null $id
     */
    public static function createDto($id = null): ProxyTrunkDto
    {
        return new ProxyTrunkDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param null|ProxyTrunkInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?ProxyTrunkDto
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, ProxyTrunkInterface::class);

        if ($depth < 1) {
            return static::createDto($entity->getId());
        }

        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy && !$entity->__isInitialized()) {
            return static::createDto($entity->getId());
        }

        $dto = $entity->toDto($depth - 1);

        return $dto;
    }

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param ProxyTrunkDto $dto
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, ProxyTrunkDto::class);
        $ip = $dto->getIp();
        Assertion::notNull($ip, 'getIp value is null, but non null value was expected.');

        $self = new static(
            $ip
        );

        $self
            ->setName($dto->getName());

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param ProxyTrunkDto $dto
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, ProxyTrunkDto::class);

        $ip = $dto->getIp();
        Assertion::notNull($ip, 'getIp value is null, but non null value was expected.');

        $this
            ->setName($dto->getName())
            ->setIp($ip);

        return $this;
    }

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): ProxyTrunkDto
    {
        return self::createDto()
            ->setName(self::getName())
            ->setIp(self::getIp());
    }

    /**
     * @return array<string, mixed>
     */
    protected function __toArray(): array
    {
        return [
            'name' => self::getName(),
            'ip' => self::getIp()
        ];
    }

    protected function setName(?string $name = null): static
    {
        if (!is_null($name)) {
            Assertion::maxLength($name, 100, 'name value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    protected function setIp(string $ip): static
    {
        Assertion::maxLength($ip, 50, 'ip value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->ip = $ip;

        return $this;
    }

    public function getIp(): string
    {
        return $this->ip;
    }
}
