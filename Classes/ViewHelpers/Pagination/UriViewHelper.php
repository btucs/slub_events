<?php
declare(strict_types = 1);

namespace Slub\SlubEvents\ViewHelpers\Pagination;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\ExtbaseRequestParameters;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Service\ExtensionService;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContext;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * UriViewHelper
 */
class UriViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Initialize arguments
     */
    #[\Override]
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('name', 'string', 'identifier important if more widgets on same page', false, 'widget');
        $this->registerArgument('arguments', 'array', 'Arguments', false, []);
    }

    /**
     * Build an uri to current action with &tx_ext_plugin[currentPage]=2
     *
     * @return string The rendered uri
     */
    #[\Override]
    public function render(): string
    {
        /** @var RenderingContext $renderingContext */
        $renderingContext = $this->renderingContext;
        $request = $renderingContext->getRequest();

        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $uriBuilder->setRequest($request);

        $extbaseRequestParameters = $request->getAttribute('extbase');
        if ($extbaseRequestParameters instanceof ExtbaseRequestParameters) {
            $extensionName = $extbaseRequestParameters->getControllerExtensionName();
            $pluginName = $extbaseRequestParameters->getPluginName();
        } else {
            // Fallback if extbase parameters are not available
            return '';
        }
        $extensionService = GeneralUtility::makeInstance(ExtensionService::class);
        $pluginNamespace = $extensionService->getPluginNamespace($extensionName, $pluginName);
        $arguments = $this->hasArgument('arguments') ? $this->arguments['arguments'] : [];
        if ($this->hasArgument('action')) {
            $arguments['action'] = $this->arguments['action'];
        }
        if ($this->hasArgument('format') && $this->arguments['format'] !== '') {
            $arguments['format'] = $this->arguments['format'];
        }

        $pluginArguments = $request->getParsedBody()[$pluginNamespace] ?? $request->getQueryParams()[$pluginNamespace] ?? [];
        if (!is_array($pluginArguments)) {
            $pluginArguments = [];
        }
        $pluginArguments[$this->arguments['name']] = $arguments;

        $uriBuilder->reset()
                   ->setArguments([$pluginNamespace => $pluginArguments])
                   ->setAddQueryString(true)
                   ->setArgumentsToBeExcludedFromQueryString(['cHash']);
        return $uriBuilder->build();
    }
}
