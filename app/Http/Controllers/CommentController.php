<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function showComments($productId)
    {
        // Получаем комментарии для конкретного товара с использованием отношения в модели Comment
        $comments = Comment::with('user')->where('product_id', $productId)->get();

        // Передаем данные в представление
        return view('comments.index', ['comments' => $comments, 'title' => 'Comments', 'productId' => $productId]);
    }

    public function showAddCommentForm($productId)
    {
        return view('comments.create', ['productId' => $productId, 'title' => 'Add Comment']);
    }

    public function addComment(Request $request, $productId)
    {
        // Валидация данных
        $request->validate([
            'text' => 'required|string',
        ]);

        $user = session('user');
        // Проверяем, что информация о пользователе доступна в сессии
        if ($user) {
            // Создание нового комментария
            Comment::create([
                'product_id' => $productId,
                'user_id' => $user['id'], // Получаем идентификатор пользователя из сессии
                'text' => $request->input('text'),
            ]);

            // Перенаправление на страницу с комментариями для данного товара
            return redirect()->route('comments.show', ['productId' => $productId])->with('success', 'Comment added success!');
        } else {
            // Если информация о пользователе не доступна в сессии, выполните необходимые действия (например, перенаправление на страницу входа)
            return redirect()->route('login')->with('error', 'You need to login to add a comment.');
        }
    }

    public function deleteComment($commentId)
    {
        $admin = session('admin');
        // Проверяем, является ли текущий пользователь администратором
        if ($admin) {
            // Находим комментарий
            $comment = Comment::find($commentId);

            // Проверяем, найден ли комментарий
            if ($comment) {
                // Удаляем комментарий
                $comment->delete();

                return redirect()->back()->with('success', 'Comment deleted success!');
            } else {
                return redirect()->back()->with('error', 'Comment not found.');
            }
        } else {
            // Если текущий пользователь не администратор, перенаправляем на страницу с необходимым сообщением
            return redirect()->back()->with('error', 'You do not have permission to delete this comment.');
        }
    }
}
