<?php
namespace App\AdminModule\Controls\ArticleForm;

use App\Controls\BaseControl;
use App\Model\ArticleEntity;
use App\Model\LanguageManager;
use App\Services\FormFactory;

/**
 */
class Control extends BaseControl
{
    private $formFactory;
    private $languageManager;


    public function __construct(
        $parent = NULL,
        $name = NULL,
        FormFactory $formFactory,
        LanguageManager $languageManager
    ){
        $this->formFactory = $formFactory;
        $this->languageManager = $languageManager;
    }


    public function render()
    {
        $this->template->setFile(__DIR__ . '/control.latte');

        $languages = $this->languageManager->search(NULL, NULL, 'is_default DESC');

        $this->template->languages = $languages;
        $this->template->render();
    }


    protected function createComponentForm($name = NULL)
    {
        $form = $this->formFactory->create($this, $name);

        $langsCont = $form->addContainer('languages');
        foreach ($this->languageManager->search() as $language) {
            $langCont = $langsCont->addContainer($language->id);

            $langCont->addText('title', 'admin.articles.title');
            $langCont->addText('title_slug', 'admin.articles.title_slug');
            $langCont->addTextarea('content_html', 'admin.articles.content');
        }

        $form->addSubmit('save', 'app.base.saveBtn');

        return $form;
    }


    public function setArticle(ArticleEntity $article)
    {
        foreach ($article->translations as $translation) {
            $this['form']['languages'][$translation->language_id]->setDefaults([
                'title' => $translation->title,
                'title_slug' => $translation->title_slug,
                'content_html' => $translation->content_html,
            ]);
        }
    }

}
