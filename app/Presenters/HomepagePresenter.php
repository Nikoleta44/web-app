<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\BrandFacade;
use Nette;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    private BrandFacade $facade;

    public function __construct(BrandFacade $facade)
    {
        $this->facade = $facade;
    }

    public function renderDefault(int $page = 1): void
    {
        $znacky = $this->facade->findBrands();
        $lastPage = 0;
        $this->template->znacky = $znacky->page($page, 10, $lastPage);
        $this->template->page = $page;
        $this->template->lastPage = $lastPage;
    }

    public function handleDelete($id) {
        $this->facade->deleteBrand($id);
    }
    public function handleSortBrands(bool $isAsc = True)
    {
        $this->facade->sortBrands($isAsc);
        $this->template->isAsc = $isAsc;

    }


}
