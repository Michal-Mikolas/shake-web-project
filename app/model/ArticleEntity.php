<?php
declare(strict_types=1);

namespace App\Model;

use Shake;
use Shake\Database\Orm\Entity;
use Nette;
use Nette\Application\BadRequestException;
use Nette\Application\Application;


/**
 */
class ArticleEntity extends Entity
{
    /** @inject @var Application */
    public $application;


    public function getTranslation($language = NULL)
    {
        if (!$language) {
            $language = $this->application->getPresenter()->locale;
        }

        $translation = $this->related('article_translation')
            ->where('language.key', $language)
            ->fetch();

        if (!$translation) {
            $translation = $this->related('article_translation')
                ->where('language.is_default', 1)
                ->fetch();
        }

        if (!$translation) {
            throw new BadRequestException;
        }

        return $translation;
    }


    public function getTranslations()
    {
        $translations = $this->related('article_translation');

        return $translations;
    }

}
