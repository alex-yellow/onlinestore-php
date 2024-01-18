<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Message1;
use App\Models\Message2;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function showAdmins()
    {
        $user = session('user');
        // Получаем список администраторов из базы данных
        $admins = Admin::all();

        // Передаем данные в представление
        return view('messages.admins', ['admins' => $admins, 'title' => 'Admins', 'user' => $user]);
    }

    public function showUserMessages($userId)
    {
        $user = User::find($userId);

        $messages = Message2::where('user_id', $userId)->get();

        return view('messages.userMessages', [
            'user' => $user,
            'messages' => $messages,
            'title' => 'User Messages',
        ]);
    }

    public function adminMessages($adminId)
    {
        $admin = Admin::find($adminId);

        $messages = Message1::where('admin_id', $adminId)->get();

        return view('messages.adminMessages', [
            'admin' => $admin,
            'messages' => $messages,
            'title' => 'Admin Messages',
        ]);
    }

    // Метод для отображения страницы отправки сообщения
    public function showSendMessageForm($userId)
    {
        $admin = session('admin');
        $user = User::find($userId);

        return view('messages.adminToUser', [
            'admin' => $admin,
            'user' => $user,
            'title' => 'Send Message'
        ]);
    }

    // Метод для обработки POST-запроса на добавление сообщения в БД
    public function sendMessage(Request $request, $userId)
    {
        $messageText = $request->input('messageText');
        $admin = session('admin');


        // Добавление сообщения в БД
        $user = User::find($userId);

        $user->messages2()->create([
            'admin_id' => $admin['id'],
            'message_text' => $messageText,
        ]);

        return redirect()->route('admins.messages', ['adminId' => $admin['id']])->with('success', 'Message delivered success!');
    }

    public function showSendUserToAdminForm($adminId)
    {
        $user = session('user');
        $admin = Admin::find($adminId);

        return view('messages.userToAdmin', [
            'user' => $user,
            'admin' => $admin,
            'title' => 'Send Message'
        ]);
    }

    // Метод для обработки POST-запроса на добавление сообщения от пользователя к админу в БД
    public function sendUserToAdminMessage(Request $request, $adminId)
    {
        $messageText = $request->input('messageText');
        $user = session('user');

        // Добавление сообщения в БД
        $admin = Admin::find($adminId);


        $admin->messages1()->create([
            'user_id' => $user['id'],
            'message_text' => $messageText,
        ]);

        return redirect()->route('users.messages', ['userId' => $user['id']])->with('success', 'Message delivered success!');
    }

    public function deleteUserMessage($userId, $messageId)
    {
        $user = User::find($userId);

        $message = Message2::find($messageId);

         // Удаление сообщения
        $message->delete();

        return redirect()->route('users.messages', ['userId' => $user->id])->with('success', 'Message deleted success!');
    }

    public function deleteAdminMessage($adminId, $messageId)
    {
        $admin = Admin::find($adminId);

        $message = Message1::find($messageId);

        // Проверка, принадлежит ли сообщение данному админу
        if ($message->admin_id != $admin->id) {
            abort(403, 'Unauthorized action');
        }

        // Удаление сообщения
        $message->delete();

        return redirect()->route('admins.messages', ['adminId' => $admin->id])->with('success', 'Message deleted success!');
    }
}
