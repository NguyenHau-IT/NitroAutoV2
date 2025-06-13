<?php
class ChatModel
{
    private $quickReplies = [
        'chào' => 'Chào bạn! Tôi có thể giúp gì?',
        'giờ làm việc' => 'Chúng tôi làm việc từ 8h đến 17h.',
        'địa chỉ' => 'Chúng tôi ở 123 Lê Lợi, Quận 1, TP.HCM.',
        'tạm biệt' => 'Tạm biệt bạn!'
    ];

    public function getReply($message)
    {
        $msg = strtolower(trim($message));

        foreach ($this->quickReplies as $key => $reply) {
            if (strpos($msg, $key) !== false) {
                return $reply;
            }
        }

        return $this->callAI($msg); // Nếu không khớp từ khóa
    }

    private function callAI($message)
    {
        $config = require dirname(__DIR__, 2) . '/config/config.php';
        $apiKey = $config['OPENROUTER_API_KEY'];

        $data = [
            "model" => "mistralai/mixtral-8x7b-instruct", // ✅ Mô hình miễn phí
            "messages" => [
                ["role" => "system", "content" => "Bạn là một trợ lý chatbot thân thiện bằng tiếng Việt."],
                ["role" => "user", "content" => $message . " Hãy trả lời bằng tiếng Việt."]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://openrouter.ai/api/v1/chat/completions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        if (curl_errno($ch)) return "Lỗi gọi AI: " . curl_error($ch);

        $result = json_decode($response, true);
        return $result['choices'][0]['message']['content'] ?? "Tôi chưa có câu trả lời phù hợp.";
    }
}
