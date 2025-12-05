<?php

namespace App\Templates;

use App\Exceptions\DoesNotExistsException;
use App\Templates\Template;

class ErrorPage extends Template
{
    private string $message;

    /**
     * @param $message
     * @throws DoesNotExistsException
     */
    public function __construct($message)
    {
        parent::__construct();
        $this->message = $message;
        $this->title = $message;
    }


    public function renderPage(): void
    {
        ?>
        <!doctype html>
        <html lang="en">
        <?php $this->getHead() ?>
        <body>
        <main>
            <section id="content">
                <?= $this->message ?>
                <br/>
                <a href="<?= url(path: 'index.php)') ?>">go home</a>
            </section>
        </main>
        </body>
        </html>
        <?php
    }
}