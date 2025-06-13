<div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="bookForm">
                @csrf
                <input type="hidden" id="bookId" name="id">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="bookModalLabel">
                        <i class="fas fa-book"></i> Form Buku
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    <i class="fas fa-heading"></i> Judul Buku <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="title" id="title" class="form-control" required placeholder="Masukkan judul buku">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="author" class="form-label">
                                    <i class="fas fa-user-edit"></i> Penulis <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="author" id="author" class="form-control" required placeholder="Nama penulis">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="publisher" class="form-label">
                                    <i class="fas fa-building"></i> Penerbit <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="publisher" id="publisher" class="form-control" required placeholder="Nama penerbit">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="publication_date" class="form-label">
                                    <i class="fas fa-calendar-alt"></i> Tanggal Terbit <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="publication_date" id="publication_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="isbn" class="form-label">
                                    <i class="fas fa-barcode"></i> ISBN <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="isbn" id="isbn" class="form-control" required placeholder="978-XXXXXXXXXX" maxlength="20">
                                <div class="form-text">Format: 978-XXXXXXXXXX atau format ISBN lainnya</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="submitBtn">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>