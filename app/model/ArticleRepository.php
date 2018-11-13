<?php
declare(strict_types=1);

namespace App\Model;

use Shake\Scaffolding\Repository;
use Nette\Application\BadRequestException;

/**
 */
class ArticleRepository extends Repository
{

    public function saveTranslation($articleId, $languageId, $values)
    {
        $translation = $this->connection->table('article_translation')
            ->where('article_id', $articleId)
            ->where('language_id', $languageId)
            ->fetch();
        if (!$translation) {
            $translation = $this->connection->table('article_translation')
                ->insert([
                    'article_id' => $articleId,
                    'language_id' => $languageId,
                ]);
        }

        return $this->connection->table('article_translation')
            ->where('id', $translation->id)
            ->update($values);
    }


    public function delete($id)
    {
        $article = $this->get($id);

        $article->related('article_translation')->delete();

        return $article->delete();
    }


    public function findBySlug(string $titleSlug)
    {
        return $this->find([
            ':article_translation.title_slug' => $titleSlug,
        ]);
    }


    public function getBySlug(string $titleSlug)
    {
        $article = $this->findBySlug($titleSlug);

        if (!$article) {
            throw new BadRequestException;
        }

        return $article;
    }

}
