@extends('layouts.app')
@section('title', 'Daftar Film')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-book"></i> Manajemen Buku</h2>
                <button class="btn btn-primary" id="addBookBtn">
                    <i class="fas fa-plus"></i> Tambah Buku
                </button>
            </div>
            
 
                    <div class="table-responsive">
                        <table class="table table-bordered" id="booksTable">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="25%">Judul</th>
                                    <th width="20%">Penulis</th>
                                    <th width="20%">Penerbit</th>
                                    <th width="15%">Tanggal Terbit</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($books as $index => $book)
                                <tr data-id="{{ $book->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $book->title }}</strong>
                                        <br><small class="text-muted">ISBN: {{ $book->isbn }}</small>
                                    </td>
                                    <td>{{ $book->author }}</td>
                                    <td>{{ $book->publisher }}</td>
                                    <td>{{ \Carbon\Carbon::parse($book->publication_date)->format('d/m/Y') }}</td>
                                    <td>
                                        
                                            <button class="btn btn-sm btn-info showBtn" title="Lihat Detail" data-bs-toggle="tooltip">
                                                detail
                                            </button>
                                            <button class="btn btn-sm btn-warning editBtn" title="Edit" data-bs-toggle="tooltip">
                                                 edit
                                            </button>
                                            <button class="btn btn-sm btn-danger deleteBtn" title="Hapus" data-bs-toggle="tooltip">
                                                hapus
                                            </button> 

                                    </td>
                                </tr>
                                @empty
                                <tr id="emptyRow">
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-book-open fa-3x mb-3 text-secondary"></i>
                                        <br>Belum ada buku yang tersedia
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div> 

        </div>
    </div>
</div>

