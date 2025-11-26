<?php
// admin_view.php - Đã thêm cột Thao tác (Sửa/Xóa)

// Yêu cầu file chứa dữ liệu
require 'data_list.php'; 

// --- Bổ sung: Gán ID tạm thời cho mỗi hoa (Cần thiết cho nút Sửa/Xóa) ---
$flowers_with_id = [];
$temp_id = 1;
if (!empty($flowers)) {
    foreach ($flowers as $flower) {
        // Gán ID tạm thời trước khi thêm vào mảng mới
        $flower['id'] = $temp_id++; 
        $flowers_with_id[] = $flower;
    }
}
// -----------------------------------------------------------------------
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh Sách Hoa (Quản trị)</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .image-cell img { width: 80px; height: auto; display: block; }
        /* Style cho các nút hoạt động */
        .action-links a { margin-right: 10px; text-decoration: none; font-weight: bold; }
        .action-links .edit { color: blue; }
        .action-links .delete { color: red; }
    </style>
</head>
<body>

    <h2>Danh sách các loài hoa (Người quản trị)</h2>

    <?php if(!empty($flowers_with_id)): ?>
        
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên Hoa</th>
                    <th>Mô tả</th>
                    <th>Hình ảnh</th>
                    <th>Hoạt động</th> </tr>
            </thead>
            
            <tbody>
            
            <?php $stt = 1; // Khởi tạo biến STT ?>
            <?php foreach ($flowers_with_id as $flower): ?>
                
                <tr>
                    <td><?php echo $stt++; ?></td> 
                    <td><?php echo htmlspecialchars($flower['Ten_Hoa']); ?></td>
                    <td><?php echo htmlspecialchars($flower['Mo_ta']); ?></td>
                    <td class="image-cell">
                        <img 
                            src="<?php echo htmlspecialchars($flower['Hinh_anh']); ?>" 
                            alt="<?php echo htmlspecialchars($flower['Ten_Hoa']); ?>"
                        >
                    </td>
                    
                    <td class="action-links">
                        <a href="admin_edit.php?id=<?php echo htmlspecialchars($flower['id']); ?>" class="edit">Sửa</a>
                        
                        <a href="admin_delete.php?id=<?php echo htmlspecialchars($flower['id']); ?>" 
                           onclick="return confirm('Xác nhận xóa <?php echo htmlspecialchars($flower['Ten_Hoa']); ?>?');"
                           class="delete">Xóa</a>
                    </td>
                    
                </tr>
                
            <?php endforeach; ?>
            
            </tbody>
        </table>

    <?php else: ?>
        <p>Danh sách rỗng</p>
    <?php endif; ?>
</body>
</html>