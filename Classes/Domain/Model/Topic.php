<?php

declare(strict_types=1);

namespace Slub\SlubEvents\Domain\Model;

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
 *  the Free Software Foundation; either version 3 of the License, or
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

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * @package slub_events
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Topic extends AbstractEntity
{

    /**
     * Name of the specialists Topic
     *
     * @var string
     */
    #[Extbase\Validate(['validator' => 'NotEmpty'])]
    protected $name;

    /**
     * parent
     *
     * @var ObjectStorage<Topic>
     */
    protected $parent;

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     *
     * @return void
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * Adds a Topic
     *
     * @param Topic $parent
     *
     * @return void
     */
    public function addParent(Topic $parent): void
    {
        $this->parent->attach($parent);
    }

    /**
     * Removes a Topic
     *
     * @param Topic $parentToRemove The Location to be removed
     *
     * @return void
     */
    public function removeParent(Topic $parentToRemove): void
    {
        $this->parent->detach($parentToRemove);
    }

    /**
     * Returns the parent
     *
     * @return ObjectStorage<Topic> $parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets the parent
     *
     * @param ObjectStorage<Topic> $parent
     *
     * @return void
     */
    public function setParent(ObjectStorage $parent): void
    {
        $this->parent = $parent;
    }
}
