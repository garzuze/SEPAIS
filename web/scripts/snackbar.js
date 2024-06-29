class SnackBar {
    make(type, snack_array, time) {
        var snack_message = snack_array[0];
        var snack_action = snack_array[1];
        var snack_class = "snackbar " + type + " ";
        if (snack_array[2] === "" || snack_array[3] === "") {
            snack_array[2] = "bottom";
            snack_array[3] = "center";
        }

        snack_class += snack_array[2] + " " + snack_array[3];

        var snack_html =
            '<div class="' + snack_class + '">' +
            '<div class="wrap">' +
            '<div class="text">' + snack_message + '</div>' +
            '<button class="close-btn"><i class="material-icons">close</i></button>' +
            (snack_action ? '<button class="action-btn">' + snack_action + '</button>' : '') +
            '</div>' +
            '</div>';
        
        // Remove any existing snackbar before adding a new one
        $(".snackbar").remove();
        
        // Append the snackbar HTML to the body
        $("body").append(snack_html);

        this.open(time);
    }

    open(time) {
        $(".snackbar").addClass("slideUp");
        // Timer
        var timer;
        if (time != null) {
            timer = setTimeout(function() {
                $(".snackbar").addClass("slideDown");
                // Remove the snackbar from the DOM after the animation
                setTimeout(function() {
                    $(".snackbar").remove();
                }, 300); // Adjust to match your CSS animation duration
            }, time);
            // If user cancels
            $(".snackbar .close-btn").click(function() {
                clearTimeout(timer);
                $(".snackbar").addClass("slideDown");
                setTimeout(function() {
                    $(".snackbar").remove();
                }, 300);
            });
        }
    }

    close() {
        $(".snackbar").addClass("slideDown");
        setTimeout(function() {
            $(".snackbar").remove();
        }, 300); // Adjust to match your CSS animation duration
    }

    action(callback) {
        $(".snackbar .action-btn").click(function() {
            callback(true);
        });
        $(".snackbar .close-btn").click(function() {
            callback(false);
        });
    }
}