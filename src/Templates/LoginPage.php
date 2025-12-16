<?php

namespace App\Templates;

use App\Classes\Request;
use App\Models\User;
use App\Templates\Template;

class LoginPage extends Template
{
    private $errors = [];

    public function __construct()
    {
        parent::__construct();

        $this->title = $this->setting->getTitle() . ' - Login to system';

        if($this->request->isPostMethod()){
          $data = $this->validator->validate([
                  'email' => ['required', 'email'],
                  'password' => ['required', 'min:6'],
          ]);

          if(!$data->hasErrors()){
              $userModel = new User();
              $user = $userModel->authenticateUser(email: $this->request->email, password: $this->request->password);
              if ($user) {
                dd('user is logged in');
              } else {
                  $this->errors[] = 'invalid email or password';
              }
          } else {
              dd($data->getErrors());
              $this->errors = $data->getErrors();
          }
        }
    }

    public function renderPage(): void
    {
        $this->title = $this->setting->getTitle();
        ?>
        <html lang="en">
            <?php $this->getAdminHead(); ?>
            <body>
            <main>
                <form method="post" action="<?= url(path: 'index.php', query: ['action' => 'login']) ?>">
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