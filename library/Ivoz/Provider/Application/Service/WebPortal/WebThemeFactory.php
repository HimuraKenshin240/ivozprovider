<?php

namespace Ivoz\Provider\Application\Service\WebPortal;

use Ivoz\Provider\Domain\Model\WebPortal\WebPortalInterface;
use Ivoz\Provider\Domain\Model\WebPortal\WebPortalRepository;
use Ivoz\Provider\Domain\Model\WebPortal\WebTheme;

class WebThemeFactory
{
    public function __construct(
        private WebPortalRepository $webPortalRepository,
    ) {
    }

    public function execute(
        string $hostname,
        string $urlType
    ): WebTheme {
        $webPortal = $this
            ->webPortalRepository
            ->findByServerNameAndType(
                $hostname,
                $urlType
            );

        if (!$webPortal) {
            throw new \DomainException(
                'WebPortal not found',
                404
            );
        }

        $api = match ($webPortal->getUrlType()) {
            WebPortalInterface::URLTYPE_GOD => 'platform',
            WebPortalInterface::URLTYPE_BRAND => 'brand',
            WebPortalInterface::URLTYPE_ADMIN => 'client',
            WebPortalInterface::URLTYPE_USER => 'user',
            default => throw new \RuntimeException('Unknown web portal type'),
        };

        $publicLogoUrl =
            'https://'
            . $hostname
            . '/api/'
            . $api
            . '/my/logo/'
            . (string) $webPortal->getId()
            . '/'
            . urlencode(
                $webPortal->getLogo()->getBaseName() ?? ''
            );

        $theme = $urlType === WebPortalInterface::URLTYPE_USER
            ? $webPortal->getUserTheme()
            : $webPortal->getKlearTheme();

        return new WebTheme(
            $webPortal->getName() ?? '',
            $theme ?? '',
            $publicLogoUrl
        );
    }
}
