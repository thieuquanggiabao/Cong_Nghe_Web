<form action="{{ route('sinhvien.store') }}" method="POST">
            @csrf 
            <p>
                <label for="ten_sinh_vien">Tên Sinh Viên:</label><br>
                <input type="text" name="ten_sinh_vien" id="ten_sinh_vien" placeholder="Nhập tên..." required>
            </p>

            <p>
                <label for="email">Email:</label><br>
                <input type="email" name="email" id="email" placeholder="Nhập email..." required>
            </p>

            <button type="submit">Lưu thông tin</button>
</form>

