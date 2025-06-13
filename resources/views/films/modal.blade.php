<div class="modal fade" id="filmModal" tabindex="-1" aria-labelledby="filmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="filmForm">
                @csrf
                <input type="hidden" id="filmId" name="id">
                <div class="modal-header">
                    <h5 class="modal-title" id="filmModalLabel">Form Film</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Film <span class="text-danger">*</span></label>
                                <input type="text" name="judul" id="judul" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sutradara" class="form-label">Sutradara <span class="text-danger">*</span></label>
                                <input type="text" name="sutradara" id="sutradara" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="genere" class="form-label">Genre <span class="text-danger">*</span></label>
                                <input type="text" name="genere" id="genere" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_rilis" class="form-label">Tanggal Rilis <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_rilis" id="tanggal_rilis" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="sinopsis" class="form-label">Sinopsis</label>
                        <textarea name="sinopsis" id="sinopsis" class="form-control" rows="4" placeholder="Masukkan sinopsis film (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="submitBtn">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>