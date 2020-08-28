$(document).ready(function () {
    load_data();
    $('#action').val("Insert");
    $("#refresh").click(function () {
        load_data();
    });
    $('#adding').click(function() { //update the "Add" button
        $('#name').val('');
        $('#description').val('');
        $('#price').val('');
        $('#picture').val('');
        $('#my_image').hide();
        $('#button_action').val("Insert");
        $('#action').val("Insert");
    });
    $(document).on('click', '#button_action', function () { // dont show the same image after updating
        $('#my_image').hide();
    });
    function filter(query) {
        var action = "Filter";
        $.ajax({
            url: "action.php",
            method: "POST",
            data: {query: query, action: action},
            success: function (data) {
                $('#user_table').html(data);
            }
        });
    }

    $('#search_text').keyup(function () {
        var search = $(this).val();
        if (search != '') {
            filter(search);
        } else {
            filter();
        }
    });

    function load_data() {
        var action = "Load";
        $.ajax({
            url: "action.php",
            method: "POST",
            data: {action: action},
            success: function (data) {
                $('#user_table').html(data);
            }
        });
    }

    $('#user_form').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "action.php",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (data) {
                alert(data);
                $('#user_form')[0].reset();
            }
        })


    });
    $(document).on('click', '.update', function () {
        var user_id = $(this).attr("id");
        var action = "Fetch";
        $.ajax({
            url: "action.php",
            method: "POST",
            data: {user_id: user_id, action: action},
            dataType: "json",
            success: function (data) {
                $('#modalPush').modal('show');
                $('#name').val(data.name);
                $('#description').val(data.description);
                $('#price').val(data.price);
                $('#my_image').attr('src',data.picture);
                $('#my_image').show()
                $('#picture').val(data.picture);
                $('#button_action').val("Edit");
                $('#action').val("Edit");
                $('#user_id').val(user_id);
            }
        });
    });
    $(document).on('click', '.delete', function () {
        var user_id = $(this).attr("id");
        var action = "Delete";
        $.ajax({
            url: "action.php",
            method: "POST",
            data: {user_id: user_id, action: action},
            success: function (data) {
                alert(data);
                $("#" + user_id).prop('disabled', true);
            }
        });
    });
});
