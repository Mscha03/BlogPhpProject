<?php

namespace App\Templates;

use App\Classes\Session;
use App\Models\Post;

class DeletePage extends Template
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->request->has('id'))
        {
            redirect(url('panel.php', ['action' => 'posts']));
        }

        $id = $this->request->get('id');
        $postModel = new Post();
        $post = $postModel->getDataById($id);

        $postModel->deleteData($post->getId());
        deleteFile($post->getImage());

        Session::flush('message', 'Post has been deleted');
        redirect('panel.php', ['action' => 'posts']);
    }

    public function renderPage(): void
    {
        echo 'delete page';
    }
}