@extends('layouts.app')
@section('title', 'Daftar Film')
@section('content')


   <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="fas fa-sticky-note text-primary me-2"></i>
                        Manajemen Catatan
                    </h1>
                    <button type="button" class="btn btn-primary" onclick="openCreateModal()">
                        <i class="fas fa-plus me-1"></i>
                        Tambah Catatan
                    </button>
                </div>

                <!-- Notes Grid -->
                <div class="row" id="notesContainer">
                    <!-- Notes will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noteModalLabel">Tambah Catatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="noteForm">
                    <div class="modal-body">
                        <input type="hidden" id="noteId" name="note_id">
                        
                        <div class="mb-3">
                            <label for="noteTitle" class="form-label">Judul Catatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="noteTitle" name="title" placeholder="Masukkan judul catatan">
                            <div class="invalid-feedback" id="titleError"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="noteContent" class="form-label">Isi Catatan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="noteContent" name="content" rows="8" placeholder="Masukkan isi catatan..."></textarea>
                            <div class="invalid-feedback" id="contentError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save me-1"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Show Modal -->
    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showModalLabel">Detail Catatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul:</label>
                        <div id="showTitle" class="form-control-plaintext"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Isi Catatan:</label>
                        <div id="showContent" class="form-control-plaintext" style="white-space: pre-wrap;"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Dibuat:</label>
                            <div id="showCreatedAt" class="form-control-plaintext note-date"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Diperbarui:</label>
                            <div id="showUpdatedAt" class="form-control-plaintext note-date"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
 
@endsection

