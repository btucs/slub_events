<?php

declare(strict_types=1);

namespace Slub\SlubEvents\ViewHelpers\Format;

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
use Slub\SlubEvents\Domain\Model\Event;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Show months as title in event listing
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 */
class NewMonthTitleViewHelper extends AbstractViewHelper
{
    /**
     * Initialize arguments.
     */
    #[\Override]
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('events', QueryResult::class, 'Events', true);
        $this->registerArgument('index', 'int', 'Index', true);
    }

    /**
     * Render the supplied DateTime object as a formatted date.
     */
    #[\Override]
    public function render()
    {
        $index = $this->arguments['index'];
        $events = $this->arguments['events'];
        // the first is shown anyway...
        if ($index == 0) {

            /** @var Event $event */
            $event = $events[$index];
            $date = $event->getStartDateTime();

            if ($date instanceof \DateTime) {
                return $date;
            }
        } else {
            /** @var Event $event */
            $event = $events[$index];
            $date = $event->getStartDateTime();
            /** @var Event $preevent */
            $preevent = $events[$index - 1];
            $predate = $preevent->getStartDateTime();

            if ($date->format('m') !== $predate->format('m')) {
                return $date;
            }
        }
        return null;
    }
}
