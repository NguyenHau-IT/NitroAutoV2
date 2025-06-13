<?php
require_once 'app/models/ChatModel.php';

class ChatController {
    public function showChat() {
        include 'views/chat_view.php';
    }

    public function getReply() {
        $userMessage = $_POST['message'] ?? '';
        $chatModel = new ChatModel();
        echo $chatModel->getReply($userMessage);
    }
}
