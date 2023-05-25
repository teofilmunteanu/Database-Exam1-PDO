$(function () {
    $('#add-notes').on('click', function (event) {
        $('#addnotesmodal').modal('show');
        $('#btn-n-save').hide();
        $('#btn-n-add').show();
    });

    $('#addnotesmodal').on('hidden.bs.modal', function (event) {
        event.preventDefault();
        document.getElementById('note-has-title').value = '';
        document.getElementById('note-has-description').value = '';
    });

    removeNote();
    favouriteNote();
    addLabelGroups();

    $('#btn-n-add').attr('disabled', 'disabled');
});
