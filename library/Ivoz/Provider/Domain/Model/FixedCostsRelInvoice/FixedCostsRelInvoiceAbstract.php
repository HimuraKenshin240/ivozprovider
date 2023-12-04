<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\FixedCostsRelInvoice;

use Assert\Assertion;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\FixedCost\FixedCostInterface;
use Ivoz\Provider\Domain\Model\Invoice\InvoiceInterface;
use Ivoz\Provider\Domain\Model\FixedCost\FixedCost;
use Ivoz\Provider\Domain\Model\Invoice\Invoice;

/**
* FixedCostsRelInvoiceAbstract
* @codeCoverageIgnore
*/
abstract class FixedCostsRelInvoiceAbstract
{
    use ChangelogTrait;

    /**
     * @var ?int
     */
    protected $quantity = null;

    /**
     * @var FixedCostInterface
     */
    protected $fixedCost;

    /**
     * @var ?InvoiceInterface
     * inversedBy relFixedCosts
     */
    protected $invoice = null;

    /**
     * Constructor
     */
    protected function __construct()
    {
    }

    abstract public function getId(): null|string|int;

    public function __toString(): string
    {
        return sprintf(
            "%s#%s",
            "FixedCostsRelInvoice",
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
    public static function createDto($id = null): FixedCostsRelInvoiceDto
    {
        return new FixedCostsRelInvoiceDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param null|FixedCostsRelInvoiceInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?FixedCostsRelInvoiceDto
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, FixedCostsRelInvoiceInterface::class);

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
     * @param FixedCostsRelInvoiceDto $dto
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, FixedCostsRelInvoiceDto::class);
        $fixedCost = $dto->getFixedCost();
        Assertion::notNull($fixedCost, 'getFixedCost value is null, but non null value was expected.');

        $self = new static();

        $self
            ->setQuantity($dto->getQuantity())
            ->setFixedCost($fkTransformer->transform($fixedCost))
            ->setInvoice($fkTransformer->transform($dto->getInvoice()));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param FixedCostsRelInvoiceDto $dto
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, FixedCostsRelInvoiceDto::class);

        $fixedCost = $dto->getFixedCost();
        Assertion::notNull($fixedCost, 'getFixedCost value is null, but non null value was expected.');

        $this
            ->setQuantity($dto->getQuantity())
            ->setFixedCost($fkTransformer->transform($fixedCost))
            ->setInvoice($fkTransformer->transform($dto->getInvoice()));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): FixedCostsRelInvoiceDto
    {
        return self::createDto()
            ->setQuantity(self::getQuantity())
            ->setFixedCost(FixedCost::entityToDto(self::getFixedCost(), $depth))
            ->setInvoice(Invoice::entityToDto(self::getInvoice(), $depth));
    }

    /**
     * @return array<string, mixed>
     */
    protected function __toArray(): array
    {
        return [
            'quantity' => self::getQuantity(),
            'fixedCostId' => self::getFixedCost()->getId(),
            'invoiceId' => self::getInvoice()?->getId()
        ];
    }

    protected function setQuantity(?int $quantity = null): static
    {
        if (!is_null($quantity)) {
            Assertion::greaterOrEqualThan($quantity, 0, 'quantity provided "%s" is not greater or equal than "%s".');
        }

        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    protected function setFixedCost(FixedCostInterface $fixedCost): static
    {
        $this->fixedCost = $fixedCost;

        return $this;
    }

    public function getFixedCost(): FixedCostInterface
    {
        return $this->fixedCost;
    }

    public function setInvoice(?InvoiceInterface $invoice = null): static
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getInvoice(): ?InvoiceInterface
    {
        return $this->invoice;
    }
}
