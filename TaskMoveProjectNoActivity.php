<?php

namespace Kanboard\Plugin\TaskMoveProjectNoActivity;

use Kanboard\Model\TaskModel;
use Kanboard\Action\Base;

class TaskMoveProjectNoActivity extends Base
{
    /**
     * Get automatic action description
     *
     * @access public
     * @return string
     */
    public function getDescription()
    {
        return t('Automatically move a task to another project when there is no activity');
    }

    /**
     * Get the list of compatible events
     *
     * @access public
     * @return array
     */
    public function getCompatibleEvents()
    {
        return array(
            TaskModel::EVENT_DAILY_CRONJOB,
        );
    }

    /**
     * Get the required parameter for the action (defined by the user)
     *
     * @access public
     * @return array
     */
    public function getActionRequiredParameters()
    {
        return array(
            'project_id' => t('Project'),
            'column_id' => t('Column'),
            'duration' => t('Duration in days')
        );
    }

    /**
     * Get the required parameter for the event
     *
     * @access public
     * @return string[]
     */
    public function getEventRequiredParameters()
    {
        return array('tasks');
    }

    /**
     * Execute the action (close the task)
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool            True if the action was executed or false when not executed
     */
    public function doAction(array $data)
    {
        $results = array();
        $max = $this->getParam('duration') * 86400;
        $targetProjectId = $this->getParam('project_id');
        $sourceColumnId = $this->getParam('column_id');

        foreach ($data['tasks'] as $task) {
            $duration = time() - $task['date_modification'];

            if ($duration > $max &&
                $sourceColumnId == $task['column_id']) {
                $results[] = $this->taskProjectMoveModel->moveToProject($task['id'], $targetProjectId);
            }
        }

        return in_array(true, $results, true);
    }

    /**
     * Check if the event data meet the action condition
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool
     */
    public function hasRequiredCondition(array $data)
    {
        return count($data['tasks']) > 0;
    }
}
