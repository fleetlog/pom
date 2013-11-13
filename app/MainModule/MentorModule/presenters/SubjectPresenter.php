<?php

namespace MainModule\MentorModule;

use Nette\Application\UI\Form;

class SubjectPresenter extends BasePresenter
{
	public function actionDefault()
	{
		$this->template->subjects = $this->subjectModel->getSubjects();
	}

	public function actionAddEdit($id)
	{
		if ($id) {
			$subject = $this->subjectModel->get($id);
			if (!$subject) {
				//throw Nette\
			}
			$this['addEditSubjectForm']->setDefaults($subject);
		}
	}

	public function createComponentAddEditSubjectForm()
	{
		$schoolYear = $this->subjectModel->getSchoolYears()->fetchPairs('id', 'year');

		$form = new Form;
		$form->addSelect('school_year_id', 'Skolský rok', $schoolYear)
			->setRequired('Povinný atribút');
		$form->addText('name', 'Názov predmetu')
			->setRequired('Povinný atribút');
		$form->addSubmit('submit');
		$form->onSuccess[] = $this->processAddEditSubjectForm;

		return $form;
	}

	public function processAddEditSubjectForm(Form $form)
	{
		$values = $form->getValues();
		$values->created = new \Nette\Datetime;
		$id = $this->presenter->getParameter('id');

		$this->subjectModel->addEdit($values, $id);
		$this->flashMessage("Predmet bol pridaný");

		$this->redirect('default');
	}
}
