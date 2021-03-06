<?php

namespace Models;

class Task extends Base
{
	public function getTasks($themeId)
	{
		$tasks = $this->getAll()->order('grade ASC, name ASC');

		if (!is_null($themeId)) {
			$tasks->where('theme_id', $themeId);
		}
		return $tasks;
	}

	public function addEdit($values, $id = NULL)
	{
		if(is_null($id)) {
			return $this->getTable()->insert($values);
		} else {
			$task = $this->getTable()->get($id);
			return $task->update($values);
		}
	}

	public function markDone($id)
	{
		$this->findBy(array('id' => $id))->update(array('grade' => 1, 'submitted' => new \Nette\DateTime()));

	}

	public function getHoursWorked($themeId)
	{
		return $this->getTable()->select('id, SUM(hours_worked) AS total_hours')->where('theme_id', $themeId)->fetch();
	}
}