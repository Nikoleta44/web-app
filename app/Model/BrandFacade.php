<?php


namespace App\Model;

use Nette;


final class BrandFacade
{
    use Nette\SmartObject;

    private Nette\Database\Explorer $database;
    /**
     * @var mixed
     */
    private $selection;

    public function __construct(Nette\Database\Explorer $database)
    {
        $this->database = $database;
    }

    public function findBrands(): Nette\Database\Table\Selection
    {
        return $this->database->table('znacky')
            ->order('id ASC');
    }

    public function getBrandsCount(): int
    {
        return $this->database->fetchField('SELECT COUNT(*) FROM znacky');
    }

    public function deleteBrand($id)
    {
        $this->database->table('znacky')->where('id', $id)->delete();
    }



}