<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Controls\ArticleForm;
use Nette\Application\UI\Form;
use Shake;
use Shake\Scaffolding;

/**
 */
class ArticlePresenter extends BasePresenter
{
    use Scaffolding\createComponentPaginator;

    /** @inject @var ArticleForm\ControlFactory */
    public $articleFormControlFactory;


    #
    #       #  ####  #####
    #       # #        #
    #       #  ####    #
    #       #      #   #
    #       # #    #   #
    ####### #  ####    #
    public function renderDefault()
    {
        // Get data
        $articles = $this->articleManager->search();

        // Paginate
        $paginator = $this['paginator']->getPaginator();
        $paginator->itemCount = count($articles);
        $articlesPaginated = $this->articleManager->search(
            NULL,
            [$paginator->itemsPerPage, $paginator->offset]
        );

        // Render
        $this->template->articles = $articles;
        $this->template->articlesPaginated = $articlesPaginated;
    }


    public function handleDelete($id)
    {
        $this->articleManager->delete($id);

        // Finish
        $this->flashMessage('admin.articles.deletedMessage', 'success');
        $this->redirect(':Admin:Article:');
    }


       #                       ##       #######
      # #   #####  #####      #  #      #       #####  # #####
     #   #  #    # #    #      ##       #       #    # #   #
    #     # #    # #    #     ###       #####   #    # #   #
    ####### #    # #    #    #   # #    #       #    # #   #
    #     # #    # #    #    #    #     #       #    # #   #
    #     # #####  #####      ###  #    ####### #####  #   #
    public function renderEdit($id)
    {
        // Get data
        $article = $this->articleManager->get($id);

        // Render
        $this['formControl']->setArticle($article);

        $this->template->article = $article;
    }


    protected function createComponentFormControl($name)
    {
        $formControl = $this->articleFormControlFactory->create($this, $name);

        $formControl['form']->onSuccess[] = array($this, 'saveForm');
        return $formControl;
    }


    public function saveForm(Form $form)
    {
        $values = $form->getValues();

        // Save/Get article
        if ($id = $this->getParam('id')) {
            $article = $this->articleManager->get($id);
        } else {
            $article = $this->articleManager->create([]);
        }

        // Save translations
        foreach ($values->languages as $langId => $langValues) {
            $this->articleManager->saveTranslation($article->id, $langId, $langValues);
        }

        // Finish
        $this->flashMessage('admin.articles.savedMessage', 'success');
        $this->redirect(':Admin:Article:');
    }

}
