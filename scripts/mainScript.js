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

var $btns = $('.note-link').click(function() {
    if (this.id == 'all-category') {
      var $el = $('.' + this.id).fadeIn();
      $('#note-full-container > div').not($el).hide();
    } if (this.id == 'important') {
      var $el = $('.' + this.id).fadeIn();
      $('#note-full-container > div').not($el).hide();
    } else {
      var $el = $('.' + this.id).fadeIn();
      $('#note-full-container > div').not($el).hide();
    }
    $btns.removeClass('active');
    $(this).addClass('active');  
});