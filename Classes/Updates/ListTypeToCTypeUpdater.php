<?php

declare(strict_types=1);

namespace Slub\SlubEvents\Updates;

use Linawolf\ListTypeMigration\Upgrades\AbstractListTypeToCTypeUpdate;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;

#[UpgradeWizard('slubEvents_listTypeToCTypeUpdate')]
final class ListTypeToCTypeUpdater extends AbstractListTypeToCTypeUpdate
{

    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'slubevents_eventlist' => 'slubevents_eventlist',
            'slubevents_eventlistupcoming' => 'slubevents_eventlistupcoming',
            'slubevents_eventlistmonth' => 'slubevents_eventlistmonth',
            'slubevents_eventshow' => 'slubevents_eventshow',
            'slubevents_eventuserpanel' => 'slubevents_eventuserpanel',
            'slubevents_eventsubscribedelete' => 'slubevents_eventsubscribedelete',
            'slubevents_eventsubscribecreate' => 'slubevents_eventsubscribecreate',
            'slubevents_eventgeniusbarcontactlist' => 'slubevents_eventgeniusbarcontactlist',
            'slubevents_eventgeniusbarcategorylist' => 'slubevents_eventgeniusbarcategorylist',
            'slubevents_apieventlist' => 'slubevents_apieventlist',
            'slubevents_apieventlistuser' => 'slubevents_apieventlistuser',
        ];
    }

    public function getTitle(): string
    {
        return 'Migrates SlubEvents plugins to CType';
    }

    public function getDescription(): string
    {
        return 'Migrates SlubEvents plugins from list_type to CType. ';
    }
}
