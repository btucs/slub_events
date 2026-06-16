<?php
declare(strict_types = 1);
namespace Slub\SlubEvents\ViewHelpers\Pagination;

use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\PaginationInterface;
use TYPO3\CMS\Core\Pagination\PaginatorInterface;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\ExtbaseRequestParameters;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Service\ExtensionService;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * PaginateViewHelper
 */
class PaginateViewHelper extends AbstractViewHelper
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * @return void
     */
    #[\Override]
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('objects', 'mixed', 'array or queryresult', true);
        $this->registerArgument('as', 'string', 'new variable name', true);
        $this->registerArgument('itemsPerPage', 'int', 'items per page', false, 10);
        $this->registerArgument('name', 'string', 'unique identification - will take "as" as fallback', false, '');
    }

    #[\Override]
    public function render(): string
    {
        if ($this->arguments['objects'] === null) {
            return $this->renderChildren();
        }
        $templateVariableContainer = $this->renderingContext->getVariableProvider();
        $templateVariableContainer->add($this->arguments['as'], [
            'pagination' => $this->getPagination(),
            'paginator' => $this->getPaginator(),
            'name' => $this->getName()
        ]);
        $output = $this->renderChildren();
        $templateVariableContainer->remove($this->arguments['as']);
        return $output;
    }

    protected function getPagination(): PaginationInterface
    {
        $paginator = $this->getPaginator();
        return GeneralUtility::makeInstance(SimplePagination::class, $paginator);
    }

    protected function getPaginator(): PaginatorInterface
    {
        if (is_array($this->arguments['objects'])) {
            $paginatorClass = ArrayPaginator::class;
        } elseif (is_a($this->arguments['objects'], QueryResultInterface::class)) {
            $paginatorClass = QueryResultPaginator::class;
        } else {
            throw new \RuntimeException('Given object is not supported for pagination', 1634132847);
        }
        return GeneralUtility::makeInstance(
            $paginatorClass,
            $this->arguments['objects'],
            $this->getPageNumber(),
            (int)$this->arguments['itemsPerPage']
        );
    }

    protected function getPageNumber(): int
    {
        $request = $this->renderingContext->getRequest();
        $extbaseRequestParameters = $request->getAttribute('extbase');
        if ($extbaseRequestParameters instanceof ExtbaseRequestParameters) {
            $extensionName = $extbaseRequestParameters->getControllerExtensionName();
            $pluginName = $extbaseRequestParameters->getPluginName();
        } else {
            // Fallback if extbase parameters are not available
            return 1;
        }
        $extensionService = GeneralUtility::makeInstance(ExtensionService::class);
        $pluginNamespace = $extensionService->getPluginNamespace($extensionName, $pluginName);
        $variables = $request->getParsedBody()[$pluginNamespace] ?? $request->getQueryParams()[$pluginNamespace] ?? null;
        if ($variables !== null && !empty($variables[$this->getName()]['currentPage'])) {
            return (int)$variables[$this->getName()]['currentPage'];
        }
        return 1;
    }

    protected function getName(): string
    {
        return $this->arguments['name'] ?: $this->arguments['as'];
    }
}
