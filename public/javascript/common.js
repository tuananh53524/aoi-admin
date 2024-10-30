function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        // Submit the delete form if confirmed
        document.getElementById(`delete-form-${id}`).submit();
    }
}