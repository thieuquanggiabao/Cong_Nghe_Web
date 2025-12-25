@foreach($danhSachSV as $sv)
                    <tr>
                        <td>{{ $sv->id }}</td>
                        <td>{{ $sv->ten_sinh_vien }}</td>
                        <td>{{ $sv->email }}</td>
                    </tr>
@endforeach