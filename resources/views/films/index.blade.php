@extends('layouts.app')
@section('title', 'Daftar Film')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Daftar Film</h2>
            <button class="btn btn-primary mb-3" id="addFilmBtn">
                <i class="fas fa-plus"></i> Tambah Film
            </button>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="filmsTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Sutradara</th>
                            <th>Genre</th>
                            <th>Tanggal Rilis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($films as $index => $film)
                        <tr data-id="{{ $film->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $film->judul }}</td>
                            <td>{{ $film->sutradara }}</td>
                            <td>{{ $film->genere }}</td>
                            <td>{{ \Carbon\Carbon::parse($film->tanggal_rilis)->format('d/m/Y') }}</td>
                            <td>
                                <button class="btn btn-sm btn-info showBtn" title="Lihat Detail">
                                    detail
                                </button>
                                <button class="btn btn-sm btn-warning editBtn" title="Edit">
                                    edit
                                </button>
                                <button class="btn btn-sm btn-danger deleteBtn" title="Hapus">
                                    hapus
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr id="emptyRow">
                            <td colspan="6" class="text-center text-muted">Tidak ada film ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('films.modal')
@include('films.show-modal')
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    let filmCounter = {{ count($films) }};
    
    // Show Modal for Add
    $('#addFilmBtn').click(function(){
        $('#filmForm')[0].reset();
        $('#filmId').val('');
        $('#filmModalLabel').text('Tambah Film Baru');
        $('#submitBtn').text('Simpan');
        var myModal = new bootstrap.Modal(document.getElementById('filmModal'));
        myModal.show();
    });
   
    // Show Detail
    $(document).on('click', '.showBtn', function(){
        let id = $(this).closest('tr').data('id');
        
        $.get('/films/' + id, function(film){
            $('#showJudul').text(film.judul);
            $('#showSutradara').text(film.sutradara);
            $('#showGenere').text(film.genere);
            $('#showTanggalRilis').text(formatDate(film.tanggal_rilis));
            $('#showSinopsis').text(film.sinopsis || 'Tidak ada sinopsis');
            
            var showModal = new bootstrap.Modal(document.getElementById('showModal'));
            showModal.show();
        }).fail(function() {
            showAlert('danger', 'Error loading film data');
        });
    });
   
    // Edit
    $(document).on('click', '.editBtn', function(){
        let id = $(this).closest('tr').data('id');
        $('#filmModalLabel').text('Edit Film');
        $('#submitBtn').text('Update');
        
        $.get('/films/' + id + '/edit', function(film){
            $('#judul').val(film.judul);
            $('#sutradara').val(film.sutradara);
            $('#genere').val(film.genere);
            $('#tanggal_rilis').val(film.tanggal_rilis);
            $('#sinopsis').val(film.sinopsis);
            $('#filmId').val(film.id);
            
            var myModal = new bootstrap.Modal(document.getElementById('filmModal'));
            myModal.show();
        }).fail(function() {
            showAlert('danger', 'Error loading film data');
        });
    });
   
    // Save/Update
    $('#filmForm').submit(function(e){
        e.preventDefault();
        let id = $('#filmId').val();
        let method = id ? 'PUT' : 'POST';
        let url = id ? '/films/' + id : '/films';
        let formData = $(this).serialize();
        
        // Disable submit button
        let submitBtn = $('#submitBtn');
        let originalText = submitBtn.text();
        submitBtn.prop('disabled', true).text('Menyimpan...');
       
        $.ajax({
            url: url,
            type: method,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                // Hide modal
                var myModal = bootstrap.Modal.getInstance(document.getElementById('filmModal'));
                myModal.hide();
                
                // Update table
                if (id) {
                    updateTableRow(id, response.film);
                } else {
                    addNewTableRow(response.film);
                }
                
                showAlert('success', response.message);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                let errorMsg = 'Error: ';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg += xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    errorMsg += Object.values(errors).flat().join(', ');
                } else {
                    errorMsg += error;
                }
                showAlert('danger', errorMsg);
            },
            complete: function() {
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
    });
   
    // Delete
    $(document).on('click', '.deleteBtn', function(){
        if (confirm("Apakah Anda yakin ingin menghapus film ini?")) {
            let id = $(this).closest('tr').data('id');
            let row = $(this).closest('tr');
            
            $.ajax({
                url: '/films/' + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    row.fadeOut(300, function() {
                        $(this).remove();
                        updateRowNumbers();
                        checkEmptyTable();
                    });
                    showAlert('success', response.message);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    showAlert('danger', 'Error menghapus film: ' + error);
                }
            });
        }
    });
    
    // Helper Functions
    function updateTableRow(id, film) {
        let row = $('tr[data-id="' + id + '"]');
        row.find('td:eq(1)').text(film.judul);
        row.find('td:eq(2)').text(film.sutradara);
        row.find('td:eq(3)').text(film.genere);
        row.find('td:eq(4)').text(formatDate(film.tanggal_rilis));
        
        row.addClass('table-success');
        setTimeout(function() {
            row.removeClass('table-success');
        }, 2000);
    }
    
    function addNewTableRow(film) {
        // Remove empty row if exists
        $('#emptyRow').remove();
        
        filmCounter++;
        let newRow = `
            <tr data-id="${film.id}" class="table-success">
                <td>${filmCounter}</td>
                <td>${film.judul}</td>
                <td>${film.sutradara}</td>
                <td>${film.genere}</td>
                <td>${formatDate(film.tanggal_rilis)}</td>
                <td>
                    <button class="btn btn-sm btn-info showBtn" title="Lihat Detail">
                        detail
                    </button>
                    <button class="btn btn-sm btn-warning editBtn" title="Edit">
                        edit
                    </button>
                    <button class="btn btn-sm btn-danger deleteBtn" title="Hapus">
                       hapus
                    </button>
                </td>
            </tr>
        `;
        
        $('#filmsTable tbody').append(newRow);
        
        setTimeout(function() {
            $('tr[data-id="' + film.id + '"]').removeClass('table-success');
        }, 2000);
    }
    
    function updateRowNumbers() {
        $('#filmsTable tbody tr').each(function(index) {
            if (!$(this).attr('id') || $(this).attr('id') !== 'emptyRow') {
                $(this).find('td:first').text(index + 1);
            }
        });
        filmCounter = $('#filmsTable tbody tr').length;
    }
    
    function checkEmptyTable() {
        if ($('#filmsTable tbody tr').length === 0) {
            $('#filmsTable tbody').append(`
                <tr id="emptyRow">
                    <td colspan="6" class="text-center text-muted">Tidak ada film ditemukan</td>
                </tr>
            `);
            filmCounter = 0;
        }
    }
    
    function formatDate(dateString) {
        let date = new Date(dateString);
        return date.toLocaleDateString('id-ID');
    }
    
    function showAlert(type, message) {
        $('.alert').remove();
        
        let alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        $('.container .row .col-md-12 h2').after(alertHtml);
        
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 4000);
    }
});
</script>
@endsection