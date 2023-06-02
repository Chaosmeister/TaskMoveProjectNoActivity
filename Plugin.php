<?php
namespace Kanboard\Plugin\TaskMoveProjectNoActivity;

use Kanboard\Core\Plugin\Base;
use Kanboard\Plugin\TaskMoveProjectNoActivity\Task;

class Plugin extends Base
{
    public function initialize()
    {
        $this->actionManager->register(new TaskMoveProjectNoActivity($this->container));
    }

    public function getPluginName()
    {
        return 'TaskMoveProjectNoActivity';
    }

    public function getPluginDescription()
    {
        return t('Automatically move a task in a column to another project when there is no activity');
    }

    public function getPluginAuthor()
    {
        return 'Tomas Dittmann';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/Chaosmeister/TaskMoveProjectNoActivity';
    }

    public function getCompatibleVersion()
    {
        return '>=1.2.29';
    }
}
