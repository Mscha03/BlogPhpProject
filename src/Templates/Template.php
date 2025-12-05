<?php

namespace App\Templates;

use App\Classes\Request;
use App\Entities\SettingEntity;
use App\Exceptions\DoesNotExistsException;
use App\Models\Setting;

abstract class Template
{
    protected string $title;
    protected SettingEntity $setting;
    protected Request $request;

    /**
     * @throws DoesNotExistsException
     */
    public function __construct()
    {
        $this->request = new Request();

        $settingModel = new Setting();
        $this->setting = $settingModel->getFirstData();
    }

    protected function getHead(): void
    {
        ?>

        <head>
            <meta charset="UTF-8">
            <meta name="description" content="<?= $this->setting->getDescription() ?>">
            <meta name="keyword" content="<?= $this->setting->getKeywords() ?>">
            <meta name="author" content="<?= $this->setting->getAuthor() ?>">

            <title><?= $this->title ?></title>
            <link rel="stylesheet" href="/assets/css/style.css">
        </head>


        <?php
    }

    protected function getHeader(): void
    {
        ?>
            <header>
                <h1><?= $this->setting->getTitle() ?></h1>
                <div id="logo">
                    <img src="<?= asset(file: $this->setting->getLogo())?>" alt="<?= $this->setting->getTitle() ?>">
                </div>
            </header>
        <?php
    }

    protected function getFooter(): void
    {
        ?>
            <footer>
                <p><?= $this->setting->getFooter() ?></p>
            </footer>
        <?php
    }

    protected function getSidebar($topPosts, $lastPosts): void
    {
        ?>
            <aside>
                <?php if (count($topPosts)): ?>
                    <div class="aside-box">
                        <h2>Top Posts</h2>
                        <ul>
                            <?php foreach ($topPosts as $item): ?>
                                <li>
                                    <a href="<?= url(path:'index.php', query: ['action' => 'single', 'id' => $item->getId()])?>">
                                        <?= $item->getTitle() ?> <small>( <?= $item->getView() ?>)</small>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="aside-box">
                    <h2>Lasts Posts</h2>
                    <ul>
                        <?php foreach ($lastPosts as $item): ?>
                            <li>
                                <a href="<?= url(path:'index.php', query: ['action' => 'single', 'id' => $item->getId()])?>">
                                    <?= $item->getTitle() ?> <small>( <?= $item->getDate() ?>)</small>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </aside>
        <?php
    }

    protected function getNavbar(): void
    {
        $word = $this->request->has('word')? $this->request->get('word') : ''
        ?>
            <nav>
                <ul>
                    <li><a href="<?= url(path: 'index.php')?>">Home</a></li>
                    <li><a href="<?= url(path: 'index.php', query: ['action' => 'category', 'category' => 'sport'])?>">Sport</a></li>
                    <li><a href="<?= url(path: 'index.php', query: ['action' => 'category', 'category' => 'social'])?>">Social</a></li>
                    <li><a href="<?= url(path: 'index.php', query: ['action' => 'category', 'category' => 'political'])?>">Political</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Gallery</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
                <form action="<?= url(path: 'index.php') ?>" method="GET">
                    <input type="hidden" name="action" value="search"/>
                    <label>
                        <input type="text" name="word" placeholder="search your word" value="<?=  $word ?>"/>
                    </label>
                    <input type="submit" value="search">
                </form>
            </nav>
        <?php
    }

    abstract public function renderPage();
}