@section('scripts')
   <script>
        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Global Variables
        let noteModal, showModal;
        let isEditing = false;
        let currentNoteId = null;

        // Initialize
        $(document).ready(function() {
            noteModal = new bootstrap.Modal(document.getElementById('noteModal'));
            showModal = new bootstrap.Modal(document.getElementById('showModal'));
            
            loadNotes();
            
            // Form submit handler
            $('#noteForm').on('submit', handleSubmit);
            
            // Modal event handlers untuk cleanup
            $('#noteModal').on('hidden.bs.modal', function () {
                // Reset form ketika modal ditutup
                $('#noteForm')[0].reset();
                clearValidationErrors();
                isEditing = false;
                currentNoteId = null;
            });
        });

        // Load Notes
        function loadNotes() {
            showLoading(true);
            
            $.ajax({
                url: '{{ route("notes.index") }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        displayNotes(response.data);
                    } else {
                        showAlert('error', 'Gagal', response.message);
                    }
                },
                error: function(xhr) {
                    console.error('Error loading notes:', xhr);
                    showAlert('error', 'Error', 'Gagal memuat data catatan');
                },
                complete: function() {
                    showLoading(false);
                }
            });
        }

        // Display Notes
        function displayNotes(notes) {
            const container = $('#notesContainer');
            
            if (notes.length === 0) {
                container.html(`
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-sticky-note fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Belum ada catatan</h4>
                            <p class="text-muted">Mulai dengan menambahkan catatan pertama Anda</p>
                            <button type="button" class="btn btn-primary" onclick="openCreateModal()">
                                <i class="fas fa-plus me-1"></i>
                                Tambah Catatan
                            </button>
                        </div>
                    </div>
                `);
                return;
            }

            let html = '';
            notes.forEach(note => {
                const createdAt = new Date(note.created_at).toLocaleDateString('id-ID');
                const content = note.content.length > 150 ? 
                    note.content.substring(0, 150) + '...' : 
                    note.content;

                html += `
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card note-card h-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-2">${escapeHtml(note.title)}</h5>
                                <p class="card-text note-content flex-grow-1">${escapeHtml(content)}</p>
                                <small class="text-muted note-date mb-3">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    ${createdAt}
                                </small>
                                <div class="mt-auto">
                                    <button type="button" class="btn btn-outline-primary btn-sm btn-action" 
                                            onclick="showNote(${note.id})" title="Lihat Detail">
                                       detail
                                    </button>
                                    <button type="button" class="btn btn-outline-warning btn-sm btn-action" 
                                            onclick="editNote(${note.id})" title="Edit">
                                       edit
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-action" 
                                            onclick="deleteNote(${note.id})" title="Hapus">
                                        hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.html(html);
        }

        // Open Create Modal
        function openCreateModal() {
            isEditing = false;
            currentNoteId = null;
            
            $('#noteModalLabel').text('Tambah Catatan');
            $('#submitBtn').html('<i class="fas fa-save me-1"></i> Simpan');
            
            // Reset form
            $('#noteForm')[0].reset();
            $('#noteId').val('');
            clearValidationErrors();
            
            noteModal.show();
        }

        // Show Note
        function showNote(id) {
            showLoading(true);
            
            $.ajax({
                url: `{{ url('notes') }}/${id}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const note = response.data;
                        
                        $('#showTitle').text(note.title);
                        $('#showContent').text(note.content);
                        $('#showCreatedAt').text(formatDateTime(note.created_at));
                        $('#showUpdatedAt').text(formatDateTime(note.updated_at));
                        
                        showModal.show();
                    } else {
                        showAlert('error', 'Gagal', response.message);
                    }
                },
                error: function(xhr) {
                    console.error('Error showing note:', xhr);
                    showAlert('error', 'Error', 'Gagal menampilkan detail catatan');
                },
                complete: function() {
                    showLoading(false);
                }
            });
        }

        // Edit Note
        function editNote(id) {
            showLoading(true);
            
            $.ajax({
                url: `{{ url('notes') }}/${id}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const note = response.data;
                        
                        isEditing = true;
                        currentNoteId = id;
                        
                        $('#noteModalLabel').text('Edit Catatan');
                        $('#submitBtn').html('<i class="fas fa-save me-1"></i> Perbarui');
                        
                        // Fill form
                        $('#noteId').val(note.id);
                        $('#noteTitle').val(note.title);
                        $('#noteContent').val(note.content);
                        
                        clearValidationErrors();
                        noteModal.show();
                    } else {
                        showAlert('error', 'Gagal', response.message);
                    }
                },
                error: function(xhr) {
                    console.error('Error loading note for edit:', xhr);
                    showAlert('error', 'Error', 'Gagal memuat data catatan');
                },
                complete: function() {
                    showLoading(false);
                }
            });
        }

        // Delete Note
        function deleteNote(id) {
            Swal.fire({
                title: 'Hapus Catatan?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    performDelete(id);
                }
            });
        }

        // Perform Delete
        function performDelete(id) {
            showLoading(true);
            
            $.ajax({
                url: `{{ url('notes') }}/${id}`,
                type: 'DELETE',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Berhasil', 'Catatan berhasil dihapus');
                        loadNotes(); // Reload data setelah berhasil hapus
                    } else {
                        showAlert('error', 'Gagal', response.message || 'Gagal menghapus catatan');
                    }
                },
                error: function(xhr) {
                    console.error('Error deleting note:', xhr);
                    showAlert('error', 'Error', 'Gagal menghapus catatan');
                },
                complete: function() {
                    showLoading(false);
                }
            });
        }

        // Handle Form Submit
       function handleSubmit(e) {
    e.preventDefault();
    
    const formData = {
        title: $('#noteTitle').val().trim(),
        content: $('#noteContent').val().trim()
    };
    
    clearValidationErrors();
    
    const url = isEditing ? 
        `{{ url('notes') }}/${currentNoteId}` : 
        '{{ route("notes.store") }}';
    
    const method = isEditing ? 'PUT' : 'POST';
    
    showLoading(true);
    $('#submitBtn').prop('disabled', true);
    
    // Konfigurasi AJAX yang lebih baik
    const ajaxConfig = {
        url: url,
        type: method,
        data: formData, // Selalu gunakan formData biasa (bukan JSON.stringify)
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', 'Berhasil', response.message);
                noteModal.hide(); // Tutup modal langsung
                loadNotes(); // Langsung reload data
            } else {
                showAlert('error', 'Gagal', response.message);
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                displayValidationErrors(errors);
            } else {
                console.error('Error saving note:', xhr);
                showAlert('error', 'Error', 'Gagal menyimpan catatan');
            }
        },
        complete: function() {
            showLoading(false);
            $('#submitBtn').prop('disabled', false);
        }
    };

    // Jika method PUT, tambahkan _method field untuk Laravel
    if (method === 'PUT') {
        formData._method = 'PUT';
    }
    
    $.ajax(ajaxConfig);
}

        // Display Validation Errors
        function displayValidationErrors(errors) {
            if (errors.title) {
                $('#noteTitle').addClass('is-invalid');
                $('#titleError').text(errors.title[0]);
            }
            
            if (errors.content) {
                $('#noteContent').addClass('is-invalid');
                $('#contentError').text(errors.content[0]);
            }
        }

        // Clear Validation Errors
        function clearValidationErrors() {
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');
        }

        // Utility Functions
        function showLoading(show) {
            if (show) {
                $('#loadingOverlay').css('display', 'flex');
            } else {
                $('#loadingOverlay').hide();
            }
        }

        function showAlert(icon, title, text) {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                timer: 3000,
                showConfirmButton: false
            });
        }

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        function formatDateTime(dateString) {
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }
    </script>
@endsection