{{-- Reusable Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark border-danger">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-white" id="deleteModalLabel">
                    <i class="mdi mdi-alert-circle text-danger"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-white">
                <div class="text-center mb-3">
                    <i class="mdi mdi-delete-forever text-danger" style="font-size: 48px;"></i>
                </div>
                <p class="text-center mb-3" id="deleteMessage">
                    Apakah Anda yakin ingin menghapus data ini?
                </p>
                <div class="alert alert-warning">
                    <i class="mdi mdi-alert"></i> 
                    <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan!
                </div>
            </div>
            <div class="modal-footer border-danger">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="mdi mdi-close"></i> Batal
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="mdi mdi-delete"></i> Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript for Delete Modal --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    let deleteForm = null;
    
    // Function to show delete modal
    window.showDeleteModal = function(form, message = null) {
        deleteForm = form;
        
        // Set custom message if provided
        if (message) {
            document.getElementById('deleteMessage').textContent = message;
        } else {
            document.getElementById('deleteMessage').textContent = 'Apakah Anda yakin ingin menghapus data ini?';
        }
        
        // Show modal
        $('#deleteModal').modal('show');
    };
    
    // Handle confirm delete button click
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (deleteForm) {
            deleteForm.submit();
        }
        $('#deleteModal').modal('hide');
    });
    
    // Reset form when modal is hidden
    $('#deleteModal').on('hidden.bs.modal', function() {
        deleteForm = null;
        document.getElementById('deleteMessage').textContent = 'Apakah Anda yakin ingin menghapus data ini?';
    });
});
</script>