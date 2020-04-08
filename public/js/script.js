$('body').on('click', '.plus-btn', function (e) {
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
let button_add2 = document.querySelector("#button-add2");
if (button_add2) {
    button_add2.onclick = function (e) {
        e.preventDefault();
        let name = document.querySelector("#name-input").value.trim(),
            nick = document.querySelector("#nick-input").value.trim(),
            url = "/lesson/user";
        document.querySelector("#name-input").value = "";
        document.querySelector("#nick-input").value = "";
        fetch(url, {
            method: "POST",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: "name=" + name + "&nick=" + nick,
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
$('body').on('click', '#main-table tbody tr .trash-ico', function (e) {
    e.preventDefault();
    let student = this.dataset.student,
        url = "/lesson/delstudent";
    fetch(url, {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: "student=" + student,
    })
        .then(response => response.text())
        .then(result => {
            if (result.trim() !== "") {
                document.querySelector("#main-table").outerHTML = result;
            }
        });
});
$('body').on('click', '#main-table tbody tr .edit-ico', function (e) {
    e.preventDefault();
    let student, url, text, input, parent, old_input;
    student = this.dataset.student;
    url = "/lesson/editstudent";
    text = this.parentElement.childNodes[0].textContent;
    input = '<div class="input-group mb-3" id="new-name-block"><input type="text" value="' + text + '" class="form-control new-name-input" placeholder="Новое значение" aria-label="Новое значение" aria-describedby="confirm-btn"><div class="input-group-append"><button class="btn btn-outline-success" type="button" id="confirm-btn"><svg class="bi bi-check" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3.5-3.5a.5.5 0 11.708-.708L6.5 10.293l6.646-6.647a.5.5 0 01.708 0z" clip-rule="evenodd"></svg></button></div></div>';
    old_input = document.querySelector('#new-name-block');
    if (old_input) {
        return false;
    }
    parent = this.parentElement;
    parent.insertAdjacentHTML('beforeend', input);
    document.querySelector('.new-name-input').focus();
});
$('body').on('blur', '#new-name-block', function () {
    let block = document.getElementById('new-name-block');
    block.remove();
});
$("body").on('click', '.lesson-list .lesson .del-btn', function (e) {
    e.preventDefault();
    let svg = this.firstElementChild,
        lesson = svg.dataset.lesson,
        url = "/main/dellesson",
        parentElement = this.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
    fetch(url, {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: "lesson=" + lesson,
    })
        .then(response => response.text())
        .then(result => {
            parentElement.remove();
        });
});