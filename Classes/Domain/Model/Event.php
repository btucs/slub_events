<?php

namespace Slub\SlubEvents\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Alexander Bigga <typo3@slub-dresden.de>, SLUB Dresden
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
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * @package slub_events
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Event extends AbstractEntity {

    public $event;
    /**
     * title
     *
     * @var boolean
     */
    protected $hidden;

    /**
     * title
     *
     * @var string
     */
    protected $title;

    /**
     * Parent Event (in case of recurring event)
     *
     * @var Event
     */
    protected $parent;

    /**
     * @var array
     */
    protected $rootCategories = [];

    /**
     * startDateTime
     *
     * @var \DateTime
     */
    #[Extbase\Validate(['validator' => 'NotEmpty'])]
    protected $startDateTime;

    /**
     * This is an Allday-Event (Time disabled)
     *
     * @var boolean
     */
    protected $allDay = false;

    /**
     * End Date of Event
     *
     * @var \DateTime
     */
    protected $endDateTime;

    /**
     * End Date of Subscription
     *
     * @var \DateTime
     */
    protected $subEndDateTime;

    /**
     * teaser
     *
     * @var string
     */
    protected $teaser;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * @var ObjectStorage<TtContent>
     */
    #[Lazy]
    protected $contentElements;

    /**
     * Fal media items
     *
     * @var FileReference
     */
    protected $image;


    /**
     * Minimum of Subscribers
     *
     * @var int
     */
    protected $minSubscriber = 0;

    /**
     * Maximum of Subscribers
     *
     * @var int
     */
    protected $maxSubscriber = 0;

    /**
     * Maximum amount of Persons per Subscription
     *
     * @var int
     */
    protected $maxNumber = 0;

    /**
     * Target Audience
     *
     * @var int
     */
    #[Extbase\Validate(['validator' => 'NotEmpty'])]
    protected $audience = 0;

    /**
     * Sent Information about SubEndTime reached
     *
     * @var boolean
     */
    protected $subEndDateInfoSent = false;

    /**
     * Should this Event been indexed by search engine e.g. solr
     *
     * @var boolean
     */
    protected $noSearch = false;

    /**
     * This is a genius bar event
     *
     * @var boolean
     */
    protected $geniusBar = false;

    /**
     * The event  has been canceld
     *
     * @var boolean
     */
    protected $cancelled = false;

    /**
     * Category Id
     *
     * @var ObjectStorage<Category>
     */
    protected $categories;

    /**
     * Subscriber Ids
     *
     * @var ObjectStorage<Subscriber>
     */
    #[Extbase\ORM\Lazy]
    #[Extbase\ORM\Cascade(['value' => 'remove'])]
    protected $subscribers;

    /**
     * Location Ids
     *
     * @var Location
     */
    protected $location = null;

    /**
     * Discipline IDs
     *
     * @var ObjectStorage<Discipline>
     */
    protected $discipline;

    /**
     * Topic for stats ID
     *
     * @var Topic
     */
    protected $topic;

    /**
     * Contact ID
     *
     * @var Contact
     */
    protected $contact = null;

    /**
     * onlinesurvey
     *
     * @var string
     */
    protected $onlinesurvey;

    /**
     * external registration link
     *
     * @var string
     */
    protected $externalRegistration;

    /**
     * This is a recurring event
     *
     * @var boolean
     */
    protected $recurring = false;

    /**
     * The recurring options
     *
     * @var string
     */
    protected $recurringOptions;

    /**
     * The unsubscribe url
     *
     * @var string
     */
    protected $unsubscribeUrl;

    /**
     * The recurring end dateTime
     *
     * @var \DateTime
     */
    protected $recurringEndDateTime;

    /**
     * Event constructor.
     */
    public function __construct() {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all Tx_Extbase_Persistence_ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects() {
        /**
         * Do not modify this method!
         * It will be rewritten on each save in the extension builder
         * You may modify the constructor of this class instead
         */
        $this->categories = new ObjectStorage();

        $this->contentElements = new ObjectStorage();

        $this->discipline = new ObjectStorage();

        $this->subscribers = new ObjectStorage();
    }

    /**
     * Returns hidden
     *
     * @return boolean $hidden
     */
    public function getHidden() {
        return $this->hidden;
    }

    /**
     * Sets hidden
     *
     * @param boolean $hidden
     */
    public function setHidden( $hidden ): void {
        $this->hidden = $hidden;
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     */
    public function setTitle( $title ): void {
        $this->title = $title;
    }

    /**
     * Returns the teaser
     *
     * @return string $teaser
     */
    public function getTeaser() {
        return $this->teaser;
    }

    /**
     * Sets the teaser
     *
     * @param string $teaser
     */
    public function setTeaser( $teaser ): void {
        $this->teaser = $teaser;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     */
    public function setDescription( $description ): void {
        $this->description = $description;
    }

    /**
     * Get content elements
     *
     * @return ObjectStorage
     */
    public function getContentElements() {
        return $this->contentElements;
    }

    /**
     * Set content element list
     *
     * @param ObjectStorage $contentElements content elements
     */
    public function setContentElements( $contentElements ): void {
        $this->contentElements = $contentElements;
    }

    /**
     * Get id list of content elements
     *
     * @return string
     */
    public function getContentElementIdList() {
        return $this->getIdOfContentElements();
    }

    /**
     * Get translated id list of content elements
     *
     * @return string
     */
    public function getTranslatedContentElementIdList() {
        return $this->getIdOfContentElements( false );
    }

    /**
     * Collect id list
     *
     * @param bool $original
     *
     * @return string
     */
    protected function getIdOfContentElements( $original = true ) {
        $idList          = [];
        $contentElements = $this->getContentElements();
        if ( $contentElements ) {
            foreach ( $this->getContentElements() as $contentElement ) {
                if ( $contentElement->getColPos() >= 0 ) {
                    $idList[] = $original ? $contentElement->getUid() : $contentElement->_getProperty( '_localizedUid' );
                }
            }
        }

        return implode( ',', $idList );
    }

    /**
     * Returns the image
     *
     * @return FileReference $image
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param FileReference $image
     */
    public function setImage( $image ): void {
        $this->image = $image;
    }

    /**
     * Returns the parent
     *
     * @return Event $parent
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Sets the parent
     *
     * @param Event $parent
     *
     * @return void
     */
    public function setParent( Event $parent ): void {
        $this->parent = $parent;
    }

    /**
     * @return array $rootCategories
     */
    public function getRootCategories(): array
    {
        return $this->rootCategories;
    }

    /**
     * @param array $rootCategories
     */
    public function setRootCategories(array $rootCategories): void
    {
        $this->rootCategories = $rootCategories;
    }

    /**
     * Returns the minSubscriber
     *
     * @return integer $minSubscriber
     */
    public function getMinSubscriber() {
        return $this->minSubscriber;
    }

    /**
     * Sets the minSubscriber
     *
     * @param integer $minSubscriber
     *
     * @return void
     */
    public function setMinSubscriber( $minSubscriber ): void {
        $this->minSubscriber = $minSubscriber;
    }

    /**
     * Returns the maxSubscriber
     *
     * @return integer $maxSubscriber
     */
    public function getMaxSubscriber() {
        return $this->maxSubscriber;
    }

    /**
     * Sets the maxSubscriber
     *
     * @param integer $maxSubscriber
     *
     * @return void
     */
    public function setMaxSubscriber( $maxSubscriber ): void {
        $this->maxSubscriber = $maxSubscriber;
    }

    /**
     * Returns maxNumber
     *
     * @return integer $maxNumber
     */
    public function getMaxNumber() {
        return $this->maxNumber;
    }

    /**
     * Sets the maxSubscriber
     *
     * @param integer $maxNumber
     *
     * @return void
     */
    public function setMaxNumber( $maxNumber ): void {
        $this->maxNumber = $maxNumber;
    }

    /**
     * Adds a Subscriber
     *
     * @param Subscriber $subscriber
     *
     * @return void
     */
    public function addSubscriber( Subscriber $subscriber ): void {
        $this->subscribers->attach( $subscriber );
    }

    /**
     * Removes a Subscriber
     *
     * @param Subscriber $subscriberToRemove The Subscriber to be removed
     *
     * @return void
     */
    public function removeSubscriber( Subscriber $subscriberToRemove ): void {
        $this->subscribers->detach( $subscriberToRemove );
    }

    /**
     * Returns the subscribers
     *
     * @return ObjectStorage<Subscriber> $subscribers
     */
    public function getSubscribers() {
        return $this->subscribers;
    }

    /**
     * Sets the subscribers
     *
     * @param ObjectStorage<Subscriber> $subscribers
     *
     * @return void
     */
    public function setSubscribers( ObjectStorage $subscribers ): void {
        $this->subscribers = $subscribers;
    }

    /**
     * Returns the audience
     *
     * @return integer $audience
     */
    public function getAudience() {
        return $this->audience;
    }

    /**
     * Sets the audience
     *
     * @param integer $audience
     *
     * @return void
     */
    public function setAudience( $audience ): void {
        $this->audience = $audience;
    }

    /**
     * Sets the discipline
     *
     * @param ObjectStorage<Discipline> $discipline
     *
     * @return void
     */
    public function setDiscipline( ObjectStorage $discipline ): void {
        $this->discipline = $discipline;
    }

    /**
     * Returns the discipline
     *
     * @return ObjectStorage<Discipline> $discipline
     */
    public function getDiscipline() {
        return $this->discipline;
    }

    /**
     * Adds a discipline
     *
     * @param Discipline $discipline
     *
     * @return void
     */
    public function addDiscipline( Discipline $discipline ): void {
        $this->discipline->attach( $discipline );
    }

    /**
     * Removes a Discipline
     *
     * @param Discipline $disciplineToRemove The Discipline to be removed
     *
     * @return void
     */
    public function removeDiscipline( Discipline $disciplineToRemove ): void {
        $this->discipline->detach( $disciplineToRemove );
    }

    /**
     * Returns the location
     *
     * @return Location $location
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * Sets the location
     *
     * @param Location $location
     *
     * @return void
     */
    public function setLocation( Location $location ): void {
        $this->location = $location;
    }

    /**
     * Returns the Event
     *
     * @return Event $event
     */
    public function getEvent() {
        return $this->event;
    }

    /**
     * Returns the contact
     *
     * @return Contact $contact
     */
    public function getContact() {
        return $this->contact;
    }

    /**
     * Sets the contact
     *
     * @param Contact $contact
     *
     * @return void
     */
    public function setContact( Contact $contact ): void {
        $this->contact = $contact;
    }

    /**
     * Returns the allDay
     *
     * @return boolean allDay
     */
    public function getAllDay() {
        return $this->allDay;
    }

    /**
     * Sets the allDay
     *
     * @param boolean $allDay
     *
     * @return boolean allDay
     */
    public function setAllDay( $allDay ): void {
        $this->allDay = $allDay;
    }

    /**
     * Returns the boolean state of allDay
     *
     * @return boolean allDay
     */
    public function isAllDay() {
        return $this->getAllDay();
    }

    /**
     * Returns the startDateTime
     *
     * @return \DateTime startDateTime
     */
    public function getStartDateTime() {
        return $this->startDateTime;
    }

    /**
     * Sets the startDateTime
     *
     * @param \DateTime $startDateTime
     */
    public function setStartDateTime( $startDateTime ): void {
        $this->startDateTime = $startDateTime;
    }

    /**
     * Returns the endDateTime
     *
     * @return \DateTime endDateTime
     */
    public function getEndDateTime() {
        return $this->endDateTime;
    }

    /**
     * Sets the endDateTime
     *
     * @param \DateTime $endDateTime
     */
    public function setEndDateTime( $endDateTime ): void {
        $this->endDateTime = $endDateTime;
    }

    /**
     * Returns the subEndDateTime
     *
     * @return DateTime subEndDateTime
     */
    public function getSubEndDateTime() {
        return $this->subEndDateTime;
    }

    /**
     * Sets the subEndDateTime
     *
     * @param \DateTime $subEndDateTime
     */
    public function setSubEndDateTime( $subEndDateTime ): void {
        $this->subEndDateTime = $subEndDateTime;
    }

    /**
     * Returns the subEndDateInfoSent
     *
     * @return \DateTime subEndDateTime
     */
    public function getSubEndDateInfoSent() {
        return $this->subEndDateInfoSent;
    }

    /**
     * Sets the subEndDateInfoSent
     *
     * @param \DateTime $subEndDateInfoSent
     */
    public function setSubEndDateInfoSent( $subEndDateInfoSent ): void {
        $this->subEndDateInfoSent = $subEndDateInfoSent;
    }

    /**
     * Returns the noSearch
     *
     * @return boolean $noSearch
     */
    public function getNoSearch() {
        return $this->noSearch;
    }

    /**
     * Sets the noSearch
     *
     * @param boolean $noSearch
     */
    public function setNoSearch( $noSearch ): void {
        $this->noSearch = $noSearch;
    }

    /**
     * Returns geniusBar
     *
     * @return boolean $geniusBar
     */
    public function getGeniusBar() {
        return $this->geniusBar;
    }

    /**
     * Sets geniusBar
     *
     * @param boolean $geniusBar
     *
     * @return void
     */
    public function setGeniusBar( $geniusBar ): void {
        $this->geniusBar = $geniusBar;
    }

    /**
     * Adds a category
     *
     * @param Category $category
     *
     * @return void
     */
    public function addCategory( Category $category ): void {
        $this->categories->attach( $category );
    }

    /**
     * Removes a category
     *
     * @param Category $category
     *
     * @return ObjectStorage<Category> categories
     */
    public function removeCategory( Category $categoryToBeRemoved ): void {
        $this->categories->detach( $categoryToBeRemoved );
    }

    /**
     * Returns the categories
     *
     * @return ObjectStorage<Category> $categories
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * Sets the categories
     *
     * @param ObjectStorage<Category> $categories
     *
     * @return void
     */
    public function setCategories( ObjectStorage $categories ): void {
        $this->categories = $categories;
    }


    /**
     * Returns the cancelled
     *
     * @return boolean $cancelled
     */
    public function getCancelled() {
        return $this->cancelled;
    }

    /**
     * Sets the cancelled
     *
     * @param boolean $cancelled
     *
     * @return void
     */
    public function setCancelled( $cancelled ): void {
        $this->cancelled = $cancelled;
    }

    /**
     * Returns the boolean state of cancelled
     *
     * @return boolean
     */
    public function isCancelled() {
        return $this->getCancelled();
    }

    /**
     * Returns the onlinesurvey
     *
     * @return string $onlinesurvey
     */
    public function getOnlinesurvey() {
        return $this->onlinesurvey;
    }

    /**
     * Sets the onlinesurvey
     *
     * @param string $onlinesurvey
     *
     * @return void
     */
    public function setOnlinesurvey( $onlinesurvey ): void {
        $this->onlinesurvey = $onlinesurvey;
    }

    /**
     * Returns the external registration link
     *
     * @return string $externalRegistration
     */
    public function getExternalRegistration() {
        return $this->externalRegistration;
    }

    /**
     * Sets the external registration link
     *
     * @param string $externalRegistration
     *
     * @return void
     */
    public function setExternalRegistration( $externalRegistration ): void {
        $this->externalRegistration = $externalRegistration;
    }


    /**
     * Returns the recurring value
     *
     * @return boolean $recurring
     */
    public function getRecurring() {
        return $this->recurring;
    }

    /**
     * Sets the recurring state
     *
     * @param boolean $recurring
     *
     * @return void
     */
    public function setRecurring( $recurring ): void {
        $this->recurring = $recurring;
    }

    /**
     * Returns the boolean state of recurring
     *
     * @return boolean recurring
     */
    public function isRecurring() {
        return $this->getRecurring();
    }

    /**
     * Returns the recurring options
     *
     * @return array $recurringOptions
     */
    public function getRecurringOptions() {
        return unserialize( $this->recurringOptions );
    }

    /**
     * Sets the recurring options
     *
     * @param array $recurringOptions
     *
     * @return void
     */
    public function setRecurringOptions( $recurringOptions ): void {
        $this->recurringOptions = serialize( $recurringOptions );
    }

    /**
     * Returns the recurring end dateTime
     *
     * @return \DateTime recurringEndDateTime
     */
    public function getRecurringEndDateTime() {
        return $this->recurringEndDateTime;
    }

    /**
     * Sets the recurring end dateTime
     *
     * @param \DateTime $recurringEndDateTime
     */
    public function setRecurringEndDateTime( $recurringEndDateTime ): void {
        $this->recurringEndDateTime = $recurringEndDateTime;
    }

    /**
     * Returns the unsubscribe url value
     *
     * @return string $unsubscribeUrl
     */
    public function getUnsubscribeUrl()
    {
        return $this->unsubscribeUrl;
    }

    /**
     * Sets the unsubscribe url state
     *
     * @param string $unsubscribeUrl
     *
     * @return void
     */
    public function setUnsubscribeUrl($unsubscribeUrl): void
    {
        $this->unsubscribeUrl = $unsubscribeUrl;
    }
  
    /**
     * Get Topic
     *
     * @return Topic $topic
     */
    public function getTopic() {
        return $this->topic;
    }

    /**
     * Set Topic
     *
     * @return Topic $topic
     */
    public function setTopic( $topic ): void {
        $this->topic = $topic;
    }
}
