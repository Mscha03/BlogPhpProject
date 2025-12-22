<?php

namespace App\Templates;

use App\Classes\Session;
use App\Entities\PostEntity;
use App\Exceptions\DoesNotExistsException;
use App\Models\Post;

class CreatePage extends Template
{
    protected string $title = '';
    private $errors = [];
    public function __construct()
    {
        parent::__construct();
        $this->title = $this->setting->getTitle(). ' - Admin Panel - Create Post';

        if($this->request->isPostMethod()){
            $data = $this->validator->validate([
                'title' => ['required', 'min:3', 'max:100'],
                'category' => ['required', 'in:sport,political,social'],
                'content' => ['required','min:3', 'max:5000'],
                'image' => ['required', 'file', 'type:jpg,jpeg,png', 'size:2048'],
            ]);

            if(!$data->hasErrors())
            {
                $this->createPost();
            } else {
                $this->errors = $data->getErrors();
            }
        }
    }

    /**
     * @throws DoesNotExistsException
     */
    private function createPost()
    {
        $postModel = new Post();

        $post = new PostEntity([
           'id' => $postModel->getLastData()->getId() + 1,
           'title' => $this->request->title,
           'content' => $this->request->content ,
            'category' => $this->request->category,
            'view' => 0,
            'image' => $this->request->image->upload(),
            'date' => date('Y-m-d H:i:s')
        ]);

        $postModel->createData($post);

        Session::flush('message', 'Post has been created');
        redirect('panel.php', ['action' => 'posts']);
    }

    public function showErrors(): void
    {
        if (count($this->errors)){
            ?>
            <div class="errors">
                <ul>
                    <?php foreach ($this->errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach;?>
                </ul>
            </div>
            <?php
        }
    }

    public function renderPage(): void
    {
        ?>
        <html lang="en">
        <?php $this->getAdminHead(); ?>
        <body>
        <main>
            <?php $this->getAdminNavbar();?>
            <section class="content">
                <?php $this->showErrors() ?>
                <form method="post" enctype="multipart/form-data">
                    <div>
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" placeholder="Title" value="<?= $this->request->has('title') ? $this->request->title : '' ?>"/>
                    </div>
                    <div>
                        <label for="category">Category</label>
                        <select id="category" name="category">
                            <option value="political" <?= $this->request->has('category') && $this->request->category == 'political' ? 'selected' : '' ?> >Political</option>
                            <option value="sport" <?= $this->request->has('category') && $this->request->category == 'sport' ? 'selected' : '' ?> >Sport</option>
                            <option value="social" <?= $this->request->has('category') && $this->request->category == 'social' ? 'selected' : '' ?> >Social</option>
                        </select>
                    </div>
                    <div>
                        <label for="content">Content</label>
                        <textarea id="content" name="content" cols="30" rows="10" placeholder="Title" ><?= $this->request->has('content') ? $this->request->content : '' ?></textarea>
                    </div>
                    <div>
                        <label for="image">Image</label>
                        <input type="file" id="image" name="image"/>
                    </div>
                    <div>
                        <input type="submit" value="Create Post"/>
                    </div>
                </form>
            </section>
        </main>
        </body>
        </html>
        <?php
    }
}