var colors = ["light", "blue", "black", "orange", "pink", "red"];

$(document).ready(function () {
    if (localStorage.getItem("mode") === "light-theme") {
        var element = document.body;
        element.classList.toggle(localStorage.getItem("mode"));
    }

    if (localStorage.getItem("mode") === "blue-theme") {
        var element = document.body;
        element.classList.toggle(localStorage.getItem("mode"));
    }

    if (localStorage.getItem("mode") === "black-theme") {
        var element = document.body;
        element.classList.toggle(localStorage.getItem("mode"));
    }

    if (localStorage.getItem("mode") === "pink-theme") {
        var element = document.body;
        element.classList.toggle(localStorage.getItem("mode"));
    }

})

$("#light").on("click", function () {
    $.each([colors], function (index, value) {
        if ($("body").hasClass(colors[index] + "-theme") != "light") {
            var couleur = localStorage.getItem("mode");
            $("body").removeClass(couleur);
            $("body").addClass(colors[0] + "-theme");
            localStorage.setItem("mode", "light-theme");
        }

    })
});

$("#blue").on("click", function () {
    $.each([colors], function (index, value) {
        if ($("body").hasClass(colors[index] + "-theme") != "blue") {
            var couleur = localStorage.getItem("mode");
            $("body").removeClass(couleur);
            $("body").addClass(colors[1] + "-theme");
            localStorage.setItem("mode", "blue-theme");
        }

    })
})

$("#black").on("click", function () {
    $.each([colors], function (index, value) {
        if ($("body").hasClass(colors[index] + "-theme") != "black") {
            var couleur = localStorage.getItem("mode");
            $("body").removeClass(couleur);
            $("body").addClass(colors[2] + "-theme");
            localStorage.setItem("mode", "black-theme");
        }

    })
})

$("#pink").on("click", function () {
    $.each([colors], function (index, value) {
        if ($("body").hasClass(colors[index] + "-theme") != "pink") {
            var couleur = localStorage.getItem("mode");
            $("body").removeClass(couleur);
            $("body").addClass(colors[4] + "-theme");
            localStorage.setItem("mode", "pink-theme");
        }

    })
})
