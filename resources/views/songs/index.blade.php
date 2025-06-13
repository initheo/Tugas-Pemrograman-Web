@extends('layouts.app')
@section('title', 'Song List')
@section('content')
<div class="container">
    <h2>Song List</h2>
    <button class="btn btn-primary mb-3" id="addSongBtn">Add Song</button>
    <table class="table table-bordered" id="songsTable">
        <thead>
            <tr>
                <th>Title</th><th>Artist</th><th>Release Date</th><th>Genre</th><th>Duration</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($songs as $song)
            <tr data-id="{{ $song->id }}">
                <td>{{ $song->title }}</td>
                <td>{{ $song->artist }}</td>
                <td>{{ $song->release_date }}</td>
                <td>{{ $song->genre }}</td>
                <td>{{ $song->duration }}</td>
                <td>
                    <button class="btn btn-sm btn-warning editBtn">Edit</button>
                    <button class="btn btn-sm btn-danger deleteBtn">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('songs.modal')
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    // Show Modal for Add
    $('#addSongBtn').click(function(){
        $('#songForm')[0].reset();
        $('#songId').val('');
        $('#songModalLabel').text('Add New Song');
        var myModal = new bootstrap.Modal(document.getElementById('songModal'));
        myModal.show();
    });
   
    // Edit - Use event delegation for dynamically loaded content
    $(document).on('click', '.editBtn', function(){
        let id = $(this).closest('tr').data('id');
        $('#songModalLabel').text('Edit Song');
        
        $.get('/songs/' + id + '/edit', function(song){
            $('#title').val(song.title);
            $('#artist').val(song.artist);
            $('#release_date').val(song.release_date);
            $('#genre').val(song.genre);
            $('#lyrics').val(song.lyrics);
            $('#duration').val(song.duration);
            $('#songId').val(song.id);
            
            var myModal = new bootstrap.Modal(document.getElementById('songModal'));
            myModal.show();
        }).fail(function() {
            alert('Error loading song data');
        });
    });
   
    // Save - WITHOUT REFRESH
    $('#songForm').submit(function(e){
        e.preventDefault();
        let id = $('#songId').val();
        let method = id ? 'PUT' : 'POST';
        let url = id ? '/songs/' + id : '/songs';
        let formData = $(this).serialize();
        
        // Disable submit button to prevent double submission
        let submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).text('Saving...');
       
        $.ajax({
            url: url,
            type: method,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                // Hide modal
                var myModal = bootstrap.Modal.getInstance(document.getElementById('songModal'));
                myModal.hide();
                
                // Update table without refresh
                if (id) {
                    // Update existing row
                    updateTableRow(id, response.song);
                } else {
                    // Add new row
                    addNewTableRow(response.song);
                }
                
                // Show success message
                showAlert('success', id ? 'Song updated successfully!' : 'Song added successfully!');
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                let errorMsg = 'Error: ';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg += xhr.responseJSON.message;
                } else {
                    errorMsg += error;
                }
                showAlert('danger', errorMsg);
            },
            complete: function() {
                // Re-enable submit button
                submitBtn.prop('disabled', false).text('Save');
            }
        });
    });
   
    // Delete - WITHOUT REFRESH
    $(document).on('click', '.deleteBtn', function(){
        if (confirm("Are you sure you want to delete this song?")) {
            let id = $(this).closest('tr').data('id');
            let row = $(this).closest('tr');
            
            $.ajax({
                url: '/songs/' + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    // Remove row from table with animation
                    row.fadeOut(300, function() {
                        $(this).remove();
                        checkEmptyTable();
                    });
                    showAlert('success', 'Song deleted successfully!');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    showAlert('danger', 'Error deleting song: ' + error);
                }
            });
        }
    });
    
    // Function to update existing table row
    function updateTableRow(id, song) {
        let row = $('tr[data-id="' + id + '"]');
        row.find('td:eq(0)').text(song.title);
        row.find('td:eq(1)').text(song.artist);
        row.find('td:eq(2)').text(song.release_date);
        row.find('td:eq(3)').text(song.genre);
        row.find('td:eq(4)').text(song.duration);
        
        // Add highlight effect
        row.addClass('table-success');
        setTimeout(function() {
            row.removeClass('table-success');
        }, 2000);
    }
    
    // Function to add new table row
    function addNewTableRow(song) {
        let newRow = `
            <tr data-id="${song.id}" class="table-success">
                <td>${song.title}</td>
                <td>${song.artist}</td>
                <td>${song.release_date}</td>
                <td>${song.genre}</td>
                <td>${song.duration}</td>
                <td>
                    <button class="btn btn-sm btn-warning editBtn">Edit</button>
                    <button class="btn btn-sm btn-danger deleteBtn">Delete</button>
                </td>
            </tr>
        `;
        
        $('#songsTable tbody').append(newRow);
        
        // Remove highlight after 2 seconds
        setTimeout(function() {
            $('tr[data-id="' + song.id + '"]').removeClass('table-success');
        }, 2000);
    }
    
    // Function to check if table is empty
    function checkEmptyTable() {
        if ($('#songsTable tbody tr').length === 0) {
            $('#songsTable tbody').append(`
                <tr>
                    <td colspan="6" class="text-center text-muted">No songs found</td>
                </tr>
            `);
        }
    }
    
    // Function to show alert messages
    function showAlert(type, message) {
        // Remove existing alerts
        $('.alert').remove();
        
        let alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        $('.container h2').after(alertHtml);
        
        // Auto dismiss after 3 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 3000);
    }
});
</script>
@endsection
