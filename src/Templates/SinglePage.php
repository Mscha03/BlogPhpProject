<?php

namespace App\Templates;

use App\Exceptions\DoesNotExistsException;
use App\Exceptions\NotFoundException;
use App\Models\Post;

class SinglePage extends Template
{
    private $post;
    private $topPosts;
    private $lastPosts;

    /**
     * @throws NotFoundException
     * @throws DoesNotExistsException
     */
    public function __construct()
    {
        parent::__construct();

        if($this->request->has('id') === false)
        {
            throw new NotFoundException(message: 'Page not found');
        }

        $id = $this->request->get('id');
        $postModel = new Post();
        $this->post = $postModel->getDataById($id);
        $this->title = $this->setting->getTitle() . ' - ' . $this->post->getTitle();

        $this->topPosts = $postModel->sortData(callback: function ($first, $second) {
            return $first->getView() > $second->getView() ? -1 : 1;
        });

        $this->lastPosts = $postModel->sortData(callback: function ($first, $second) {
            return $first->getTimestamp() > $second->getTimestamp() ? -1 : 1;
        });
    }


    public function renderPage(): void
    {
        ?>
        <html lang="en">
        <?php $this->getHead(); ?>
        <body>
        <main>
            <?php $this->getHeader();?>
            <?php $this->getNavbar();?>
            <section id="content">
                <?php $this->getSidebar($this->topPosts, $this->lastPosts) ?>
                <?php if($this->post) : ?>
                    <div id="articles">
                            <article>
                                <div class="caption">
                                    <h3><?= $this->post->getTitle() ?></h3>
                                    <ul>
                                        <li>Date: <span><?= $this->post->getDate() ?></span></li>
                                        <li>Views: <span><?= $this->post->getView() ?> view</span></li>
                                    </ul>
                                    <p>
                                        <?= $this->post->getContent() ?>
                                    </p>
                                </div>
                                <div class="image">
                                    <img src="<?= asset($this->post->getImage()) ?>" alt="<?= $this->post->getTitle() ?>">
                                </div>
                                <div class="clearfix"></div>
                            </article>
                    </div>
                <?php endif ?>
                <div class="clearfix"></div>
            </section>
            <?php $this->getFooter(); ?>
        </main>
        </body>
        </html>
        <?php
    }
}