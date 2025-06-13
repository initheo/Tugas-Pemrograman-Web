@extends('layouts.app')
@section('title', 'Daftar Hobi')
@section('content')

<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="mb-0">
                    <i class="fas fa-heart me-3"></i>
                    Manajemen Hobi
                </h1>
                <p class="mb-0 mt-2">Kelola data hobi dengan mudah</p>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-primary btn-lg" onclick="showCreateModal()">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Hobi Baru
                </button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Alert Messages -->
    <div id="alertContainer"></div>

    <!-- Data Table -->
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Daftar Hobi</h4>
            <div class="loading" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th width="40%">Nama Hobi</th>
                        <th width="25%">Dibuat</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="hobiTableBody">
                    <!-- Data akan dimuat via AJAX -->
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            <i class="fas fa-spinner fa-spin fa-3x mb-3"></i><br>
                            Memuat data...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Create/Edit -->
<div class="modal fade" id="hobiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Hobi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="hobiForm">
                <div class="modal-body">
                    <input type="hidden" id="hobiId" name="id">
                    
                    <div class="mb-3">
                        <label for="namaHobi" class="form-label">
                            <i class="fas fa-tag me-2"></i>
                            Nama Hobi *
                        </label>
                        <input type="text" class="form-control" id="namaHobi" name="nama" 
                               placeholder="Masukkan nama hobi" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>
                    Detail Hobi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4"><strong>ID:</strong></div>
                    <div class="col-sm-8" id="detailId">-</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4"><strong>Nama Hobi:</strong></div>
                    <div class="col-sm-8" id="detailNama">-</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4"><strong>Dibuat:</strong></div>
                    <div class="col-sm-8" id="detailCreated">-</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4"><strong>Diperbarui:</strong></div>
                    <div class="col-sm-8" id="detailUpdated">-</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-trash me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: invert(1);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Apakah Anda yakin?</h5>
                    <p class="text-muted">Hobi "<span id="deleteItemName"></span>" akan dihapus secara permanen!</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-2"></i>Ya, Hapus!
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // CSRF Token untuk Laravel
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Base URLs menggunakan resource routes
    const baseUrl = '/hobis';
    const apiUrls = {
        index: baseUrl,                    // GET /hobis
        store: baseUrl,                    // POST /hobis
        show: (id) => `${baseUrl}/${id}`,  // GET /hobis/{id}
        update: (id) => `${baseUrl}/${id}`,// PUT /hobis/{id}
        destroy: (id) => `${baseUrl}/${id}`,// DELETE /hobis/{id}
        checkName: `${baseUrl}/check-name` // POST /hobis/check-name
    };

    let currentEditId = null;
    let currentDeleteId = null;

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        loadHobis();
        setupFormSubmission();
    });

    // Load data hobi dari server menggunakan resource route
    async function loadHobis() {
        showLoading(true);
        
        try {
            const response = await fetch(apiUrls.index, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const result = await response.json();
            
            if (result.success) {
                displayHobis(result.data);
            } else {
                showAlert(result.message || 'Gagal memuat data', 'danger');
                displayHobis([]);
            }
            
        } catch (error) {
            console.error('Error loading data:', error);
            showAlert('Gagal memuat data hobi: ' + error.message, 'danger');
            displayHobis([]);
        } finally {
            showLoading(false);
        }
    }

    // Display hobi data in table
    function displayHobis(hobis) {
        const tbody = document.getElementById('hobiTableBody');
        tbody.innerHTML = '';
        
        if (hobis.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-3x mb-3"></i><br>
                        Belum ada data hobi
                    </td>
                </tr>
            `;
        } else {
            hobis.forEach(hobi => {
                const row = createTableRow(hobi);
                tbody.appendChild(row);
            });
        }
    }

    // Create table row
    function createTableRow(hobi) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><span class="badge bg-primary">${hobi.id}</span></td>
            <td><strong>${hobi.nama}</strong></td>
            <td><small class="text-muted">${formatDate(hobi.created_at)}</small></td>
            <td>
                <button class="btn btn-info btn-sm btn-action" onclick="showDetail(${hobi.id})" title="Lihat Detail">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-warning btn-sm btn-action" onclick="showEditModal(${hobi.id})" title="Edit">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-danger btn-sm btn-action" onclick="showDeleteModal(${hobi.id})" title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        return tr;
    }

    // Show loading
    function showLoading(show) {
        document.querySelector('.loading').style.display = show ? 'block' : 'none';
    }

    // Show alert
    function showAlert(message, type = 'success') {
        const alertContainer = document.getElementById('alertContainer');
        const alertId = 'alert-' + Date.now();
        
        alertContainer.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" id="${alertId}">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    }

    // Format date
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        const options = { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        return date.toLocaleDateString('id-ID', options);
    }

    // Show create modal
    function showCreateModal() {
        currentEditId = null;
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus me-2"></i>Tambah Hobi';
        document.getElementById('hobiForm').reset();
        document.getElementById('hobiId').value = '';
        document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save me-2"></i>Simpan';
        
        // Clear validation
        clearValidation();
        
        const modal = new bootstrap.Modal(document.getElementById('hobiModal'));
        modal.show();
    }

    // Show edit modal
    async function showEditModal(id) {
        showLoading(true);
        
        try {
            const response = await fetch(apiUrls.show(id), {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const result = await response.json();
            
            if (result.success) {
                const hobi = result.data;
                currentEditId = id;
                document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Hobi';
                document.getElementById('hobiId').value = hobi.id;
                document.getElementById('namaHobi').value = hobi.nama;
                document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save me-2"></i>Update';
                
                // Clear validation
                clearValidation();
                
                const modal = new bootstrap.Modal(document.getElementById('hobiModal'));
                modal.show();
            } else {
                showAlert(result.message || 'Data hobi tidak ditemukan!', 'danger');
            }
            
        } catch (error) {
            console.error('Error fetching hobi:', error);
            showAlert('Gagal mengambil data hobi: ' + error.message, 'danger');
        } finally {
            showLoading(false);
        }
    }

    // Show detail modal
    async function showDetail(id) {
        showLoading(true);
        
        try {
            const response = await fetch(apiUrls.show(id), {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const result = await response.json();
            
            if (result.success) {
                const hobi = result.data;
                document.getElementById('detailId').textContent = hobi.id;
                document.getElementById('detailNama').textContent = hobi.nama;
                document.getElementById('detailCreated').textContent = formatDate(hobi.created_at);
                document.getElementById('detailUpdated').textContent = formatDate(hobi.updated_at);
                
                const modal = new bootstrap.Modal(document.getElementById('detailModal'));
                modal.show();
            } else {
                showAlert(result.message || 'Data hobi tidak ditemukan!', 'danger');
            }
            
        } catch (error) {
            console.error('Error fetching hobi:', error);
            showAlert('Gagal mengambil data hobi: ' + error.message, 'danger');
        } finally {
            showLoading(false);
        }
    }

    // Show delete modal
    async function showDeleteModal(id) {
        showLoading(true);
        
        try {
            const response = await fetch(apiUrls.show(id), {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const result = await response.json();
            
            if (result.success) {
                currentDeleteId = id;
                document.getElementById('deleteItemName').textContent = result.data.nama;
                
                const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                modal.show();
            } else {
                showAlert(result.message || 'Data hobi tidak ditemukan!', 'danger');
            }
            
        } catch (error) {
            console.error('Error fetching hobi:', error);
            showAlert('Gagal mengambil data hobi: ' + error.message, 'danger');
        } finally {
            showLoading(false);
        }
    }

    // Setup form submission
    function setupFormSubmission() {
        document.getElementById('hobiForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = {
                nama: formData.get('nama').trim()
            };
            
            // Validation
            if (!await validateForm(data)) {
                return;
            }
            
            // Disable submit button
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            
            try {
                if (currentEditId) {
                    await updateHobi(currentEditId, data);
                } else {
                    await createHobi(data);
                }
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('hobiModal'));
                modal.hide();
                
            } catch (error) {
                console.error('Error submitting form:', error);
                showAlert('Terjadi kesalahan saat menyimpan data: ' + error.message, 'danger');
            } finally {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
        
        // Setup delete confirmation
        document.getElementById('confirmDeleteBtn').addEventListener('click', async function() {
            if (currentDeleteId) {
                // Disable delete button
                const deleteBtn = document.getElementById('confirmDeleteBtn');
                const originalText = deleteBtn.innerHTML;
                deleteBtn.disabled = true;
                deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...';
                
                try {
                    await deleteHobi(currentDeleteId);
                } catch (error) {
                    console.error('Error deleting:', error);
                    showAlert('Gagal menghapus data: ' + error.message, 'danger');
                } finally {
                    // Reset button
                    deleteBtn.disabled = false;
                    deleteBtn.innerHTML = originalText;
                }
            }
        });
    }

    // Validate form
    async function validateForm(data) {
        clearValidation();
        let isValid = true;
        
        // Validasi required field
        if (!data.nama || data.nama.length < 2) {
            showFieldError('namaHobi', 'Nama hobi harus diisi minimal 2 karakter');
            isValid = false;
        }
        
        // Validasi duplikat di server
        if (isValid) {
            try {
                const response = await fetch(apiUrls.checkName, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        nama: data.nama,
                        except_id: currentEditId || null
                    })
                });
                
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                
                const result = await response.json();
                
                if (result.exists) {
                    showFieldError('namaHobi', 'Nama hobi sudah ada, gunakan nama lain');
                    isValid = false;
                }
            } catch (error) {
                console.error('Error validating name:', error);
                // Lanjutkan tanpa validasi duplikat jika terjadi error
            }
        }
        
        return isValid;
    }

    // Show field error
    function showFieldError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const feedback = field.nextElementSibling;
        
        field.classList.add('is-invalid');
        feedback.textContent = message;
    }

    // Clear validation
    function clearValidation() {
        const fields = document.querySelectorAll('.form-control');
        fields.forEach(field => {
            field.classList.remove('is-invalid');
            const feedback = field.nextElementSibling;
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.textContent = '';
            }
        });
    }

    // Create hobi
    async function createHobi(data) {
        try {
            const response = await fetch(apiUrls.store, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const result = await response.json();
            
            if (result.success) {
                loadHobis(); // Refresh data
                showAlert(`Hobi "${data.nama}" berhasil ditambahkan!`);
                return true;
            } else {
                showAlert(result.message || 'Gagal menambahkan hobi', 'danger');
                return false;
            }
        } catch (error) {
            console.error('Error creating hobi:', error);
            showAlert('Terjadi kesalahan saat menambahkan hobi: ' + error.message, 'danger');
            throw error;
        }
    }

    // Update hobi
    async function updateHobi(id, data) {
        try {
            const response = await fetch(apiUrls.update(id), {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const result = await response.json();
            
            if (result.success) {
                loadHobis(); // Refresh data
                showAlert(`Hobi "${data.nama}" berhasil diperbarui!`);
                return true;
            } else {
                showAlert(result.message || 'Gagal memperbarui hobi', 'danger');
                return false;
            }
        } catch (error) {
            console.error('Error updating hobi:', error);
            showAlert('Terjadi kesalahan saat memperbarui hobi: ' + error.message, 'danger');
            throw error;
        }
    }

    // Delete hobi
    async function deleteHobi(id) {
        try {
            const response = await fetch(apiUrls.destroy(id), {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const result = await response.json();
            
            if (result.success) {
                loadHobis(); // Refresh data
                showAlert(result.message || 'Hobi berhasil dihapus!', 'success');
                return true;
            } else {
                showAlert(result.message || 'Gagal menghapus hobi', 'danger');
                return false;
            }
        } catch (error) {
            console.error('Error deleting hobi:', error);
            showAlert('Terjadi kesalahan saat menghapus hobi: ' + error.message, 'danger');
            throw error;
        }
    }
</script>
@endsection