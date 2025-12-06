<?php

namespace App\Templates;

use App\Templates\Template;

class LoginPage extends Template
{
    public function renderPage(): void
    {
        $this->title = $this->setting->getTitle();
        ?>
        <html lang="en">
            <?php $this->getAdminHead(); ?>
            <body>
            <main>
                <form method="POST" action="<?= url(path: 'index.php', query: ['action' => 'login']); ?>">
                    <div class="login">
                        <h3>Login to System</h3>
                        <div class="errors">
                            <ul>
                                <li>error is exists</li>
                            </ul>
                        </div>
                        <div>
                            <label for="email">Email:</label>
                            <input type="text" id="email" name="email">
                        </div>
                        <div>
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password">
                        </div>
                        <div>
                            <input type="submit" value="Login">
                        </div>
                    </div>
                </form>
            </main>
            </body>
        </html>
        <?php
    }
}