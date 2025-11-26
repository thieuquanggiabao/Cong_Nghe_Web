<?php
// Tên tệp tin chứa dữ liệu câu hỏi
$file_path = 'Quiz.txt';

// Khai báo mảng để lưu trữ các câu hỏi đã được parse
$questions = [];
$error_message = '';

if (file_exists($file_path)) {
    // Đọc toàn bộ nội dung tệp tin vào một chuỗi
    $content = file_get_contents($file_path);

    // Tách chuỗi thành các khối câu hỏi dựa trên 2 dòng xuống dòng liên tiếp (\n\n)
    // Hoặc chỉ cần \n\n nếu tệp tin được lưu với định dạng Windows (CRLF)
    // Tùy thuộc vào hệ điều hành, có thể dùng regex cho chắc chắn: /(\r?\n){2,}/
    $question_blocks = preg_split('/(\r?\n){2,}/', $content, -1, PREG_SPLIT_NO_EMPTY);

    // Phân tích từng khối câu hỏi
    foreach ($question_blocks as $block) {
        // Tách khối thành các dòng
        $lines = array_filter(array_map('trim', explode("\n", $block)));
        
        if (count($lines) < 3) { // Phải có ít nhất Tiêu đề, 1 đáp án, và ANSWER
            continue;
        }

        $question_data = [];
        $question_data['question'] = array_shift($lines); // Dòng đầu tiên là nội dung câu hỏi
        $question_data['options'] = [];
        $question_data['answer'] = '';

        foreach ($lines as $line) {
            // Kiểm tra dòng đáp án đúng
            if (strpos($line, 'ANSWER:') === 0) {
                // Tách lấy ký tự đáp án (ví dụ: 'A', 'B')
                $question_data['answer'] = trim(str_replace('ANSWER:', '', $line));
            } else {
                // Các dòng còn lại là lựa chọn
                // Lấy ký tự lựa chọn (ví dụ: 'A')
                $key = strtoupper(substr($line, 0, 1)); 
                // Lấy nội dung lựa chọn
                $value = trim(substr($line, 2)); 
                
                if (ctype_alpha($key) && strlen($key) == 1) {
                    $question_data['options'][$key] = $value;
                }
            }
        }
        
        // Thêm câu hỏi đã parse vào mảng chính
        if (!empty($question_data['question']) && !empty($question_data['options']) && !empty($question_data['answer'])) {
            $questions[] = $question_data;
        }
    }

} else {
    $error_message = "Lỗi: Không tìm thấy tệp tin dữ liệu: " . $file_path;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài Thi Trắc Nghiệm</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .question-block { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .question-text { font-weight: bold; margin-bottom: 10px; color: #333; }
        .option label { display: block; margin: 5px 0; cursor: pointer; }
    </style>
</head>
<body>

    <h1>Bài Thi Trắc Nghiệm Đọc từ Tệp</h1>
    <hr>

    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php else: ?>

        <form method="post" action="submit_quiz.php"> <?php foreach ($questions as $index => $q): ?>
                <div class="question-block">
                    <p class="question-text"><?php echo ($index + 1) . ". " . htmlspecialchars($q['question']); ?></p>
                    
                    <?php foreach ($q['options'] as $key => $option_text): ?>
                        <div class="option">
                            <input 
                                type="radio" 
                                id="q<?php echo $index . $key; ?>" 
                                name="answer_<?php echo $index; ?>" 
                                value="<?php echo $key; ?>"
                                required
                            >
                            <label for="q<?php echo $index . $key; ?>">
                                <strong><?php echo htmlspecialchars($key); ?>.</strong> <?php echo htmlspecialchars($option_text); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                    
                </div>
            <?php endforeach; ?>

            <?php if (!empty($questions)): ?>
                <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    Hoàn thành bài thi
                </button>
            <?php else: ?>
                <p>Không có câu hỏi nào được tải.</p>
            <?php endif; ?>
            
        </form>
    
    <?php endif; ?>

</body>
</html>