@include('books.modal')
@include('books.show-modal')
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    let bookCounter = {{ count($books) }};
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Show Modal for Add
    $('#addBookBtn').click(function(){
        $('#bookForm')[0].reset();
        $('#bookId').val('');
        $('#bookModalLabel').text('Tambah Buku Baru');
        $('#submitBtn').html('<i class="fas fa-save"></i> Simpan');
        var myModal = new bootstrap.Modal(document.getElementById('bookModal'));
        myModal.show();
    });
   
    // Show Detail
    $(document).on('click', '.showBtn', function(){
        let id = $(this).closest('tr').data('id');
        
        $.get('/books/' + id, function(book){
            $('#showTitle').text(book.title);
            $('#showAuthor').text(book.author);
            $('#showPublisher').text(book.publisher);
            $('#showPublicationDate').text(formatDate(book.publication_date));
            $('#showIsbn').text(book.isbn);
            $('#showCreatedAt').text(formatDateTime(book.created_at));
            $('#showUpdatedAt').text(formatDateTime(book.updated_at));
            
            var showModal = new bootstrap.Modal(document.getElementById('showModal'));
            showModal.show();
        }).fail(function() {
            showAlert('danger', 'Error memuat data buku');
        });
    });
   
    // Edit
    $(document).on('click', '.editBtn', function(){
        let id = $(this).closest('tr').data('id');
        $('#bookModalLabel').text('Edit Buku');
        $('#submitBtn').html('<i class="fas fa-save"></i> Update');
        
        $.get('/books/' + id + '/edit', function(book){
            $('#title').val(book.title);
            $('#author').val(book.author);
            $('#publisher').val(book.publisher);
            $('#publication_date').val(book.publication_date);
            $('#isbn').val(book.isbn);
            $('#bookId').val(book.id);
            
            var myModal = new bootstrap.Modal(document.getElementById('bookModal'));
            myModal.show();
        }).fail(function() {
            showAlert('danger', 'Error memuat data buku');
        });
    });
   
    // Save/Update
    $('#bookForm').submit(function(e){
        e.preventDefault();
        let id = $('#bookId').val();
        let method = id ? 'PUT' : 'POST';
        let url = id ? '/books/' + id : '/books';
        let formData = $(this).serialize();
        
        // Disable submit button
        let submitBtn = $('#submitBtn');
        let originalHtml = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
       
        $.ajax({
            url: url,
            type: method,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                // Hide modal
                var myModal = bootstrap.Modal.getInstance(document.getElementById('bookModal'));
                myModal.hide();
                
                // Update table
                if (id) {
                    updateTableRow(id, response.book);
                } else {
                    addNewTableRow(response.book);
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
                submitBtn.prop('disabled', false).html(originalHtml);
            }
        });
    });
   
    // Delete
    $(document).on('click', '.deleteBtn', function(){
        let bookTitle = $(this).closest('tr').find('td:eq(1) strong').text();
        
        if (confirm(`Apakah Anda yakin ingin menghapus buku "${bookTitle}"?`)) {
            let id = $(this).closest('tr').data('id');
            let row = $(this).closest('tr');
            
            $.ajax({
                url: '/books/' + id,
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
                    showAlert('danger', 'Error menghapus buku: ' + error);
                }
            });
        }
    });
    
    // Helper Functions
    function updateTableRow(id, book) {
        let row = $('tr[data-id="' + id + '"]');
        row.find('td:eq(1)').html(`
            <strong>${book.title}</strong>
            <br><small class="text-muted">ISBN: ${book.isbn}</small>
        `);
        row.find('td:eq(2)').text(book.author);
        row.find('td:eq(3)').text(book.publisher);
        row.find('td:eq(4)').text(formatDate(book.publication_date));
        
        row.addClass('table-success');
        setTimeout(function() {
            row.removeClass('table-success');
        }, 2000);
    }
    
    function addNewTableRow(book) {
        // Remove empty row if exists
        $('#emptyRow').remove();
        
        bookCounter++;
        let newRow = `
            <tr data-id="${book.id}" class="table-success">
                <td>${bookCounter}</td>
                <td>
                    <strong>${book.title}</strong>
                    <br><small class="text-muted">ISBN: ${book.isbn}</small>
                </td>
                <td>${book.author}</td>
                <td>${book.publisher}</td>
                <td>${formatDate(book.publication_date)}</td>
                <td>
                     
                        <button class="btn btn-sm btn-info showBtn" title="Lihat Detail" data-bs-toggle="tooltip">
                           detail
                        </button>
                        <button class="btn btn-sm btn-warning editBtn" title="Edit" data-bs-toggle="tooltip">
                            edit
                        </button>
                        <button class="btn btn-sm btn-danger deleteBtn" title="Hapus" data-bs-toggle="tooltip">
                             hapus
                        </button> 
                </td>
            </tr>
        `;
        
        $('#booksTable tbody').append(newRow);
        
        // Reinitialize tooltips for new row
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        setTimeout(function() {
            $('tr[data-id="' + book.id + '"]').removeClass('table-success');
        }, 2000);
    }
    
    function updateRowNumbers() {
        $('#booksTable tbody tr').each(function(index) {
            if (!$(this).attr('id') || $(this).attr('id') !== 'emptyRow') {
                $(this).find('td:first').text(index + 1);
            }
        });
        bookCounter = $('#booksTable tbody tr:not(#emptyRow)').length;
    }
    
    function checkEmptyTable() {
        if ($('#booksTable tbody tr:not(#emptyRow)').length === 0) {
            $('#booksTable tbody').append(`
                <tr id="emptyRow">
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-book-open fa-3x mb-3 text-secondary"></i>
                        <br>Belum ada buku yang tersedia
                    </td>
                </tr>
            `);
            bookCounter = 0;
        }
    }
    
    function formatDate(dateString) {
        let date = new Date(dateString);
        return date.toLocaleDateString('id-ID');
    }
    
    function formatDateTime(dateTimeString) {
        let date = new Date(dateTimeString);
        return date.toLocaleDateString('id-ID') + ' ' + date.toLocaleTimeString('id-ID');
    }
    
    function showAlert(type, message) {
        $('.alert').remove();
        
        let iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
        let alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="fas ${iconClass} me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        $('.container .row .col-md-12 .d-flex').after(alertHtml);
        
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 4000);
    }
});
</script>
@endsection 