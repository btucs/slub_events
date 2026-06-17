<?php
namespace Slub\SlubEvents\Controller\Backend;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use Psr\Http\Message\ResponseInterface;
use Slub\SlubEvents\Controller\AbstractController;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Base class for backend modules
 * Parts of the code are inspired by EXT:news
 *
 * @package slub_events
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class BaseController extends AbstractController
{
    protected ?ModuleTemplate $moduleTemplate = null;

    /**
     * @var int
     */
    public $pageUid;
    /**
     * @var array
     */
    protected $pageInformation;
    public function __construct(private readonly ModuleTemplateFactory $moduleTemplateFactory, protected UriBuilder $uriBuilder)
    {
    }

    /**
     * Function will be called before every other action
     *
     */
    #[\Override]
    public function initializeAction(): void
    {
        $this->pageUid = (int)($this->request->getQueryParams()['id'] ?? null);
        $this->pageInformation = BackendUtility::readPageAccess($this->pageUid, '');
        parent::initializeAction();
    }

    /**
     * Set up the doc header properly here
     *
     * @param ViewInterface $view
     * @param \TYPO3Fluid\Fluid\View\ViewInterface $view
     */
    protected function initializeView($view): void
    {
        $moduleTemplate = $this->getModuleTemplate();
        $moduleTemplate->getDocHeaderComponent()->setMetaInformation([]);

        $this->createMenu();
        $this->createButtons();
    }

    /**
     * Create menu
     */
    protected function createMenu(): void
    {
        $moduleTemplate = $this->getModuleTemplate();
        $uriBuilder = $this->uriBuilder;
        $uriBuilder->setRequest($this->request);

        $menu = $moduleTemplate->getDocHeaderComponent()->getMenuRegistry()->makeMenu();
        $menu->setIdentifier('slub_events');

        $actions = [
            ['controller' => 'Backend\Event', 'action' => 'beList', 'label' => 'tx_slubevents.be.eventmanagement'],
            ['controller' => 'Backend\Subscriber', 'action' => 'beList', 'label' => 'tx_slubevents.be.subscriberlist']
        ];

        foreach ($actions as $action) {
            $item = $menu->makeMenuItem()
                ->setTitle(
                    // TODO: make this more flexible and changeable by TypoScript or an alternative language file
                    LocalizationUtility::translate($action['label'], 'SlubEvents')
                )
                ->setHref($uriBuilder->reset()->uriFor($action['action'], [], $action['controller']))
                ->setActive(
                    $this->request->getControllerName() === $action['controller'] &&
                    $this->request->getControllerActionName() === $action['action']
                );
            $menu->addMenuItem($item);
        }

        $moduleTemplate->getDocHeaderComponent()->getMenuRegistry()->addMenu($menu);

        if (is_array($this->pageInformation)) {
            $moduleTemplate->getDocHeaderComponent()->setMetaInformation($this->pageInformation);
        }
    }

    /**
     * Create the panel of buttons
     */
    protected function createButtons(): void
    {
        $moduleTemplate = $this->getModuleTemplate();
        $buttonBar = $moduleTemplate->getDocHeaderComponent()->getButtonBar();

        // Shortcut
        if ($this->getBackendUser()->mayMakeShortcut()) {
            $shortcutButton = $buttonBar->makeShortcutButton()
                ->setRouteIdentifier('web_SlubEvents')
                ->setArguments([
                  'route' => [],
                  'module' => [],
                  'id' => []
                ])
                ->setDisplayName('Shortcut');
            $buttonBar->addButton($shortcutButton, ButtonBar::BUTTON_POSITION_RIGHT);
        }
    }

    /**
     * Get backend user
     *
     * @return BackendUserAuthentication
     */
    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    protected function getModuleTemplate(): ModuleTemplate
    {
        if (!$this->moduleTemplate instanceof ModuleTemplate) {
            $this->moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        }
        return $this->moduleTemplate;
    }

    #[\Override]
    protected function htmlResponse(?string $html = null): ResponseInterface
    {
        $moduleTemplate = $this->getModuleTemplate();
        $moduleTemplate->assign('content', $html ?? $this->view->render());

        return $moduleTemplate->renderResponse('ModuleTemplate/Module');
    }
}
