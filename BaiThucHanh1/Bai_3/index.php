<?php
// Tên tệp tin CSV
$file_path = '65HTTT_Danh_sach_diem_danh.csv';

$data = []; // Mảng chứa toàn bộ dữ liệu từ CSV
$error_message = '';

// Kiểm tra xem tệp tin có tồn tại không
if (file_exists($file_path)) {
    // Mở tệp tin ở chế độ đọc ('r')
    if (($handle = fopen($file_path, "r")) !== FALSE) {
        
        // Cần xử lý mã hóa UTF-8 cho file CSV có tiếng Việt
        // Thêm đoạn code này để PHP hiểu tiếng Việt trong file CSV
        if (fseek($handle, 0) === 0) {
            $bom = fread($handle, 3);
            if ($bom !== "\xef\xbb\xbf") { // Kiểm tra BOM (Byte Order Mark)
                // Nếu không có BOM, tua lại về đầu file
                fseek($handle, 0); 
            }
        }
        
        // Đọc từng hàng trong tệp CSV
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Thêm hàng đã đọc vào mảng dữ liệu
            $data[] = $row;
        }
        
        // Đóng tệp tin
        fclose($handle);
        
    } else {
        $error_message = "Lỗi: Không thể mở tệp tin " . $file_path;
    }
} else {
    $error_message = "Lỗi: Không tìm thấy tệp tin " . $file_path;
}

// Hàng đầu tiên thường là tiêu đề (header)
$headers = !empty($data) ? array_shift($data) : [];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hiển Thị Danh Sách Tài Khoản CSV</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>

    <h1>Danh Sách Tài Khoản (Đọc từ CSV)</h1>
    <hr>

    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php elseif (empty($data)): ?>
        <p>Tệp tin CSV rỗng hoặc chỉ có tiêu đề.</p>
    <?php else: ?>

        <table>
            <thead>
                <tr>
                    <?php foreach ($headers as $header): ?>
                        <th><?php echo htmlspecialchars($header); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <?php foreach ($row as $cell): ?>
                            <td><?php echo htmlspecialchars($cell); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p style="margin-top: 20px;">Đã đọc và hiển thị thành công **<?php echo count($data); ?>** bản ghi.</p>

    <?php endif; ?>

</body>
</html>