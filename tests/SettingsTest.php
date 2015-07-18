<?php

namespace Potherca\Flysystem\Github;

/**
 * Tests for the Settings class
 *
 * @coversDefaultClass \Potherca\Flysystem\Github\Settings
 * @covers ::<!public>
 * @covers ::__construct
 */
class SettingsTest extends \PHPUnit_Framework_TestCase
{
    const MOCK_REPOSITORY_NAME = 'foo/bar';
    const MOCK_CREDENTIALS = ['mock_type', 'mock_user', 'mock_password'];
    const MOCK_BRANCH = 'mock_branch';
    const MOCK_REFERENCE = 'mock_reference';

    /** @var Settings */
    private $settings;

    /**
     *
     */
    final protected function setUp()
    {
        $this->settings = new Settings(
            self::MOCK_REPOSITORY_NAME,
            self::MOCK_CREDENTIALS,
            self::MOCK_BRANCH,
            self::MOCK_REFERENCE
        );
    }

    /**
     * @covers ::__construct
     */
    final public function testSettingsShouldComplainWhenInstantiatedWithoutProject()
    {
        $this->setExpectedException(
            \PHPUnit_Framework_Error_Warning::class,
            sprintf('Missing argument %d for %s::__construct()', 1, Settings::class)
        );

        /** @noinspection PhpParamsInspection */
        new Settings();
    }

    /**
     * @covers ::getRepository
     */
    final public function testSettingsShouldContainRepositoryItWasGivenGivenWhenInstantiated()
    {
        $settings = $this->settings;

        $expected = self::MOCK_REPOSITORY_NAME;

        $actual = $settings->getRepository();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ::__construct
     *
     * @dataProvider provideInvalidRepositoryNames
     *
     * @param string $name
     */
    final public function testSettingsShouldComplainWhenGivenInvalidRepositoryNames($name)
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            sprintf(Settings::ERROR_INVALID_REPOSITORY_NAME, var_export($name, true))
        );
        new Settings($name);
    }

    /**
     * @covers ::getRepository
     */
    final public function testSettingsShouldOnlyNeedRepositoryNameWhenInstantiated()
    {
        $settings = new Settings(self::MOCK_REPOSITORY_NAME);
        $this->assertInstanceOf(Settings::class, $settings);
    }

    /**
     * @covers ::getCredentials
     */
    final public function testSettingsShouldContainEmptyCredentialsWhenInstantiatedWithoutCredentials()
    {
        $settings = new Settings(self::MOCK_REPOSITORY_NAME);

        $expected = [];

        $actual = $settings->getCredentials();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ::getCredentials
     */
    final public function testSettingsShouldContainCredentialsItWasGivenGivenWhenInstantiated()
    {
        $settings = $this->settings;

        $expected = self::MOCK_CREDENTIALS;

        $actual = $settings->getCredentials();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ::getBranch
     */
    final public function testSettingsShouldContainMasterAsBranchWhenInstantiatedWithoutBranch()
    {
        $settings = new Settings(self::MOCK_REPOSITORY_NAME);

        $expected = 'master';

        $actual = $settings->getBranch();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ::getBranch
     */
    final public function testSettingsShouldContainBranchItWasGivenGivenWhenInstantiated()
    {
        $settings = $this->settings;

        $expected = self::MOCK_BRANCH;

        $actual = $settings->getBranch();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ::getReference
     */
    final public function testSettingsShouldContainHeadAsReferenceWhenInstantiatedWithoutReference()
    {
        $settings = new Settings(self::MOCK_REPOSITORY_NAME);

        $expected = 'HEAD';

        $actual = $settings->getReference();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ::getReference
     */
    final public function testSettingsShouldContaingetReferenceItWasGivenGivenWhenInstantiated()
    {
        $settings = $this->settings;

        $expected = self::MOCK_REFERENCE;

        $actual = $settings->getReference();

        $this->assertEquals($expected, $actual);
    }

    final public function provideInvalidRepositoryNames()
    {
        return [
            [''],
            [null],
            [true],
            [array()],
            ['foo'],
            ['/foo'],
            ['foo/bar/'],
            ['/foo/bar/'],
            ['foo/bar/baz'],
            ['/foo/bar/baz/'],
            ['foo/bar/baz/'],
            ['/foo/bar/baz'],
        ];
    }
}

/*EOF*/