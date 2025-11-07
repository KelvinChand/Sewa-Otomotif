<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Sewa Kendaraan</title>
</head>
<body class="p-4">
    <div class="container">
        <h2 class='mb-4'>Data Sewa Kendaraan</h2>
        <button id="addBtn" class="btn btn-primary">Tambah Transaksi</button>
        <table id="sewaTable" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Customer</th>
                <th>Nomor Kendaraan</th>
                <th>Tanggal Mulai Sewa</th>
                <th>Tanggal Berakhir Sewa</th>
                <th>Harga Sewa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        </table>
    </div>

    <div class="modal fade" id="sewaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id='sewaForm'>
                    <div class="modal-header">
                        <h5 class="modal-title">Form Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_sewas">
                        <div class="mb-3">
                            <label>Nama Customer</label>
                            <input type="text" id="nama_customer" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Nomor Kendaraan</label>
                            <select id="id_kendaraans" class="form-select" required>
                         <option value="">-- Pilih Kendaraan --</option>
                        </select>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Mulai Sewa</label>
                            <input type="date" id="tanggal_mulai_sewa" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Berakhir Sewa</label>
                            <input type="date" id="tanggal_berakhir_sewa" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Harga Sewa</label>
                            <input type="number" id="harga_sewa" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(function(){
            let table= $('#sewaTable').DataTable({
                processing:true,
                serverSide:true,
                ajax:
                '{{ route('dashboard.data') }}',
                columns:[
                    {data: 'id_sewas'},
                    {data: 'nama_customer'},
                    {data: 'nomor_kendaraan'},
                    {data: 'tanggal_mulai_sewa'},
                    {data: 'tanggal_berakhir_sewa'},
                    {data: 'harga_sewa'},
                    {data: null, render: function(data){
                        console.log(data);
                        return ` <button class='btn btn-warning btn-sm edit' data-id="${data.id_sewas}">Edit</button>
                                <button class='btn btn-danger btn-sm delete' data-id="${data.id_sewas}">Hapus</button>
                         `;
                    }}
                ]
            });

            let modal = new bootstrap.Modal('#sewaModal');

            function loadKendaraanDropdown() {
                $.get('/kendaraan/list', function(data){
                let select = $('#id_kendaraans');
                select.empty().append('<option value="">-- Pilih Kendaraan --</option>');
                 data.forEach(k => {
                    select.append(`<option value="${k.id_kendaraans}">${k.nomor_kendaraan}</option>`);
                });
             });
            }


            $('#addBtn').click(()=> {
                $('#sewaForm')[0].reset();
                $('#id_sewas').val('');
                loadKendaraanDropdown();
                modal.show();
            });

            $('#sewaTable').on('click','.edit', function(){
                let id = $(this).data('id');
                $.get('/sewa/'+ id, function(res){
                    $('#id_sewas').val(res.id_sewas);
                    $('#nama_customer').val(res.nama_customer);
                    $('#tanggal_mulai_sewa').val(res.tanggal_mulai_sewa);
                    $('#tanggal_berakhir_sewa').val(res.tanggal_berakhir_sewa);
                    $('#harga_sewa').val(res.harga_sewa);
                    loadKendaraanDropdown();
                    modal.show();
                })
            });

            $('#sewaForm').submit(function(e){
                e.preventDefault();
                let id = $('#id_sewas').val();
                let url = id ? '/sewa/' + id : '/sewa';
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url:url,
                    method:method,
                    data:{
                        nama_customer:$('#nama_customer').val(),
                        id_kendaraans: $('#id_kendaraans').val(),
                        tanggal_mulai_sewa:$('#tanggal_mulai_sewa').val(),
                        tanggal_berakhir_sewa:$('#tanggal_berakhir_sewa').val(),
                        harga_sewa:$('#harga_sewa').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(){
                        modal.hide();
                        table.ajax.reload();
                    }
                });
            });

            $('#sewaTable').on('click','.delete',function(){
                let id = $(this).data('id');
                if(confirm('Yakin ingin hapus data ini ?')){
                    $.ajax({
                        url:'/sewa/'+id,
                        method: 'DELETE',
                        data:{ _token: '{{ csrf_token() }}'},
                        success: () => table.ajax.reload()
                    });
                }
            });
        });
    </script>
</body>
</html>
