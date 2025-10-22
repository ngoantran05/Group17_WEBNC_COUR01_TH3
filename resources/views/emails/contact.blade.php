<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tin nhắn liên hệ mới</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2 style="color: #333;">Bạn có tin nhắn liên hệ mới</h2>
    <hr>
    <p><strong>Từ:</strong> {{ $data['name'] }} ({{ $data['email'] }})</p>
    <p><strong>Chủ đề:</strong> {{ $data['subject'] }}</p>
    <hr>
    <p><strong>Nội dung tin nhắn:</strong></p>
    <div style="background-color: #f9f9f9; border: 1px solid #ddd; padding: 15px;">
        {!! nl2br(e($data['message'])) !!}
    </div>
</body>
</html>