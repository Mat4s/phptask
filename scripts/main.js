$(document).ready(function () {

    let count = $(".childRowContainer > .childRow").length;

    $(".addChild").click(function () {
        childRowContainer = $(this).parent().prev(".childRowContainer");

        if (count < 3) {
            if (childRowContainer.children(".childRow:last").hasClass("hidden")) {
                childRowContainer.children(".childRow:last, .labelLeft, .labelRight").removeClass("hidden");
                childRowContainer.children(".childRow:last").children("input[type=text], select").prop("disabled", false);
            } else {
                rowClone = childRowContainer.children(".childRow:last").clone(true, true);

                $(rowClone).children("input[type=text]").val("");
                $(rowClone).children("select").find('option').removeAttr("selected");

                $(rowClone).children("input[type=text], select").removeClass('disabledInput');
                $(rowClone).children(".removeChild").removeClass('hidden');
                $(rowClone).children("input.isDisabledForEditing").val(0);

                rowClone.appendTo(childRowContainer);

                clearDiv = $('<div />', {"class": 'float-clear'});
                clearDiv.appendTo(childRowContainer);
                count++;
            }
        }
        return false;
    })


    $(".removeChild").click(function () {
        childRowContainer = $(this).parent().parent(".childRowContainer");

        if (childRowContainer.children('.childRow').size() > 1) {
            $(this).parent().next(".float-clear").remove();
            $(this).parent().remove();
            count--
        } else {
            childRowContainer.children('.childRow, .labelLeft, .labelRight').addClass("hidden");
            childRowContainer.children(".childRow").children("input[type=text], select").prop("disabled", true);
        }

        return false;
    })
});

function showConfirmDialog(module, id, action) {
    var r = confirm("Do you want to do this?");
    if (r === true) {
        window.location.replace("index.php?module=" + module + "&action=" + action + "&id=" + id);
    }
}