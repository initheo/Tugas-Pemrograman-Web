<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="showModalLabel">
                    <i class="fas fa-eye"></i> Detail Buku
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title text-primary" id="showTitle"></h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">
                                                <i class="fas fa-user-edit"></i> Penulis:
                                            </label>
                                            <p id="showAuthor" class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">
                                                <i class="fas fa-building"></i> Penerbit:
                                            </label>
                                            <p id="showPublisher" class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">
                                                <i class="fas fa-calendar-alt"></i> Tanggal Terbit:
                                            </label>
                                            <p id="showPublicationDate" class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">
                                                <i class="fas fa-barcode"></i> ISBN:
                                            </label>
                                            <p id="showIsbn" class="form-control-plaintext border-bottom font-monospace"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Sistem</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label class="form-label fw-bold text-muted small">Dibuat pada:</label>
                                            <p id="showCreatedAt" class="form-control-plaintext small"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label class="form-label fw-bold text-muted small">Terakhir diubah:</label>
                                            <p id="showUpdatedAt" class="form-control-plaintext small"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>