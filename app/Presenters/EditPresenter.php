<?php


namespace App\Presenters;
use App\Model\BrandFacade;
use Nette\Application\UI\Form;
use Nette;

class EditPresenter extends Nette\Application\UI\Presenter
{
    private Nette\Database\Explorer $database;

    public function __construct(Nette\Database\Explorer $database)
    {
        $this->database = $database;
    }

    protected function createComponentBrandForm(): Form
    {
        $form = new Form;
        $form->addText('nazov_znacky', 'Název značky:')
            ->setRequired()
            ->addRule($form::MAX_LENGTH, 'Počet znakú přesáhl limit', 30);

        $form->addSubmit('send', 'Uložit');
        $form->onSuccess[] = [$this, 'brandFormSucceeded'];

        return $form;
    }

    public function brandFormSucceeded(array $data): void
    {
        $id = $this->getParameter('id');

        if ($id) {
            $znacka = $this->database
                ->table('znacky')
                ->get($id);
            $znacka->update($data);
            $this->flashMessage('Značka byla editována.', 'success');

        } else {
            $znacka = $this->database
                ->table('znacky')
                ->insert($data);
            $this->flashMessage('Značka byla úspěšne přidána.', 'success');
        }
        $this->redirect('Homepage:default');
    }

    /**
     * @throws Nette\Application\BadRequestException
     * @throws Nette\InvalidArgumentException
     */
    public function renderEdit(int $id): void
    {
        $znacka = $this->database
            ->table('znacky')
            ->get($id);

        if (!$znacka) {
            $this->error('Značka nenájdená');
        }

        $this->getComponent('brandForm')
            ->setDefaults($znacka->toArray());
    }

}