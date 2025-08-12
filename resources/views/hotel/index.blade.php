@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Data Hotel</h1>
    <div class="ml-auto">
        <button class="btn btn-primary" data-toggle="modal" data-target="#createHotelModal"><i class="fa fa-plus"></i> Tambah Hotel</button>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-bordered" id="hotelTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Hotel</th>
                    <th>Alamat</th>
                    <th>Harga</th>
                    <th>Rating</th>
                    <th>Fasilitas</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@include('hotel.create', ['hotel' => null])
@include('hotel.edit')

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const table = $('#hotelTable').DataTable({
            ajax: "{{ route('hotel.getData') }}"
            , columns: [{
                    data: 'no'
                }
                , {
                    data: 'nama_hotel'
                }
                , {
                    data: 'alamat'
                }
                , {
                    data: 'harga'
                }
                , {
                    data: 'rating'
                }
                , {
                    data: 'fasilitas'
                }
                , {
                    data: 'deskripsi'
                }
                , {
                    data: 'gambar'
                }
                , {
                    data: 'id'
                    , render: function(data, type, row) {
                        return `
                        <button class="btn btn-warning btn-sm editBtn" data-id="${data}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="/hotel/${data}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus hotel ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    `;
                    }
                }
            ]
        });

        // Tombol edit AJAX
        $('#hotelTable').on('click', '.editBtn', function() {
            const id = $(this).data('id');
            $.ajax({
                url: '/hotel/getHotelData/' + id,
                type: 'GET',
                success: function(data) {
                    $('#edit_id').val(data.id);
                    $('#edit_nama_hotel').val(data.nama_hotel);
                    $('#edit_alamat').val(data.alamat);
                    $('#edit_rating').val(data.rating);
                    $('#edit_fasilitas').val(data.fasilitas);
                    $('#edit_harga').val(data.harga);
                    $('#edit_deskripsi').val(data.deskripsi);

                    $('#edit_image_preview').html('');
                    if (data.images && data.images.length > 0) {
                        data.images.forEach(function(image) {
                            $('#edit_image_preview').append(`<img src="/storage/${image.path}" width="100" class="img-thumbnail">`);
                        });
                    }

                    const formAction = '/hotels/' + id;
                    console.log('Setting form action to:', formAction); // Debug log
                    $('#editHotelForm').attr('action', formAction);
                    $('#editHotelModal').modal('show');
                }
            });
        });

        // Handle form submission via AJAX
        $('#editHotelForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            const form = $(this);
            const formData = new FormData(form[0]); // Get form data including files
            const url = form.attr('action');

            console.log('Submitting form via AJAX. URL:', url, 'Data:', formData); // Debug log

            $.ajax({
                url: url,
                type: 'POST', // Use POST for form submission with _method=PUT
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('AJAX success:', response); // Debug log
                    $('#editHotelModal').modal('hide'); // Hide the modal
                    table.ajax.reload(); // Reload DataTable to show updated data
                    // Optionally, show a success message
                    if (response.message) {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    console.error('AJAX error:', xhr.responseText); // Debug log
                    // Handle errors, e.g., display validation messages
                    alert('Error updating hotel: ' + xhr.responseText);
                }
            });
        });
    });

</script>
@endpush