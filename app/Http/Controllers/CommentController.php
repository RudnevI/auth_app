<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends BaseCrudController
{
    public function getModel() {
        return Comment::class;
    }

}
