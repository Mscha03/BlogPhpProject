<?php

namespace App\Templates;

use App\Entities\SettingEntity;
use App\Exceptions\DoesNotExistsException;
use App\Models\Setting;

abstract class Template
{
    protected string $title;
    protected SettingEntity $setting;

    /**
     * @throws DoesNotExistsException
     */
    public function __construct()
    {
        $settingModel = new Setting();
        $this->setting = $settingModel->getFirstData();
    }

    public function getHead(): void
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

    public function getHeader(): void
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

    public function getFooter(): void
    {
        ?>
            <footer>
                <p><?= $this->setting->getFooter() ?></p>
            </footer>
        <?php
    }

    abstract protected function renderPage();
}