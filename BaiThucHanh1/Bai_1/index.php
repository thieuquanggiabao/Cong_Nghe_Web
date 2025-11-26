<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Chủ - Danh Sách Hoa</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            padding: 50px; 
            text-align: center; 
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 30px;
            border-radius: 8px;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            margin: 10px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s;
        }
        .guest-btn {
            background-color: #007bff; /* Màu xanh dương */
        }
        .guest-btn:hover {
            background-color: #0056b3;
        }
        .admin-btn {
            background-color: #28a745; /* Màu xanh lá */
        }
        .admin-btn:hover {
            background-color: #1e7e34;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Chào mừng đến với Danh Sách Hoa!</h1>
        <p>Vui lòng chọn giao diện bạn muốn xem:</p>
        
        <hr>
        
        <a href="guest_view.php" class="btn guest-btn">
            Xem với vai trò Khách
        </a>
        
        <a href="admin_view.php" class="btn admin-btn">
            Xem với vai trò Quản trị
        </a>
        
        <p style="margin-top: 20px; font-size: small; color: #666;">
            * Giao diện Quản trị viên thường yêu cầu đăng nhập thực tế.
        </p>
    </div>

</body>
</html>