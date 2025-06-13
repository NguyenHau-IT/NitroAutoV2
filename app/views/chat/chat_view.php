<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chatbot Trợ lý Ô tô AI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script> <!-- Markdown Parser -->
    <style>
        #chat-content {
            height: 260px;
            overflow-y: auto;
            font-size: 14px;
        }
        .chat-bubble {
            padding: 8px 12px;
            border-radius: 12px;
            max-width: 80%;
            display: inline-block;
        }
        .chat-user {
            background-color: #cce5ff;
            text-align: right;
            margin-left: auto;
        }
        .chat-bot {
            background-color: #f1f1f1;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <!-- Nút mở chat -->
    <div class="position-fixed end-0 me-4 z-3" style="bottom: 130px;">
        <button class="btn btn-outline-info rounded-circle shadow" style="width: 56px; height: 56px;" onclick="toggleChat()">
            <i class="bi bi-chat-dots-fill fs-5"></i>
        </button>
    </div>

    <!-- Hộp chat -->
    <div id="chat-box" class="card position-fixed end-0 m-4 shadow" style="width: 340px; display: none; z-index: 1055; bottom: 105px;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>
                <!-- ✅ Dùng icon kép: AI + ô tô -->
                <i class="bi bi-robot me-1"></i>
                Trợ lý ô tô AI
            </span>
            <button class="btn btn-sm btn-light" onclick="toggleChat()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div id="chat-content" class="card-body bg-light">
            <div id="typing-indicator" class="text-muted fst-italic mt-1" style="display: none;">AI đang soạn tin...</div>
        </div>
        <div class="card-footer p-2 border-top">
            <div class="input-group">
                <input type="text" id="chatInput" class="form-control" placeholder="Nhập câu hỏi..." onkeypress="handleKey(event)">
                <button class="btn btn-primary" onclick="sendChat()">Gửi</button>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        function toggleChat() {
            const box = document.getElementById("chat-box");
            box.style.display = (box.style.display === "none" || !box.style.display) ? "block" : "none";
        }

        function handleKey(e) {
            if (e.key === 'Enter') sendChat();
        }

        function sendChat() {
            const input = document.getElementById("chatInput");
            const content = document.getElementById("chat-content");
            const typing = document.getElementById("typing-indicator");
            const msg = input.value.trim();
            if (!msg) return;

            // Hiển thị tin người dùng
            const userMsg = document.createElement("div");
            userMsg.className = "text-end mb-2";
            userMsg.innerHTML = `<div class="chat-bubble chat-user">${msg}</div>`;
            content.insertBefore(userMsg, typing);
            input.value = '';
            input.focus();
            content.scrollTop = content.scrollHeight;

            // Hiện "đang soạn tin..."
            typing.style.display = "block";

            fetch('/chat', {
                method: "POST",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'message=' + encodeURIComponent(msg)
            })
            .then(res => res.text())
            .then(reply => {
                typing.style.display = "none";

                const botMsg = document.createElement("div");
                botMsg.className = "text-start mb-2";
                botMsg.innerHTML = `<div class="chat-bubble chat-bot">${marked.parse(reply)}</div>`;
                content.insertBefore(botMsg, typing);
                content.scrollTop = content.scrollHeight;
            });
        }
    </script>
</body>
</html>
