<?php

namespace Slub\SlubEvents\Tests\Unit\Domain\Model;

use TYPO3\CMS\Core\Tests\UnitTestCase;
use Slub\SlubEvents\Domain\Model\Contact;


/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Alexander Bigga <typo3@slub-dresden.de>, SLUB Dresden
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Test case for class Tx_SlubEvents_Domain_Model_Contact.
 *
 * @version    $Id$
 * @copyright  Copyright belongs to the respective authors
 * @license    http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package    TYPO3
 * @subpackage SLUB: Event Registration
 *
 * @author     Alexander Bigga <typo3@slub-dresden.de>
 */
class ContactTest extends UnitTestCase
{
    /**
     * @var Contact
     */
    protected $subject;

    public function setUp(): void
    {
        $this->subject = new Contact();
    }

    public function tearDown(): void
    {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function getNameInitiallyReturnsNull(): void
    {
        self::assertSame(
            null,
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName(): void
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function getEmailInitiallyReturnsNull(): void
    {
        self::assertSame(
            null,
            $this->subject->getEmail()
        );
    }

    /**
     * @test
     */
    public function setEmailForStringSetsEmail(): void
    {
        $this->subject->setEmail('slub@example.com');

        self::assertSame(
            'slub@example.com',
            $this->subject->getEmail()
        );
    }

    /**
     * @test
     */
    public function getTelephoneInitiallyReturnsNull(): void
    {
        self::assertSame(
            null,
            $this->subject->getTelephone()
        );
    }

    /**
     * @test
     */
    public function setTelephoneForStringSetsTelephone(): void
    {
        $this->subject->setTelephone('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getTelephone()
        );
    }

    /**
     * @test
     */
    public function getDescriptionInitiallyReturnsNull(): void
    {
        self::assertSame(
            null,
            $this->subject->getTelephone()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription(): void
    {
        $this->subject->setDescription('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function getPhotoInitiallyReturnsNull(): void
    {
        self::assertSame(
            null,
            $this->subject->getPhoto()
        );
    }

    /**
     * @test
     */
    public function setPhotoForStringSetsPhoto(): void
    {
        $this->subject->setPhoto('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getPhoto()
        );
    }
}
