<?php

namespace App\Templates;

use App\Classes\Session;
use App\Entities\PostEntity;
use App\Models\Post;
use App\Templates\Template;

class EditPage extends Template
{
    private PostEntity $post;
    private array $errors = [];

    public function __construct()
    {
        parent::__construct();

        if(!$this->request->has('id'))
        {
            redirect('panel.php', ['action' => 'post']);
        }

        $postModel = new Post();
        $this->post = $postModel->getDataById(id: $this->request->id);

        $this->title = $this->setting->getTitle() . ' - Admin panel - Edit post: ' . $this->post->getTitle();

        if ($this->request->isPostMethod())
        {
            $data = $this->validator->validate([
                'title' => ['required', 'min:3', 'max:100'],
                'category' => ['required', 'in:sport,political,social'],
                'content' => ['required','min:3', 'max:5000'],
                'image' => ['nullable', 'file', 'type:jpg,jpeg,png', 'size:2048']
            ]);

            if(!$data->hasErrors())
            {
                $this->updatePost($postModel);
            } else {
                $this->errors = $data->getErrors();
            }
        }

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
                        <input type="text" id="title" name="title" placeholder="Title" value="<?= $this->post->getTitle() ?>"/>
                    </div>
                    <div>
                        <label for="category">Category</label>
                        <select id="category" name="category">
                            <option value="political" <?= $this->post->getCategory() == 'political' ? 'selected' : '' ?> >Political</option>
                            <option value="sport" <?= $this->post->getCategory() == 'sport' ? 'selected' : '' ?> >Sport</option>
                            <option value="social" <?= $this->post->getCategory() == 'social' ? 'selected' : '' ?> >Social</option>
                        </select>
                    </div>
                    <div>
                        <label for="content">Content</label>
                        <textarea id="content" name="content" cols="30" rows="10" placeholder="Title" ><?= $this->post->getContent() ?></textarea>
                    </div>
                    <div>
                        <label for="image">Image</label>
                        <input type="file" id="image" name="image"/>
                    </div>
                    <div>
                        <input type="submit" value="Edit Post"/>
                    </div>
                </form>
            </section>
        </main>
        </body>
        </html>
        <?php
    }

    private function updatePost(Post $postModel): void
    {
        $this->post->setTitle($this->request->title);
        $this->post->setContent($this->request->content);
        $this->post->setCategory($this->request->category);

        if($this->request->image->isFile()){
            deleteFile($this->post->getImage());
            $image = $this->request->image->upload();
            $this->post->setImage($image);
        }

        $postModel->editData($this->post);
        Session::flush('message', 'Post has been updated');

        redirect('panel.php', ['action' => 'post']);
    }
}