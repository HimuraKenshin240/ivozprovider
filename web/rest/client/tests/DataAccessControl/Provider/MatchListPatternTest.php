<?php

namespace Tests\DataAccessControl\Provider;

use Ivoz\Api\Core\Security\DataAccessControlParser;
use Ivoz\Provider\Domain\Model\MatchListPattern\MatchListPattern;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MatchListPatternTest extends KernelTestCase
{
    use \Ivoz\Tests\AccessControlTestHelperTrait;

    protected function getResourceClass()
    {
        return MatchListPattern::class;
    }

    protected function getAdminCriteria(): array
    {
        return ['username' => 'test_company_admin'];
    }

    /**
     * @test
     */
    function it_has_read_access_control()
    {
        $accessControl = $this
            ->dataAccessControlParser
            ->get(
                DataAccessControlParser::READ_ACCESS_CONTROL_ATTRIBUTE
            );

        $this->assertEquals(
            $accessControl,
            [
                [
                    'matchList',
                    'in',
                    'MatchListRepository({"or":[["brand","eq","user.getCompany().getBrand().getId()"],["company","eq","user.getCompany().getId()"]]})'
                ]
            ]
        );
    }

    /**
     * @test
     */
    function it_has_write_access_control()
    {
        $accessControl = $this
            ->dataAccessControlParser
            ->get(
                DataAccessControlParser::WRITE_ACCESS_CONTROL_ATTRIBUTE
            );

        $this->assertEquals(
            $accessControl,
            [
                [
                    'matchList',
                    'in',
                    'matchListRepository.getIdsByCompanyId(user.getCompany().getId())'
                ]
            ]
        );
    }
}
