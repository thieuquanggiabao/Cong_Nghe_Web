<?php
// guest_view.php

// Yêu cầu file chứa dữ liệu
require 'data_list.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh Sách Hoa (Khách)</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        ul { list-style: none; padding: 0; }
        li { border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; border-radius: 5px; }
    </style>
</head>
<body>

    <h2>Danh sách các loài hoa (Người dùng khách)</h2>

    <?php if(!empty($flowers)): ?>
        
        <ul> 
        
        <?php foreach ($flowers as $flower): ?>
            
            <li> 
                <strong><?php echo htmlspecialchars($flower['Ten_Hoa']); ?></strong> 
                <br>
                Mô tả: <em><?php echo htmlspecialchars($flower['Mo_ta']); ?></em>
                <br>
                <img 
                    src="<?php echo htmlspecialchars($flower['Hinh_anh']); ?>" 
                    alt="<?php echo htmlspecialchars($flower['Ten_Hoa']); ?>" 
                    style="width: 150px; height: auto; margin-top: 5px;"
                >
                <hr style="margin: 10px 0;">
            </li>
            
        <?php endforeach; ?>
        
        </ul>

    <?php else: ?>
        <p>Danh sách rỗng</p>
    <?php endif; ?>
</body>
</html>