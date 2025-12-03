<?php
// Đọc file Quiz.txt
$filename = "Quiz.txt";
$content = file_get_contents($filename);

// Tách từng block câu hỏi
$blocks = preg_split("/\r?\n\s*\r?\n/", trim($content));

$questions = [];

foreach ($blocks as $block) {
    $lines = array_map('trim', explode("\n", $block));
    $question = $lines[0];

    // Tìm dòng ANSWER
    $answerLineIndex = null;
    foreach ($lines as $i => $l) {
        if (stripos($l, "ANSWER:") === 0) {
            $answerLineIndex = $i;
            break;
        }
    }

    // Lấy danh sách đáp án A,B,C,D,E,...
    $options = [];
    foreach ($lines as $i => $line) {
        if ($i >= 1 && $i < $answerLineIndex) {
            if (preg_match('/^([A-Z])[\.\)\:\-]?\s*(.*)$/', $line, $m)) {
                $letter = strtoupper($m[1]);
                $text   = $m[2];
                $options[$letter] = $text;
            }
        }
    }

    // Lấy đáp án đúng (có thể nhiều đáp án)
    preg_match('/ANSWER:\s*([A-Z](?:\s*,\s*[A-Z])*)/i', $lines[$answerLineIndex], $match);
    $correctList = [];
    if (!empty($match[1])) {
        $correctList = array_map('trim', explode(",", strtoupper($match[1])));
    }

    $questions[] = [
        "question" => $question,
        "options"  => $options,      // ["A"=>"text","B"=>"text",...]
        "correct"  => $correctList   // ["A","C",...]
    ];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Bài thi trắc nghiệm</title>
<style>
body { font-family: Arial; width: 900px; margin: auto; }
.question { border: 1px solid #ccc; padding: 10px; margin: 15px 0; border-radius: 6px; background: #f9f9f9; }
.correct { color: green; font-weight: bold; }
.wrong { color: red; font-weight: bold; }
ul { padding-left: 0; list-style: none; }
</style>
</head>
<body>

<h2>📘 Bài thi trắc nghiệm</h2>

<form method="post">
<?php
$submitted = isset($_POST['submit']);
$score = 0;

foreach ($questions as $index => $q) {
    echo "<div class='question'>";
    echo "<h3>Câu ".($index+1).": " . htmlspecialchars($q['question']) . "</h3>";

    $correctList = $q['correct'];   // ["A","C",...]
    $userAnswers = $_POST["q{$index}"] ?? [];

    echo "<ul>";

    foreach ($q['options'] as $letter => $opt) {
        $isChecked = in_array($letter, $userAnswers);

        $class = "";
        if ($submitted) {
            if (in_array($letter, $correctList)) {
                $class = "correct"; // đúng
            } elseif ($isChecked) {
                $class = "wrong";   // chọn sai
            }
        }

        $valueEscaped = htmlspecialchars($letter, ENT_QUOTES);
        $labelEscaped = htmlspecialchars("$letter. $opt");
        $checkedAttr = $isChecked ? ' checked' : '';

        echo "<li class='$class'>
                <label>
                    <input type='checkbox' name='q{$index}[]' value='{$valueEscaped}'{$checkedAttr}>
                    {$labelEscaped}
                </label>
              </li>";
    }

    if ($submitted) {
        if (!empty($correctList)) {
            echo "<p><strong>Đáp án đúng:</strong> <span class='correct'>" . implode(", ", $correctList) . "</span></p>";

            // tính điểm: đúng nếu chọn đúng 100%
            sort($correctList);
            sort($userAnswers);
            if ($correctList === $userAnswers) {
                $score++;
            }
        } else {
            echo "<p style='color:orange'><strong>Câu này không có đáp án chuẩn.</strong></p>";
        }
    }

    echo "</ul></div>";
}

if ($submitted) {
    echo "<h2>Kết quả: $score / ".count($questions)." câu có đáp án</h2>";
}
?>
<input type="submit" name="submit" value="Nộp bài" style="padding:10px 25px; font-size:16px;">
</form>

</body>
</html>
