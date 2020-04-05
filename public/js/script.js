$("body").on('click', '.plus-btn', function (e) {
    let student = $(this).data('student'),
        theme = $(this).data('theme'),
        url = "/lesson/mark";
    fetch(url, {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: "student="+student+"&theme="+theme
    })
        .then(response => response.text())
        .then(result => {
            if ( result.trim() !== "" ) {
                this.outerText = result;
            }
        });
});
let add_input = document.querySelector("#add-input");
if(add_input) {
    add_input.onkeyup = function (e) {
        let empty = this.value.trim() === "";
        document.querySelector("#button-add").disabled = empty;
    };
}
let button_add = document.querySelector("#button-add");
if (button_add) {
    button_add.onclick = function (e) {
        e.preventDefault();
        let theme = document.querySelector("#add-input").value.trim(),
            url = "/lesson/theme";
        document.querySelector("#add-input").value = "";
        fetch(url, {
            method: "POST",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: "theme=" + theme
        })
            .then(response => response.text())
            .then(result => {
                if (result.trim() !== "") {
                    document.querySelector("#main-table").outerHTML = result;
                }
            });
    };
}
let radios = document.querySelectorAll(".group-radio-input");
radios.forEach(function (element) {
    element.onclick = function(){
        let id = "#" + this.dataset.show;
        document.querySelectorAll(".group-input").forEach(function (elem) {
            elem.disabled = true;
            elem.hidden = true;
        });
        document.querySelector(id).disabled = false;
        document.querySelector(id).hidden = false;
    }
});
// let student_input = document.querySelector("#student-input");
// if(student_input) {
//     student_input.onkeyup = function (e) {
//         let empty = this.value.trim() === "",
//             empty2 = document.querySelector("#student-input-nick").value.trim() === "";
//         document.querySelector("#student-button").disabled = empty && empty2;
//     };
// }
let student_button = document.querySelector("#student-button");
if (student_button) {
    student_button.onclick = function (e) {
        e.preventDefault();
        let name = document.querySelector("#student-input").value.trim(),
            nick = document.querySelector("#student-input-nick").value.trim(),
            url = "/add/new";
        document.querySelector("#student-input").value = "";
        document.querySelector("#student-input-nick").value = "";
        fetch(url, {
            method: "POST",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: "name=" + name + "&nick=" + nick
        })
            .then(response => response.text())
            .then(result => {
                if (result.trim() !== "") {
                    let list = document.querySelector(".student-list");
                    list.insertAdjacentHTML('beforeend', result);
                    let no_students = document.querySelector(".no-students");
                    if (no_students) {
                        no_students.outerHTML = "";
                    }
                    location.reload();
                }
            });
    };
}
// let create = document.querySelector('#create-btn');
// if (create) {
//     create.onclick = function (e) {
//         e.preventDefault();
//         let st_radios = document.querySelectorAll('.student-radio'),
//             st_list = [];
//         st_radios.forEach(function (elem) {
//             st_list.push(elem.value);
//         });
//         console.log()
//     }
// }