$(document).ready(function () {
    //add item btn
    $(".add-item-btn").on("click", function (e) {
        e.preventDefault();
        var name = $(this).data("name");
        var id = $(this).data("id");
        
        $(this).removeClass("btn-success").addClass("btn-default disabled");

        var html = `<tr>
                <td>${name}</td>
                <td><input type="number" step="any" min="0" name="items[${id}][quantity]" class="form-control input-sm item-quantity border" value="1"></td>
                <td><button class="btn btn-danger remove-item-btn" data-id="${id}"><i class="fa-solid fa-trash"></i></button></td>
            </tr>`;

        $(".tro-list").append(html);
    });

    //disabled btn
    $("body").on("click", ".disabled", function (e) {
        e.preventDefault();
    }); //end of disabled

    //remove item btn
    $("body").on("click", ".remove-item-btn", function (e) {
        e.preventDefault();
        var id = $(this).data("id");

        $(this).closest("tr").remove();
        $("#item-" + id)
            .removeClass("btn-default disabled")
            .addClass("btn-success");
    }); //end of remove item btn

    //list all tro items
    $(".tro-items").on("click", function (e) {
        e.preventDefault();

        $("#loading").css("display", "flex");

        var url = $(this).data("url");
        var method = $(this).data("method");
        $.ajax({
            url: url,
            method: method,
            success: function (data) {
                $("#loading").css("display", "none");
                $("#tro-item-list").empty();
                $("#tro-item-list").append(data);
            },
        });
    }); //end of tro items click
}); //end of document ready