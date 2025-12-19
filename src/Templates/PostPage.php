<?php

namespace App\Templates;

use App\Models\Post;
use App\Templates\Template;

class PostPage extends Template
{

    private $posts;

    public function __construct()
    {
        parent::__construct();

        $this->title = $this->setting->getTitle() . ' - Admin panel - All Posts';

        $postModel = new Post();
        $this->posts = $postModel->getAllData();
    }

    public function renderPage()
    {
        ?>
            <html lang="en">
                <?php $this->getAdminHead(); ?>
                <body>
                    <main>
                        <?php $this->getAdminNavbar(); ?>
                        <section class="content">
                            <?php if(count($this->posts)): ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>View</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($this->posts as $post): ?>
                                            <tr>
                                                <td><?= $post->getId() ?></td>
                                                <td><?= $post->getTitle() ?></td>
                                                <td><?= $post->getCategory() ?></td>
                                                <td><?= $post->getView() ?></td>
                                                <td><?= $post->getDate() ?></td>
                                                <td>
                                                    <a href="#">Edit</a>
                                                    <a href="#">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </section>
                    </main>
                </body>
            </html>
        <?php
    }
}